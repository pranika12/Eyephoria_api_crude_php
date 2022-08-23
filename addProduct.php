<?php

include 'DatabaseConfig.php';
include 'helper_functions/authentication_functions.php';

$isAdmin = checkIfAdmin($_POST['token'] ?? null);
if ($isAdmin) {
    if (isset($_POST['name']) && isset($_POST['description'])) {
        $name = $_POST['name'];
        $description = $_POST['description'];

        $addProduct = "INSERT INTO products (name, description) VALUES ('$name', '$description')";
        $result = mysqli_query($con, $addProduct);
        if ($result) {
            echo json_encode(
                [
                    'success' => true,
                    'message' => 'Product added'
                ]
            );
        } else {
            echo json_encode(
                [
                    'success' => false,
                    'message' => 'Error adding product'
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
