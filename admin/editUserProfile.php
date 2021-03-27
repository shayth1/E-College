<?php
define('TITLE', 'Edit User Profile');
include '../assets/layouts/header.php';
check_verified();
if ($_SESSION['account'] != "admin"){
    header("Location: ../logout");
    exit();
}
if(isset($_GET['id'])){
    $userid = $_GET['id'];
}else{
    header("Location: users.php");
}
$sql = "SELECT * FROM users WHERE id ='$userid'";
$stmt = mysqli_stmt_init($conn);
if(!mysqli_stmt_prepare($stmt, $sql)){
    die('SQL ERROR');
}else{
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);
}
$college = "SELECT * FROM college";
 $getCollege = mysqli_query($conn, $college);

 $maijor = "SELECT * FROM maijor";
 $getMaijor = mysqli_query($conn, $maijor);
?>

<div class="container">
    <div class="row">
        <div class="col-md-4">
        </div>
        <div class="col-md-4">
            <form class="form-auth" action="api/profileUserEdit.inc.php" method="post" enctype="multipart/form-data"
                autocomplete="off">

                <h6 class="h3 mt-3 mb-3 font-weight-normal text-muted text-center">Edit
                    <?php echo $user['first_name']; ?>'s Profile</h6>
                <div class="form-group">
                    <input type="text" value="<?php echo $user['id']; ?>" name="id" style="display: none;">
                    <label for="fn">First Name</label>
                    <input type="text" id="fn" name="first_name" class="form-control"
                        placeholder="Phone NumberFirst Name" value="<?php echo $user['first_name']; ?>"
                        autocomplete="off">
                </div>
                <div class="form-group">
                    <label for="ln">Last Name</label>
                    <input type="text" id="ln" name="last_name" class="form-control" placeholder="Last Name"
                        value="<?php echo $user['last_name']; ?>" autocomplete="off">
                </div>
                <div class="form-group">
                    <label>Gender</label>
                    <select name="gender" class="form-control">
                        <option value="<?php echo $user['gender']; ?>"><?php echo $user['gender']; ?></option>
                        <option value="f">Female</option>
                        <option value="m">Male</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="id">University ID:</label>
                    <input type="text" id="id" name="uniid" class="form-control" placeholder="University ID"
                        value="<?php echo $user['uniid']; ?>" autocomplete="off">
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" class="form-control" placeholder="E-mail"
                        value="<?php echo $user['email']; ?>" autocomplete="off">
                </div>
                <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <input type="text" id="phone" name="phone" class="form-control" placeholder="Phone Number"
                        value="<?php echo $user['phone']; ?>" autocomplete="off">
                </div>
                <div class="form-group">
                    <label for="college"> College</label>
                    <select id="college" name="college" class="form-control" required>
                        <option value="<?php echo $user['college']; ?>"><?php echo $user['college']; ?></option>
                        <?php while ($row = mysqli_fetch_array($getCollege)):?>
                        <option value="<?php echo $row[1];?>"><?php echo $row[1];?>
                        </option>
                        <?php endwhile;?>
                    </select>
                </div>
                <br>
                <div class="form-group">
                    <label>Maijor</label>
                    <select name="maijor" class="form-control" required>
                        <option value="<?php echo $user['maijor']; ?>"><?php echo $user['maijor']; ?></option>
                        <?php while ($row = mysqli_fetch_array($getMaijor)):?>
                        <option value="<?php echo $row[1];?>"><?php echo $row[1];?>
                        </option>
                        <?php endwhile;?>
                    </select>
                </div>
                <div class="form-group">
                    <label>User Type</label>
                    <select name="user_type" class="form-control">
                        <option value="<?php echo $user['account_type']; ?>"><?php echo $user['account_type']; ?>
                        </option>
                        <option value="student">Student</option>
                        <option value="teacher">Teacher</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
                <hr>
                <button class="btn btn-lg btn-primary btn-block mb-5" type="submit" name="updateUserProfile">Confirm
                    Changes</button>
            </form>
        </div>
        <div class="col-md-4"></div>
    </div>
</div>