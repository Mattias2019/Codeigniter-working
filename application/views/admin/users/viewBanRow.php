<?php
$banDetail = array();
if (isset($banDetails) and $banDetails->num_rows() > 0) {
    $banDetail = $banDetails->row();
}
?>
<tr class="<?php if ($mode == "insert") {
    echo "new-row";
} ?>">
    <td>
        <?php
        if ($mode == "view") {
            ?>
            <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                <input type="checkbox" class="checkboxes" name="banlist[]"
                       id="banlist[] value="<?php echo $banDetail->id; ?>">
                <span></span>
            </label>
            <?php
        }
        ?>
    </td>
    <td>
        <?php
        if ($mode == "insert") {

        } else {
            ?>
            <span class="id"><?php echo $banDetail->id; ?></span>
            <?php
        }
        ?>
    </td>
    <td>
        <?php if ($mode == "insert" || $mode == "update") { ?>
            <select class="form-control" id="ban_type_id" name="ban_type_id">
                <option value=""></option>

                <?php
                if (isset($banTypes) and $banTypes->num_rows() > 0) {
                    foreach ($banTypes->result() as $banType) {
                        ?>
                        <option value="<?php echo $banType->id; ?>" <?php if (isset($banDetails) && $banType->id == $banDetail->ban_type_id) echo "selected"; ?>> <?php echo $banType->type ?> </option>
                        <?php
                    }
                }
                ?>
            </select>
        <?php } else {
            echo $banDetail->ban_type;
        }
        ?>
    </td>
    <td>
        <?php if ($mode == "insert" || $mode == "update") { ?>
            <input type="text" class="form-control input" name="ban_value" id="ban_value"
                   value="<?php if ($mode == "update") {
                       echo $banDetail->ban_value;
                   } ?>">
        <?php } else {
            echo $banDetail->ban_value;
        }
        ?>
    </td>
    <td>
        <?php
        if ($mode == "insert") {
        } else {
            echo date('Y-m-d', $banDetail->ban_time);
        }
        ?>
    </td>

    <td class="text-center">
        <a href="#" class="table-button btn-edit <?php if ($mode == 'insert') {
            echo 'hidden';
        } else {
            echo '';
        } ?>">
            <?php echo svg("table-buttons/edit", TRUE); ?>
        </a>
        <a href="#" class="table-button btn-delete <?php if ($mode == 'insert') {
            echo 'hidden';
        } else {
            echo '';
        } ?>">
            <?php echo svg("table-buttons/delete", TRUE); ?>
        </a>
        <a href="#" class="table-button btn-save <?php if ($mode == 'insert') {
            echo '';
        } else {
            echo 'hidden';
        } ?>">
            <?php echo svg("table-buttons/accept", TRUE); ?>
        </a>
        <a href="#" class="table-button btn-cancel <?php if ($mode == 'insert') {
            echo '';
        } else {
            echo 'hidden';
        } ?>">
            <?php echo svg("table-buttons/reject", TRUE); ?>
        </a>
    </td>
</tr>
