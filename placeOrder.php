<?php

 include 'DatabaseConfig.php';
 // Creating MySQL Connection.
 $con = mysqli_connect($HostName,$HostUser,$HostPass,$DatabaseName);
 
 if( isset($_POST['token'])) {
    $access_token = $_POST['token'];

    //Applying User Login query with email and password.
    
       $userQuery = "SELECT * FROM user_sessions WHERE token ='$access_token'";
       $sendingQuery = mysqli_query($con, $userQuery);
       $checkQuery = mysqli_num_rows($sendingQuery);
   
       if ($checkQuery > 0) {
           // if token is available in database
           getProducts();
       } else {
           //if token is not found in database
           $data=[
               'success'=>false,
               'message'=>'UnAuthenticated'
           ];
           echo json_encode($data);
           
       }
 }else{
    $data=[
        'success'=>false,
        'message'=>'Token is required'
    ];
    echo json_encode($data);
 }
 

function getProducts()
{
    global $con;

    $sql = "SELECT * FROM products where is_deleted=0";
    $query = mysqli_query($con, $sql);

    if ($query) {
        //after the query is sucessfully executed!
        while($row=mysqli_fetch_assoc($query)) {
            $resultset[] = $row;
        }
        if(!empty($resultset))
        $data=[
            'success'=>true,
            'message'=>'Data successfully feteched.',
            'data'=>$resultset

        ];
        echo json_encode($data);

    } else {

        $data=[
            'success'=>false,
            'message'=>'Something went wrong.'
        ];
        echo json_encode($data);
    }
}

?>
