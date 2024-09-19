<?php
$FILE_ROOT = '../';
$group = 'admin';
$name = 'uploadCommissionCSV';

include_once('../inc/views/header.php');

?>

<script src="js/upload-commission-csv.js?v=<?php echo $version; ?>"></script>

<h2>Upload Commission CSV File</h2>
<form id="uploadCommissionCSVForm" method="post" enctype="multipart/form-data">
	<input type="hidden" name="username" value="<?php echo $_SESSION['login']; ?>" required>
	<input type="file" name="csvFile" accept=".csv" required>
	<br />
	<br />
	<input type="submit" class="btn btn-primary" value="Upload and Process">
</form>