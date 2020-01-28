import React from 'reactn';  
import { Redirect, Route } from 'react-router-dom';

const PrivateRoute = ({ component: Component, loggedIn, ...rest }) => (  
  <Route {...rest} render={props => (
    loggedIn ? (
      <Component {...props} />
    ) : (
      <Redirect to={{ pathname: '/login', state: { from: props.location } }} />
    )
  )} />
);

export default PrivateRoute;
