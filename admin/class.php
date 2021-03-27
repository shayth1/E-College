<?php
define('TITLE', "Manage Classes");
include '../assets/layouts/header.php';
if (!isset($_SESSION['auth'])) {
    header("Location: ../login");
    exit();
}
if ($_SESSION['account'] != "admin") {
    header("Location: ../logout");
    exit();
}
$teacher = "teacher";
$instractor = "SELECT * FROM users WHERE account_type = '$teacher'";
$geTeacher = mysqli_query($conn, $instractor);

$teacher1 = "teacher";
$instractor1 = "SELECT * FROM users WHERE account_type = '$teacher1'";
$geTeacher1 = mysqli_query($conn, $instractor1);

$maijor = "SELECT * FROM college";
$getMaijor = mysqli_query($conn, $maijor);

$maijor1 = "SELECT * FROM college";
$getMaijor1 = mysqli_query($conn, $maijor1);

$subject = "SELECT * FROM subject";
$getSubject = mysqli_query($conn, $subject);

$subject1 = "SELECT * FROM subject";
$getSubject1 = mysqli_query($conn, $subject1);
?>

<div class="container">
    <div class="container-fluid p-0">

        <div class="row">
            <div class="col-xl-8">
                <div class="card">
                    <div class="card-header pb-0">
                        <div class="card-actions float-right">
                            <div class="dropdown show">
                                <a href="#" data-toggle="dropdown" data-display="static">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="feather feather-more-horizontal align-middle">
                                        <circle cx="12" cy="12" r="1"></circle>
                                        <circle cx="19" cy="12" r="1"></circle>
                                        <circle cx="5" cy="12" r="1"></circle>
                                    </svg>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" data-toggle="modal" data-target="#ec">Edit Class</a>

                                </div>
                            </div>
                        </div>
                        <h5 class="card-title mb-0">Classes</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>College</th>
                                    <th>Teacher</th>
                                    <th>Join Code</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql = "SELECT classes.class_id AS 'class_id', classes.class_subject AS 'class_subject', classes.class_status AS 'class_status', classes.class_college 
                                         AS 'class_college', users.first_name AS 'class_teacherf', users.last_name AS 'class_teacherl', classes.class_code AS
                                          'class_code' FROM classes INNER JOIN users ON classes.class_teacher = users.id";
                                $stmt = mysqli_stmt_init($conn);
                                if (!mysqli_stmt_prepare($stmt, $sql)) {
                                    die('ERROR IN DATABASE');
                                } else {
                                    mysqli_stmt_execute($stmt);
                                    $result = mysqli_stmt_get_result($stmt);
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo '
                                                <tr>
                                                    <td>' . $row['class_id'] . '</td>
                                                    <td>' . $row['class_subject'] . '</td> 
                                                    <td>' . $row['class_college'] . '</td>
                                                    <td>' . $row['class_teacherf'] . ' ' . $row['class_teacherl'] . '</td>
                                                    <td>' . $row['class_code'] . '</td>
                                                    <td>' . $row['class_status'] . '</td>
                                                </tr>';
                                    }
                                }
                                ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="col-xl-4">
                <div class="card">
                    <div class="card-header">

                        <h5 class="card-title mb-0">Add New Class</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-0">
                            <div class="col-sm-3 col-xl-12 col-xxl-3 text-center">
                                <img src="../assets/images/class.png" width="64" height="64" class="rounded-circle mt-2"
                                    alt="Angelica Ramos">
                            </div>

                        </div>
                        <br>

                        <form action="api/addClass.inc.php" method="post">
                            <div class="form-group">
                                <input name="classCode" type="text" class="form-control" placeholder="Class Join Code"
                                    required autocomplete="off">
                                <br>
                                <label for="teacher">Select Teacher Name</label>
                                <select id="teacher" name="teacher" class="form-control" required>
                                    </option>
                                    <?php while ($row = mysqli_fetch_array($geTeacher)) : ?>
                                    <option value="<?php echo $row[0]; ?>"><?php echo $row[4]; ?> <?php echo $row[5]; ?>
                                    </option>
                                    <?php endwhile; ?>
                                </select>
                                <br>
                                <label for="college">Select College</label>
                                <select id="college" name="college" class="form-control" required>
                                    </option>
                                    <?php while ($row = mysqli_fetch_array($getMaijor)) : ?>
                                    <option value="<?php echo $row[1]; ?>"><?php echo $row[1]; ?>
                                    </option>
                                    <?php endwhile; ?>
                                    <option value="global">Global</option>
                                </select>
                                <br>
                                <label for="subject">Select Subject</label>
                                <select id="subject" name="subject" class="form-control" required>
                                    </option>
                                    <?php while ($row = mysqli_fetch_array($getSubject)) : ?>
                                    <option value="<?php echo $row[1]; ?>"><?php echo $row[1]; ?>
                                    </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                            <div class="modal-footer">
                                <button name="addClass" type="submit" class="btn btn-success">Add</button>
                            </div>
                        </form>


                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<!-- delete User -->
<div class="modal fade" id="ec" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Class</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="api/editClass.inc.php" method="post">
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Enter Class Data to confirm</label>
                        <input name="cid" type="text" class="form-control" placeholder="Class ID" required
                            autocomplete="off">
                        <br>
                        <input name="cn" type="text" class="form-control" placeholder="Class Join Code" required
                            required autocomplete="off">
                        <label for="teachere">Select Teacher Name</label>
                        <select id="teachere" name="teachere" class="form-control" required>
                            </option>
                            <?php while ($row = mysqli_fetch_array($geTeacher1)) : ?>
                            <option value="<?php echo $row[0]; ?>"><?php echo $row[4]; ?> <?php echo $row[5]; ?>
                            </option>
                            <?php endwhile; ?>
                        </select>
                        <br>
                        <label for="college">Select College</label>

                        <select id="college" name="collegee" class="form-control" required>
                            </option>
                            <?php while ($row = mysqli_fetch_array($getMaijor1)) : ?>
                            <option value="<?php echo $row[1]; ?>"><?php echo $row[1]; ?>
                            </option>
                            <?php endwhile; ?>
                            <option value="global">Global</option>
                        </select>
                        <br>
                        <label for="subject">Select Subject</label>
                        <select id="subject" name="subjecte" class="form-control" required>
                            </option>
                            <?php while ($row = mysqli_fetch_array($getSubject1)) : ?>
                            <option value="<?php echo $row[1]; ?>"><?php echo $row[1]; ?>
                            </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <br>
                    <label for="css">Class Status</label>
                    <select id="css" name="cStat" class="form-control" required>
                        <option value="Open">Open</option>
                        <option value="Close">Close</option>
                    </select>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button name="editClass" type="submit" class="btn btn-warning">Edit</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
<?php include '../assets/layouts/footer.php'; ?>