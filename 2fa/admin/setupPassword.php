<?php

include_once(__DIR__ . '/inc/Setting.php');
$setting = new Setting(true);
include_once(__DIR__ . '/inc/Util.php');
$util = new Util();
include_once(__DIR__ . '/inc/function.php');
include_once(__DIR__ . '/inc/DB.php');
include_once(__DIR__ . '/inc/dbInit.php');

$token = $_GET['token'] ?? '';
$token = $util->purifyCheck($token);

// get user info
$rst = $db->select($setting->DB_PREFIX . 'adminuser', 'password="" AND password_reset_token=:token LIMIT 1', array(':token' => $token));

$headerExtra = <<<EOT
<style>
body{background:url('./assets/img/bg/3.jpg') no-repeat center center;background-size:cover;}
</style>
EOT;

include_once('inc/views/simple-header.php');
?>

<style>
	.error-message {
		display: none;
		margin-bottom: 1rem;
		color: red;
	}
</style>

<div class="col-md-8">
	<div class="card-group animate__animated<?php echo ($result === false) ? ' animate__shakeX' : ''; ?>">
		<div class="card p-4">
			<div class="card-body">
				<?php if (!empty($rst)): ?>
					<form method="post" id="setupPasswordForm" data-toggle="validator">
						<input type="hidden" name="token" value="<?php echo $token; ?>">
						<input type="hidden" name="username" value="<?php echo $rst[0]['login']; ?>">
						<h1>Hello <?php echo $rst[0]['name']; ?>, <br />Password Setup</h1>
						<p class="text-muted">
							Please set up your account password before your first login.
							<br />
							<br />
							(Password should be 8-20 characters in length and should include at least one upper case letter, one number, and one special character.)
						</p>
						<div class="input-group mb-3">
							<div class="input-group-prepend">
								<span class="input-group-text">
									<svg class="c-icon">
										<use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-lock-locked"></use>
									</svg>
								</span>
							</div>
							<input class="form-control" type="password" placeholder="Password" id="password" name="password" required autocomplete="off">
						</div>
						<div class="input-group mb-3">
							<div class="input-group-prepend">
								<span class="input-group-text">
									<svg class="c-icon">
										<use xlink:href="vendors/@coreui/icons/svg/free.svg#cil-lock-locked"></use>
									</svg>
								</span>
							</div>
							<input class="form-control" type="password" placeholder="Confirm Password" id="confirm_password" name="confirm_password" required autocomplete="off">
						</div>

						<div class="success-message"></div>
						<div class="error-message"></div>

						<div class="row">
							<div class="col-6">
								<button class="btn btn-primary px-4 btn-submit" type="submit">Submit</button>
							</div>
						</div>
					</form>
				<?php else: ?>
					<div>The link is invalid.</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>

<script src="lib/jquery/jquery-3.5.1.min.js"></script>

<script>
	$(document).ready(function() {
		$('#setupPasswordForm').on('submit', function(e) {
			e.preventDefault();

			$('.error-message').hide();

			const password = $('#password').val();
			const confirmPassword = $('#confirm_password').val();

			// Check if passwords match
			if (password !== confirmPassword) {
				$('.error-message').text("Password and Confirm Password do not match.").show();
				return;
			}

			// Check password format
			const passwordCheck = checkPasswordFormat(password);
			if (!passwordCheck.valid) {
				$('.error-message').html(passwordCheck.reason).show();
				return;
			}

			const formData = new FormData(this);

			$.ajax({
				type: "POST",
				url: 'ajax/setup_password.php',
				data: formData,
				processData: false, // Add this line
				contentType: false, // Add this line
				dataType: 'json',
				success: function(data) {
					if (data.success) {
						const countdownSeconds = 3; // Set the countdown time (in seconds)
						const countdownMessage = "Password setup successful. Redirecting in {seconds} seconds...";

						$('.btn-submit').hide();
						$('.success-message').show();
						countdown(countdownSeconds, function(seconds) {
							$('.success-message').text(countdownMessage.replace('{seconds}', seconds));
						}, function() {
							location.href = '/2fa/admin/login.php';
						});
					} else {
						$('.error-message').text(data.message).show();
					}
				},
				error: function(jqXHR, textStatus, errorThrown) {
					console.error('AJAX Error:', textStatus, errorThrown);
					alert("An error occurred during upload. Please try again.");
				}
			});
		});
	});

	function countdown(seconds, updateCallback, completeCallback) {
		updateCallback(seconds);

		if (seconds > 0) {
			setTimeout(function() {
				countdown(seconds - 1, updateCallback, completeCallback);
			}, 1000);
		} else {
			completeCallback();
		}
	}

	function checkPasswordFormat(password) {
		const uppercase = /[A-Z]/.test(password);
		const lowercase = /[a-z]/.test(password);
		const number = /[0-9]/.test(password);
		const specialChars = /[^A-Za-z0-9]/.test(password);
		const length = password.length >= 8 && password.length <= 20;

		if (!uppercase || !lowercase || !number || !specialChars || !length) {
			return {
				valid: false,
				reason: [
					!uppercase ? "Missing uppercase letter" : null,
					!lowercase ? "Missing lowercase letter" : null,
					!number ? "Missing number" : null,
					!specialChars ? "Missing special character" : null,
					!length ? "Password must be 8-20 characters long" : null
				].filter(Boolean).join("<br>")
			};
		}
		return {
			valid: true,
			reason: ""
		};
	}
</script>

<?php
include_once('inc/views/simple-footer.php');
?>