<?php
require_once '../../core/database.php';
if (isset($_POST['pID'])) {

    $pid = $_POST['pID'];
    $days = $_POST['days'];
    $sql = $db->query("UPDATE `pet_sitter` SET `owner_id`='$id', `days`='$days' WHERE `id`='$pid'");

    if ($sql) {
        echo 'updated';
    }
}

if (isset($_POST['pName'])) {
    $pName = $_POST['pName'];
?>
    <?php
    $sitter_data = $db->query("CALL `list_pet_sitters`('$pName')");
    while ($info = mysqli_fetch_object($sitter_data)) :
    ?>
        <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
            <div class="content border p-2 position-relative">
                <div class="logo">
                    <img src="https://picsum.photos/20<?= $info->id ?>" class="rounded-circle w-25" alt="img">
                </div>
                <div class="info">
                    <h4><strong>Name: </strong><?= $info->sitterName ?></h4>
                    <h5><strong>Charges: </strong>$<?= $info->charges ?></h5>
                </div>
                <?php if ($info->ownerId != $id && $info->status == 'approve') { ?>
                    <a href="#!" data-sid="<?= $info->sid ?>" class="btn btn-info btn-md btn-sitter-info" data-toggle="modal" data-target="#modal-default">info</a>
                    <div class="btns">
                        <div class="days">
                            <span>Days:</span>
                            <div class="qty">
                                <button class="btn btn-xs btn-decr"><i class="fas fa-minus"></i></button>
                                <input type="number" value="1" min="1" class="form-control" name="days" id="days">
                                <button class="btn btn-xs btn-incr"><i class="fas fa-plus"></i></button>
                            </div>
                        </div>
                        <a href="#!" data-id="<?= $info->id ?>" class="btn btn-primary btn-md btn-booking">Book</a>
                    </div>
                <?php } else if ($info->ownerId == $id && $info->status == 'approve') {  ?>
                    <a href="#!" data-sid="<?= $info->sid ?>" class="btn btn-primary btn-md btn-sitter-info" data-toggle="modal" data-target="#modal-default">info</a>
                    <a href="#!" class="btn btn-secondary btn-md">Requested</a>
                <?php } else { ?>
                    <a href="#!" data-sid="<?= $info->sid ?>" class="btn btn-primary btn-md btn-sitter-info" data-toggle="modal" data-target="#modal-default">info</a>
                    <a href="#!" class="btn btn-success btn-md">Accepted</a>
                <?php } ?>
            </div>
        </div>
    <?php endwhile; ?>
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
    <script>
        $(document).ready(function() {
            $('.btn-booking').on('click', function(e) {
                let id = $(this).data('id');
                let days = $('.qty input[type="number"]').val();
                $.ajax({
                    url: '<?= site_url ?>forms/ajax/requests.php',
                    method: 'post',
                    data: {
                        pID: id,
                        days: days
                    },
                    success: function(res) {
                        console.log(res);
                        $('.btn-booking').html('Requested').removeClass('btn-primary').addClass('btn-secondary');
                        setTimeout(() => {
                            window.location.href = "";
                        }, 1800);
                    }
                })
            });

            $('.btn-sitter-info').on('click', function(e) {
                e.preventDefault();
                let getSitterInfo = $(this).data('sid');
                $.ajax({
                    url: '<?= site_url ?>forms/ajax/requests.php',
                    method: 'post',
                    data: {
                        getSitterInfo: getSitterInfo
                    },
                    success: function(response) {
                        let res = JSON.parse(response);
                        $('.modal-body h5.name span').html(res.username);
                        $('.modal-body h5.email span').html(res.email);
                        $('.modal-body h5.contact span').html(res.contact);
                        console.log(res);
                    }
                })
            });

            $('.qty').on('click', '.btn-decr', function(e) {
                e.preventDefault();
                let val = +$('.qty input[type="number"]').val();
                $('.qty input[type="number"]').val(val - 1);
            });
            $('.qty').on('click', '.btn-incr', function(e) {
                e.preventDefault();
                let val = +$('.qty input[type="number"]').val();
                $('.qty input[type="number"]').val(val + 1);
            });
        });
    </script>
<?php

}

