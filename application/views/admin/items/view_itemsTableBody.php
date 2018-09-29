
    <?php $no=1;
    if(isset($items) and $items->num_rows()>0)
    {
        foreach($items->result() as $item)
        {
            ?>
            <tr role="row">

                <td class="id"><?php echo $item->id;?></td>
                <td><?php echo $item->name;?></td>
                <td><?php echo $item->unit;?></td>

                <td class="text-center">
                    <a href="#" class="table-button btn-edit"><?php echo svg('table-buttons/edit', TRUE); ?></a>
                    <a href="#" class="table-button btn-delete"><?php echo svg('table-buttons/delete', TRUE); ?></a>
                    <a href="#" class="table-button btn-save hidden"><?php echo svg('table-buttons/accept', TRUE); ?></a>
                    <a href="#" class="table-button btn-cancel hidden"><?php echo svg('table-buttons/reject', TRUE); ?></a>
                </td>
            </tr>

        <?php }
    }
    else{ ?>
        <tr>
            <td colspan="4">
                <?= t('No items found');?>
            </td>
        </tr>
    <?php }
    ?>

