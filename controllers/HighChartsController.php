<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;

class HighChartsController extends Controller 
{
    public function actionIndex()
    {
        $sql = "SELECT bsr_date, bs_status FROM `bsr_header` BH
                INNER JOIN bsr_activity BA
                ON BH.bsr_id = BA.bsr_id
                WHERE equipment_id = 97
                AND BH.bsr_date >= '2016-04-01'
                AND equipment_id 
                IN
                (SELECT equipment_id FROM `deploy`
                INNER JOIN `address`
                ON deploy.address_id=address.address_id
                INNER JOIN `area`
                ON deploy.area_id=area.area_id
                WHERE address.address_line1 = 'Old Harbour'
                AND deploy.area_id = 3
                /*
                AND area.area_name LIKE '%Canteen%'*/)";
        
        $rawData = Yii::$app->db->createCommand($sql)->queryAll();
        
        return $this->render('index', [
            'rawData' => $rawData
        ]);
    }
}