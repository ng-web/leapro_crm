<?=$this->title = ''?>

<div class="row">
    <div class="col-lg-12  col-md-12 col-sm-12 col-xs-12">
        <?= \dosamigos\highcharts\HighCharts::widget([
            'clientOptions' => [
                'chart' => [
                        'type' => 'line'
                ],
                'title' => [
                     'text' => 'Summary for current year'
                     ],
                'xAxis' => [
                    'categories' => [
                        'January',
                        'February',
                        'March',
                        'April',
                        'May',
                        'June',
                        'July',
                        'August',
                        'September',
                        'October',
                        'November',
                        'December',
                    ]
                ],
                'yAxis' => [
                    'title' => [
                        'text' => ''
                    ]
                ],
                'series' => [
                    ['name' => 'JobOrders', 'data' => $jobOrders],
                    ['name' => 'Declined Estimates', 'data' => $declined]
                ]
            ]
        ]);
        ?>
   </div>
   <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
     <br>
       <?= \dosamigos\highcharts\HighCharts::widget([
            'clientOptions' => [
                'chart' => [
                        'type' => 'column'
                ],
                'title' => [
                     'text' => 'Summary for current year'
                     ],
                'xAxis' => [
                    'categories' => [
                        'January',
                        'February',
                        'March',
                        'April',
                        'May',
                        'June',
                        'July',
                        'August',
                        'September',
                        'October',
                        'November',
                        'December',
                    ]
                ],
                'yAxis' => [
                    'title' => [
                        'text' => ''
                    ]
                ],
                'series' => [
                    ['name' => 'JobOrders', 'data' => $jobOrders],
                    ['name' => 'Declined Estimates', 'data' => $declined]
                ]
            ]
        ]);
        ?>
   </div>
  
   <div class="col-lg-6  col-md-6 col-sm-6 col-xs-6">
     <br>
          <?= \dosamigos\highcharts\HighCharts::widget([
            'clientOptions' => [
                'chart' => [
                        'type' => 'bar'
                ],
                'title' => [
                     'text' => 'Summary for current year'
                     ],
                'xAxis' => [
                    'categories' => [
                        'January',
                        'February',
                        'March',
                        'April',
                        'May',
                        'June',
                        'July',
                        'August',
                        'September',
                        'October',
                        'November',
                        'December',
                    ]
                ],
                'yAxis' => [
                    'title' => [
                        'text' => ''
                    ]
                ],
                'series' => [
                    ['name' => 'JobOrders', 'data' => $jobOrders],
                    ['name' => 'Declined Estimates', 'data' => $declined]
                ]
            ]
        ]);
        ?>
   </div>
</div>