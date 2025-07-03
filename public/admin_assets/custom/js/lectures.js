$(function () {

    addMorePages();

    deletePage();

    handleAttendanceStatus();

});//end of document ready

let addMorePages = () => {

    $(document).on('click', '#add-more-pages-btn', function (e) {
        e.preventDefault();

        $('#pages-row-wrapper select.select2').select2('destroy');

        $('#pages-row-wrapper').append($('.page-row:first').clone());

        $('#pages-row-wrapper .page-row:last input').val('');
        $('#pages-row-wrapper .page-row:last select').val('').trigger('change');

        $('#pages-row-wrapper .page-row:last input[name="pages[0][from]"]').attr('name', 'pages[' + ($('.page-row').length - 1) + '][from]');
        $('#pages-row-wrapper .page-row:last input[name="pages[0][to]"]').attr('name', 'pages[' + ($('.page-row').length - 1) + '][to]');
        $('#pages-row-wrapper .page-row:last select[name="pages[0][assessment]"]').attr('name', 'pages[' + ($('.page-row').length - 1) + '][assessment]');

        window.initSelect2();

        toggleDisabledDeletePageBtn();
    });

}

let deletePage = () => {

    $(document).on('click', '.delete-page-btn', function (e) {
        e.preventDefault();

        $(this).closest('.page-row').remove();

        toggleDisabledDeletePageBtn();

    });

}

let toggleDisabledDeletePageBtn = () => {

    if ($('.delete-page-btn').length > 1) {

        $('.delete-page-btn').attr('disabled', false);

    } else {

        $('.delete-page-btn').attr('disabled', true);
    }

}

let handleAttendanceStatus = () => {

    $(document).on('change', '#attendance-status', function (e) {

        if ($(this).val() && $(this).val() == 'attended') {

            $('#pages-wrapper').show();

            $('#pages-wrapper input, #pages-wrapper select')
                .attr('required', true)
                .attr('disabled', false);

        } else {

            $('#pages-wrapper').hide();

            $('#pages-wrapper input, #pages-wrapper select')
                .val('')
                .attr('required', false)
                .attr('disabled', true);

        }

    })
}