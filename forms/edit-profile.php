<?php
require_once '../core/database.php';
if (!is_loggedin()) {
?><script>
        window.location.href = "../login.php";
    </script><?php
            }
            include_once '../includes/header.php';
            include_once '../includes/aside.php';


            $msg = '';
            $msgStatus = 0;
            if (isset($_POST['submit'])) {
                $username           = $_POST['username'];
                $email              = $_POST['email'];
                $pwd                = $_POST['password'];
                $contact            = $_POST['contact'];
                $dob                = $_POST['dob'];
                $addr               = $_POST['address'];

                $dbUsers = $db->query("SELECT * FROM `employees` WHERE `name`='$username'");

                if (empty($username) || empty($email) || empty($contact) || empty($dob) || empty($addr)) {
                    $msg .= 'All fields are required!';
                    $msgStatus = 0;
                } else if (mysqli_num_rows($dbUsers) > 1) {
                    $msg = 'username already exists';
                } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $msg .= 'Email Should be valid';
                    $msgStatus = 0;
                } else {
                    if (!empty($pwd)) {
                        $pwd = md5($pwd);
                        $sql = $db->query("UPDATE `employees` SET `name`='$username',`email`='$email',`password`='$pwd',`contact`='$contact',`dob`='$dob',`address`='$addr' WHERE `id`='$id'");
                        if ($sql) {
                            $msg = 'Successfully Updated.';
                            $msgStatus = 1;
                            echo '<script>setTimeout(function(){window.location.href=""},2800)</script>';
                        }
                    } else {
                        $sql = $db->query("UPDATE `employees` SET `name`='$username',`email`='$email',`contact`='$contact',`dob`='$dob',`address`='$addr' WHERE `id`='$id'");
                        if ($sql) {
                            $msg = 'Successfully Updated.';
                            $msgStatus = 1;
                            echo '<script>setTimeout(function(){window.location.href=""},2800)</script>';
                        }
                    }
                }
            }
                ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Edit Profile</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Edit Profile</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div id="edit-profile" class="card card-secondary">
                        <div class="card-header">
                            <h3 class="card-title msg">
                                <?= $msg ?>
                                <!-- If you need clarification while filling this form then please email us at <strong class="text-warning">support@octoinsurance.com</strong> or call us at <strong class="text-warning">469-898-8348</strong> -->
                            </h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form method="post" action="">
                            <div class="card-body">
                                <!-- row 1 start -->
                                <div class="row">
                                    <div class="form-group col-lg-4 col-sm-12">
                                        <label for="username">Name</label>
                                        <input type="text" class="form-control" name="username" id="username" value="<?= (isset($_POST['username']) ? $_POST['username'] : $username) ?>" required>
                                    </div>
                                    <div class="form-group col-lg-4 col-sm-12">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control" name="email" id="email" value="<?= (isset($_POST['email']) ? $_POST['email'] : $data->email) ?>" required>
                                    </div>
                                    <div class="form-group col-lg-4 col-sm-12">
                                        <label for="password">Password <i class="text-danger">leave empty if don't wanna change</i></label>
                                        <input type="password" class="form-control" name="password" id="password">
                                    </div>
                                    <div class="form-group col-lg-4 col-md-12">
                                        <label for="contact">Phone</label>
                                        <input type="text" class="form-control" name="contact" value="<?= (isset($_POST['contact']) ? $_POST['contact'] : $data->contact) ?>" id="contact" required>
                                    </div>
                                    <div class="form-group col-lg-4 col-md-12">
                                        <label for="dob">Date Of Birth</label>
                                        <input type="date" class="form-control" name="dob" id="dob" value="<?= (isset($_POST['dob']) ? $_POST['dob'] : $data->dob) ?>" required>
                                    </div>
                                    <div class="form-group col-lg-4 col-md-12">
                                        <label for="address">Address</label>
                                        <input type="text" class="form-control" name="address" value="<?= (isset($_POST['address']) ? $_POST['address'] : $data->address) ?>" id="address" required>
                                    </div>
                                </div>
                                <!-- row 1 end -->
                            </div>
                            <!-- /.card-body -->
                            <input type="hidden" name="p" value="pet_sitter_service">
                            <div class="card-footer text-right">
                                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.card -->
                </div>
                <!--/.col (left) -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->






    <?php include_once '../includes/footer.php'; ?>
    <script>
        $(document).ready(function() {

        });
    </script>