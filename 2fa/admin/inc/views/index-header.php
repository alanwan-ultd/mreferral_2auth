<!DOCTYPE html>
<html lang="en">
<head>
<base href="./">
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
<meta name="description" content="Content Management System (CMS)">
<meta name="keyword" content="Bootstrap,Admin,Template,Open,Source,jQuery,CSS,HTML,RWD,Dashboard">
<title>Content Management System (CMS)</title>
<link rel="apple-touch-icon" sizes="114x114" href="assets/favicon/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="assets/favicon/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="assets/favicon/favicon-16x16.png">
<link rel="manifest" href="assets/favicon/site.webmanifest" crossorigin="use-credentials">
<link rel="mask-icon" href="assets/favicon/safari-pinned-tab.svg" color="#5bbad5">
<meta name="msapplication-TileColor" content="#da532c">
<meta name="theme-color" content="#ffffff">
<!-- Main styles for this application-->
<link href="css/style.css?v=<?php echo $version; ?>" rel="stylesheet">
<link href="vendors/@coreui/icons/css/free.min.css" rel="stylesheet">
<link href="lib/icomoon/style.css" rel="stylesheet">
<link href="lib/cropperjs/v1.5.7/cropper.min.css" rel="stylesheet">
<link href="css/ultd.css?v=<?php echo $version; ?>" rel="stylesheet">
</head>
<body class="c-app">
<div class="c-sidebar c-sidebar-dark c-sidebar-fixed c-sidebar-lg-show" id="sidebar">
	<ul class="c-sidebar-nav">
		<li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="main.php">
			<i class="c-sidebar-nav-icon cil-speedometer"></i>Dashboard</a></li>


<?php
foreach($sectionModelMenu AS $key=>$value){
	if(isset($value['title'])):
?>
		<li class="c-sidebar-nav-title"><?php echo $value['title']; ?></li>
<?php elseif(isset($value['sub'])): ?>
		<li class="c-sidebar-nav-dropdown">
			<a class="c-sidebar-nav-dropdown-toggle" href="#"><i class="c-sidebar-nav-icon <?php echo $value['icon']; ?>"></i><?php echo $value['name']; ?></a>
			<ul class="c-sidebar-nav-dropdown-items">
<?php foreach($value['sub'] AS $key2=>$value2){ ?>
				<li class="c-sidebar-nav-item">
					<a class="c-sidebar-nav-link" href="<?php echo $value2['link']; ?>"><i class="c-sidebar-nav-icon <?php echo $value2['icon']; ?>"></i><?php echo $value2['name']; ?></a>
				</li>
<?php } ?>
			</ul>
		</li>
<?php else: ?>
		<li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="<?php echo $value['link']; ?>">
			<i class="c-sidebar-nav-icon <?php echo $value['icon']; ?>"></i><?php echo $value['name']; ?></a></li>
<?php endif; ?>
<?php } ?>
	</ul>
	<button class="c-sidebar-minimizer c-class-toggler" type="button" data-target="_parent" data-class="c-sidebar-minimized"></button>
</div>

<div class="c-wrapper c-fixed-components">
	<header class="c-header c-header-light c-header-fixed c-header-with-subheader">
		<button class="c-header-toggler c-class-toggler d-lg-none mfe-auto" type="button" data-target="#sidebar" data-class="c-sidebar-show">
			<i class="c-icon c-icon-lg cil-menu"></i>
		</button>
		<!--button class="c-header-toggler c-class-toggler mfs-3 d-md-down-none" type="button" data-target="#sidebar" data-class="c-sidebar-lg-show" responsive="true">
			<i class="c-icon c-icon-lg cil-menu"></i>
		</button-->
		<!--ul class="c-header-nav d-md-down-none">
			<li class="c-header-nav-item px-3"><a class="c-header-nav-link" href="#">Dashboard</a></li>
			<li class="c-header-nav-item px-3"><a class="c-header-nav-link" href="#">Users</a></li>
			<li class="c-header-nav-item px-3"><a class="c-header-nav-link" href="#">Settings</a></li>
		</ul-->
		<ul class="c-header-nav ml-auto mr-4">
			<li class="c-header-nav-item dropdown">
				<a class="c-header-nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
					<i class="c-icon mr-2 cil-people"></i>Hi, <?php echo $_SESSION['login']; ?>
				</a>
				<div class="dropdown-menu dropdown-menu-right pt-0">
					<div class="dropdown-header bg-light py-2"><strong>Account</strong></div>
					<a class="dropdown-item c-xhr-link" href="admin_edit.php?id=<?php echo $_SESSION['id']; ?>">
						<i class="c-icon mr-2 cil-user"></i>My Profile</a>
					<a class="dropdown-item" href="login.php">
						<i class="c-icon mr-2 cil-account-logout"></i>Logout</a>
				</div>
			</li>
		</ul>
		<!--div class="c-subheader px-3">
			<ol class="breadcrumb border-0 m-0">
				<li class="breadcrumb-item">Home</li>
				<li class="breadcrumb-item"><a href="#">Admin</a></li>
				<li class="breadcrumb-item active">Dashboard</li>
			</ol>
		</div-->
	</header>
	<div class="c-body">
		<main class="c-main">
			<div class="container-fluid">
				<div id="ui-view">
