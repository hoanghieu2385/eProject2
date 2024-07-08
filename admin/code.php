<?php

session_start();
include('../config/dbcon.php');
include('../functions/myfunctions.php');

if (isset($_POST['add_category_btn'])) {

    $category_name = $_POST['category_name'];
    $parent_category_id = $_POST['parent_category_id'];

    $image = $_FILES['image']['category_name'];

    $path = "../uploads";

    $image_ext = pathinfo($image, PATHINFO_EXTENSION);
    $filename = time() . '.' . $image_ext;

    $category_query = "INSERT INTO product_category (category_name, parent_category_id)
    VALUES ('$category_name','$parent_category_id')";

    $category_query_run = mysqli_query($con, $category_query);

    if ($category_query_run) {

        move_uploaded_file($_FILES['image']['tmp_name'], $path . '/' . $filename);
        redirect("add-category.php", "Category added Successfully!");
    } else {

        redirect("add-category.php", "Something went wrong!");
    }
}
