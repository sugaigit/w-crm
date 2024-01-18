$(document).ready(function() {
    /******************************************
     * 必須項目の表示切替
    ******************************************/
    $('.required').each(function() {
        if ($(this).val().length) {
            $(this).removeClass('bg-danger bg-opacity-25');
        } else {
            $(this).addClass('bg-danger bg-opacity-25');
        }
    });

    $('.required').on('change', function () {
        if ($(this).val().length) {
            $(this).removeClass('bg-danger bg-opacity-25');
        } else {
            $(this).addClass('bg-danger bg-opacity-25');
        }
    });

});
    /******************************************
     * 人材紹介/紹介予定 採用ご条件の表示切替
    ******************************************/
    if ($('.conditions').val().length) {
        $('.conditions').removeClass('bg-info bg-opacity-25');
    } else {
        $('.conditions').addClass('bg-info bg-opacity-25');
    }
    $('.conditions').on('change', function () {
        if ($(this).val().length) {
            $(this).removeClass('bg-info bg-opacity-25');
        } else {
            $(this).addClass('bg-info bg-opacity-25');
        }
    });
