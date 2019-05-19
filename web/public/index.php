<?php
include 'db_connection.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>National Judiciary Informatics System - Landing Page</title>
    <meta name="description"
        content="Landing page for National Judiciary Informatics System.">
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
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/ionicons/css/ionicons.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="lib/magnific-popup/magnific-popup.css" rel="stylesheet">
    <link href="lib/ionicons/css/ionicons.min.css" rel="stylesheet">

    <!-- Main Stylesheet File -->
    <link href="css/style.css" rel="stylesheet">
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
                    <li class="menu-active"><a href="/">Home</a></li>
                    <li><a href="/login.php">Login</a></li>
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

    <!--==========================
    Intro Section
  ============================-->
    <section id="intro">

        <div class="intro-content">
            <h2><span>Justice</span> is the foundation of the state.<br></h2>
            <div>
                <a href="/register.php" class="btn-get-started scrollto">Sign-up to Get Started</a>
                <a href="/login.php" class="btn-projects scrollto">Login to Continue</a>
            </div>
        </div>

        <div id="intro-carousel" class="owl-carousel">
            <div class="item" style="background-image: url('img/intro-carousel/1.jpg');"></div>
            <div class="item" style="background-image: url('img/intro-carousel/2.jpg');"></div>
            <div class="item" style="background-image: url('img/intro-carousel/3.jpg');"></div>
            <div class="item" style="background-image: url('img/intro-carousel/4.jpg');"></div>
            <div class="item" style="background-image: url('img/intro-carousel/5.jpg');"></div>
        </div>

    </section><!-- #intro -->

    <main id="main">

        <!--==========================
      About Section
    ============================-->
        <section id="about" class="wow fadeInUp">
            <div class="container">
                <div class="row" style="display:flex;justify-content:space-between;">
                    <div class="col-lg-6 content" style="flex-grow: 1;">
                        <h2>Justice has never been easier before!</h2>
                        <h3>With our organized and user-friendly system, the progress of your cases are easily trackable. Here are some of the things that you are able to do:</h3>
                        <ul>
                            <li><i class="ion-android-checkmark-circle"></i> See your existing cases and file a new lawsuit.</li>
                            <li><i class="ion-android-checkmark-circle"></i> Find a conciliator who can resolve your conflict.</li>
                            <li><i class="ion-android-checkmark-circle"></i> Know where and when your trials will be for your ongoing cases.</li>
                            <li><i class="ion-android-checkmark-circle"></i> Learn the final verdict and the result for your case.</li>
                        </ul>
                    </div>
                    <div class="col-lg-3 about-img" style="margin-left:50px;">
                        <img src="img/about-img.png" alt="" style="max-height:300px;">
                    </div>
                </div>

            </div>
        </section><!-- #about -->

        <!--==========================
      Services Section
    ============================-->
        <section id="services">
            <div class="container">
                <div class="section-header">
                    <h2>Services</h2>
                    <p>Your lawsuit will be assigned to various roles. Each role will play a different part in your lawsuit. Learn more below!</p>
                </div>
                <br>
                <div class="row">

                    <div class="col-lg-6">
                        <div class="box wow fadeInLeft">
                            <div class="icon"><i class="fa fa-users"></i></div>
                            <h4 class="title"><a href="">Citizen</a></h4>
                            <p class="description">
                                &bull; Citizens can learn about all cases concerning them.<br>
                                &bull; Citizens are able to file a new lawsuit.<br>
                                &bull; Citizens can assign a conciliator for their cases and negotiate.<br>
                            </p>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="box wow fadeInRight">
                            <div class="icon"><i class="fa fa-landmark"></i></div>
                            <h4 class="title"><a href="">Lawyer</a></h4>
                            <p class="description">
                                &bull; Lawyers can follow their ongoing cases & trials.<br>
                                &bull; Lawyers can file a new lawsuit or find cases to accept.<br>
                                &bull; Lawyers can negotiate with the conciliator assigned to the case.<br>
                            </p>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="box wow fadeInLeft" data-wow-delay="0.2s">
                            <div class="icon"><i class="fa fa-gavel"></i></div>
                            <h4 class="title"><a href="">Judge</a></h4>
                            <p class="description">
                                &bull; Judges can follow their all cases & trials.<br>
                                &bull; Judges can manage or give a verdict to an ongoing trial.<br>
                            </p>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="box wow fadeInRight" data-wow-delay="0.2s">
                            <div class="icon"><i class="fa fa-handshake"></i></div>
                            <h4 class="title"><a href="">Conciliator</a></h4>
                            <p class="description">
                                &bull; Conciliators can follow lawsuits assigned to them.<br>
                                &bull; Conciliators are able to resolve a dispute and end the lawsuit.<br>
                            </p>
                        </div>
                    </div>

                </div>

            </div>
        </section><!-- #services -->
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