<?php
    if (isset($faqs) and $faqs->num_rows()>0)
    {
        foreach($faqs->result() as $faq)
        {
            ?>
            <tr role="row">
                <td>
                    <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                        <input type="checkbox" class="checkboxes" name="faqlist[]" id="faqlist[]" value="<?php echo $faq->id; ?>">
                        <span></span>
                    </label>
                </td>

                <td class="id"><?php echo $faq->id; ?></td>
                <td><?php echo $faq->category_name; ?></td>
                <td><?php echo $faq->question; ?></td>
                <td><?php echo $faq->answer; ?></td>
                <td>
                    <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                        <input type="checkbox" class="checkboxes" name="is_frequent" id="is_frequent" disabled <?php if ($faq->is_frequent == 1) {echo "checked";}; ?>>
                        <span></span>
                    </label>
                </td>
                <td><?php echo date('Y-m-d',$faq->created); ?></td>

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
        <tr>
            <td colspan="8" class="text-center">
                <?= t('No FAQs Found');?>
            </td>
        </tr>

        <?php
    }
?>