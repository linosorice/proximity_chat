const baseURL = 'http://bechat.hubern.com';
const oauthURL = 'https://stagingoauth2.promoincloud.com';

const CLIENT_ID = 'wapi01';
const CLIENT_SECRET = '8k69287ghc734hjnrt7c9j347t8u21j1je4hvc73';

const oauth = (response) => {

  let form = `client_id=${CLIENT_ID}&client_secret=${CLIENT_SECRET}&grant_type=client_credentials`;
  let content = {
    method: 'POST',
    headers: {
      'Content-Type': 'application/x-www-form-urlencoded'
    },
    body: form
  };

  // Request new Token
  if (response.status === 401) {
    return fetch(`${oauthURL}/oauth/access_token`, content)
    .then((response) => response.json())
    .then((responseJson) => {
      localStorage.setItem('access_token', responseJson.access_token);
      throw new Error(response.status);
    });
  }
  else if (response.ok) {
    return response;
  }
  else {
    throw new Error(response.status);
  }
}

const call = (method, params, content, successCallback, errCallback, tries=0) => {

  if (tries === 3) {
    errCallback('Too many follow up!');
    return;
  }

  content.headers['Authorization'] = localStorage.getItem('access_token');

  fetch(method(params), content)
    .then(oauth)
    .then((response) => response.json())
    .then((responseJson) => {
      successCallback(responseJson);
    })
    .catch((error) => {

      if (error.message === '401') {
        call(method, params, content, successCallback, errCallback, tries+1);
      }
      else {
        errCallback(error);
      }
    });
}

module.exports = {

  // Call
  get: (method, params, successCallback, errCallback) => {

    let content = {
      method: 'GET',
      headers: {
        'Content-Type': 'application/json',
        'Authorization': localStorage.getItem('access_token')
      }
    };

    call(method, params, content, successCallback, errCallback);
  },

  post: (method, params, successCallback, errCallback) => {

    let content = {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Authorization': localStorage.getItem('access_token')
      },
      body: JSON.stringify(params)
    };

    call(method, params, content, successCallback, errCallback);
  },

  uploadFile: (method, params, successCallback, errCallback) => {

    let data = new FormData();
    for (let key in params) {
      data.append(key, params[key]);
    }

    let content = {
      method: 'POST',
      headers: {
        'Authorization': localStorage.getItem('access_token')
      },
      body: data
    };

    call(method, params, content, successCallback, errCallback);
  },

  methods: {

    // GET
    userData: (params) => {
      return `${baseURL}/api/${params.lang}/user/id/${params.userID}`;
    },

    // POST
    login: () => {
      return `${baseURL}/api/v1/module/login`;
    },

    nickname: () => {
      return `${baseURL}/api/v1/module/nickname`;
    },

    avatar: () => {
      return `${baseURL}/api/v1/module/avatar`;
    },

    privateroom: () => {
      return `${baseURL}/api/v1/module/privateroom`;
    }
  }
}
