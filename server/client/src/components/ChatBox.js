import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import './ChatBox.css';

export default class ChatBox extends Component {

  componentDidUpdate = () => {
    const node = ReactDOM.findDOMNode(this.messages);
    node.scrollTop = node.scrollHeight;
  }

  render() {
    return (
      <div>
        <ul className="messages" ref={(el) => { this.messages = el; }}>
          {this.props.messages}
        </ul>
      </div>
    );
  }
}
