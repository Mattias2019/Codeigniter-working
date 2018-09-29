<select multiple="multiple" id="category_items" name="category_items[]">
    <?php
    if(isset($all_items) and $all_items->num_rows()>0) {
        foreach ($all_items->result() as $item) {
            ?>
            <option value="<?php echo $item->id; ?>"> <?php echo $item->name; ?> </option>
            <?php
        }
    }
    ?>
</select>