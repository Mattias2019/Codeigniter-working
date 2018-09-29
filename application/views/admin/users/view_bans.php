<?php $this->load->view('header1'); ?>

    <div class="view-bans">
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
            <small>View Bans</small>
        </h1>
				  
        <?php
            //Show Flash Message
            if($msg = $this->session->flashdata('flash_message'))
            {
                echo $msg;
            }
        ?>

        <div class="table-toolbar">
            <div class="row">
                <div class="col-md-12" align="right">
                    <div class="btn-group">
                        <button id="add_ban_btn" name="add_ban_btn" class="btn btn-success"><i class="fa fa-plus"></i> <?= t('Add Ban');?> </button>
<!--                        <a class="btn btn-success" href="--><?php //echo admin_url('users/addBan')?><!--"><i class="fa fa-plus"></i> --><?php //echo t('Add Ban'); ?><!--</a>-->
                    </div>
                </div>
            </div>
        </div>

        <div class="bans-table">
            <?php $this->load->view('admin/users/viewBansTable', $this->outputData); ?>
            <?php $this->load->view('pagination', $this->outputData); ?>
        </div>
    </div>

<?php $this->load->view('footer1'); ?>