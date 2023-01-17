# Dev Jobs

An app used to display, favourite jobs and update job searches, this app manages data with the use of the Dev Jobs API. 

## Install software

### NodeJS
- Install in ubuntu
```
curl -sL https://deb.nodesource.com/setup_13.x | sudo -E bash -
sudo apt-get install -y nodejs
```
- Install in MacOS via brew 
```
brew install node
```
### Dev Jobs API

Go to https://github.com/meshu-dev/devjobs-api then follow install and setup instructions

## Setup 

- Install npm packages

```
npm install
```
- Copy the .env.example file to a new file named .env
```
cp .env.example .env
```
- Fill in .env variables in new file
    - REACT_APP_API_URL set to the Dev Jobs API
```
REACT_APP_API_URL=http://localhost:8000
```
## Commands

- Run app in development

```
npm run start
```
- Build files
```
npm run build
```
- Build files for test environment
```
npm run build:test
```
- Build files for production environment
```
npm run build:production
```
