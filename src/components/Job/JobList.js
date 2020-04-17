import React, { Component } from 'reactn';
import { Container, Row, Col } from 'react-bootstrap';

import JobListRow from './JobListRow';
import Loader from './../Loader/Loader';
import Paginator from './../Paginator/Paginator';

class JobList extends Component {
  constructor(props) {
    super(props);

    this.state = {
      error: null,
      isLoaded: false,
      jobs: null,
      totalJobs: -1
    };

    const { page } = this.props.match.params;

    this.pageLimit = 10;
    this.pageNum = page ? page : 1;
  }

  async componentDidMount() {
    const { pageNum } = this.props.match.params;

    let offset = (this.pageNum - 1) * this.pageLimit;

    let result = await this.global.apiUtils.get(
      `/jobs?isFavourited=false&limit=${this.pageLimit}&offset=${offset}&order[date]=desc`,
      true
    );

    let total = -1;

    if (result.headers['x-total-count']) {
      total = result.headers['x-total-count'];
    }

    this.setState({
      isLoaded: true,
      jobs: result.data,
      totalJobs: total
    });
  }

  getJobRows(jobs) {
    let rows = [];

    for (let key in jobs) {
      console.log('job KEY', key);
      rows.push(<JobListRow key={ key } job={ jobs[key] } />);
    }
    return rows;
  }

  render() {
    const { error, isLoaded, jobs, totalJobs } = this.state;

    let content = [];

    if (isLoaded) {
      content = this.getJobRows(jobs);

      let totalPages = Math.ceil(totalJobs / this.pageLimit)

      content.push(
        <Paginator
          key={ jobs.length + 1 }
          total={totalPages}
          active={this.pageNum}
          url="/jobs"
        />
      );
    } else {
      content.push(<Loader key="0" />);
    }

    return (
      <div id="job-view">
        <h1>Job Vacancies</h1>
        { content }
      </div>
    );
  }
}

export default JobList;
