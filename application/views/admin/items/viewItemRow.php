<?php
    $item = array();
    if(isset($items) and $items->num_rows()>0) {
        $item = $items->row();
    }
?>
    <tr class="<?php if ($mode == "insert") { echo "new-row";}?>">
        <td>
            <?php
                if ($mode == "insert") {

                }
                else {
            ?>
                <span class="id"><?php echo $item->id; ?></span>
            <?php
                }
            ?>
        </td>
        <td>
            <?php if ($mode == "insert" || $mode == "update") { ?>
                <input type="text" class="form-control input" name="name" id="name" value="<?php if ($mode == "update") {echo $item->name;} ?>">
            <?php } else {
                echo $item->name;
            }
            ?>
        </td>
        <td>
            <?php if ($mode == "insert" || $mode == "update") { ?>
                <input type="text" class="form-control input" name="unit" id="unit" value="<?php if ($mode == "update") {echo $item->unit;} ?>">
            <?php } else {
                echo $item->unit;
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
