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
                $city               = $_POST['city'];
                $state              = $_POST['state'];
                $zip                = $_POST['zip'];

                $dbUsers = $db->query("SELECT * FROM `users` WHERE `username`='$username'");

                if (empty($username) || empty($email) || empty($contact) || empty($dob) || empty($addr) || empty($city) || empty($state) || empty($zip)) {
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
                        $sql = $db->query("UPDATE `users` SET `username`='$username',`email`='$email',`password`='$pwd',`contact`='$contact',`dob`='$dob',`address`='$addr',`city`='$city',`state`='$state',`zip`='$zip' WHERE `id`='$id'");
                        if ($sql) {
                            $msg = 'Successfully Updated.';
                            $msgStatus = 1;
                            echo '<script>setTimeout(function(){window.location.href=""},2800)</script>';
                        }
                    } else {
                        $sql = $db->query("UPDATE `users` SET `username`='$username',`email`='$email',`contact`='$contact',`dob`='$dob',`address`='$addr',`city`='$city',`state`='$state',`zip`='$zip' WHERE `id`='$id'");
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
                    <div class="card card-secondary">
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
                                        <label for="city">City</label>
                                        <input type="text" class="form-control" name="city" id="city" value="<?= (isset($_POST['city']) ? $_POST['city'] : $data->city) ?>" required>
                                    </div>
                                    <div class="form-group col-lg-4 col-md-12">
                                        <label for="state">State</label>
                                        <select name="state" id="state" class="form-control">
                                            <option value="<?= (isset($_POST['state']) ? $_POST['state'] : $data->state) ?>" selected="" hidden="" data-select2-id="2"><?= (isset($_POST['state']) ? $_POST['state'] : $data->state) ?></option>
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
                                    <div class="form-group col-lg-4 col-md-12">
                                        <label for="address">Address</label>
                                        <input type="text" class="form-control" name="address" value="<?= (isset($_POST['address']) ? $_POST['address'] : $data->address) ?>" id="address" required>
                                    </div>
                                    <div class="form-group col-lg-4 col-md-12">
                                        <label for="zip">Zip</label>
                                        <input type="text" class="form-control" name="zip" id="zip" value="<?= (isset($_POST['zip']) ? $_POST['zip'] : $data->zip) ?>" required>
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