if (isset($_POST['delete_employee'])) {
    $delID = $_POST['delete_employee'];
    $sql = $db->query("DELETE FROM `employees` WHERE `id`='$delID' AND `role`='employee'");
    if ($sql) {
        echo 'Deleted Successfully!';
    }
}
if (isset($_POST['cancelReq'])) {
    $cancelID = $_POST['cancelReq'];
    $sql = $db->query("UPDATE `pet_sitter` SET `owner_id`='0' WHERE `id`='$cancelID'");
    if ($sql) {
        echo 'Updated Successfully!';
    }
}



if (isset($_POST['approve_emp'])) {
    $approve_emp = $_POST['approve_emp'];
    $sql = $db->query("UPDATE `employees` SET `status`='1' WHERE `id`='$approve_emp'");
    if ($sql) {
        echo 'Updated Successfully!';
    }
}

if (isset($_POST['department_name'])) {
    $dep_name = $_POST['department_name'];
    $check = $db->query("SELECT * FROM `departments` WHERE `department_name`='$dep_name'");
    if (mysqli_num_rows($check) > 0) {
        echo json_encode(['class_' => 'alert-warning', 'msg' => 'Department Already Exist!']);
    } else {
        $dep_added = $db->query("INSERT INTO `departments` (department_name) VALUES('$dep_name')");
        if ($dep_added) {
            echo json_encode(['class_' => 'alert-success', 'msg' => 'Department Added Successfully.']);
        }
    }
}

if (isset($_POST['dept_update_id'])) {
    $dptID = $_POST['dept_update_id'];
    $dep_name = $_POST['dept_name'];

    $check = $db->query("SELECT * FROM `departments` WHERE `department_name`='$dep_name'");
    if (mysqli_num_rows($check) > 0) {
        echo json_encode(['class_' => 'alert-warning p-2', 'msg' => 'Department Already Exist!', 'status' => 'error']);
    } else {
        $dep_upd = $db->query("UPDATE `departments` SET `department_name`='$dep_name' WHERE `id`='$dptID'");
        if ($dep_upd) {
            echo json_encode(['class_' => 'alert-success p-2', 'msg' => 'Department Updated Successfully.', 'status' => 'success']);
        }
    }
}

