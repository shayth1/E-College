<?php
define('TITLE', "Explore");
include '../assets/layouts/header.php';
if (!isset($_SESSION['auth'])) {
    header("Location: ../login");
    exit();
}
check_verified();
?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/ti-icons@0.1.2/css/themify-icons.css">
<div class="events_area">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5">
                <div class="main_title">
                    <h2 class="mb-3 text-black" style="text-align: center;">Explore Subjects</h2>

                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-6">
                <div class="single_event position-relative">
                    <div class="event_thumb">
                        <img src="https://colors.couponrani.com/wp-content/uploads/2014/09/books-featured-img.jpg"
                            alt="" />
                    </div>
                    <div class="event_details">
                        <div class="d-flex mb-4">
                            <div class="date"><span>
                                    <?php
                                    $g = "global";
                                    $query1 = mysqli_query($conn, "SELECT count(*) AS 'countC' FROM classes WHERE class_college ='$g'");
                                    $row = mysqli_fetch_array($query1);
                                    $count_S = $row['countC'];
                                    echo $row["countC"]; ?>
                                </span></div>
                            <div class="time-location">
                                <p><i class="fa fa-university" aria-hidden="true"></i></span> Global</p>
                                <p><span class="ti-time mr-2"></span></i></span>
                                    <?php echo date('H:i A') ?></p>

                            </div>
                        </div>
                        <p>
                            Here youll find the global subjects in your university
                        </p>
                        <a href="global.php" class="btn btn-primary rounded-0 mt-3">View</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6">
                <div class="single_event position-relative">
                    <div class="event_thumb">
                        <img src="https://colors.couponrani.com/wp-content/uploads/2014/09/books-featured-img.jpg"
                            alt="" />
                    </div>
                    <div class="event_details">
                        <div class="d-flex mb-4">
                            <div class="date"><span>
                                    <?php
                                    $g = $_SESSION['college'];
                                    $query1 = mysqli_query($conn, "SELECT count(*) AS 'countC' FROM classes WHERE class_college ='$g'");
                                    $row = mysqli_fetch_array($query1);
                                    $count_S = $row['countC'];
                                    echo $row["countC"]; ?>
                                </span></div>
                            <div class="time-location">
                                <p><i class="fa fa-university" aria-hidden="true"></i></span>
                                    <?php echo $_SESSION['college']; ?></p>
                                <p><span class="ti-time mr-2"></span></i></span>
                                    <?php echo date('H:i A') ?></p>

                            </div>
                        </div>
                        <p>
                            Here youll find the global subjects in your College
                        </p>
                        <a href="college.php" class="btn btn-primary rounded-0 mt-3">View</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<?php include '../assets/layouts/footer.php'; ?>