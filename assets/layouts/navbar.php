<?php if (!isset($_SESSION['auth'])) { ?>

<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm p-2">
    <?php } else { ?>
    <nav class="navbar navbar-expand-md navbar-dark bg-dark shadow-sm p-2">
        <?php } ?>
        <div class="container">
            <a class="navbar-brand" href="../home">

                <img src="../assets/images/logo.png" alt="E-College Logo" width="50" height="50" class="mr-3">
                <?php echo APP_NAME; ?>
            </a>

            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{__('Toggle navigation')}}">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side of Nav EC -->
                <ul class="navbar-nav mr-auto">

                </ul>
                <!-- Right Side of Nav EC -->
                <?php if (isset($_SESSION['auth'])) { ?>
                <ul class="navbar-nav ml-atuo">
                    <?php
                        if ($_SESSION['account'] == "admin") {
                            echo '
                    <li class="nav-item">
                        <a class="nav-link" href="../admin/users.php">Users</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../admin/manageUni.php">Manage</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../admin/showMessges.php">Supprt Inbox</a>
                    </li>
                        ';
                        } elseif ($_SESSION['account'] == "student") {
                            echo '
                    <li class="nav-item">
                        <a class="nav-link" href="../profile">Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../timeline">Timeline</a>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link" href="../community">Community</a>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link" href="../explore">Explore</a>
                     </li>
                    ';
                        } else {
                            echo '
                        <li class="nav-item">
                        <a class="nav-link" href="../teacher/classes.php">Classes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../explore">Explore</a>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link" href="../home">Home</a>
                     </li>
                        ';
                        }
                        ?>


                    <div class="dropdown">
                        <button class="btn btn-dark dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">
                            <img class="navbar-img"
                                src="../assets/uploads/users/<?php echo $_SESSION['profile_image'] ?>">
                            <span class="caret"></span>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="imgdropdown">
                            <a class="dropdown-item text-muted" href="../profile-edit"><i
                                    class="fa fa-pencil-alt pr-2"></i>
                                Edit Profile
                            </a>
                            <a class="dropdown-item text-muted" href="../faq"><i class="fa fa-info pr-2"></i>
                                FAQ
                            </a>
                            <a class="dropdown-item text-muted" href="../logout"><i class="fa fa-running pr-2"></i>
                                LogOut
                            </a>
                        </div>
                    </div>
                </ul>
                <?php } ?>
            </div>
        </div>
    </nav>