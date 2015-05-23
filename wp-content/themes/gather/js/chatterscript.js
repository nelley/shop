function Chatter(){
        this.getMessage = function(callback, lastTime){
                var t = this;
                var latest = null;
 
                $.ajax({
                        'url': 'http://localhost/shop/chatterengine',
                        'type': 'post',
                        'dataType': 'json',
                        'data': {
                            'mode': 'get',
                            'lastTime': lastTime
                        },
                        'timeout': 30000,
                        'cache': false,
                        'success': function(result){
                                if(result.result){
                                    callback(result.message);
                                    latest = result.latest;
                                } 
                        },
                        'error': function(e){
                            console.log(e);
                        },
                        'complete': function(){
                            t.getMessage(callback, latest);
                        }
                });
        };
 
        this.postMessage = function(user, text, callback){
                $.ajax({
                        'url': 'http://localhost/shop/chatterengine',
                        'type': 'post',
                        'dataType': 'json',
                        'data': {
                                'mode': 'post',
                                'user': user,
                                'text': text
                        },
                        'success': function(result){
                                callback(result);
                        },
                        'error': function(e){
                                console.log(e);
                        }
                });
        };
};

var c = new Chatter();

$(document).ready(function(){
        $('#formPostChat').submit(function(e){
                e.preventDefault();
 
                var user = $('#postUsername');
                var text = $('#postText');
                var err = $('#postError');
 
                c.postMessage(user.val(), text.val(), function(result){
                        if(result){
                                text.val('');
                        }
                        err.html(result.output);
                });
 
                return false;
        });
 
        c.getMessage(function(message){
                var chat = $('#chatMessageList').empty();
 
                for(var i = 0; i < message.length; i++){
                        chat.append(
                                '<li class="chatMessage">' +
                                ' <span class="chatUsername">' + message[i].user + '</span>' +
                                ' <p class="chatText">' + message[i].text + '</p>' +
                                '</li>'
                        );
                }
 
                $('#chatMessageList').scrollTop($('#chatMessageList')[0].scrollHeight);
        });
});