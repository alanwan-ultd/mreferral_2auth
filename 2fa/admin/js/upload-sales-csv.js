$(document).ready(function () {
	$('#uploadSalesCSVForm').on('submit', function (e) {
		e.preventDefault();

		if (!confirm("Warning: This action may update existing sales items. Are you sure you want to proceed?")) {
			return;
		}

		const formData = new FormData(this);

		$.ajax({
			type: "POST",
			url: 'ajax/upload_sales_csv.php',
			data: formData,
			dataType: 'json',
			contentType: false,
			processData: false,
			success: function (data) {
				if (data.success) {
					alert("CSV file uploaded and processed successfully.");
					location.reload();
				} else {
					alert("Error: " + data.message);
				}
			},
			error: function (jqXHR, textStatus, errorThrown) {
				console.error('AJAX Error:', textStatus, errorThrown);
				alert("An error occurred during upload. Please try again.");
			}
		});
	});
});