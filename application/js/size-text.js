var sizeText;
(new (function SizeText() {

    sizeText = this;
    this.init = function(container) {
        var width = container.width();
        var fontSize = parseInt(container.css('font-size'));
        var textLength = container.text().length;
        if (textLength > 0) {
            var space = (width - (fontSize/1.63)*textLength) / textLength;
            if (space > 0) {
                container.css('letter-spacing', space+'px');
            }
        }
    }

})());