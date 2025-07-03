$(function () {

    fetchLectureTypes();

});//end of document ready

let fetchLectureTypes = () => {

    $(document).on('change', '#section-id', function () {

        if ($(this).val() && $(this).val() != 0) {

            let url = $(this).find(':selected').data('lecture-types-url');

            $.ajax({
                url: url,
                cache: false,
                success: function (html) {

                    $('#lecture-type option').not(':first').remove();
                    $('#lecture-type').append(html);
                    $('#lecture-type').attr('disabled', false);
                },

            });//end of ajax call

        } else {

            $('#lecture-type').attr('disabled', true);
            $('#lecture-type').val('').trigger('change');

        }

    });

}
