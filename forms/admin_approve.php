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
                    <h1>Admin Approval</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Admin Approval</li>
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
                        <div class="card-header">
                            <h3 class="card-title">Admin | Pet Sitter Approval</h3>
                            <h3 class="card-title position-absolute text-success h3 msg-table" style="left:50%;transform:translateX(-50%)"></h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example2" class="table table-bordered table-hover text-center">
                                <thead>
                                    <tr>
                                        <th>Sitter Name</th>
                                        <th>Pet Name</th>
                                        <th>Services Offer</th>
                                        <th>Charges per Hour</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $getData = $db->query("CALL `pet_sitter_list_admin`()");
                                    while ($row = mysqli_fetch_object($getData)) {
                                    ?>
                                        <tr>
                                            <td><?= $row->sitterName ?></td>
                                            <td><?= $row->petName ?></td>
                                            <td><?= $row->services ?></td>
                                            <td><?= $row->charges ?></td>
                                            <td><span class="btn 
                                            <?php if ($row->status == 'pending') { ?>
                                                btn-warning
                                            <?php } else if ($row->status == 'approve' || $row->status == 'active') { ?>
                                                btn-success
                                            <?php } ?>
                                            "><?= $row->status ?></span></td>
                                            <?php if ($row->status != 'active' && $row->status != 'approve') : ?>
                                                <td><a data-id="<?= $row->pID ?>" class="btn btn-success btn-sm btn-approve">Approve</a> <!--| <a data-id="< ?= $row->pID ?>" class="btn btn-sm btn-warning btn-rej">Rejected</a>--> | <a data-id="<?= $row->pID ?>" class="btn btn-sm btn-danger btn-delete">Remove</a></td>
                                            <?php else : ?>
                                                <td>-</td>
                                            <?php endif; ?>
                                        </tr>
                                    <?php }
                                    $getData->close();
                                    $db->next_result();
                                    ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Sitter Name</th>
                                        <th>Pet Name</th>
                                        <th>Services Offer</th>
                                        <th>Charges per Hour</th>
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


    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Admin | Active Services</h3>
                            <h3 class="card-title position-absolute text-success h3" style="left:50%;transform:translateX(-50%)"></h3>
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
                                        <th>Charges per Hour</th>
                                        <th>Total Days</th>
                                        <th>Pet Sitter</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $getData = $db->query("CALL `owners_list_admin`()");
                                    while ($row = mysqli_fetch_object($getData)) {
                                    ?>
                                        <tr>
                                            <td><?= $row->ownerName ?></td>
                                            <td><?= $row->petName ?></td>
                                            <td><?= $row->services ?></td>
                                            <td><?= (empty($row->startDate)) ? '-' : $row->startDate ?></td>
                                            <td><?= (empty($row->endDate)) ? '-' : $row->endDate ?></td>
                                            <td>$<?= $row->charges ?></td>
                                            <td>

                                                <?php if (!empty($row->startDate)) : ?>
                                                    <span class="font-weight-bold">For 
                                                        <!-- < ?= $row->days ?> days:</span> $< ?= ($row->days * $row->charges) ?> -->
                                                        <?= $row->days . ($row->days == '1' ? ' Day' : ' Days') ?> </span>
                                                <?php else : ?>
                                                    ---
                                                <?php endif; ?>

                                            </td>
                                            <td><a href="#!" data-sid="<?= $row->sitterID ?>" class="btn btn-sm btn-info btn-sitter-info" data-toggle="modal" data-target="#modal-default">info</a></td>
                                            <td><span class="btn 
                                            <?php if ($row->status == 'pending') { ?>
                                                btn-warning
                                            <?php } else if ($row->status == 'approve' || $row->status == 'active') { ?>
                                                btn-success
                                            <?php } ?>
                                            "><?= $row->status ?></span></td>
                                        </tr>
                                    <?php }
                                    $getData->close();
                                    ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Service Holder</th>
                                        <th>Pet Name</th>
                                        <th>Services Offer</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Charges per Hour</th>
                                        <th>Total Days</th>
                                        <th>Pet Sitter</th>
                                        <th>Status</th>
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

        $('.btn-approve').on('click', function(e) {
            e.preventDefault();
            let id = $(this).data('id');
            $.ajax({
                url: 'ajax/requests.php',
                method: 'post',
                data: {
                    approve_sitter: id
                },
                success: function(res) {
                    $('.msg-table').html(res);
                    setTimeout(function() {
                        location.reload()
                    }, 1800);
                }
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