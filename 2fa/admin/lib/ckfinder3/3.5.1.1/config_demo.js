/*
Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://cksource.com/ckfinder/license
*/

/*CKFinder.customConfig = function( config )
{
	// Define changes to default configuration here.
	// For the list of available options, check:
	// http://docs.cksource.com/ckfinder_2.x_api/symbols/CKFinder.config.html

	// Sample configuration options:
	// config.uiColor = '#BDE31E';
	config.language = 'en';
	config.removePlugins = 'basket';
    config.disableHelpButton = true;
    config.gallery_autoLoad = true;  // Disable auto-loading of Colorbox to show images.
    
    //config.resourceType = 'Images';
    //config.startupPath = 'Images:/news/';
    config.resourceType = 'News';  //edit in config.php
    config.rememberLastFolder = true;
    config.startupFolderExpanded = true;
};*/


/*
 Copyright (c) 2007-2018, CKSource - Frederico Knabben. All rights reserved.
 For licensing, see LICENSE.html or https://ckeditor.com/sales/license/ckfinder
 */

var config = {};

// Set your configuration options below.

// Examples:
// config.language = 'pl';
// config.skin = 'jquery-mobile';
config.resourceType = 'Ourteam';  //edit in config.php
config.id = 'myCKFinderOurteam';
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

config.w = 960;
config.h = 1015;

CKFinder.define( config );