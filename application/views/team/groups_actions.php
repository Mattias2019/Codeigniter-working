<a href="#" class="table-button group-button-move">
    <?php echo svg('table-buttons/move', TRUE); ?>
</a>
<a href="#" class="table-button group-button-lock">
    <?php echo svg('table-buttons/unlock', TRUE); ?>
</a>
<a href="#" class="table-button group-button-edit">
    <?php echo svg('table-buttons/edit', TRUE); ?>
</a>

<?php if (isset($item) && $item['is_i_team_lead']) {?>
    <a href="#" class="table-button group-button-delete">
        <?php echo svg('table-buttons/delete', TRUE); ?>
    </a>
<?php }  ?>

<a href="#" class="table-button group-button-save hidden">
    <?php echo svg('table-buttons/accept', TRUE); ?>
</a>
<a href="#" class="table-button group-button-cancel hidden">
    <?php echo svg('table-buttons/reject', TRUE); ?>
</a>