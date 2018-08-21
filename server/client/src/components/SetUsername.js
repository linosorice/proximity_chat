import React, { Component } from 'react';
import { Alert, Button, Modal, ModalHeader, ModalBody, ModalFooter, InputGroup, Input } from 'reactstrap';
import './ChatBox.css';
import Api from '../Api.js';

export default class SetUsername extends Component {
  constructor(props) {
    super(props);

    this.state = {
      nickname: "",
      loading: false,
      errorConflict: false
    }
  }

  handleChange = (e) => {
    this.setState({
      nickname: e.target.value
    });
  }

  sendNickname = () => {

    let params = {
      nickname: this.state.nickname,
      email: this.props.email
    }

    this.setState({ loading: true });

    Api.post(
      Api.methods.nickname,
      params,
      (responseJson) => {
        console.log(responseJson);
        this.props.setUsername(responseJson.data.nickname);
        //socket.emit('user join', { username: email });

      },
      (error) => {
        this.setState({
          loading: false,
          showWrongCredentials: true
        });

        if (error.message === "409") {
          this.setState({ errorConflict: true });
        }

        //this.changePage('error', { errorCode: '', errorText: strings.error }, false);
      });
  }

  render() {

    let alert =
      <Alert color="danger">
        <strong>Ops!</strong> Il nickname è già stato scelto
      </Alert>


    return (
      <Modal isOpen={this.props.open}>
        <ModalHeader toggle={this.props.toggle}>Inserisci il tuo Nickname</ModalHeader>
        <ModalBody>
          <InputGroup>
            <Input value={this.state.nickname} onChange={this.handleChange}/>
          </InputGroup>
          {this.state.errorConflict ? alert : null}
        </ModalBody>
        <ModalFooter>
          <Button color="primary" onClick={this.sendNickname}>Invia</Button>
        </ModalFooter>
      </Modal>
    );
  }
}
