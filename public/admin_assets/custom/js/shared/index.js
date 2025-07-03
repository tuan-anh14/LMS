$(function () {

    initLiveWireHooks();

    initAjaxHeader();

    ajaxData();

    // initSelect2();

    // initDatePicker();

    initGalleryImages();

    ajaxModal();

    ajaxForm();

    disabledLinks();

    dataTableRecordSelect();

    showImageUnderFileExplorer()

    // checkFieldLanguage();

    toggleActive();

});//end of document ready

let initLiveWireHooks = () => {

    $(document).on('livewire:navigating', function (event) {

        window.destroySelect2();

        window.destroyDataTable();

    });


    $(document).on('livewire:navigated', (event) => {

        window.initSidebar();

        feather.replace();

        window.initSelect2();

        window.initDatePicker();

        $('input[autofocus]').focus();

    })

}

window.destroySelect2 = () => {

    $('select').each(function () {

        if ($(this).data('select2') != undefined) {

            $(this).select2('destroy');
        }
    });

}

window.destroyDataTable = () => {

    $('.datatable').DataTable().destroy();

}

let initAjaxHeader = () => {

    let loginUrl = $('meta[name="login-url"]').attr('content')

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        error: function (xhr, status, error) {

            if (xhr.status == 500) {

                window.handleErrorModal(xhr);

            } else if (xhr.status == 401 || xhr.status == 415 || xhr.status == 419) {

                window.location.href = loginUrl;

            }
        },
        statusCode: {}
    });

}

let ajaxData = () => {

    $(document).on('click', '.ajax-data', function () {

        let loadingHtml = `
              <div style="height: 50vh;" class="d-flex justify-content-center align-items-center">
                  <div class="loader"></div>
              </div>
        `;

        $('.ajax-data').removeClass('active');

        $(this).addClass('active');

        $('#ajax-data-wrapper').empty().append(loadingHtml);

        let url = $(this).data('url');

        $.ajax({
            url: url,
            cache: false,
            success: function (html) {

                $('#ajax-data-wrapper').empty().append(html);

                window.initSelect2();

                window.initDatePicker();

                feather.replace();

            },

        });//end of ajax call

    });//end of on click

}

window.initSelect2 = () => {

    $('.select2').each(function () {

        let placeholder = $(this).find('option:first').text();

        if ($(this).attr('placeholder')) {

            placeholder = $(this).attr('placeholder');

        }//end of if

        $(this).select2({
            'width': '100%',
            'placeholder': placeholder
        })

    })

    // $('.select2-ajax').each(function () {
    //
    //     let searchUrl = $(this).attr('data-search-url');
    //     let placeholder = $(this).attr('placeholder');
    //     let loadingText = $(this).attr('data-loading-text');
    //
    //     $(this).select2({
    //         placeholder: placeholder,
    //         ajax: {
    //             url: searchUrl,
    //             delay: 250,
    //             dataType: 'json',
    //             data: function (params) {
    //                 return {
    //                     'search': params.term,
    //                     // 'not_in_names': that.val(),
    //                 };
    //             },
    //             processResults: function (data, params) {
    //                 data = data.data;
    //
    //                 return {
    //                     results: $.map(data, function (item) {
    //                         return {
    //                             text: item.title,
    //                             id: item.id,
    //                             image_asset_path: item.image_asset_path,
    //                             description: item.description.substring(0, 200),
    //                         }
    //                     })
    //                 }
    //             },
    //         },
    //         minimumInputLength: 1,
    //         escapeMarkup: function (markup) {
    //             return markup;
    //         },
    //         createTag: function (params) {
    //             return {
    //                 id: params.term,
    //                 text: params.term,
    //             };
    //         },
    //         templateResult: select2TemplateResult,
    //         templateSelection: select2TemplateSelection,
    //     });
    //
    // })

    let select2TemplateResult = (data) => {

        var el = '';

        if (data.loading) {

            let html = `
            <div class="d-flex justify-content-between">
                <p style="font-size: 1.1rem; margin-bottom: 0;">loading..</p>
                 <div class="loading-container p-0">
                    <div class="loader-xs"></div>
                </div>
            </div>
        `
            el = $(html);

        } else {

            let html = `
            <div class="d-flex">
                <img src="${data.image_asset_path}" style="width: 80px; height: 100px;" alt="">

                <div style="margin-left: 10px;">
                    <h4>${data.text}</h4>
                    <p>${data.description}</p>
                </div>
            </div>
        `;

            el = $(html);

        }

        return el;
    }

    let select2TemplateSelection = (data) => {

        var el = '';

        if (data.newOption & !data.addedBefore) {

            let html = `<span>${data.text}</div>`;

            $.ajax({
                url: data.creationUrl,
                method: 'POST',
                data: {
                    'name': data.text,
                },
                cache: false,
                success: function (resp) {
                    data.addedBefore = true;
                }
            });//end of ajax call

            el = $(html);

        } else {

            let html = `<span>${data.text}</div>`;

            el = $(html);

        }

        return el;

    }

}

