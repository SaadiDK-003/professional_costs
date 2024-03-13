<?php
require_once '../core/database.php';
$pageTitle = 'Department List';
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
            <div class="col-12 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title"><?=$pageTitle?></h3>
                        <h3 class="card-title position-absolute text-success h3 msg-table" style="left:50%;transform:translateX(-50%)"></h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="example2" class="table table-bordered table-hover text-center">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Department Name</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                    <?php
                                $getData = $db->query("CALL `get_departments`()");
                                while ($row = mysqli_fetch_object($getData)) {
                                ?>
                                    <tr>
                                        <td><?= $row->id ?></td>
                                        <td><?= $row->department_name ?></td>
                                        <td>
                                        <a data-id="<?= $row->id ?>" class="btn btn-sm btn-info btn-primary" data-toggle="modal" data-target="#modal-default">Edit</a> |
                                            <a data-id="<?= $row->id ?>" class="btn btn-sm btn-danger btn-delete">Remove</a>
                                        </td>
                                    </tr>
                                <?php }
                                $getData->close();
                                $db->next_result();
                                ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Department Name</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
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
                <h4 class="modal-title">Department Update</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h5 id="showMsg" class="text-center"></h5>
                <form id="update_dept">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                            <label for="dept_name">Department Name</label>
                            <input type="text" name="dept_name" id="dept_name" class="form-control">
                            </div>
                        </div>
                        <div class="col-12 d-flex justify-content-end">
                            <div class="form-group">
                            <button type="submit" name="upd_dept" id="upd_dept" class="btn btn-primary">
                                Update
                            </button>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="dept_update_id" id="dept_update_id">
                </form>
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

        $('#update_dept').on('submit', function(e) {
            e.preventDefault();
            let formData = $(this).serialize();
            $.ajax({
                url: '<?=site_url?>forms/ajax/requests.php',
                method: 'post',
                data: formData,
                success: function(res) {
                    console.log(res);
                    let response = JSON.parse(res);
                    $('#showMsg').addClass(response.class_).html(response.msg);
                    if(response.status == 'success') {
                        setTimeout(function() {
                            location.reload();
                        }, 1500);
                    } else {
                        setTimeout(function() {
                            $('#showMsg').removeClass(response.class_).html('');
                        }, 1200);
                    }

                }
            });
        });

        $('.btn-info').on('click', function(e) {
            e.preventDefault();
            let getInfo = $(this).data('id');
            $.ajax({
                url: '<?=site_url?>forms/ajax/requests.php',
                method: 'post',
                data: {
                    getDepInfo: getInfo
                },
                success: function(response) {
                    let res = JSON.parse(response);
                    $('#dept_update_id').val(res.id);
                    $('#dept_name').val(res.name);
                    // let res = JSON.parse(response);
                    // $('.modal-body h5.name span').html(res.username);
                    // $('.modal-body h5.email span').html(res.email);
                    // $('.modal-body h5.contact span').html(res.contact);
                }
            })
        });

        $('.btn-delete').on('click', function(e) {
            e.preventDefault();
            let id = $(this).data('id');
            $.ajax({
                url: '<?=site_url?>forms/ajax/requests.php',
                method: 'post',
                data: {
                    delete_employee: id
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