$(function () {

    handleTeacherSection();

    handleCenterManager();

});//end of document ready

let handleTeacherSection = () => {

    $(document).on('click', '.teacher-center', function () {

        sections = $(this).closest('.row').find('.teacher-sections');

        if ($(this).is(':checked')) {

            sections.attr('disabled', false).attr('required', true);

        } else {

            sections.attr('disabled', true).attr('required', false)
            sections.val(0).trigger('change');

        }

        window.initSelect2();

    });
}

let handleCenterManager = () => {

    $(document).on('change', '#is-center-manager', function () {

        if ($(this).is(':checked')) {


            $('#center-ids-as-manager').attr('disabled', false).attr('required', true);

        } else {

            $('#center-ids-as-manager').attr('disabled', true).attr('required', false);

            $('#center-ids-as-manager').val(0).trigger('change');

        }

        window.initSelect2();

    });

}