/*
 SelectNav.js (v. 0.1)
 Converts your <ul>/<ol> navigation into a dropdown list for small screens
 https://github.com/lukaszfiszer/selectnav.js
*/
window.selectnav=function(){return function(p,q){var a,h=function(b){var c;b||(b=window.event);b.target?c=b.target:b.srcElement&&(c=b.srcElement);3===c.nodeType&&(c=c.parentNode);c.value&&(window.location.href=c.value)},k=function(b){b=b.nodeName.toLowerCase();return"ul"===b||"ol"===b},l=function(b){for(var c=1;document.getElementById("selectnav"+c);c++);return b?"selectnav"+c:"selectnav"+(c-1)},n=function(b){g++;var c=b.children.length,a="",d="",f=g-1;if(c){if(f){for(;f--;)d+=r;d+=" "}for(f=0;f<
c;f++){var e=b.children[f].children[0];if("undefined"!==typeof e){var h=e.innerText||e.textContent,i="";j&&(i=-1!==e.className.search(j)||-1!==e.parentElement.className.search(j)?m:"");s&&!i&&(i=e.href===document.URL?m:"");a+='<option value="'+e.href+'" '+i+">"+d+h+"</option>";t&&(e=b.children[f].children[1])&&k(e)&&(a+=n(e))}}1===g&&o&&(a='<option value="">'+o+"</option>"+a);1===g&&(a='<select class="selectnav" id="'+l(!0)+'">'+a+"</select>");g--;return a}};if((a=document.getElementById(p))&&k(a)){document.documentElement.className+=
" js";var d=q||{},j=d.activeclass||"active",s="boolean"===typeof d.autoselect?d.autoselect:!0,t="boolean"===typeof d.nested?d.nested:!0,r=d.indent||"\u2192",o=d.label||"- Navigation -",g=0,m=" selected ";a.insertAdjacentHTML("afterend",n(a));a=document.getElementById(l());a.addEventListener&&a.addEventListener("change",h);a.attachEvent&&a.attachEvent("onchange",h)}}}();

jQuery(document).ready(function($){

jQuery(".jp-audio").css("opacity",1);

jQuery('.icon-btn').tooltip();
jQuery('.event-performers a').tooltip();

jQuery("#banner .flexslider ul.slides li") .each(function(index, el) {
  var a = jQuery(this) .find('img').attr('src');
  jQuery(this) .find('img').css("opacity",0)
  jQuery(this) .css({
    background:"url("+a+") no-repeat center top"
  })
});
	
	selectnav('menus', {
	  label: 'Menu',
	  nested: true,
	  indent: '-'
	});  
	  
    jQuery('audio,video').mediaelementplayer();
	jQuery("#stickyarea").hide();
	selectnav('menus', {
	  label: 'Menu',
	  nested: true,
	  indent: '-'
	});
	  
jQuery(window).resize(function(event) {
  /* Act on the event */
 
});  
jQuery(window).load(function() {
  jQuery(".loader") .remove();
  jQuery("#main").css("opacity",1);
    /* Act on the event */
   jQuery(".mejs-time-rail") .each(function(index, el) {
    var a = jQuery(this).width();
    jQuery(this).css({"width":a-2});
  });
});


	//jQuery('.tagcloud a').addClass("colrhover");

jQuery('p').each(function() {
    var $this = $(this);
    if($this.html().replace(/\s|&nbsp;/g, '').length == 0)
        $this.remove();
});

});

jQuery( document ).ready(function() {
    jQuery('.testimonial-shortcode .testimonial-v1:nth-child(3)').addClass("listitem3");
});
function cs_menu_sticky(){
	// jQuery(".main-menu").scrollToFixed();
}

function show_map(id) {
	jQuery("div.post-"+id).toggleClass("show-map");

}

/*var $container = jQuery('#containergallery');
  $container.isotope({
    itemSelector: 'figure',
 layoutMode: 'masonryHorizontal',
    masonryHorizontal: {
        rowHeight: 8
    },
    resizesContainer: true


});*/

