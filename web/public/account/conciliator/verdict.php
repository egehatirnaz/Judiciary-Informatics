<?php
    include '../../db_connection.php';
    if(!isLoggedIn(4)){
        header("Location: ../../login.php");
        die();
    }

    $userID = $_SESSION['credentials']['user_id'];
    $msg = "";

    // Get the case ID from the post array
    if(isset($_GET['caseID']) && is_numeric($_GET['caseID'])){
        $caseID = intval($_GET['caseID']);

        // Check if the case belongs to user
        $query = "SELECT * FROM Lawsuit WHERE `id` = '$caseID' AND `conciliator_id` = '$userID'";
        if ($result = mysqli_query($db,$query)){
            $count = mysqli_num_rows($result);
            if ($count == 1) {
                // Case belongs to user.
                $query = "SELECT * FROM Lawsuit WHERE (`id` = '$caseID' AND `current_status` = '3')";
                if ($result = mysqli_query($db,$query)){
                    $count = mysqli_num_rows($result);
                    if ($count == 1) {
                        // Case is open for verdict.
                        $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
                        
                        if ($_SERVER['REQUEST_METHOD'] === 'POST' ){
                            // Validate the inputs.
                            if(isset(
                                $_POST['final_decision']
                            )){
                                // Secure the inputs.
                                $final_decision = mysqli_real_escape_string($db, $_POST['final_decision']);
                                $finalization_date = time();

                                // Update the lawsuit.
                                $query = "UPDATE Lawsuit SET 
                                `current_status` = '1',
                                `finalization_date` = '$finalization_date',
                                `final_decision` = '$final_decision'
                                WHERE `id` = $caseID AND `conciliator_id` = $userID LIMIT 1";

                                if (mysqli_query($db, $query)) {
                                    $msg = "Success! Case is settled.";
                                    echo '<script>alert("' . $msg . '");window.location.replace("cases.php");</script>';
                                } else {
                                    $msg = "Error! Invalid entry." . mysqli_error($db) . "";
                                    die($msg);
                                }
                            }
                        }
                    } else {
                        $msg = "Error! This case is not available for settlement.";
                        die($msg);
                    }
                } else {
                    // Case is not open.
                    $msg = "Error! Case could not be found.";
                    die($msg);
                }
            } else {
                // Case does not belong to user.
                $msg = "Error! This is not your case. Go home.";
                die($msg);
            }
        }
    } else {
        header("Location: ../../index.php");
        die();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>NJIS - Settle The Case</title>
    <meta name="description"
        content="Settle The Case - National Judiciary Informatics System">
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
        <section>
            <div class="container" style="margin-top:40px;">
                <div class="section-header">
                    <h2>End The Case #<?php echo $caseID;?></h2>
                    <p>Please fill the following input for the <b>final decision</b> regarding the settlement. This case will be closed after the final decision.</p>
                </div>
                <div class="card-display" style="margin-top:0px;">
                    <h4 style="margin-bottom:0;">Final Decision</h4><br>
                    <div class="form">
                        <form action="verdict.php?caseID=<?php echo $caseID; ?>" method="POST" role="form" class="contactForm">
                            <div class="row" id="conciliator-display">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <textarea class="login_input" type="text" name="final_decision" style="width:100%;min-height:200px;" data-rule="required" data-msg="This field is required."></textarea>
                                        <div class="validation"></div>
                                    </div>
                                    <div class="">
                                        <input class="signUpButton" type="submit" value="Close The Case" style="width:100%;">
                                    </div>
                                </div>
                            </div>
                        </form>
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