<?php
  use yii\helpers\Html;
  use yii\widgets\DetailView;
  $this->params['breadcrumbs'][] = ['label' => 'Estimates', 'url' => ['index']];
  $this->params['breadcrumbs'][] = 'View';
?>

<div class="customers-view">
  <div class="container">
       <div class="row">
          <div class="col-md-4">
            <div class="panel ">
                <div class="panel-heading" >
                  <h3 class="panel-title">
                        <img alt="User Pic" src='img/profile.png' height="60px;"  class="img-circle"> 
                        <?=ucwords($model->customer_firstname) .' '. ucwords($model->customer_lastname)?> &nbsp (<?=$model->status?>)
                  </h3>
                </div>
                <div class="panel-body">
                  <div class="row">
                     <div class=""> 
                      <table class="table table-user-information">
                        <tbody>
                          <tr>
                            <td>Registered date:</td>
                            <td><?= date("M d, Y", strtotime($model->date_registered))?></td>
                          </tr>
                          <tr>
                            <td>Gender</td>
                            <td><?= ucwords($model->gender)?></td>
                          </tr>
                           <tr>
                              <td>Address</td>
                             <td>
                                    <?= $model->addresses->address_line1?>,&nbsp
                                    <?= $model->addresses->address_line2?>, <br />
                                    <?= $model->addresses->address_province?>
                             </td>
                            </tr>
                          <tr>
                            <td>Email</td>
                            <td><a href=""><?=$model->customer_email?></a></td>
                          </tr>
                          <tr>
                            <td>Phone Number</td>
                            <td>
                                <?=$model->customer_telephone?>(Landline) <br/>
                                <?= $model->customer_cell?>(Mobile)
                            </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
                 <div class="panel-footer">
                    <a data-original-title="Broadcast Message" data-toggle="tooltip" type="button" class="btn btn-sm btn-primary"><i class="glyphicon glyphicon-envelope"></i></a>
                    <span class="pull-right">
                      <?=  '<a href="index.php?r=customers/update&id='.$model['customer_id'].'"  class="btn btn-sm btn-warning"><i class="glyphicon glyphicon-edit"></i></a>'?>
                    </span>
                </div>     
            </div>
          </div>
          <div class="col-md-8">
               <ul class="nav nav-tabs">
                  <li class="active"><a  href="#job-orders-section" data-toggle="tab">Job Orders  <span class="badge success"><?=$jobOrdersProvider->totalCount?></a></li>
                  <li><a href="#estimate-section"data-toggle="tab">Estimates <span class="badge label-primary"><?=$dataProvider->totalCount?></a></li>
                  <?= ($model->customer_type=='Commercial')?
                       '<li><a href="#company-section"data-toggle="tab">Companies<span class="badge label-primary">'.$dataProvider->totalCount.'</a></li>':''
                  ?>
              </ul>
              <div class="tab-content">
                   <div class="tab-pane active" id="job-orders-section">
                      <?= $this->render('customer-job-orders', [
                            'jobOrdersProvider' => $jobOrdersProvider,

                      ]) ?>
                   </div>
                   <div class="tab-pane" id="estimate-section">
                     <?= $this->render('customer_estimate', [
                                        'id'=>$id,
                            'dataProvider' => $dataProvider,

                      ]) ?>
                   </div>
                   <div class='tab-pane' id='company-section'>
                          <?= $this->render('company-list', [
                                'companiesDataProvider' => $companiesDataProvider,

                          ]) ?>
                    </div>

              </div>  
          </div>
       </div>
       <div class="row">
        <div class="panel-group">
          <div class="panel panel-default">
                <div class="panel-heading">
                  <h4 class="panel-title">
                   <span class=" glyphicon glyphicon-folder-open">&nbsp</span> Invoices
                    <a data-toggle="collapse" href="#collapse1" class="pull-right"> <span class="glyphicon glyphicon-chevron-down"></span></a>
                  </h4>
                </div>
                <div id="collapse1" class="panel-collapse collapse">
                <div class="panel-body">
                 Not yet Implemented..
                </div>
            </div>
           </div>
          </div>
       </div>
   </div>
</div>
