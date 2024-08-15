{*strip*}
	</div>
</div><!-- id:mainWrapper -->
<footer id="footerWrapper">
	<div id="footerContent">

	</div>
</footer><!-- id:footerWrapper -->

<script defer src="plugins/jquery/jquery-3.5.1.min.js"></script>
<script defer src="plugins/gsap/3.2.0/gsap.min.js"></script>
<!--script defer src="plugin/gsap/3.2.0/MorphSVGPlugin3.min.js"></script-->
<script defer src="plugins/viewport-checker/2.0.0/viewportChecker.umd.js"></script>
<script defer src="plugins/UA.js"></script>
<script defer src="plugins/swiper/6.3.2/js/swiper-bundle.min.js"></script>
<script defer src="plugins/jquery.scrollbar-gh-pages/jquery.scrollbar.js"></script>
<script defer src="plugins/select2/select2.min.js"></script>
<script defer src="plugins/signature_pad/signature_pad.min.js"></script>

<script defer src="{$MIN_FOLDER}js/util{$MIN_FILENAME}.js"></script>
<script defer src="{$MIN_FOLDER}js/script{$MIN_FILENAME}.js{#ASSET_VERSION#}"></script>

<noscript id="deferred-styles">
<link rel="stylesheet" href="plugins/icomoon/style.css" type="text/css" media="screen" onload="CSSLoad()" />
<link rel="stylesheet" href="plugins/swiper/6.3.2/css/swiper-bundle.min.css" onload="CSSLoad()">
<link rel="stylesheet" href="plugins/jquery.scrollbar-gh-pages/jquery.scrollbar.css" type="text/css" media="screen" onload="CSSLoad()" />
<link rel="stylesheet" href="plugins/select2/select2.min.css" type="text/css" media="screen" onload="CSSLoad()" />
<!--link rel="stylesheet" href="plugins/hamburger-menu/hamburgers.min.css" type="text/css" media="screen" onload="CSSLoad()" /-->

<link rel="stylesheet" href="css/style{$MIN_FILENAME}.css{#ASSET_VERSION#}" type="text/css" media="screen" onload="CSSLoad()" />
{$EXTRA_CSS}
{if $LANG eq 'tc'}<link rel="stylesheet" href="css/tc{$MIN_FILENAME}.css{#ASSET_VERSION#}" type="text/css" media="screen" onload="CSSLoad()" />{/if}
{if $LANG eq 'sc'}<link rel="stylesheet" href="css/sc{$MIN_FILENAME}.css{#ASSET_VERSION#}" type="text/css" media="screen" onload="CSSLoad()" />{/if}
</noscript>

{$EXTRA_JS}

<script>
var loadDeferredStyles = function() {
	var addStylesNode = document.getElementById("deferred-styles");
	var replacement = document.createElement("div");
	replacement.setAttribute("id", "deferred-styles-link");
	replacement.innerHTML = addStylesNode.textContent;
	document.body.appendChild(replacement)
	addStylesNode.parentElement.removeChild(addStylesNode);
};
var raf = window.requestAnimationFrame || window.mozRequestAnimationFrame ||
	window.webkitRequestAnimationFrame || window.msRequestAnimationFrame;
if (raf) raf(function() { window.setTimeout(loadDeferredStyles, 0); });
else window.addEventListener('load', loadDeferredStyles);
</script>

{include file='GA3.tpl'}

</body>
</html>
{*/strip*}