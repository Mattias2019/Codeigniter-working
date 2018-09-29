// Avoiding conflict between Bootstrap and jQueryUI tooltips
$.widget.bridge('uibutton', $.ui.button);
$.widget.bridge('uitooltip', $.ui.tooltip);