<?php 
if (isset($_POST['JOIN'])){
require '../../assets/setup/db.inc.php';
$uniid = $_POST['uniid'];
$jcode = $_POST['code'];
$query = "SELECT class_id FROM classes WHERE class_code = $jcode";
$stmt = mysqli_stmt_init($conn);    
if (!mysqli_stmt_prepare($stmt, $query))
{
    die('SQL error');
} 
else
{
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    while ($row = mysqli_fetch_assoc($result))
    { 
        
        $sql = "INSERT INTO members (m_user, classID) VALUES ($uniid, $row[class_id])";
        $addC = mysqli_query($conn, $sql);
            if($addC){
                header("Location: ../../class/showClass.php?classid=$row[class_id]"); 
        }else{
            echo"ERROR";
        }
    }
}

}else{
    header("Location: ../../logout");
}