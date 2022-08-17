<?php
 include 'DatabaseConfig.php';
 $con = mysqli_connect($HostName,$HostUser,$HostPass,$DatabaseName);
 if( isset($_POST['order_items']) && isset($_POST['method']) &&  isset($_POST['token']) && isset($_POST['amount'])) //check is details sent by the user
 {
    $order_items =json_decode($_POST['order_items']);
    $access_token = $_POST['token'];
    $order_method = $_POST['method'];
    $amount = $_POST['amount'];
    

    $result = mysqli_query($con,"SELECT * FROM user_sessions WHERE token ='$access_token'");
 
    $checkQuery = mysqli_num_rows($result);

    if ($checkQuery > 0) {
    $row = mysqli_fetch_assoc($result);
    $user_id=$row['uid'];
        // if token is available in database
        createOrder($user_id,$amount);
    } else {
        //if token is not found in database
        $data=[
            'success'=>false,
            'message'=>'UnAuthenticated'
        ];
        echo json_encode($data);
        
    }
 }else{
    $data=['success'=>false, 'message'=>'Unable to process the request due to incomplete details.'];
    
    echo json_encode($data);
 }

 function insertOrderItem($proid,$qty, $order_id){

    global $con;
    $insert = "INSERT INTO order_items (proid,quantity,order_id)VALUES('$proid','$qty','$order_id')";
    mysqli_query($con, $insert);
 }
 function makeANewOrder($uid,$amount, $method, $deliverstatus,$transaction_token){

    global $con;
    $insert = "INSERT INTO orders (uid,amount, method, deliverstatus,transaction_token)VALUES('$uid','$amount','$method','$deliverstatus','$transaction_token')";
    return mysqli_query($con, $insert);
 }

 function createOrder($uid,$amount){
    global $order_items;
    global $order_method;
    global $con;

    switch ($order_method) {
        case '1':
            $qurey=makeANewOrder($uid,$amount, $order_method, 'pending',null);
            if($qurey){
                $order_id = $con->insert_id;
             
                foreach ($order_items as $key => $value) {
                    insertOrderItem($key,$value->orderQuantity, $order_id);
                }
                $data=['success'=>true, 'message'=>'Order Succesfully Submitted.'];
                echo json_encode($data);
            }else{
                $data=['success'=>false, 'message'=>'Something went wrong.'];
                echo json_encode($data);
            }
            break;
        case '2':
            if(isset($_POST['transaction_token'])){
                echo json_encode($order_items);
            }else{
                $data=['success'=>false, 'message'=>'Transaction token not found.'];
                echo json_encode($data);
            }
            break;
        case '3':
            $qurey=makeANewOrder($uid,$amount, $order_method, 'pending',null);
            if($qurey){
                $order_id = $con->insert_id;
                foreach ($order_items as $key => $value) {
                    insertOrderItem($key,$value->orderQuantity, $order_id);
                }
                $data=['success'=>true, 'message'=>'Order Succesfully Submitted.'];
                echo json_encode($data);
            }else{
                $data=['success'=>false, 'message'=>'Something went wrong.'];
                echo json_encode($data);
            }
        default:
            $data=['success'=>false, 'message'=>'Unkown order method'];
            echo json_encode($data);
          
      }
}

 ?>