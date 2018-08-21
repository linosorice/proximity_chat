import React, { Component } from 'react';
import './ChatBox.css';

export default class ChatMessage extends Component {

  onClickAvatar = (username) => {
    this.props.changePage('private', {username: username});
  }

  render() {
    let timestamp = this.props.created;
    //let date = timestamp.split('T')[0];
    let date = new Date(this.props.created);
    let msgDate = this.getDate(date);
    let time = date.getHours() + ':' + date.getMinutes();

    return (
      <li className={"message appeared " + this.props.direction}>
        <img className="rounded-circle avatar" src={this.props.image} alt="avatar"/>
        <div className="text_wrapper">
          <div className="username" style={{ "color": this.props.userColor}}>{this.props.username}</div>
          <div className="text wrap-text">{this.props.text}</div>
          <div className="timestamp">{time}</div>
        </div>
      </li>
    );
  }

  getDate = (date) => {
    let today = new Date();
    if (today.getMonth() === date.getMonth && today.getYear() === date.getYear()) {
      if (today.getDay() === date.getDay()) {
        return 'today';
      }
    }

    return date.getDay() + '/' + date.getMonth();
  }
}
