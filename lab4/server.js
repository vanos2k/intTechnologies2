var app = require('express')();
var server = require('http').createServer(app);
var io = require('socket.io')(server);


app.get('/', function(req, res) {
  res.sendFile(__dirname + '/index.html');
});

io.on('connection', function(socket){
  socket.on('send message', function(msg) {
    io.emit('receive message', msg);
  });
});


server.listen(3000, function() {
  console.log('listening on *:3000');
});
