<?php
require_once '../core/database.php';
$pageTitle = 'Edit Employee';
if (!is_loggedin()) {
?><script>
        window.location.href = "../login.php";
    </script><?php
            } else if($role != 'director') {
             ?>
             <script>
            window.location.href = "../index.php";
        </script>
             <?php
            }
            include_once '../includes/header.php';
            include_once '../includes/aside.php';

            if(isset($_GET['emp_id'])) {
                $emp_id = $_GET['emp_id'];
            }

                ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><?=$pageTitle?></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active"><?=$pageTitle?></li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <h3 class="card-title"><?=$pageTitle?> Details</h3>
                            <h3 class="card-title h3 position-absolute msg-table edit p-2 rounded"></h3>
                        </div>
                        <!-- /.card-header -->
                        <?php
                        $check = $db->query("SELECT * FROM `employees` WHERE `id`='$emp_id' AND `role`!='director'");
                        if(mysqli_num_rows($check)> 0):
                            $empData = mysqli_fetch_object($check);
                        ?>
                        <div class="card-body">
                            <form id="edit_employee" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-12 col-lg-3">
                                        <div class="form-group">
                                            <label for="emp_name">Employee Name</label>
                                            <input type="text" value="<?=$empData->name?>" class="form-control" name="name" id="emp_name">
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-3">
                                        <div class="form-group">
                                            <label for="emp_email">Employee Email</label>
                                            <input type="email" value="<?=$empData->email?>" class="form-control" name="email" id="emp_email">
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-3">
                                        <div class="form-group">
                                            <label for="password">Password <span class="text-danger"> (leave blank if not changing)</span></label>
                                            <input type="password" class="form-control" name="password" id="password">
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-3">
                                        <div class="form-group">
                                            <label for="contact">Contact Number</label>
                                            <input type="text" value="<?=$empData->contact?>" class="form-control" name="contact" id="contact">
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-3">
                                        <div class="form-group">
                                            <label for="dob">Date of Birth</label>
                                            <input type="date" value="<?=$empData->dob?>" class="form-control" name="dob" id="dob">
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-9">
                                        <div class="form-group">
                                            <label for="address">Address</label>
                                            <input type="text" value="<?=$empData->address?>" class="form-control" name="address" id="address">
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-3">
                                        <div class="form-group">
                                            <label for="joining_date">Joining Date</label>
                                            <input type="date" value="<?=$empData->joining_date?>" class="form-control" name="joining_date" id="joining_date">
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-3">
                                        <div class="form-group">
                                            <label for="designation">Designation</label>
                                            <input type="text" value="<?=$empData->designation?>" class="form-control" name="designation" id="designation">
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-3">
                                        <div class="form-group">
                                            <label for="department">Department</label>
                                            <select class="form-control" name="department" id="department" required>
                                                <?php
                                                $dep = $db->query("CALL `get_departments`()");
                                                while($depData = mysqli_fetch_object($dep)):
                                                    ?>
                                                <option <?=($empData->department == $depData->id) ? 'selected':''?> value="<?=$depData->id?>"><?=$depData->department_name?></option>
                                                <?php endwhile;
                                                $dep->close();
                                                $db->next_result();
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-3">
                                    <img src="<?=site_url.$empData->avatar?>" class="avatar-img position-absolute" alt="avatar_<?=$empData->id?>">
                                        <div class="form-group">
                                            <label for="avatar_new">Avatar</label>
                                            <input type="file" class="form-control" name="avatar_new" id="avatar_new">
                                        </div>
                                    </div>
                                    <div class="col-12 d-flex justify-content-end mt-3">
                                        <div class="form-group">
                                            <input type="hidden" name="avatar" value="<?=$empData->avatar?>">
                                            <input type="hidden" name="edit_emp" value="<?=$empData->id?>">
                                            <input type="hidden" name="check_pwd" value="<?=$empData->password?>">
                                            <button type="submit" class="btn btn-primary">Update Employee</button>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <?php else: ?>
                            <h4 class="text-center p-2 mb-0 alert-warning">No Record Found!</h4>
                            <script>setTimeout(function(){window.location.href = '<?=site_url?>index.php'},1800)</script>
                        <?php endif; ?>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->

                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Pet Sitter Info</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <h5 class="name">Name: <span></span></h5>
                <h5 class="email">Email: <span></span></h5>
                <h5 class="contact">Contact: <span></span></h5>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<?php include_once '../includes/footer.php'; ?>
<script>
    $(document).ready(function() {

        $('#edit_employee').on('submit', function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            console.log(formData);
            $.ajax({
                url: 'ajax/requests.php',
                method: 'post',
                data: formData,
                success: function(res) {
                    let response = JSON.parse(res);
                    $('.msg-table').addClass(response.class_).html(response.msg);
                    setTimeout(function() {
                        location.reload();
                    }, 1800);
                },
                cache:false,
                contentType:false,
                processData:false
            });
        });

        $('.btn-sitter-info').on('click', function(e) {
            e.preventDefault();
            let getSitterInfo = $(this).data('sid');
            $.ajax({
                url: 'ajax/requests.php',
                method: 'post',
                data: {
                    getSitterInfo: getSitterInfo
                },
                success: function(response) {
                    let res = JSON.parse(response);
                    $('.modal-body h5.name span').html(res.username);
                    $('.modal-body h5.email span').html(res.email);
                    $('.modal-body h5.contact span').html(res.contact);
                }
            })
        });

        $('.btn-delete').on('click', function(e) {
            e.preventDefault();
            let id = $(this).data('id');
            $.ajax({
                url: 'ajax/requests.php',
                method: 'post',
                data: {
                    delete_sitter: id
                },
                success: function(res) {
                    $('.msg-table').html(res);
                    setTimeout(function() {
                        location.reload()
                    }, 1800);
                }
            });
        });

    });
</script>