<?php
if (isset($_POST['cpost'])) {
    require '../../assets/setup/db.inc.php';
    $title = $_POST['title'];
    $postText = $_POST['postText'];
    $date = date('Y/m/d g:i A');
    $sql = "INSERT INTO informs (inf_date, inf_title, inf_text) VALUES ('$date','$title', '$postText')";
    $addC = mysqli_query($conn, $sql);
    if ($addC) {
        header("Location: ../index.php");
    } else {
        echo "ERROR";
    }
} else {
    header("Location: ../index.php");
}