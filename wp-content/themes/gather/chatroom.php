<!DOCTYPE HTML>
<html>
<head>
<title>Chatter: Long-Polling AJAX Chatting System</title>
<link href="http://localhost/shop/wp-content/themes/gather/css/chatterStyle.css" rel="stylesheet" type="text/css" />
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<?php add_my_ajaxurl();?>
<script type="text/javascript">

function Chatter(){
     this.getMessage = function(callback, lastTime){
             var t = this;
             var latest = null;
             $.ajax({
                     url: ajaxurl,
                     type: 'post',
                     dataType: 'json',	//received data format
                     data: {
                         'action':'chatter_engine',
                         'mode': 'get',
                         'lastTime': lastTime
                     },
                     timeout: 30000,
                     cache: false,
                     success: function(result){
                         //alert(result.latest);
                         if(result.result){
                             callback(result.message);
                             latest = result.latest;
                         } 
                     },
                     error: function(e){
                         console.log(e);
                     },
                     complete: function(result){
                         //alert("complete");
                         t.getMessage(callback,latest);
                     }
             });
     };

     this.postMessage = function(user, text, callback){
         var mes = 'HellPPPo Chatter!!';
         $.ajax({
                 url: ajaxurl,
                 type: 'post',
                 data: {
                     'action' : 'chatter_engine',//have to match the chatter_engine function in functions.php
                     'mode': 'post',
                     'user': user,
                     'text': text,
                     'chatter': mes,
                  },
                  success: function(result){
                       //alert( result );
                       callback(result);
                  },
                  error: function(e){
                       console.log(e);
                  }
         });
     };
};
var cht = new Chatter();

     $(document).ready(function() {
         // chat room start
         $('#formPostChat').submit(function(e){
             e.preventDefault();
             var user = $('#postUsername');
             var text = $('#postText');
             var err = $('#postError');

             cht.postMessage(user.val(), text.val(), function(result){
                 //alert("document ready post msg");
                 if(result){
                     text.val('');
                 }
                 err.html(result.output);
             });
             return false;
         });

         cht.getMessage(function(message){
             var chat = $('#chatMessageList').empty();
             //alert(call back get msg);
             //alert(message[0].text);
             
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
         // chat room end
     });

</script>
</head>
<body>
     <ul id="chatMessageList" class="chatMessageList"></ul>
     <form method="post" id="formPostChat">
          <fieldset>
                <label for="postUsername">Username</label>
                     <input type="text" id="postUsername" />
                </fieldset>
                <fieldset>
                      <textarea id="postText"></textarea>
                </fieldset>
                <fieldset>
                     <input type="submit" value="Reply"/>
                     <span class="errorMessage" id="postError"></span>
                </fieldset>
      </form>
</body>
</html>