<?php
define('TITLE', "Users");
include '../assets/layouts/header.php';
if (!isset($_SESSION['auth'])) {
    header("Location: ../login");
    exit();
}

if ($_SESSION['account'] != "admin") {
    header("Location: ../logout");
    exit();
}
check_verified();
$college = "SELECT * FROM college";
$getCollege = mysqli_query($conn, $college);

$maijor = "SELECT * FROM maijor";
$getMaijor = mysqli_query($conn, $maijor);
?>



<div class="container">
    <div class="row flex-lg-nowrap">

        <div class="col">
            <div class="e-tabs mb-3 px-3">
                <ul class="nav nav-tabs">
                    <li class="nav-item"><a class="nav-link active" href="#">Users</a></li>
                </ul>
            </div>

            <div class="row flex-lg-nowrap">
                <div class="col mb-3">
                    <div class="e-panel card">
                        <div class="card-body">
                            <div class="card-title">
                                <h6 class="mr-2"><span>Users</span><small class="px-1">Be a wise leader</small></h6>
                            </div>
                            <div class="e-table">
                                <div class="table-responsive table-lg mt-3">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th class="align-top">ID</th>
                                                <th>Photo</th>
                                                <th class="max-width">Name</th>
                                                <th class="sortable">Type</th>
                                                <th>Phone </th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $sql = "SELECT * FROM users";
                                            $stmt = mysqli_stmt_init($conn);
                                            if (!mysqli_stmt_prepare($stmt, $sql)) {
                                                die('ERROR IN DATABASE');
                                            } else {
                                                mysqli_stmt_execute($stmt);
                                                $result = mysqli_stmt_get_result($stmt);
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    echo '
                                                 <tr>
                                                 <td class="text-nowrap align-middle">' . $row['uniid'] . '</td>
                                                 <td class="align-middle text-center">
                                                     <div class="bg-light d-inline-flex justify-content-center align-items-center align-top"
                                                         >
                                                         <img src="../assets/uploads/users/' . $row['profile_image'] . '" style="width: 35px; height: 35px; border-radius: 3px;">
                                                     </div>
                                                 </td>
                                                 <td class="text-nowrap align-middle">' . $row['first_name'] . ' ' . $row['last_name'] . '</td>
                                                 <td class="text-nowrap align-middle"><span>';
                                                    if ($row['account_type'] == NULL) {
                                                        echo 'Student';
                                                    } else {
                                                        echo $row['account_type'];
                                                    }
                                                    echo '</span></td>
                                                 <td class="text-center align-middle">' . $row['phone'] . ' </td>
                                                 <td class="text-center align-middle">
                                                     <div class="btn-group align-top">
                                                         <a href="editUserProfile.php?id=' . $row['id'] . '" type="button" class="btn btn-sm btn-outline-warning badge">Edit</a>
                                                            
                                                         <button class="btn btn-sm btn-outline-danger badge"
                                                             type="button" data-toggle="modal" data-target="#du"><i class="fa fa-trash"></i></button>
                                                     </div>
                                                 </td>
                                             </tr>
                                                 ';
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
                <div class="col-12 col-lg-3 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="text-center px-xl-3">
                                <button class="btn btn-success btn-block" type="button" data-toggle="modal"
                                    data-target="#user-form-modal">New User</button>
                            </div>
                            <hr class="my-3">
                            <div class="e-navlist e-navlist--active-bold">
                                <ul class="nav">
                                    <li class="nav-item active"><a href="" class="nav-link"><span>Total
                                                Students</span>&nbsp;<small>/&nbsp;
                                                <?php
                                                $student = "student";
                                                $query = mysqli_query($conn, "SELECT COUNT(*) as 'countS' FROM users WHERE account_type ='$student'");
                                                $row = mysqli_fetch_array($query);
                                                echo $row['countS'];

                                                ?>
                                            </small></a></li>
                                    <li class="nav-item"><a href="" class="nav-link"><span>Total
                                                Teachers</span>&nbsp;<small>/&nbsp; <?php
                                                                                    $teacher = "teacher";
                                                                                    $query = mysqli_query($conn, "SELECT COUNT(*) as 'countS' FROM users WHERE account_type ='$teacher'");
                                                                                    $row = mysqli_fetch_array($query);
                                                                                    echo $row['countS'];

                                                                                    ?></small></a></li>
                                    <li class="nav-item"><a href="" class="nav-link"><span>Total
                                                Admins</span>&nbsp;<small>/&nbsp;<?php
                                                                                    $admin = "admin";
                                                                                    $query = mysqli_query($conn, "SELECT COUNT(*) as 'countS' FROM users WHERE account_type ='$admin'");
                                                                                    $row = mysqli_fetch_array($query);
                                                                                    echo $row['countS'];

                                                                                    ?></small></a></li>
                                </ul>
                            </div>
                            <hr class="my-3">
                            <div>
                                <div class="search-box header-search-form search-box">
                                    <input type="text" class=" search-box mainMenuediv form-control" autocomplete="off"
                                        placeholder="search by uni id" />

                                    <div class="result" style="background-color: #eee;">

                                    </div>
                                </div>
                            </div>
                            <hr class="my-3">

                        </div>
                    </div>
                </div>
            </div>

            <!-- User Form Modal -->
            <div class="modal fade" role="dialog" tabindex="-1" id="user-form-modal">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Create User</h5>
                            <button type="button" class="close" data-dismiss="modal">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="py-1">
                                <form action="api/addUser.inc.php" method="post" class="form">
                                    <div class="row">
                                        <div class="col">
                                            <div class="row">
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label>First Name</label>
                                                        <input class="form-control" type="text" autocomplete="off"
                                                            name="first_name">

                                                    </div>

                                                </div>
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label>Last Name</label>
                                                        <input class="form-control" type="text" autocomplete="off"
                                                            name="last_name">
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label>University ID</label>
                                                        <input class="form-control" type="text" autocomplete="off"
                                                            name="uniid">
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label>Gender</label>
                                                        <select name="gender" class="form-control">
                                                            <option value="f">Female</option>
                                                            <option value="m">Male</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col">
                                                    <div class="form-group">
                                                        <label>Email</label>
                                                        <input class="form-control" name="email" type="email"
                                                            autocomplete="off">
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="row">
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label>College</label>
                                                        <select name="college" class="form-control" required>
                                                            <option value="">Select College</option>
                                                            <?php while ($row = mysqli_fetch_array($getCollege)) : ?>
                                                            <option value="<?php echo $row[1]; ?>">
                                                                <?php echo $row[1]; ?>
                                                            </option>
                                                            <?php endwhile; ?>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col">
                                                    <div class="form-group">
                                                        <label>Maijor</label>
                                                        <select name="maijor" class="form-control" required>
                                                            <option value="">Select Maijor</option>
                                                            <?php while ($row = mysqli_fetch_array($getMaijor)) : ?>
                                                            <option value="<?php echo $row[1]; ?>">
                                                                <?php echo $row[1]; ?>
                                                            </option>
                                                            <?php endwhile; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="form-group">
                                                        <label>User Type</label>
                                                        <select name="user_type" class="form-control">
                                                            <option value="student">Student</option>
                                                            <option value="teacher">Teacher</option>
                                                            <option value="admin">Admin</option>
                                                        </select>
                                                    </div>
                                                </div>


                                                <div class="col">
                                                    <div class="form-group">
                                                        <label>Phone</label>
                                                        <input class="form-control" type="text" name="phone"
                                                            autocomplete="off">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col d-flex justify-content-end">
                                            <button class="btn btn-success" name="addUser" type="submit">Add
                                                User</button>
                                        </div>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- delete User -->
<div class="modal fade" id="du" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Are you sure about <span
                        style="font-weight: bold;">DELETING </span> this user?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="api/deleteUser.inc.php" method="post">
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Enter user Data to confirm</label>
                        <input name="useid" type="text" class="form-control" placeholder="Universuty ID" required
                            autocomplete="off">
                        <br>
                        <input name="phone" type="text" class="form-control" placeholder="Phone Number" required
                            required autocomplete="off">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button name="deleteUser" type="submit" class="btn btn-danger">DELETE</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

<?php include '../assets/layouts/footer.php'; ?>
<script type="text/javascript">
$(document).ready(function() {
    $('.search-box input[type="text"]').on("keyup input", function() {

        var inputVal = $(this).val();
        var resultDropdown = $(this).siblings(".result");
        if (inputVal.length) {
            $.get("search.php", {
                term: inputVal
            }).done(function(data) {

                resultDropdown.html(data);
            });
        } else {
            resultDropdown.empty();
        }
    });


    $(document).on("click", ".result p", function() {
        $(this).parents(".search-box").find('input[type="text"]').val($(this).text());
        $(this).parent(".result").empty();
    });
});
</script>