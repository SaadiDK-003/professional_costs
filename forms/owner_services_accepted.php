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
                    <h1>Services Accepted</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Services Accepted</li>
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
                            <h3 class="card-title">Services Accepted</h3>
                            <h3 class="card-title position-absolute text-success h3 msg-table" style="left:50%;transform:translateX(-50%)"></h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                        <?php

check_end_date($db);

?>
                            <table id="example2" class="table table-bordered table-hover text-center">
                                <thead>
                                    <tr>
                                        <th>Sitter Name</th>
                                        <th>Pet Name</th>
                                        <th>Services Offer</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Charges per Day</th>
                                        <th>Total Days</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $getData = $db->query("CALL `services_accepted`($id)");
                                    while ($row = mysqli_fetch_object($getData)) {
                                    ?>
                                        <tr>
                                            <td><?= $row->sitterName ?></td>
                                            <td><?= $row->petName ?></td>
                                            <td><?= $row->services ?></td>
                                            <td><?= $row->startDate ?></td>
                                            <td><?= $row->endDate ?></td>
                                            <td>$<?= $row->charges ?></td>
                                            <td><span class="font-weight-bold">For 
                                                <!-- < ?= $row->days ?> days:</span> $< ?= ($row->days * $row->charges) ?> -->
                                                <?= $row->days . ($row->days == '1' ? ' Day' : ' Days') ?> </span>
                                            </td>
                                            <td><span class="btn <?=($row->status == 'active') ? 'btn-success' : 'btn-danger' ?>"><?= $row->status ?></span></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Sitter Name</th>
                                        <th>Pet Name</th>
                                        <th>Services Offer</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Charges per Day</th>
                                        <th>Total Days</th>
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