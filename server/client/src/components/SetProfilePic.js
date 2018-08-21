import React, { Component } from 'react';
import { Alert, Button, Modal, ModalHeader, ModalBody, ModalFooter } from 'reactstrap';
import Api from '../Api.js';
import './SetProfilePic.css';
import loading from '../loading.svg';

const MAX_SIZE = 2048;

export default class SetProfilePic extends Component {
  constructor(props) {
    super(props);

    this.state = {
      inputValue: '',
      file: '',
      imagePreviewUrl: null,
      loading: false,
      showNetworkError: false,
      showSizeError: false,
      showFileError: false
    }
  }

  handleImageChange = (e) => {

    let reader = new FileReader();
    let file = e.target.files[0];

    reader.onloadend = () => {

      // Check if it is an image
      if (file.name.match(/\.(jpg|jpeg|png|gif)$/)) {

        // Check image size
        let img = new Image();
        img.wrapper = this;
        img.onload = function () {

            if (this.width <= MAX_SIZE && this.width <= MAX_SIZE) {

              img.wrapper.setState({
                file: file,
                imagePreviewUrl: reader.result
              });
            }
            else {
              img.wrapper.setState({
                showSizeError: true
              })
            }
        };

        img.src = reader.result;
      }
      else {
        this.setState({
          showFileError: true
        })
      }
    }

    reader.readAsDataURL(file)
  }

  handleCancel = (e) => {

    e.preventDefault();
    this.setState({
      inputValue: '',
      file: '',
      imagePreviewUrl: null
    });
  }

  handleSubmit = (e) => {

    e.preventDefault();
    this.setState({ loading: true });

    let params = {
      avatar: this.state.file,
      email: this.props.email
    };

    Api.uploadFile(
      Api.methods.avatar,
      params,
      (responseJson) => {console.log(responseJson);

        this.props.setImage(responseJson.data.url);
        this.setState({
          loading: false,
          showUploadSuccessful: true,
          imagePreviewUrl: responseJson.data.url
        });
      },
      (error) => {console.log(error);
        this.setState({
          loading: false,
          showNetworkError: true
        });
      });
  }

  render() {

    let alertNetwork =
      <Alert color="danger mt-3">
        <strong>Ops!</strong> Qualcosa è andato storto
      </Alert>

    let alertFile =
      <Alert color="danger mt-3">
        <strong>Ops!</strong> Formato immagine non valido
      </Alert>

    let alertSize =
      <Alert color="danger mt-3">
        <strong>Ops!</strong> Dimensione massima {MAX_SIZE} x {MAX_SIZE}
      </Alert>

    let alertSuccess =
      <Alert color="success mt-3">
        <strong>Yes!</strong> Immagine caricata correttamente
      </Alert>

    let image;
    if (this.state.imagePreviewUrl) {
      image = <img src={this.state.imagePreviewUrl} className="rounded-circle set-image mb-3" alt=""/>
    }

    // Send button
    let sendButton = this.state.imagePreviewUrl ? <Button color="primary" onClick={(e) => this.handleSubmit(e)}>Invia</Button> : null

    if (this.state.loading) {
      sendButton = <img src={loading} id="set-image-loading" alt="loading"/>
    }

    return (
      <Modal isOpen={this.props.open} toggle={this.props.toggle}>
        <ModalHeader toggle={this.props.toggle}>Cambia Immagine</ModalHeader>
        <ModalBody>

          <div id="set-image-container">
            {image}
          </div>

          <label id="upload-btn" htmlFor="upload" className="btn btn-primary">Carica</label>
          <input id="upload" className="hidden-xs-up" type="file" accept="image/*" value={this.state.inputValue} onChange={(e) => this.handleImageChange(e)}/>
          {this.state.showNetworkError ? alertNetwork : null}
          {this.state.showFileError ? alertFile : null}
          {this.state.showSizeError ? alertSize : null}
          {this.state.showUploadSuccessful ? alertSuccess : null}
        </ModalBody>
        <ModalFooter>
          {sendButton}
        </ModalFooter>
      </Modal>
    );
  }
}
