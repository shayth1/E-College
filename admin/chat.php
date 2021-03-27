<?php

define('TITLE', "Support");
include '../assets/layouts/header.php';
check_verified();

if (isset($_GET['id'])) {

    $userid = $_GET['id'];
} else {
    $userid = $_SESSION['id'];
}

?>

<main>
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
    <div class="container">
        <div class="panel messages-panel">

            <div class="tab-content">
                <div class="tab-pane message-body active" id="inbox-message-1">

                    <div class="message-chat">
                        <div class="chat-body">


                            <?php

                            $sender = "USER";
                            $in = "admin";
                            $sql = "SELECT * FROM messages WHERE messagefrom = '$userid' OR messageto = '$userid' ORDER BY messagedate ASC";
                            $stmt = mysqli_stmt_init($conn);
                            if (!mysqli_stmt_prepare($stmt, $sql)) {
                                die('SQL error');
                            } else {
                                mysqli_stmt_execute($stmt);
                                $result = mysqli_stmt_get_result($stmt);

                                while ($row = mysqli_fetch_assoc($result)) {
                                    if ($row['messagefrom'] == $in) {
                                        echo '
                                    <div class="message info">
                                            <img alt="" class="img-circle medium-image" src="../assets/images/logo.png">

                                            <div class="message-body">
                                                <div class="message-info">
                                                    <h4> E-College </h4>
                                                    <h5> <i class="fa fa-clock-o"></i> ' . $row['messagedate'] . ' </h5>
                                                </div>
                                                <hr>
                                                <div class="message-text">
                                                ' . $row['messagetext'] . '
                                                </div>
                                            </div>
                                            <br>
                                        </div>
                                        ';
                                    } else {
                                        echo '
                                            <div class="message my-message">
                                            <img alt="" class="img-circle medium-image" src="../assets/uploads/users/_defaultUser.png">

                                            <div class="message-body">
                                                <div class="message-body-inner">
                                                    <div class="message-info">
                                                    <a href="../timeline/index.php?userid=' . $userid . '">
                                                        <h6> ' . $sender . ' </h6>
                                                        </a>
                                                        <h5> <i class="fa fa-clock-o"></i> ' . $row['messagedate'] . ' </h5>
                                                    </div>
                                                    <hr>
                                                    <div class="message-text">
                                                    ' . $row['messagetext'] . '
                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                        </div>
                                            ';
                                    }
                                }
                            }
                            ?>



                        </div>

                        <div class="chat-footer">
                            <form action="api/message.inc.php" method="post">
                                <input type="text" name="to" value="<?php echo $userid; ?>" style="display: none;">
                                <textarea required placeholder="type someting " name="message"
                                    class="send-message-text"></textarea>
                                <!-- <label class="upload-file">
                            <input type="file" required="">
                            <i class="fa fa-paperclip"></i>
                        </label> -->
                                <button type="submit" name="sendMessage" class="send-message-button btn-info"> <i
                                        class="fa fa-send"></i> </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<?php include '../assets/layouts/footer.php' ?>