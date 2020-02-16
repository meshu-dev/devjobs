import 'bootstrap/dist/css/bootstrap.min.css';

import React from 'react';
import ReactDOM from 'react-dom';
import { BrowserRouter as Router } from 'react-router-dom';
import { setGlobal } from 'reactn';

import './index.css';

import Layout from './components/Layout/Layout.js';
import * as serviceWorker from './serviceWorker';

import APIUtils from './common/APIUtils';
import AuthService from './common/AuthService';

let apiUtils = new APIUtils(
  process.env.REACT_APP_API_URL
);

setGlobal({
  apiUtils: apiUtils,
  authService: new AuthService(apiUtils)
});

ReactDOM.render(
	<Router>
		<Layout />
	</Router>,
	document.getElementById('root')
);

// If you want your app to work offline and load faster, you can change
// unregister() to register() below. Note this comes with some pitfalls.
// Learn more about service workers: https://bit.ly/CRA-PWA
serviceWorker.unregister();
