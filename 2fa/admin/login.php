<?php
$FILE_ROOT = '';
include_once('inc/views/header.php');
session_unset();
session_destroy();
ini_set('session.gc_maxlifetime', SESSION_TIMEOUT_SECONDS);
session_start();

$loginBg = $util->randArray($util->getFolderFiles($FILE_ROOT.'assets/img/bg/'), 1);

$needIncludeHeader = false;  //used in models/admin.php
include_once('models/admin.php');
$adminModel = new Admin();
$FILE_ROOT = '';  //re-define because change in admin model;
$login = $util->purifyCheck($util->returnData('login', 'post'));
$password = $util->purifyCheck($util->returnData('password', 'post'));
if($login != '' && $password != ''){
	$result = $adminModel->login($login, $password);//var_dump($result);exit;
	if($result){
		header('Location: ./'); exit();
	}
}else{
    $result = '';
}

$headerExtra = <<<EOT
<style>
body{background:url('{$FILE_ROOT}assets/img/bg/{$loginBg}') no-repeat center center;background-size:cover;}
label{font-size:0;line-height:0;}
</style>
EOT;

include_once('inc/views/simple-header.php');
?>

<div class="col-md-8">
	<div class="card-group animate__animated<?php echo ($result === false)?' animate__shakeX':''; ?>">
		<div class="card p-4">
			<div class="card-body"><form action="" method="post" id="myForm" class="" data-toggle="validator">
				<h1>2FA Portal<br>Login</h1>
				<p class="text-muted">Sign In to your account</p>
				<div class="input-group mb-3">
					<div class="input-group-prepend"><span class="input-group-text">
						<svg class="c-icon">
							<use xlink:href="lib/@coreui/icons/svg/free.svg#cil-user"></use>
						</svg></span></div>
					<label for="login">login</label><input class="form-control" type="text" placeholder="Username" id="login" name="login" required>
				</div>
				<div class="input-group mb-4">
					<div class="input-group-prepend"><span class="input-group-text">
						<svg class="c-icon">
							<use xlink:href="lib/@coreui/icons/svg/free.svg#cil-lock-locked"></use>
						</svg></span></div>
					<label for="password">password</label><input class="form-control" type="password" placeholder="Password" id="password" name="password" required>
				</div>
				<div class="row">
					<div class="col-6">
						<button class="btn btn-primary px-4" type="submit">Login</button>
					</div>
					<!--div class="col-6 text-right">
						<button class="btn btn-link px-0" type="button">Forgot password?</button>
					</div-->
				</div>
			</form></div>
		</div>
	</div>
</div>

<?php
$footerExtra = <<<EOT
<link rel="stylesheet" href="css/animate.min.css">
<link rel="stylesheet" href="lib/hyperform-0.12.0/css/hyperform.css">
<script src="lib/hyperform-0.12.0/js/hyperform.min.js"></script>

<style>
/* overwrite hyperform */
.hf-invalid + .hf-warning, :invalid + .hf-warning{
	bottom: 0;z-index:10;
	-moz-transform: translateY(100%);
	-o-transform: translateY(100%);
	-ms-transform: translateY(100%);
	-webkit-transform: translateY(100%);
	transform: translateY(100%);
}
.animated{
	-webkit-animation-duration:0.7s;
	-moz-animation-duration:0.7s;
	-ms-animation-duration:0.7s;
	-o-animation-duration:0.7s;
	animation-duration:0.7s;
}
</style>

<script>
document.onreadystatechange = function (){
	//do nothing
};

window.onload = (event) => {
	hyperform(window);
	document.getElementById('myForm').addEventListener('submit', function(event) {
		/* do not submit the form, because we'll do that later */
		event.preventDefault();
		event.stopPropagation();
		document.forms['myForm'].submit();
	});
};

// clear cashrebate filter cookie when login
eraseCookie('cb_modify_fm');
eraseCookie('cb_modify_to');
eraseCookie('cb_type');
eraseCookie('cb_status');

function eraseCookie(name) {
    document.cookie = name + '=; path=/; expires=Thu, 01 Jan 1970 00:00:00 GMT"'
}
</script>
EOT;

include_once('inc/views/simple-footer.php');
?>