let ajaxModal = () => {

    $('#ajax-modal').on('hide.bs.modal', function (e) {

        $('#ajax-modal .modal-body').empty();

        window.destroySelect2();

        window.initSelect2();

    });

    $(document).on('click', '.ajax-modal', function (e) {
        e.preventDefault();

        let loading = `
            <div class="loading-container absolute-centered">
                <div class="loader sm"></div>
            </div>
        `;

        let url = $(this).data('url');
        let modalTitle = $(this).data('modal-title');
        let modalBodyClass = $(this).data('modal-body-class')

        $('#ajax-modal').modal('show');

        $('#ajax-modal .modal-body').remove();

        $('#ajax-modal .modal-content').append('<div class="modal-body relative"></div>')

        $('#ajax-modal .modal-body').addClass(modalBodyClass);

        $('#ajax-modal .modal-body').empty().append(loading);

        $('#ajax-modal .modal-title').text(modalTitle);

        window.destroySelect2();

        $.ajax({
            url: url,
            //processData: false,
            //contentType: false,
            cache: false,
            success: function (response) {

                $('#ajax-modal .modal-body').empty().append(response['view']);

                window.initSelect2();

                window.initDatePicker();

                feather.replace();
            },

        });//end of ajax call

    });

}

let ajaxForm = () => {

    $(document).on('submit', '.ajax-form', function (e) {
        e.preventDefault();

        let that = $(this);

        let loading = $('meta[name="loading"]').attr('content');

        let submitButton = that.find('button[type="submit"]:last-child');

        let submitButtonHtml = submitButton.html();

        submitButton.attr('disabled', true);

        that.find('button[type="submit"]').html(loading);

        that.removeClass('active');

        that.addClass('active');

        that.find('.invalid-feedback').remove();

        let url = $(this).attr('action');
        let data = new FormData(this);

        $('.ajax-form.active .invalid-feedback').hide();

        $.ajax({
            url: url,
            data: data,
            method: 'POST',
            contentType: false,
            processData: false,
            cache: false,
            success: function (response) {

                hideModals();

                handleAjaxRedirects(response, submitButtonHtml);

                handleAjaxRemoveElements(response);

                handleRefreshDatatable();

                if (that.hasClass('empty-form')) {

                    that.find('input:not([type=hidden]), textarea, select').val('');

                }//end of if
            },
            error: function (xhr, exception) {

                let loginUrl = $('meta[name="login-url"]').attr('content')

                if (xhr.status == 500) {

                    window.handleErrorModal(xhr);

                } else if (xhr.status == 401 || xhr.status == 415 || xhr.status == 419) {

                    window.location.href = loginUrl;

                } else {

                    handleAjaxErrors(xhr, submitButtonHtml);

                }//end of if

            },
            complete: function () {

                submitButton.attr('disabled', false);

                submitButton.html(submitButtonHtml);
            }
        });//end of ajax call

    })

}

