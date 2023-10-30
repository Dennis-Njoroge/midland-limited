<?php
require_once "../database/conn.php";
	$action = $_GET['action'];
    $result = array();
	switch ($action) {
        case 'view_purchases':
		$supplierId	 	 = isset($_POST['supplier_id']) ? e($_POST['supplier_id']) : null;
		$status	 	 = isset($_POST['status']) ? e($_POST['status']) : null;

        $result['read'] = array();
//        if ($supplierId){
//            $query = mysqli_query($conn,
//                "SELECT p.*, s.contact_fname, s.contact_sname, s.company_name, prod.prod_name
//                    FROM purchases_tb p
//                        JOIN supplier_tb s ON p.supplier_id = s.id
//                        JOIN product_tb prod ON p.prod_id = prod.prod_id
//                        WHERE ('$supplierId' IS NULL OR p.supplier_id = '$supplierId')
//                    ORDER BY p.create_on DESC"
//            );
//        }
//        else{
//            $query = mysqli_query($conn,
//                "SELECT p.*, s.contact_fname, s.contact_sname, s.company_name, prod.prod_name
//                    FROM purchases_tb p
//                        JOIN supplier_tb s ON p.supplier_id = s.id
//                        JOIN product_tb prod ON p.prod_id = prod.prod_id
//                    ORDER BY p.create_on DESC"
//            );
//        }
            $query = mysqli_query($conn,
                "SELECT p.*, s.contact_fname, s.contact_sname, s.company_name, prod.prod_name 
                    FROM purchases_tb p 
                        JOIN supplier_tb s ON p.supplier_id = s.id 
                        JOIN product_tb prod ON p.prod_id = prod.prod_id
                        WHERE (COALESCE('$supplierId', '') = '' OR p.supplier_id = '$supplierId')
                        AND (COALESCE('$status', '') = '' OR p.status = '$status')
                    ORDER BY p.create_on DESC"
            );
        if(mysqli_num_rows($query)>0){
                while($row = mysqli_fetch_assoc($query)){
                    $h['id'] 			  	 = $row['id'];
                    $h['purchase_no'] 	 	 	 = $row['purchase_no'];
                    $h['payment_code'] 	 	 	 = $row['payment_code'];
                    $h['supplier_id'] 	 	 	 = $row['supplier_id'];
                    $h['prod_id'] 	 	 	 = $row['prod_id'];
                    $h['prod_name'] 	 	 	 = $row['prod_name'];
                    $h['supplier_name'] 	 	 	 = $row['contact_fname'].' '.$row['contact_sname'];
                    $h['supplier_company'] 	 	 	 = $row['company_name'];
                    $h['original_qty'] 			 = $row['original_qty'];
                    $h['available_qty'] 	     = $row['available_qty'];
                    $h['description']	 	 	     = $row['description'];
                    $h['purchase_date']	 	 	     = date('d/m/Y',strtotime($row['create_on']));
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

	break;
        case 'approve_purchase':
            $purchaseId = isset($_POST['purchase_id']) ? e($_POST['purchase_id']) : null;
            $status = 'APPROVED';
            $availableQty = isset($_POST['available_qty']) ? e($_POST['available_qty']) : null;
            $price = isset($_POST['price']) ? e($_POST['price']) : null;
            if(!$status ||  !$purchaseId ){
                $result['success']  = "0";
                $result['message']  = "Purchase ID  missing!";
            }
            else{

                $query = mysqli_query($conn,
                    "UPDATE purchases_tb
                            SET 
                                status = '$status',
                                available_qty = CASE
                                    WHEN '$availableQty' IS NOT NULL THEN '$availableQty'
                                    ELSE available_qty
                                END,
                                final_price_per_unit = CASE
                                    WHEN '$price' IS NOT NULL  THEN '$price'
                                    ELSE final_price_per_unit
                                END
                            WHERE id = '$purchaseId'");
                if($query){
                    $result['success']  = "1";
                    $result['message']  = "Operation successful!";
                }
                else{
                    $result['success']  = "0";
                    $result['message']  = "Operation failed";
                }
            }
            echo json_encode($result);
            break;
        case 'update_purchase_status':
            $purchaseId = isset($_POST['purchase_id']) ? e($_POST['purchase_id']) : null;
            $status = isset($_POST['status']) ? e($_POST['status']) : null;
            $transactionCode = isset($_POST['payment_code']) ? e($_POST['payment_code']) : null;
            if(!$status ||  !$purchaseId){
                $result['success']  = "0";
                $result['message']  = "Purchase ID or Status missing!";
            }
            else{

                $query = mysqli_query($conn,
                    "UPDATE purchases_tb
                            SET status = '$status'
                            WHERE id = '$purchaseId'");
                if($query){
                    $result['success']  = "1";
                    $result['message']  = "Operation successful!";
                }
                else{
                    $result['success']  = "0";
                    $result['message']  = "Operation failed";
                }
            }
            echo json_encode($result);
            break;
        default:
        $result["success"] = "0";
        $result["message"] = "Invalid action provided";
        echo json_encode($result);

	}
 mysqli_close($conn);
?>