
///////////////////////////////		
// iPad and iPod Detection
///////////////////////////////
	
function isMobile(){
    return (
        (navigator.userAgent.match(/Android/i)) ||
		(navigator.userAgent.match(/webOS/i)) ||
		(navigator.userAgent.match(/iPhone/i)) ||
		(navigator.userAgent.match(/iPod/i)) ||
		(navigator.userAgent.match(/iPad/i)) ||
		(navigator.userAgent.match(/BlackBerry/))
    );
}


///////////////////////////////
// Project Filtering 
///////////////////////////////

function projectFilterInit() {
	
	jQuery('#filterNav a').click(function(){
		var selector = jQuery(this).attr('data-filter');
		var container = jQuery('.thumbs.masonry');
		var colW = container.width() * 0.25;	
		container.isotope({
			filter: selector,			
			hiddenStyle : {
		    	opacity: 0,
		    	scale : 1
			},
			resizable: false,
			masonry: {
				columnWidth: colW
			}			
		});
	
		if ( !jQuery(this).hasClass('selected') ) {
			jQuery(this).parents('#filterNav').find('.selected').removeClass('selected');
			jQuery(this).addClass('selected');
		}
	
		return false;
	});	
}

///////////////////////////////
// Isotope Grid Resize
///////////////////////////////

function gridResize() {	
	// update columnWidth on window resize
	var container = jQuery('.thumbs.masonry');
	var colW = container.width() * 0.25;	
	container.isotope({
		resizable: false,
		masonry: {
			columnWidth: colW
		}
	});			
}


///////////////////////////////
// Project thumbs 
///////////////////////////////

function projectThumbInit() {	
	var container = jQuery('.thumbs.masonry');
	var colW = container.width() * 0.25;	
	container.isotope({		
		resizable: false,
		layoutMode: 'fitRows',
		masonry: {
			columnWidth: colW
		}
	});	
	jQuery(".project.small").css("opacity", "1");	
}

///////////////////////////////
// Product thumbs 
///////////////////////////////

function productThumbInit() {	
	var container = jQuery('ul.products');
	var colW = container.width() * 0.25;	
	
	container.isotope({		
		resizable: false,
		layoutMode: 'fitRows',
		masonry: {
			columnWidth: colW
		}
	});
	//alert(container.width());	
	jQuery(".product").css("opacity", "1");	
}

///////////////////////////////
// Isotope Grid Resize Product
///////////////////////////////

function gridResizeProduct() {	
	// update columnWidth on window resize
	var container = jQuery('#content ul.products');
	var colW = container.width() * 0.25;	
	container.isotope({
		resizable: false,
		masonry: {
			columnWidth: colW
		}
	});			
}	
	
jQuery.noConflict();
jQuery(window).load(function(){		
	productThumbInit();
	projectThumbInit();	
	projectFilterInit();
	jQuery(".videoContainer").fitVids();
	
	jQuery(window).smartresize(function(){
		gridResize();
		gridResizeProduct();
	});	
	
});