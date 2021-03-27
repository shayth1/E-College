<?php

define('TITLE', "Support");
include '../assets/layouts/header.php';
check_verified();

?>

<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="main-box clearfix">
                <div class="table-responsive">
                    <table class="table user-list">
                        <thead>
                            <tr>
                                <th><span>User</span></th>
                                <th><span>Last Message</span></th>

                                <th>&nbsp;</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php


                            $in = "admin";
                            $sql = "SELECT * FROM messages WHERE messagefrom != '$in' GROUP BY messagefrom ORDER BY messagedate  DESC";
                            $stmt = mysqli_stmt_init($conn);
                            if (!mysqli_stmt_prepare($stmt, $sql)) {
                                die('SQL error');
                            } else {
                                mysqli_stmt_execute($stmt);
                                $result = mysqli_stmt_get_result($stmt);

                                while ($row = mysqli_fetch_assoc($result)) {

                                    echo '
                        <tr>
                            <td>
                                <img src="../assets/uploads/users/_defaultUser.png" alt="">
                                <a href="chat.php?id=' . $row['messagefrom'] . '" class="user-link">USER</a>
                                <span class="user-subhead">' . $row['messagetext'] . '</span>
                            </td>
                            <td>
                                ' . $row['messagedate'] . '
                            </td>
                        </tr>';
                                }
                            }
                            ?>


                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>
<?php include '../assets/layouts/footer.php' ?>