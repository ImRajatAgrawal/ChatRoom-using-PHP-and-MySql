<?php 
session_start();
    include("include/_dbconnect.php");
    if(isset($_POST['sign_in'])){
        $email=$_POST['email'];
        $pass=$_POST['pass'];
        $sql="select * from users where email='$email' and password='$pass'";
        $query=mysqli_query($conn,$sql);
        $check_user=mysqli_num_rows($query);
        if($check_user==1){
            $_SESSION['email']=$email;
            $update_msg=mysqli_query($conn,"update users set login='Online' where email='$email'");
            $user=$_SESSION['email'];
            $get_user="select * from users where email='$user'";
            $run_user=mysqli_query($conn,$get_user);
            $row=mysqli_fetch_array($run_user);
            $user_name=$row['username'];
            echo "<script>window.open('home.php?username=$user_name','_self')</script>";
        }
        else{
            echo"
            <div class='alert alert-danger'>
            <strong>Check your email and password</strong></div>
            ";
        }
    }

?>