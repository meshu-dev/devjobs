import './Layout.css';

import React, { Component } from 'reactn';
import { Route, Redirect } from 'react-router-dom';

import Header from './../Header/Header.js';
import JobList from './../Job/JobList';
import JobFavouriteList from './../Job/JobFavouriteList';
import JobSearch from './../Job/JobSearch';
import JobView from './../Job/JobView';
import JobTest from './../Job/JobTest';
import Login from './../Auth/Login';

import PrivateRoute from './../../common/PrivateRoute';

import { Container } from 'react-bootstrap';

class Layout extends Component {
  render() {
    let userData = this.global.authService.getUserData(),
        isLoggedIn = userData ? true : false;

    return (
      <div className="container-fluid px-0">
        <div className="row no-gutters h-100">
          <div className="col-sm h-100">
            <Header />
            <div id="main">
              <Route
                path='/login'
                component={ Login } />
              <PrivateRoute
                exact path='/'
                component={ JobList }
                loggedIn={ isLoggedIn } />
              <PrivateRoute
                path='/jobs/:page'
                component={ JobList }
                loggedIn={ isLoggedIn } />
              <PrivateRoute
                path='/settings'
                component={ JobSearch }
                loggedIn={ isLoggedIn } />
              <PrivateRoute
                path='/favourites/:page'
                component={ JobFavouriteList }
                loggedIn={ isLoggedIn } />
              <PrivateRoute
                path='/job/:id'
                component={ JobView }
                loggedIn={ isLoggedIn } />
              <PrivateRoute
                path="/test"
                component={ JobTest }
                loggedIn={ isLoggedIn } />
              <Route
                exact
                path="/jobs"
                render={
                  () => (<Redirect to="/" />)
                }
              /> 
            </div>
          </div>
        </div>
      </div>
    );
  }
}

export default Layout;
