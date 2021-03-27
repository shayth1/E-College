<?php
require '../../assets/setup/db.inc.php';
$pid = $_GET['pid'];
$by = $_GET['pby'];
echo $pid;
echo $by;

$qurey = "DELETE FROM postst WHERE post_id = $pid AND post_by = $by";
$deleteUser = mysqli_query($conn, $qurey);
if ($deleteUser) {
    header("Location: ../");
} else {
    echo "a7a";
}