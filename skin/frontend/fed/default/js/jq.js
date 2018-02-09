jQuery(document).ready(function ($) {

    $('button[data-target="#navbar-collapse-1"]').on('click', function () {
        $('html').toggleClass('nav-open');
    });

    $(document).on('change', '#s_method_sy_novaposhta_type_WarehouseWarehouse', function () {
        if ($(this).is(':checked')) {
            $('#billing:street1').removeClass('required-entry').prop('disabled', true);
        } else {
            $('#billing:street1').addClass('required-entry').prop('disabled', false);
        }
    });
    $(document).on('change', '#s_method_sy_novaposhta_type_WarehouseDoors', function () {
        if ($(this).is(':checked')) {
            $('#billing:street1').removeClass('required-entry').prop('disabled', true);
        } else {
            $('#billing:street1').addClass('required-entry').prop('disabled', false);
        }
    });

});