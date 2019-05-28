$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();

    autoScroll();

    $(document).on('click', '.zoom-btn-result', function(event) {
        event.preventDefault();
        var contentSection = $(this).closest('.wrapper-section-result').next('.content-section-result');

        if ($(contentSection).is(":visible")) {
            $(contentSection).hide('slide', { direction: 'up', }, 600);
            $(this).removeClass('zoom-in-btn');
            $(this).addClass('zoom-out-btn');
            $(this).closest('.wrapper-section-result').css('border-bottom', '1px solid #1987ad');
        } else {
            $(contentSection).show('slide', { direction: 'up', }, 600);
            $(this).removeClass('zoom-out-btn');
            $(this).addClass('zoom-in-btn');
            $(this).closest('.wrapper-section-result').css('border-bottom', 'none');
        }

        return false;
    });

    results();

    $(document).on('change', '.page-answer-detail', function(event) {
        event.preventDefault();
        var page = parseInt($(this).val());
        var countPage = parseInt($('.count-result').text());

        if (!Number.isInteger(page) || page > countPage || page < 1) {
            page = 1;
        }

        $('.page-answer-detail').val(page);
        getPageDetail(page);
    });

    $(document).on('click', '.preview-answer-detail', function(event) {
        event.preventDefault();
        var page = parseInt($('.page-answer-detail').val()) - 1;

        if (page < 1) {
            page = 1;
        }

        $('.page-answer-detail').val(page);
        getPageDetail(page);
    });

    $(document).on('click', '.next-answer-detail', function(event) {
        event.preventDefault();
        var countPage = parseInt($('.count-result').text());
        var page = parseInt($('.page-answer-detail').val()) + 1;

        if (page > countPage) {
            page = countPage;
        }

        $('.page-answer-detail').val(page);
        getPageDetail(page);
    });

    function getPageDetail(page) {
        var url = $('#btn-personal-result').data('url');

        $.ajax({
            url : url + '?page=' + page,
            dataType: 'json',
        })
            .done(function (data) {
                $('#div-management-survey').html(data.html);
                $('[data-toggle="tooltip"]').tooltip();
                location.hash = page;
                autoAlignChoiceAndCheckboxIcon();
            });
    }
});

function autoAlignChoiceAndCheckboxIcon()
{
    // auto align center multi-choice icon
    $('.li-question-review .item-answer .checkmark-radio').each(function () {
        var height = $(this).parent().height();
        var top = 12.5 * (height / 25 - 1);
        $(this).css('top', top + 'px');
    });

    // auto align center checkboxes icon
    $('.li-question-review .item-answer .checkmark-setting-survey').each(function () {
        var height = $(this).parent().height();
        var top = 12.5 * (height / 25 - 1);
        $(this).css('top', top + 'px');
    });
}

function autoScroll() {
    if ($('.scroll-answer-result').height() >= 250) {
        $('.scroll-answer-result').css({
            'overflow-y': 'scroll',
            'max-height': '250px',
        });
    }
}

function results() {
    $('.checkboxes-result').each(function() {
        var text = createDataForChart($(this).attr('data'));
        var dataCheckboxes = $.parseJSON((text));

        createBarChart($(this).attr('id'), dataCheckboxes);
    });

    $('.multiple-choice-result').each(function() {
        var text = createDataForChart($(this).attr('data'));
        var dataMultipleChoice = $.parseJSON(text);

        createPieChart($(this).attr('id'), dataMultipleChoice);
    });

    $('.redirect-result').each(function() {
        var text = createDataForChart($(this).attr('data'));
        var dataRedirect = $.parseJSON(text);

        createPieChart($(this).attr('id'), dataRedirect, true);
    });

    $('.linearscale-result').each(function() {
        var value = $(this).data('linear');
        var text = createDataLinrearForChart($(this).attr('data'), value);
        var dataLinearScale = $.parseJSON(text);
        var arrLinear = [];

        for (var i = parseInt(value.min_value); i <= parseInt(value.max_value); i++) {
            arrLinear.push(i);
        }

        createBarChartColumn($(this).attr('id'), dataLinearScale, value, arrLinear);
    });

    // excel option menu
    $('.option-menu-group').on('click', function(e) {
        e.stopPropagation();
        $('.survey-select-options').hide();
        $('.option-menu-dropdown').hide();
        $(this).children('.option-menu').toggleClass('active').next('ul.option-menu-dropdown').toggle();

        return false;
    });

    $(document).click(function() {
        $('.option-menu').removeClass('active');
        $('.option-menu-dropdown').hide();
    });

    $(document).on('click', '.submit-export-excel', function(event) {
        event.preventDefault();
        $('.info-export').submit();
    });
}

