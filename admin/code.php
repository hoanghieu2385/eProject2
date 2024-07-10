<?php

session_start();
include('../config/dbcon.php');
include('../functions/myfunctions.php');

if (isset($_POST['add_category_btn'])) {

    $category_name = $_POST['category_name'];
    $parent_category_id = $_POST['parent_category_id'];


    if ($parent_category_id != null) {
        $category_query = "INSERT INTO product_category (category_name, parent_category_id)
            VALUES ('$category_name','$parent_category_id')";
    } else {
        $category_query = "INSERT INTO product_category (category_name)
            VALUES ('$category_name')";
    }


    $category_query_run = mysqli_query($con, $category_query);

    if ($category_query_run) {

        redirect("product_category.php", "Category added Successfully!");
    } else {

        redirect("product_category.php", "Something went wrong!");
    }
} else if (isset($_POST['update_category_btn'])) {

    $product_category_id = $_POST['product_category_id'];
    $category_name = $_POST['category_name'];
    $parent_category_id = $_POST['parent_category_id'];


    if ($parent_category_id != null) {
        $update_query = "UPDATE product_category SET category_name='$category_name', parent_category_id='$parent_category_id' WHERE id='$product_category_id'";
    } else {
        $update_query = "UPDATE product_category SET category_name='$category_name' WHERE id='$product_category_id'";
    }

    $update_query_run = mysqli_query($con, $update_query);

    if ($update_query_run) {
        redirect("product_category.php", "Category updated Successfully!");
    } else {
        redirect("edit_product_category.php?id=$product_category_id", "Something went wrong when updating the Category!");
    }
} else if (isset($_POST['delete_category_btn'])) {
    $category_id = mysqli_real_escape_string($con, $_POST['category_id']);

    $delete_query = "DELETE FROM product_category WHERE id='$category_id'";

    $delete_query_run = mysqli_query($con, $delete_query);

    if ($delete_query) {
        redirect("product_category.php", "Category deleted Successfully.");
    } else {
        redirect("product_category.php", "Something went wrong with the category deletion.");
    }
}
