<?php
if(!isset($_COOKIE["USER"]))
{
    echo "<script>window.location.href='index.php'</script>";
}
$user_email = $_COOKIE["USER"];
include "conn.php";

$q = "SELECT * FROM `users` WHERE `EMAIL` LIKE '$user_email'";
$run = mysqli_query($conn,$q);
$row=mysqli_fetch_array($run); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <title>Online Chat</title>
    <style>
        *{
            font-family: Verdana, Geneva, Tahoma, sans-serif;
        }
        .container{
            width:500px;
            height:100vh;
            margin:auto;
            overflow:scroll;
            box-shadow: 0 0 20px 0 rgba(0, 0, 0, 0.2), 0 5px 5px 0 rgba(0, 0, 0, 0.24);
        }
        @media screen and (max-width:500px){
            .container{
                width:100%;
            }
        }
        .container::-webkit-scrollbar{
            width: 1px;
        }
        header{
            height:10vh;
            background:rgb(85, 83, 83);
            display: flex;
            gap:15px;
            align-items: center;
            font-weight: bold;
            color: aliceblue;
        }
        img{
            margin-left:20px;
            border-radius:50%;
        }
        .name{
            cursor: pointer;
            width: 90%;
            margin: auto;
        }
        a{
            width:93%;
            margin:auto;
            margin-top: 10px;
            padding:10px 0;
            text-decoration: none;
            color: black;
            display:flex;
            gap:15px;
            align-items: center;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.2), 0 0px 5px rgba(0, 0, 0, 0.24);
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <div class="profile"><img src="img/<?php echo $row["IMG"]?>" height=35 width=35/></div>
            <div><?php echo $row["USERNAME"];?></div>
        </header>
        
        <?php         
            $email = $_COOKIE["USER"];
            $q = "SELECT * FROM `users` WHERE `EMAIL` NOT LIKE '$email'";
            $run = mysqli_query($conn,$q);
            if($run)
            {
                if(mysqli_num_rows($run)>0)
                {
                    while($row=mysqli_fetch_array($run))
                    {
                        $name = $row["USERNAME"];
                        $email = $row["EMAIL"];
                        echo
                        '
                        <a href="chatScreen.php?friend='.base64_encode($email).'">
                            <img src="img/'.$row["IMG"].'" height=35 width=35/>
                            <div class="name">'.$name.'</div>
                        </a>
                        ';
                    }
                }
            }
        ?>
    </div>
</body>
</html>