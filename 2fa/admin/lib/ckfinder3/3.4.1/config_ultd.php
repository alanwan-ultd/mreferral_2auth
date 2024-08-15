<?php
header('Content-Type: application/javascript');
?>
var config = {};
config.rememberLastFolder = true;
//config.startupPath = 'Images:/ourteam/';
config.startupFolderExpanded = true;
config.resizeImages = [ 'small', 'medium' ];
/*config.editImagePresets = [
    'clarity', 'concentrate', 'crossProcess', 'glowingSun', 'grungy', 'hazyDays', 'hemingway', 'herMajesty',
    'jarques', 'lomo', 'love', 'nostalgia', 'oldBoot', 'orangePeel', 'pinhole', 'sinCity', 'sunrise', 'vintage'
];*/
config.editImagePresets = [];
/*config.editImageAdjustments = [
    'brightness', 'clip', 'contrast', 'exposure', 'gamma', 'hue', 'noise', 'saturation', 'sepia',
    'sharpen', 'stackBlur', 'vibrance'
];*/
config.editImageAdjustments = [];
<?php
/*$section = $_GET['s'];

switch ($section) {

	case "Blog":
		$resourceType = 'Blog';
		$configId = 'myCKFinderBlog';
		break;

	case "Blog_default":
		$resourceType = 'Blog_default';
		$configId = 'myCKFinderBlog_default';
		break;
}*/
//echo "config.resourceType = '". $resourceType ."';";
//echo "config.id = '". $configId /


?>
CKFinder.define( config );
