$(function () {

    fetchProjects();

    fetchSections();

});//end of document ready

let fetchProjects = () => {

    $(document).on('change', '#center-id', function () {

        if (this.value && this.value != 0) {

            let url = $(this).find(':selected').data('projects-url');

            $.ajax({
                url: url,
                cache: false,
                success: function (html) {

                    $('#project-id option').not(':first').remove();
                    $('#project-id').append(html);
                    $('#project-id').attr('disabled', false);

                    $('#section-id').attr('disabled', true);
                    $('#section-id').val('').trigger('change');

                },
            });//end of ajax call

        } else {

            $('#project-id').attr('disabled', true);
            $('#project-id').val('').trigger('change');

            $('#section-id').attr('disabled', true);
            $('#section-id').val('').trigger('change');

        } //end of else

    });

}

let fetchSections = () => {

    $(document).on('change', '#project-id', function () {

        if (this.value && this.value != 0) {

            let url = $(this).find(':selected').data('sections-url');

            $.ajax({
                url: url,
                cache: false,
                success: function (html) {

                    $('#section-id option').not(':first').remove();
                    $('#section-id').append(html);
                    $('#section-id').attr('disabled', false);
                },
            });//end of ajax call

        } else {

            $('#section-id').attr('disabled', true);
            $('#section-id').val('').trigger('change');

        } //end of else

    });

}