<?php
require '../../assets/setup/db.inc.php';
$pid = $_GET['aid'];
$ass = $_GET['ass'];
$qurey = "DELETE FROM submission WHERE sub_id = $pid";
$deleteUser = mysqli_query($conn, $qurey);
if ($deleteUser) {
    header("Location: ../showAssigment.php?id=$ass");
} else {
    echo "a7a";
}