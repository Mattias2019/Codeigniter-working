<tr data-group-id="0" class="hidden">
    <td><input class="table-input" name="group_name" value="" disabled="disabled"/></td>
    <td class="team-members">0</td>
    <td><input type="checkbox" name="admin" disabled="disabled"/></td>
    <td><input type="checkbox" name="quotes_create" disabled="disabled"/></td>
    <td><input type="checkbox" name="quotes_edit_all" disabled="disabled"/></td>
    <td><input type="checkbox" name="quotes_edit_own" disabled="disabled"/></td>
    <td><input type="checkbox" name="projects_all" disabled="disabled"/></td>
    <td><input type="checkbox" name="projects_assigned" disabled="disabled"/></td>
    <td><input type="checkbox" name="projects_own" disabled="disabled"/></td>
    <td><input type="checkbox" name="portfolio_create" disabled="disabled"/></td>
    <td><input type="checkbox" name="portfolio_edit_all" disabled="disabled"/></td>
    <td><input type="checkbox" name="portfolio_edit_own" disabled="disabled"/></td>
    <td><input type="checkbox" name="portfolio_view" disabled="disabled"/></td>
    <td>
        <?php $this->load->view('team/groups_actions');?>
    </td>
</tr>

<?php foreach ($groups as $item) {?>
    <?php $this->load->view('team/groups_table_row', ['item' => $item])?>
<?php }?>
