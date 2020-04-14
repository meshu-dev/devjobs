import React, { Component } from 'reactn';
import './JobView.css';

import JobViewRow from './JobViewRow';
import JobViewHtmlRow from './JobViewHtmlRow';
import Loader from './../Loader/Loader';

import Container from 'react-bootstrap/Container';
import Row from 'react-bootstrap/Row';
import Col from 'react-bootstrap/Col';
import Button from 'react-bootstrap/Button';

import { useGlobal } from 'reactn';

class JobView extends Component {
  constructor(props) {
    super(props);

    this.state = {
      error: null,
      isLoaded: false,
      job: null
    };
  }

  async componentDidMount() {
    const { id } = this.props.match.params;

    let result = await this.global.apiUtils.request(
      `/jobs/${id}`
    );

    this.setState({
      isLoaded: true,
      job: result
    });
  }

  getDate(timestamp) {
    let t = parseInt(timestamp);
    let d = new Date(t);

    console.log(d);

    let timeStampCon = d.getDate() + '/' + (d.getMonth()) + '/' + d.getFullYear();

    return timeStampCon;
  }

  render() {
    const { error, isLoaded, job } = this.state;

    if (isLoaded) {
      if (error) {
        return <div>Error: { error.message }</div>;
      }
      let date = this.getDate(job.date.$date.$numberLong);

      return (
        <div>
          <Row id="job-view-header">
            <Col>
              <h1>{ job.jobTitle }</h1>
            </Col>
            <Col>
              <Button href="/">Back</Button>
            </Col>
          </Row>
          <Row>
            <Col>
              <div id="job-view">
                <JobViewRow label="Date Posted:" value={ date } />
                <JobViewRow label="Employer:" value={ job.employerName } />
                <JobViewRow label="Location:" value={ job.locationName } />
                <JobViewRow label="Job Link:" value={ job.jobUrl } />
                <JobViewHtmlRow label="Description:" value={ job.jobDescription } />
              </div>
            </Col>
          </Row>
        </div>
      );
    } else {
      return <Loader />;
    }
  }
}

export default JobView;
