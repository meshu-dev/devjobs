class APIUtils {
	constructor(apiUrl) {
    this.apiUrl = apiUrl;
  }

  async get(
    url,
    incHeaders = false
  ) {
    return this.request(url, {}, incHeaders);
  }

  async post(url, params = {}) {
    let fetchData = {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify(params)
    };
    return this.request(url, fetchData);
  }

  async put(url, params = {}) {
    let fetchData = {
      method: 'PUT',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify(params)
    };
    return this.request(url, fetchData);
  }

  async request(
    url,
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

      const response = await fetch(
        this.apiUrl + url,
        fetchData
      );

      if (!response.ok) {
        console.log('APIUtils.request | Response', response);
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
      console.log('APIUtils.request | Error', error);
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
