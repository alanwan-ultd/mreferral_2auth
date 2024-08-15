<?php
//support only 2 levels
/*
"titleSection_xxxx" => array(
	"title" => "[text]",
),

"[$name]" => array(
	"name" => "[display name in menu]",
	"link" => "[link in menu]",
	"icon" => "cil-xxxx",
	"items" => array(
		"ourTeam" => array(
			"name" => "[display name in menu]",
			"link" => "xxx_list.php",
			"icon" => "cil-xxx",
			"sort" => true,
			"create" => true,
		),
	),
),
*/
$CMSSection = array(
	"titleSection" => array(
		"title" => "Section",
	),
	// "submitApproval" => array(
	// 	"name" => "Wait For Approval", 
	// 	"link" => "submitApproval_list.php", 
	// 	"icon" => "icon-clipboard", 
	// 	"sort" => false, 
	// 	"create" => false, 
	// ), 
	"admin" => array(
		"name" => "Admin",
		"link" => "group",
		"icon" => "cil-spreadsheet",
		"items" => array(
			"admin" => array(
				"name" => "User",
				"link" => "admin_list.php",
				"icon" => "cil-user",
				"sort" => false,
				"create" => true,
			),
			"adminGroup" => array(
				"name" => "User Group",
				"link" => "adminGroup_list.php",
				"icon" => "cil-people",
				"sort" => false,
				"create" => false,
			),
		),
	),
	/*admin end*/
	/*"titleSection_DEMO" => array(
		"title" => "_DEMO_",
	),
	"_DEMO_" => array(
		"name" => "_DEMO_(name)",
		"link" => "group",
		"icon" => "icon-star-full",
		"items" => array(
			"_DEMO_CAT0" => array(
				"name" => "Category",
				"link" => "test1.html",
				"icon" => "",
				"sort" => true,
				"create" => true,
			),
		),
	),
	"_DEMO2_" => array(
		"name" => "_DEMO2_(name)",
		"link" => "test.html",
		"icon" => "icon-star-full",
	),
	"_DEMO3_" => array(
		"name" => "_DEMO3_(name)",
		"link" => "group",
		"icon" => "icon-star-full",
		"items" => array(
			"_DEMO_CAT" => array(
				"name" => "Category",
				"link" => "_DEMO_CAT_list.php",
				"icon" => "",
				"sort" => true,
				"create" => true,
			),
			"_DEMO3_GROUP" => array(
				"name" => "Category 2 (sub)",
				"link" => "group",
				"icon" => "icon-star-full",
				"items" => array(
					"_DEMO3_GROUP1" => array(
						"name" => "Category 2.1",
						"link" => "_DEMO_CAT2_list.php",
						"icon" => "icon-star-full",
						"sort" => true,
						"create" => true,
					),
					"_DEMO3_GROUP2" => array(
						"name" => "Category 2.2",
						"link" => "test4.html",
						"icon" => "",
						"sort" => true,
						"create" => true,
					),
				),
			),
			"_DEMO_DETAIL" => array(
				"name" => "Detail",
				"link" => "_DEMO_DETAIL_list.php",
				"icon" => "",
				"sort" => true,
				"create" => true,
			),
		),
	),*/
);

?>