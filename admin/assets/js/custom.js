$(document).ready(function () {
    
    $(document).on('click', '.delete_product_btn', function (e) {
        e.preventDefault();

        var id = $(this).val();

        // alert(id); TESTING PURPOSES

        swal({
            title: "Are you sure?",
            text: "Once deleted, you will not be able to recover this product!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
          })
          .then((willDelete) => {
            if (willDelete) {
              $.ajax({
                method: "POST",
                url: "code.php",
                data: {
                    'product_id' : id,
                    'delete_product_btn' : true
                },
                success: function (response) {
                    if (response == 200) {
                        swal("Success!", "Product deleted Successfully!", "success");
                        $("#products_table").load(location.href + " #products_table")
                    } else if (response == 500) {
                        swal("Error!", "Something went wrong while deleting the Product!", "error");
                    }
                }
              });
            }
          });
        
    });

    $(document).on('click', '.delete_category_btn', function (e) {
        e.preventDefault();

        var id = $(this).val();

        // alert(id); TESTING PURPOSES

        swal({
            title: "Are you sure?",
            text: "Once deleted, you will not be able to recover this category!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
          })
          .then((willDelete) => {
            if (willDelete) {
              $.ajax({
                method: "POST",
                url: "code.php",
                data: {
                    'category_id' : id,
                    'delete_category_btn' : true
                },
                success: function (response) {
                    if (response == 200) {
                        swal("Success!", "Category deleted Successfully!", "success");
                        $("#categories_table").load(location.href + " #categories_table")
                    } else if (response == 500) {
                        swal("Error!", "Something went wrong while deleting the Category!", "error");
                    }
                }
              });
            }
          });
        
    });

});
