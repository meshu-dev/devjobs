import React, { Component } from 'reactn';
import { Row, Col, Button, Form } from 'react-bootstrap';
import './JobView.css';

import Loader from './../Loader/Loader';

// TODO - is useGlobal required?
//import { useGlobal } from 'reactn';

class JobSearch extends Component {
  constructor(props) {
    super(props)

    this.state = {
      error: null,
      isLoaded: false,
      jobSite: null
    }
  }

  async componentDidMount() {
    const result = await this.global.apiUtils.get(
      `/job-sites?name=Reed`
    )
    const jobSite = result[0]

    const jobSearches = JSON.stringify(
      jobSite.searchParams,
      null,
      4
    )

    this.setState({
      isLoaded: true,
      jobSite: jobSite,
      jobSearches: jobSearches
    });
  }

  onFieldChange(event) {
    this.setState({
      [event.target.name]: event.target.value
    });
  }

  async setJobSearches() {
    const jobSearches = JSON.parse(this.state.jobSearches)

    const result = await this.global.apiUtils.put(
      `/job-sites/${this.state.jobSite.id}`,
      {
        searchParams: jobSearches
      }
    )

    if (result) {
      this.state.jobSite.searchParams = jobSearches

      this.setState({
        jobSite: this.state.jobSite
      });
    }
  }

  render() {
    const { error, isLoaded } = this.state;

    if (isLoaded) {
      if (error) {
        return <div>Error: { error.message }</div>
      }

      return (
        <div>
          <Row id="job-view-header">
            <Col>
              <h1>{ this.state.jobSite.name }</h1>
            </Col>
            <Col>
              <Button onClick={ this.setJobSearches.bind(this) }>
                  Save
              </Button>
            </Col>
          </Row>
          <Row>
            <Col>
              <Form>
                <Form.Group controlId="exampleForm.ControlTextarea1">
                  <Form.Label>Job Search Params</Form.Label>
                  <Form.Control
                    as="textarea"
                    rows="20"
                    name="jobSearches"
                    value={ this.state.jobSearches }
                    onChange={ this.onFieldChange.bind(this) }
                  />
                </Form.Group>
              </Form>
            </Col>
          </Row>
        </div>
      )
    } else {
      return <Loader />
    }
  }
}

export default JobSearch;
