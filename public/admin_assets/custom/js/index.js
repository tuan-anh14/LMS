$(function () {

    renderOrdersChart();

    renderOrdersChartByYear();

});//end of document ready

let renderOrdersChart = (data = {}) => {

    if ($('#orders-chart-wrapper').length) {

        let loadingHtml = `
              <div style="height: 400px;" class="d-flex justify-content-center align-items-center">
                  <div class="loader-md"></div>
              </div>
        `;

        $('#orders-chart-wrapper').empty().append(loadingHtml);

        let url = $('#orders-chart-wrapper').data('url');

        $.ajax({
            url: url,
            data: data,
            success: function (html) {

                $('#orders-chart-wrapper').empty().append(html);

            },

        });//end of ajax call

    }//end of if

}

let renderOrdersChartByYear = () => {

    $('#orders-chart-year').on('change', function () {

        renderOrdersChart({year: this.value});

    })

}



