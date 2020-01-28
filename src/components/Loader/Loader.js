import React, { Component } from 'react';
import Spinner from 'react-bootstrap/Spinner';
import './Loader.css';

class Loader extends Component {
  render() {
    return (
  		<div class="d-flex justify-content-center">
			<Spinner animation="border" role="status">
			  <span className="sr-only">Loading...</span>
			</Spinner>
  		</div>
    );
  }
}

export default Loader;
