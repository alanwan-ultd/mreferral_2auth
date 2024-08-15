$(document).ready(function() {
	// 2fa generate code
	$('.btn-google-2fa-gen').on('click', function() {
		console.log('generate code');

		$.ajax({
            url: 'ajax/generate_2fa.php', 
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.secret && response.qr_code_url) {
                    // Optionally, display the QR code on the page
                    $('.google-2fa-group .google-2fa-secret').text(response.secret);
                    $('.google-2fa-group img').attr('src', response.qr_code_url);

					$('#2fa_secret').val(response.secret);
					$('#2fa_qrcode').val(response.qr_code_url);
                } else {
                    console.error('Error generating 2FA code.');
                }
            },
            error: function() {
                console.error('Failed to generate 2FA code.');
            }
        });
	});
})