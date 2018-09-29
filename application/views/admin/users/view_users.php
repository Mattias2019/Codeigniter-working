<?php $this->load->view('header1');
if(isset($countUsers)) { $countUsers = $countUsers->result_array(); }
if(isset($countOnlineUsers)) { $countOnlineUsers = $countOnlineUsers->result_array(); }
if(isset($countOnlineUsers)) { $countOnlineEntrepreneur = $countOnlineEntrepreneur->result_array(); }
if(isset($countOnlineUsers)) { $countOnlineProvider = $countOnlineProvider->result_array(); }
?>

<div class="view-users">
    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <a href="index.html">Home</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span>User Manager</span>
            </li>
        </ul>
    </div>

    <h1 class="page-title"> User Manager
        <small>Manage all existing users</small>
    </h1>

    <div class="row">
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <a class="dashboard-stat dashboard-stat-v2 blue" href="#">
                <div class="visual">
                    <i class="fa fa-users"></i>
                </div>
                <div class="details">
                    <div class="number">
                        <span data-counter="counterup" data-value="<?php echo $countOnlineUsers[0]['count_online_users'] ?>"><?php echo $countOnlineUsers[0]['count_online_users'] ?></span>
                    </div>
                    <div class="desc"> Online Users </div>
                </div>
            </a>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <a class="dashboard-stat dashboard-stat-v2 grey" href="#">
                <div class="visual">
                    <i class="fa fa-users"></i>
                </div>
                <div class="details">
                    <div class="number">
                        <span data-counter="counterup" data-value="<?php echo $countOnlineEntrepreneur[0]['count_online_users'] ?>"><?php echo $countOnlineEntrepreneur[0]['count_online_users'] ?></span>
                    </div>
                    <div class="desc"> <?php echo ROLE_ENTREPRENEUR; ?> </div>
                </div>
            </a>
        </div>

        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <a class="dashboard-stat dashboard-stat-v2 blue" href="#">
                <div class="visual">
                    <i class="fa fa-users"></i>
                </div>
                <div class="details">
                    <div class="number">
                        <span data-counter="counterup" data-value="<?php echo $countOnlineProvider[0]['count_online_users'] ?>"><?php echo $countOnlineProvider[0]['count_online_users'] ?></span>
                    </div>
                    <div class="desc"> <?php echo ROLE_PROVIDER; ?> </div>
                </div>
            </a>
        </div>

        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
            <a class="dashboard-stat dashboard-stat-v2 green" href="#">
                <div class="visual">
                    <i class="fa fa-users"></i>
                </div>
                <div class="details">
                    <div class="number">
                        <span data-counter="counterup" data-value="<?php echo $countUsers[0]['count'] ?>"><?php echo $countUsers[0]['count'] ?></span>
                    </div>
                    <div class="desc"> Total Users </div>
                </div>
            </a>
        </div>
    </div>

    <?php
        //Show Flash Message
        if($msg = $this->session->flashdata('flash_message'))
        {
            echo $msg;
        }
    ?>

    <form class="form" role="form">
        <div class="row">
            <div class="col-md-2">
                <div class="form-group form-md-line-input form-md-floating-label">
                    <input type="text" class="form-control" id="username" value="<?php echo set_value('username', $view_users_filter["username"]); ?>">
                    <label for="username">Username</label>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group form-md-line-input form-md-floating-label">
                    <div class="input-group">

                        <div class="input-group-control">
                            <select class="form-control" id="role_id">
                                <option value="" selected></option>
                                <?php
                                if(isset($roles) and $roles->num_rows()>0) {
                                    foreach ($roles->result() as $role) {
                                        ?>
                                        <option value="<?php echo $role->id; ?>" <?php if (set_value('role_id', $view_users_filter["role_id"]) == $role->id) echo "selected"; ?>> <?php echo $role->role_name ?> </option>
                                        <?php
                                    }
                                }
                                ?>
                            </select>
                            <label for="role_id" class="control-label">Role</label>
                        </div>

                        <span class="input-group-btn btn-right">
                            <button id="find-user-btn" name="find-user-btn" class="btn green"><i class="fa fa-search"></i> <?= t('filter_results');?> </button>
                        </span>

                        <span class="input-group-btn btn-right">
                            <button id="reset-find-user-btn" name="reset-find-user-btn" class="btn red"><i class="fa fa-remove"></i> <?= t('reset_filter');?> </button>
                        </span>

                    </div>
                </div>
            </div>

            <div class="col-md-6" align="right">
                <div class="form-group form-md-line-input">
                    <div class="btn-group">
                        <a class="btn btn-success" href="<?php echo admin_url('users/addUser');?>"><i class="fa fa-plus"></i> Add New User</a>
                    </div>
                </div>
                <!--                <div class="btn-group">-->
                <!--                    <button id="del_users" class="btn red">-->
                <!--                      <i class="fa fa-trash"></i>-->
                <!--                      Delete selected Users-->
                <!--                    </button>-->
                <!--                </div>-->
            </div>

        </div>
    </form>

    <div class="users-table">
        <?php $this->load->view('admin/users/view_usersTable', $this->outputData); ?>
        <?php $this->load->view('pagination', $this->outputData); ?>
    </div>

</div>

<?php $this->load->view('footer1'); ?>