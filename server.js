const express    = require('express'),
	  app        = express(),
	  path       = require('path');

// Load config params to process.env
let envFilename = '.env'

if (process.env.NODE_ENV !== 'production') {
  envFilename = `.env.${process.env.NODE_ENV}`
}

require('dotenv').config({ path: envFilename });

const port = process.env.APP_PORT || 3000;

app.use(express.static(path.join(__dirname, 'build')));

app.get('/*', function (req, res) {
   res.sendFile(path.join(__dirname, 'build', 'index.html'));
 });

// Start server
app.listen(port);
console.log('Server started on port ' + port);
