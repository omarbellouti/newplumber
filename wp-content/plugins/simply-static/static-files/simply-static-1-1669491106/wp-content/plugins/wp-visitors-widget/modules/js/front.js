jQuery(document).ready(function ($) {
  var charts = [];

  function findCharts() {
    $(".random_prefix_val").each(function () {
      var this_id = $(this).val();
      if ($("#chart_div_" + this_id).length == 0) {
        return;
      }
      charts.push({
        json: $.parseJSON($("#graph_info_" + this_id).val()),
        chart: document.getElementById("chart_div_" + this_id),
      });
    });
  }

  findCharts();

  if (charts.length > 0) {
    google.charts.load("current", { packages: ["corechart"] });
    google.charts.setOnLoadCallback(drawChart);
  }

  function drawChart() {
    $.each(charts, function (i, chart) {
      var data = google.visualization.arrayToDataTable(chart.json);
      var options = {
        title: {
          position: "none",
        },
        backgroundColor: {
          fill: "transparent",
        },
        curveType: "function",
        legend: {
          position: "none",
        },
        hAxis: {
          baselineColor: "transparent",
          gridlineColor: "transparent",
          textPosition: "none",
        },
        vAxis: {
          baselineColor: "transparent",
          gridlineColor: "transparent",
          textPosition: "none",
        },
        chartArea: {
          left: -100,
          right: -50,
          top: -50,
          width: "100%",
          height: "100",
        },
      };
      var chart = new google.visualization.LineChart(chart.chart);
      chart.draw(data, options);
    });
  }
}); // global end
