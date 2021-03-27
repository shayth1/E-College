<?php
define('TITLE', "Profile");
include '../assets/layouts/header.php';
if (!isset($_SESSION['auth'])) {
    header("Location: ../login");
    exit();
}
check_verified();
if (isset($_GET['userid'])) {
    $userid = $_GET['userid'];
} else {
    $userid = $_SESSION['id'];
}
$sql = "SELECT * FROM users WHERE id ='$userid'";
$stmt = mysqli_stmt_init($conn);
if (!mysqli_stmt_prepare($stmt, $sql)) {
    die('SQL ERROR');
} else {
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);
}

?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div id="content" class="content content-full-width">
                <!-- begin profile -->
                <div class="profile">
                    <div class="profile-header">
                        <!-- BEGIN profile-header-cover -->
                        <div class="profile-header-cover"></div>
                        <!-- END profile-header-cover -->
                        <!-- BEGIN profile-header-content -->
                        <div class="profile-header-content">
                            <!-- BEGIN profile-header-img -->
                            <div class="profile-header-img">
                                <img src="../assets/uploads/users/<?php echo $user['profile_image']; ?>" alt="">
                            </div>
                            <!-- END profile-header-img -->
                            <!-- BEGIN profile-header-info -->
                            <div class="profile-header-info">
                                <h4 class="m-t-10 m-b-5"><?php echo $user['first_name']; ?>
                                    <?php echo $user['last_name']; ?></h4>
                                <p class="m-b-10"><?php echo $user['maijor']; ?></p>
                                <?php
                                $owner = $userid;
                                if ($_SESSION['id'] == $owner) {
                                    echo '<a data-toggle="modal" data-target="#post" class="btn btn-sm btn-info mb-2">Create New Post
                                    </a>';
                                } else {
                                    echo ' <a data-toggle="modal" data-target="#post" class="btn btn-sm btn-info mb-2">Post on ' . $user['first_name'] . 's Profile
                                     </a>';
                                    echo ' <a href="callto:' . $user['phone'] . '" class="btn btn-sm btn-info mb-2">Call ' . $user['first_name'] . '
                                     </a>';
                                }
                                ?>
                            </div>
                            <!-- END profile-header-info -->
                        </div>
                        <!-- END profile-header-content -->
                        <!-- BEGIN profile-header-tab -->
                        <ul class="profile-header-tab nav nav-tabs">
                            <li class="nav-item"><a href="#profile-post" class="nav-link active show"
                                    data-toggle="tab">POSTS</a></li>
                            <li class="nav-item"><a href="#profile-about" class="nav-link" data-toggle="tab">ABOUT</a>
                            </li>
                            <li class="nav-item"><a href="#profile-photos" class="nav-link" data-toggle="tab">PHOTOS</a>
                            </li>
                            <li class="nav-item"><a href="#profile-videos" class="nav-link" data-toggle="tab">VIDEOS</a>
                            </li>
                            <li class="nav-item"><a href="#profile-friends" class="nav-link"
                                    data-toggle="tab">FRIENDS</a></li>
                        </ul>
                        <!-- END profile-header-tab -->
                    </div>


                </div>
                <!-- end profile -->
                <!-- begin profile-content -->
                <div class="profile-content">
                    <!-- begin tab-content -->
                    <div class="tab-content p-0">
                        <!-- begin #profile-post tab -->
                        <div class="tab-pane fade active show" id="profile-post">
                            <!-- begin timeline -->
                            <ul class="timeline">
                                <?php
                                $sql = "SELECT postst.post_id AS 'post_id', postst.post_text AS'post_text', postst.post_date AS 'post_date',
                                 postst.post_time AS 'post_time', postst.post_by AS 'post_by', postst.post_on AS 'post_on', users.first_name AS 'first_name', users.last_name AS 'last_name',
                                  users.profile_image AS 'profile_image'FROM postst INNER JOIN users ON 
                                  postst.post_on = '$owner' AND postst.post_by = users.id ORDER BY postst.post_id DESC";
                                $stmt = mysqli_stmt_init($conn);
                                if (!mysqli_stmt_prepare($stmt, $sql)) {


                                    die('SQL error');
                                } else {
                                    mysqli_stmt_execute($stmt);
                                    $result = mysqli_stmt_get_result($stmt);

                                    while ($row = mysqli_fetch_assoc($result)) {

                                        echo '

                                <li>
                                    <!-- begin timeline-time -->
                                    <div class="timeline-time">
                                        <span class="date">' . $row['post_date'] . '</span>
                                        <span class="time">' . $row['post_time'] . '</span>
                                        
                                    </div>
                                    <!-- end timeline-time -->
                                    <!-- begin timeline-icon -->
                                    <div class="timeline-icon">
                                        <a href="javascript:;">&nbsp;</a>
                                    </div>
                                    <!-- end timeline-icon -->
                                    <!-- POST -->
                                    <div class="timeline-body">
                                        <div class="timeline-header">
                                            <span class="userimage"><img
                                                    src="../assets/uploads/users/' . $row['profile_image'] . '"
                                                    alt=""></span>
                                            <span class="username"><a href="javascript:;">' . $row['first_name'] . ' ' . $row['last_name'] . '</a>
                                                <small></small></span>
                                            
                                        </div>
                                        <div class="timeline-content">
                                            <p>
                                            ' . $row['post_text'] . '';
                                        if ($row['post_by'] || $row['post_on'] == $_SESSION['id']) {
                                            echo '<a style="float: right;" href="api/deletePost.inc.php?pid=' . $row['post_id'] . '&pby=' . $row['post_by'] . '" class="text-danger"><i class="far fa-trash-alt"></i></a>';
                                        }

                                        echo '
                                            </p>
                                        </div>
                                       
                                        <div class="timeline-footer">';
                                        $post = $row['post_id'];
                                        $query = mysqli_query($conn, "SELECT count(*) AS 'countL' FROM likes WHERE post_id = '$row[post_id]'");
                                        $row = mysqli_fetch_array($query);
                                        $count_F = $row['countL'];
                                        // liked or not
                                        $sql = mysqli_query($conn, "SELECT count(*) AS 'Liked' FROM likes WHERE post_id = '$post' AND 
                                        like_by = '$_SESSION[id]'");
                                        $row1 = mysqli_fetch_array($sql);
                                        $like = $row1['Liked'];

                                        if ($row1['Liked'] == 0) {
                                            echo '
                                            <a href="api/like.inc.php?by=' . $_SESSION['id'] . '&post=' . $post . '&for=' . $owner . '" class="m-r-15 text-inverse-lighter"><i
                                                    class="fa fa-thumbs-up fa-fw fa-lg m-r-3"></i> Like</a><br><br><div class="timeline-likes">
                                                    <div class="stats">
                                                        <span class="fa-stack fa-fw stats-icon">
                                                            <i class="fa fa-circle fa-stack-2x text-primary"></i>
                                                            <i class="fa fa-thumbs-up fa-stack-1x fa-inverse"></i>
                                                        </span>
                                                        <span class="stats-total">' . $row["countL"] . ' People likes this post </span>

                                                        
                                                    </div>
                                                </div>';
                                        } else {
                                            echo '
                                            <a href="api/unlike.inc.php?by=' . $_SESSION['id'] . '&post=' . $post . '&for=' . $owner . '" class="m-r-15 text-inverse-lighter"><i
                                                    class="fa fa-thumbs-down fa-fw fa-lg m-r-3"></i> Unlike</a><br><br> <div class="timeline-likes">
                                                    <div class="stats">
                                                        <span class="fa-stack fa-fw stats-icon">
                                                            <i class="fa fa-circle fa-stack-2x text-primary"></i>
                                                            <i class="fa fa-thumbs-up fa-stack-1x fa-inverse"></i>
                                                        </span>
                                                        <span class="stats-total">' . $row["countL"] . ' People likes this post </span>
                                                    </div>
                                                </div>';
                                        }
                                        echo '
    
                                        </div>

                                        
                                       
                                    </div>';
                                    }
                                }
                                ?>
                                <!-- end POST -->
                                </li>



                            </ul>
                            <!-- end timeline -->
                        </div>
                        <!-- end #profile-post tab -->
                    </div>
                    <!-- end tab-content -->
                </div>
                <!-- end profile-content -->
            </div>
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
                        <input style="display: none;" type="text" name="postby" class="form-control"
                            value="<?php echo $_SESSION['id']; ?>">
                        <input style="display: none;" type="text" name="poston" class="form-control"
                            value="<?php echo $userid; ?>">
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

<!-- Message -->
<div class="modal fade" id="msg" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Send a Message for <?php echo $user['first_name']; ?>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="api/sndmsg.inc.php" method="post">
                    <div class="form-group">
                        <input style="display: none;" type="text" name="msgfrom" class="form-control"
                            value="<?php echo $_SESSION['id']; ?>">
                        <input style="display: none;" type="text" name="msgto" class="form-control"
                            value="<?php echo $userid; ?>">
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="col-form-label"></label>
                        <textarea name="msg_text" class="form-control"
                            id="message-text">Hi <?php echo $user['first_name']; ?></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button name="snd" type="submit" class="btn btn-primary">Send</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
<!-- 
     <div class="timeline-comment-box">
                                            <div class="user"><img
                                                    src="../assets/uploads/users/'.$_SESSION['profile_image'].'"></div>
                                            <div class="input">
                                                <form action="">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control rounded-corner"
                                                            placeholder="Write a comment...">
                                                        <span class="input-group-btn p-l-10">
                                                            <button class="btn btn-primary f-s-12 rounded-corner"
                                                                type="button">Comment</button>
                                                        </span>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
 -->

<?php include '../assets/layouts/footer.php'; ?>