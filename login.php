<?php
// require_once 'config.php';
require_once 'core/database.php';
require_once 'includes/head.php';

$msg = '';
$pageTitle = 'Login';

if(isset($_POST['submit'])) {
    $email = $_POST['email'];
    $pwd = $_POST['password'];
    $loginCheck = login($email,$pwd,$db);
    if($loginCheck === true) {
        ?><script>window.location.href = "index.php";</script><?php
    } else {
        $msg = 'Username or Password is incorrect!';
    }
}

?>
<body>


<div class="container">
    <div class="row vh-100 align-items-center justify-content-center">
        <div class="col-lg-4 col-md-6">
            <img src="./dist/img/pro_costs.png" class="d-block mx-auto w-50" alt="">
            <h5 class="text-center text-danger mb-3 font-weight-bold"><?=$msg?></h5>
            <h3 class="text-center mb-3 font-weight-bold"><?=$pageTitle?></h3>
            <form id="login-form" action="" method="post">
                <div class="row">
                    <div class="col-12 mb-3">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" name="email" id="email" required>
                    </div>
                    <div class="col-12 mb-3">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" name="password" id="password" required>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <input type="checkbox" name="remember_me" id="remember_me">
                            <label for="remember_me">Remember Me</label>
                        </div>
                    </div>
                    <div class="col-6 d-flex justify-content-end">
                        <a href="forgetPassword.php">Forget Password</a>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-chocolate w-100" name="submit" id="login-btn">Login</button>
                    </div>
                </div>
            </form>
            <div class="row">
                <div class="col-12 mt-3 text-center">
                    <p class="text-bold">Need to Register ?</p>
                    <a href="register.php" class="btn btn-dark-chocolate btn-md w-100">Register</a>
                </div>
            </div>
        </div>
    </div>
</div>



<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="<?=site_url?>plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="<?=site_url?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- bs-custom-file-input -->
<script src="<?=site_url?>plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
<!-- overlayScrollbars -->
<script src="<?=site_url?>plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="<?=site_url?>dist/js/adminlte.js"></script>

<!-- PAGE PLUGINS -->
<!-- jQuery Mapael -->
<script src="<?=site_url?>plugins/jquery-mousewheel/jquery.mousewheel.js"></script>
<script src="<?=site_url?>plugins/raphael/raphael.min.js"></script>
<script src="<?=site_url?>plugins/jquery-mapael/jquery.mapael.min.js"></script>
<script src="<?=site_url?>plugins/jquery-mapael/maps/usa_states.min.js"></script>
<!-- ChartJS 
<script src="< ?=site_url?>plugins/chart.js/Chart.min.js"></script>
-->
<!-- DataTables  & Plugins -->
<script src="<?=site_url?>plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?=site_url?>plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?=site_url?>plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?=site_url?>plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="<?=site_url?>plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?=site_url?>plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="<?=site_url?>plugins/jszip/jszip.min.js"></script>
<script src="<?=site_url?>plugins/pdfmake/pdfmake.min.js"></script>
<script src="<?=site_url?>plugins/pdfmake/vfs_fonts.js"></script>
<script src="<?=site_url?>plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="<?=site_url?>plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="<?=site_url?>plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<!-- InputMask -->
<script src="<?=site_url?>plugins/moment/moment.min.js"></script>
<script src="<?=site_url?>plugins/inputmask/jquery.inputmask.min.js"></script>
<!-- dateRangePicker -->
<script src="<?=site_url?>plugins/daterangepicker/daterangepicker.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?=site_url?>dist/js/demo.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) 
<script src="< ?=site_url?>dist/js/pages/dashboard2.js"></script>
-->


<script>
    $(document).ready(function(){
        // $('#login-form').on('submit', function(e){
        //     e.preventDefault();
            
        // });
    });
</script>

</body>
</html>