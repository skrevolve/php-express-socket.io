<?php
    session_start();
    if(isset($_SESSION["usr_name"])&&isset($_SESSION["usr_phone"])) {
        //$usr_name = $_SESSION["usr_name"];
        //$usr_phone = $_SESSION["usr_phone"];
    } else {
        //echo '<script>alert("인증정보가 없습니다. 로그인 해주시기 바랍니다.");location.href="xxx.php";</script>';
        $usr_name = "Calvin";
        //$usr_phone = "";
    }
?>
<!doctype html>
<html>
  <head>
    <title>Socket.IO chat</title>
    <style>
      * { margin: 0; padding: 0; box-sizing: border-box; }
      body { font: 13px Helvetica, Arial; }
      form { background: #000; padding: 3px; position: fixed; bottom: 0; width: 100%; }
      form input { border: 0; padding: 10px; width: 90%; margin-right: .5%; }
      form button { width: 9%; background: rgb(130, 224, 255); border: none; padding: 10px; }
      #messages { list-style-type: none; margin: 0; padding: 0; }
      #messages:after{content:'';display:block;clear:both;}
      #messages li {float:left;padding: 5px 10px; }
      #messages li.left {width:10%;}
      #messages li.right{width:90%;}
      #messages li:nth-child(odd) { background: #eee; }
      #messages { margin-bottom: 40px }
    </style>
    <script src="/socket.io/socket.io.js"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
  </head>
  <body>
    <ul id="messages"></ul>
    <form action="">
        <input id="usr" type="hidden" value='<?=$usr_name?>'/>
        <input id="m" autocomplete="off" /><button>Send</button>
    </form>
  </body>
  <script>
    $(function () {
        var socket = io();
        $('form').submit(function(e){
            e.preventDefault(); // prevents page reloading
            socket.emit('usr name', $('#usr').val()); //우선순위 왼쪽부터;
            socket.emit('chat message', $('#m').val());
            $('#m').val('');
            return false;
        });
        socket.on('usr name', function(usr){
            $('#messages').append($('<li class="name left">').text(usr));
            window.scrollTo(0, document.body.scrollHeight);
        });
        
        socket.on('chat message', function(msg){
            $('#messages').append($('<li class="msg right">').text(msg));
            window.scrollTo(0, document.body.scrollHeight);
        });
    });
    </script>
</html>
