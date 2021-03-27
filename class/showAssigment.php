<?php
define('TITLE', 'Show Class');
include '../assets/layouts/header.php';
check_verified();
if (isset($_GET['id'])) {
    $id = $_GET['id'];
} else {
    header("Location: classes.php");
}
$sql = "SELECT * FROM assigment WHERE ass_id ='$id'";
$stmt = mysqli_stmt_init($conn);
if (!mysqli_stmt_prepare($stmt, $sql)) {
    die('SQL ERROR');
} else {
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $ass = mysqli_fetch_assoc($result);
}

?>

<section class="container ng-scope ng-fadeInLeftShort">
    <!-- uiView:  -->
    <div class="ng-fadeInLeftShort ng-scope">
        <div class="container-overlap bg-blue-500 ng-scope">
            <div class="media m0 pv">
                <div class="media-left"><a href="#"><img src="../assets/images/book.png" alt="User"
                            class="media-object img-circle thumb64"></a></div>
                <div class="media-body media-middle">
                    <h4 class="media-heading text-white"><?php echo $ass['ass_name']; ?></h4>
                    <span class="text-white">Assigment Number: <?php echo $ass['ass_id']; ?></span>
                </div>
            </div>
        </div>
        <div class="container-fluid ng-scope">
            <div class="row">
                <!-- Left column-->
                <div class="col-md-7 col-lg-8">
                    <form class="card ng-pristine ng-valid">
                        <div class="card-divider"></div>
                        <h5 class="card-heading pb0">
                            Instruction's
                        </h5>
                        <div class="card-body">
                            <p class="ng-scope ng-binding editable"><?php echo $ass['ass_about']; ?> | this assigment
                                will close at <?php echo $ass['due_date']; ?> <?php echo $ass['due_time']; ?></p>
                        </div>
                        <div class="card-divider"></div>

                        <br>
                        <h5 class="card-heading pb0">Assigment Files</h5>
                        <div class="card-body">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Download</th>
                                        <th>Date</th>
                                        <th>Caption</th>



                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $assN = $ass['ass_id'];
                                    $query = "SELECT * FROM meterials WHERE ass_id = '$assN'";
                                    $stmt = mysqli_stmt_init($conn);
                                    if (!mysqli_stmt_prepare($stmt, $query)) {
                                        die('SQL error');
                                    } else {
                                        mysqli_stmt_execute($stmt);
                                        $result = mysqli_stmt_get_result($stmt);

                                        while ($row = mysqli_fetch_assoc($result)) {
                                            echo '

                                    <tr>
                                        <td><em class="ion-document-text icon-fw mr">' . $row['meterialid'] . '</td> 
                                        <td class="ng-binding"><a href="../teacher/uploads/files/' . $row['meterialName'] . '" type="button" class="btn btn-sm btn-outline-success badge" target="_blank">Download</a></td>
                                        <td><em class="ion-document-text icon-fw mr">' . $row['upTime'] . '</td>
                                        <td><em class="ion-document-text icon-fw mr">' . $row['caption'] . '</td>
                                    </tr>';
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>

                    </form>
                </div>
                <!-- Right column-->
                <div class="col-md-5 col-lg-4">
                    <div class="card">
                        <h5 class="card-heading">
                            Submissions:
                        </h5>
                        <div class="mda-list">
                            <div class="card-body">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Show</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $assN = $ass['ass_id'];
                                        $std = $_SESSION['id'];
                                        $query = "SELECT * FROM submission WHERE as_id = '$assN' AND sub_by = $std";
                                        $stmt = mysqli_stmt_init($conn);
                                        if (!mysqli_stmt_prepare($stmt, $query)) {
                                            die('SQL error');
                                        } else {
                                            mysqli_stmt_execute($stmt);
                                            $result = mysqli_stmt_get_result($stmt);

                                            while ($row = mysqli_fetch_assoc($result)) {
                                                echo '

                                    <tr>
                                        <td><em class="ion-document-text icon-fw mr">' . $row['sub_at'] . '</td> 
                                        <td class="ng-binding">
                                        <a href="../teacher/uploads/files/' . $row['sub_file'] . '" type="button" class="btn btn-sm btn-outline-success badge" target="_blank">Show</a>
                                        <a href="api/deleteAss.inc.php?aid=' . $row['sub_id'] . '&ass=' . $assN . '" class="text-danger"><i class="far fa-trash-alt"></i></a>
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
                    <div class="card-body pv0 text-right">
                        <?php
                        $due = $ass['due_date'];
                        $duem = $ass['due_time'];
                        $time = date('Y-m-d');
                        $min = date('H:i');

                        if ($time  > $due && $min > $duem || $time  === $due && $min > $duem) {
                            echo '
                            <a  class="btn btn-flat btn-danger"
                            style="color: #ffffff;">This Submission has been closed
                        </a>
                            ';
                        } else {
                            echo '<a data-toggle="modal" data-target="#up" class="btn btn-flat btn-info"
                            style="color: #ffffff;">add
                            submission
                        </a>';
                        }


                        ?>
                    </div>
                    <div class="card-divider"></div>
                </div>
            </div>
        </div>
    </div>
    </div>
</section>

<div class="modal fade" id="up" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">add a submission for <?php echo $ass['ass_name']; ?>
                    assigment
                    <?php echo $ass['ass_id']; ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="api/addFile.inc.php" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Upload</span>
                        </div>
                        <br>
                        <div class="custom-file">
                            <input name="upFile" type="file" class="custom-file-input" id="inputGroupFile01" required>
                            <input style="display: none;" name="assId" value=" <?php echo $ass['ass_id']; ?>">
                            <input style="display: none;" name="by" value=" <?php echo $_SESSION['id']; ?>">
                            <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                        </div>
                        <br>

                    </div>
                    <br>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" name="addFile" class="btn btn-primary">Upload</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>


<?php include '../assets/layouts/footer.php'; ?>