window.hideModals = () => {

    $(".modal:not(#ajax-modal)").each(function () {

        $(this).modal("hide");

    });

    $(".modal#ajax-modal").each(function () {

        $(this).modal("hide");

        $('#ajax-modal .modal-body').empty();

        window.destroySelect2();

        window.initSelect2();

    });


}

window.handleErrorModal = (xhr) => {

    $('#error-modal').modal('show');

    let html = '';

    if (xhr.responseJSON) {

        let error = xhr.responseJSON;

        html += `
            <h3> ${error.message}</h3>
            <p><strong>Exception: </strong>${error.exception}</p>
            <p><strong>file: </strong>${error.file}</p>
            <p><strong>line: </strong>${error.line}</p>
        `

        if (error.trace) {

            html += `<h5>Trace</h5>`;

        }//end of if

        error.trace.forEach((item, index) => {

            html += `
                <div style="margin-bottom: 10px">
                    <p class="mb-0"><strong>class: </strong> ${item.class}</p>
                    <p class="mb-0"><strong>file: </strong>${item.file}</p>
                    <p class="mb-0"><strong>function: </strong>${item.function}</p>
                    <p class="mb-0"><strong>line: </strong>${item.line}</p>
                </div>
            `;
        })

    } else {

        html += xhr.responseText;

    }

    $('#error-modal .modal-body').empty().append(html);

}

let handleAjaxErrors = (xhr, submitButtonHtml) => {

    let errors = xhr['responseJSON']['errors'];

    for (const field in xhr['responseJSON']['errors']) {

        $(`.ajax-form.active input[name="${field}"], .ajax-form.active select[name="${field}"], .ajax-form.active textarea[name="${field}"]`)
            .closest('.form-group')
            .append(`<span class="invalid-feedback d-block">${errors[field][0]}</span>`)

        $(`.ajax-form.active input[data-error-name="${field}"], .ajax-form.active select[data-error-name="${field}"], .ajax-form.active textarea[data-error-name="${field}"]`)
            .closest('.form-group')
            .append(`<span class="invalid-feedback d-block">${errors[field][0]}</span>`);

    }

    if ($('.invalid-feedback.d-block').length) {

        $('html, body, .page-data').animate({
            scrollTop: $('.invalid-feedback.d-block').offset().top - 300
        }, 200);

    }//end of if

    $('.ajax-form input[type="password"]').val("");

    $('.ajax-form input.empty').val("");

}

let handleAjaxRedirects = (response, submitButtonHtml) => {

    if (response['success_message'] && response['redirect_to']) {

        new Noty({
            layout: 'topRight',
            text: response['success_message'],
            timeout: 2000,
            killer: true
        }).show();

        setTimeout(function () {

            window.location.href = response['redirect_to'];

        }, 100);

    } else if (response['redirect_to'] || response['success_message'] || response['replace'] || response['modal_view']) {

        if (response['redirect_to']) {
            Livewire.navigate(response['redirect_to']);

            // window.location.href = response['redirect_to'];
        }

        if (response['success_message']) {

            new Noty({
                layout: 'topRight',
                text: response['success_message'],
                timeout: 2000,
                killer: true
            }).show();

        }

        if (response['replace']) {

            $(response['replace']).html(response['replace_with']);

        }//end of if

        if (response['modal_view']) {

            if (response['modal-size-class']) {

                $('#ajax-modal .modal-dialog').removeAttr('class').attr('class', 'modal-dialog modal-dialog-centered ' + response['modal-size-class']);

            } //end of if

            $('#ajax-modal .modal-title').text(response['modal_title']);

            $('#ajax-modal .modal-body').empty().append(response['modal_view']);

            $('#ajax-modal').modal('show');

            $('.ajax-form.active button[type="submit"]').html(submitButtonHtml);

            $('.ajax-form.active button[type="submit"]').attr('disabled', false)

        }//end of if

    } else {

        $('.ajax-form.active button[type="submit"]').html(submitButtonHtml);

        $('.ajax-form.active button[type="submit"]').attr('disabled', false)

    }

}

