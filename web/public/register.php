<?php
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' ){
    $msg = "";
    
    // Validate the inputs.
    if(isset(
        $_POST['user_id'], 
        $_POST['user_surname'],
        $_POST['user_name'], 
        $_POST['user_email'],
        $_POST['user_phone'],
        $_POST['user_pass'],
        $_POST['user_pass_confirm'],
        $_POST['user_address'],
        $_POST['user_city'],
        $_POST['user_zipcode']
    )){
        // Secure the inputs.
        $citizen_no = mysqli_real_escape_string($db, $_POST['user_id']);
        $name = mysqli_real_escape_string($db, $_POST['user_name']);
        $surname = mysqli_real_escape_string($db, $_POST['user_surname']);
        $email_address = mysqli_real_escape_string($db, $_POST['user_email']);
        $phone_no = mysqli_real_escape_string($db, $_POST['user_phone']);
        $unhashed_pass = mysqli_real_escape_string($db, $_POST['user_pass']);
        $unhashed_pass_confirm = mysqli_real_escape_string($db, $_POST['user_pass_confirm']);
        $address = mysqli_real_escape_string($db, $_POST['user_address']);
        $city = mysqli_real_escape_string($db, $_POST['user_city']);
        $zip_code = mysqli_real_escape_string($db, $_POST['user_zipcode']);

        // Confirm the pass and its validation.
        if($unhashed_pass === $unhashed_pass_confirm){
            // Passwords are matching. Hash that shit.
            $hashed_pass = hash_pass($unhashed_pass, $citizen_no);
            // Insert into the db.
            $query = "INSERT INTO User (
                `citizen_no`,
                `name`,
                `surname`,
                `password`,
                `phone_no`,
                `email_address`,
                `address`,
                `city`,
                `zip_code`
            )
            VALUES (
                '$citizen_no',
                '$name',
                '$surname',
                '$hashed_pass',
                '$phone_no',
                '$email_address',
                '$address',
                '$city',
                '$zip_code'
            )";
            if (mysqli_query($db, $query)) {
                // Insert into userRoleTable for the user role
                $query2 = "INSERT INTO UserRoleTable (
                    `user_id`,
                    `role_id`
                ) 
                VALUES (
                    (SELECT id from User where citizen_no = '$citizen_no'),
                    '1'
                )";
                if (mysqli_query($db, $query2)) {
                    $msg = "Success! You have registered into the system.";
                    echo '<script>
                    alert("'.$msg.'");
                    window.location.replace("index.php");
                    </script>';
                    //header("Location: index.php");
                } else {
                    // Error - UserRoleTable table.
                    $msg = "Error! Could not assign user role." . mysqli_error($db) . "";
                    die($msg);
                }
            } else { // Error - User table.
                $msg =  "Error: " . mysqli_error($db); //bad idea.
                die($msg);
            }
        } else {
            // Passwords dont match. Give error.
            $msg = "Error: Password and password confirmation does not match.";
        }

    } else { // Missing inputs. 
        $msg = "Error: Some input fields are missing.";
    }
    echo '<script>alert("'.$msg.'");</script>';    

    /*
    // debug: assume it is valid.
    $user = ['user_type' => "user", 'user_id' => "", 'user_hash' => ""];
    $_SESSION['credentials'] = $user;

    // depending on the user type, redir.
    header("Location: account/user/lawsuits.php");
    die();
    */
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>National Judiciary Informatics System - Register</title>
    <meta name="description" content="User registiration page for National Judiciary Informatics System.">
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
        .login_description {
            margin: 0;
            margin-bottom: 5px;
        }

        .login_input {
            margin-bottom: 20px;
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
                    <li><a href="/login.php">Login</a></li>
                    <li class="menu-active"><a href="/register.php">Register</a></li>
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
        <section id="login">
            <div class="container" style="margin-top:40px;">
                <div class="section-header">
                    <h2>Register</h2>
                    <p>Please enter your personal information to register to system. All fields are required.</p>
                </div>
                <div class="form">
                    <form action="" method="POST" role="form" class="contactForm">
                        <!-- Personal Information -->
                        <h4>Personal Information</h4>
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="box wow fadeInLeft form-group">
                                    <p class="login_description">National ID:</p>
                                    <input class="login_input" type="text" name="user_id" data-rule="minlen:11" data-msg="Your ID must be 11 digits long.">
                                    <div class="validation"></div>
                                </div>
                                <div class="box wow fadeInLeft form-group">
                                    <p class="login_description">Surname:</p>
                                    <input class="login_input" type="text" name="user_surname" data-rule="required" data-msg="This field is required.">
                                    <div class="validation"></div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="box wow fadeInLeft form-group">
                                    <p class="login_description">Name:</p>
                                    <input class="login_input" type="text" name="user_name" data-rule="required" data-msg="This field is required.">
                                    <div class="validation"></div>
                                </div>
                                <div class="box wow fadeInLeft form-group">
                                    <p class="login_description">E-mail:</p>
                                    <input class="login_input" type="text" name="user_email" data-rule="email" data-msg="Please enter a valid email.">
                                    <div class="validation"></div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="box wow fadeInLeft form-group">
                                    <p class="login_description">Phone Number:</p>
                                    <input class="login_input" type="text" name="user_phone" data-rule="required" data-msg="This field is required.">
                                    <div class="validation"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Password -->
                        <h4>Password</h4>
                        <div class="row" style="margin-top:20px;">
                            <div class="col-lg-3">
                                <div class="box wow fadeInLeft form-group">
                                    <p class="login_description">Password (min. 8 characters):</p>
                                    <input class="login_input" type="password" name="user_pass" data-rule="minlen:8" data-msg="Please enter at least 8 characters.">
                                    <div class="validation"></div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="box wow fadeInLeft form-group">
                                    <p class="login_description">Confirm Password:</p>
                                    <input class="login_input" type="password" name="user_pass_confirm" data-rule="minlen:8" data-msg="Please enter at least 8 characters.">
                                    <div class="validation"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Address Information -->
                        <h4>Address Information</h4>
                        <div class="row" style="margin-top:20px;">
                            <div class="col-lg-3">
                                <div class="box wow fadeInLeft form-group">
                                    <p class="login_description">Address:</p>
                                    <textarea class="login_input" type="text" name="user_address" data-rule="required" data-msg="This field is required."></textarea>
                                    <div class="validation"></div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="box wow fadeInLeft form-group">
                                    <p class="login_description">City:</p>
                                    <input class="login_input" type="text" name="user_city" data-rule="required" data-msg="This field is required.">
                                    <div class="validation"></div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="box wow fadeInLeft form-group">
                                    <p class="login_description">Zip Code:</p>
                                    <input class="login_input" type="text" name="user_zipcode" data-rule="required" data-msg="This field is required.">
                                    <div class="validation"></div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-lg-10">
                                <div class="box wow fadeInLeft">
                                    <input class="signUpButton" type="submit" value="Register">
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