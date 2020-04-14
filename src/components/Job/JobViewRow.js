import React, { Component } from 'react';
import Row from 'react-bootstrap/Row';
import Col from 'react-bootstrap/Col';

class JobViewRow extends Component {
  isValidUrl(string) {
    try {
      new URL(string);
      return true;
    } catch (_) {
      return false;  
    }
  }

  render() {
    return (
	    <Row className="job-view-row">
	      <Col xs lg="2" className="font-weight-bold">{ this.props.label }</Col>
	      <Col xs lg="10">
          {
            this.isValidUrl(this.props.value) ? (
              <a
                href={ this.props.value }
                target="_blank"
                rel="noopener noreferrer">{ this.props.value }</a>
            ) : (
              this.props.value
            )
          }
        </Col>
	    </Row>
    );
  }
}

export default JobViewRow;
