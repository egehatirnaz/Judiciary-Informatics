<?php
include '../../db_connection.php';
if (!isLoggedIn(1)) {
    header("Location: ../../login.php");
    die();
}

$userID = $_SESSION['credentials']['user_id'];

// Get user details for populating the input fields with existing data.
$query = "SELECT * FROM User WHERE `id` = '$userID'";
if ($result = mysqli_query($db, $query)) {
    $count = mysqli_num_rows($result);
    // If count is 1, user exists.
    if ($count == 1) {
        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        $citizen_no = $row['citizen_no'];
        $name = $row['name'];
        $surname = $row['surname'];
        $phone_no = $row['phone_no'];
        $email_address = $row['email_address'];
        $address = $row['address'];
        $city = $row['city'];
        $zip_code = $row['zip_code'];
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userID = $_SESSION['credentials']['user_id'];
    $msg = "";
    // Check the current password control.
    $unhashed_pass = mysqli_real_escape_string($db, $_POST['password']);
    $pass = hash_pass($unhashed_pass, $citizen_no);
    $query = "SELECT id FROM User WHERE `id` = '$userID' AND `password` = '$pass'";
    if ($result = mysqli_query($db, $query)) {
        $count = mysqli_num_rows($result);
        // If count is 1, user exists.
        if ($count == 1) {
            // Validate the inputs.
            if (isset($userID,
            $_POST['phone_no'],
            $_POST['email_address'],
            $_POST['address'],
            $_POST['city'],
            $_POST['zip_code'])){
                // Secure the inputs.
                $new_phone_no = mysqli_real_escape_string($db, $_POST['phone_no']);
                $new_email_address = mysqli_real_escape_string($db, $_POST['email_address']);
                $new_address = mysqli_real_escape_string($db, $_POST['address']);
                $new_city = mysqli_real_escape_string($db, $_POST['city']);
                $new_zip_code = mysqli_real_escape_string($db, $_POST['zip_code']);
                
                if (!empty($_POST['new_password']) && !empty($_POST['new_password_confirm'])) {
                    // The user wants to change their password as well.
                    // Check if they match:
                    if ($_POST['new_password'] == $_POST['new_password_confirm']) {
                        $new_password = hash_pass(mysqli_real_escape_string($db, $_POST['new_password']), $citizen_no);

                        // Query is relevant to pass change.
                        $query = "UPDATE User SET 
                                `password` = '$new_password',
                                `phone_no` = '$new_phone_no',
                                `email_address` = '$new_email_address',
                                `address` = '$new_address',
                                `city` = '$new_city',
                                `zip_code` = '$new_zip_code' 
                            WHERE `id` = $userID";
                    } else {
                        $msg = "Error! New password and its confirmation doesn't match.";
                        echo $msg . '';
                        echo '<script>alert("' . $msg . '");</script>';
                    }
                } else {
                    // Insert the new data.
                    $query = "UPDATE User SET 
                                `phone_no` = '$new_phone_no',
                                `email_address` = '$new_email_address',
                                `address` = '$new_address',
                                `city` = '$new_city',
                                `zip_code` = '$new_zip_code' 
                            WHERE `id` = $userID";
                }

                // Proceed as normal.
                if (mysqli_query($db, $query)) {
                    $msg = "Success! Your information is updated.";
                    echo '<script>alert("' . $msg . '");window.location.replace("manage.php");</script>';
                } else {
                    $msg = "Error! Invalid entry." . mysqli_error($db) . "";
                    echo '<script>alert("' . $msg . '");</script>';
                }
            } else {
                $msg = "Error! Invalid password and user.";
                echo '<script>alert("' . $msg . '");</script>';
            }
        }
    } else {
        $msg = "Error! Invalid password.";
        echo '<script>alert("' . $msg . '");</script>';
        var_dump(mysqli_error($db));
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>NJIS - User Account Manager</title>
    <meta name="description" content="Manage your user account - National Judiciary Informatics System">
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
        .login_description {
            margin: 0;
            margin-bottom: 5px;
        }

        .login_input {
            margin-bottom: 20px;
            width: 100%;
        }

        .lawsuit-option {
            padding-left: 0px;
        }

        textarea {
            margin-bottom: 20px;
            width: 100%;
            height: 100px;
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
                    <li><a href="request.php">Request a New Lawsuit</a></li>
                    <li class="menu-has-children menu-active"><a>Account - User Userson</a>
                        <ul>
                            <li class="menu-active"><a href="#">Manage Account</a></li>
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
                                    <input class="login_input" type="text" name="surname" <?php echo 'value="' . $surname . '"'; ?> disabled>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="box wow fadeInLeft form-group">
                                    <p class="login_description">Name:</p>
                                    <input class="login_input" type="text" name="name" <?php echo 'value="' . $name . '"'; ?> disabled>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="box wow fadeInLeft form-group">
                                    <p class="login_description">ID:</p>
                                    <input class="login_input" type="text" name="citizen_no" <?php echo 'value="' . $citizen_no . '"'; ?> disabled>
                                </div>
                            </div>
                        </div>
                        <h4>Personal Information</h4>
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="box wow fadeInLeft form-group">
                                    <p class="login_description">E-mail:</p>
                                    <input class="login_input" type="text" name="email_address" <?php echo 'value="' . $email_address . '"'; ?> data-rule="email" data-msg="Please enter a valid email.">
                                    <div class="validation"></div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="box wow fadeInLeft form-group">
                                    <p class="login_description">Phone Number:</p>
                                    <input class="login_input" type="text" name="phone_no" <?php echo 'value="' . $phone_no . '"'; ?> data-rule="required" data-msg="This field is required.">
                                    <div class="validation"></div>
                                </div>
                            </div>
                        </div>
                        <h4>Address Information</h4>
                        <div class="row" style="margin-top:20px;">
                            <div class="col-lg-3">
                                <div class="box wow fadeInLeft form-group" style="margin-bottom:0px;">
                                    <p class="login_description">Address:</p>
                                    <textarea class="login_input" type="text" name="address" data-rule="required" data-msg="This field is required." style="height:124px;"><?php echo $address . ''; ?></textarea>
                                    <div class="validation"></div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="box wow fadeInLeft form-group">
                                    <p class="login_description">City:</p>
                                    <input class="login_input" type="text" name="city" <?php echo 'value="' . $city . '"'; ?> data-rule="required" data-msg="This field is required.">
                                    <div class="validation"></div>
                                </div>
                                <div class="box wow fadeInLeft form-group">
                                    <p class="login_description">Zip Code:</p>
                                    <input class="login_input" type="text" name="zip_code" <?php echo 'value="' . $zip_code . '"'; ?> data-rule="required" data-msg="This field is required.">
                                    <div class="validation"></div>
                                </div>
                            </div>
                        </div>
                        <h4>Update Password</h4>
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="box wow fadeInLeft form-group">
                                    <p class="login_description">Password (min. 8 characters):</p>
                                    <!--input class="login_input" type="password" name="new_password" data-rule="minlen:8" data-msg="Please enter at least 8 characters."-->
                                    <input class="login_input" type="password" name="new_password">
                                    <div class="validation"></div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="box wow fadeInLeft form-group">
                                    <p class="login_description">Confirm Password:</p>
                                    <!--input class="login_input" type="password" name="new_password_confirm" data-rule="minlen:8" data-msg="Please enter at least 8 characters."-->
                                    <input class="login_input" type="password" name="new_password_confirm">
                                    <div class="validation"></div>
                                </div>
                            </div>
                        </div>
                        <h4>Please enter your current password to confirm the changes.</h4>
                        <div class="row">
                            <div class="col-lg-3">
                                <div class="box wow fadeInLeft form-group">
                                    <p class="login_description">Current Password:</p>
                                    <input class="login_input" type="password" name="password" data-rule="minlen:8" data-msg="Please enter at least 8 characters.">
                                    <div class="validation"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="margin-bottom:50px;">
                            <div class="col-lg-6">
                                <div class="box wow fadeInLeft">
                                    <input class="signUpButton" type="submit" value="Update" style="width:100%;">
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