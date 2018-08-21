var app = require('express')();
var http = require('http').Server(app);
var io = require('socket.io')(http);
var port = 3001;

var mongoose = require('mongoose');
mongoose.connect('mongodb://127.0.0.1:27017/test');

//app.use(cors());

var clients = {};
var users = {};

// Chat schema
var chatSchema = mongoose.Schema({
  created: Date,
  content: String,
  username: String,
  image: String,
  room: String
});

//Create a model from the chat schema
var Chat = mongoose.model('Chat', chatSchema);

//Allow CORS
/*app.all('/*', function(req, res, next) {
  res.header("Access-Control-Allow-Origin", "localhost:3001");
  res.header('Access-Control-Allow-Methods', 'GET,PUT,POST,DELETE,OPTIONS');
  res.header('Access-Control-Allow-Headers', 'Content-type,Accept,X-Access-Token,X-Key');
  if (req.method == 'OPTIONS') {
    res.status(200).end();
  } else {
    next();
  }
});*/

app.get('/', function(req, res) {
  res.sendFile(__dirname + '/index.html');
});

app.get('/refresh', function(req, res) {
  console.log('refresh');
  Chat.remove({}, function() {
    res.send('chat deleted');
  });
});

io.on('connection', function(socket) {
  console.log("connection");

  socket.on('disconnect', function() {

    console.log('disconnected', clients[socket.id]);

    if (clients[socket.id]) {
      io.in(clients[socket.id].room).emit('user disconnected', clients[socket.id]);
      delete users[clients[socket.id]];
      delete clients[socket.id];
    }

  });

  socket.on('user join', function(data) {
    console.log(data);
    if (!data || !data.username) {
      return;
    }

    /*if (users[data.username]) {
      socket.emit('user exists', null);
    } else {*/

      // Store new user
      users[data.username] = socket.id;
      clients[socket.id] = data;

      // Join room
      socket.join(data.room);
      sendOldMessages(socket, data.room);
      io.in(data.room).emit('user join', data);

      // Send current users
      sendUserList(socket, data.room);
    //}
  });

  socket.on('user join private', function(data) {
    console.log(data);
    if (!data || !data.username) {
      return;
    }

    // Join room
    socket.join(data.room);
    sendOldMessages(socket, data.room);
  });

  socket.on('chat message', function(msg) {
    console.log('new message', msg);
    var newMsg = new Chat({
      username: msg.username,
      content: msg.message,
      room: msg.room,
      image: msg.image,
      created: new Date()
    });

    newMsg.save(function(err, msg){
      io.in(msg.room).emit('chat message', msg);
    });

  });

  socket.on('old messages', function(data) {
    sendOldMessages(socket, data.room);
  });
});

function sendOldMessages(socket, room) {
  Chat.find({
    'room': room
  }).sort('-date').limit(50).exec(function(err, msgs) {
    socket.emit('old messages', msgs);
  });
}

function sendUserList(socket, room) {
  let res = {};
  for (var i in clients) {
    if (clients[i].room === room) {
      res[clients[i].username] = clients[i];
    }
  }
  console.log("test");
  console.log(res);
  socket.emit('user list', res);
}

http.listen(port, function() {
  console.log('listening on *:' + port);
});
