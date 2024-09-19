<?php
$FILE_ROOT = '../';
$group = 'admin';
$name = 'uploadSalesCSV';

include_once('../inc/views/header.php');

?>

<script src="js/upload-sales-csv.js?v=<?php echo $version; ?>"></script>

<h2>Upload Sales CSV File</h2>
<form id="uploadSalesCSVForm" method="post" enctype="multipart/form-data">
	<input type="file" name="csvFile" accept=".csv" required>
	<br />
	<br />
	<input type="submit" class="btn btn-primary" value="Upload and Process">
</form>