let handleAjaxRemoveElements = (response) => {

    if (response['remove']) {$(response['remove']).remove();}//end of if

}

let disabledLinks = () => {

    $(document).on('click', 'a.disabled, .disabled a, span[disabled]', function (e) {
        e.preventDefault();

        return
    })

}

let handleRefreshDatatable = () => {

    if ($('.datatable').length) {

        $('.datatable').DataTable().ajax.reload();

    }//end of if


}

window.initDatePicker = () => {

    $('.date-picker').flatpickr({
        dateFormat: 'Y-m-d',
        disableMobile: "true",
        locale: "ar",
        position: 'top right',
    });

    $('.date-range-picker').each(function () {

        let defaultFromDate = $(this).data('default-from-date');
        let defaultToDate = $(this).data('default-to-date');

        $(this).flatpickr({
            mode: "range",
            locale: "ar",
            position: 'top right',
            dateFormat: "Y-m-d",
            defaultDate: [defaultFromDate ?? '', defaultToDate ?? ''],
            onClose: function (selectedDates, dateStr, instance) {

                const fromDate = [selectedDates[0].getFullYear(), selectedDates[0].getMonth() + 1, selectedDates[0].getDate()].join('-');
                const toDate = [selectedDates[1].getFullYear(), selectedDates[1].getMonth() + 1, selectedDates[1].getDate()].join('-');

                $('#from-date').val(fromDate).trigger('change');
                $('#to-date').val(toDate).trigger('change');

                // $('.datatable').DataTable().ajax.reload();

            },
        });

    })

    $('.time-picker').each(function () {

        $(this).flatpickr({
            enableTime: true,
            noCalendar: true,
            time_24hr: false,
            locale: "ar",
            position: 'top right',
        });

    })

    $('.date-time-picker').each(function () {

        $(this).flatpickr({
            enableTime: true,
            dateFormat: "Y-m-d H:i K",
            locale: "ar",
            position: 'top right',
        });

    })

    // $(".hijri-date-picker").hijriDatePicker({
    //     locale: "ar-sa",
    //     format: "YYYY-MM-DD",
    //     hijriFormat: "iYYYY-iMM-iDD",
    //     dayViewHeaderFormat: "MMMM YYYY",
    //     hijriDayViewHeaderFormat: "iMMMM iYYYY",
    //     showSwitcher: true,
    //     allowInputToggle: true,
    //     useCurrent: true,
    //     isRTL: true,
    //     viewMode: 'days',
    //     keepOpen: true,
    //     hijri: false,
    //     debug: true,
    //     // showClear: true,
    //     showTodayButton: true,
    //     minDate: new Date(),
    //     // showClose: true,
    //
    // });

}

let initGalleryImages = () => {

    $('.gallery-images').each(function () { // the containers for all your galleries

        $(this).magnificPopup({
            delegate: 'a', // child items selector, by clicking on it popup will open
            type: 'image',
            gallery: {
                enabled: true,
                navigateByImgClick: true,
                preload: [0, 1] // Will preload 0 - before current, and 1 after the current image
            },
        });

    });

}

let dataTableRecordSelect = () => {

    //select all functionality
    $(document).on('change', '.record__select', function () {
        getSelectedRecords();
    });

    // used to select all records
    $(document).on('change', '#record__select-all', function () {

        $('.record__select').prop('checked', this.checked);
        getSelectedRecords();
    });

    let getSelectedRecords = () => {
        var recordIds = [];
        $.each($(".record__select:checked"), function () {
            recordIds.push($(this).val());
        });

        $('#record-ids').val(JSON.stringify(recordIds));

        recordIds.length > 0
            ? $('#bulk-delete').attr('disabled', false)
            : $('#bulk-delete').attr('disabled', true)

    }
}

