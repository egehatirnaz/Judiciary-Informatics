<?php
    include '../../db_connection.php';

    if(!isLoggedIn(1)){
        header("Location: ../../login.php");
        die();
    }

    // Get the existing Courts
    $courts = [];
    $query = "SELECT * FROM Court";
    if ($result = mysqli_query($db,$query)){
        while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)){
            array_push($courts, [$row['id'], $row['name'], $row['city'], $row['district']]);
        }
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' ){
        $msg = "";
    
        // Validate the inputs.
        if(isset(
            $_POST['victim'], 
            $_POST['suspect'],
            $_POST['category'], 
            $_POST['court'],
            $_POST['description']
        )){
            // Secure the inputs.
            $victim_id = mysqli_real_escape_string($db, $_POST['victim']);
            $suspect_id = mysqli_real_escape_string($db, $_POST['suspect']);
            $category = mysqli_real_escape_string($db, $_POST['category']);
            $court_id = mysqli_real_escape_string($db, $_POST['court']);
            $description = mysqli_real_escape_string($db, $_POST['description']);
            $filing_date = time();

            $suspect_query = "SELECT id FROM User WHERE `citizen_no` = '$suspect_id'";
            if ($result = mysqli_query($db,$suspect_query)){
                $count = mysqli_num_rows($result);
                // If count is 1, user exists.
                if ($count == 1) {
                    $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
                    $suspect_id = $row['id'];
                }
            } else {
                $suspect_id = -1;
            }
            $victim_query = "SELECT id FROM User WHERE `citizen_no` = '$victim_id'";
            if ($result = mysqli_query($db,$victim_query)){
                $count = mysqli_num_rows($result);
                // If count is 1, user exists.
                if ($count == 1) {
                    $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
                    $victim_id = $row['id'];
                }
            } else {
                $victim_id = -1;
            }

            $query = "INSERT INTO Lawsuit (
                `description`,
                `filing_date`,
                `case_category`,
                `current_status`,
                `court_id`,
                `judge_id`,
                `filed_lawyer_id`
            )
            VALUES (
                '$description',
                '$filing_date',
                '$category',
                '0',
                '$court_id',
                '12',
                '13'
            )";
            if (mysqli_query($db, $query)) {
                $lawsuit_id = mysqli_insert_id($db);
                $query2 = "INSERT INTO Associated (
                    `lawsuit_id`,
                    `user_id`,
                    `is_victim`,
                    `is_suspect`
                )
                VALUES (
                    '$lawsuit_id',
                    '$victim_id',
                    '1',
                    '0'
                ),(
                    '$lawsuit_id',
                    '$suspect_id',
                    '0',
                    '1'
                )";
                if(mysqli_query($db, $query2)){
                    $msg = "Success! Your new lawsuit is filed for processing.";
                    echo '<script>
                    alert("'.$msg.'");
                    window.location.replace("lawsuits.php");
                    </script>';
                } else {
                    $msg = "Error! Suspect/Victim could not be added." . mysqli_error($db) . "";
                    die($msg);
                }
            } else {
                $msg = "Error! New entry could not be entered to lawsuit database." . mysqli_error($db) . "";
                    die($msg);
            }
        } else {
            $msg = "Error! Invalid entry.";
            die($msg);
        }
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>NJIS - User Lawsuit Request</title>
    <meta name="description"
        content="File a new lawsuit - National Judiciary Informatics System">
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
                <!-- Uncomment below if you prefer to use an image logo -->
                <!-- <a href="#body"><img src="img/logo.png" alt="" title="" /></a>-->
            </div>

            <nav id="nav-menu-container">
                <ul class="nav-menu">
                    <li><a href="lawsuits.php">Lawsuits</a></li>
                    <li class="menu-active"><a href="">Request a New Lawsuit</a></li>
                    <li class="menu-has-children"><a>Account - User Userson</a>
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
        <section>
            <div class="container" style="margin-top:40px;">
                <div class="section-header">
                    <h2>Request a New Lawsuit</h2>
                    <p>Please fill out the information necessary to form a new lawsuit.</p>
                </div>
                <div class="form">
                    <form action="" method="POST" role="form" class="contactForm">
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="box wow fadeInLeft form-group">
                                    <p class="login_description">Victim ID:</p>
                                    <input class="login_input" type="text" name="victim" data-rule="required" data-msg="This field is required.">
                                    <div class="validation"></div>
                                </div>
                                <div class="box wow fadeInLeft form-group">
                                    <p class="login_description">Suspect ID:</p>
                                    <input class="login_input" type="text" name="suspect" data-rule="required" data-msg="This field is required.">
                                    <div class="validation"></div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="box wow fadeInLeft form-group"> <!-- This should be a dropdown. -->
                                    <p class="login_description">Category:</p>
                                    <input class="login_input" type="text" name="category" data-rule="required" data-msg="This field is required.">
                                    <div class="validation"></div>
                                </div>
                                <div class="box wow fadeInLeft form-group"> <!-- This should be a dropdown. -->
                                    <p class="login_description">Court:</p>
                                    <select name="court" style="white-space: normal;" required>
                                        <option value="" selected disabled>Pick a Court</option>
                                        <?php
                                            foreach($courts as $court){
                                                echo '<option value="'.$court[0].'">'.$court[2].' - '.$court[3].' - '.$court[1].'</option>';
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="box wow fadeInLeft form-group">
                                    <p class="login_description">Description:</p>
                                    <textarea class="login_input" type="text" name="description" data-rule="required" data-msg="This field is required."></textarea>
                                    <div class="validation"></div>
                                </div>
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
