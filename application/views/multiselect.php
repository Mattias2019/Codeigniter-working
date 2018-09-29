<?php
if (!isset($this->outputData['groups_with_categories'])) {
	$this->outputData['groups_with_categories'] = [];
}
elseif (!is_array($this->outputData['groups_with_categories'])){
	$this->outputData['groups_with_categories'] = [$this->outputData['groups_with_categories']];
}
if (!isset($this->outputData['selectedCategories'])) {
    $this->outputData['selectedCategories'] = [];
}
elseif (!is_array($this->outputData['selectedCategories'])) {
    $this->outputData['selectedCategories'] = [$this->outputData['selectedCategories']];
}
if (!isset($this->outputData['search_type'])) {
	$this->outputData['search_type'] = 0;
}
if (!isset($this->outputData['multiselect_id'])) {
	$this->outputData['multiselect_id'] = '';
}
if (!isset($this->outputData['multiselect_dropdown'])) {
	$this->outputData['multiselect_dropdown'] = TRUE;
}
?>

<div id="<?php echo $this->outputData['multiselect_id'] . "select"; ?>" class="custom_dropdown mod_fix">

    <input id="search_type" type="hidden" value="<?php echo $this->outputData['search_type']; ?>">
    <?php if ($this->outputData['search_type'] == 2) { ?>
        <input id="limit_selected_count" type="hidden" value="<?php echo $limit_selected_count; ?>">
    <?php } ?>

    <div class="custom_dropdown_block result_box mod_fix" <?php if (!$this->outputData['multiselect_dropdown'] || count($this->outputData['selectedCategories'])==0) echo 'hidden="hidden"' ?> >

        <div class="result_box_area mod_fix"></div>

        <div id="search_box_area" class="search_box_area mod_fix">
            <input type="text" id="search_box">
        </div>

    </div>
    <div class="result_mark mod_fix">
        <span id="mark" class="fa fa-caret-down"></span>
    </div>

    <div class="custom_dropdown_block dropdown_box mod_fix" <?php if ($this->outputData['multiselect_dropdown']) echo 'id="group_form" hidden="hidden"' ?> >

        <?php $i = 0;
        foreach ($this->outputData['groups_with_categories'] as $groupWithCategory) { ?>

            <ul>
                <li class="<?php echo $this->outputData['multiselect_id'] . "select" . $i; ?>">

                    <div class="checkbox">
                        <?php if ($this->outputData['search_type'] != 1) { ?>
                            <input name="<?php echo $this->outputData['multiselect_id'] . "select" . $i; ?>"
                                   id="<?php echo $this->outputData['multiselect_id'] . "select" . $i; ?>"
                                   class="<?php echo $this->outputData['multiselect_id'] . "select" . $i; ?> styled main_category"
                                   type="checkbox">
                        <?php } ?>
                        <label class="main_category_label <?php if ($this->outputData['search_type'] == 1) echo " remove_checkbox"; ?>" main_category_id="<?php echo $this->outputData['multiselect_id'] . "select" . $i; ?>">
                            <span class="main_category_name" id="<?php echo $this->outputData['multiselect_id'] . "select" . $i; ?>"><?php echo $groupWithCategory['group_name']; ?></span>
                            <span class="main_category_mark fa fa-caret-up" style="color:gray" id="mark_<?php echo $this->outputData['multiselect_id'] . "select" . $i; ?>"></span>
                        </label>
                    </div>

                    <div class="<?php echo $this->outputData['multiselect_id'] . "select" . $i; ?> sub_category ">
                        <ul class="<?php echo $this->outputData['multiselect_id'] . "select" . $i; ?>">
                            <?php
                            $j = 0;
                            foreach ($groupWithCategory['categories'] as $category) {

                                ?>
                                <li sub_category_id="<?php echo $this->outputData['multiselect_id'] . "select" . $i . "_" . $j; ?>"
                                    class="<?php echo $this->outputData['multiselect_id'] . "select" . $i . "_" . $j; ?>">
                                    <div class="checkbox">
                                        <input id="<?php echo $this->outputData['multiselect_id'] . "select" . $i . "_" . $j; ?>"
                                               name="category[]"
                                               class="styled sub_item"
                                               type="checkbox"
                                               value="<?php echo $category['id']; ?>"
                                            <?php
                                            if (in_array($category['id'], $this->outputData['selectedCategories'])) echo 'checked="checked"'; ?>
                                               main_category_id="<?php echo $this->outputData['multiselect_id'] . "select" . $i; ?>"
                                        >
                                        <label for="<?php echo $this->outputData['multiselect_id'] . "select" . $i . "_" . $j; ?>"
                                               class="<?php echo $this->outputData['multiselect_id'] . "select" . $i . "_" . $j; ?> sub_category_label">
                                            <?php echo $category['category_name']; ?>
                                        </label>
                                    </div>
                                </li>
                                <?php
                                $j++;
                            }
                            ?>
                        </ul>
                    </div>
                </li>
            </ul>

            <?php
            $i++;
        }
        ?>
    </div>

</div>