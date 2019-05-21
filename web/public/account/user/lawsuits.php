<?php
    include '../../db_connection.php';
    if(!isLoggedIn(1)){
        header("Location: ../../login.php");
        die();
    }

    // Get citizen ID for display purposes.
    $userID = $_SESSION['credentials']['user_id'];
    $query = "SELECT citizen_no FROM User WHERE `id` = '$userID'";
    $result = mysqli_query($db,$query);
    $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
    $userCitizenID = $row['citizen_no'];

    $awaiting_cases = [];
    $query = "SELECT l.* , s.citizen_no AS suspectNo, v.citizen_no AS victimNo FROM Lawsuit l
    INNER JOIN User s 
    ON l.suspect_id = s.id
    INNER JOIN User v 
    ON l.victim_id = v.id 
    WHERE (l.suspect_id = '$userID' OR l.victim_id = '$userID') AND l.current_status = '2'";
    if ($result = mysqli_query($db,$query)){
        $count = mysqli_num_rows($result);
        if ($count > 0) {
            while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)){
                array_push($awaiting_cases, $row);
            }
        }
    }

    $ongoing_cases = [];
    $query = "SELECT l.* , s.citizen_no AS suspectNo, v.citizen_no AS victimNo FROM Lawsuit l
    INNER JOIN User s 
    ON l.suspect_id = s.id
    INNER JOIN User v 
    ON l.victim_id = v.id 
    WHERE (l.suspect_id = '$userID' OR l.victim_id = '$userID') AND l.current_status = '0'";
    if ($result = mysqli_query($db,$query)){
        $count = mysqli_num_rows($result);
        if ($count > 0) {
            while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)){
                array_push($ongoing_cases, $row);
            }
        }
    }
    $previous_cases = [];
    $query = "SELECT l.* , s.citizen_no AS suspectNo, v.citizen_no AS victimNo FROM Lawsuit l
    INNER JOIN User s 
    ON l.suspect_id = s.id
    INNER JOIN User v 
    ON l.victim_id = v.id 
    WHERE (l.suspect_id = '$userID' OR l.victim_id = '$userID') AND l.current_status = '1'";
    if ($result = mysqli_query($db,$query)){
        $count = mysqli_num_rows($result);
        if ($count > 0) {
            while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)){
                array_push($previous_cases, $row);
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>NJIS - User Lawsuits</title>
    <meta name="description"
        content="See your existing lawsuits - National Judiciary Informatics System">
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
                <!-- Uncomment below if you prefer to use an image logo -->
                <!-- <a href="#body"><img src="img/logo.png" alt="" title="" /></a>-->
            </div>

            <nav id="nav-menu-container">
                <ul class="nav-menu">
                    <li class="menu-active"><a href="">Lawsuits</a></li>
                    <li><a href="request.php">Request a New Lawsuit</a></li>
                    <li class="menu-has-children"><a>Account - <?php echo getUsername($db);?></a>
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
                    <h2>My Lawsuits</h2>
                    <p>Your ongoing and previous case details are shown below:</p>
                </div>
                <div class="lawsuit-category">
                    <a href="#requested-lawsuit-display">Requested</a> |<a href="#lawsuit-display">Ongoing</a> | <a href="#closedlawsuit-display">Previous</a>
                </div>
                <div class="card-display" style="margin-top:50px;">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="box wow fadeInLeft lawsuit-option" style="cursor:pointer" onclick="document.location='request.php'">
                                <div class="icon"><i class="fa fa-plus-circle"></i></div>
                                <h4 class="title"><a href="">Request a Lawsuit</a></h4>
                                <p class="description">Fill out a form to request a new lawsuit.</p>
                            </div>
                        </div>
                    </div>
                    <h4>Requested Cases</h4>
                    <div class="row" id="requested-lawsuit-display">
                        <?php
                        foreach($awaiting_cases as $oc){
                            if($userCitizenID == $oc['victimNo']){
                                echo '
                                <div class="col-lg-5">
                                    <div class="box wow fadeInLeft lawsuit-option">
                                        <div class="icon"><i class="fa fa-balance-scale"></i></div>
                                        <h4 class="title"><a href="">Case #'.$oc['id'].'</a></h4>
                                        <p class="description">
                                        <b>Victim ID: <a href="#">'.$oc['victimNo'].'</a></b><br>
                                        Suspect ID: <a href="#">'.$oc['suspectNo'].'</a><br>
                                        Description: '.$oc['description'].'<br>
                                        <b>Awaiting for a Lawyer action.</b><br><br>
                                        </p>
                                    </div>
                                </div>
                                ';
                            } else if($userCitizenID == $oc['suspectNo']){
                                echo '
                                <div class="col-lg-5">
                                    <div class="box wow fadeInLeft lawsuit-option">
                                        <div class="icon"><i class="fa fa-balance-scale"></i></div>
                                        <h4 class="title"><a href="">Case #'.$oc['id'].'</a></h4>
                                        <p class="description">
                                        Victim ID: <a href="#">'.$oc['victimNo'].'</a><br>
                                        <b>Suspect ID: <a href="#">'.$oc['suspectNo'].'</a></b><br>
                                        Description: '.$oc['description'].'<br>
                                        <b>Awaiting for a Lawyer action.</b><br><br>
                                        </p>
                                    </div>
                                </div>
                                ';
                            }
                        }
                        ?>
                    </div>
                    <h4>Ongoing Cases</h4>
                    <div class="row" id="lawsuit-display">
                        <?php
                        foreach($ongoing_cases as $oc){
                            if($userCitizenID == $oc['victimNo']){
                                echo '
                                <div class="col-lg-5">
                                    <div class="box wow fadeInLeft lawsuit-option">
                                        <div class="icon"><i class="fa fa-balance-scale"></i></div>
                                        <h4 class="title"><a href="">Case #'.$oc['id'].'</a></h4>
                                        <p class="description">
                                        <b>Victim ID: <a href="#">'.$oc['victimNo'].'</a></b><br>
                                        Suspect ID: <a href="#">'.$oc['suspectNo'].'</a><br>
                                        Description: '.$oc['description'].'<br><br>
                                        </p>
                                        <a href="#">Negotiate with Conciliator</a><br>
                                    </div>
                                </div>
                                ';
                            } else if($userCitizenID == $oc['suspectNo']){
                                echo '
                                <div class="col-lg-5">
                                    <div class="box wow fadeInLeft lawsuit-option">
                                        <div class="icon"><i class="fa fa-balance-scale"></i></div>
                                        <h4 class="title"><a href="">Case #'.$oc['id'].'</a></h4>
                                        <p class="description">
                                        Victim ID: <a href="#">'.$oc['victimNo'].'</a><br>
                                        <b>Suspect ID: <a href="#">'.$oc['suspectNo'].'</a></b><br>
                                        Description: '.$oc['description'].'<br><br>
                                        </p>
                                        <a href="#">Negotiate with Conciliator</a><br>
                                    </div>
                                </div>
                                ';
                            }
                        }
                        ?>
                    </div>
                    <div class="card-display" style="margin-top:0px;">
                        <h4>Previous Cases</h4>
                        <div class="row" id="closedlawsuit-display">
                        <?php
                        foreach($previous_cases as $oc){
                            if($userCitizenID == $oc['victimNo']){
                                echo '
                                <div class="col-lg-5">
                                    <div class="box wow fadeInLeft lawsuit-option">
                                        <div class="icon"><i class="fa fa-balance-scale"></i></div>
                                        <h4 class="title"><a href="">Case #'.$oc['id'].'</a></h4>
                                        <p class="description">
                                        Date of Finalization: '.date("d.m.Y  H:i",$oc['finalization_date']).'<br><br>
                                        <b>Victim ID: <a href="#">'.$oc['victimNo'].'</a></b><br>
                                        Suspect ID: <a href="#">'.$oc['suspectNo'].'</a><br>
                                        Description: '.$oc['description'].'<br><br>
                                        </p>
                                        <a href="#">See Final Verdict</a><br>
                                    </div>
                                </div>
                                ';
                            } else if($userCitizenID == $oc['suspectNo']){
                                echo '
                                <div class="col-lg-5">
                                    <div class="box wow fadeInLeft lawsuit-option">
                                        <div class="icon"><i class="fa fa-balance-scale"></i></div>
                                        <h4 class="title"><a href="">Case #'.$oc['id'].'</a></h4>
                                        <p class="description">
                                        Date of Finalization: '.date("d.m.Y  H:i",$oc['finalization_date']).'<br><br>
                                        Victim ID: <a href="#">'.$oc['victimNo'].'</a><br>
                                        <b>Suspect ID: <a href="#">'.$oc['suspectNo'].'</a></b><br>
                                        Description: '.$oc['description'].'<br><br>
                                        </p>
                                        <a href="#">See Final Verdict</a><br>
                                    </div>
                                </div>
                                ';
                            }
                        }
                        ?>
                        <!--
                        <div class="col-lg-5">
                            <div class="box wow fadeInLeft lawsuit-option">
                                <div class="icon"><i class="fa fa-gavel"></i></div>
                                <h4 class="title"><a href="">Lawsuit #00001</a></h4>
                                <p class="description">Against: <a href="#">User#0001</a></p><br>
                                <a href="#">Assign Conciliator</a><br>
                                <a href="#">Negotiate With Conciliator</a>
                            </div>
                        </div>
                        <div class="col-lg-5">
                            <div class="box wow fadeInLeft lawsuit-option">
                                <div class="icon"><i class="fa fa-gavel"></i></div>
                                <h4 class="title"><a href="">Lawsuit #00002</a></h4>
                                <p class="description">Against: <a href="#">User#0002</a></p><br>
                                <a href="#">Assign Conciliator</a><br>
                                <a href="#">Negotiate With Conciliator</a>
                            </div>
                        </div>
                        <div class="col-lg-5">
                            <div class="box wow fadeInLeft lawsuit-option">
                                <div class="icon"><i class="fa fa-gavel"></i></div>
                                <h4 class="title"><a href="">Lawsuit #00003</a></h4>
                                <p class="description">Against: <a href="#">User#0003</a></p><br>
                                <a href="#">Assign Conciliator</a><br>
                                <a href="#">Negotiate With Conciliator</a>
                            </div>
                        </div>
                        -->
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
