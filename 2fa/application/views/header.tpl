<!DOCTYPE html>{*strip*}
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="{#HTML_LANG#}" lang="{#HTML_LANG#}">
<head>
<base href="{$HTML_BASE}">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">

{foreach from=$LANG_ARRAY key=k item=v}{if $LANG_DEFAULT eq $k}
<link rel="alternate" href="{$HTML_BASE|cat:$CURRENT_LINK}" hreflang="{$v[0]}" />
{else}
<link rel="alternate" href="{$HTML_BASE|cat:$k|cat:'/'|cat:$CURRENT_LINK}" hreflang="{$v[0]}" />
{/if}{/foreach}
<link rel="alternate" href="{$HTML_BASE|cat:$CURRENT_LINK}" hreflang="x-default" />
<link rel="canonical" href="{$HTML_BASE|cat:$CURRENT_LINK}" />

<title>{if isset($HTML_TITLE)}{$HTML_TITLE}{else}{#HTML_TITLE#}{/if}</title>
<meta name="description" lang="en" content="{if isset($HTML_DESC)}{$HTML_DESC}{else}{#HTML_DESC#}{/if}" />
<meta name="keywords" content="{if isset($HTML_KEYWORDS)}{$HTML_KEYWORDS}{else}{#HTML_KEYWORDS#}{/if}" />
<link rel="image_src" href="{$HTML_IMG}{#ASSET_VERSION#}" />

<link rel="apple-touch-icon" sizes="180x180" href="images/favicon/apple-touch-icon.png{#ASSET_VERSION#}">
<link rel="icon" type="image/png" sizes="32x32" href="images/favicon/favicon-32x32.png{#ASSET_VERSION#}">
<link rel="icon" type="image/png" sizes="16x16" href="images/favicon/favicon-16x16.png{#ASSET_VERSION#}">
<link rel="manifest" href="images/favicon/site.webmanifest{#ASSET_VERSION#}" crossorigin="use-credentials">
<link rel="shortcut icon" href="images/favicon/favicon.ico{#ASSET_VERSION#}">
<meta name="msapplication-TileColor" content="#da532c">
<meta name="msapplication-config" content="images/favicon/browserconfig.xml{#ASSET_VERSION#}">
<meta name="theme-color" content="#ffffff">

<meta property="og:title" content="{if isset($HTML_TITLE)}{$HTML_TITLE}{else}{#HTML_TITLE#}{/if}" />
<meta property="og:description" content="{if isset($HTML_DESC)}{$HTML_DESC}{else}{#HTML_DESC#}{/if}" />
<meta property="og:type" content="website" />
<meta property="og:url" content="{$HTML_BASE|cat:$CURRENT_LINK}" id="ogurl" />
<meta property="og:image" content="{$HTML_IMG}{#ASSET_VERSION#}" />
<meta property="fb:app_id" content="0" />

<meta name="twitter:title" content="{if isset($HTML_TITLE)}{$HTML_TITLE}{else}{#HTML_TITLE#}{/if}">
<meta name="twitter:description" content="{if isset($HTML_DESC)}{$HTML_DESC}{else}{#HTML_DESC#}{/if}">
<meta name="twitter:image" content="{$HTML_IMG}{#ASSET_VERSION#}">
<meta name="twitter:card" content="summary_large_image">

<script>
"use strict";
/*!function () { setInterval(function () { debugger; }, 1000) }();*//*force not use in debug*/
var lang = '{$LANG}';
var lang_folder = "{$LANG_FOLDER}";
var baseURL = '{$HTML_BASE}';
var currentURL = '{$CURRENT_LINK}';
var currentSection = '{$URL_CURRENT}';
var isMobile = false;
var isPad = false;
var isiOS = false;
var CSSLoaded = 0;

function CSSLoad(){
	CSSLoaded++;
	if(document.querySelectorAll('#deferred-styles-link link').length == CSSLoaded){
		setTimeout(function(){
			document.querySelector('#preloader').setAttribute('data-css', 'done')
		}, 1000);
	}
}
</script>

<style>
#preloader { position:fixed;top:0;left:0;right:0;bottom:0;background-color:rgba(255,255,255,1);z-index:99999; }
#preloader .preloaderImg{ position:absolute;left:50%; top:50%;margin:-27.5px 0 0 -27px; width: 40px;}
</style>

{include file='GA.tpl'}

</head>
<body>

{include file='GA2.tpl'}

<div id="preloader"><img class="preloaderImg" src="images/ajax-loader.gif" alt=""></div>

<header id="headerWrapper">
	<div id="headerContent">
		<nav>
			<!-- main navigation here -->
		</nav>
	</div>
</header>

<div id="mainWrapper">
	<div id="mainContent">
{*/strip*}