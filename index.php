<?php
require_once 'core/database.php';
if (!is_loggedin()) {
?><script>
        window.location.href = "login.php";
    </script><?php
            }
            include_once 'includes/header.php';
            include_once 'includes/aside.php';
                ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <?php if ($data->role == 'director') { ?>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Employees List</h3>
                                <h3 class="card-title position-absolute text-success h3 msg-table" style="left:50%;transform:translateX(-50%)"></h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example2" class="table table-bordered table-hover text-center">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Contact</th>
                                            <th>Designation</th>
                                            <th>Department</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                         <?php
                                        $getData = $db->query("CALL `get_list_employees`()");
                                        while ($row = mysqli_fetch_object($getData)) {
                                        ?>
                                            <tr>
                                                <td><?= $row->name ?></td>
                                                <td><?= $row->email ?></td>
                                                <td><?= $row->contact ?></td>
                                                <td><?= $row->designation ?></td>
                                                <td><?= $row->department_name ?></td>
                                                <td>
                                                <a href="forms/edit_employee.php?emp_id=<?= $row->id ?>" class="btn btn-sm btn-primary">Edit</a> |
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
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Contact</th>
                                            <th>Designation</th>
                                            <th>Department</th>
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

    <?php } ?>


    <?php if ($data->role == 'employee') { ?>

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
                                    <!-- If you need clarification while filling this form then please email us at <strong class="text-warning">support@octoinsurance.com</strong> or call us at <strong class="text-warning">469-898-8348</strong> -->
                                </h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form id="pet_sitter">
                                <div class="card-body">
                                    <!-- row 1 start -->
                                    <div class="row">
                                        <div class="form-group col-lg-6 col-sm-12">
                                            <label for="firstName">Pet Name <span class="text-danger">*</span></label>
                                            <select name="pet_name" id="pet_name" class="form-control" required>
                                                <option value="" selected hidden>Select Pet</option>
                                                <option value="Cat">Cat</option>
                                                <option value="Dog">Dog</option>
                                                <option value="Mouse">Mouse</option>
                                                <option value="Parrot">Parrot</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-lg-6 col-sm-12">
                                            <label for="charges">Charges per Hour ($)<span class="text-danger">*</span></label>
                                            <input type="text" name="charges" class="form-control" id="charges" placeholder="Eg. 5,10,20" required>
                                        </div>
                                        <div class="form-group col-lg-12 col-md-12">
                                            <label for="services_offer">Services offer <span class="text-danger">*</span></label>
                                            <input type="text" name="services_offer" class="form-control" id="services_offer" placeholder="Eg. Dog Walk, Dog Sitting, Cat Care etc." required>
                                        </div>
                                    </div>
                                    <!-- row 1 end -->
                                </div>
                                <!-- /.card-body -->
                                <input type="hidden" name="p" value="pet_sitter_service">
                                <input type="hidden" name="edit_id" value="">
                                <div class="card-footer text-right">
                                    <button type="submit" class="btn btn-primary">Submit</button>
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
    <?php }  ?>


</div>
<!-- /.content-wrapper -->

<?php include_once './includes/footer.php'; ?>
<script>
    $(document).ready(function() {

        $('#select_pet').on('change', function(e) {
            let pName = $(this).val();
            $.ajax({
                url: 'forms/ajax/requests.php',
                method: 'post',
                data: {
                    pName: pName
                },
                success: function(res) {
                    $('.render_data').html(res);
                }
            })
        });


        $('#pet_sitter').on('submit', function(e) {
            e.preventDefault();
            let data = $(this).serialize();
            $.ajax({
                url: 'forms/data-submit.php',
                method: 'post',
                data: data,
                success: function(res) {
                    $('.msg').html(res);
                    setTimeout(function() {
                        location.reload()
                    }, 1800);
                }
            })
        });

        $('.btn-approve').on('click', function(e) {
            e.preventDefault();
            let id = $(this).data('id');
            $.ajax({
                url: 'forms/ajax/requests.php',
                method: 'post',
                data: {
                    approve_emp: id
                },
                success: function(res) {
                    $('.msg-table').html(res);
                    setTimeout(function() {
                        location.reload()
                    }, 1800);
                }
            });
        });

        $('.btn-edit').on('click', function(e) {
            e.preventDefault();
            let id = $(this).data('id');
            $.ajax({
                url: 'forms/ajax/requests.php',
                method: 'post',
                data: {
                    edit_sitter_info: id
                },
                success: function(res) {
                    let data = JSON.parse(res);
                    $(`select[name="pet_name"] option[value=${data.pet_name}]`).attr('selected', true);
                    $('input[name="charges"]').val(data.charges);
                    $('input[name="services_offer"]').val(data.services_offer);
                    $('input[name="edit_id"]').val(data.id);
                    console.log(data);
                }
            });
        });

        $('.btn-sitter-info').on('click', function(e) {
            e.preventDefault();
            let getSitterInfo = $(this).data('sid');
            $.ajax({
                url: 'forms/ajax/requests.php',
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
                url: 'forms/ajax/requests.php',
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