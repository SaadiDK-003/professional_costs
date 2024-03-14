<?php
require_once '../core/database.php';
$pageTitle = 'Task List In-Progress';
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
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h3 class="card-title"><?=$pageTitle?></h3>
                        <h3 class="card-title msg-table"></h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="example2" class="table table-bordered table-hover text-center">
                            <thead>
                                <tr>
                                    <th>Emp Name</th>
                                    <th>Task Title</th>
                                    <th>Task Desc</th>
                                    <th>Priority</th>
                                    <th>End Date</th>
                                    <th>Progress <span class="text-success">%</span></th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                    <?php
                                $getData = $db->query("CALL `get_all_in_complete_task`()");
                                while ($row = mysqli_fetch_object($getData)) {
                                    $taskStatus = $row->task_status;
                                    $pri = $row->pri;
                                    $progress = $row->progress;
                                ?>
                                    <tr>
                                        <td><?= $row->name ?></td>
                                        <td><?= $row->title ?></td>
                                        <td><?= $row->desc ?></td>
                                        <td>
                                            <?php if($pri == 'urgent'):?>
                                                <span class="btn btn-sm btn-danger"><?= $pri ?></span>
                                            <?php elseif($pri == 'medium'): ?>
                                                <span class="btn btn-sm btn-warning"><?= $pri ?></span>
                                                <?php else: ?>                                                    
                                                <span class="btn btn-sm btn-success"><?= $pri ?></span>
                                            <?php endif; ?>

                                        </td>
                                        <td><?=$row->end_date?></td>
                                        <td>
                                            <?php
                                            if($progress <= 30){
                                                ?>
                                                <div class="prog">
                                                <span><?=$progress?>%</span>
                                                <progress max="100" style="accent-color: red;" value="<?=$progress?>"></progress>
                                                </div>
                                                <?php

                                            } else if($progress > 31 && $progress <=70) {
                                                ?>
                                                <div class="prog">
                                                <span><?=$progress?>%</span>
                                                <progress max="100" style="accent-color: blue;" value="<?=$progress?>"></progress>
                                                </div>
                                                <?php
                                            } else {
                                                ?>
                                                <div class="prog">
                                                <span><?=$progress?>%</span>
                                                <progress max="100" style="accent-color: green;" value="<?=$progress?>"></progress>
                                                </div>
                                                <?php
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php if($taskStatus == 'pending'):?>
                                                <span class="btn btn-sm btn-warning"><?= $taskStatus ?></span>
                                            <?php elseif($taskStatus == 'progress'): ?>
                                                <span class="btn btn-sm btn-info"><?= $taskStatus ?></span>
                                                <?php else: ?>                                                    
                                                <span class="btn btn-sm btn-success"><?= $taskStatus ?></span>
                                            <?php endif; ?>

                                        </td>
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
                                    <th>Emp Name</th>
                                    <th>Task Title</th>
                                    <th>Task Desc</th>
                                    <th>Priority</th>
                                    <th>End Date</th>
                                    <th>Progress <span class="text-success">%</span></th>
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

<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Task Update</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h5 id="updMsg" class="text-center"></h5>
                <form id="update_task_director">
                    <div class="row">
                        <div class="col-12 col-lg-4">
                            <div class="form-group">
                            <label for="task_title">Title</label>
                            <input type="text" name="task_title" id="task_title" class="form-control">
                            </div>
                        </div>
                        <div class="col-12 col-lg-8">
                            <div class="form-group">
                            <label for="task_desc">Description</label>
                            <input type="text" name="task_desc" id="task_desc" class="form-control">
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="form-group">
                            <label for="task_priority">Priority</label>
                            <select name="task_priority" id="task_priority" class="form-control">
                                <option value="" selected hidden></option>
                                <option value="normal">Normal</option>
                                <option value="medium">Medium</option>
                                <option value="urgent">Urgent</option>
                            </select>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="form-group">
                            <label for="task_end_date">End Date</label>
                            <input type="date" name="task_end_date" id="task_end_date" class="form-control">
                            </div>
                        </div>
                        <div class="col-12 d-flex justify-content-end">
                            <div class="form-group">
                                <input type="hidden" name="task_upd_id_dir" id="task_upd_id_dir">
                            <button type="submit" name="upd_dept" id="upd_dept" class="btn btn-primary">
                                Update
                            </button>
                            </div>
                        </div>
                    </div>
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

        $('#update_task_director').on('submit', function(e) {
            e.preventDefault();
            let formData = $(this).serialize();
            console.log(formData);
            $.ajax({
                url: '<?=site_url?>forms/ajax/requests.php',
                method: 'post',
                data: formData,
                success: function(res) {
                    let response = JSON.parse(res);
                    $('#updMsg').addClass(response.class_).html(response.msg);
                    setTimeout(function() {
                        location.reload();
                    }, 1800);
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
                    getTaskEditInfo: getInfo
                },
                success: function(response) {
                    let res = JSON.parse(response);
                    console.log(res);
                    $('#task_upd_id_dir').val(res.id);
                    $('#task_title').val(res.title);
                    $('#task_desc').val(res.desc);
                    $('#task_priority').val(res.priority);
                    $('#task_end_date').val(res.end_date);
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
                    delete_task: id
                },
                success: function(response) {
                    let res = JSON.parse(response);
                    $('.msg-table').addClass(res.class_).html(res.msg);
                    setTimeout(function() {
                        location.reload();
                    }, 1800);
                }
            });
        });

    });
</script>