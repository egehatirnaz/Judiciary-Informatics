<?php
    include '../../db_connection.php';
    if(!isLoggedIn(2)){
        header("Location: ../../login.php");
        die();
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>NJIS - Judge Account Manager</title>
    <meta name="description"
        content="Manage your judge account - National Judiciary Informatics System">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="../../img/favicon.png" rel="icon">
    <link href="../../img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,700,700i|Raleway:300,400,500,700,800|Montserrat:300,400,700" rel="stylesheet">

    <!-- Bootstrap CSS File -->
    <link href="../../lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Libraries CSS Files -->
    <link href="../../lib/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="../../lib/animate/animate.min.css" rel="stylesheet">
    <link href="../../lib/ionicons/css/ionicons.min.css" rel="stylesheet">
    <link href="../../lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="../../lib/magnific-popup/magnific-popup.css" rel="stylesheet">
    <link href="../../lib/ionicons/css/ionicons.min.css" rel="stylesheet">

    <!-- Main Stylesheet File -->
    <link href="../../css/style.css" rel="stylesheet">
    <style>
        .login_description{
            margin:0;
            margin-bottom: 5px;
        }
        .login_input{
            margin-bottom:20px;
            width:100%;
        }
        .lawsuit-option{
            padding-left:0px;
        }
        textarea{
            margin-bottom:20px;
            width:100%;
            height:100px;
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
            </div>

            <nav id="nav-menu-container">
                <ul class="nav-menu">
                    <li><a href="cases.php">My Cases</a></li>
                    <li><a href="trials.php">Trials</a></li>
                    <li><a href="conciliators.php">Conciliators</a></li>
                    <li class="menu-has-children menu-active"><a>Account - Judge User Userson</a>
                        <ul>
                            <li class="menu-active"><a href="manage.php">Manage Account</a></li>
                            <li><a href="/logout.php">Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </nav><!-- #nav-menu-container -->
        </div>
    </header><!-- #header -->

    <main id="main">

        <!--==========================
      Services Section
    ============================-->
        <section>
            <div class="container" style="margin-top:40px;">
                <div class="section-header">
                    <h2>Manage Account Information</h2>
                    <p>You can update your account information shown in the following fields.</p>
                </div>
                <div class="form">
                    <form action="" method="POST" role="form" class="contactForm">
                        <h4>Citizen Information (Not Changable)</h4>
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="box wow fadeInLeft form-group">
                                    <p class="login_description">Surname:</p>
                                    <input class="login_input" type="text" name="user_surname" disabled>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="box wow fadeInLeft form-group">
                                    <p class="login_description">Name:</p>
                                    <input class="login_input" type="text" name="user_name" disabled>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="box wow fadeInLeft form-group">
                                    <p class="login_description">ID:</p>
                                    <input class="login_input" type="text" name="user_id" disabled>
                                </div>
                            </div>
                        </div>
                        <h4>Personal Information</h4>
                        <div class="row">
                            <div class="col-lg-3">
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
                        <h4>Address Information</h4>
                        <div class="row" style="margin-top:20px;">
                            <div class="col-lg-3">
                                <div class="box wow fadeInLeft form-group" style="margin-bottom:0px;">
                                    <p class="login_description">Address:</p>
                                    <textarea class="login_input" type="text" name="user_address" data-rule="required" data-msg="This field is required." style="height:124px;"></textarea>
                                    <div class="validation"></div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="box wow fadeInLeft form-group">
                                    <p class="login_description">City:</p>
                                    <input class="login_input" type="text" name="user_city" data-rule="required" data-msg="This field is required.">
                                    <div class="validation"></div>
                                </div>
                                <div class="box wow fadeInLeft form-group">
                                    <p class="login_description">Zip Code:</p>
                                    <input class="login_input" type="text" name="user_zipcode" data-rule="required" data-msg="This field is required.">
                                    <div class="validation"></div>
                                </div>
                            </div>
                        </div>
                        <h4>Update Password</h4>
                        <div class="row">
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
                        <div class="row" style="margin-bottom:50px;">
                            <div class="col-lg-6">
                                <div class="box wow fadeInLeft">
                                    <input class="signUpButton" type="submit" value="Form" style="width:100%;">
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
    <script src="../../lib/jquery/jquery.min.js"></script>
    <script src="../../lib/jquery/jquery-migrate.min.js"></script>
    <script src="../../lib/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../../lib/easing/easing.min.js"></script>
    <script src="../../lib/superfish/hoverIntent.js"></script>
    <script src="../../lib/superfish/superfish.min.js"></script>
    <script src="../../lib/wow/wow.min.js"></script>
    <script src="../../lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="../../lib/magnific-popup/magnific-popup.min.js"></script>
    <script src="../../lib/sticky/sticky.js"></script>

    <!-- Contact Form JavaScript File -->
    <script src="../../contactform/contactform.js"></script>

    <!-- Template Main Javascript File -->
    <script src="../../js/main.js"></script>

</body>

</html>
