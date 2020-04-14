import React, { Component } from 'react';
import Row from 'react-bootstrap/Row';
import Col from 'react-bootstrap/Col';

class JobViewHtmlRow extends Component {
  render() {
    return (
	    <Row className="job-view-row">
	      <Col xs lg="2" className="font-weight-bold">{ this.props.label }</Col>
	      <Col xs lg="10">
          <div dangerouslySetInnerHTML={{ __html: this.props.value }} />
        </Col>
	    </Row>
    );
  }
}

export default JobViewHtmlRow;
