<?php
    include '../../db_connection.php';
    if(!isLoggedIn(3)){
        header("Location: ../../login.php");
        die();
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>NJIS - Lawyer Trials</title>
    <meta name="description"
        content="See your existing cases - National Judiciary Informatics System">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="../../img/favicon.png" rel="icon">
    <link href="../../img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,700,700i|Raleway:300,400,500,700,800|Montserrat:300,400,700" rel="stylesheet">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
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
        }
        .lawsuit-option{
            padding-left:0px;
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
                    <li><a href="formlawsuit.php">Form A Lawsuit</a></li>
                    <li><a href="possiblecases.php">Possible Cases</a></li>
                    <li class="menu-active"><a href="">Trials</a></li>
                    <li class="menu-has-children"><a>Account - Attn. User Userson</a>
                        <ul>
                            <li><a href="manage.php">Manage Account</a></li>
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
        <section id="services">
            <div class="container" style="margin-top:40px;">
                <div class="section-header">
                    <h2>Trials</h2>
                    <p>In order to see detailed information, please click on each trial. </p>
                </div>
                <div class="lawsuit-category">
                    <a href="#">Ongoing</a> | <a href="#">Previous</a>
                </div>
                <div class="card-display" style="margin-top:0px;">
                    <h4>Ongoing Trials</h4>
                    <div class="row" id="case-display">
                        <div class="col-lg-4">
                            <div class="box wow fadeInLeft lawsuit-option">
                                <div class="icon"><i class="fas fa-landmark"></i></div>
                                <h4 class="title"><a href="">Trial #00001</a></h4>
                                <p class="description">Between: <br> <a href="#">User#0001</a> & <a href="#">User#0002</a></p><br>
                                <a href="#">View Court Room</a><br>
                                <a href="#">Final Verdict</a>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="box wow fadeInLeft lawsuit-option">
                                <div class="icon"><i class="fas fa-landmark"></i></div>
                                <h4 class="title"><a href="">Trial #00002</a></h4>
                                <p class="description">Between: <br> <a href="#">User#0002</a> & <a href="#">User#0003</a></p><br>
                                <a href="#">View Court Room</a><br>
                                <a href="#">Final Verdict</a>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="box wow fadeInLeft lawsuit-option">
                                <div class="icon"><i class="fas fa-landmark"></i></div>
                                <h4 class="title"><a href="">Trial #00003</a></h4>
                                <p class="description">Between: <br> <a href="#">User#0003</a> & <a href="#">User#0001</a></p><br>
                                <a href="#">View Court Room</a><br>
                                <a href="#">Final Verdict</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-display" style="margin-top:0px;">
                    <h4>Previous Trials</h4>
                    <div class="row" id="closedcase-display">
                        <div class="col-lg-5">
                            <div class="box wow fadeInLeft lawsuit-option">
                                <div class="icon"><i class="fa fa-gavel"></i></div>
                                <h4 class="title"><a href="">[Completed] Trial #00001</a></h4>
                                <p class="description">Between: <br> <a href="#">User#0003</a> & <a href="#">User#0001</a></p><br>
                                <p class="description">Date of Finalization : <a href="#">15.05.2019</a></p><br>
                                <a href="#">See Final Verdict</a><br>
                            </div>
                        </div>
                        <div class="col-lg-5">
                            <div class="box wow fadeInLeft lawsuit-option">
                                <div class="icon"><i class="fa fa-gavel"></i></div>
                                <h4 class="title"><a href="">[Completed] Trial #00002</a></h4>
                                <p class="description">Between: <br> <a href="#">User#0004</a> & <a href="#">User#0002</a></p><br>
                                <p class="description">Date of Finalization : <a href="#">17.05.2019</a></p><br>
                                <a href="#">See Final Verdict</a><br>
                            </div>
                        </div>
                    </div>
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
