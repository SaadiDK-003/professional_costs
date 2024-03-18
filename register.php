<?php
// require_once 'config.php';
require_once 'core/database.php';
require_once 'includes/head.php';

$pageTitle = 'Register';

$username           = '';
$email              = '';
$pwd                = '';
$confirm_pwd        = '';
$contact            = '';
$dob                = '';
$addr               = '';
$msg = '';
$designation = '';
$msgStatus = 0;
if (isset($_POST['submit'])) {
    $username           = $_POST['username'];
    $email              = $_POST['email'];
    $pwd                = $_POST['password'];
    $confirm_pwd        = $_POST['c_password'];
    $contact            = $_POST['contact'];
    $dob                = $_POST['dob'];
    $addr               = $_POST['address'];
    $designation        = $_POST['designation'];

    $dbUsers = $db->query("SELECT * FROM `employees` WHERE `name`='$username'");

    if (empty($username) || empty($email) || empty($pwd) || empty($confirm_pwd) || empty($contact) || empty($dob) || empty($addr) || empty($designation)) {
        $msg .= 'All fields are required!';
        $msgStatus = 0;
    } else if (mysqli_num_rows($dbUsers) > 0) {
        $msg = 'username already exists';
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $msg .= 'Email Should be valid';
        $msgStatus = 0;
    } else if ($pwd != $confirm_pwd) {
        $msg .= "Password & Confirm Password Does't match.";
        $msgStatus = 0;
    } else {
        $pwd = md5($pwd);
        $sql = $db->query("INSERT INTO `employees` (name,email,password,contact,dob,address,designation) VALUES('$username','$email','$pwd','$contact','$dob','$addr','$designation')");
        if ($sql) {
            $msg = 'Successfully Registered.';
            $msgStatus = 1;
            echo '<script>setTimeout(function(){window.location.href = "login.php"},2800)</script>';
        }
    }
}

?>

<body>

    <div class="container">
        <div class="row vh-100 align-items-center justify-content-center">
            <div class="col-lg-8 col-md-6">
                <img src="./dist/img/pro_costs.png" class="d-block mx-auto w-25" alt="">
                <h5 class="text-center <?= ($msgStatus == 0) ? 'text-danger' : 'text-success' ?> mb-3 font-weight-bold"><?= $msg ?></h5>
                <h3 class="text-center mb-3 font-weight-bold"><?=$pageTitle?></h3>
                <form id="login-form" action="" method="post">
                    <div class="row">
                        <div class="col-6 mb-3">
                            <label for="username">Name</label>
                            <input type="text" class="form-control" name="username" id="username" value="<?=(isset($_POST['username']) ? $_POST['username'] : '')?>" required>
                        </div>
                        <div class="col-6 mb-3">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" name="email" id="email" value="<?=(isset($_POST['email']) ? $_POST['email'] : '')?>" required>
                        </div>
                        <div class="col-6 mb-3">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" name="password" id="password" required>
                        </div>
                        <div class="col-6 mb-3">
                            <label for="c_password">Confirm Password</label>
                            <input type="password" class="form-control" name="c_password" id="c_password" required>
                        </div>
                        <div class="col-6 mb-3">
                            <label for="contact">Phone</label>
                            <input type="text" class="form-control" name="contact" value="<?=(isset($_POST['contact']) ? $_POST['contact'] : '')?>" id="contact" required>
                        </div>
                        <div class="col-6 mb-3">
                            <label for="dob">Date Of Birth</label>
                            <input type="date" class="form-control" name="dob" id="dob" value="<?=(isset($_POST['dob']) ? $_POST['dob'] : '')?>" required>
                        </div>
                        <div class="col-6 mb-3">
                            <label for="designation">Designation</label>
                            <input type="text" name="designation" id="designation" class="form-control" required>
                        </div>
                        <div class="col-6 mb-3">
                            <label for="address">Address</label>
                            <input type="text" class="form-control" name="address" value="<?=(isset($_POST['address']) ? $_POST['address'] : '')?>" id="address" required>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-chocolate w-100" name="submit" id="register-btn">Register</button>
                        </div>
                    </div>
                </form>
                <div class="row">
                    <div class="col-12 mt-3 text-center">
                        <p class="text-bold">Already Registered ?</p>
                        <a href="login.php" class="btn btn-dark-chocolate btn-md w-100">Login</a>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- REQUIRED SCRIPTS -->
    <!-- jQuery -->
    <script src="<?= site_url ?>plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="<?= site_url ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- bs-custom-file-input -->
    <script src="<?= site_url ?>plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
    <!-- overlayScrollbars -->
    <script src="<?= site_url ?>plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?= site_url ?>dist/js/adminlte.js"></script>

    <!-- PAGE PLUGINS -->
    <!-- jQuery Mapael -->
    <script src="<?= site_url ?>plugins/jquery-mousewheel/jquery.mousewheel.js"></script>
    <script src="<?= site_url ?>plugins/raphael/raphael.min.js"></script>
    <script src="<?= site_url ?>plugins/jquery-mapael/jquery.mapael.min.js"></script>
    <script src="<?= site_url ?>plugins/jquery-mapael/maps/usa_states.min.js"></script>
    <!-- ChartJS 
<script src="< ?=site_url?>plugins/chart.js/Chart.min.js"></script>
-->
    <!-- DataTables  & Plugins -->
    <script src="<?= site_url ?>plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="<?= site_url ?>plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="<?= site_url ?>plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="<?= site_url ?>plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="<?= site_url ?>plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="<?= site_url ?>plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="<?= site_url ?>plugins/jszip/jszip.min.js"></script>
    <script src="<?= site_url ?>plugins/pdfmake/pdfmake.min.js"></script>
    <script src="<?= site_url ?>plugins/pdfmake/vfs_fonts.js"></script>
    <script src="<?= site_url ?>plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="<?= site_url ?>plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="<?= site_url ?>plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
    <!-- InputMask -->
    <script src="<?= site_url ?>plugins/moment/moment.min.js"></script>
    <script src="<?= site_url ?>plugins/inputmask/jquery.inputmask.min.js"></script>
    <!-- dateRangePicker -->
    <script src="<?= site_url ?>plugins/daterangepicker/daterangepicker.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="<?= site_url ?>dist/js/demo.js"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) 
<script src="< ?=site_url?>dist/js/pages/dashboard2.js"></script>
-->


    <script>
        $(document).ready(function() {
            // $('#login-form').on('submit', function(e){
            //     e.preventDefault();

            // });
        });
    </script>

</body>

</html>