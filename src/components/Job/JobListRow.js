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
    const dateObj = new Date(job.date);
    const month = this.getMonth(dateObj.getTime());
    const day = dateObj.getDate();
    const dayText = day + this.getDaySuffix(day);

    return `${dayText} ${month} ${dateObj.getFullYear()}`;
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
      const job = this.props.job;
      const jobParams = job.params;
      const dateText = this.getDate(job);
      const minimumSalary = jobParams ? this.formatSalary(jobParams.minimumSalary) : 0;
      const maximumSalary = jobParams ? this.formatSalary(jobParams.maximumSalary) : 0;
      let salaryText = 'Unavailable';

      if (jobParams && jobParams.minimumSalary && jobParams.maximumSalary) {
        salaryText = `${minimumSalary} to ${maximumSalary}`;
      }

      if (jobParams) {
        return (
          <Link to={ `/job/${job.id}` } className="job-list-row">
            <Card bg="light" className="job-list-content">
              <div className="job-list-mobileview">
                <div className="job-list-title">{ jobParams.jobTitle }</div>
                <div className="job-list-mobileview-content">
                  <img src={ job.thumb } alt={ job.id } />
                  <div className="job-list-mobileview-text">
                    <div>
                      <span className="font-weight-bold">Date posted:&nbsp;</span>
                      { dateText }
                    </div>
                    <div>
                      <span className="font-weight-bold">Location:&nbsp;</span>
                      { jobParams.locationName }
                    </div>
                    <div>
                      <span className="font-weight-bold">Salary:&nbsp;</span>
                      { salaryText }
                    </div>
                  </div>
                </div>
              </div>
              <div className="job-list-desktopview">
                <Card.Img src={ job.thumb } className="rounded" />
                <Card.Body>
                  <Container>
                    <Row>
                      <Col>
                        <Card.Title>{ jobParams.jobTitle }</Card.Title>
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
                          { jobParams.locationName }
                        </Card.Text>
                        <Card.Text>
                          <span>Salary:&nbsp;</span>
                          { salaryText }
                        </Card.Text>
                      </Col>
                    </Row>
                  </Container>
                </Card.Body>
              </div>
            </Card>
          </Link>
        );
      }
    }
    return (null);
  }
}

export default JobListRow;
