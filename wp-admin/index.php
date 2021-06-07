<?php
    include "includes/connection.php";

    ob_start();
    session_start();

    if (!empty($_SESSION['u_mail'])) {
        header('Location: dashboard.php');
      }
?>


<DOCTYPE html>
    <html lang="en">
        <head>
            <meta charset="UTF-8">
            <title>OurTimes</title>
            <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
            <style>
                *{
                    margin: 0;
                    padding: 0;
                    font-family: Century Gothic;
                }
                header {
                    background-image: linear-gradient(rgba(0,0,0,0.5),rgba(0,0,0,0.5)), url(assets/img/index-wallpaper.jpg);
                    height: 100vh;
                    background-size: cover;
                    background-position: center;
                    
                }
                ul{
                    float: right;
                    list-style-type: none;
                    margin-top: 25px;;
                }
                ul li {
                    display: inline-block;
                }

                ul li a {
                    text-decoration: none;
                    color: #fff;
                    padding: 5px 20px;
                    border: 1px solid transparent;
                    transition: .6s ease;
                }
                ul li a:hover{
                    background-color: #fff;
                    color: #000;   
                }
                ul li.active a{
                    background-color: #fff;
                    color: #000;
                }
                .logo img{
                    float: left;
                    width: 150px;
                    height: auto;
                }
                .main {
                    max-width: 1200px;
                    margin: auto;
                }
                .title {
                    position: absolute;
                    top: 50%;
                    left: 50%;
                    transform: translate(-50%,-50%)
                }
                .title h1 {
                    color: #fff;
                    font-size: 68px;
                }
                .button {
                    position: absolute;
                    top: 62%;
                    left: 50%;
                    transform: translate(-50%,-50%)
                }
                .btn{
                    border: 1px solid #fff;
                    padding: 10px 30px;
                    color: #fff;
                    text-decoration: none;
                    transition: 0.6s ease;
                }
                .btn:hover {
                    background-color: #fff;
                    color: #000;   
                }
                .modal-login {		
                    color: #636363;
                    width: 350px;
                }
                .modal-login .modal-content {
                    padding: 20px;
                    border-radius: 5px;
                    border: none;
                }
                .modal-login .modal-header {
                    border-bottom: none;   
                    position: relative;
                    justify-content: center;
                }
                .modal-login h4 {
                    text-align: center;
                    font-size: 26px;
                    margin: 30px 0 -15px;
                }
                .modal-login .form-control:focus {
                    border-color: #70c5c0;
                }
                .modal-login .form-control, .modal-login .btn {
                    min-height: 40px;
                    border-radius: 3px; 
                }
                .modal-login .close {
                    position: absolute;
                    top: -5px;
                    right: -5px;
                }	
                .modal-login .modal-footer {
                    background: #ecf0f1;
                    border-color: #dee4e7;
                    text-align: center;
                    justify-content: center;
                    margin: 0 -20px -20px;
                    border-radius: 5px;
                    font-size: 13px;
                }
                .modal-login .modal-footer a {
                    color: #999;
                }		
                .modal-login .avatar {
                    position: absolute;
                    margin: 0 auto;
                    left: 0;
                    right: 0;
                    top: -70px;
                    width: 95px;
                    height: 95px;
                    border-radius: 50%;
                    z-index: 9;
                    background: #60c7c1;
                    padding: 15px;
                    box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.1);
                }
                .modal-login .avatar img {
                    width: 100%;
                }
                .modal-login.modal-dialog {
                    margin-top: 80px;
                }
                .modal-login .btn, .modal-login .btn:active {
                    color: #fff;
                    border-radius: 4px;
                    background: #60c7c1 !important;
                    text-decoration: none;
                    transition: all 0.4s;
                    line-height: normal;
                    border: none;
                }
                .modal-login .btn:hover, .modal-login .btn:focus {
                    background: #45aba6 !important;
                    outline: none;
                }
                .trigger-btn {
                    display: inline-block;
                    margin: 100px auto;
                }
            </style>
        </head>
        <body>
           <header>
               
               <div class="title">
                   <h1>Ourtimes Newsportal</h1>
               </div>
               <div class="button">
                   <a href="#myModal" class="btn" data-toggle="modal">Click To Login</a>
               </div>
           </header>
         
           <!-- Modal HTML -->
            <div id="myModal" class="modal fade">
                <div class="modal-dialog modal-login">
                    <div class="modal-content">
                        <div class="modal-header">
                            <div class="avatar">
                                <img src="assets/img/user-male.png">
                            </div>				
                            <h4 class="modal-title">Member Login</h4>	
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        </div>
                        <div class="modal-body">
                            <form action="" method="POST">
                                <div class="form-group">
                                    <input type="email" class="form-control" name="email" placeholder="Your Email" required="required">		
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control" name="password" placeholder="Your Password" required="required">	
                                </div>        
                                <div class="form-group">
                                    <input type="submit" name="submit" value="Login" class="btn btn-primary btn-lg btn-block login-btn">
                                </div>
                            </form>
                        </div>

                        <?php
                        if (isset($_POST['submit'])) {
                            $email      = mysqli_real_escape_string($db,$_POST['email']);
                            $password   = mysqli_real_escape_string($db,$_POST['password']);
                            $hashPass   = sha1($password);
                            
                            $query = "SELECT * FROM wp_users WHERE u_mail = '$email'";
                            $result = mysqli_query($db, $query);
                            while ($row = mysqli_fetch_assoc($result)) {
                                $_SESSION['u_id']       = $row['u_id'];
                                $_SESSION['u_name']     = $row['u_name'];
                                $_SESSION['u_mail']     = $row['u_mail'];
                                $_SESSION['u_pass']     = $row['u_pass'];
                                $_SESSION['u_address']  = $row['u_address'];
                                $_SESSION['u_phone']    = $row['u_phone'];
                                $_SESSION['biodata']    = $row['biodata'];
                                $_SESSION['photo']      = $row['photo'];
                                $_SESSION['user_role']  = $row['user_role'];
                            }
                            if (($email == $_SESSION['u_mail']) && ($hashPass == $_SESSION['u_pass'])) {
                                header("Location: dashboard.php");
                            }
                            else if (($email != $_SESSION['u_mail']) || ($hashPass != $_SESSION['u_pass'])) {
                                header("Location: index.php");
                            }else {
                                header("Location: index.php");
                            }
                        }
                        
                        ?>

                    </div>
                </div>
            </div>  

        





            <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
        </body>
    </html>