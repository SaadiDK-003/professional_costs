<?php
require_once '../core/database.php';
$pageTitle = 'Add Task';
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
<style>
select[name="department_id"] {
    appearance: none;
    -webkit-appearance: none;
    pointer-events: none;
}
</style>
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
                            <h3 class="w-100 card-title p-2 h3 text-center rounded msg-table"></h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <form id="add_task">
                                <div class="row">
                                <div class="col-12 col-lg-6">
                                        <div class="form-group">
                                        <label for="employee_id">Employee</label>
                                            <select class="form-control" name="employee_id" id="employee_id" required>
                                                <option value="" selected hidden>Select Employee</option>
                                                <?php
                                                $emp_list = $db->query("CALL `get_list_employees`()");
                                                while($emp = mysqli_fetch_object($emp_list)):
                                                ?>
                                                <option value="<?=$emp->id?>"><?=$emp->name?></option>
                                                <?php endwhile;
                                                $emp_list->close();
                                                $db->next_result();
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <div class="form-group">
                                            <label for="department_id">Department</label>
                                            <select class="form-control" name="department_id" id="department_id" required readonly></select>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-4">
                                        <div class="form-group">
                                            <label for="task_title">Task Title</label>
                                            <input type="text" name="task_title" id="task_title" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-8">
                                        <div class="form-group">
                                            <label for="task_desc">Task Description</label>
                                            <input type="text" name="task_desc" id="task_desc" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <div class="form-group">
                                            <label for="task_priority">Task Priority</label>
                                            <select name="task_priority" id="task_priority" class="form-control">
                                                <option value="" selected hidden>Select Priority</option>
                                                <option value="normal">Normal</option>
                                                <option value="medium">Medium</option>
                                                <option value="urgent">Urgent</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <div class="form-group">
                                            <label for="task_end_date">Task End Date</label>
                                            <input type="date" name="task_end_date" id="task_end_date" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <div class="form-group">
                                            <label for="task_points">Task Points</label>
                                            <input type="number" min="1" name="task_points" id="task_points" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-12 d-flex justify-content-end mt-3">
                                        <div class="form-group">
                                            <input type="hidden" name="add_task_db" value="add_task_db">
                                            <button type="submit" class="btn btn-primary">Add Task</button>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </form>
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

        $('#add_task').on('submit', function(e) {
            e.preventDefault();
            let formData = $(this).serialize();
            $.ajax({
                url: '<?=site_url?>forms/ajax/requests.php',
                method: 'post',
                data: formData,
                success: function(res) {
                    // console.log(res);
                    let response = JSON.parse(res);
                    // console.log(response);
                    $('.msg-table').addClass(response.class_).html(response.msg);
                    setTimeout(function() {
                        location.reload();
                    }, 1800);
                }
            });
        });

        $(document).on('change','#employee_id', function(e){
            let id = $(this).find('option:selected').val();
            $.ajax({
                url: '<?=site_url?>forms/ajax/requests.php',
                method:'post',
                data: {
                    get_dept_by_emp_id: id
                },
                success: function(response){
                    let res = JSON.parse(response);
                    $('select[name="department_id"]').find('option').remove();
                    $('select[name="department_id"]').append(`<option value="${res.id}">${res.name}</option>`);
                }
            })
        });

    });
</script>