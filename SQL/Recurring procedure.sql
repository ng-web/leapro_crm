DELIMITER //
CREATE PROCEDURE `recur_job_orders`(id INT, diff INT, type INT)
BEGIN
        DECLARE _cnt INT;
        DECLARE _id INT;
        Declare ea int;
       
        SET _cnt = 1;
        WHILE _cnt <= diff DO

             IF type = 1 THEN BEGIN
               INSERT into estimates(`campaign_id`, `status_id`, `received_date`, `confirmed_date`, `schedule_date_time`,`tax`, `discount`, `factor`, `schedule_end_date`, `recurring_value`)
               select `campaign_id`, `status_id`, `received_date`, `confirmed_date`, `schedule_date_time`+ INTERVAL _cnt WEEK, `tax`, `discount`, `factor`, `schedule_end_date` + INTERVAL _cnt WEEK,
               null from estimates WHERE estimate_id = id;
             END; END IF;

            IF type = 2 THEN BEGIN
               INSERT into estimates(`campaign_id`, `status_id`, `received_date`, `confirmed_date`, `schedule_date_time`,`tax`, `discount`, `factor`, `schedule_end_date`, `recurring_value`)
               select `campaign_id`, `status_id`, `received_date`, `confirmed_date`, `schedule_date_time`+ INTERVAL _cnt MONTH, `tax`, `discount`, `factor`, `schedule_end_date` + INTERVAL _cnt WEEK,
               null from estimat
               es WHERE estimate_id = id;
             END; END IF;
             
             set _id = (select LAST_INSERT_ID()); 

             insert into estimated_areas(estimate_id,area_id)
             select _id, `area_id` from estimated_areas
             where estimate_id = id;
             
             create table estimate_area_temp (ID int not null auto_increment, PRIMARY KEY (ID))
             as select `estimated_area_id` from  estimated_areas where estimate_id = _id;
            
             insert into products_used_per_area(`estimated_area_id`, `product_id`, `quantity`, `product_cost_at_time`)
             select (select `estimated_area_id` from estimate_area_temp) as `estimated_area_id`, `product_id`, `quantity`, 
             `product_cost_at_time` from estimated_areas inner join products_used_per_area 
             on
             products_used_per_area.estimated_area_id = estimated_areas.estimated_area_id
             where estimated_areas.estimate_id = id; 

             drop table estimate_area_temp;
             SET _cnt = _cnt + 1;
        END WHILE;
END//
DELIMITER ;

    