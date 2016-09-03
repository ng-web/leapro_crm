<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\data\ArrayDataProvider;
use kartik\grid\GridView;
use yii\widgets\DetailView;
use app\models\Estimates;

?>
<div class="estimates-form">

<?php 
  //Queries to display preview
  $totalCost = Estimates::FindTotalCost(7);
  $areas = Estimates::FindAreas(7);
  $products = Estimates::FindProductUsedInArea(7);
  $services = Estimates::FindServicesSql(7);

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
        <?=  "Quote Number: ".$estimates[0]['estimate_id']."<br />".
             "Quote Date: ".$estimates[0]['received_date']?>
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
        <?=  $estimates[0]['company_name']."<br />".
             $estimates[0]['address_line1'].", ".$estimates[0]['address_line2']."<br />".$estimates[0]['address_province']?>
     </td>
    </tr>
</table>
</div>

<table class="table table-bordered" >
  <caption></caption>
  <thead>
    <tr>
      <th>Area</th>
      <th>Product</th>
      <th>Quantity</th>
      <th>Unit Price</th>
      <th>Amount</th>
    </tr>
  </thead>
  <tbody>
    <tr>
    <?php  
      foreach($areas as $area)
      {
        echo ' <td>'.$area['area_name'].'</td>
               <td></td>
               <td></td>
               <td></td>
               <td></td>';
         foreach($products as $product)
         {  
           if($area['area_name'] == $product['area_name'])
           {
               echo' <tr>
                        <td></td>
                        <td>'.$product['product_name'].'</td>
                        <td>'. $product['quantity'] .'</td>
                        <td>$'. $product['product_cost_at_time'] .'</td>
                        <td>$'. $product['product_cost_at_time'] * $product['quantity'].' </td>
                    </tr>';
           }
           
         }
        
     }
   ?>
     
    </tr>
    <tr>
        <td colspan="5">
            <table class="table">
                  <thead>
                    <tr>
                      <th>Service</th>
                      <th>Description</th>
                      <th>Cost</th>
                      <th>Discount</th>
                      <th>Total</th>
                    </tr>
                  </thead>
                   <tbody>
                      
                      <?php  
                        
                           foreach($services as $service)
                           {  
                                 echo' <tr>
                                    <td>'.$service['service_name'].'</td>
                                    <td>'.$service['service_cost'].'</td>
                                    <td>'.$service['service_cost'].'</td>
                                    <td>'. $service['discount'] .'</td>
                                    <td>'.$service['service_cost'] - $service['discount'] .'</td>
                                  </tr>';
                           }
                         
                         
                     ?>
                  
                   </tbody>
            </table>
        </td>
    </tr>
  </tbody>
  <tfoot>
    
  </tfoot>
</table>

 <div  style="float: right">
   <table class="table">
       <tr>
      <th colspan="4" style="text-align: right">Sub Total</th>
      <th>$667.90</th>
    </tr>
    <tr>
      <th colspan="4" style="text-align: right">Discount</th>
      <th>$667.90</th>
    </tr>
    <tr>
      <th colspan="4" style="text-align: right">Sales Tax</th>
      <th>$667.90</th>
    </tr>
    <tr>
      <th colspan="4" style="text-align: right">Total</th>
      <th>$667.90</th>
    </tr>
   </table>
 </div>


