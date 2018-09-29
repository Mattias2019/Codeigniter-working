var groups;

(new (function Groups() {
    var _this = groups = this;
    var _siteUrl = "";

    this.init = function(siteUrl) {
        _siteUrl = siteUrl || "";
        jQuery('#group-button-new').click(newGroup);
        initTable();
    };

    function initTable() {
        $('#table-groups tbody tr').each(function () {
            initRow($(this));
        })
    }

    function initRow(row) {
        row.find('.group-button-edit').click(editGroup);
        row.find('.group-button-save').click(saveGroup);
        row.find('.group-button-cancel').click(cancelEditGroup);
        row.find('.group-button-delete').click(deleteGroup);
        row.find('.group-button-lock').click(lockGroup);
        row.find('.group-button-move').click(moveGroup);
        row.find('input[name=quotes_create], input[name=quotes_edit_all], input[name=quotes_edit_own]').change(checkQuotes);
        row.find('input[name=projects_all], input[name=projects_assigned], input[name=projects_own]').change(checkProject);
        row.find('input[name=portfolio_create], input[name=portfolio_edit_all], input[name=portfolio_edit_own], input[name=portfolio_view]').change(checkPortfolio);
    }

    function setRowToEdit(row) {
        row.find('input').prop('disabled', false);
        row.find('.group-button-move, .group-button-lock, .group-button-edit, .group-button-delete').addClass('hidden');
        row.find('.group-button-save, .group-button-cancel').removeClass('hidden');
    }

    function editGroup(e) {
        e.preventDefault();
        var row = jQuery(this).closest('tr');
        setRowToEdit(row);
    }

    function newGroup(e) {
        e.preventDefault();
        var row = $('#team-group-body tr:first').clone().appendTo('#team-group-body');
        row.removeClass('hidden');
        setRowToEdit(row);
        initRow(row);
    }

    function saveGroup(e) {
        e.preventDefault();
        var row = jQuery(this).closest('tr');
        var data = {
            "id": row.attr('data-group-id'),
            "group_name": row.find('input[name=group_name]').val(),
        };
        row.find('input[type=checkbox]').each(function () {
            data[$(this).attr('name')] = $(this).is(":checked")?1:0;
        });
        m.post(_siteUrl + "/team/save_group", data,
            function (result) {
                if (result.html) {
                    var newRow = $(result.html);
                    row.replaceWith(newRow);
                    initRow(newRow);
                }
            }
        );
    }

    function cancelEditGroup(e) {
        e.preventDefault();
        m.post(_siteUrl + "/team/refresh_group", {},
            function (result) {
                if (result.html) {
                    $('#team-group-body').html(result.html);
                    initTable();
                }
            }
        );
    }

    function deleteGroup(e) {
        e.preventDefault();
        var row = jQuery(this).closest('tr');
        var id = row.attr('data-group-id');
        m.dialog({
            header: 'Delete group',
            body: 'Do you wish to delete group?',
            btnOk: {
                label:'Yes',
                callback: function() {
                    m.post(_siteUrl + "/team/delete_group", {id : id },
                        function (result) {
                            if (result.html) {
                                $('#team-group-body').html(result.html);
                                initTable();
                            }
                        }
                    );
                }
            },
            btnCancel: {
                label:'No'
            }
        });
    }

    function lockGroup(e) {
        e.preventDefault();
        var row = jQuery(this).closest('tr');
        var id = row.attr('data-group-id');
        var isLocked = row.attr('data-is-locked');
        var msg = parseInt(isLocked) === 0?"lock":"un-lock";
        m.dialog({
            header: 'Lock group',
            body: 'Do you wish to ' + msg + ' group?',
            btnOk: {
                label:'Yes',
                callback: function() {
                    m.post(_siteUrl + "/team/lock_group", { id : id, locked: isLocked },
                        function (result) {
                            if (result.html) {
                                var newRow = $(result.html);
                                row.replaceWith(newRow);
                                initRow(newRow);                            }
                        }
                    );
                }
            },
            btnCancel: {
                label:'No'
            }
        });
    }

    function moveGroup(e) {
        e.preventDefault();
        var row = jQuery(this).closest('tr');
        var id = row.attr('data-group-id');
        m.post(_siteUrl + "/team/move_group", {id : id},
            function (result) {
                if (result.html) {
                    $('#team-group-body').html(result.html);
                    initTable();
                }
            }
        );
    }

    function checkPortfolio() {

        var row = jQuery(this).closest('tr');
        var isChecked = $(this).is(":checked");

        row.find('input[name=portfolio_create]').prop('checked', false);
        row.find('input[name=portfolio_edit_all]').prop('checked', false);
        row.find('input[name=portfolio_edit_own]').prop('checked', false);
        row.find('input[name=portfolio_view]').prop('checked', false);

        $(this).prop('checked', isChecked);
    }

    function checkQuotes() {

        var row = jQuery(this).closest('tr');
        var isChecked = $(this).is(":checked");

        row.find('input[name=quotes_create]').prop('checked', false);
        row.find('input[name=quotes_edit_all]').prop('checked', false);
        row.find('input[name=quotes_edit_own]').prop('checked', false);

        $(this).prop('checked', isChecked);
    }

    function checkProject() {
        var row = jQuery(this).closest('tr');
        var isChecked = $(this).is(":checked");
        var name = jQuery(this).attr('name');

        row.find('input[name=projects_all]').prop('checked', false);
        row.find('input[name=projects_assigned]').prop('checked', false);
        row.find('input[name=projects_own]').prop('checked', false);

        $(this).prop('checked', isChecked);
        switch (name) {
            case 'projects_all':
                row.find('input[name=projects_assigned]').prop('checked', isChecked);
                row.find('input[name=projects_own]').prop('checked', isChecked);
                row.find('input[name=projects_assigned]').prop('disabled', isChecked);
                row.find('input[name=projects_own]').prop('disabled', isChecked);
                break;
            default:
            case 'projects_assigned':
            case 'projects_own':
                break;
        }
    }


})());