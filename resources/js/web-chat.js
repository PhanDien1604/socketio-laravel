import { io } from "socket.io-client";

let ip_address = '127.0.0.1';
let socket_port = '3000';
let socket = io.connect(ip_address + ":" + socket_port);

$('#form-chat').submit(function(e) {
    e.preventDefault()
    socket.emit('chat message', $('#content-message').val());
    $('#content-message').val('');
});

socket.on('chat message', function(msg){
    var _html = '<span>'+ msg +'</span> <br>'
    $('.box-messages').append(_html);
});


var userId = 0
const friends = $('.friends')
const boxChat = $('.box-chat')

friends.find('.info').click(function() {
    var friend_id = $(this).find('.friend_id').val()
    var friend_name = $(this).find('.name').text()

    boxChat.find('.receiver-name').text(friend_name)
    boxChat.find('.receiver_id').val(friend_id)
    // socket.emit('chat message', friend_id, )
})
