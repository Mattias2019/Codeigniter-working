<?php if (!isset($this->outputData['page_numbers']) or !is_array($this->outputData['page_numbers'])) $this->outputData['page_numbers'] = [10, 25, 50, 100]; ?>

<?php if (
            isset($this->outputData['pagination'])
            &&
            $this->outputData['pagination'] != ""
            &&
            count($this->outputData['page_numbers']) > 0
        ) { ?>

    <div class="pagination-container">

            <div class="pagination-container-inner" data-page="1">
                <?php echo $this->outputData['pagination']; ?>
            </div>

        <?php if (count($this->outputData['page_numbers']) > 0) { ?>
            <div class="pagination-limit">
                <select class="pagination-limit-select" title="<?= t('Results'); ?>">
                    <?php foreach ($this->outputData['page_numbers'] as $page_number) { ?>
                        <option value="<?php echo $page_number; ?>"><?php echo $page_number; ?></option>
                    <?php } ?>
                </select>
                <span><?= t('Results'); ?></span>
            </div>
        <?php } ?>
    </div>

<?php } ?>