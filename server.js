const express = require('express');
const app = express();
const http = require('http');
const server = http.createServer(app);
const io = require("socket.io")(server, {
    cors: {
        origin: "*"
    }
});
// const io = new Server(server);

server.listen(3000, () => {
    console.log('listening on *:3000');
});

const users = [];

io.on('connection', (socket) => {
    console.log(socket.id);
    socket.on("user connected", function(user_id) {
        users[user_id] = socket.id
    })

    socket.on('send message', function(sender_id, receiver_id, message) {
        io.to(users[receiver_id]).emit('new message', [sender_id, receiver_id, message]);
    })
});



