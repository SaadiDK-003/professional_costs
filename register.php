<?php
// require_once 'config.php';
require_once 'core/database.php';
require_once 'includes/head.php';

$pageTitle = 'Professional Costs';

$username           = '';
$email              = '';
$pwd                = '';
$confirm_pwd        = '';
$contact            = '';
$dob                = '';
$addr               = '';
$city               = '';
$state              = '';
$zip                = '';
$role               = '';
$msg = '';
$msgStatus = 0;
if (isset($_POST['submit'])) {
    $username           = $_POST['username'];
    $email              = $_POST['email'];
    $pwd                = $_POST['password'];
    $confirm_pwd        = $_POST['c_password'];
    $contact            = $_POST['contact'];
    $dob                = $_POST['dob'];
    $addr               = $_POST['address'];
    $city               = $_POST['city'];
    $state              = $_POST['state'];
    $zip                = $_POST['zip'];
    $role               = $_POST['role'];

    $dbUsers = $db->query("SELECT * FROM `users` WHERE `username`='$username'");

    if (empty($username) || empty($email) || empty($pwd) || empty($confirm_pwd) || empty($contact) || empty($dob) || empty($addr) || empty($city) || empty($state) || empty($zip) || empty($role)) {
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
        $sql = $db->query("INSERT INTO `users` (username,email,password,contact,dob,address,city,state,zip,status,role) VALUES('$username','$email','$pwd','$contact','$dob','$addr','$city','$state','$zip','0','$role')");
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
                <h5 class="text-center <?= ($msgStatus == 0) ? 'text-danger' : 'text-success' ?> mb-3 font-weight-bold"><?= $msg ?></h5>
                <h3 class="text-center mb-3 font-weight-bold"><?=$pageTitle?> | Register</h3>
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
                        <div class="col-4 mb-3">
                            <label for="city">City</label>
                            <input type="text" class="form-control" name="city" id="city" value="<?=(isset($_POST['city']) ? $_POST['city'] : '')?>" required>
                        </div>
                        <div class="col-4 mb-3">
                            <label for="state">State</label>
                            <select name="state" id="state" class="form-control">
                                <option value="<?=(isset($_POST['state']) ? $_POST['state'] : '')?>" selected="" hidden="" data-select2-id="2"><?=(isset($_POST['state']) ? $_POST['state'] : 'Select State')?></option>
                                <option value="Alabama" data-select2-id="31">
                                    Alabama </option>
                                <option value="Alaska" data-select2-id="32">
                                    Alaska </option>
                                <option value="Arkansas" data-select2-id="33">
                                    Arkansas </option>
                                <option value="Arizona" data-select2-id="34">
                                    Arizona </option>
                                <option value="California" data-select2-id="35">
                                    California </option>
                                <option value="Colorado" data-select2-id="36">
                                    Colorado </option>
                                <option value="Connecticut" data-select2-id="37">
                                    Connecticut </option>
                                <option value="Delaware" data-select2-id="38">
                                    Delaware </option>
                                <option value="District of Columbia" data-select2-id="39">
                                    District of Columbia </option>
                                <option value="Florida" data-select2-id="40">
                                    Florida </option>
                                <option value="Georgia" data-select2-id="41">
                                    Georgia </option>
                                <option value="Hawaii" data-select2-id="42">
                                    Hawaii </option>
                                <option value="Idaho" data-select2-id="43">
                                    Idaho </option>
                                <option value="Illinois" data-select2-id="44">
                                    Illinois </option>
                                <option value="Indiana" data-select2-id="45">
                                    Indiana </option>
                                <option value="Iowa" data-select2-id="46">
                                    Iowa </option>
                                <option value="Kansas" data-select2-id="47">
                                    Kansas </option>
                                <option value="Kentucky" data-select2-id="48">
                                    Kentucky </option>
                                <option value="Louisiana" data-select2-id="49">
                                    Louisiana </option>
                                <option value="Maine" data-select2-id="50">
                                    Maine </option>
                                <option value="Maryland" data-select2-id="51">
                                    Maryland </option>
                                <option value="Massachusetts" data-select2-id="52">
                                    Massachusetts </option>
                                <option value="Michigan" data-select2-id="53">
                                    Michigan </option>
                                <option value="Minnesota" data-select2-id="54">
                                    Minnesota </option>
                                <option value="Mississippi" data-select2-id="55">
                                    Mississippi </option>
                                <option value="Missouri" data-select2-id="56">
                                    Missouri </option>
                                <option value="Montana" data-select2-id="57">
                                    Montana </option>
                                <option value="Nebraska" data-select2-id="58">
                                    Nebraska </option>
                                <option value="Nevada" data-select2-id="59">
                                    Nevada </option>
                                <option value="New Hampshire" data-select2-id="60">
                                    New Hampshire </option>
                                <option value="New Jersey" data-select2-id="61">
                                    New Jersey </option>
                                <option value="New Mexico" data-select2-id="62">
                                    New Mexico </option>
                                <option value="New York" data-select2-id="63">
                                    New York </option>
                                <option value="North Carolina" data-select2-id="64">
                                    North Carolina </option>
                                <option value="North Dakota" data-select2-id="65">
                                    North Dakota </option>
                                <option value="Ohio" data-select2-id="66">
                                    Ohio </option>
                                <option value="Oklahoma" data-select2-id="67">
                                    Oklahoma </option>
                                <option value="Oregon" data-select2-id="68">
                                    Oregon </option>
                                <option value="Pennsylvania" data-select2-id="69">
                                    Pennsylvania </option>
                                <option value="Rhode Island" data-select2-id="70">
                                    Rhode Island </option>
                                <option value="South Carolina" data-select2-id="71">
                                    South Carolina </option>
                                <option value="South Dakota" data-select2-id="72">
                                    South Dakota </option>
                                <option value="Tennessee" data-select2-id="73">
                                    Tennessee </option>
                                <option value="Texas" data-select2-id="74">
                                    Texas </option>
                                <option value="Utah" data-select2-id="75">
                                    Utah </option>
                                <option value="Vermont" data-select2-id="76">
                                    Vermont </option>
                                <option value="Virginia" data-select2-id="77">
                                    Virginia </option>
                                <option value="Washington" data-select2-id="78">
                                    Washington </option>
                                <option value="West Virginia" data-select2-id="79">
                                    West Virginia </option>
                                <option value="Wisconsin" data-select2-id="80">
                                    Wisconsin </option>
                                <option value="Wyoming" data-select2-id="81">
                                    Wyoming </option>
                            </select>
                        </div>
                        <div class="col-4 mb-3">
                            <label for="zip">Zip</label>
                            <input type="text" class="form-control" name="zip" id="zip" value="<?=(isset($_POST['zip']) ? $_POST['zip'] : '')?>" required>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary w-100" name="submit" id="register-btn">Register</button>
                        </div>
                    </div>
                </form>
                <div class="row">
                    <div class="col-12 mt-3 text-center">
                        <p class="text-bold">Already Registered ?</p>
                        <a href="login.php" class="btn btn-info btn-md w-100">Login</a>
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