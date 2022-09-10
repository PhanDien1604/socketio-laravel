import { io } from "socket.io-client";

let ip_address = '127.0.0.1';
let socket_port = '3000';
let socket = io.connect(ip_address + ":" + socket_port);

const sender_id = $('.sender_id').val()
socket.emit("user connected", sender_id)

const friends = $('.friends')
const boxChat = $('.box-chat')
let friend_id = 0
let friend_name = ""
let receiver_id = 0

const boxMessages = $('.box-messages')

friends.find('.info').click(function() {
    boxMessages.html('')

    friend_id = $(this).find('.friend_id').val()
    friend_name = $(this).find('.name').text()

    boxChat.find('.receiver_id').val(friend_id)
    boxChat.find('.receiver-name').text(friend_name)
    console.log(friend_id)

    // socket.emit('join message', friend_id)


    $.ajax({
        type: "get",
        url: "/api/get-message",
        data: $('#form-chat').serialize(),
        dataType: "json",
        success: function (response) {
            console.log(response.data)
            response.data.forEach(messageItem => {
                var message = messageItem['message']
                var _html = ""
                if(sender_id == messageItem['sender_id']) {
                    _html = '<span class="bg-danger">'+ message +'</span> <br>'
                } else {
                    _html = '<span class="bg-success">'+ message +'</span> <br>'
                }

                boxMessages.append(_html);
                boxMessages.scrollTop(boxMessages[0].scrollHeight)
            });
        }
    });
})

$('#form-chat').submit(function(e) {
    e.preventDefault()

    $.ajax({
        type: "post",
        url: '/api/send-message',
        data: $('#form-chat').serialize(),
        dataType: "json",
        success: function (response) {
            if(response.success) {
                console.log(response.data)
            }
        }
    });
    receiver_id = boxChat.find('.receiver_id').val()
    var message = $('#content-message').val()

    socket.emit('send message',sender_id, receiver_id, message);

    var _html = '<span>'+ message +'</span> <br>'
    boxMessages.append(_html);

    $('#content-message').val('');
    boxMessages.scrollTop(boxMessages[0].scrollHeight)

});
socket.on('new message', function(data){
    if(data[0] == friend_id) {
        var _html = '<span>'+ data[2] +'</span> <br>'
        boxMessages.append(_html);
        boxMessages.scrollTop(boxMessages[0].scrollHeight)
    }
});
