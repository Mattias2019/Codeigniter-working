<?php
    $faqCategory = array();
    if(isset($faqCategories) and $faqCategories->num_rows()>0) {
        $faqCategory = $faqCategories->row();
    }
?>
    <tr class="<?php if ($mode == "insert") { echo "new-row";}?>">
        <td>
            <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                <input type="checkbox" class="checkboxes" name="faqCategorieslist[]" id="faqCategorieslist[]"
                       value="">
                <span></span>
            </label>
        </td>

        <td>
            <?php
                if ($mode == "insert") {

                }
                else {
            ?>
                <span class="id"><?php echo $faqCategory->id; ?></span>
            <?php
                }
            ?>
        </td>
        <td>
            <?php if ($mode == "insert" || $mode == "update") { ?>
                <input type="text" class="form-control input" name="category_name" id="category_name" value="<?php if ($mode == "update") {echo $faqCategory->category_name;} ?>">
            <?php } else {
                echo $faqCategory->category_name;
            }
            ?>
        </td>
        <td>
            <?php
                if ($mode == "insert") {
                }
                else {
                    echo date('Y-m-d', $faqCategory->created);
                }
            ?>
        </td>

        <td class="text-center">
            <a href="#" class="table-button btn-edit <?php if ($mode == 'insert') { echo 'hidden';} else { echo '';} ?>">
                <?php echo svg("table-buttons/edit", TRUE); ?>
            </a>
            <a href="#" class="table-button btn-delete <?php if ($mode == 'insert') { echo 'hidden';} else { echo '';} ?>">
                <?php echo svg("table-buttons/delete", TRUE); ?>
            </a>
            <a href="#" class="table-button btn-save <?php if ($mode == 'insert') { echo '';} else { echo 'hidden';} ?>">
                <?php echo svg("table-buttons/accept", TRUE); ?>
            </a>
            <a href="#" class="table-button btn-cancel <?php if ($mode == 'insert') { echo '';} else { echo 'hidden';} ?>">
                <?php echo svg("table-buttons/reject", TRUE); ?>
            </a>
        </td>
    </tr>
