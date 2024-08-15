/**
*
* util.js
*
* Create Date: 20190807
* Update Date: 20201006
*
* Authors:
* Tony Ho
*
* Copyright 2020, UNLIMITED Ltd
* http://www.ultd.com.hk/
*/

class Util{
	constructor(){
		
	}

	cookieDelete(){
		var cookies = document.cookie.split(";");

		for (var i = 0; i < cookies.length; i++) {
			var cookie = cookies[i];
			var eqPos = cookie.indexOf("=");
			var name = eqPos > -1 ? cookie.substr(0, eqPos) : cookie;
			document.cookie = name + "=;expires=Thu, 01 Jan 1970 00:00:00 GMT";
		}
	}
	
	cookieGet(c_name){
		var c_value = document.cookie;
		var c_start = c_value.indexOf(" " + c_name + "=");
		if (c_start == -1){
			c_start = c_value.indexOf(c_name + "=");
		}
		if (c_start == -1){
			c_value = null;
		}else{
			c_start = c_value.indexOf("=", c_start) + 1;
			var c_end = c_value.indexOf(";", c_start);
			if (c_end == -1){
				c_end = c_value.length;
			}
			c_value = unescape(c_value.substring(c_start,c_end));
		}
		return c_value;
	}
	
	cookieSet(c_name, value, exdays){
		if(typeof exdays == 'undefined') exdays = 1;
		var exdate = new Date();
		exdate.setTime(exdate.getTime() + (exdays*24*60*60*1000) );
		var c_value = escape(value) + "; path=/; expires="+exdate.toUTCString();
		document.cookie = c_name + "=" + c_value;
	}
	
	dateConvert(d){
		// Converts the date in d to a date-object. The input can be:
		//   a date object: returned without modification
		//  an array      : Interpreted as [year,month,day]. NOTE: month is 0-11.
		//   a number     : Interpreted as number of milliseconds
		//                  since 1 Jan 1970 (a timestamp) 
		//   a string     : Any format supported by the javascript engine, like
		//                  "YYYY/MM/DD", "MM/DD/YYYY", "Jan 31 2009" etc.
		//  an object     : Interpreted as an object with year, month and date
		//                  attributes.  **NOTE** month is 0-11.
		return (
			d.constructor === Date ? d :
			d.constructor === Array ? new Date(d[0],d[1],d[2]) :
			d.constructor === Number ? new Date(d) :
			d.constructor === String ? new Date(d) :
			typeof d === "object" ? new Date(d.year,d.month,d.date) :
			NaN
		);
	}
	
	dateCompare(a, b){
		// Compare two dates (could be of any type supported by the convert
		// function above) and returns:
		//  -1 : if a < b
		//   0 : if a = b
		//   1 : if a > b
		// NaN : if a or b is an illegal date
		// NOTE: The code inside isFinite does an assignment (=).
		return (
			isFinite(a=dateConvert(a).valueOf()) &&
			isFinite(b=dateConvert(b).valueOf()) ?
			(a>b)-(a<b) :
			NaN
		);
	}
	
	dateInRange(a, b){
		// Returns a boolean or NaN:
		// true  : if d is between start and end (inclusive)
		// false : if d is before start or after end
		// NaN   : if one or more of the dates is illegal.
		// NOTE: The code inside isFinite does an assignment (=).
		return (
			isFinite(d=this.convert(d).valueOf()) &&
			isFinite(start=this.convert(start).valueOf()) &&
			isFinite(end=this.convert(end).valueOf()) ?
			start <= d && d <= end :
			NaN
		);
	}
	
	gaLink(section, value, action, category){
		if(typeof gtag != 'function') return;
		action = (typeof action !== "undefined")?action:'click';
		category = (typeof category !== "undefined")?category:'link';
		if(typeof value !== "undefined"){
			gtag('event', action, {
				'event_category': category,
				'event_label': section,
				'transport_type': 'beacon',
				'value': value, 
				'event_callback': function(){
					//console.log("Event received");
				}
			});
		}else{
			gtag('event', action, {
				'event_category': category,
				'event_label': section, 
				'transport_type': 'beacon',
				'event_callback': function(){
					//console.log("Event received");
				}
			});
		}
		//console.log('gaLink: ' + section + ' ' + value);
	}
	
