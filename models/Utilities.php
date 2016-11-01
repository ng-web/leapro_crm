<?php

namespace app\models;


class Utilities
{

	public static function  datediffInWeeks($datefrom, $dateto, $type)
	{
		//var_dump($datefrom); die();
		$d1 = date('Y-m-d',strtotime($datefrom));
		$d2 = date('Y-m-d',strtotime($dateto));

		$date3 = date_create($d1);
		$date4 = date_create($d2);
	
		$diff34 = date_diff($date4, $date3);

		//accesing months
		switch($type){
			case 1:
		        $days = floor($diff34->days/7);
		        $result = $days;
	        break;
			case 2:
				$months = $diff34->m;
		        $result = $months;
            break;
            
        }
	 
       return $result;
	}

	
}
?>