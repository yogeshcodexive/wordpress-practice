export class Truncate {
    init() {
        $(document).ready(function () {
            $('.truncate').each(function () {
                var maxLength = $(this).data('max-length');
                var text = $(this).text();
                if (text.length > maxLength) {
                    var truncatedText = text.substring(0, maxLength);
                    $(this).text(truncatedText + '...');
                }
            });
        });
    }
}