import React, { Component } from 'react';
import io from 'socket.io-client';
import ChatBox from './components/ChatBox.js';
import ChatInput from './components/ChatInput.js';
import ChatMessage from './components/ChatMessage.js';
import SetUsername from './components/SetUsername.js';
import Loading from './components/Loading.js';
import ChatHeader from './components/ChatHeader.js';
import UserList from './components/UserList.js';
import Api from './Api.js';
import './App.css';

let socket = null;
let appcode = null;
let email = null;

let colors = [];

class App extends Component {
  constructor(props) {
    super(props);

    this.state = {
      page: 'users',
      pageParams: null,
      messages: [],
      text: "",
      username: null,
      image: null,
      room: null,
      publicRoom: null,
      users: {},
      askUsername: false,
      loading: false
    }
  }

  componentDidMount = () => {

    // Init some colors
    while (colors.length < 100) {
      do {
          var color = Math.floor((Math.random()*1000000)+1);
      } while (colors.indexOf(color) >= 0);
      colors.push("#" + ("000000" + color.toString(16)).slice(-6));
    }

    // Get appcode and email from GET params
    appcode = this.getParameterByName('app_code');
    email = this.getParameterByName('email');

    // Contact BE for user info and room
    this.setState({ loading: true });
    this.login();

    // History
    window.onpopstate = (e) => {
      console.log(e.state);
      if (e.state === null) {
        this.changePage('users', null, false);
      }
      else {
        this.changePage(e.state.page, e.state.params, false);
      }
    };
  }

  changePage = (page, params, pushToHistory = true) => {

    if (pushToHistory) {
      window.history.pushState({ page: page, params: params }, null);
    }

    if (this.state.page === 'private') {
      this.closePrivateChat();
    }

    if (page === 'private') {
      this.joinPrivateChat(params.username);
    }

    /*if (page === 'private') {
      this.joinPrivateChat(params.username);
    } else {
      this.setState({
        page: page,
        pageParams: params
      });
    }*/

    this.setState({
      page: page,
      pageParams: params
    });
  }

  login = () => {

    let params = {
      app_code: appcode,
      email: email
    }

    Api.post(
      Api.methods.login,
      params,
      (responseJson) => {
        console.log(responseJson);

        this.setState({ loading: false });
        if (!responseJson.data.nickname) {
          this.setState({
            image: responseJson.data.avatar,
            publicRoom: responseJson.data.room_id,
            room: responseJson.data.room_id
          });
          this.toggleAskUsername();
        } else {
          this.setState({
            username: responseJson.data.nickname,
            image: responseJson.data.avatar,
            publicRoom: responseJson.data.room_id,
            room: responseJson.data.room_id
          });
          this.connectToChatServer();
        }

      },
      (error) => {
        this.setState({
          loading: false,
          showWrongCredentials: true
        });
      });
  }

  connectToChatServer = () => {
    socket = io('http://schat.hubern.com/', { transports: ['websocket'] });
    socket.emit('user join', { username: this.state.username, image: this.state.image, room: this.state.room });

    socket.on('user join', (data) => {
      let users = this.state.users;
      users[data.username] = {image: data.image, online: true};
      this.setState({users: users});
    });

    socket.on('user disconnected', (data) => {
      let users = this.state.users;
      users[data.username].online = false;
      this.setState({users: users});
    });

    socket.on('user list', (data) => {
      for (let i in data) {
        data[i].online = true;
      }
      console.log(data);
      this.setState({users: data});
    });

    socket.on('chat message', (msg) => {
      console.log(msg.room != this.state.room);
      if (msg.room != this.state.room) {
        return;
      }

      let messages = this.state.messages;
      messages.push(<ChatMessage key={messages.length}
                                 direction={msg.username === this.state.username ? "right" : "left"}
                                 text={msg.content}
                                 username={msg.username}
                                 userColor={this.getColorFromUsername(msg.username)}
                                 image={msg.image}
                                 created={msg.created}
                                 changePage={this.changePage}/>
                               );
      this.setState({
        messages: messages
      });
    });

    socket.on('old messages', (msgs) => {
      let messages = this.state.messages;
      messages = [];
      for (let i in msgs) {
        messages.push(<ChatMessage key={messages.length}
                                   direction={msgs[i].username === this.state.username ? "right" : "left"}
                                   text={msgs[i].content}
                                   username={msgs[i].username}
                                   userColor={this.getColorFromUsername(msgs[i].username)}
                                   image={msgs[i].image}
                                   created={msgs[i].created}
                                   changePage={this.changePage}/>
                                  );
      }

      this.setState({
        messages: messages
      });
    });

    socket.on('user exists', () => {
      console.log('user exists');
    });

  }

