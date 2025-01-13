export class Privacy {
    init() {
        this.Privacy();
    }
    Privacy() {
        $(document).ready(function () {
            var links = $("#privacy-links a");
            links.first().parent().addClass("active");

            $(window).scroll(function () {
                var fromTop = $(this).scrollTop();

                links.each(function () {
                    var section = $($(this).attr("href"));

                    if (
                        section.position().top <= fromTop &&
                        section.position().top + section.outerHeight() > fromTop
                    ) {
                        links.each(function () {
                            $(this).parent().removeClass("active");
                        });
                        $(this).parent().addClass("active");
                    }
                });
            });
        });
    }
}