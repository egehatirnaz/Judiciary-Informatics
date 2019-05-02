<?php
    include 'db_connection.php';
?>
<!DOCTYPE html>
<html>
    <body>
        <meta charset="utf-8">
        <h1>Page for testing</h1>
        <p>
        <?php
            $query = "SELECT * FROM user";
            if($result = mysqli_query($db, $query)){
                while($row = mysqli_fetch_assoc($result)) {
                    echo "id: " . $row["id"]. " - Name: " . $row["name"]. "<br>";
                }
            } else {
                echo "Something is not right, check the db connection.";
            }
        ?>
        </p>
    </body>
</html>
