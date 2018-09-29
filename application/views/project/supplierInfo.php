<div class="row">
    <div class="col-lg-12 col-xs-12 col-sm-12">
        <div class="row">
            <div class="col-lg-3 col-md-3 col-sm-2 col-xs-12">
                <div class="image-circle large">
                    <img src="<?php echo $this->outputData['supplier']['img_logo']; ?>">
                </div>
            </div>
            <div class="col-lg-5 col-md-5 col-sm-4 col-xs-12">
                <p class="account-title"><?php echo $this->outputData['supplier']['full_name']; ?>
                    &nbsp;</p>
                <p class="account-value"><?php echo $this->outputData['supplier']['name']; ?>&nbsp;</p>
                <p class="account-title"><?= t('Tax number'); ?></p>
                <p class="account-value"><?php echo $this->outputData['supplier']['vat_id']; ?>
                    &nbsp;</p>
                <p class="account-title"><?= t('Email'); ?></p>
                <p class="account-value"><?php echo $this->outputData['supplier']['email']; ?>&nbsp;</p>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <p class="account-title"><?= t('Country'); ?></p>
                <p class="account-value"><?php echo $this->outputData['supplier']['country_name']; ?>
                    &nbsp;</p>
                <p class="account-title"><?= t('State/Province'); ?></p>
                <p class="account-value"><?php echo $this->outputData['supplier']['state']; ?>&nbsp;</p>
                <p class="account-title"><?= t('City'); ?></p>
                <p class="account-value"><?php echo $this->outputData['supplier']['city']; ?>&nbsp;</p>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-xs-12 col-sm-12">
                <span class="supplier-rank">
                    <strong>
                        Rank
                        <span class="text-primary">
                            <?php echo $this->outputData['rank']; ?>
                        </span>
                        of
                        <?php echo $this->outputData['all_rank']; ?>
                    </strong>
                </span>
                <br>
                <span class="supplier-rating">
                    <strong>
                        <span class="text-color-2"><?= t('Total rating'); ?></span>
                        <span class="text-color-2"><?php echo number_format($this->outputData['supplier']['user_rating'], 1); ?></span>
                    </strong>
                    <input type="hidden"
                           class="rating-value"
                           value="<?php echo $this->outputData['supplier']['user_rating']; ?>"/>
                    <div class="supplier_rating"></div>
                </span>
            </div>
        </div>
    </div>
</div>