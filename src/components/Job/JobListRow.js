import React, { Component } from 'react';
import { Link } from 'react-router-dom';

import Container from 'react-bootstrap/Container';
import Row from 'react-bootstrap/Row';
import Col from 'react-bootstrap/Col';

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

  getDaySuffix(day) {
    if (day > 3 && day < 21) return 'th'

    switch (day % 10) {
      case 1:  return 'st'
      case 2:  return 'nd'
      case 3:  return 'rd'
      default: return 'th'
    }
  }

  getDate(job) {
    const timestamp = parseInt(job.date.$date.$numberLong)
    const dateObj = new Date(timestamp)
    const month = this.getMonth(timestamp)
    const day = dateObj.getDate()
    const dayText = day + this.getDaySuffix(day)

    return `${dayText} ${month} ${dateObj.getFullYear()}`
  }

  getMonth(timestamp) {
    const date = new Date(timestamp)
    return date.toLocaleString('default', { month: 'long' })
  }

  formatSalary(salary) {
    const formatter = new Intl.NumberFormat('en-GB', {
      style: 'currency',
      currency: 'GBP',
    });
    return formatter.format(salary);
  }

  render() {
    if (this.props.job) {
      const job = this.props.job
      const dateText = this.getDate(job)
      const minimumSalary = this.formatSalary(job.minimumSalary)
      const maximumSalary = this.formatSalary(job.maximumSalary)

      return (
        <Link to={ `/job/${job.id}` } className="job-list-row">
          <Card bg="light" className="job-list-content">
            <Card.Img src={ job.thumb } className="rounded" />
            <Card.Body>
              <Container>
                <Row>
                  <Col>
                    <Card.Title>{ job.jobTitle }</Card.Title>
                  </Col>
                  <Col>
                    <span className="font-weight-bold">Date posted:&nbsp;</span>
                    { dateText }
                  </Col>
                </Row>
                <Row>
                  <Col>
                    <Card.Text>
                      <span className="font-weight-bold">Location:&nbsp;</span>
                      { job.locationName }
                    </Card.Text>
                    <Card.Text>
                      <span>Salary:&nbsp;</span>
                      { `${minimumSalary} to ${maximumSalary}` }
                    </Card.Text>
                  </Col>
                </Row>
              </Container>
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
