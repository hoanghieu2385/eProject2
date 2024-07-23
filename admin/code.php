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
    $version = $_POST['version'];
    $edition = $_POST['edition'];
    $description = $_POST['description'];
    $current_price = $_POST['current_price'];

    $image = $_FILES['image']['name'];
    $path = "../uploads";
    $image_ext = pathinfo($image, PATHINFO_EXTENSION);
    $filename = time() . '.' . $image_ext;

    if ($category_id != "" && $artist_id != "" && $album != "" && $description != "" && $current_price != "") {
        // Prepare the SQL statement
        $stmt = $con->prepare("INSERT INTO product (category_id, artist_id, album, version, edition, description, product_image, current_price) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

        if ($stmt === false) {
            die("Failed to prepare statement: " . $con->error);
        }

        // Bind the parameters
        $stmt->bind_param("iisssssd", $category_id, $artist_id, $album, $version, $edition, $description, $filename, $current_price);

        // Execute the statement
        if ($stmt->execute()) {

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

        if (file_exists("../uploads/" . $image)) {
            unlink("../uploads/" . $image);
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

    $country_name = mysqli_real_escape_string($con, $_POST['country_name']);

    $check_country_query = "SELECT * FROM country WHERE country_name='$country_name'";
    $check_country_result = mysqli_query($con, $check_country_query);

    if (mysqli_num_rows($check_country_result) > 0) {

        redirect("country.php", "Country already exists!");
    } else {

        $country_name = $_POST['country_name'];

        $country_query = "INSERT INTO country (country_name)
            VALUES ('$country_name')";
        $country_query_run = mysqli_query($con, $country_query);

        if ($country_query_run) {

            redirect("country.php", "Country added Successfully!");
        } else {

            redirect("country.php", "Something went wrong while adding the Country!");
        }
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
} else if (isset($_POST['add_genre_btn'])) {

    $genre_name = mysqli_real_escape_string($con, $_POST['genre_name']);

    $check_genre_query = "SELECT * FROM genre WHERE genre_name='$genre_name'";
    $check_genre_result = mysqli_query($con, $check_genre_query);

    if (mysqli_num_rows($check_genre_result) > 0) {

        redirect("genre.php", "Genre already exists!");
    } else {

        $genre_name = $_POST['genre_name'];

        $genre_query = "INSERT INTO genre (genre_name)
            VALUES ('$genre_name')";
        $genre_query_run = mysqli_query($con, $genre_query);

        if ($genre_query_run) {

            redirect("genre.php", "Genre added Successfully!");
        } else {

            redirect("genre.php", "Something went wrong while adding the Genre!");
        }
    }
} else if (isset($_POST['update_genre_btn'])) {

    $genre_id = $_POST['genre_id'];
    $genre_name = $_POST['genre_name'];

    $genre_query = "UPDATE genre
    SET genre_name = '$genre_name'
    WHERE id = $genre_id";

    $genre_query_run = mysqli_query($con, $genre_query);

    if ($genre_query_run) {
        redirect("genre.php", "Genre updated Successfully!");
    } else {
        redirect("genre.php?id=$genre_id", "Something went wrong when updating the Genre!");
    }
} else if (isset($_POST['delete_genre_btn'])) {

    $genre_id = mysqli_real_escape_string($con, $_POST['genre_id']);

    $delete_query = "DELETE FROM genre WHERE id='$genre_id'";

    $delete_query_run = mysqli_query($con, $delete_query);

    if ($delete_query_run) {

        echo 200;
    } else {

        echo 500;
    }
} else if (isset($_POST['add_artist_btn'])) {

    $artist_name = mysqli_real_escape_string($con, $_POST['artist_name']);
    $country_id = mysqli_real_escape_string($con, $_POST['country_id']);


    $check_artist_query = "SELECT * FROM artist WHERE full_name='$artist_name'";
    $check_artist_result = mysqli_query($con, $check_artist_query);

    if (mysqli_num_rows($check_artist_result) > 0) {

        redirect("artist.php", "Artist already exists!");
    } else {

        $artist_query = "INSERT INTO artist (full_name, country_id) 
            VALUES ('$artist_name', '$country_id')";
        $artist_query_run = mysqli_query($con, $artist_query);

        if ($artist_query_run) {
            redirect("artist.php", "Artist added Successfully!");
        } else {
            redirect("artist.php", "Something went wrong while adding the Artist!");
        }
    }
} else if (isset($_POST['update_artist_btn'])) {

    $artist_id = $_POST['artist_id'];
    $artist_name = $_POST['artist_name'];
    $country_id = $_POST['country_id'];

    $artist_query = "UPDATE artist
    SET full_name = '$artist_name', country_id = '$country_id'
    WHERE id = $artist_id";

    $artist_query_run = mysqli_query($con, $artist_query);

    if ($artist_query_run) {
        redirect("artist.php", "Artist updated Successfully!");
    } else {
        redirect("artist.php?id=$artist_id", "Something went wrong when updating the Artist!");
    }
} else if (isset($_POST['delete_artist_btn'])) {

    $artist_id = mysqli_real_escape_string($con, $_POST['artist_id']);

    $delete_query = "DELETE FROM artist WHERE id='$artist_id'";

    $delete_query_run = mysqli_query($con, $delete_query);

    if ($delete_query_run) {

        echo 200;
    } else {

        echo 500;
    }
} else if (isset($_POST['add_supplier_btn'])) {

    $supplier_name = mysqli_real_escape_string($con, $_POST['supplier_name']);
    $contact_information = mysqli_real_escape_string($con, $_POST['contact_information']);
    $email_address = mysqli_real_escape_string($con, $_POST['email_address']);
    $country_id = mysqli_real_escape_string($con, $_POST['country_id']);

    $check_supplier_query = "SELECT * FROM supplier WHERE supplier_name='$supplier_name'";
    $check_supplier_result = mysqli_query($con, $check_supplier_query);

    if (mysqli_num_rows($check_supplier_result) > 0) {

        redirect("supplier.php", "Supplier already exists!");
    } else {

        if ($email_address != '') {

            $supplier_query = "INSERT INTO supplier (supplier_name, contact_information, email_address, country_id) 
            VALUES ('$supplier_name', '$contact_information', '$email_address', '$country_id')";
            $supplier_query_run = mysqli_query($con, $supplier_query);

            if ($supplier_query_run) {
                redirect("supplier.php", "Supplier added Successfully!");
            } else {
                redirect("supplier.php", "Something went wrong while adding the Supplier!");
            }
        } else {

            $supplier_query = "INSERT INTO supplier (supplier_name, contact_information, country_id) 
            VALUES ('$supplier_name', '$contact_information', '$country_id')";
            $supplier_query_run = mysqli_query($con, $supplier_query);

            if ($supplier_query_run) {
                redirect("supplier.php", "Supplier added Successfully!");
            } else {
                redirect("supplier.php", "Something went wrong while adding the Supplier!");
            }
        }
    }
} else if (isset($_POST['update_supplier_btn'])) {

    $supplier_id = $_POST['supplier_id'];
    $supplier_name = $_POST['supplier_name'];
    $contact_information = $_POST['contact_information'];
    $email_address = $_POST['email_address'];
    $country_id = $_POST['country_id'];

    if ($email_address != '') {

        $supplier_query = "UPDATE supplier
        SET supplier_name = '$supplier_name', contact_information = '$contact_information', email_address = '$email_address', country_id = '$country_id'
        WHERE id = $supplier_id";
    } else {

        $supplier_query = "UPDATE supplier
        SET supplier_name = '$supplier_name', contact_information = '$contact_information', country_id = '$country_id'
        WHERE id = $supplier_id";
    }

    $supplier_query_run = mysqli_query($con, $supplier_query);

    if ($supplier_query_run) {
        redirect("supplier.php", "Supplier updated Successfully!");
    } else {
        redirect("supplier.php?id=$supplier_id", "Something went wrong when updating the Supplier!");
    }
} else if (isset($_POST['delete_supplier_btn'])) {

    $supplier_id = mysqli_real_escape_string($con, $_POST['supplier_id']);

    $delete_query = "DELETE FROM supplier WHERE id='$supplier_id'";

    $delete_query_run = mysqli_query($con, $delete_query);

    if ($delete_query_run) {

        echo 200;
    } else {

        echo 500;
    }
} else if (isset($_POST['supply_product_btn'])) {

    $category_id = $_POST['category_id'];
    $artist_id = $_POST['artist_id'];
    $album = $_POST['album'];
    $version = $_POST['version'];
    $edition = $_POST['edition'];
    $supplier_id = $_POST['supplier_id'];
    $supply_price = $_POST['supply_price'];
    $quantity = $_POST['quantity'];

    $product_id_query = "SELECT id 
    FROM product 
    WHERE category_id = '$category_id' AND artist_id = '$artist_id' AND album = '$album' AND version = '$version' AND edition = '$edition'";

    $product_id_query_result = mysqli_query($con, $product_id_query);

    if (mysqli_num_rows($product_id_query_result) > 0) {

        $row = mysqli_fetch_assoc($product_id_query_result);
        $product_id = $row['id'];

        $supply_query = "INSERT INTO product_inventory (product_id, supplier_id, supply_price, qty)
        VALUES ('$product_id', '$supplier_id', '$supply_price', '$quantity')";
        $supply_query_run = mysqli_query($con, $supply_query);

        if ($supply_query_run) {
            redirect("inventory.php", "Product restocked successfully!");
        } else {
            redirect("inventory.php", "Something went wrong while restocking!");
        }
    } else {

        redirect("inventory.php", "Product doesn't exist!");
    }
} else if (isset($_POST['update_ps_btn'])) {

    $payment_shipment_id = $_POST['payment_shipment_id'];
    $payment_option_id = $_POST['payment_option_id'];
    $shipment_option_id = $_POST['shipment_option_id'];
    $fees = $_POST['fees'];

    $payment_shipment_id_query = "UPDATE payment_shipment SET payment_option_id='$payment_option_id', shipment_option_id='$shipment_option_id', fees='$fees' WHERE id='$payment_shipment_id'";

    $payment_shipment_id_query_run = mysqli_query($con, $payment_shipment_id_query);

    if ($payment_shipment_id_query_run) {

        redirect("payment_shipment.php", "Payment and Shipment options Updated Successfully!");
    } else {

        redirect("site_user.php", "Something went wrong while updating!");
    }
} else {
    header('Location: ../index.php');
}
