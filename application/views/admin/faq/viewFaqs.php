<?php $this->load->view('header1'); ?>

    <?php
        //Show Flash Message
        if($msg = $this->session->flashdata('flash_message'))
        {
            echo $msg;
        }
    ?>

    <div class="row">

        <div class="col-md-12">

            <div class="portlet light ">

                <div class="portlet-body">

                    <div class="faq">

                        <div class="row">

                            <div class="col-md-12">
                                <div class="faq-categories">
                                    <div class="portlet box blue-hoki">

                                        <div class="portlet-title">
                                            <div class="caption">
                                                <i class="icon-docs"></i> <?= t('view_faq_categories'); ?> </div>
                                            <div class="tools">
                                                <a href="javascript:;" class="collapse" data-original-title="" title=""> </a>
                                            </div>
                                            <div class="actions">
                                                <a class="btn btn-default btn-sm" id="btn_add_faq_categories" href="#">
                                                    <i class="fa fa-plus"></i> <?= t('Add'); ?>
                                                </a>
                                            </div>
                                        </div>

                                        <div class="portlet-body">

                                            <div class="faq-categories-table">
                                                <?php $this->load->view('admin/faq/viewFaqCategoriesTable', $this->outputData); ?>
                                                <?php $this->outputData['pagination'] = $this->outputData['pagination_faq_categories']; ?>
                                                <?php $this->load->view('pagination', $this->outputData); ?>
                                            </div>

                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">

                                <div class="faqs">

                                    <div class="portlet box blue-hoki">

                                        <div class="portlet-title">
                                            <div class="caption">
                                                <i class="icon-docs"></i> <?= t('faqs'); ?>
                                            </div>
                                            <div class="tools">
                                                <a href="javascript:;" class="collapse" data-original-title="" title=""> </a>
                                            </div>
                                            <div class="actions">
                                                <a class="btn btn-default btn-sm" id="btn_add_faq">
                                                    <i class="fa fa-plus"></i> <?= t('Add'); ?>
                                                </a>
                                            </div>
                                        </div>

                                        <div class="portlet-body">

                                            <div class="faqs-table">
                                                <?php $this->load->view('admin/faq/viewFaqsTable', $this->outputData); ?>
                                                <?php $this->outputData['pagination'] = $this->outputData['pagination_faqs']; ?>
                                                <?php $this->load->view('pagination', $this->outputData); ?>
                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

<!--    <li><a href="--><?php //echo admin_url('faq/viewFaqCategories')?><!--">--><?php //echo t('view_faq_categories'); ?><!--</a></li>-->
<!--    <li><a href="--><?php //echo admin_url('faq/addFaqCategory')?><!--">--><?php //echo t('add_faq_category'); ?><!--</a></li>-->
<!--    <li class="clsNoBorder"><a href="--><?php //echo admin_url('faq/addFaq')?><!--">--><?php //echo t('add_faq'); ?><!--</a></li>-->

<!--	 <a name="delete" href="javascript: document.managefaqlist.action='--><?php //echo admin_url('faq/deleteFaq'); ?><!--'; document.managefaqlist.submit();" onclick="return confirm('Are you sure want to delete??');"><img src="--><?php //echo image_url('delete-new.png'); ?><!--" alt="Delete" title="Delete" /></a></div>-->

<?php $this->load->view('footer1'); ?>