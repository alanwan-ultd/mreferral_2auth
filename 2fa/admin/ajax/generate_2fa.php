<?php
require_once __DIR__ . '/../inc/Setting.php';
require_once __DIR__ . '/../vendor/autoload.php';

$setting = new Setting;

use Sonata\GoogleAuthenticator\GoogleAuthenticator;
use Sonata\GoogleAuthenticator\GoogleQrUrl;

$g = new GoogleAuthenticator();
$secret = $g->generateSecret();
$qrCodeUrl = GoogleQrUrl::generate($setting->GOOGLE_2FA_SITE_NAME, $secret, $setting->GOOGLE_2FA_SITE_DOMAIN);

echo json_encode(['secret' => $secret, 'qr_code_url' => $qrCodeUrl]);