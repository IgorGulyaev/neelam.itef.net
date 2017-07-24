jQuery(document).ready(function ($) {

    $('button[data-target="#navbar-collapse-1"]').on('click', function () {
        $('html').toggleClass('nav-open');
    });

});