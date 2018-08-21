import React, { Component } from 'react';
import { Navbar, NavbarBrand } from 'reactstrap';
import SetProfilePic from './SetProfilePic.js';
import './ChatHeader.css';

export default class ChatHeader extends Component {
  constructor(props) {
    super(props);

    this.toggle = this.toggle.bind(this);
    this.state = {
      isOpen: false,
      setProfilePic: false
    };
  }

  toggle() {
    this.setState({
      isOpen: !this.state.isOpen
    });
  }

  onClickIcon = () => {

    window.history.back();
    /*switch (this.props.currentPage) {
      case 'chat':
        window.history.back();
        break;

      case 'private':
        this.props.closePrivateChat();
        break;
    }*/
  }

  toggleSetProfilePic = () => {
    this.setState({
      setProfilePic: !this.state.setProfilePic
    })
  }

  render() {

    let iconClass = this.props.currentPage === 'chat' || this.props.currentPage === 'private' ? 'fa fa-chevron-left' : null;

    let avatar = <img className="rounded-circle header-avatar mr-3" src={this.props.image} alt="avatar" onClick={() => this.toggleSetProfilePic()}/>

    return (
      <div id="chat-header">
        <SetProfilePic open={this.state.setProfilePic} toggle={this.toggleSetProfilePic} email={this.props.email} setImage={this.props.setImage}/>
        <Navbar light toggleable>
          <NavbarBrand><i id="chat-header-btn" className={iconClass} onClick={() => this.onClickIcon()}/>{this.props.speaker ? '    Chatting with ' + this.props.speaker : '    ProxyChat'}</NavbarBrand>
          <div className="header-username-container mr-3">
            {avatar}
            {this.props.username}
          </div>
        </Navbar>
      </div>
    );
  }
}
