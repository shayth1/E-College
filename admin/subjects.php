<?php
 define('TITLE', "Subjects");
 include '../assets/layouts/header.php';
 if(! isset($_SESSION['auth'])){
    header("Location: ../login");
    exit();
} 
if ($_SESSION['account'] != "admin"){
    header("Location: ../logout");
    exit();
}
$college = "SELECT * FROM college";
 $getCollege = mysqli_query($conn, $college);

 $maijor = "SELECT * FROM maijor";
 $getMaijor = mysqli_query($conn, $maijor);
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
                                    <a class="dropdown-item" data-toggle="modal" data-target="#ds">Delete Subject</a>

                                </div>
                            </div>
                        </div>
                        <h5 class="card-title mb-0">Subjects</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped" style="width:100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Maijor</th>
                                    <th>College</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                         $sql = "SELECT subject.subject_id AS 'subject_id', subject.subject_maijor AS 'subject_maijor', subject.subject_name AS 'subject_name', maijor.maijor_name AS 'maijor_name',
                                         subject.colleg_name AS 'college_name', subject.global AS 'global' FROM subject INNER JOIN maijor ON subject.subject_maijor = maijor.maijor_id";
                                         $stmt =mysqli_stmt_init($conn);
                                         if(!mysqli_stmt_prepare($stmt, $sql)){
                                             die('ERROR IN DATABASE');
                                         }else{ 
                                             mysqli_stmt_execute($stmt);
                                             $result = mysqli_stmt_get_result($stmt);
                                             while($row = mysqli_fetch_assoc($result)){
                                                 echo'
                                                <tr>
                                                    <td>'.$row['subject_id'].'</td>
                                                    <td>'.$row['subject_name'].'</td>
                                                    <td>'.$row['maijor_name'].'</td>
                                                    <td>'.$row['college_name'].'</td>
                                                    <td>'; if ($row['global']== 0){
                                                        echo"Private";
                                                    }else{
                                                        echo"Global";
                                                    }
                                                    echo'</td>
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

                        <h5 class="card-title mb-0">Add New Subject</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-0">
                            <div class="col-sm-3 col-xl-12 col-xxl-3 text-center">
                                <img src="../assets/images/book.png" width="64" height="64" class="rounded-circle mt-2"
                                    alt="Angelica Ramos">
                            </div>

                        </div>

                        <form action="api/addSubject.inc.php" method="post">
                            <div class="form-group">
                                <input name="subName" type="text" class="form-control" placeholder="Subject Name"
                                    required autocomplete="off">
                                <br>
                                <select id="college" name="college" class="form-control" required>
                                    </option>
                                    <?php while ($row = mysqli_fetch_array($getCollege)):?>
                                    <option value="<?php echo $row[1];?>"><?php echo $row[1];?>
                                    </option>
                                    <?php endwhile;?>
                                </select>
                                <br>
                                <select name="maijor" class="form-control" required>
                                    </option>
                                    <?php while ($row = mysqli_fetch_array($getMaijor)):?>
                                    <option value="<?php echo $row[0];?>"><?php echo $row[1];?>
                                    </option>
                                    <?php endwhile;?>
                                </select>
                                <br>
                                <select name="global" class="form-control" required>
                                    <option value="1">Make visibel for all students</option>
                                    <option value="0">Make visibel only for College students</option>
                                </select>
                            </div>
                            <div class="modal-footer">
                                <button name="addSubject" type="submit" class="btn btn-success">Add</button>
                            </div>
                        </form>


                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<!-- delete User -->
<div class="modal fade" id="ds" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Are you sure about <span
                        style="font-weight: bold;">DELETING </span> this subject?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="api/deleteSubject.inc.php" method="post">
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">Enter subject Data to confirm</label>
                        <input name="sid" type="text" class="form-control" placeholder="Subject ID" required
                            autocomplete="off">
                        <br>
                        <input name="sm" type="text" class="form-control" placeholder="Subject College" required
                            required autocomplete="off">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button name="deleteSubject" type="submit" class="btn btn-danger">DELETE</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
<?php include '../assets/layouts/footer.php'; ?>