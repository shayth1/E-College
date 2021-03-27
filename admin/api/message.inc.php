<?php
require '../../assets/setup/db.inc.php'; 
if (isset($_POST['sendMessage'])){
        $touser = $_POST['to'];;
        $atdate = date("Y/m/d h:ia"); 
        $from = "admin";
        $message = $_POST['message'];
        
            // add new order
        $qry = "INSERT INTO messages (messagefrom, messageto, messagedate, messagetext)
        VALUES('$from', '$touser', '$atdate', '$message')";
            $addm = mysqli_query($conn, $qry);
            if ($addm){
                header("Location: ../chat.php?id=$touser");
                
                

                }else{
                    echo '<div class="alert alert-danger" role="alert">
                    Oops! Someting went wrong please try again or contact with Good System to solve it 
                </div> ';
                }
            }