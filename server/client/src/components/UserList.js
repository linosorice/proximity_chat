import React, { Component } from 'react';
import './UserList.css';

export default class UserList extends Component {

  onClickItem = (username) => {
    this.props.changePage('private', {username: username});
  }

  render() {

    let users = [];
    let key = 0;
    for (let i in this.props.users) {

      if (i === this.props.username) {
        continue;
      }

      let user = this.props.users[i];

      users.push(
        <div className="user-item mt-3" key={key++}>
          <img className="rounded-circle user-item-img" src={user.image} alt="avatar" onClick={() => this.onClickItem(i)}/>
          <div className="user-item-info">
            <h5 className="ml-2 mb-0">{i}</h5>
            <p className={"ml-2 user-" + (user.online ? "online" : "offline")}>{user.online ? "online" : "offline"}</p>
          </div>
        </div>
      );
    }

    return (
      <div className="pl-5 pr-5 pt-3">
        <div className="row">
          <div className="user-item mt-3">
            <img className="user-item-img" src="https://integnology.force.com/resource/1482192830000/OnlineChatbutton" alt="avatar" onClick={() => this.props.changePage('chat')}/>
            <div className="user-item-info">
              <h5 className="ml-2 mb-0">Chat Pubblica</h5>
              <p className="ml-2 user-online">entra!</p>
            </div>
          </div>
          {users}
        </div>
      </div>
    );
  }
}
