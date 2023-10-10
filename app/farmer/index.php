<?php
require_once "../database/conn.php";
	$action = $_POST['action'];
	switch ($action) {
        case 'view_purchases':
		$supplierId	 	 = e($_POST['supplier_id']);
        $result = array();
        $result['read'] = array();

        if ($supplierId){
            $query = mysqli_query($conn,
                "SELECT purchases_tb.*, supplier_tb.*, product_tb.* 
                    FROM purchases_tb 
                        JOIN supplier_tb ON purchases_tb.supplier_id = supplier_tb.id 
                        JOIN products_tb ON purchases_tb.prod_id = products_tb._id
                        WHERE purchases_tb.supplier_id = '$supplierId'
                    ORDER BY purchases_tb.create_date DESC"
            );
        }
        else{
            $query = mysqli_query($conn,
                "SELECT purchases_tb.*, supplier_tb.*, product_tb.* 
                    FROM purchases_tb 
                        JOIN supplier_tb ON purchases_tb.supplier_id = supplier_tb.id 
                        JOIN products_tb ON purchases_tb.prod_id = products_tb._id
                    ORDER BY purchases_tb.create_date DESC"
            );
        }


        if(mysqli_num_rows($query)>0){
                while($row = mysqli_fetch_assoc($query)){
                    $h['id'] 			  	 = $row['id'];
                    $h['supplier_id'] 	 	 	 = $row['supplier_id'];
                    $h['prod_id'] 	 	 	 = $row['prod_id'];
                    $h['prod_name'] 	 	 	 = $row['prod_name'];
                    $h['supplier_name'] 	 	 	 = $row['contact_fname'].' '.$row['contact_sname'];
                    $h['supplier_company'] 	 	 	 = $row['company_name'];
                    $h['original_qty'] 			 = $row['original_qty'];
                    $h['available_qty'] 	     = $row['available_qty'];
                    $h['description']	 	 	     = $row['purchases_tb.description'];
                    $h['purchase_date']	 	 	     = date('d/m/Y',strtotime($row['create_date']));
                    $h['status'] 	     	 = $row['status'];
                    $h['price']			 = $row['price_per_unit'];
                    $h['final_price']			 = $row['final_price_per_unit'];
                    array_push($result["read"], $h);
                }
                $result["success"] = "1";
                echo json_encode($result);
            }else{
                //no records found
                $result["success"] = "0";
                echo json_encode($result);
        }
            mysqli_close($conn);
	break;
	}
?>