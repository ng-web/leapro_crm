<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\data\ArrayDataProvider;
use kartik\grid\GridView;
use yii\widgets\DetailView;
use app\models\Estimates;

?>
<div class="estimates-form">
    <div class="form-group">
     <?php 
        if($estimates[0]['status_id'] == 1 || $estimates[0]['status_id']  == 3 && date('Y-m-d', strtotime($estimates[0]['schedule_date_time'])) > date('Y-m-d')){
          echo '<a class="btn btn-primary" href="index.php?r=estimates/update&id='.$estimates[0]['estimate_id'].'">Update</a>'; 
        }
         
    ?>
     
    </div>

<?php 
  //Queries to display preview
  $totalCost = Estimates::FindTotalCost($id);

  $services = Estimates::FindServicesSql($id);
  $subTotal = 0;
  $discounts = 0;
?>

<div style="float: right">
<table>
    <tr>
      <th>
         QUOTATION
      </th>
    </tr>
    <tr>
     <td>
        <?php echo"Quote Number: ".$estimates[0]['estimate_id']."<br />".
                  "Quote Date: ".date('M d, Y',strtotime($estimates[0]['received_date']))?>
       </td>
    </tr>
</table>
</div>

<table>
    <tr>
      <th>
         Quoted To:
      </th>
    </tr>
    <tr>
     <td>
        <?php echo $estimates[0]['name']."<br />".
             $estimates[0]['address_line1'].", ".$estimates[0]['address_line2']."<br />".$estimates[0]['address_province']?>
     </td>
    </tr>
</table>
</div>
<br />


 <table class="table table-bordered">
    <tr>
      <th>Good Thru</th>
      <th>Payment Terms</th>
      <th>Sales Rep</th>
    </tr>
    <tr>
       <td><?=date('M d, Y',strtotime($estimates[0]['expiry_date']))?></td>
       <td></td>
       <td></td>
    </tr> 
  </table>

  <table class="table table-bordered">
      <tr>
        <th>Service</th>
        <th>Cost</th>
      </tr>
        <?php  
             foreach($services as $i => $service)
             {  
                   echo' <tr>
                          <td>'.$service['service_name'].'</td>
                          <td>$'.$service['service_cost'].'</td>
                        </tr>';
                  
                      echo ' <tr >
                              <td colspan="2" style="background-color: #eee">
                               <table class="table table-bordered" >
                                <tr>
                                  <th>Area</th>
                                  <th>Product</th>
                                  <th>Description</th>
                                  <th>Quantity</th>
                                  <th>Unit Price</th>
                                  <th>Amount</th>
                                </tr>
                            ';
                  
                    $areas = Estimates::FindAreas($id, $service['service_id']);
                    foreach($areas as $area)
                    {
                      
                          echo '<tr> <td>'.$area['area_name'].'</td>
                                 ';

                           $products = Estimates::FindProductUsedInArea($id, $service['service_id'], $area['area_id']);
                           foreach($products as $j => $product)
                           {  
                             if($area['area_name'] == $product['area_name'])
                             {
                                $tags = ($j>0)?'<td></td>':'';
                                $cost = Estimates::CalculateCost($service, $product, $area['area_id']);
                                 echo' '.$tags.'
                                          <td>'.$product['product_name'].'</td>
                                          <td>'.$product['product_description'].'</td>
                                          <td>'. $product['quantity'] .'</td>
                                          <td>$'. $product['product_cost_at_time'] .'</td>
                                          <td>$'. number_format($cost, 2).' </td>
                                      </tr>';
                                      $subTotal += $cost;
                             }
                           }
                      
                      
                   }
                  if($i < count($services)){
                    echo '</table>
                            </td>
                            </tr>';
                  }
                 //$discounts +=  ($service['service_cost']*$service['discount']/100) ;
                  $subTotal += $service['service_cost'];
             }
    ?>
  </table>


<?php
   $tax = ($subTotal*$estimates[0]['tax']/100);
?>
 <div  style="float: right">
   <table class="table">
       <tr>
      <th colspan="4" style="text-align: right">Sub Total</th>
      <th>$<?php echo number_format($subTotal, 2);?></th>
    </tr>
    <tr>
      <th colspan="4" style="text-align: right">Discount</th>
      <th>$<?php echo number_format($discounts, 2);?></th>
    </tr>
    <tr>
      <th colspan="4" style="text-align: right">Sales Tax</th>
      <th>$<?php echo number_format($tax, 2)?></th>
    </tr>
    <tr>
      <th colspan="4" style="text-align: right">Total</th>
      <th>$<?php echo number_format($subTotal + ($tax) - $discounts, 2)?></th>
    </tr>
   </table>
 </div>


