var express = require('express');
var app = express();

// must specify options hash even if no options provided!
var phpExpress = require('php-express')({

  // assumes php is in your PATH
  binPath: 'php'
});

// set view engine to php-express
app.set('views', './views');
app.engine('php', phpExpress.engine);
app.set('view engine', 'php');

// routing all .php file to php-express
app.all(/.+\.php$/, phpExpress.router);

var server = app.listen(8080, function () {
  var host = server.address().address;
  var port = server.address().port;
  console.log('PHPExpress app listening at http://%s:%s', host, port);
});

var io = require('socket.io')(server);

io.on('connection', (socket) => {
    socket.on('chat message', (msg) => {
      io.emit('chat message', msg);
    });
    socket.on('usr name', (usr) => {
        io.emit('usr name', usr);
    });
});
