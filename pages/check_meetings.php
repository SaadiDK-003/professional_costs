<?php
require_once '../core/database.php';
$pageTitle = 'Meetings List';
if (!is_loggedin()) {
?><script>
        window.location.href = "../login.php";
    </script><?php
            } else if ($role != 'director') {
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
                    <h1><?= $pageTitle ?></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active"><?= $pageTitle ?></li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-lg-8">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <h3 class="card-title"><?= $pageTitle ?></h3>
                            <h3 class="card-title p-2 msg-table"></h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example2" class="table table-bordered table-hover text-center">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Joining Date</th>
                                        <th>Link</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $getData = $db->query("CALL `check_meetings`()");
                                    while ($row = mysqli_fetch_object($getData)) {
                                    ?>
                                        <tr>
                                            <td><?= $row->title ?></td>
                                            <td><?= $row->jd ?></td>
                                            <td><?= $row->link ?></td>
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
                                        <th>Title</th>
                                        <th>Joining Date</th>
                                        <th>Link</th>
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
                <h4 class="modal-title">Meeting Update</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h5 id="showMsg" class="text-center"></h5>
                <form id="update_meeting">
                    <div class="row">
                        <div class="col-12 col-lg-6">
                            <div class="form-group">
                                <label for="meeting_title">Meeting Title</label>
                                <input type="text" name="meeting_title" id="meeting_title" class="form-control">
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="form-group">
                                <label for="joining_date">Joining Date</label>
                                <input type="datetime-local" name="joining_date" id="joining_date" class="form-control">
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="employee_ids">Employees</label>
                                <select name="employee_ids[]" multiple class="select2" id="employee_ids">
                                    <?php
                                    $emp_list = $db->query("CALL `get_list_employees`()");
                                    while ($emp = mysqli_fetch_object($emp_list)) :
                                    ?>
                                        <option value="<?= $emp->id ?>"><?= $emp->name ?></option>
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
                                <input type="text" name="meeting_link" id="meeting_link" class="form-control">
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
                    <input type="hidden" name="meeting_update_id" id="meeting_update_id">
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

        $('#update_meeting').on('submit', function(e) {
            e.preventDefault();
            let formData = $(this).serialize();
            $.ajax({
                url: '<?= site_url ?>forms/ajax/requests.php',
                method: 'post',
                data: formData,
                success: function(res) {
                    let response = JSON.parse(res);
                    $('#showMsg').addClass(response.class_).html(response.msg);
                    setTimeout(function() {
                        location.reload();
                    }, 1500);
                }
            });
        });

        $('.btn-info').on('click', function(e) {
            e.preventDefault();
            let getMeetingInfo = $(this).data('id');
            $.ajax({
                url: '<?= site_url ?>forms/ajax/requests.php',
                method: 'post',
                data: {
                    getMeetingInfo: getMeetingInfo
                },
                success: function(response) {
                    let res = JSON.parse(response);
                    $('#meeting_title').val(res.title);
                    $('#joining_date').val(res.jd);
                    var employeeNames = res.emp_names.split(',');
                    // Get the select element
                    var selectElement = $('#employee_ids');

                    // Iterate through each option
                    selectElement.find('option').each(function() {
                        var option = $(this);
                        // Check if the option's name matches any of the names received from AJAX
                        if (employeeNames.indexOf(option.text()) !== -1) {
                            // If it matches, select the option
                            option.prop('selected', true);
                        } else {
                            // If it doesn't match, deselect the option
                            option.prop('selected', false);
                        }
                    });

                    // Reinitialize Select2
                    selectElement.select2();

                    $('#meeting_link').val(res.link);
                    $('#meeting_update_id').val(res.id);
                }
            })
        });

        $('.btn-delete').on('click', function(e) {
            e.preventDefault();
            let id = $(this).data('id');
            $.ajax({
                url: '<?= site_url ?>forms/ajax/requests.php',
                method: 'post',
                data: {
                    delete_meeting: id
                },
                success: function(res) {
                    $('.msg-table').addClass('alert-success').html(res);
                    setTimeout(function() {
                        location.reload();
                    }, 1800);
                }
            });
        });

    });
</script>