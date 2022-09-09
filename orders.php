<?php
include 'DatabaseConfig.php';
include 'helper_functions/authentication_functions.php';
    $tokenCheck=checkIdValidUser($_POST['token']??null);
    if(isset($_POST['token']) && $tokenCheck != null){
           //get orders from orders table
           $isAdmin = checkIfAdmin($_POST['token']);
           if($isAdmin){
               $sql = "SELECT * FROM orders";
           }else{
                $userId=$tokenCheck;
                $sql = "SELECT * FROM orders WHERE user_id = '$userId'";
           }
            $result = mysqli_query($con, $sql);
            if ($result) {
                $data = [];
                while ($row = mysqli_fetch_assoc($result)) {
                    $data[] = $row;
                }
                echo json_encode(
                    [
                        'success' => true,
                        'data' => $data,
                        'message' => "Orders fetched successfully"
                    ]
                );
            } else {
                echo json_encode(
                    [
                        'success' => false,
                        'message' => 'Error fetching orders'
                    ]
                );
            }
    }else{
        echo json_encode(
            [
                'success' => false,
                'message' =>'Access denied'
            ]
        );
    }
?>





