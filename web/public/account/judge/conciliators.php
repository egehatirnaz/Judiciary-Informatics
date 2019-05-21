<?php
    include '../../db_connection.php';
    if(!isLoggedIn(2)){
        header("Location: ../../login.php");
        die();
    }

    $userID = $_SESSION['credentials']['user_id'];

    // Get the case ID from the post array
    if(isset($_GET['caseID']) && is_numeric($_GET['caseID'])){
        $caseID = intval($_GET['caseID']);
        $suitableConciliators = [];
        // Check if the case belongs to user
        $query = "SELECT * FROM Lawsuit WHERE `id` = '$caseID' AND `judge_id` = '$userID'";
        if ($result = mysqli_query($db,$query)){
            $count = mysqli_num_rows($result);
            // If count is 1, user exists.
            if ($count == 1) {
                // Case belongs to user.

                // Get the (lowercase) category for that case
                $caseCategory = "n/a";
                $query = "SELECT case_category FROM Lawsuit WHERE `id` = '$caseID' AND `current_status` != '1'";
                if ($result = mysqli_query($db,$query)){
                    $count = mysqli_num_rows($result);
                    // If count is 1, case exists.
                    if ($count == 1) {
                        $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
                        $regularCategory = $row['case_category'];
                        $caseCategory = strtolower($row['case_category']);
                        
                        // Obtain suitable conciliators for a given category
                        $query = "SELECT c.* , u.citizen_no AS conciliatorID, u.name AS name, u.surname AS surname FROM Conciliator c
                                INNER JOIN User u 
                                ON c.user_id = u.id
                                WHERE lower(`expertise`) = '$caseCategory'";
                        if ($result = mysqli_query($db,$query)){
                            $count = mysqli_num_rows($result);
                            // If they exist...
                            if ($count > 0) {
                                while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)){
                                    array_push($suitableConciliators, $row);
                                }
                            }
                        }

                    } else {
                        $msg = "Error! Case could not be found.";
                        die($msg);
                    }
                }
            } else {
                // Case does not belong to user.
                $msg = "Error! This is not your case. Go home.";
                die($msg);
            }
        }
    } else {
        //header("Location: ../../index.php");
        die();
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>NJIS - Choose Conciliator for Your Case</title>
    <meta name="description"
        content="Choose a suitable conciliator - National Judiciary Informatics System">
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
                    <li><a href="trials.php">Trials</a></li>
                    <li class="menu-has-children"><a>Account - Judge <?php echo getUsername($db);?></a>
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
                    <h2>Choose A Suitable Conciliator for Case #<?php echo $caseID;?></h2>
                    <p>You can choose the following conciliators for <b><?php echo $regularCategory; ?></b> type of cases such as this case:</p>
                </div>
                <div class="card-display" style="margin-top:0px;">
                    <h4>Suitable Conciliators</h4><br>
                    <div class="row" id="conciliator-display">
                        <?php 
                            if(count($suitableConciliators) > 0){
                                foreach($suitableConciliators as $user){
                                    echo '
                                    <div class="col-lg-5">
                                        <div class="box wow fadeInLeft lawsuit-option">
                                            <div class="icon"><i class="fas fa-user"></i></div>
                                            <h4 class="title"><a href="">'.$user['name']." ".$user['surname'].'</a></h4>
                                            <p class="description">
                                            Citizen ID: <a href="#">'.$user['conciliatorID'].'</a><br>
                                            Expertise: ' . $user['expertise'] . '<br>Rating: ' . $user['rating'] . '<br>
                                            </p><br>
                                            <a href="#">Choose as a Conciliator</a><br>
                                        </div>
                                    </div>
                                    ';
                                }
                            } else {
                                echo '<div class="col-lg-5"><p>No suitable conciliators found for this case.</p></div>';
                            }
                        ?>
                        
                        <!--
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
