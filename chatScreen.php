<?php
if(!isset($_COOKIE["USER"]))
{
    echo "<script>window.location.href='index.php'</script>";
}
$friend_email = $_GET["friend"];
$friend_email = base64_decode($friend_email);
if(!isset($friend_email))
{
    echo "<script>window.location.href='users.php'</script>";
}

include "conn.php";

$q = "SELECT * FROM `users` WHERE `EMAIL` LIKE '$friend_email'";
$run = mysqli_query($conn,$q);
$row=mysqli_fetch_array($run);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <title>Chat App</title>
    <style>
        *{
            font-family: Verdana, Geneva, Tahoma, sans-serif;
        }
        .container{
            width:500px;
            height:100vh;
            margin:auto;
            box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.2), 0 5px 5px 0 rgba(0, 0, 0, 0.24);
        }
        @media screen and (max-width:500px){
            .container{
                width:100%;
            }
        }
        header{
            height:10vh;
            background:rgb(85, 83, 83);
            display: flex;
            /* place-content: center; */
            justify-content: flex-start;
            gap: 20px;
            align-items: center;
            font-weight: bold;
            color: aliceblue;
        }
        .chatBox{
            height: 80vh;
            overflow: scroll;
            background: rgb(206, 230, 209);
        }
        .chatBox::-webkit-scrollbar{
            width: 1px;
        }
        .square1{
            padding-right:10px;
            display:flex;
            justify-content:flex-end;
            align-items:center;
        }
        .square2{
            padding-left:10px;
            display:flex;
            justify-content:flex-start;
        }
        .inmsg{
            padding: 10px 15px;
            margin:3px;
            background:#f2f7f2;
            margin-right:200px;
            border-radius:0px 15px 15px 15px;
            box-shadow:1px 3px 5px gray;
        }
        .outmsg{
            margin:3px;
            margin-left:200px;
            padding: 10px 15px;
            background:#a3f0a3;
            border-radius:15px 0px 15px 15px;
            box-shadow:1px 3px 5px gray;
        }
        img{
            border-radius:50%;
        }
        footer{
            background: rgb(206, 230, 209);
            height: 10vh;
            display: flex;
        }
        input[type=text]{
            padding:0 10px;
            margin: auto;
            height: 7vh;
            width: 75%;
            border-radius: 10px;
            outline: none;
            border: none;
            font-size: 12pt;
        }
        input[type=button]
        {
            margin: auto;
            width: 18%;
            height: 7vh;
            border-radius: 5px;
            border: 1px solid rgb(25, 158, 96);
            background: rgb(25, 158, 96);
            font-size: 11pt;
            font-weight: bold;
            color: aliceblue;
            cursor: pointer;
        }
        .backbtn{
            margin-left: 20px;
            border: none;
            background: rgb(85, 83, 83);
            color: white;
            font-weight: bolder;
            font-family: Verdana, Geneva, Tahoma, sans-serif;
            font-size: 12pt;
            cursor: pointer;
        }
    </style>
</head>
<body class="document">
    <div class="container">
        <header>
            <button class="backbtn" title="Back">&lt;</button>
            <div class="profile"><img src="img/<?php echo $row["IMG"]?>" height=35 width=35/></div>
            <?php echo $row["USERNAME"];?>
        </header>
        <div class="chatBox" id="chatBox"></div>
        <footer>
            <input type="hidden" name="friend" id="friend" value="<?php echo $friend_email;?>">
            <input type="hidden" name="myName" id="myName" value="<?php echo $_COOKIE["USER"];?>">
            <input type="text" name="sendText" id="sendText" placeholder="Type message to send" autofocus>
            <input type="button" value="Send" id="send">
        </footer>
    </div>
</body>
</html>
<script>
    // update messages(realtime)
    var msgFrom = document.getElementById("myName").value;
    var msgTo = document.getElementById("friend").value;
    const req = new XMLHttpRequest();

    setInterval(() => {
        req.open("GET","updateMsg.php?msgFrom="+msgFrom+"&msgTo="+msgTo,true);
        req.send();
        req.onreadystatechange = function()
        {
            if(req.readyState == 4 && req.status==200){
                document.getElementById('chatBox').innerHTML = req.responseText;
                var ele = document.getElementById("chatBox");
                ele.scrollTop = ele.scrollHeight;
            }
        }
    },500);
    
    // send message to friend
    $(document).ready(function(){
        $("#send").click(function(){
            var msg = document.getElementById("sendText").value.trim();
            var msgFrom = document.getElementById("myName").value;
            var msgTo = document.getElementById("friend").value;
            if(msg!=""){
                $.post("sendMsg.php",{
                    msg:msg,
                    msgFrom:msgFrom,
                    msgTo:msgTo
                },function(data,status){
                    if(status == "success"){
                        document.getElementById("sendText").value = null;
                    }
                });               
            }             
        });
    });
    // // go to the users page
    $(".backbtn").click(function(){
        window.location.href = "users.php";
    });
</script>