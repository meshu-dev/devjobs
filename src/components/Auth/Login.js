import React, { Component } from 'reactn';
import { withRouter } from 'react-router-dom';
import { Row, Col, Form, Button } from 'react-bootstrap';

class Login extends Component {
  constructor(props) {
    super(props);
    
    this.state = {
      email: '',
      password: ''
    };

    this.login = this.login.bind(this);
    this.onFieldChange = this.onFieldChange.bind(this);
  }

  onFieldChange(event) {
    this.setState({
      [event.target.name]: event.target.value
    });
  }

  async login(event) {
    event.preventDefault();

    let email = this.state.email,
        password = this.state.password;

    let isLoggedIn = await this.global.authService.login(
      email,
      password
    );

    if (isLoggedIn === true) {
      this.props.history.push('/');
    }
  }

  render() {
    return (
      <Row className="justify-content-center">
        <Col>
          <Form
            className="border rounded mx-auto"
            onSubmit={ this.login }
            style={{ padding: '1rem', width: '18rem' }}>
            <Form.Row className="text-center">
              Login (Develop2)
            </Form.Row>
            <Form.Group controlId="formBasicEmail">
              <Form.Control
                type="email"
                placeholder="Enter email"
                required
                name="email"
                value={this.state.email}
                onChange={this.onFieldChange} />
            </Form.Group>
            <Form.Group controlId="formBasicPassword">
              <Form.Control
                type="password"
                placeholder="Password"
                required
                name="password"
                value={this.state.password}
                onChange={this.onFieldChange} />
            </Form.Group>
            <Form.Row>
              <Button variant="primary" type="submit" className="mx-auto">
                Submit
              </Button>
            </Form.Row>
          </Form>
        </Col>
      </Row>
    );
  }
}

export default withRouter(Login);
