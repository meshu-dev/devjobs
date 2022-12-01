class APIUtils {
	constructor(apiUrl) {
    this.apiUrl = apiUrl;
  }

  async get(
    url,
    incHeaders = false
  ) {
    return this.request(url, 'GET', {}, incHeaders);
  }

  async post(url, params = {}) {
    let fetchData = {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify(params)
    };
    return this.request(url, 'POST', fetchData);
  }

  async put(url, params = {}) {
    let fetchData = {
      method: 'PUT',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify(params)
    };
    return this.request(url, 'PUT', fetchData);
  }

  async request(
    url,
    method = 'GET',
    fetchData = {},
    getHeaders = false
  ) {
    try {
      const authToken = this.getAuthToken();

      if (authToken) {
        if (!fetchData['headers']) {
          fetchData = {
            headers: {}
          };
        }
        fetchData['headers']['Authorization'] = `Bearer ${authToken}`;
      }

      console.log('Request', this.apiUrl + url, fetchData);

      const response = await fetch(
        this.apiUrl + url,
        fetchData
      );

      if (!response.ok) {
        throw Error(response.statusText);
      }

      const json = await response.json();

      if (getHeaders === true) {
        return {
          'headers': this.getHeaders(response),
          'data': json
        }
      } else {
        return json;
      }
    } catch (error) {
      console.log(error);
    }
  }

  getHeaders(response) {
    let headers = {};

    for (let header of response.headers) {
      headers[header[0]] = header[1];
    }
    return headers;
  }

  getUserData() {
    let currentUser = localStorage.getItem('currentUser');
    return currentUser ? JSON.parse(currentUser) : null;
  }

  getAuthToken() {
    let userData = this.getUserData();

    if (userData) {
      return userData.token;
    }
    return null;
  }
}

export default APIUtils;