  joinPrivateChat = (username) => {

    if (this.state.page !== 'private' && username !== this.state.username) {

      // Get private room id
      let params = {
        nickname_1: this.state.username,
        nickname_2: username
      }

      this.setState({loading: true, messages: []});

      Api.post(
        Api.methods.privateroom,
        params,
        (responseJson) => {
          console.log(responseJson);

          this.setState({room: responseJson.data.room_id, loading: false});
          socket.emit('user join private', {username: this.state.username, image: this.state.image, room: responseJson.data.room_id});
          socket.emit('old messages', {room: responseJson.data.room_id});

        },
        (error) => {
          this.setState({
            loading: false,
            showWrongCredentials: true
          });
        });
    }

  }

  closePrivateChat = () => {
    console.log("CLOOSE");
    this.setState({room: this.state.publicRoom});
    //socket.emit('user join', {username: this.state.username, image: this.state.image, room: this.state.publicRoom});
    socket.emit('old messages', {room: this.state.publicRoom});

  }

  toggleAskUsername = () => {

    if (this.state.askUsername && !this.state.username) {
      return;
    }

    this.setState({
      askUsername: !this.state.askUsername
    })
  }

  setUsername = (nickname) => {
    this.setState({
      username: nickname,
      askUsername: false
    });

    this.connectToChatServer();
  }

  setImage = (image) => {
    this.setState({
      image: image
    });
  }

  getParameterByName = (name, url) => {
    if (!url) url = window.location.href;
    name = name.replace(/[\[\]]/g, "\\$&");
    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, " "));
  }

  updateText = (event) => {
    this.setState({text: event.target.value});
  }

  sendMessage = () => {

    if (!this.state.text || this.state.text.length === 0) {
      return;
    }

    let data = {
      username: this.state.username,
      message: this.state.text,
      image: this.state.image,
      room: this.state.room
    }

    socket.emit('chat message', data);

    this.setState({
      text: ''
    });
  }

  getColorFromUsername = (username) => {
    let index = 0;
    for (let i = 0; i < username.length; i ++) {
      index += username[i].charCodeAt(0);
    }

    return colors[index % colors.length];
  }

  render() {
    let content;
    let speaker = this.state.page === 'private' ? this.state.pageParams.username : null;

    switch (this.state.page) {
      case 'chat':
      case 'private':
        content =
          <div>
            <ChatBox messages={this.state.messages}/>
            <ChatInput active={!this.state.askUsername} text={this.state.text} updateText={this.updateText} sendMessage={this.sendMessage}/>
          </div>
        break;

      case 'users':
        content = <UserList username={this.state.username} users={this.state.users} changePage={this.changePage}/>
        break;
    }
    return (
      <div>
        <ChatHeader username={this.state.username} image={this.state.image} speaker={speaker} currentPage={this.state.page} changePage={this.changePage} closePrivateChat={this.closePrivateChat} email={email} setImage={this.setImage}/>
        {this.state.loading ? <Loading/> : null}
        <SetUsername email={email} open={this.state.askUsername} toggle={this.toggleAskUsername} setUsername={this.setUsername}/>
        {content}
      </div>
    );
  }
}

export default App;
