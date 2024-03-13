<?php
require_once '../core/database.php';
$pageTitle = 'View Task Completed';
if (!is_loggedin()) {
?><script>
        window.location.href = "../login.php";
    </script><?php
            }
             ?>
             <?php
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
                    <div class="card-header">
                        <h3 class="card-title"><?=$pageTitle?></h3>
                        <h3 class="card-title position-absolute text-success h3 msg-table" style="left:50%;transform:translateX(-50%)"></h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table id="task_table" class="table table-bordered table-hover text-center">
                            <thead>
                                <tr>
                                    <th>Task Title</th>
                                    <th>Task Desc</th>
                                    <th>Priority</th>
                                    <th>End Date</th>
                                    <th>progress <span class="text-success">%</span></th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                    <?php
                                $getData = $db->query("CALL `get_task_by_id_completed`($id)");
                                while ($row = mysqli_fetch_object($getData)) {
                                    $taskStatus = $row->task_status;
                                    $pri = $row->task_priority;
                                    $progress = $row->task_progress;
                                ?>
                                    <tr>
                                        <td><?= $row->task_title ?></td>
                                        <td><?= $row->task_desc ?></td>
                                        <td>
                                            <?php if($pri == 'urgent'):?>
                                                <span class="btn btn-sm btn-danger"><?= $pri ?></span>
                                            <?php elseif($pri == 'medium'): ?>
                                                <span class="btn btn-sm btn-warning"><?= $pri ?></span>
                                                <?php else: ?>                                                    
                                                <span class="btn btn-sm btn-success"><?= $pri ?></span>
                                            <?php endif; ?>

                                        </td>
                                        <td><?= $row->task_end_date ?></td>
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
                                    </tr>
                                <?php }
                                $getData->close();
                                $db->next_result();
                                ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Task Title</th>
                                    <th>Task Desc</th>
                                    <th>Priority</th>
                                    <th>End Date</th>
                                    <th>progress <span class="text-success">%</span></th>
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
                <h4 class="modal-title">Task Update</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h5 id="updMsg" class="text-center"></h5>
                <form id="update_task">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                            <label for="comments">Comments</label>
                            <input type="text" name="comments" id="comments" class="form-control">
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="form-group">
                            <label for="task_progress">Progress <span class="text-success">%</span></label>
                            <select name="task_progress" id="task_progress" class="form-control">
                                <option value="" selected hidden>Select Progress</option>
                                <option value="10">10</option>
                                <option value="20">20</option>
                                <option value="30">30</option>
                                <option value="40">40</option>
                                <option value="50">50</option>
                                <option value="60">60</option>
                                <option value="70">70</option>
                                <option value="80">80</option>
                                <option value="90">90</option>
                                <option value="100">100</option>
                            </select>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="form-group">
                            <label for="task_progress">Status</label>
                            <select name="task_status" id="task_status" class="form-control">
                                <option value="" selected hidden>Select status</option>
                                <option value="progress">In Progress</option>
                                <option value="completed">Completed</option>
                            </select>
                            </div>
                        </div>
                        <div class="col-12 d-flex justify-content-end">
                            <div class="form-group">
                            <input type="hidden" id="task_id" name="task_id">
                            <button type="submit" name="upd_task" id="upd_task" class="btn btn-primary">
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
