<?php
define('TITLE', 'Show Class');
include '../assets/layouts/header.php';
check_verified();
if (isset($_GET['classid'])) {
    $classid = $_GET['classid'];
} else {
    header("Location: ../");
}
$sql = "SELECT * FROM classes WHERE class_id ='$classid'";
$stmt = mysqli_stmt_init($conn);
if (!mysqli_stmt_prepare($stmt, $sql)) {
    die('SQL ERROR');
} else {
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $class = mysqli_fetch_assoc($result);
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
                    <h4 class="media-heading text-white"><?php echo $class['class_subject']; ?></h4>
                    <span class="text-white">Class Number: <?php echo $class['class_id']; ?></span>
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
                            About Class
                        </h5>

                        <div class="card-body">
                            <p class="ng-scope ng-binding editable"><?php echo $class['aboutClass']; ?></p>
                            <iframe width="100%" height="315"
                                src="https://www.youtube.com/embed/<?php echo $class['class_video']; ?>" frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen></iframe>
                        </div>
                        <div class="card-divider"></div>

                        <br>
                        <h5 class="card-heading pb0">Class Files</h5>
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
                                    $classN = $class['class_id'];
                                    $query = "SELECT * FROM meterials WHERE Classid = '$classN'";
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
                        <!-- endFilesInfo -->


                        <h5 class="card-heading pb0">Class Information</h5>
                        <div class="card-body">
                            <table class="table table-striped">
                                <tbody>
                                    <tr>
                                        <td><em class="ion-document-text icon-fw mr"></em>College:
                                        </td>
                                        <td class="ng-binding"><?php echo $class['class_college']; ?></td>
                                    </tr>
                                    <tr>
                                        <td><em class="ion-egg icon-fw mr"></em>Class Status:</td>
                                        <td><span
                                                class="ng-scope ng-binding editable"><?php echo $class['class_status']; ?></span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><em class="ion-man icon-fw mr"></em>Total Students: </td>
                                        <td><span class="ng-scope ng-binding editable">
                                                <?php
                                                $classz = $class['class_id'];
                                                $query1 = mysqli_query($conn, "SELECT count(*) AS 'countS' FROM members WHERE classID = '$classz'");
                                                $row = mysqli_fetch_array($query1);
                                                $count_S = $row['countS'];
                                                echo $row["countS"];
                                                ?></span></td>
                                    </tr>
                                    <tr>
                                        <td><em class="ion-android-home icon-fw mr"></em>Total Files</td>
                                        <td><span class="ng-scope ng-binding editable">
                                                <?php
                                                $class1 = $class['class_id'];
                                                $query = mysqli_query($conn, "SELECT count(*) AS 'countF' FROM meterials WHERE Classid = '$class1'");
                                                $row = mysqli_fetch_array($query);
                                                $count_F = $row['countF'];
                                                echo $row["countF"];
                                                ?>
                                            </span></td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </form>
                </div>
                <!-- Right column-->

            </div>
        </div>
    </div>
</section>


<?php include '../assets/layouts/footer.php'; ?>