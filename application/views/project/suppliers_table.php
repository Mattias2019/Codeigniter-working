<?php
    if(isset($this->outputData['suppliers']) and count($this->outputData['suppliers'])>0)
    {
        foreach ($this->outputData['suppliers'] as $supplier) { ?>
            <tr data-id="<?php echo $supplier['id']; ?>">
                <td>
                    <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                        <input type="checkbox" class="checkboxes" name="suppliersList[]"
                               id="suppliersList[]" value="<?php echo $supplier['id']; ?>">
                        <span></span>
                    </label>
                </td>
                <td>
                    <div class="image-circle small">
                        <img src=<?php echo $this->user_model->get_logo($supplier['id']); ?>>
                    </div>
                </td>
                <td><?php echo $supplier['full_name']; ?></td>
                <td><?php echo $supplier['email']; ?></td>
                <td>
                    <a href="<?php echo site_url('project/getSupplierInfo'); ?>"
                       class="btn btn-sm btn-outline grey-salsa view-supplier-info-btn"
                       data-toggle="tooltip"
                       data-placement="top"
                       data-supplier-id="<?php echo $supplier['id']; ?>"
                       title="<?= t('View Supplier Info'); ?>">
                        <i class="fa fa-search"></i>
                        <?= t('View'); ?>
                    </a>
                </td>
            </tr>
<?php
        }
    }
    else{
?>
    <tr>
        <td align="center" colspan="5">
            <?= t('No suppliers found');?>
        </td>
    </tr>
<?php }
?>
