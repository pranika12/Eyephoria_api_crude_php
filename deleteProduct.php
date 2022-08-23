<?php

include 'DatabaseConfig.php';
include 'helper_functions/authentication_functions.php';

$isAdmin = checkIfAdmin($_POST['token'] ?? null);
if ($isAdmin) {
    if (isset($_POST['id']) && isset($_POST['name']) && isset($_POST['description'])) {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $description = $_POST['description'];
        $deleteProduct = "DELETE FROM products WHERE name='$name'";
        $result = mysqli_query($con, $deleteProduct);
        if ($result) {
            echo json_encode(
                [
                    'success' => true,
                    'message' => 'Product Deleted'
                ]
            );
        } else {
            echo json_encode(
                [
                    'success' => false,
                    'message' => 'Error deleting product'
                ]
            );
        }
    } else {
        echo json_encode(
            [
                'success' => false,
                'message' => 'Please fill all the fields.'
            ]
        );
    }
} else {
    echo json_encode(
        [
            'success' => false,
            'message' => 'Access denied'
        ]
    );
}

