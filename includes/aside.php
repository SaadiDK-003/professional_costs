<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.php" class="brand-link">
        <img src="<?= site_url ?>dist/img/Logo.png" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light"><?= website_title ?></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="<?= site_url . $avatar ?>" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block"><?= $username ?></a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="<?= site_url ?>" class="nav-link active">
                        <i class="fas fa-home nav-icon"></i>
                        <p><?= $Dashboard_ ?? 'Dashboard' ?></p>
                    </a>
                </li>
                <?php if ($role == 'director') { ?>
                    <!-- ADD and Manage Departments -->
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon far fa-building"></i>
                            <p>
                                <?= $Department_ ?? 'Department' ?>
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="<?= site_url ?>forms/add_department.php" class="nav-link">
                                    <i class="nav-icon far fa-circle"></i>
                                    <p><?= $Add_Department_ ?? 'Add Department' ?></p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= site_url ?>pages/departments_list.php" class="nav-link">
                                    <i class="nav-icon far fa-circle"></i>
                                    <p><?= $Manage_Department_ ?? 'Manage Department' ?></p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <!-- ADD and Manage Employees -->
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-user-friends"></i>
                            <p>
                                <?= $Employees_ ?? 'Employees' ?>
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="<?= site_url ?>forms/add_employee.php" class="nav-link">
                                    <i class="nav-icon far fa-circle"></i>
                                    <p><?= $Reg_Employees_ ?? 'Register Employee' ?></p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= site_url ?>pages/employees_list.php" class="nav-link">
                                    <i class="nav-icon far fa-circle"></i>
                                    <p><?= $Manage_Employees_ ?? 'Manage Employees' ?></p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <!-- ADD and Manage Task -->
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-tasks"></i>
                            <p>
                                <?= $Task_ ?? 'Task' ?>
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="<?= site_url ?>forms/add_task.php" class="nav-link">
                                    <i class="nav-icon far fa-circle"></i>
                                    <p><?= $Add_Task_ ?? 'Add Task' ?></p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= site_url ?>pages/task_list.php" class="nav-link">
                                    <i class="nav-icon far fa-circle"></i>
                                    <p><?= $In_Prog_Task_ ?? 'In-Progress Task' ?></p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= site_url ?>pages/task_list_completed.php" class="nav-link">
                                    <i class="nav-icon far fa-circle"></i>
                                    <p><?= $Completed_Task_ ?? 'Completed Task' ?></p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <!-- ADD and Manage Meeting -->
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-chalkboard-teacher"></i>
                            <p>
                                <?= $Meeting_ ?? 'Meeting' ?>
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="<?= site_url ?>forms/add_meeting.php" class="nav-link">
                                    <i class="nav-icon far fa-circle"></i>
                                    <p><?= $Add_Meeting_ ?? 'Add Meeting' ?></p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= site_url ?>pages/check_meetings.php" class="nav-link">
                                    <i class="nav-icon far fa-circle"></i>
                                    <p><?= $Manage_Meeting_ ?? 'Manage Meeting' ?></p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="<?= site_url ?>forms/edit-profile.php" class="nav-link">
                            <i class="nav-icon far fa-circle text-info"></i>
                            <p><?= $Edit_Profile_ ?? 'Edit Profile' ?></p>
                        </a>
                    </li>

                <?php } else { ?>

                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-tasks"></i>
                            <p>
                                <?= $Task_ ?? 'Task' ?>
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="<?= site_url ?>pages/view_task.php" class="nav-link">
                                    <i class="nav-icon far fa-circle text-info"></i>
                                    <p><?= $View_Task_ ?? 'View Task' ?></p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= site_url ?>pages/view_task_completed.php" class="nav-link">
                                    <i class="nav-icon far fa-circle text-info"></i>
                                    <p><?= $Completed_Task_ ?? 'Completed Task' ?></p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a href="<?= site_url ?>pages/view_meetings.php" class="nav-link">
                            <i class="nav-icon fas fa-chalkboard-teacher text-info"></i>
                            <p><?=$Check_Meetings_??'Check Meetings'?></p>
                        </a>
                    </li>
                <?php } ?>
                <li class="nav-item">
                    <a href="<?= site_url ?>pages/view-profile.php" class="nav-link">
                        <i class="nav-icon far fa-circle text-info"></i>
                        <p><?= $View_Profile_ ?? 'View Profile' ?></p>
                    </a>
                </li>
                <!-- <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-user"></i>
                        <p>
                            Profile
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="< ?= site_url ?>pages/view-profile.php" class="nav-link">
                                <i class="nav-icon far fa-circle text-info"></i>
                                <p>View Profile</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="< ?= site_url ?>forms/edit-profile.php" class="nav-link">
                                <i class="nav-icon far fa-circle text-info"></i>
                                <p>Edit Profile</p>
                            </a>
                        </li>
                    </ul>
                </li>-->
                <li class="nav-item">
                    <a href="<?= site_url ?>logout.php" class="nav-link">
                        <i class="nav-icon fas fa-circle text-danger"></i>
                        <p><?= $Logout_ ?? 'Logout' ?></p>
                    </a>
                </li>

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>