//Jquery Inview Plugin
(function(d){var p={},e,a,h=document,i=window,f=h.documentElement,j=d.expando;d.event.special.inview={add:function(a){p[a.guid+"-"+this[j]]={data:a,$element:d(this)}},remove:function(a){try{delete p[a.guid+"-"+this[j]]}catch(d){}}};d(i).bind("scroll resize",function(){e=a=null});!f.addEventListener&&f.attachEvent&&f.attachEvent("onfocusin",function(){a=null});setInterval(function(){var k=d(),j,n=0;d.each(p,function(a,b){var c=b.data.selector,d=b.$element;k=k.add(c?d.find(c):d)});if(j=k.length){var b;
if(!(b=e)){var g={height:i.innerHeight,width:i.innerWidth};if(!g.height&&((b=h.compatMode)||!d.support.boxModel))b="CSS1Compat"===b?f:h.body,g={height:b.clientHeight,width:b.clientWidth};b=g}e=b;for(a=a||{top:i.pageYOffset||f.scrollTop||h.body.scrollTop,left:i.pageXOffset||f.scrollLeft||h.body.scrollLeft};n<j;n++)if(d.contains(f,k[n])){b=d(k[n]);var l=b.height(),m=b.width(),c=b.offset(),g=b.data("inview");if(!a||!e)break;c.top+l>a.top&&c.top<a.top+e.height&&c.left+m>a.left&&c.left<a.left+e.width?
(m=a.left>c.left?"right":a.left+e.width<c.left+m?"left":"both",l=a.top>c.top?"bottom":a.top+e.height<c.top+l?"top":"both",c=m+"-"+l,(!g||g!==c)&&b.data("inview",c).trigger("inview",[!0,m,l])):g&&b.data("inview",!1).trigger("inview",[!1])}}},250)})(jQuery);
//Jquery Inview Plugin

jQuery(document).ready(function($){
	//jQuery('audio,video').mediaelementplayer();
jQuery('#back-top').click(function(event) {
    jQuery('html, body').animate({scrollTop: 0}, 1000);
    return false;
})

// NiceScroll Javascript
jQuery("html").niceScroll({styler:"fb",cursorcolor:"#000", horizrailenabled:false, cursorwidth:"10px"});
// NiceScroll Javascript

// TextArea Javascript
	$(' textarea, input[type="text"], input[type="password"], input[type="datetime"], input[type="datetime-local"], input[type="date"], input[type="month"], input[type="time"], input[type="week"], input[type="number"], input[type="email"], input[type="url"], input[type="search"], input[type="tel"], input[type="color"]').focus(function() {
    if (!$(this).data("DefaultText")) $(this).data("DefaultText", $(this).val());
    if ($(this).val() != "" && $(this).val() == $(this).data("DefaultText")) $(this).val("");
  }).blur(function() {
    if ($(this).val() == "") $(this).val($(this).data("DefaultText"));
  });
// TextArea Javascript

});

// Map Toggle function 
function cs_map_toggle(){
	// plus minus Close event script start
	jQuery("a.map-marker") .click(function(){
		jQuery(this).toggleClass("active");
	})
	// plus minus Close script start	
}
// Player toggle function
function cs_playlist_toggle(){
	// jplyer list Toggle
	jQuery(".btntoggle").click(function(event) {
		/* Act on the event */
		var a = jQuery(this).attr('href');
		jQuery(this).toggleClass('active');
		jQuery(a).toggleClass("active-box");
		return false;
	});
	// jplyer list Toggle	
}
// Gallery js function
function cs_gallery_js(){
	  //Inview Call Back
  jQuery(".gallerysec figure").on("inview", function(e, t) {
    if (t) {
      jQuery(this).addClass("viewme")
    }
  });	
}
// Share toggle function
function cs_social_share(){
	
// JavaScript Toggle function everywhere click close
jQuery('.share_post .social-network').hide();
	jQuery(".sharenow").click(function(){
  jQuery(this).toggleClass("active").next().fadeToggle("active");
 });
 jQuery('html').click(function() {
 jQuery(".share_post .social-network").fadeOut();
 });
jQuery('.share_post').click(function(event){
     event.stopPropagation();
 });	
}
function para() {}
// Parallex
// Tabs script start
jQuery('#myTab a').click(function (e) {
  e.preventDefault()
  jQuery(this).tab('show')
})
// Tabs script End

