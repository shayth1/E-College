<?php
define('TITLE', "Profile");
include '../assets/layouts/header.php';
if (!isset($_SESSION['auth'])) {
    header("Location: ../login");
    exit();
}
check_verified();
?>

<link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/MaterialDesign-Webfont/5.3.45/css/materialdesignicons.css"
    integrity="sha256-NAxhqDvtY0l4xn+YVa6WjAcmd94NNfttjNsDmNatFVc=" crossorigin="anonymous" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/css/all.min.css"
    integrity="sha256-2XFplPlrFClt0bIdPgpz8H7ojnk10H69xRqd9+uTShA=" crossorigin="anonymous" />
<div class="body1">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-xl-4">
                <div class="card-box text-center">
                    <img src="../assets/uploads/users/<?php echo $_SESSION['profile_image'] ?>"
                        class="rounded-circle avatar-xl img-thumbnail" alt="profile-image">

                    <h4 class="mb-0"><?php echo $_SESSION['first_name']; ?> <?php echo  $_SESSION['last_name']; ?></h4>
                    <p class="text-muted">@<?php echo $_SESSION['uniid']; ?> </p>

                    <button type="button" data-toggle="modal" data-target="#exampleModal2"
                        class="btn btn-success btn-xs waves-effect mb-2 waves-light">Join to
                        Class</button>
                    <a href="../support" type="button"
                        class="btn btn-danger btn-xs waves-effect mb-2 waves-light">Support</a>

                    <div class="text-left mt-3">
                        <h4 class="font-13 text-uppercase">About Me :</h4>
                        <p class="text-muted mb-2 font-13"><strong>College :</strong> <span
                                class="ml-2"><?php echo $_SESSION['college']; ?></span></p>

                        <p class="text-muted mb-2 font-13"><strong>Specialization :</strong><span
                                class="ml-2"><?php echo $_SESSION['maijor']; ?></span></p>

                        <p class="text-muted mb-2 font-13"><strong>Email :</strong> <span
                                class="ml-2 "><?php echo $_SESSION['email']; ?></span></p>

                        <p class="text-muted mb-1 font-13"><strong>Phone :</strong> <span
                                class="ml-2"><?php echo $_SESSION['phone']; ?></span></p>
                    </div>


                </div> <!-- end card-box -->


            </div> <!-- end col-->

            <div class="col-lg-8 col-xl-8">
                <div class="card-box">
                    <ul class="nav nav-pills navtab-bg">
                        <li class="nav-item">
                            <a href="#about-me" data-toggle="tab" aria-expanded="true" class="nav-link ml-0 active">
                                <i class="mdi mdi-face-profile mr-1"></i> General
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#settings" data-toggle="tab" aria-expanded="false" class="nav-link">
                                <i class="mdi mdi-settings-outline mr-1"></i>Courses
                            </a>
                        </li>
                    </ul>

                    <div class="tab-content">

                        <div class="tab-pane show active" id="about-me">


                            <h5 class="mb-3 mt-4 text-uppercase"><i class="mdi mdi-book-open-page-variant mr-1"></i>
                                Assigments</h5>
                            <div class="table-responsive">
                                <table class="table table-borderless mb-0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Course Name</th>
                                            <th>Start Date</th>
                                            <th>Due Date</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $id = $_SESSION['uniid'];

                                        $sql = "SELECT assigment.ass_id AS 'ass_id', assigment.ass_name AS 'ass_name', assigment.ass_date AS 'assdate', assigment.due_time AS 'ass_dt',
                                    assigment.due_date AS 'ass_due', assigment_members.ms_id AS 'userid' FROM assigment INNER JOIN assigment_members ON assigment_members.ms_id = '$id'";
                                        $stmt = mysqli_stmt_init($conn);
                                        if (!mysqli_stmt_prepare($stmt, $sql)) {
                                            die('SQL error');
                                        } else {
                                            mysqli_stmt_execute($stmt);
                                            $result = mysqli_stmt_get_result($stmt);

                                            while ($row = mysqli_fetch_assoc($result)) {
                                                echo '
                                        <tr>
                                            <td>' . $row['ass_id'] . '</td>
                                            <td>' . $row['ass_name'] . '</td>
                                            <td>' . $row['assdate'] . '</td>
                                            <td>' . $row['ass_due'] . ' ' . $row['ass_dt'] . '</td>';
                                                $due = array($row['ass_due'], $row['ass_dt']);
                                                $time = date('Y-m-d');
                                                $min = date('H:i');
                                                $nowt = array($time, $min);

                                                if ($nowt > $due) {
                                                    echo '
                                                    <td><span class="badge badge-danger">Closed</span></td>
                                                    ';
                                                } else {
                                                    echo '<td><span class="badge badge-success">Avilabel</span></td>';
                                                }

                                                echo '
                                            <td><a href="../class/showAssigment.php?id=' . $row['ass_id'] . '"><span class="badge badge-success">View</span></a></td>
                                        </tr>';
                                            }
                                        }
                                        ?>

                                    </tbody>
                                </table>
                            </div>

                        </div>
                        <!-- end timeline content-->


                        <!-- Cors content-->

                        <div class="tab-pane" id="settings">
                            <h5 class="mb-3 mt-4 text-uppercase"><i class="mdi mdi-book-open-page-variant mr-1"></i>
                                My Classes</h5>
                            <div class="table-responsive">
                                <table class="table table-borderless mb-0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Class Nuber</th>
                                            <th>Class Name</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $std = $_SESSION['uniid'];
                                        $query = "SELECT classes.class_id AS 'class_id', classes.class_subject AS 'class_subject', members.m_user 
                                    FROM classes INNER JOIN members ON  classes.class_id = members.classID AND members.m_user='$std'";
                                        $stmt = mysqli_stmt_init($conn);
                                        if (!mysqli_stmt_prepare($stmt, $query)) {
                                            die('SQL error');
                                        } else {
                                            mysqli_stmt_execute($stmt);
                                            $result = mysqli_stmt_get_result($stmt);

                                            while ($row = mysqli_fetch_assoc($result)) {
                                                echo '
                                        <tr>
                                            <td>' . $row['class_id'] . '</td>
                                            <td>' . $row['class_subject'] . '</td>
                                            <td class="ng-binding"> <a href="../class/showClass.php?classid=' . $row['class_id'] . '" type="button"
                                                    class="btn btn-sm btn-outline-success badge">Enter
                                                    Class</a></td>
                                        </tr>';
                                            }
                                        }
                                        ?>


                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!-- end settings content-->

                    </div> <!-- end tab-content -->
                </div> <!-- end card-box-->

            </div> <!-- end col -->
        </div>
    </div>
</div>

<!-- Support Message -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">New message to admin</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Recipient:</label>
                        <input disabled type="text" class="form-control" id="recipient-name" value="ADMIN">
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Message:</label>
                        <textarea class="form-control" id="message-text"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Send message</button>
            </div>
        </div>
    </div>
</div>

<!-- Join Code -->
<div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Join to Class by Code</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="api/join.inc.php" method="post">
                    <div class="form-group">

                        <input style="display: none;" type="text" class="form-control" name="uniid"
                            value="<?php echo $_SESSION['uniid']; ?>">
                    </div>
                    <div class="form-group">

                        <input class="form-control" id="message-text" name="code" placeholder="Enter Class Join Code"
                            required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" name="JOIN" class="btn btn-primary">Join</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>


<?php include '../assets/layouts/footer.php'; ?>