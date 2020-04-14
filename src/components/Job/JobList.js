import React, { Component } from 'reactn';

import Container from 'react-bootstrap/Container';
import Row from 'react-bootstrap/Row';
import Col from 'react-bootstrap/Col';

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
      `/jobs?limit=${this.pageLimit}&offset=${offset}&order[date]=desc`,
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

    for (let job of jobs) {
      rows.push(<JobListRow job={ job } />);
    }
    return rows;
  }

  render() {
    const { error, isLoaded, jobs, totalJobs } = this.state;

    let content = [];

    if (isLoaded) {
      content = this.getJobRows(jobs);

      let totalPages = totalJobs / this.pageLimit;

      content.push(<Paginator total={totalPages} active={this.pageNum} url="/jobs" />);
    } else {
      content.push(<Loader />);
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
