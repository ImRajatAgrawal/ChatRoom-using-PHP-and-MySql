<?php
   include("include/_dbconnect.php");
    $user="select * from users";
    $run_user=mysqli_query($conn,$user);
    while($row=mysqli_fetch_array($run_user)){
        $user_id=$row['user_id'];
        $username=$row['username'];
        $login=$row['login'];
       echo" <li>
            <div class='chat-left-img'>
                <img src='images/login_image.png' alt='user image'>
            </div>
            <div class='chat-left-detail'>
                <p><a href='home.php?username=$username'>$username</a></p>
            ";
            if($login=='Online'){
                echo"<span><i class='fa fa-circle' aria-hidden='true'></i> Online</span>";
            }
            else{
                echo"<span><i class='fa fa-circle-o' aria-hidden='true'></i> Offline</span>";
            }
        echo"
             </div>
             </li>";
    }
?>