let showImageUnderFileExplorer = () => {

    $(document).on('change', '.load-image', function (e) {

        var that = $(this);

        let reader = new FileReader();
        reader.onload = function () {
            that.parent().find('.loaded-image').attr('src', reader.result);
            that.parent().find('.loaded-image').css('display', 'block');
        }
        reader.readAsDataURL(e.target.files[0]);

    });

}

let toggleActive = () => {

    $(document).on('change', '.toggle-active', function () {

        let url = $(this).data('url');

        $.ajax({
            url: url,
            method: 'PUT',
            cache: false,
            success: function (data) {

                new Noty({
                    type: 'warning',
                    layout: 'topRight',
                    text: data.message,
                    timeout: 2000,
                    killer: true
                }).show();

            },
        });//end of ajax call

    });

}

// let checkFieldLanguage = () => {
//
//     $(document).on("input", 'input[type="text"]', function () {
//
//         var ranges = [ // EMOJIS RANGE
//             '[\u2700-\u27BF]',
//             '[\uE000-\uF8FF]',
//             '\uD83C[\uDC00-\uDFFF]',
//             '\uD83D[\uDC00-\uDFFF]',
//             '[\u2011-\u26FF]',
//             '\uD83E[\uDD10-\uDDFF]'
//         ];
//
//         let str = $(this).val();
//
//         str = str.replace(new RegExp(ranges.join('|'), 'g'), '');
//
//         if (str == null || str.trim() == '') {
//             str = str.trim()
//         }
//
//         $(this).val(str);
//
//     });
//
//     $(document).on('keyup', '.select2-search__field', function () {
//
//         let str = $(this).val();
//
//         str = str.replace(/([\u2700-\u27BF]|[\uE000-\uF8FF]|\uD83C[\uDC00-\uDFFF]|\uD83D[\uDC00-\uDFFF]|[\u2011-\u26FF]|\uD83E[\uDD10-\uDDFF])/g, "").trim();
//         // str = str.replace(/[^\u0600-\u06FF_ , a-z , A-Z , 0-9]+$/g, "");
//         $(this).val(str);
//
//     });
//
//     $(document).on(
//         'input[name="first_name"], ' +
//         'input[name="last_name"], ',
//         function () {
//
//             let regex = /[!@#$%^&*()_+\-={}[\]\\|:;"'<>,.?\,0-9]/g; //prevent this regex
//             let str = $(this).val();
//             str = str.replace(regex, "");
//
//             if (str.isEmpty || str === " ") {
//                 str = str.trim();
//             }//end of if
//
//             $(this).val(str);
//         });
//
//     $(document).on(
//         "input",
//         'input[data-error-name="ar.title"], ' +
//         'input[data-error-name="ar.subtitle"], ' +
//         'input[data-error-name="ar.name"], ' +
//         'textarea[data-error-name="ar.description"], ' +
//         'textarea[data-error-name="ar.short_description"], ' +
//         'input[data-error-name="ar.address"]',
//         function () {
//
//             let regex = /[a-z,A-Z]/g; //prevent this regex
//             let str = $(this).val();
//             str = str.replace(regex, "");
//
//             if (str.isEmpty || str === " ") {
//                 str = str.trim();
//             }//end of if
//
//             $(this).val(str);
//
//         }
//     );
//
//     $(document).on(
//         "input",
//         'input[data-error-name="en.title"], ' +
//         'input[data-error-name="en.subtitle"], ' +
//         'input[data-error-name="en.name"],' +
//         'textarea[data-error-name="en.description"], ' +
//         'textarea[data-error-name="en.short_description"], ' +
//         'input[data-error-name="en.address"]',
//         function () {
//
//             let regex = /[\u0600-\u06FF_]/g; //prevent this regex
//             let str = $(this).val();
//             str = str.replace(regex, "");
//
//             if (str.isEmpty || str === " ") {
//                 str = str.trim();
//             }//end of if
//
//             $(this).val(str);
//
//         }
//     );
//
// }
