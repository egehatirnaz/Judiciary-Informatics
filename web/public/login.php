<?php
    include 'db_connection.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST' ){
        // Check user credentials, if true then create a sesh var
        $citizen_no = mysqli_real_escape_string($db,$_POST['id']);
        $pass = hash_pass(mysqli_real_escape_string($db,$_POST['pass']), $citizen_no); 
        $query = "SELECT id FROM User WHERE `citizen_no` = '$citizen_no' AND `password` = '$pass'";
        if ($result = mysqli_query($db,$query)){
            $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
            $id = $row['id'];
            $count = mysqli_num_rows($result);

            // If count is 1, user exists.
            if ($count == 1) {

                // Find the userrole.
                $query2 = "SELECT * FROM UserRoleTable WHERE `user_id` = '$id'";
                if ($result = mysqli_query($db,$query2)){
                    $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
                    $role_id = $row['role_id'];
                    $count = mysqli_num_rows($result);
                    // If count is 1, user has a role.
                    if ($count == 1) {
                        // Set the session cookie
                        $user = ['user_type' => $role_id, 'user_id' => $id, 'user_hash' => hash_pass($id, $role_id)];
                        $_SESSION['credentials'] = $user;

                        // Redirect according to the role.
                        if ($role_id == "1"){ // Citizen
                            header("Location: account/user/lawsuits.php");
                        } else if ($role_id == "2"){ // Judge
                            header("Location: account/judge/cases.php");
                        } else if ($role_id == "3"){ // Lawyer
                            header("Location: account/lawyer/cases.php");
                        } else if ($role_id == "4"){ // Conciliator
                            header("Location: account/conciliator/cases.php");
                        } else {
                            header("Location: login.php");
                        }
                    } else {
                        header("Location: login.php");
                    }    
            } else {
                $msg = "Error: Invalid ID or password.";
            }
        } else {
            $msg = "Error: Invalid ID or password.";
        }
        /*
        // debug: assume it is valid.
        $user = ['user_type' => "user", 'user_id' => "", 'user_hash' => ""];
        $_SESSION['credentials'] = $user;

        // depending on the user type, redir.
        header("Location: account/user/lawsuits.php");
        die();
        */
        } else {
            $msg = "Error: Something went wrong.";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>National Judiciary Informatics System - Login</title>
    <meta name="description"
        content="User login page for National Judiciary Informatics System.">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicons -->
    <link href="img/favicon.png" rel="icon">
    <link href="img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,700,700i|Raleway:300,400,500,700,800|Montserrat:300,400,700" rel="stylesheet">

    <!-- Bootstrap CSS File -->
    <link href="lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Libraries CSS Files -->
    <link href="lib/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/ionicons/css/ionicons.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/magnific-popup/magnific-popup.css" rel="stylesheet">
    <link href="lib/ionicons/css/ionicons.min.css" rel="stylesheet">

    <!-- Main Stylesheet File -->
    <link href="css/style.css" rel="stylesheet">
    <style>
        .login_description{
            margin:0;
            margin-bottom: 5px;
        }
        .login_input{
            margin-bottom:20px;
        }
    </style>
</head>

<body id="body">
    <!--==========================
    Header
  ============================-->
    <header id="header">
        <div class="container">

            <div id="logo" class="pull-left">
                <h1><a href="/" class="scrollto">NJIS - <span>National Judiciary Informatics System</span></a></h1>
                <!-- Uncomment below if you prefer to use an image logo -->
                <!-- <a href="#body"><img src="img/logo.png" alt="" title="" /></a>-->
            </div>

            <nav id="nav-menu-container">
                <ul class="nav-menu">
                    <li><a href="/">Home</a></li>
                    <li class="menu-active"><a href="/login.php">Login</a></li>
                    <li><a href="/register.php">Register</a></li>
                    <!--
                    <li class="menu-has-children"><a href="">Drop Down</a>
                        <ul>
                            <li><a href="#">Drop Down 1</a></li>
                            <li><a href="#">Drop Down 3</a></li>
                            <li><a href="#">Drop Down 4</a></li>
                            <li><a href="#">Drop Down 5</a></li>
                        </ul>
                    </li>
                    <li><a href="#contact">Contact</a></li>
                    -->
                </ul>
            </nav><!-- #nav-menu-container -->
        </div>
    </header><!-- #header -->

    <main id="main">

        <!--==========================
      Services Section
    ============================-->
        <section id="login">
            <div class="container" style="margin-top:40px;">
                <div class="section-header">
                    <h2>Login</h2>
                    <p>Please enter your account information to login.</p>
                </div>
                <div class="form">
                    <form action="/login.php" method="POST" role="form" class="contactForm">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="box wow fadeInLeft form-group">
                                    <p class="login_description">Citizen ID Number:</p>
                                    <input class="login_input" type="text" name="id" data-rule="required" data-msg="This field is required.">
                                    <div class="validation"></div>
                                </div>
                                <div class="box wow fadeInLeft form-group">
                                    <p class="login_description">Password:</p>
                                    <input class="login_input" type="password" name="pass" data-rule="required" data-msg="This field is required.">
                                    <div class="validation"></div>
                                </div>
                                <div class="box wow fadeInLeft">
                                    <input class="signUpButton" type="submit" value="Login">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section><!-- #login -->
    </main>

    <a href="#" class="back-to-top"><i class="fa fa-chevron-up"></i></a>

    <!-- JavaScript Libraries -->
    <script src="lib/jquery/jquery.min.js"></script>
    <script src="lib/jquery/jquery-migrate.min.js"></script>
    <script src="lib/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/superfish/hoverIntent.js"></script>
    <script src="lib/superfish/superfish.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/magnific-popup/magnific-popup.min.js"></script>
    <script src="lib/sticky/sticky.js"></script>

    <!-- Contact Form JavaScript File -->
    <script src="contactform/contactform.js"></script>

    <!-- Template Main Javascript File -->
    <script src="js/main.js"></script>

</body>

</html>
