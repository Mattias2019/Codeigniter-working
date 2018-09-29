<?php if (isset($packages)) foreach($packages as $package) { ?>
    <tr role="row">
        <td><?php echo $package['id'];?></td>
        <td><?php echo $package['package_name'];?></td>
        <td><?php echo $package['description'];?></td>
        <td><?php echo $package['credits'];?></td>
        <td><?php echo $package['total_days'];?></td>
        <td><?php echo $package['amount'];?></td>
        <td><?php echo ($package['isactive']==0)?t('Disabled'):t('Enabled'); ?></td>
        <td>
            <a href="<?php echo admin_url('packages/editPackage?id='.$package['id']); ?>"
               role="button"
               class="table-button tooltip-attach"
               data-toggle="tooltip"
               data-placement="top"
               title="<?= t('Edit Package');?>">
                <?php echo svg('table-buttons/edit', TRUE); ?>
            </a>
            <a href="<?php echo admin_url('packages/deletePackage?id='.$package['id']); ?>"
               role="button"
               class="table-button tooltip-attach delete"
               data-toggle="tooltip"
               data-placement="top"
               title="<?= t('Delete Package');?>">
                <?php echo svg('table-buttons/delete', TRUE); ?>
            </a>
        </td>
    </tr>
<?php } ?>