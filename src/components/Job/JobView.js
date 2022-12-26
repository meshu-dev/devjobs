import React, { Component } from 'reactn';
import { Link } from 'react-router-dom';
import { Row, Col, Button } from 'react-bootstrap';
import './JobView.css';

import JobViewRow from './JobViewRow';
import JobViewHtmlRow from './JobViewHtmlRow';
import Loader from './../Loader/Loader';

// TODO - is useGlobal required?
//import { useGlobal } from 'reactn';

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

  getDate(date) {
    date = new Date(date);
    return `${date.getDate()}/${date.getMonth()}/${date.getFullYear()}`;
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
      const jobParams = job.params;
      let date = this.getDate(job.date);

      let favouriteBtnText = 'Favourite'

      if (job.isFavourited === true) {
        favouriteBtnText = 'Unfavourite'
      }

      return (
        <div>
          <Row id="job-view-header">
            <Col>
              <h1>{ jobParams.jobTitle }</h1>
            </Col>
            <Col>
              <Link to="/">
                <Button>Back</Button>
              </Link>
              <Button onClick={ this.setFavouriteStatus.bind(this) }>
                  { favouriteBtnText }
              </Button>
            </Col>
          </Row>
          <Row>
            <Col>
              <div id="job-view">
                <JobViewRow label="Date Posted:" value={ date } />
                <JobViewRow label="Employer:" value={ jobParams.employerName } />
                <JobViewRow label="Location:" value={ jobParams.locationName } />
                <JobViewRow label="Job Link:" value={ jobParams.jobUrl } />
                <JobViewHtmlRow label="Description:" value={ jobParams.jobDescription } />
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