function createBarChartColumn(id, data, value, arr = []) {
    Highcharts.chart(id, {
        chart: {
            type: 'column'
        },
        title: {
            text: ''
        },
        subtitle: {
            text: ''
        },
        xAxis: {
            type: 'category',
            categories: arr,
        },
        yAxis: {
            title: {
                text: ''
            }
        },
        legend: {
            enabled: false
        },
        tooltip: {
            pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> of total<br/>'
        },
        credits: {
            enabled: false,
        },
        series: [{
            name: 'Population',
            data: data,
            dataLabels: {
                enabled: true,
                rotation: -90,
                color: '#FFFFFF',
                align: 'right',
                format: '{point.y:.1f}', // one decimal
                y: 10, // 10 pixels down from the top
                style: {
                    fontSize: '13px',
                    fontFamily: 'Verdana, sans-serif'
                }
            }
        }]
    });
}

function createBarChart(id, data) {
    Highcharts.chart(id, {
        chart: {
            type: 'bar',
            inverted: true,
        },
        exporting: {
            enabled: false,
        },
        title: {
            text: '',
        },
        subtitle: {
            text: '',
        },
        xAxis: {
            type: 'category',
        },
        yAxis: {
            title: {
                text: '',
            }
        },
        legend: {
            enabled: false,
        },
        credits: {
            enabled: false,
            position: {
                align: 'left',
            }
        },
        plotOptions: {
            series: {
                borderWidth: 0,
                dataLabels: {
                    enabled: true,
                    format: '{point.y:.1f}%',
                }
            }
        },
        tooltip: {
            pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> of total<br/>',
        },
        series: [
            {
                name: '',
                colorByPoint: true,
                data: data,
            }
        ],
        responsive: {
            rules: [{
                condition: {
                    maxWidth: 500,
                },
                chartOptions: {
                    xAxis: {
                        labels: {
                            formatter: function () {
                                return this.value.charAt(0);
                            }
                        }
                    },
                    yAxis: {
                        labels: {
                            align: 'left',
                            x: 0,
                            y: -2,
                        },
                        title: {
                            text: '',
                        }
                    }
                }
            }]
        }
    });
}

function createPieChart(id, data, redirect = false) {
    var options3d = redirect ? { enabled: true, alpha: 45, beta: 0,} : { enabled: false,};
    Highcharts.chart(id, {
        chart: {
            type: 'pie',
            options3d: options3d,
        },
        exporting: {
            enabled: false,
        },
        title: {
            text: '',
        },
        credits: {
            enabled: false,
            position: {
                align: 'left',
            }
        },
        tooltip: {
            pointFormat: '<b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                depth: 40,
                dataLabels: {
                    enabled: true,
                    format: '{point.percentage:.1f} %',
                    colors: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black',
                    distance: -50,
                },
                showInLegend: true,
            }
        },
        series: [
            {
                type: 'pie',
                name: '',
                data: data,
            }
        ],
        responsive: {
            rules: [{
                condition: {
                    maxWidth: 500,
                },
                chartOptions: {
                    xAxis: {
                        labels: {
                            formatter: function () {
                                return this.value.charAt(0);
                            }
                        }
                    },
                    yAxis: {
                        labels: {
                            align: 'left',
                            x: 0,
                            y: -2,
                        },
                        title: {
                            text: '',
                        }
                    }
                }
            }]
        }
    });
}

function createDataLinrearForChart(data, value) {
    var newData = $.parseJSON(data.replace(/\\r\\n/g, " / "));
    var text = '';

    $.each(newData, function(index, item) {
        text += `{"name": ${item['content']}, "y": ${item['percent']}}`;
        text += (index == newData.length - 1) ? '' : ',';
    });

    return '[' + text + ']';
}

function createDataForChart(data) {
    var newData = $.parseJSON(data.replace(/\\r\\n/g, " / "));
    var text = '';

    $.each(newData, function(index, item) {
        var name = item['content'];

        if (name.length > 30) {
            name = name.substring(0, 30) + '...';
        }

        text += `{"name": "${name}", "y": ${item['percent']}}`;
        text += (index == newData.length - 1) ? '' : ',';
    });

    return '[' + text + ']';
}

function subResults() {
    $('.sub-checkboxes-result').each(function() {
        var text = createDataForChart($(this).attr('data'));
        var dataCheckboxes = $.parseJSON((text));

        createBarChart($(this).attr('id'), dataCheckboxes);
    });

    $('.sub-multiple-choice-result').each(function() {
        var text = createDataForChart($(this).attr('data'));
        var dataMultipleChoice = $.parseJSON(text);

        createPieChart($(this).attr('id'), dataMultipleChoice);
    });
}
