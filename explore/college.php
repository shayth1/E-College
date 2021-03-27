<?php
define('TITLE', "Explore Global");
include '../assets/layouts/header.php';
if (!isset($_SESSION['auth'])) {
    header("Location: ../login");
    exit();
}
check_verified();
?>
<div class="container mt-3 mb-4">
    <div class="col-lg-9 mt-4 mt-lg-0">
        <div class="row">
            <div class="col-md-12">
                <div class="user-dashboard-info-box table-responsive mb-0 bg-white p-4 shadow-sm">
                    <table class="table manage-candidates-top mb-0">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th class="text-center">Status</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $c = $_SESSION['college'];

                            $s = "Open";
                            $sql = "SELECT * FROM classes WHERE class_college ='$c' AND class_status ='$s' ORDER BY class_id ASC";
                            $stmt = mysqli_stmt_init($conn);
                            if (!mysqli_stmt_prepare($stmt, $sql)) {


                                die('SQL error');
                            } else {
                                mysqli_stmt_execute($stmt);
                                $result = mysqli_stmt_get_result($stmt);

                                while ($row = mysqli_fetch_assoc($result)) {

                                    echo '
                            <tr class="candidates-list">
                                <td class="title">
                                    <div class="thumb">
                                        <img class="img-fluid"
                                            src="https://colors.couponrani.com/wp-content/uploads/2014/09/books-featured-img.jpg"
                                            alt="">
                                    </div>
                                    <div class="candidate-list-details">
                                        <div class="candidate-list-info">
                                            <div class="candidate-list-title">
                                                <h5 class="mb-0"><a href="../class/visitClass.php?classid=' . $row['class_id'] . '">' . $row['class_subject'] . '</a></h5>
                                            </div>

                                        </div>
                                    </div>
                                </td>
                                <td class="candidate-list-favourite-time text-center">
                                    
                                    <span class="candidate-list-time order-1">' . $row['class_status'] . '</span>
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

<?php include '../assets/layouts/footer.php'; ?>