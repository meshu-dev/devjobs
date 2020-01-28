import React, { Component } from 'reactn';
import { NavLink, Link, withRouter } from 'react-router-dom';
import { Container, Navbar, Nav } from 'react-bootstrap';

import { useGlobal } from 'reactn';

import logo from './../../logo.svg';

class Header extends Component {
  constructor(props) {
    super(props);

    this.logout = this.logout.bind(this);
  }

  logout(event) {
    event.preventDefault();

    let isLoggedOut = this.global.authService.logout();

    if (isLoggedOut) this.props.history.push('/login');
  }

  renderLinks() {
    let userData = this.global.authService.getUserData();

    if (userData) {
      return (
        <Nav className="mr-auto">
          <Nav.Item>
            <NavLink to="/" className="nav-link">Home</NavLink>
          </Nav.Item>
          <Nav.Item>
            <NavLink to="#" onClick={ this.logout } className="nav-link">Logout</NavLink>
          </Nav.Item>
        </Nav>
      );
    }
  }

  render() {
    return (
      <header>
        <Navbar bg="dark" variant="dark">
          <Container>
            <Navbar.Brand href="/">
              <img
                src={ logo }
                width="30"
                height="30"
                className="d-inline-block align-top"
                alt="React Bootstrap logo"
              />{' '}
              DevJobs!!!
            </Navbar.Brand>
            { this.renderLinks() }
          </Container>
        </Navbar>
      </header>
    );
  }
}

export default withRouter(Header);
