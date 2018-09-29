function setInputmask() {

    // Create inputmask
    jQuery('.inputmask').each(function (key, value) {
        jQuery(value).inputmask("decimal", {
            autoUnmask: true,
            groupSeparator: '.',
            digits: 0,
            autoGroup: true,
            prefix: jQuery(value).data('prefix'),
            rightAlign: false
        });
    });

    // Unmask masked fields on form submit
    jQuery('form').submit(function () {
        jQuery(this).find('.inputmask').inputmask('remove');
    });

}

jQuery(document).ready(function () {
    setInputmask();
});