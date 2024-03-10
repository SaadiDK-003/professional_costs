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
                    <h1>Pet Owner Requests</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Pet Owner Requests</li>
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
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">List of Pet Owners Requests</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="row text-center p-3">
                            <?php
                            $sitter_data = $db->query("CALL `get_pet_owners_requests`('$id')");
                            while ($info = mysqli_fetch_object($sitter_data)) :
                            ?>
                                <div class="col-lg-3 col-md-6 col-sm-12 mb-3">
                                    <div class="content border p-2">
                                        <div class="logo">
                                            <img src="https://picsum.photos/20<?=$info->id?>" class="rounded-circle w-25" alt="img">
                                        </div>
                                        <div class="info">
                                            <h3><?= $info->pet_name ?></h3>
                                            <p>$<?= $info->charges ?></p>
                                            <p>days: <?= $info->days ?></p>
                                        </div>
                                        <?php if ($info->status != 'active') : ?>
                                            <a href="#!" data-days="<?=$info->days?>" data-id="<?= $info->id ?>" class="btn btn-success btn-md btn-accept">Accept</a>
                                            <a href="#!" data-id="<?= $info->id ?>" class="btn btn-danger btn-md btn-denied">Denied</a>
                                        <?php else : ?>
                                            <a href="#!" class="btn btn-success btn-md">Accepted</a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endwhile; ?>
                        </div>

                    </div>
                    <!-- /.card -->
                </div>
                <!--/.col (left) -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php include_once '../includes/footer.php'; ?>

<script>
    $(document).ready(function() {
        $('.btn-denied').on('click', function(e){
            e.preventDefault();
            let id = $(this).data('id');
            $.ajax({
                url:'ajax/requests.php',
                method:'post',
                data:{cancelReq:id},
                success:function(res){
                    setTimeout(function(){location.reload()},1800);
                }
            })
        });
        
        $('.btn-accept').on('click', function(e){
            e.preventDefault();
            let id = $(this).data('id');
            let days = $(this).data('days');
            $.ajax({
                url:'ajax/requests.php',
                method:'post',
                data:{acceptReq:id,days:days},
                success:function(res){
                    // console.log(res);
                    setTimeout(function(){window.location.href = "<?=site_url?>"},1800);
                }
            })
        });

    });
</script>