// masonry script
function  cs_mas_script(id){
	var $container = jQuery('#'+id);
  	$container.isotope({
    itemSelector: '.box',
	layoutMode: 'masonry',
    resizesContainer: true
  });
}
function event_map(contentdesc,lat, long, zoom, counter){
	 function initialize() {
				var styles = [
    {
      stylers: [
        { hue: "#000000" },
        { saturation: -100 }
      ]
    },{
      featureType: "road",
      elementType: "geometry",
      stylers: [
        { lightness: -40 },
        { visibility: "simplified" }
      ]
    },{
      featureType: "road",
      elementType: "labels",
      stylers: [
        { visibility: "on" }
      ]
    }
  ];
		var styledMap = new google.maps.StyledMapType(styles,
		{name: "Styled Map"});
			var myLatlng = new google.maps.LatLng(lat,long);
			directionsDisplay = new google.maps.DirectionsRenderer({
				polylineOptions: {
				  strokeColor: "red"
				}
			  });
			var mapOptions = {
				zoom: zoom,
				backgroundColor: '#cccccc',
				scrollwheel: true,
				draggable: true,
				center: myLatlng,
				//mapTypeId: google.maps.MapTypeId.ROADMAP ,
				disableDefaultUI: true,
				mapTypeControlOptions: {
				  mapTypeIds: [google.maps.MapTypeId.ROADMAP, 'map_style']
				}
			}
  			var map = new google.maps.Map(document.getElementById('map_canvas'+counter), mapOptions);
			map.mapTypes.set('map_style', styledMap);
			map.setMapTypeId('map_style');
			var infowindow = new google.maps.InfoWindow({
				content: "<div class='info-gmap-tool'>"+contentdesc+"</div>",
				//position: myLatLng,
				maxWidth: 500,
				maxHeight:350,
			});
			var marker = new google.maps.Marker({
			position: myLatlng,
			map: map,
			title: '',
			// icon: 'images/map-marker.png',
			shadow:''
		});
			//google.maps.event.addListener(marker, 'click', function() {
				if (infowindow.content != ''){
				  infowindow.open(map, marker);
				   map.panBy(1,-60);
				   google.maps.event.addListener(marker, 'click', function(event) {
					infowindow.open(map, marker);

				   });
				}
			//});
		}
     google.maps.event.addDomListener(window, 'load', initialize);
  }
  
function cs_like_counter(theme_url, post_id){
   jQuery("#like_this"+post_id).hide();
   jQuery("#loading_div"+post_id).show();
   var dataString = 'post_id=' + post_id;
            jQuery.ajax({
                type:"POST",
                url: theme_url+"/include/like_counter.php",
    data:dataString, 
                success:function(response){
     jQuery("#loading_div"+post_id).hide();
     jQuery("#you_liked"+post_id).show();
     jQuery("#like_counter"+post_id).html(response);
	 jQuery(".like_counter"+post_id).html(response);
                }
            });
            //return false;
}
// Add Tag Last child Script
function cs_add_class_last_child(){
	jQuery(".event article:last").addClass("last-item").append('<span class="last-span" />');
}

function gotoTop () {
	jQuery('.gotop').each(function(){
		var a = jQuery(window).width();
		var c = jQuery(this).parents(".container").width();
		jQuery(this) .css({
			right: (a-c)/3
		});
	});	
}

