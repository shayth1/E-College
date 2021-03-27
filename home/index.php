<?php
define('TITLE', "HOME");
include '../assets/layouts/header.php';
if (!isset($_SESSION['auth'])) {
    header("Location: ../login");
    exit();
}
check_verified();
?>

<div class="container">
    <?php if ($_SESSION['account'] == "admin") {
        echo ' <a type="button" data-toggle="modal" data-target="#post" class="btn btn-success" style="color: #ffffff;">New Post</a>';
    }
    ?>

    <div class="row">
        <div class="col-xl-12">
            <?php
            $sql = "SELECT * FROM informs ORDER BY inf_date DESC";
            $stmt = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($stmt, $sql)) {


                die('SQL error');
            } else {
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);

                while ($row = mysqli_fetch_assoc($result)) {

                    echo '
            <section class="hk-sec-wrapper">
                <h5 class="hk-sec-title">' . $row['inf_title'] . '</h5>
                <p class="mb-40">By Admin:
                    <code>' . $row['inf_date'] . '</code>
                </p>
                <div class="row">
                    <p class="mb-40">' . $row['inf_text'] . '</p>
                </div>
            </section>';
                }
            }
            ?>

        </div>
    </div>
</div>

<!-- createPost -->
<div class="modal fade" id="post" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Create New Post</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="api/createPost.inc.php" method="post">
                    <div class="form-group">
                        <input netype="text" name="title" class="form-control" placeholder="Title" required>
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="col-form-label"></label>
                        <textarea name="postText" class="form-control" id="message-text">Type Someting...</textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button name="cpost" type="submit" class="btn btn-primary">POST</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>



<?php include '../assets/layouts/footer.php'; ?>