<?php $this->load->view('header1'); ?>

<div class="email-settings">

    <div class="page-bar">
        <ul class="page-breadcrumb">
            <li>
                <a href="index.html">Home</a>
                <i class="fa fa-circle"></i>
            </li>
            <li>
                <span>Email Template Settings</span>
            </li>
        </ul>
    </div>

    <h1 class="page-title"> <?= t('Email settings'); ?> </h1>

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
                    <a class="btn btn-success" href="<?php echo admin_url('emailSettings/addEmailSettings')?>"><i class="fa fa-plus"></i> <?= t('Add Email Settings'); ?></a>
                </div>
            </div>
        </div>
    </div>

    <div class="email-templates-table">
        <table class="table table-striped table-bordered table-hover table-checkable order-column dataTable no-footer" id="email_template_table" role="grid">
            <thead data-field="" data-sort="">
                <tr role="row">
                    <th width="5%" rowspan="1" colspan="1"> <?= t('Id'); ?> <span role="button" class="table-sort fa fa-sort" data-field="id" data-sort=""> </span></th>
                    <th rowspan="1" colspan="1"> <?= t('email_template_title'); ?> <span role="button" class="table-sort fa fa-sort" data-field="title" data-sort=""> </span></th>
                    <th rowspan="1" colspan="1"> <?= t('email_template_subject'); ?> <span role="button" class="table-sort fa fa-sort" data-field="title" data-sort=""> </span></th>
                    <th width="6%" rowspan="1" colspan="1"> <?= t('actions');?> </th>
                </tr>
            </thead>
            <tbody>
                <?php $this->load->view('admin/settings/view_emailTemplatesTableBody', $this->outputData); ?>
            </tbody>
        </table>

        <?php $this->load->view('pagination', $this->outputData); ?>

    </div>

</div>

<?php $this->load->view('footer1'); ?>
