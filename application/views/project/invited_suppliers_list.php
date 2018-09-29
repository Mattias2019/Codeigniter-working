<?php
if(isset($this->outputData['invited_suppliers']) and count($this->outputData['invited_suppliers'])>0) {
    foreach ($this->outputData['invited_suppliers'] as $invited_supplier) { ?>

        <div class="supplier">
            <div class="supplier-img">
                <img src=<?php echo $this->user_model->get_logo($invited_supplier['id']); ?>>
            </div>
            <div class="supplier-body">
                <div class="supplier-info">
                    <span class="supplier-name"><?php echo $invited_supplier['full_name']; ?></span>
                    <br>
                    <span class="supplier-country"><?php echo $invited_supplier['country_name']; ?></span>
                    <ul class="supplier-actions">
                        <li>
                            <a href="<?php echo site_url('project/getSupplierInfo'); ?>"
                               data-supplier-id="<?php echo $invited_supplier['id']; ?>"
                               class="view-invited-supplier-info-btn">View
                            </a>
                        </li>
                    </ul>
                    <br>
                    <span class="supplier-rank">
                        <strong>
                            Rank
                            <span class="text-primary">
                                <?php echo $invited_supplier['rank']; ?>
                            </span>
                            of
                            <?php echo $invited_supplier['all_rank']; ?>
                        </strong>
                    </span>
                    <br>
                    <span class="supplier-rating">
                        <strong>
                            <span class="text-color-2"><?= t('Total rating'); ?></span>
                            <span class="text-color-2"><?php echo number_format($invited_supplier['user_rating'], 1); ?></span>
                        </strong>
                        <input type="hidden"
                               class="rating-value"
                               value="<?php echo $invited_supplier['user_rating']; ?>"/>
                        <div class="rating"></div>
                    </span>

                </div>
            </div>
        </div>
        <?php
    }
}
else {
    ?>
    <div align="center">
        <?= t('No suppliers are invited');?>
    </div>
    <?php
}
?>