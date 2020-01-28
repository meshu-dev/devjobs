import React, { Component } from 'react';
import { Link } from 'react-router-dom';
import Card from 'react-bootstrap/Card';

import './JobListRow.css';

class JobListRow extends Component {
  isValidUrl(string) {
    try {
      new URL(string);
      return true;
    } catch (_) {
      return false;  
    }
  }

  render() {
    console.log(this.props.job);

    if (this.props.job) {
      let job = this.props.job;

      return (
        <Link to={ `/job/${job.id}` } className="job-list-row">
          <Card bg="light" className="job-list-content">
            <Card.Img src="https://media.glassdoor.com/sql/464321/jobsite-squarelogo-1432214278057.png" className="rounded" />
            <Card.Body>
              <Card.Title>{ job.jobTitle }</Card.Title>
              <Card.Text>
                <span class="font-weight-bold">Location:&nbsp;</span>
                { job.locationName }
              </Card.Text>
              <Card.Text>
                <span>Salary:&nbsp;</span>
                { `${job.minimumSalary} to ${job.maximumSalary}` }
              </Card.Text>
            </Card.Body>
          </Card>
        </Link>
      );
    } else {
      return <div></div>;
    }
  }
}

export default JobListRow;
