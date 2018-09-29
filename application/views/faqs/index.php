<?php $this->load->view('header'); ?>
<div class="container">
    <div class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="col-xs-12">
                    <?php foreach ($this->outputData['faq'] as $faq_category) { ?>
                        <h2><?php echo $faq_category['category_name']; ?></h2>
	                    <?php foreach ($faq_category['questions'] as $question) { ?>
                            <p>
                                <strong><?= t('Q: '); ?></strong>
                                <strong><?php echo $question['question']; ?></strong>
                            </p>
                            <p>
                                <strong><?= t('A: '); ?></strong>
                                <span><?php echo $question['answer']; ?></span>
                            </p>
						<?php } ?>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('footer'); ?>