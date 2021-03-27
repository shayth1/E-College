<?php
define('TITLE', "Support");

include '../assets/layouts/header.php';
if (!isset($_SESSION['auth'])) {
    echo '<a href="../login">Login First</a>';
    die();
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
                            <div class="message info">
                                <img alt="" class="img-circle medium-image" src="../assets/images/logo.png">

                                <div class="message-body">
                                    <div class="message-info">
                                        <h4> E-College </h4>
                                        <h5> <i class="fa fa-clock-o"></i> Now </h5>
                                    </div>
                                    <hr>
                                    <div class="message-text">
                                        Hi <?php echo $_SESSION['first_name']; ?> How can we help you
                                    </div>

                                </div>
                                <br>
                            </div>

                            <?php
                            $userid = $_SESSION['id'];
                            $sender = $_SESSION['first_name'];
                            $in = "admin";
                            $sql = "SELECT * FROM messages WHERE messagefrom OR messageto = '$userid' ORDER BY messagedate ASC";
                            $stmt = mysqli_stmt_init($conn);
                            if (!mysqli_stmt_prepare($stmt, $sql)) {
                                die('SQL error');
                            } else {
                                mysqli_stmt_execute($stmt);
                                $result = mysqli_stmt_get_result($stmt);

                                while ($row = mysqli_fetch_assoc($result)) {
                                    if ($row['messagefrom'] == $userid) {
                                        echo '
                                        <div class="message my-message">
                                            <img alt="" class="img-circle medium-image" src="../assets/uploads/users/' . $_SESSION['profile_image'] . '">

                                            <div class="message-body">
                                                <div class="message-body-inner">
                                                    <div class="message-info">
                                                        <h4> ' . $sender . ' </h4>
                                                        <h5> <i class="fa fa-clock-o"></i> ' . $row['messagedate'] . ' </h5>
                                                    </div>
                                                    <hr>
                                                    <div class="message-text">
                                                    ' . $row['messagetext'] . '
                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                        </div>';
                                    } else {
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
                                        </div>';
                                    }
                                }
                            }
                            ?>


                        </div>

                        <div class="chat-footer">
                            <form action="api/message.inc.php" method="post">
                                <input type="text" name="from" value="<?php echo $_SESSION['id']; ?>"
                                    style="display: none;">
                                <textarea required placeholder="type someting " name="message"
                                    class="send-message-text"></textarea>

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