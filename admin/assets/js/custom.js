$(document).ready(function () {
  
  $(document).on("click", ".delete_product_btn", function (e) {
    e.preventDefault();

    var id = $(this).val();

    // alert(id); TESTING PURPOSES

    swal({
      title: "Are you sure?",
      text: "Once deleted, you will not be able to recover this product!",
      icon: "warning",
      buttons: true,
      dangerMode: true,
    }).then((willDelete) => {
      if (willDelete) {
        $.ajax({
          method: "POST",
          url: "code.php",
          data: {
            product_id: id,
            delete_product_btn: true,
          },
          success: function (response) {
            if (response == 200) {
              swal("Success!", "Product deleted Successfully!", "success");
              $("#products_table").load(location.href + " #products_table");
            } else if (response == 500) {
              swal(
                "Error!",
                "Something went wrong while deleting the Product!",
                "error"
              );
            }
          },
        });
      }
    });
  });

  $(document).on("click", ".delete_category_btn", function (e) {
    e.preventDefault();

    var id = $(this).val();

    // alert(id); TESTING PURPOSES

    swal({
      title: "Are you sure?",
      text: "Once deleted, you will not be able to recover this category!",
      icon: "warning",
      buttons: true,
      dangerMode: true,
    }).then((willDelete) => {
      if (willDelete) {
        $.ajax({
          method: "POST",
          url: "code.php",
          data: {
            category_id: id,
            delete_category_btn: true,
          },
          success: function (response) {
            if (response == 200) {
              swal("Success!", "Category deleted Successfully!", "success");
              $("#categories_table").load(location.href + " #categories_table");
            } else if (response == 500) {
              swal(
                "Error!",
                "Something went wrong while deleting the Category!",
                "error"
              );
            }
          },
        });
      }
    });
  });

  $(document).on("click", ".delete_user_btn", function (e) {
    e.preventDefault();

    var id = $(this).val();

    // alert(id); TESTING PURPOSES

    swal({
      title: "Are you sure?",
      text: "Once deleted, the user will not be able to access their account anymore!",
      icon: "warning",
      buttons: true,
      dangerMode: true,
    }).then((willDelete) => {
      if (willDelete) {
        $.ajax({
          method: "POST",
          url: "code.php",
          data: {
            site_user_id: id,
            delete_user_btn: true,
          },
          success: function (response) {
            if (response == 200) {
              swal("Success!", "User deleted Successfully!", "success");
              $("#users_table").load(location.href + " #users_table");
            } else if (response == 500) {
              swal(
                "Error!",
                "Something went wrong while deleting the User!",
                "error"
              );
            }
          },
        });
      }
    });
  });

  $(document).on("click", ".delete_country_btn", function (e) {
    e.preventDefault();

    var id = $(this).val();

    // alert(id); TESTING PURPOSES

    swal({
      title: "Are you sure?",
      text: "Once deleted, the country will no longer be available!",
      icon: "warning",
      buttons: true,
      dangerMode: true,
    }).then((willDelete) => {
      if (willDelete) {
        $.ajax({
          method: "POST",
          url: "code.php",
          data: {
            country_id: id,
            delete_country_btn: true,
          },
          success: function (response) {
            if (response == 200) {
              swal("Success!", "Country deleted Successfully!", "success");
              $("#countries_table").load(location.href + " #countries_table");
            } else if (response == 500) {
              swal(
                "Error!",
                "Something went wrong while deleting the Country!",
                "error"
              );
            }
          },
        });
      }
    });
  });






});
