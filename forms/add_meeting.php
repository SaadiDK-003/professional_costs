<?php
require_once '../core/database.php';
$pageTitle = 'Add Meeting';
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
                            <h3 class="w-100 card-title p-2 h3 text-center rounded msg-table"></h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <form id="add_meeting">
                                <div class="row">
                                    <div class="col-12 col-lg-6">
                                        <div class="form-group">
                                            <label for="meeting_title">Meeting Title</label>
                                            <input type="text" class="form-control" name="meeting_title" id="meeting_title" required>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-6">
                                        <div class="form-group">
                                            <label for="joining_date">Joining Date</label>
                                            <input type="datetime-local" class="form-control" name="joining_date" id="joining_date" required>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="employee_ids">Employees</label>
                                            <select class="form-control select2" name="employee_ids[]" id="employee_ids" multiple>
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
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="meeting_link">Meeting Link</label>
                                            <input type="text" class="form-control" name="meeting_link" id="meeting_link" required>
                                        </div>
                                    </div>
                                    <div class="col-12 d-flex justify-content-end mt-3">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary">Add Meeting</button>
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

         //Initialize Select2 Elements
        $('.select2').select2();

        //Initialize Select2 Elements
        $('.select2bs4').select2({
        theme: 'bootstrap4'
        });


        $('#add_meeting').on('submit', function(e) {
            e.preventDefault();
            let formData = $(this).serialize();
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
                }
            });
        });
    });
</script>