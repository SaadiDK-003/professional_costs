<?php
require_once '../core/database.php';
if (!is_loggedin()) {
?><script>
        window.location.href = "../login.php";
    </script><?php
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
                    <h1>Pet Sitter</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Pet Sitter</li>
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
                                        <label for="charges">Charges per Day ($)<span class="text-danger">*</span></label>
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

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">My Services</h3>
                            <h3 class="card-title position-absolute text-danger h3 msg-table" style="left:50%;transform:translateX(-50%)"></h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example2" class="table table-bordered table-hover text-center">
                                <thead>
                                    <tr>
                                        <th>Service Holder</th>
                                        <th>Pet Name</th>
                                        <th>Services Offer</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Charges per Day</th>
                                        <th>Total Charges</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $getData = $db->query("CALL `pet_sitter_list`($id)");
                                    while ($row = mysqli_fetch_object($getData)) {
                                    ?>
                                        <tr>
                                            <td><?= (empty($row->startDate)) ? '-' : $row->u ?></td>
                                            <td><?= $row->petName ?></td>
                                            <td><?= $row->services ?></td>
                                            <td><?= (empty($row->startDate)) ? '-' : $row->startDate ?></td>
                                            <td><?= (empty($row->endDate)) ? '-' : $row->endDate ?></td>
                                            <td>$<?= $row->charges ?></td>
                                            <td>

                                                <?php if (!empty($row->startDate)) : ?>
                                                    <span class="font-weight-bold">For <?= $row->days ?> days:</span> $<?= ($row->days * $row->charges) ?>
                                                <?php else : ?>
                                                    $0
                                                <?php endif; ?>

                                            </td>
                                            <td><span class="<?= ($row->status == 'approve' || $row->status == 'active') ? 'btn btn-success' : 'btn btn-warning' ?>"><?= $row->status ?></span></td>
                                            <td>
                                                <?php if ($row->status == 'pending') { ?>
                                                    <a data-id="<?= $row->pID ?>" class="btn btn-info btn-edit">Edit</a> | <a data-id="<?= $row->pID ?>" class="btn btn-danger btn-delete">Remove</a>
                                                <?php } else { ?>
                                                    -
                                                <?php } ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Service Holder</th>
                                        <th>Pet Name</th>
                                        <th>Services Offer</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Charges per Day</th>
                                        <th>Total Charges</th>
                                        <th>Status</th>
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

<?php include_once '../includes/footer.php'; ?>
<script>
    $(document).ready(function() {

        $('#pet_sitter').on('submit', function(e) {
            e.preventDefault();
            let data = $(this).serialize();
            $.ajax({
                url: 'data-submit.php',
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

        $('.btn-edit').on('click', function(e) {
            e.preventDefault();
            let id = $(this).data('id');
            $.ajax({
                url: 'ajax/requests.php',
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