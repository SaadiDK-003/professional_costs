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
                    <h1>Pet Sitter List</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Pet Sitter List</li>
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
                            <h3 class="card-title">List of Pet Sitters</h3>
                        </div>
                        <!-- /.card-header -->

                        <div class="row text-center p-3">
                            <div class="col-12 mb-3 text-left">
                                <label for="animal">Select Pet</label>
                                <select name="select_pet" id="select_pet" class="form-control">
                                    <option value="" selected hidden>Select Pet</option>
                                    <option value="Cat">Cat</option>
                                    <option value="Dog">Dog</option>
                                    <option value="Mouse">Mouse</option>
                                </select>
                            </div>
                        </div>
                        <div class="row text-center p-3 render_data"></div>

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
        
        $('#select_pet').on('change', function(e) {
            let pName = $(this).val();
            $.ajax({
                url: 'ajax/requests.php',
                method: 'post',
                data: {
                    pName:pName 
                },
                success: function(res) {
                    $('.render_data').html(res);
                }
            })
        });
    });
</script>