<?php
    include '../../db_connection.php';
    if(!isLoggedIn(3)){
        header("Location: ../../login.php");
        die();
    }

    $userID = $_SESSION['credentials']['user_id'];
    $msg = "";
    
    // Get the case ID from the post array
    if(isset($_GET['caseID']) && is_numeric($_GET['caseID'])){
        $caseID = intval($_GET['caseID']);
        
        // Check the availability.
        $query = "SELECT * FROM Lawsuit 
                WHERE `id` = '$caseID' AND `current_status` = '2'";
        if ($result = mysqli_query($db,$query)){
            $count = mysqli_num_rows($result);
            if ($count == 1) {
                // Case is available.

                // Update the lawsuit.
                $query = "UPDATE Lawsuit SET 
                `filed_lawyer_id` = '$userID',
                `current_status` = '0'
                WHERE `id` = $caseID LIMIT 1";

                if (mysqli_query($db, $query)) {
                    $msg = "Success! Case is now yours.";
                    echo '<script>alert("' . $msg . '");window.location.replace("cases.php");</script>';
                } else {
                    $msg = "Error! Invalid entry." . mysqli_error($db) . "";
                    die($msg);
                }        
            } else {
                // Case does not belong to user.
                $msg = "Error! Case is not available";
                die($msg);
            }
        }
    } else {
        header("Location: ../../index.php");
        die();
    }
?>