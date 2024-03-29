import React, { Component } from 'reactn';
import { withRouter } from 'react-router-dom';
import { Row, Col, Form, Button } from 'react-bootstrap';

class Login extends Component {
  constructor(props) {
    super(props);
    
    this.state = {
      email: '',
      password: '',
      isLoggedIn: null
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

    this.setState({
      isLoggedIn: isLoggedIn
    });

    if (isLoggedIn === true) {
      // TODO - Not working anymore
      //this.props.history.push('/');
    
      window.location = '/';
    }
  }

  render() {
    let loginMsg = this.state.isLoggedIn === false ? <div style={{ color: 'red' }}>Email/password was incorrect. Please try again.</div> : '';

    return (
      <Row className="justify-content-center">
        <Col>
          <Form
            className="border rounded mx-auto"
            onSubmit={ this.login }
            style={{ padding: '1rem', width: '18rem' }}>
            { loginMsg }
            <Form.Row className="text-center" style={{ display: 'block', marginBottom: '10px' }}>
              Login
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
