/*global variables*/
var $preloader, common, nav, resizeTimeoutID;
var wh, ww;
/*global variables eol*/

document.addEventListener("DOMContentLoaded", function () {
	$preloader = $('#preloader');
	preloader = new Preloader();
	common = new Common();
	nav = new Nav();
});

$(window).on('load', function(){
	setWWH();
	if(!UA.isPC){
		
	}
	$preloader.attr('data-js', 'done');
});

$(window).on('resize', function(){
	setWWH();
	
});

$(window).scroll(function(e){
	
});

function back2Bottom(section = ''){
	$('html, body').animate({scrollTop:wh}, 500);
}

function back2Top(){
	$('html, body').animate({scrollTop:0}, 500);
}

function setWWH(){
	wh = $preloader.outerHeight();
	ww = $preloader.outerWidth();
}

/*demo swiper
var swiper = new Swiper('.swiper-container', {   
   // Default parameters   
   slidesPerView: 4,   
   spaceBetween: 40,   
   // Responsive breakpoints   
   breakpoints: {  
   
	  // when window width is <= 320px     
	  320: {       
		 slidesPerView: 1,
		 spaceBetween: 10     
	  },     
	  // when window width is <= 480px     
	  480: {       
		 slidesPerView: 2,       
		 spaceBetween: 20     
	  },   
  
	  // when window width is <= 640px     
	  640: {       
		 slidesPerView: 3,       
		 spaceBetween: 30     
	  } 
  
   } 
});

// breakpoint where swiper will be destroyed
// and switches to a dual-column layout
const breakpoint = window.matchMedia( '(min-width:31.25em)' );
// keep track of swiper instances to destroy later
let mySwiper;
//////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////
const breakpointChecker = function() {
   // if larger viewport and multi-row layout needed
   if ( breakpoint.matches === true ) {
	  // clean up old instances and inline styles when available
	  if ( mySwiper !== undefined ) mySwiper.destroy( true, true );
	  // or/and do nothing
	  return;
   // else if a small viewport and single column layout needed
   } else if ( breakpoint.matches === false ) {
	  // fire small viewport version of swiper
	  return enableSwiper();
   }
};

*/

class Preloader{
	constructor(){
		this.targetNode = document.getElementById('preloader');
		this.config = { attributes: true, childList: true, subtree: true };
		const observer = new MutationObserver(this.callback);
		observer.observe(this.targetNode, this.config);
		this.preloadCallback = function(){
			//console.log('preloadCallback');
			setTimeout(function(){/*wait 1 second for defer load css and js*/
				$preloader.attr('data-status', 'done');
				if(typeof pageCallBack != 'undefined'){
					pageCallBack(); /*functin add in specific page*/
				}else{
					$preloader.hide();
				}
			}, 1000);
		}
	}
	callback(mutationsList, observer){
		for(let mutation of mutationsList) {
			/*if (mutation.type === 'childList') {
				console.log('A child node has been added or removed.');
			}
			else if (mutation.type === 'attributes' && mutation.attributeName == 'data-status') {*/
			if (mutation.type === 'attributes' && $preloader.attr('data-css') == 'done' && $preloader.attr('data-js') == 'done'
				&& (mutation.attributeName == 'data-css' || mutation.attributeName == 'data-js')
			) {
				/*console.log('The ' + mutation.attributeName + ' attribute was modified.');*/
				preloader.preloadCallback();
			}
		}
	}
}

class Nav{
	constructor(){
		
	}
	init(){

	}
}

class Common{
	constructor(){

	}
	init(){

	}
}