// Load  Event map js
function show_mapp(id, add,lat, long, zoom, home_url, get_template_directory_uri) {
						
	var a = jQuery("div.post-"+id).find("[id^=map]").length;
	if (a > 1) {
		jQuery("div.post-"+id).toggleClass("event-map");
		} else {
			jQuery("article.post-"+id) .find("a.map-marker i").hide();
			//jQuery("article.post-"+id) .find("a.map-marker").append('<img src="'+get_template_directory_uri+'/images/ajax-loader.gif" />');
			jQuery("article.post-"+id) .find("a.map-marker").append('<i class="fa fa-spinner fa-spin"></i>');
	var dataString = 'post_id=' + id + '&add=' + add + '&lat=' + lat + '&long=' + long + '&zoom='+ zoom;
			jQuery.ajax({
				type:"POST",
				url: get_template_directory_uri+"/include/map_load.php",
				data:dataString, 
				success:function(response){
					
					jQuery("article.post-"+id) .find("a.map-marker i").show();
					jQuery("article.post-"+id) .find("a.map-marker .fa-spin").hide();
					jQuery("div.post-"+id).toggleClass("event-map");
					jQuery("div.post-"+id).show();
					jQuery("#map_canvas"+id).html(response);
					//jQuery(".map-marker"+id).hide();
				
				}
	});
		}
}
function cs_mailchimp_submit(theme_url,counter){
	'use strict';
 	$ = jQuery;

	$('#btn_newsletter_'+counter).hide();

	$('#process_newsletter_'+counter).html('<i class="fa fa-spinner fa-spin"></i>');

	$.ajax({

		type:'POST', 

		url: theme_url+'/include/mailchimp_load.php',

		data:$('#mcform_'+counter).serialize(), 

		success: function(response) {

			$('#mcform_'+counter).get(0).reset();

			$('#newsletter_mess_'+counter).show('');

			$('#newsletter_mess_'+counter).html(response);

			$('#btn_newsletter_'+counter).show('');

			$('#process_newsletter_'+counter).html('');

 
			//$('#frm_slide').find('.form_result').html(response);

		}

	});

}

// Mailchimp widget 
function cs_mailchimp_add_scripts () {
	//'use strict';
	(function(a){a.fn.ns_mc_widget=function(b){var e,c,d;e={url:"/",cookie_id:false,cookie_value:""};d=jQuery.extend(e,b);c=a(this);c.submit(function(){var f;f=jQuery("<div></div>");f.css({"background-image":"url("+d.loader_graphic+")","background-position":"center center","background-repeat":"no-repeat",height:"16px",left:"48%",position:"absolute",top:"40px",width:"16px","z-index":"100"});c.css({});c.children().hide();c.append(f);a.getJSON(d.url,c.serialize(),function(h,k){var j,g,i;if("success"===k){if(true===h.success){i=jQuery("<p>"+h.success_message+"</p>");i.hide();c.fadeTo(400,0,function(){c.html(i);i.show();c.fadeTo(400,1)});if(false!==d.cookie_id){j=new Date();j.setTime(j.getTime()+"3153600000");document.cookie=d.cookie_id+"="+d.cookie_value+"; expires="+j.toGMTString()+";"}}else{g=jQuery(".error",c);if(0===g.length){f.remove();c.children().show();g=jQuery('<div class="error"></div>');g.prependTo(c)}else{f.remove();c.children().show()}g.html(h.error)}}return false});return false})}}(jQuery));
}
// end mailchimp widget

function cs_textrotation(){

	jQuery(".cs-page-title span").textrotator({
	    animation: "fade",
	    speed: 1000
	  });
	  jQuery(".demo2 .rotate").textrotator({
	    animation: "flip",
	    speed: 1250
	  });
	  jQuery(".demo3 .rotate").textrotator({
	    animation: "flipCube",
	    speed: 1500
	  });
	  jQuery(".demo4 .rotate").textrotator({
	    animation: "flipUp",
	    speed: 1750
	  });
	  jQuery(".demo5 .rotate").textrotator({
	    animation: "spin",
	    speed: 2000
	});
}

function cs_video_load(theme_url, post_id, post_video,poster){
	'use strict';
   	//var dataString = 'post_video=' + post_video;
   	var dataString = {post_video:post_video,poster:poster};
	jQuery.ajax({
		type:"POST",
		url: theme_url+"/include/video_load.php",
			 data:dataString, 
		success:function(response){
	//jQuery("#myModal"+post_id).hide();
	jQuery("a[data-target='#myModal"+post_id+"']").removeAttr('onclick')
	jQuery("#myModal"+post_id).html(response);
		jQuery('audio,video').mediaelementplayer({
			sfeatures: ['playpause']
		});
	}
});
            //return false;
}