	getUrlVars() {
		/*
		useage
		var first = getUrlVars()["id"];
		*/
		var vars = {};
		var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m, key, value) {
			vars[key] = value;
		});
		return vars;
	}
	
	getYouTubeIdFromURL(url){
		//var regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|\&v=)([^#\&\?]*).*/;
		var regExp = /^.*(youtu.be\/|v\/|embed\/|watch\?|youtube.com\/user\/[^#]*#([^\/]*?\/)*)\??v?=?([^#\&\?]*).*/;
		var m = url.match(regExp);
		if (m && m[3].length == 11){
			return m[3];
		}else{
			return false;
		}
	}
	
	isEmailContainsIllegalChars(email) {
		var illegalChars= /[\(\)\<\>\,\;\:\\\"\[\]]/;
		return email.match(illegalChars);
	}
	
	isEmpty(str){
		if (str == null || str == "" || (/^\s*$/).test(str)){
			return true;
		}
		return false;
	}
	
	isHKID(hkid){
		return (/([a-zA-Z0-9]{1})(\d{3})/).test(hkid);
	}
	
	isMobileDevice(str){
		var output = false;
		var _isMobile = {
			Android: function() {
				return navigator.userAgent.match(/Android/i);
			},
			BlackBerry: function() {
				return navigator.userAgent.match(/BlackBerry/i);
			},
			iOS: function() {
				return navigator.userAgent.match(/iPhone|iPad|iPod/i);
			},
			Opera: function() {
				return navigator.userAgent.match(/Opera Mini/i);
			},
			Windows: function() {
				return navigator.userAgent.match(/IEMobile|Windows Phone|ZuneWP7/i);
			},
			any: function() {
				return (_isMobile.Android() || _isMobile.BlackBerry() || _isMobile.iOS() || _isMobile.Opera() || _isMobile.Windows());
			}
		};
		switch(str){
			case 'Android': output = _isMobile.Android(); break;
			case 'BlackBerry': output = _isMobile.BlackBerry(); break;
			case 'iOS': output = _isMobile.iOS(); break;
			case 'Opera': output = _isMobile.Opera(); break;
			case 'Windows': output = _isMobile.Windows(); break;
			default: output = _isMobile.any(); break;
		}
		return output;
	}
	
	isNumber(num) {
		return !isNaN(parseFloat(num)) && isFinite(num);
	}
	
	isNumericKey(evt) {//onkeydown in input field e.g. onkeydown="return isNumericKey(event)"
		var isIE = (navigator.appName == "Microsoft Internet Explorer");
		var c = isIE ? evt.keyCode : evt.which;
		return ((c>=48 && c<=57) || (c>=96 && c<=105) || c==8 || c==9 || c==13 || c==17 || c==35 || c==36 || c==37 || c==38 || c==39 || c==40 || c==46);
	}
	
	isTextOnly(s){
		var filter=/^[0-9a-zA-Z_\-() ]+$/;
		return filter.test(s);
	}
	
	isValidEmail(email, isSimple){
		isSimple = typeof isSimple !== 'undefined'?isSimple:true;
		if(isSimple){  //match php isValidEmail
			var pattern = new RegExp(/^([A-Za-z0-9_\-\.\'])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,6})$/);
			return pattern.test(email);
		}else{
			var pattern = new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);
			return pattern.test(email);
		}
	}
	
	isValidFilename(s){
		return (s.length<=255 && !(s.match(/[\\\/?\*:<>\|'\"]/g)));
	}
	
	isValidPhone(phone){
		var pattern = new RegExp(/^[0-9]{8}$/);
		return pattern.test(phone);
	}
	
	isValidPhoneNational(phone){
		var pattern = new RegExp(/^[0-9\-\+() ]+$/);
		return filter.test(phone);
	}
	
	jsonTostring(val){
		var temp = '';
		$.each (val,function (index,value){
			if (typeof value == 'object'){
				value = jsonTostring(value);
			}
			temp += (temp != '') ? ',' + value : value;
		});
		
		return temp;
	}
	
	moneyFormat(num, n, x){  //moneyFormat(num)->1,234, 123456.789.moneyFormat(num, 2, 4)->12,3456.79
		var re = '\\d(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\.' : '$') + ')';
		return num.toFixed(Math.max(0, ~~n)).replace(new RegExp(re, 'g'), '$&,');
	}
	
	randomArray(array) {
		for (var i = array.length - 1; i > 0; i--) {
			var j = Math.floor(Math.random() * (i + 1));
			var temp = array[i];
			array[i] = array[j];
			array[j] = temp;
		}
		return array;
	}
	
	randomNumber(low, high){
		return Math.floor(Math.random() * (1+high-low)) + low;
	}
	
	randomString(length){
		if(typeof length == 'undefined') length = 5;
		var str = '';
		var possible = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
		for(var i=0; i<length; i++){
			str += possible.charAt(Math.floor(Math.random() * possible.length));
		}
	
		return str;
	}
	
	strPad(str, padString, length){
		while (str.length < length){
			str = padString + str;
		}
		return str;
	}
}

//JavaScript.load('xxxx', function(){});
var JavaScript = {
	load: function(src, callback) {
		var script = document.createElement('script'), loaded;
		script.setAttribute('src', src);
		if (callback) {
			script.onreadystatechange = script.onload = function() {
				if (!loaded) {
					callback();
				}
				loaded = true;
			};
		}
		document.getElementsByTagName('head')[0].appendChild(script);
	}
};

