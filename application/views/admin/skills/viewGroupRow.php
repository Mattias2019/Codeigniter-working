<?php
    $group = array();
    if(isset($groups) and $groups->num_rows()>0) {
        $group = $groups->row();
    }
?>
    <tr class="<?php if ($mode == "insert") { echo "new-row";}?>">
        <td>
            <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                <input type="checkbox" class="checkboxes" name="grouplist[]" id="grouplist[] value="<?php echo $group->id; ?>">
                <span></span>
            </label>
        </td>
        <td>
            <?php
            if ($mode == "insert") {

            }
            else {
                ?>
                <span class="id"><?php echo $group->id; ?></span>
                <?php
            }
            ?>
        </td>
        <td>
            <?php if ($mode == "insert" || $mode == "update") { ?>
                <input type="text" class="form-control input" name="group_name" id="group_name" value="<?php if ($mode == "update") {echo $group->group_name;} ?>">
            <?php } else {
                echo $group->group_name;
            }
            ?>
        </td>
        <td>
            <?php if ($mode == "insert" || $mode == "update") { ?>
                <textarea class="form-control input" name="description" id="description" rows="3"><?php if ($mode == "update") {echo $group->description;} ?></textarea>
            <?php } else {
                echo $group->description;
            }
            ?>
        </td>
        <td>
            <?php
            if ($mode == "insert") {
            }
            else {
                echo date('Y-m-d',$group->created);
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
