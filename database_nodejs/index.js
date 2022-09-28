var express = require('express'),
    routes = require('./routes'),
    path = require('path'),
    fileUpload = require('express-fileupload'),
    app = express(),
    mysql = require('mysql'),
    bodyParser = require('body-parser');

var connection = mysql.createConnection({
    host    : 'localhost',
    user    : 'root',
    password: 'password',
    database: 'student_records'
});

connection.connect();

global.db = connection;

// All environments
var port = process.env.PORT || 3000;
app.set('port', port);
app.set('views',__dirname + '/views');
app.set('view engine', 'ejs');
app.use(bodyParser.urlencoded({extended:false}));
app.use(bodyParser.json());
app.use(express.static(path.join(__dirname, 'public')));
app.use(fileUpload());

// Development only
app.get('/', routes.index);//call for main index page
app.post('/', routes.index);//call for signup post
app.get('/profile/:id', routes.profile);

// Middleware
app.listen(port);
console.log(port);