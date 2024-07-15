<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
$(document).ready(function() {
   
    let originalAddress = $('#address').text();
    let originalWard = $('#ward').text();
    let originalDistrict = $('#district').text();
    let originalCity = $('#city').text();

 
    $('#editBtn').click(function() {
        $('#userInfo').hide();
        $('#editForm').show();
        $('#editAddress').val($('#address').text());
        $('#editWard').val($('#ward').text());
        $('#editDistrict').val($('#district').text());
        $('#editCity').val($('#city').text());
    });

 
    $('#cancelBtn').click(function() {
        $('#editForm').hide();
        $('#userInfo').show();
        $('#address').text(originalAddress);
        $('#ward').text(originalWard);
        $('#district').text(originalDistrict);
        $('#city').text(originalCity);
    });

    $('#saveBtn').click(function() {
        let newAddress = $('#editAddress').val();
        let newWard = $('#editWard').val();
        let newDistrict = $('#editDistrict').val();
        let newCity = $('#editCity').val();

        console.log('Sending AJAX request...');
        $.ajax({
            url: 'update_address.php',
            method: 'POST',
            data: {
                address: newAddress,
                ward: newWard,
                district: newDistrict,
                city: newCity
            },
            success: function(response) {
                console.log('AJAX response:', response);
                if(response === 'success') {
                    $('#address').text(newAddress);
                    $('#ward').text(newWard);
                    $('#district').text(newDistrict);
                    $('#city').text(newCity);

                    originalAddress = newAddress;
                    originalWard = newWard;
                    originalDistrict = newDistrict;
                    originalCity = newCity;
                    
                    $('#editForm').hide();
                    $('#userInfo').show();
                    alert('Address updated!');
                } else {
                    alert('There are some issues when updating address.');
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('AJAX error:', textStatus, errorThrown);
                alert('Server connecting error.');
            }
        });
    });
});
