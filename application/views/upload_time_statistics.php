<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!-- Styles -->
<style>
#chartdiv
{
    width: 100%;
    height: 500px;
}
</style>

<!-- Resources -->
<script src="https://cdn.amcharts.com/lib/4/core.js"></script>
<script src="https://cdn.amcharts.com/lib/4/charts.js"></script>
<script src="https://cdn.amcharts.com/lib/4/themes/animated.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
//keep chart instance
var chartReg = {};

// release chart instance create earlier
function maybeDisposeChart(chartdiv) {
    if (chartReg[chartdiv]) {
        chartReg[chartdiv].dispose();
        delete chartReg[chartdiv];
    }
}
function drawGraph(tit, data, mode, forecastperiod) {
    
    // clear resources.
     maybeDisposeChart("chartdiv");

    am4core.ready(function() {

        // Themes begin
        am4core.useTheme(am4themes_animated);
        // Themes end

        // Create chart instance
        var chart = am4core.create("chartdiv", am4charts.XYChart);
        chart.background.fill = '#ffff';
        chart.background.opacity = 1;
         chart.scrollbarX = new am4charts.XYChartScrollbar();

        // Increase contrast by taking evey second color
        chart.colors.step = 2;

        // Add data
        chart.data = data
        var title = chart.titles.create();
        title.text =tit;
        title.fontSize = 30;
        title.marginBottom = 30;
                // Create axes
      var dateAxis;
        if (mode == 'daily') {
        dateAxis = chart.xAxes.push(new am4charts.DateAxis());
        dateAxis.title.text = "Forecast Day";
        dateAxis.dateFormats.setKey("day", "dt MMMM ,yyyy");
        dateAxis.title.fontSize = 20;
        dateAxis.renderer.minGridDistance = 100;
        }
        var categoryAxis;
        if (mode == 'monthly' || mode == 'seasonal') {
            categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
            categoryAxis.dataFields.category = "date";
            categoryAxis.renderer.minGridDistance = 100;
            categoryAxis.title.text = mode == 'monthly' ? "(issue date,month_from-month_to,upload date)" :
                "(issue date,season,upload date)";
            categoryAxis.title.fontWeight = "bold";
            categoryAxis.title.fontSize = 20;
        }

        var valueAxis = chart.yAxes.push(new am4charts.DurationAxis());
        // Create series
        function createAxisAndSeries(field, name, opposite, bullet) {
            
             valueAxis.baseUnit = "minute";
            if (chart.yAxes.indexOf(valueAxis) != 0) {
                valueAxis.syncWithAxis = chart.yAxes.getIndex(0);
            }

            var series = chart.series.push(new am4charts.LineSeries());
            series.dataFields.valueY = field;
            //series.dataFields.dateX = "date";
             mode == 'daily' ? series.dataFields.dateX = "date" : series.dataFields.categoryX = "date";
            series.strokeWidth = 2;
            series.yAxis = valueAxis;
            series.name = name;
            
            series.tooltipText = "{name}:{valueY.formatDuration('hh:mm:ss')}";
            series.tensionX = 0.8;
            series.showOnInit = true;
            series.smoothing = "monotoneX";
            var interfaceColors = new am4core.InterfaceColorSet();

            switch (bullet) {
                case "circle2":
                  // var bullet = series.bullets.push(new am4charts.CircleBullet());
                   // bullet.circle.stroke = am4core.color("#dc3545");
                   // bullet.circle.strokeWidth = 2;
                    //series.fill = am4core.color("red");
                    series.stroke = am4core.color("red");
                    //series.strokeWidth = 1;
                    //bullet.circle.fill = am4core.color("#dc3545");
                    break;
                default:
                    var bullet = series.bullets.push(new am4charts.CircleBullet());
                    bullet.circle.stroke = interfaceColors.getFor("background");
                    bullet.circle.strokeWidth = 2;
                    //series.fill = am4core.color("red");
                    break;
            }
            valueAxis.renderer.line.strokeOpacity = 1;
            valueAxis.renderer.line.strokeWidth = 2;
            valueAxis.renderer.line.stroke = series.stroke;
            valueAxis.renderer.labels.template.fill = series.stroke;
            valueAxis.renderer.opposite = opposite;
            valueAxis.title.text = "Time Of Upload";
            valueAxis.title.fontWeight = "bold";
            valueAxis.title.fontSize = 20;
            
        }

        createAxisAndSeries("uploads", "upload_time", true, "circle");
        createAxisAndSeries("constant_time", "threshold_time",false, "circle2");
        


        // Add legend
        chart.legend = new am4charts.Legend();

        // Add cursor
        chart.cursor = new am4charts.XYCursor();

    }); // end am4core.ready()
}
$(document).ready(function() {
    $(document).on('click', '#submit', function()

        {
            var forecastperioddate = $('#date_start').val();
            var forecastperiod = $('#forecastperiod').val();
            if (forecastperiod == "") {
                $("#forecastperiod").css("border-color", "#dc3545");
                return false;
            } else {
                $("#forecastperiod").css("border-color", "1px solid #f4f4f4");
            }
            var mode = 'daily';
            if (forecastperiod == 'monthly') {
                mode = 'monthly';
            } else if (forecastperiod == 'seasonal') {
                mode = 'seasonal';
            }
            $.ajax({
                url: '<?=base_url()?>index.php/Graph/uploadTime',
                method: 'post',
                data: {
                    'forecastperiod': forecastperiod,
                    'forecastdate': forecastperioddate
                },
                success: function(array) {
                    $("#forecastperioddate").val("");
                    drawGraph(array.chart_title, array.chart_data, mode, forecastperiod);
                    // console.log(array.chart_data);
                },
                error: function(error) {
                    console.log(error);

                }
            });
        });
});
</script>



