<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../lib/PHPMailer-6.1.6/Exception.php';
require_once __DIR__ . '/../lib/PHPMailer-6.1.6/PHPMailer.php';
require_once __DIR__ . '/../lib/PHPMailer-6.1.6/SMTP.php';

require_once __DIR__ . '/../inc/Setting.php';
$setting = new Setting(true);
require_once __DIR__ . '/../inc/DB.php';
require_once __DIR__ . '/../inc/dbInit.php';


if (!(isset($_GET['key']) && $_GET['key'] === $setting->CRONJOB_KEY)) {
	$data['message'] = 'The key is invalid';
	echo json_encode($data);
	exit;
}

// Construct the base URL using $_SERVER values
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
$host = $_SERVER['HTTP_HOST'];
$baseUrl = "{$protocol}://{$host}";

// Construct the QR code URL
$setupPasswordUrl = $baseUrl . '/2fa/admin/setupPassword.php';
$loginUrl = $baseUrl . '/2fa/admin/';


// Fetch admin users from the database
$adminUsers = $db->select($setting->DB_PREFIX . 'adminuser', 'email != "" AND 2fa_receive_email = "N" AND status = "A" AND deleted = "N" LIMIT 1', array(), 'id, login, email, name, password_reset_token, 2fa_qrcode');

if ($adminUsers) {
	$user = $adminUsers[0];

	if (!empty($user['email']) && !empty($user['2fa_qrcode'])) {
		// Set email format to HTML
		$sendEmailSetupPassword = sendEmailSetupPassword($user);
		$sendEmailQRCode = sendEmailQRCode($user);

		if ($sendEmailSetupPassword && $sendEmailQRCode) {
			// Update the user's 2fa_receive_email status to 'Y'
			$data['2fa_receive_email'] = 'Y';

			$result = $db->update($setting->DB_PREFIX . 'adminuser', $data, "id = :id", array(':id' => $user['id']));

			if ($result) {
				echo "Updated 2fa_receive_email status for user {$user['id']} <br />";
			} else {
				echo "Failed to update 2fa_receive_email status for user {$user['id']} <br />";
			}
		} else {
			echo "Failed to send email to {$user['email']} <br />";
		}
	}
} else {
	echo "No active admin users found in the database.\n";
}

function sendEmailSetupPassword($user)
{
	global $setupPasswordUrl;
	// Prepare email content
	$subject = "Set Up Your Mreferral Account Password";
	$body = "
<html>
<body>
<p>Dear {$user['name']},</p>
<p>To complete your account setup, please set your password by clicking the button below:</p>
<p><a href='{$setupPasswordUrl}?token={$user['password_reset_token']}'>Setup Password</a></p>
</body>
</html>
";

	return sendEmail($subject, $body, $user);
}

function sendEmailQRCode($user)
{
	global $loginUrl;
	// Prepare email content
	$subject = "Set Up Two-Factor Authentication (2FA) for Your Mreferral Account";
	$body = "
<html>
<body>
<p>Dear {$user['name']},</p>
<p>
Here is your login info: <br /><br />
Login: <b>{$user['login']}</b> <br />
Password: <b>[Your password was created from a different email]</b><br />
</p>
<hr>
<p>Here is your 2FA QR code:</p>
<img src='{$user['2fa_qrcode']}' alt='2FA QR Code' style='width:200px; height:200px;'>
<p>Please scan this QR code with your authenticator app to set up your 2FA.</p>
<p>You can log in to your account at: <a href='{$loginUrl}'>{$loginUrl}</a></p>
</body>
</html>
";

	return  sendEmail($subject, $body, $user);
}

function sendEmail($subject, $body, $user)
{
	global $setting, $db;

	// Send email using PHPMailer
	$mail = new PHPMailer(true);
	try {
		$mail->isHTML(true);
		$mail->isSMTP();
		$mail->Host = $setting->MAIL_HOST;
		$mail->SMTPAuth = $setting->MAIL_SMTP_AUTH;
		$mail->Username = $setting->MAIL_SMTP_USERNAME;
		$mail->Password = $setting->MAIL_SMTP_PWD;
		$mail->SMTPSecure = $setting->MAIL_SMTP_SECURE;
		$mail->Port = $setting->MAIL_PORT;

		$mail->setFrom($setting->MAIL_CONTACT_FROM['email'], $setting->MAIL_CONTACT_FROM['name']);
		$mail->addAddress($user['email'], $user['name']);
		$mail->Subject = $subject;
		$mail->Body = $body;

		$mail->send();

		return true;
	} catch (Exception $e) {
		return false;
	}
}
