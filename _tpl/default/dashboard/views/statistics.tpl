<style type="text/css">
* {
  @include box-sizing(border-box);
}

$pad: 20px;

.grid {
  background: white;
  margin: 0 0 $pad 0;
  
  &:after {
    /* Or @extend clearfix */
    content: "";
    display: table;
    clear: both;
  }
}

/*[class*='col-'] {
  float: left;
  padding-right: $pad;
  .grid &:last-of-type {
    padding-right: 0;
  }
}*/

.col-2-3 {
  width: 66.66%;
}
.col-1-3 {
  width: 33.33%;
}
.col-1-2 {
  width: 50%;
}
.col-1-4 {
  width: 25%;
}
.col-1-8 {
  width: 12.5%;
}

/* Opt-in outside padding */
.grid-pad {
  padding: $pad 0 $pad $pad;
  [class*='col-']:last-of-type {
    padding-right: $pad;
  }
}
.chart {
  width: 100%; 
  height: 300px;
}
</style>

<div class="row board ml0 pl0">

  <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12" >
    <h2>{$translations.dashboard_recruiter.statistics_headline}</h2>
    <p>{$translations.dashboard_recruiter.statistics_desc}</p>
  </div>

  <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12" >
    <a href="{$BASE_URL}{$URL_DASHBOARD}/{$URL_DASHBOARD_JOBS}"><button type="button" class="btn btn-green tabletmt3p deskFr" >{$translations.dashboard_recruiter.back}</button></a>
  </div>
</div>

<br /><br />

  <!--Load the AJAX API-->
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    {literal}
    <script type="text/javascript">

      // Load the Visualization API and the piechart package.
      google.load('visualization', '1.0', {'packages':['corechart', 'gauge', 'bar']});

      // Set a callback to run when the Google Visualization API is loaded.
      google.setOnLoadCallback(drawChart);
      google.setOnLoadCallback(drawGauge);
      google.setOnLoadCallback(drawTrendlines);

      //ad responsivness
      $(window).resize(function(){
        drawChart();
        drawGauge();
        drawTrendlines();
    });

      // Callback that creates and populates a data table,
      // instantiates the pie chart, passes in the data and
      // draws it.
      function drawChart() {

         {/literal}
        var views = parseInt("{$views}");
        var applications = parseInt("{$applications}");
        var graph_headline = "{$graph_headline}";
        {literal}

        // Create the data table.
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Topping');
        data.addColumn('number', 'Slices');
         
        data.addRows([
          ['views', views],
          ['applications', applications]
        ]);
          
        // Set chart options
        var options = {'title': graph_headline,
                       'width':400,
                       'fontSize':12,
                       'height':300};

        // Instantiate and draw our chart, passing in some options.
        var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }

     function drawGauge() {

         {/literal}
        var conversion = parseInt("{$conversion_rate}");
        {literal}

       var data = google.visualization.arrayToDataTable([
          ['Label', 'Value'],
          ['Conversion', conversion],
        ]);

        var options = {
          width: 700, height: 175,
          greenFrom: 75, greenTo: 100,
          yellowFrom: 50, yellowTo: 75,
          minorTicks: 5
        };

        var chart = new google.visualization.Gauge(document.getElementById('gauge_div'));
        chart.draw(data, options);
     }

     function drawTrendlines() {
     var data = new google.visualization.DataTable();
      data.addColumn('date', 'Day');
      data.addColumn('number', '{/literal}{$translations.dashboard_recruiter.stats_views}{literal}');
      data.addColumn('number', '{/literal}{$translations.dashboard_recruiter.stats_applications}{literal}');

      {/literal}
        var title = "{$barchart_headline}";
        var x_title = "{$barchart_x_title}";
        var y_title = "{$barchart_y_title}";
      {literal}

      data.addRows([
        /*[a,VIEWS,APPLICATIONS]*/
        {/literal}
        {foreach from=$stats item=stat}
        {if $smarty.foreach.stat.last}
          [new Date(parseInt("{$statsDate[$stat.id]->year}"), parseInt("{$statsDate[$stat.id]->month}") - 1, parseInt("{$statsDate[$stat.id]->day}")), parseInt("{$stat.views}"), parseInt("{$stat.applications}")]
        {else}
           [new Date(parseInt("{$statsDate[$stat.id]->year}"), parseInt("{$statsDate[$stat.id]->month}") - 1, parseInt("{$statsDate[$stat.id]->day}")), parseInt("{$stat.views}"), parseInt("{$stat.applications}")],
        {/if}
        {/foreach}
        {literal}
      ]);

      var options = {
        title: title,
        hAxis: {
          title: x_title,
          format: 'dd/MM/yyyy',
          textStyle:{fontSize: '11'}
        },
        vAxis: {
          title: y_title
        }
      };

      var chart = new google.visualization.ColumnChart(document.getElementById('barchart_div'));
      chart.draw(data, options);
     }

    </script>
    {/literal}

  <div class="row board mt0">
      <div id="barchart_div" class="chart" style="width: {$firstGraphWidth}"></div>
  </div>

  <div class="row board" >

    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 mobChartFix">
       <div id="chart_div" ></div>
    </div>

     <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 mobGaugeFix">
       <label class="gauge-title mg6p">{$conversion_title}</label>
       <div id="gauge_div"></div>
     </div>

  </div>