<script>
var title = `<?php echo $chart_title; ?>`;
var data = JSON.parse(`<?php echo $chart_data; ?>`);
drawGraph(title, data, 'daily', null);
</script>


<section class="content" id="dashboard-content">
    <section class="content-header">
        <h1>
            FORECAST UPLOAD TIME
            <small>Report</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url() ?>index.php/Landing/index"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#"><i class="fa fa-dashboard"></i>Visualizaions</a></li>
        </ol>
    </section>

    <section class='content'>
        <div class='row'>
            <div class='col-xs-12'>
                <div class='box'>
                    <div class='box-header'>

                        <h3 class='box-title'>FORECAST UPLOAD TIME</h3>

                        <div class='box box-primary'>

                            <div class="table-responsive">
                                <table class='table table-bordered'>
                                    <tr>
                                        <td>Date to current Forecast Date</td>
                                        <td>
                                            Start Forecast Date:<br>
                                            <input class="form-control" type="date" name="date" id="date_start"
                                                required>
                                        </td>
                                        <td>
                                            Forecast: <br>
                                            <select name="forecastperiod" class="form-control" id="forecastperiod"
                                                validate>
                                                <option value="">Select the graph</option>
                                                <option value="early_morning" onchange="function(data)">Early
                                                    Morning forecast</option>
                                                <option value="late_morning" onchange="function(data)"> Late Morning
                                                    forecast</option>

                                                <option value="afternoon" onchange="function(data)">Afternoon forecast
                                                </option>
                                                <option value="late_afternoon" onchange="function(data)">Late Afternoon
                                                    forecast
                                                </option>
                                                <option value="evening" onchange="function(data)">Evening forecast
                                                </option>
                                                <option value="24hourly" onchange="function(data)">24 hourly forecast
                                                </option>
                                                <option value="monthly" onchange="function(data)">Monthly forecast
                                                </option>
                                                <option value="seasonal" onchange="function(data)">Seasonal forecast
                                                </option>
                                            </select>
                                        </td>
                                        <td><br><input type="submit" value="Generate Chart" name="submit" id="submit"
                                                class="btn btn-primary"></td>
                                    </tr>
                                    </tr>
                                </table>
                            </div>
                        </div><!-- /.box-body -->
                        <div class="box-body">
                            <!-- HTML -->
                            <div id="chartdiv"></div>
                        </div>
    </section>