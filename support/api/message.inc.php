<?php
require '../../assets/setup/db.inc.php';
if (isset($_POST['sendMessage'])) {
    $touser = "admin";
    $atdate = date("Y/m/d h:ia");
    $from = $_POST['from'];
    $message = $_POST['message'];

    // add new order
    $qry = "INSERT INTO messages (messagefrom, messageto, messagedate, messagetext)
        VALUES('$from', '$touser', '$atdate', '$message')";
    $addm = mysqli_query($conn, $qry);
    if ($addm) {
        header("Location: ../");
    } else {
        echo '<div class="alert alert-danger" role="alert">
                    Oops! Someting went wrong please try again or contact with system admin to solve it 
                </div> ';
    }
}