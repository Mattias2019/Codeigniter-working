<?php $this->load->view('header1');?>

<div class="view-items">

    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <a href="index.html">Home</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span>Items</span>
            </li>
        </ul>
    </div>

    <h1 class="page-title">Manage Items</h1>

    <?php
        //Show Flash Message
        if($msg = $this->session->flashdata('flash_message'))
        {
            echo $msg;
        }
    ?>

    <div class="row">

        <div class="col-md-4">
            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="fa fa-cogs font-green-sharp"></i>
                        <span class="caption-subject font-green-sharp bold uppercase">Groups</span>
                    </div>
                    <div class="actions">
                        <a id="add_tree_item" class="btn btn-circle btn-icon-only btn-default" href="javascript:;" title="Add item">
                            <i class="fa fa-plus"></i>
                        </a>
                        <a id="delete_tree_item" class="btn btn-circle btn-icon-only btn-default" href="javascript:;" title="Delete item">
                            <i class="fa fa-trash"></i>
                        </a>
                        <a id="refresh_tree" class="btn btn-circle btn-icon-only btn-default" href="javascript:;" title="Refresh tree">
                            <i class="fa fa-refresh"></i>
                        </a>
                    </div>
                </div>
                <div class="portlet-body">
                    <div id="groups_tree">

                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8">

            <div class="portlet light portlet-fit bordered">
                <div class="portlet-title">
                    <div align="right">
                        <div class="btn-group">
                            <a class="btn btn-success" id="btn_add_item" href="#">
                                <i class="fa fa-plus"></i>
                                Add Item
                            </a>
                        </div>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="items-table">
                        <?php $this->load->view('admin/items/view_itemsTable', $this->outputData); ?>
                        <?php $this->load->view('pagination', $this->outputData); ?>
                    </div>

                </div>

            </div>

        </div>

    </div>
</div>

<?php $this->load->view('footer1'); ?>