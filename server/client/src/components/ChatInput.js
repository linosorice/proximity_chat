import React, { Component } from 'react';
import './ChatInput.css';

export default class ChatInput extends Component {

  componentWillMount = () => {
    document.addEventListener('keyup', this.handleKeyPress, false);
  }

  handleKeyPress = (e) => {
    if (e.key === 'Enter' && this.props.active) {
      this.props.sendMessage();
    }
  }

  render() {
    return (
      <div className="bottom_wrapper clearfix">
        <div className="message_input_wrapper">
          <input placeholder="Scrivi un messaggio..."
                 className="message_input"
                 value={this.props.text}
                 onChange={(e) => this.props.updateText(e)}/>
        </div>
        <div className="send_message" onClick={() => this.props.sendMessage()}>
          <div id="send-icon" className="fa fa-paper-plane"/>
        </div>
      </div>
    );
  }
}