if (isset($_POST['add_emp'])) {
    $cols = '';
    $values = '';
    $Dir = '../../uploads/';
    $imgDir = 'uploads/';
    $rand = rand(10, 999);
    $target_file = $Dir . $rand . '_' . basename($_FILES["avatar"]["name"]);
    $db_file_path = $imgDir . $rand . '_' . basename($_FILES["avatar"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    if (
        $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif"
    ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    } else {
        if (move_uploaded_file($_FILES["avatar"]["tmp_name"], $target_file)) {
            $_POST['password'] = md5($_POST['password']);
            foreach ($_POST as $key => $value) {
                if ($key != 'add_emp')
                    $cols .= $key . ',';
                $values .= "'" . $value . "',";
            }
            $cols = $cols . 'avatar';
            $values = substr($values, 0, strlen($values) - 6);
            $values = $values . "'" . $db_file_path . "'";

            $add_emp = $db->query("INSERT INTO `employees` ($cols) VALUES($values)");
            if ($add_emp) {
                echo 'Employee has been added.';
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}

if (isset($_POST['edit_emp'])) {
    $empEID = $_POST['edit_emp'];
    $pwd = $_POST['check_pwd'];
    $checkPwdQ = $db->query("SELECT `password` FROM `employees` WHERE `id`='$empEID'");
    $checkPwd = mysqli_fetch_object($checkPwdQ);
    if ($pwd == $checkPwd->password) {
        $_POST['password'] = $checkPwd->password;
    } else {
        $_POST['password'] = md5($_POST['password']);
    }
    echo $_POST['password'];
    die();
    $cols = '';
    $values = array();
    if (!empty($_FILES['avatar_new']['name'])) {
        $Dir = '../../uploads/';
        $imgDir = 'uploads/';
        $rand = rand(10, 999);
        $target_file = $Dir . $rand . '_' . basename($_FILES["avatar_new"]["name"]);
        $db_file_path = $imgDir . $rand . '_' . basename($_FILES["avatar_new"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        if (
            $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
            && $imageFileType != "gif"
        ) {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        } else {
            if (move_uploaded_file($_FILES["avatar_new"]["tmp_name"], $target_file)) {
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
        $_POST['avatar'] = $db_file_path;
    } else {
    }
    foreach ($_POST as $key => $value) {
        if ($key != 'edit_emp' && $key != 'check_pwd')
            $values[] .= "$key = '" . $value . "'";
    }
    $values = join(', ', $values);
    $edit_emp = $db->query("UPDATE `employees` SET " . $values . " WHERE `id`='$empEID'");
    if ($edit_emp) {
        echo json_encode(['class_' => 'alert-success', 'msg' => 'Employee has been updated.']);
    }
}


if (isset($_POST['getDepInfo'])) {
    $getDepInfo = $_POST['getDepInfo'];
    $deptQ = $db->query("SELECT * FROM `departments` WHERE `id`='$getDepInfo'");
    $dept = mysqli_fetch_object($deptQ);
    echo json_encode(['id' => $dept->id, 'name' => $dept->department_name]);
}

if (isset($_POST['acceptReq'])) {
    $acceptReq = $_POST['acceptReq'];
    $days = $_POST['days'];
    $currentDate = date('Y-m-d');
    $endDate = date('Y-m-d', strtotime('+' . $days . ' days'));
    $sql = $db->query("UPDATE `pet_sitter` SET `status`='active', `start_date`='$currentDate', `end_date`='$endDate' WHERE `id`='$acceptReq'");
    if ($sql) {
        echo 'Updated Successfully!';
    }
}

if (isset($_POST['get_dept_by_emp_id'])) {
    $empID = $_POST['get_dept_by_emp_id'];
    $getDept = $db->query("CALL `get_dept_by_emp_id`($empID)");
    $getDept = mysqli_fetch_object($getDept);
    echo json_encode(['id' => $getDept->id, 'name' => $getDept->department_name]);
}

if (isset($_POST['edit_sitter_info'])) {
    $edit_sitter_info = $_POST['edit_sitter_info'];
    $sql = $db->query("SELECT `id`,`pet_name`,`charges`,`services_offer` FROM `pet_sitter` WHERE `id`='$edit_sitter_info'");
    $edit_sitter = mysqli_fetch_array($sql);
    $edit_sitter = json_encode($edit_sitter);
    echo $edit_sitter;
}

if (isset($_POST['getSitterInfo'])) {
    $getSitterInfo = $_POST['getSitterInfo'];
    $sql = $db->query("SELECT * FROM `users` WHERE `id`='$getSitterInfo'");
    $fetchSitterInfo = mysqli_fetch_object($sql);
    echo json_encode($fetchSitterInfo);
}


if (isset($_POST['add_task_db'])) {

    $cols = '';
    $values = '';
    foreach ($_POST as $key => $value) {
        if ($key != 'add_task_db')
            $cols .= $key . ',';
        if ($value != 'add_task_db')
            $values .= "'" . $value . "',";
    }
    $cols = substr($cols, 0, strlen($cols) - 1);
    $values = substr($values, 0, strlen($values) - 1);

    $add_task = $db->query("INSERT INTO `task` ($cols) VALUES($values)");
    if ($add_task) {
        echo json_encode(['class_' => 'alert-success', 'msg' => 'Task Added Successfully.']);
    }
}

if (isset($_POST['getTaskInfo'])) {
    $getTaskInfo = $_POST['getTaskInfo'];
    $getTaskQ = $db->query("SELECT * FROM `task` WHERE `id`='$getTaskInfo'");
    $getTask = mysqli_fetch_object($getTaskQ);
    $arr = ['id' => $getTask->id, 'comments' => $getTask->comments, 'progress' => $getTask->task_progress, 'status' => $getTask->task_status];
    echo json_encode($arr);
}

if (isset($_POST['task_id'])) {
    $task_id = $_POST['task_id'];
    $comments = $_POST['comments'];
    $task_progress = $_POST['task_progress'];
    $task_status = $_POST['task_status'];

    $upd_task = $db->query("UPDATE `task` SET `task_progress`='$task_progress',`task_status`='$task_status',`comments`='$comments' WHERE `id`='$task_id'");
    if ($upd_task) {
        echo json_encode(['class_' => 'alert-success p-2', 'msg' => 'Task Updated Successfully.']);
    }
}

if (isset($_POST['getTaskEditInfo'])) {
    $getTaskEditInfo = $_POST['getTaskEditInfo'];
    $getTaskEditQ = $db->query("SELECT * FROM `task` WHERE `id`='$getTaskEditInfo'");
    $TaskEdit_data = mysqli_fetch_object($getTaskEditQ);
    echo json_encode(['id' => $TaskEdit_data->id, 'title' => $TaskEdit_data->task_title, 'desc' => $TaskEdit_data->task_desc, 'priority' => $TaskEdit_data->task_priority, 'end_date' => $TaskEdit_data->task_end_date]);
}

if (isset($_POST['task_upd_id_dir'])) {
    $values = array();
    $upd_id = $_POST['task_upd_id_dir'];
    foreach ($_POST as $key => $val) {
        if ($key != 'task_upd_id_dir')
            $values[] .= $key . '=' . "'" . $val . "'";
    }
    $values = join(',', $values);

    $upd_db = $db->query("UPDATE `task` SET $values WHERE `id`='$upd_id'");
    if ($upd_db) {
        echo json_encode(['class_' => 'alert-success p-2', 'msg' => 'Task Updated Successfully.']);
    }
}

if (isset($_POST['delete_task'])) {
    $del_task = $_POST['delete_task'];
    $del_task = $db->query("DELETE FROM `task` WHERE `id`='$del_task'");
    if ($del_task) {
        echo json_encode(['class_' => 'alert-success p-2', 'msg' => 'Task Deleted Successfully.']);
    }
}

if (isset($_POST['meeting_title']) && isset($_POST['meeting_link']) && !isset($_POST['meeting_update_id'])) {
    $Employees = $_POST['employee_ids'];
    $_POST['employee_ids'] = implode(',', $Employees);

    $cols = '';
    $values = '';

    foreach ($_POST as $key => $value) {
        $cols .= $key . ',';
        $values .= "'" . $value . "',";
    }
    $cols = substr($cols, 0, strlen($cols) - 1);
    $values = substr($values, 0, strlen($values) - 1);

    $insert_meeting = $db->query("INSERT INTO `meeting` ($cols) VALUES($values)");
    if ($insert_meeting) {
        echo json_encode(['class_' => 'alert-success', 'msg' => 'Meeting Added Successfully.']);
    }
}

if (isset($_POST['getMeetingInfo'])) {
    $mID = $_POST['getMeetingInfo'];

    $getMeetData = $db->query("SELECT * FROM `meeting` WHERE `id`='$mID'");
    $m = mysqli_fetch_object($getMeetData);
    $ids = $m->employee_ids;
    $getEmp = $db->query("SELECT * FROM `employees` WHERE id IN ($ids)");
    $names = '';
    while ($emp_ = mysqli_fetch_object($getEmp)) :
        $names .= $emp_->name . ',';
    endwhile;
    $names = substr($names, 0, strlen($names) - 1);
    $arr = ['id' => $m->id, 'title' => $m->meeting_title, 'jd' => $m->joining_date, 'link' => $m->meeting_link, 'emp_names' => $names];
    echo json_encode($arr);
}

if (isset($_POST['meeting_update_id'])) {
    $updMID = $_POST['meeting_update_id'];
    $_POST['employee_ids'] = implode(',', $_POST['employee_ids']);
    $values = array();
    foreach ($_POST as $key => $value) {
        if ($key != 'meeting_update_id')
            $values[] .= $key . '=' . "'" . $value . "'";
    }
    $values = join(',', $values);
    $updMeeting = $db->query("UPDATE `meeting` SET $values WHERE `id`='$updMID'");
    if ($updMeeting) {
        echo json_encode(['class_' => 'alert-success p-2', 'msg' => 'Meeting Updated Successfully.']);
    }
}

if (isset($_POST['delete_meeting'])) {
    $delID = $_POST['delete_meeting'];
    $delM = $db->query("DELETE FROM `meeting` WHERE `id`='$delID'");
    if ($delM) {
        echo 'Deleted Successfully.';
    }
}
if (isset($_POST['delete_department'])) {
    $delID = $_POST['delete_department'];
    $delM = $db->query("DELETE FROM `departments` WHERE `id`='$delID'");
    if ($delM) {
        echo 'Deleted Successfully.';
    }
}



?>