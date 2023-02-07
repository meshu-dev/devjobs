import React, { Component } from 'reactn';

import JobListRow from './JobListRow';
import Loader from './../Loader/Loader';
import Paginator from './../Paginator/Paginator';

class JobFavouriteList extends Component {
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
    // TODO - Should pageNum be used?
    //const { pageNum } = this.props.match.params;

    let offset = (this.pageNum - 1) * this.pageLimit;

    let result = await this.global.apiUtils.get(
      `/jobs?isFavourited=true&limit=${this.pageLimit}&skip=${offset}&sort=desc`,
      true
    );

    this.setState({
      isLoaded: true,
      jobs: result.data.data,
      totalJobs: result.data.total
    });
  }

  getJobRows(jobs) {
    let rows = [];

    for (let key in jobs) {
      rows.push(<JobListRow key={ key } job={ jobs[key] } />);
    }
    return rows;
  }

  render() {
    // TODO - Not sure if error will 
    //const { error, isLoaded, jobs, totalJobs } = this.state;
    const { isLoaded, jobs, totalJobs } = this.state;

    let content = [];

    if (isLoaded) {
      content = this.getJobRows(jobs);

      if (content.length > 0) {
        let totalPages = totalJobs / this.pageLimit;

        if (totalPages > 1) {
          content.push(
            <Paginator
              key={ jobs.length + 1 }
              total={totalPages}
              active={this.pageNum}
              url="/favourites"
            />
          );
        }
      } else {
        content.push(<div key="0">No favourites added</div>);
      }
    } else {
      content.push(<Loader key="0" />);
    }

    return (
      <div id="job-view">
        <h1>Favourited Vacancies</h1>
        { content }
      </div>
    );
  }
}

export default JobFavouriteList;
