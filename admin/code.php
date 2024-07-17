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

        redirect("product_category.php", "Something went wrong while adding the Category!");
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
        // redirect("product_category.php", "Category deleted Successfully.");
        echo 200;
    } else {
        // redirect("product_category.php", "Something went wrong with the Category deletion.");
        echo 500;
    }

} else if (isset($_POST['add_product_btn'])) {

    $category_id = $_POST['category_id'];
    $artist_id = $_POST['artist_id'];
    $album = $_POST['album'];
    $description = $_POST['description'];
    $current_price = $_POST['current_price'];

    $image = $_FILES['image']['name'];

    $path = "../uploads";

    $image_ext = pathinfo($image, PATHINFO_EXTENSION);
    $filename = time() . '.' . $image_ext;

    if ($category_id != "" && $artist_id != "" && $album != "" && $description != "" && $current_price != "") {
        $product_query = "INSERT INTO product (category_id, artist_id, album, description, product_image, current_price) 
                            VALUES ('$category_id', '$artist_id', '$album', '$description', '$filename', '$current_price')";

        $product_query_run = mysqli_query($con, $product_query);

        if ($product_query_run) {

            move_uploaded_file($_FILES['image']['tmp_name'], $path . '/' . $filename);

            redirect("product.php", "Product added Successfully!");
        } else {

            redirect("product.php", "Something went wrong while adding the Product!");
        }
    } else {
        redirect("product.php", "Please fill in the blanks!");
    }
} else if (isset($_POST['update_product_btn'])) {

    $product_id = $_POST['product_id'];
    $category_id = $_POST['category_id'];
    $artist_id = $_POST['artist_id'];
    $album = $_POST['album'];
    $description = $_POST['description'];
    $current_price = $_POST['current_price'];

    $path = "../uploads";

    $new_image = $_FILES['image']['name'];
    $old_image = $_POST['old_image'];

    if ($new_image != "") {

        $image_ext = pathinfo($new_image, PATHINFO_EXTENSION);
        $update_filename = time() . '.' . $image_ext;
    } else {

        $update_filename = $old_image;
    }

    $update_product_query = "UPDATE product 
    SET category_id = '$category_id', artist_id = '$artist_id', album = ' $album', description = '$description', current_price = '$current_price', product_image = '$update_filename' 
    WHERE id = $product_id";

    $update_product_query_run = mysqli_query($con, $update_product_query);

    if ($update_product_query_run) {

        if ($_FILES['image']['name'] != "") {

            move_uploaded_file($_FILES['image']['tmp_name'], $path . '/' . $update_filename);

            if (file_exists("../uploads/" . $old_image)) {

                unlink("../uploads/" . $old_image);
            }
        }

        // redirect("edit_product.php?id=$product_id", "Product Updated Successfully!");
        redirect("product.php", "Product Updated Successfully!");

    } else {

       // redirect("edit_product.php?id=$product_id", "Something went wrong!");
       redirect("product.php", "Something went wrong while updating the Product!");
    }
} else if (isset($_POST['delete_product_btn'])) {

    $product_id = mysqli_real_escape_string($con, $_POST['product_id']);

    $product_query = "SELECT * FROM product WHERE id = '$product_id'";
    $product_query_run = mysqli_query($con, $product_query);
    $product_data = mysqli_fetch_array($product_query_run);
    $image = $product_data['product_image'];

    $delete_query = "DELETE FROM product WHERE id = '$product_id'";
    $delete_query_run = mysqli_query($con, $delete_query);

    if ($delete_query_run) {

        if (file_exists("../uploads/".$image)) {
            unlink("../uploads/".$image);
        }

        // redirect("product.php", "Product deleted Successfully");
        echo 200;
    } else {
        // redirect("product.php", "Something went wrong while deleting the Product!");
        echo 500;
    }

} else if (isset($_POST['update_user_btn'])) {

    $site_user_id = $_POST['site_user_id'];
    $email_address = $_POST['email_address'];
    $phone_number = $_POST['phone_number'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $role_id = $_POST['role_id'];

    $update_user_query = "UPDATE site_user
    SET email_address = '$email_address', phone_number = '$phone_number', first_name = '$first_name', last_name = '$last_name', role_id = '$role_id' 
    WHERE id = $site_user_id";

    $update_user_query_run = mysqli_query($con, $update_user_query);

    if ($update_product_query_run) {
        
        redirect("site_user.php", "User Updated Successfully!");

    } else {

       // redirect("edit_product.php?id=$product_id", "Something went wrong!");
       redirect("site_user.php", "Something went wrong while updating the User!");
    }

} else if (isset($_POST['delete_user_btn'])) {

    $user_id = mysqli_real_escape_string($con, $_POST['user_id']);

    $user_query = "SELECT * FROM site_user WHERE id = '$user_id'";
    $user_query_run = mysqli_query($con, $user_query);
    $user_data = mysqli_fetch_array($user_query_run);

    $delete_query = "DELETE FROM user WHERE id = '$user_id'";
    $delete_query_run = mysqli_query($con, $delete_query);

    if ($delete_query_run) {

        echo 200;
        
    } else {

        echo 500;
    }

} else if (isset($_POST['add_country_btn'])) {

    $country_name = $_POST['country_name'];

    $country_query = "INSERT INTO country (country_name)
        VALUES ('$country_name')";


    $country_query_run = mysqli_query($con, $country_query);

    if ($country_query_run) {

        redirect("country.php", "Country added Successfully!");
    } else {

        redirect("country.php", "Something went wrong while adding the Country!");
    }
} else if (isset($_POST['update_country_btn'])) {

    $country_id = $_POST['country_id'];
    $country_name = $_POST['country_name'];

    $country_query = "UPDATE country
    SET country_name = '$country_name'
    WHERE id = $country_id";

    $country_query_run = mysqli_query($con, $country_query);

    if ($country_query_run) {
        redirect("country.php", "Country updated Successfully!");
    } else {
        redirect("country.php?id=$country_id", "Something went wrong when updating the Country!");
    }

} else if (isset($_POST['delete_country_btn'])) {

    $country_id = mysqli_real_escape_string($con, $_POST['country_id']);

    $delete_query = "DELETE FROM country WHERE id='$country_id'";

    $delete_query_run = mysqli_query($con, $delete_query);

    if ($delete_query_run) {

        echo 200;
        
    } else {

        echo 500;
    }

} else {
    header('Location: ../index.php');
}
