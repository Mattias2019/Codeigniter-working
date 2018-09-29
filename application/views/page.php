<?php $this->load->view('header'); ?>
<div class="container">
    <div class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="col-xs-12">
                    <h2><?php if (isset($page)) echo $page['page_title']; ?></h2>
                </div>
                <div class="col-xs-12">
				    <?php if (isset($page)) echo $page['content']; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('footer'); ?>