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
    $sql = $db->query("DELETE FROM `employees` WHERE `id`='$delID'");
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
    if(mysqli_num_rows($check) > 0){
        echo json_encode(['class_'=>'alert-warning','msg'=>'Department Already Exist!']);
    } else {
        $dep_added = $db->query("INSERT INTO `departments` (department_name) VALUES('$dep_name')");
        if($dep_added) {
            echo json_encode(['class_'=>'alert-success','msg'=>'Department Added Successfully.']);
        }
    }
}

if(isset($_POST['add_emp'])) {
    $cols = '';
    $values = '';
    $Dir = '../../uploads/';
    $imgDir = 'uploads/';
    $rand = rand(10,999);
    $target_file = $Dir .$rand.'_'. basename($_FILES["avatar"]["name"]);
    $db_file_path = $imgDir .$rand.'_'. basename($_FILES["avatar"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
      echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    }else {
        if (move_uploaded_file($_FILES["avatar"]["tmp_name"], $target_file)) {
            $_POST['password'] = md5($_POST['password']);
            foreach ($_POST as $key => $value) {
                if($key != 'add_emp')
                    $cols .= $key.',';
                    $values .= "'".$value."',";
            }
            $cols = $cols.'avatar';
            $values = substr($values, 0, strlen($values) - 6);
            $values = $values."'".$db_file_path."'";
            
            $add_emp = $db->query("INSERT INTO `employees` ($cols) VALUES($values)");
            if($add_emp){
              echo 'Employee has been added.';
            }
          } else {
            echo "Sorry, there was an error uploading your file.";
          }
    }
}

if(isset($_POST['edit_emp'])) {
        $empEID = $_POST['edit_emp'];
        $pwd = $_POST['check_pwd'];
        $checkPwdQ = $db->query("SELECT `password` FROM `employees` WHERE `id`='$empEID'");
        $checkPwd = mysqli_fetch_object($checkPwdQ);
        if($pwd == $checkPwd) {
            $_POST['password'] = $pwd;
        } else {
            $_POST['password'] = md5($_POST['password']);
        }

        $cols = '';
        $values = array();
        if(!empty($_FILES['avatar_new']['name'])){
        $Dir = '../../uploads/';
        $imgDir = 'uploads/';
        $rand = rand(10,999);
        $target_file = $Dir .$rand.'_'. basename($_FILES["avatar_new"]["name"]);
        $db_file_path = $imgDir .$rand.'_'. basename($_FILES["avatar_new"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
          echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        }else {
            if (move_uploaded_file($_FILES["avatar_new"]["tmp_name"], $target_file)) {
              } else {
                echo "Sorry, there was an error uploading your file.";
              }
        }
        $_POST['avatar'] = $db_file_path;
    } else {
    }
    foreach ($_POST as $key => $value) {
        if($key != 'edit_emp' && $key != 'check_pwd')
            $values[] .= "$key = '" . $value . "'";
    }
    $values = join(', ', $values);
        $edit_emp = $db->query("UPDATE `employees` SET ".$values." WHERE `id`='$empEID'");
        if($edit_emp){
          echo json_encode(['class_'=>'alert-success','msg'=>'Employee has been updated.']);
        }
    }

    
if(isset($_POST['getInfo'])){
    $getInfo = $_POST['getInfo'];
    $deptQ = $db->query("SELECT * FROM `departments` WHERE `id`='$getInfo'");
    $dept = mysqli_fetch_object($deptQ);
    echo json_encode(['id'=>$dept->id,'name'=>$dept->department_name]);
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

?>