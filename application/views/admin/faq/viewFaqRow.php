<?php
    $faq = array();
    if(isset($faqs) and $faqs->num_rows()>0) {
        $faq = $faqs->row();
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
                <span class="id"><?php echo $faq->id; ?></span>
            <?php
                }
            ?>
        </td>
        <td>
            <?php if ($mode == "insert" || $mode == "update") { ?>
<!--                <input type="text" class="form-control input" name="category_name" id="category_name" value="--><?php //if ($mode == "update") {echo $faq->category_name;} ?><!--">-->
                <select class="form-control" id="faq_category_id" name="faq_category_id">
                    <option value=""></option>

                    <?php
                    if(isset($faqCategories) and $faqCategories->num_rows()>0) {
                        foreach($faqCategories->result() as $faqCategory) {
                            ?>
                            <option value="<?php echo $faqCategory->id; ?>" <?php if(isset($faqs) && $faq->faq_category_id == $faqCategory->id) echo "selected"; ?>> <?php echo $faqCategory->category_name ?> </option>
                            <?php
                        }
                    }
                    ?>
                </select>
            <?php } else {
                echo $faq->category_name;
            }
            ?>
        </td>
        <td>
            <?php if ($mode == "insert" || $mode == "update") { ?>
                <textarea class="form-control input" name="question" id="question" rows="3"><?php if ($mode == "update") {echo $faq->question;} ?></textarea>
            <?php } else {
                echo $faq->question;
            }
            ?>
        </td>
        <td>
            <?php if ($mode == "insert" || $mode == "update") { ?>
                <textarea class="form-control input" name="answer" id="answer" rows="3"><?php if ($mode == "update") {echo $faq->answer;} ?></textarea>
            <?php } else {
                echo $faq->answer;
            }
            ?>
        </td>
        <td>
            <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                <input type="checkbox" class="checkboxes" name="is_frequent" id="is_frequent" <?php if ($mode == "view") {echo "disabled";} ?> <?php if ($mode != "insert" && $faq->is_frequent == 1) {echo "checked";} ?>>
                <span></span>
            </label>
        </td>
        <td class="editable-text title" contenteditable="false">
            <?php
                if ($mode == "insert") {
                }
                else {
                    echo date('Y-m-d', $faq->created);
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
