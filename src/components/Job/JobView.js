import React, { Component } from 'reactn';
import { Container, Row, Col, Button } from 'react-bootstrap';
import './JobView.css';

import JobViewRow from './JobViewRow';
import JobViewHtmlRow from './JobViewHtmlRow';
import Loader from './../Loader/Loader';

import { useGlobal } from 'reactn';

import APIUtils from './../../common/APIUtils';

class JobView extends Component {
  constructor(props) {
    super(props)

    this.state = {
      error: null,
      isLoaded: false,
      job: null
    }
  }

  async componentDidMount() {
    const { id } = this.props.match.params;

    let result = await this.global.apiUtils.request(
      `/jobs/${id}`
    );

    this.setState({
      isLoaded: true,
      job: result,
      api: this.global.apiUtils
    });
  }

  getDate(timestamp) {
    timestamp = parseInt(timestamp)
    const date = new Date(timestamp)

    return `${date.getDate()}/${date.getMonth()}/${date.getFullYear()}`
  }

  async setFavouriteStatus() {
    const isFavourited = this.state.job.isFavourited ? false : true;
    const result = await this.global.apiUtils.put(
      `/jobs/${this.state.job.id}`,
      {
        isFavourited: isFavourited
      }
    )

    if (result) {
      this.state.job.isFavourited = isFavourited

      this.setState({
        job: this.state.job
      })
    }
    console.log('result', result);
  }

  render() {
    const { error, isLoaded, job } = this.state;

    if (isLoaded) {
      if (error) {
        return <div>Error: { error.message }</div>
      }
      let date = this.getDate(job.date.$date.$numberLong);

      let favouriteBtnText = 'Favourite'

      if (job.isFavourited === true) {
        favouriteBtnText = 'Unfavourite'
      }
      const favouriteBtn = <Button
        onClick={ this.setFavouriteStatus }>
          { favouriteBtnText }
        </Button>

      return (
        <div>
          <Row id="job-view-header">
            <Col>
              <h1>{ job.jobTitle }</h1>
            </Col>
            <Col>
              <Button href="/">Back</Button>
              <Button onClick={ this.setFavouriteStatus.bind(this) }>
                  { favouriteBtnText }
              </Button>
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
      )
    } else {
      return <Loader />
    }
  }
}

export default JobView;
