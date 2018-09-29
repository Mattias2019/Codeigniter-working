
    <?php
        if(isset($faqCategories) and $faqCategories->num_rows()>0)
        {
            foreach($faqCategories->result() as $faqCategory)
            {
    ?>

    <tr role="row">

        <td>
            <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                <input type="checkbox" class="checkboxes" name="faqlist[]" id="faqlist[]" value="<?php echo $faqCategory->id; ?>">
                <span></span>
            </label>
        </td>

        <td class="id"><?php echo $faqCategory->id;?></td>
        <td><?php echo $faqCategory->category_name; ?></td>
        <td><?php echo date('Y-m-d',$faqCategory->created); ?></td>

        <td class="text-center">
            <a href="#" class="table-button btn-edit"><?php echo svg('table-buttons/edit', TRUE); ?></a>
            <a href="#" class="table-button btn-delete"><?php echo svg('table-buttons/delete', TRUE); ?></a>
            <a href="#" class="table-button btn-save hidden"><?php echo svg('table-buttons/accept', TRUE); ?></a>
            <a href="#" class="table-button btn-cancel hidden"><?php echo svg('table-buttons/reject', TRUE); ?></a>
        </td>

    </tr>

    <?php
            }
        }
        else
        {
    ?>
        <tr class="no-data-found">
            <td colspan="5" class="text-center">
                <?= t('No FAQ Categories Found');?>
            </td>
        </tr>
    <?php
        }
    ?>

