<!DOCTYPE html>
<?php
    session_start();
    include("include/_dbconnect.php");
    if(!isset($_SESSION['email'])){
        header("location: sigin.php");
    }
    else{
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ChatRoom-Home</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/home.css">
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-3 col-sx-3 col-xs-12 left-sidebar">
                <div class="input-group searchbox">
                    <div class="input-group-btn">
                        <center><a href="include/find_friends.php"><button class="btn btn-default search-icon"
                                    name="search_user" type="submit">Add new user</button></a></center>
                    </div>

                </div>
                <div class="left-chat">
                    <ul>
                        <?php 
                            include('include/get_users_data.php');
                        ?>
                    </ul>
                </div>

            </div>
            <div class="col-md-9 col-sm-9 col-xs-12 right-sidebar">
                <div class="row">
                    <?php 
                        $user=$_SESSION['email'];
                        $get_user="select * from users where email='$user'";
                        $run_user=mysqli_query($conn,$get_user);
                        $row=mysqli_fetch_array($run_user);
                        $user_name=$row['username'];
                        $userid=$row['user_id'];
                    ?>
                    <?php 
                    if(isset($_GET['username'])){
                    
                        $user=$_GET['username'];
                        $get_user="select * from users where username='$user'";
                        $run_user=mysqli_query($conn,$get_user);
                        $row=mysqli_fetch_array($run_user);
                        $username=$row['username'];
                    }
                       $totalmessages="select * from users_chat where (sender_username='$user_name' and reciever_username='$username') 
                                        or (reciever_username='$user_name' and sender_username='$username')" ;
                        $run_messages=mysqli_query($conn,$totalmessages);
                        $total=mysqli_num_rows($run_messages);
                    ?>
                    <div class="col-md-12 right-header">
                        <div class="right-header-img">
                            <img src="images/login_image.png">
                        </div>
                        <div class="right-header-detail">
                            <form method="post">
                                <p><?php   echo $username;?></p>
                                <span><?php echo $total;?> Messages</span>&nbsp &nbsp
                                <button name="logout" class="btn btn-danger">Logout</button>
                            </form>
                            <?php
                                     if(isset($_POST['logout'])){
                                        $update_msg=mysqli_query($conn,"update users set login='offline' where username='$user_name'");
                                        header("Location:logout.php");
                                        exit();
                                     }
                                ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div id="scrolling_to_bottom" class="col-md-12 right-header-contentChat">
                        <?php
                                         $update_msg=mysqli_query($conn,"update users_chat set msg_status='read' where sender_username='$username'and reciever_username='$user_name'");
                                         $sel_user="select * from users_chat where (sender_username='$user_name' and reciever_username='$username') 
                                         or (reciever_username='$user_name' and sender_username='$username') order by 1 ASC" ;
                                         $run_message=mysqli_query($conn,$sel_user);
                                         while($row=mysqli_fetch_array($run_message)){
                                             $sender_username=$row['sender_username'];
                                             $reciever_username=$row['reciever_username'];
                                             $msg_content=$row['msg_content'];
                                             $msg_date=$row['msg_date'];
                                             
                                       ?>  
                                    
                        <ul>
                        <?php
                                            if($user_name==$sender_username AND $username==$reciever_username){
                                                echo"<li>
                                                    <div class='rightside-right-chat'>
                                                        <span>$user_name <small> $msg_date</small></span><br><br>
                                                        <p>$msg_content</p>
                                                    </div>
                                                </li>";
                                            }
                                            else if($user_name==$reciever_username AND $username==$sender_username){
                                                echo"<li>
                                                    <div class='rightside-left-chat'>
                                                        <span>$username<small> $msg_date</small></span><br><br>
                                                        <p>$msg_content</p>
                                                    </div>
                                                </li>";
                                            }
                                        
                                      ?>
                        </ul>
                        <?php }?>
                    </div> 
                </div>
                <div class="row">
                    <div class="col-md-12 right-chat-textbox">
                        <form  method="post">
                            <input type="text" name="msg_content" id="msg_content" autocomplete="off" placeholder="Type Message here">
                            <button class="btn" name="submit"><i class="fa fa-telegram" aria-hidden="true"></i></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
        if(isset($_POST['submit'])){
            $msg=$_POST['msg_content'];
            if($msg==""){
               echo " <div class='alert alert-danger'>
                    <strong><center>Message was unable to send</center></strong>
                </div>
                ";
            }
            else if(strlen($msg)>100){
                echo " <div class='alert alert-danger'>
                    <strong><center>Message is too long use upto 100 characters...</center></strong>
                </div>
                ";
            }
            else{
                $insert="insert into users_chat(sender_username,reciever_username,msg_content,msg_status,msg_date) values('$user_name','$username','$msg','unread',NOW())";
                $run_insert=mysqli_query($conn,$insert);
              
            }
        }
    ?>

      <script>
          $('#scrolling_to_bottom').animate({
                scrollTop :$('#scrolling_to_bottom').get(0).scrollHeight},1000 );

      </script>  
      <script type="text/javascript">
            $(document).ready(
                function(){
                    var height=$(window).height();
                    $('.left-chat').css('height',(height-92)+'px');
                    $('.right-header-contentChat').css('height',(height-163)+'px');
                    
                }
            );
      </script>
</body>

</html>
    <?php } ?>