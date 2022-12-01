class AuthService {
	constructor(apiUtils) {
    this.apiUtils = apiUtils;
  }

  async login(email, password) {
    let result = await this.apiUtils.post(
      `/auth/login`,
      {
        email: email,
        password: password
      }
    );

    if (result && result.token) {
      localStorage.setItem('currentUser', JSON.stringify(result));
      return true;
    }
    return false;
  }

  logout() {
    localStorage.removeItem('currentUser');
    return true;
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

  getAuthHeader() {
    let userData = this.getUserData();

    if (userData) {
      return {
        headers: {
          Authorization: 'Bearer ' + userData.token
        }
      };
    }
    return null;
  }
}

export default AuthService;
