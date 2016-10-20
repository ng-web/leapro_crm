<?=$this->title = ''?>
        <!-- Main content -->
        <section class="content">
          <!-- Small boxes (Stat box) -->
          <div class="row">
            <div class="col-lg-3 col-xs-3">
              <!-- small box -->
              <div class="small-box bg-aqua">
                <div class="inner">
                  <h3>150</h3>

                  <p>Active Customers</p>
                </div>
                <div class="icon">
                  <i class="ion ion-person-add"></i>
                </div>
                <a href="#" class="small-box-footer">Client Center <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-3">
              <!-- small box -->
              <div class="small-box bg-green">
                <div class="inner">
                  <h3>53<sup style="font-size: 20px">%</sup></h3>

                  <p>Estimate Conversion</p>
                </div>
                <div class="icon">
                  <i class="ion-android-list"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-3">
              <!-- small box -->
              <div class="small-box bg-yellow">
                <div class="inner">
                  <h3>44</h3>

                  <p>Invoices</p>
                </div>
                <div class="icon">
                  <i class="ion-android-document"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-3">
              <!-- small box -->
              <div class="small-box bg-red">
                <div class="inner">
                  <h3>65</h3>

                  <p>Critical Areas</p>
                </div>
                <div class="icon">
                  <i class="ion-nuclear"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->
          </div>

          <!-- TABLE: LATEST ORDERS -->
         <div class="box box-info">
           <div class="box-header with-border">
             <h3 class="box-title">Latest Job Orders</h3>

             <div class="box-tools pull-right">
               <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
               </button>
               <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
             </div>
           </div>
           <!-- /.box-header -->
           <div class="box-body">
             <div class="table-responsive">
               <table class="table no-margin">
                 <thead>
                 <tr>
                   <th>Order ID</th>
                   <th>Item</th>
                   <th>Status</th>
                   <th>Popularity</th>
                 </tr>
                 </thead>
                 <tbody>
                 <tr>
                   <td><a href="pages/examples/invoice.html">OR9842</a></td>
                   <td>Call of Duty IV</td>
                   <td><span class="label label-success">Shipped</span></td>
                   <td>
                     <div class="sparkbar" data-color="#00a65a" data-height="20">90,80,90,-70,61,-83,63</div>
                   </td>
                 </tr>
                 <tr>
                   <td><a href="pages/examples/invoice.html">OR1848</a></td>
                   <td>Samsung Smart TV</td>
                   <td><span class="label label-warning">Pending</span></td>
                   <td>
                     <div class="sparkbar" data-color="#f39c12" data-height="20">90,80,-90,70,61,-83,68</div>
                   </td>
                 </tr>
                 <tr>
                   <td><a href="pages/examples/invoice.html">OR7429</a></td>
                   <td>iPhone 6 Plus</td>
                   <td><span class="label label-danger">Delivered</span></td>
                   <td>
                     <div class="sparkbar" data-color="#f56954" data-height="20">90,-80,90,70,-61,83,63</div>
                   </td>
                 </tr>
                 <tr>
                   <td><a href="pages/examples/invoice.html">OR7429</a></td>
                   <td>Samsung Smart TV</td>
                   <td><span class="label label-info">Processing</span></td>
                   <td>
                     <div class="sparkbar" data-color="#00c0ef" data-height="20">90,80,-90,70,-61,83,63</div>
                   </td>
                 </tr>
                 <tr>
                   <td><a href="pages/examples/invoice.html">OR1848</a></td>
                   <td>Samsung Smart TV</td>
                   <td><span class="label label-warning">Pending</span></td>
                   <td>
                     <div class="sparkbar" data-color="#f39c12" data-height="20">90,80,-90,70,61,-83,68</div>
                   </td>
                 </tr>
                 <tr>
                   <td><a href="pages/examples/invoice.html">OR7429</a></td>
                   <td>iPhone 6 Plus</td>
                   <td><span class="label label-danger">Delivered</span></td>
                   <td>
                     <div class="sparkbar" data-color="#f56954" data-height="20">90,-80,90,70,-61,83,63</div>
                   </td>
                 </tr>
                 <tr>
                   <td><a href="pages/examples/invoice.html">OR9842</a></td>
                   <td>Call of Duty IV</td>
                   <td><span class="label label-success">Shipped</span></td>
                   <td>
                     <div class="sparkbar" data-color="#00a65a" data-height="20">90,80,90,-70,61,-83,63</div>
                   </td>
                 </tr>
                 </tbody>
               </table>
             </div>
             <!-- /.table-responsive -->
           </div>
           <!-- /.box-body -->
           <div class="box-footer clearfix">
             <a href="javascript:void(0)" class="btn btn-sm btn-info btn-flat pull-left">Create New</a>
             <a href="javascript:void(0)" class="btn btn-sm btn-default btn-flat pull-right">View All Orders</a>
           </div>
           <!-- /.box-footer -->
         </div>
         <!-- /.box -->
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