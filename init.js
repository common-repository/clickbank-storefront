function cs_loadScript(url, callback)
{
    var script = document.createElement('script');
    script.type = 'text/javascript';
    script.src = url;
    if (typeof callback != 'undefined') {
        // bind the event to the callback function 
        // there are several events for cross browser compatibility
        script.onreadystatechange = callback;
        script.onload = callback;
    }
    
    // adding the script tag to the head as suggested before
    var head = document.getElementsByTagName('head')[0];
    // fire the loading
    head.appendChild(script);
}

function cs_imagePreviewLoad()
{
    if (typeof cs_imagePreview == 'undefined') {
        cs_loadScript(cs_pluginURL+'/image_preview.js');
    }
}

/*
function cs_show_page(section, user_id, criteria, page, sortby, switch_view,mcat,scat)
{
    page_top = jQuery('#cs_product_list').offset().top - 10;
    if (page_top < 0) page_top = 0;
    
    jQuery('#cs_product_list')
        .css({opacity: 0.2});
    jQuery('#cs_loading_label').css({
        display: 'inline',
        top: jQuery(window).height()/2 - jQuery('#cs_loading_label').height()/2,
        left: jQuery(document).width()/2 - jQuery('#cs_loading_label').width()/2});
    
    url = cs_pluginURL+'/ajax_request.php'
        + '?section='+section
        + '&user_id='+user_id
        + '&criteria='+encodeURIComponent(criteria)
        + '&sortby='+sortby
        + '&cs_mcat='+mcat
        + '&cs_scat='+scat
        + '&sortby='+sortby
        + '&switch_view='+switch_view
        + '&page='+page;
        //console.log(url);
    jQuery.get(
        url,
        function(data) {
            jQuery('#cs_loading_label').css({display: 'none'});
            jQuery('#cs_product_list')
                .html(data)
                .css({opacity: 1});
            cs_imagePreview(); // Enable preview function
            
            FB.XFBML.parse(jQuery('#cs_product_list').get(0));
            twttr.widgets.load(jQuery('#cs_product_list').get(0));
        });
    
    // Scroll to the top of the list
    jQuery('html, body').animate({scrollTop: page_top}, 1000);
}
*/
function cs_quick_search(search_page, criteria)
{
    window.location = search_page + encodeURIComponent(criteria);
}




if (typeof jQuery == 'undefined') {
    cs_loadScript('https://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js',
        cs_imagePreviewLoad);
} else {
    cs_imagePreviewLoad();
}

var cs_pluginURL = jQuery("script[src]")
        .last()
        .attr("src").split('?')[0].split('/').slice(0, -1).join('/');

function cs_show_page(section, user_id, criteria, page, sortby, switch_view,mcat,scat)
{
	
	page_top = jQuery('#cs_product_list').offset().top - 10;
    if (page_top < 0) page_top = 0;
    
    jQuery('#cs_product_list')
        .css({opacity: 0.2});
    jQuery('#cs_loading_label').css({
        display: 'inline',
        top: jQuery(window).height()/2 - jQuery('#cs_loading_label').height()/2,
        left: jQuery(document).width()/2 - jQuery('#cs_loading_label').width()/2});
    
    // This does the ajax request (The Call).
    jQuery.ajax({
        url: cbpro_paging_ajax_object.ajax_url, 
		
        data: {
            'action':'cs_pagination_ajax_request', // This is our PHP function below
			'cbpro_nonce' : 'cbpro_paging_ajax_object.global_cbpro_nonce',
            'section': section,
        	'user_id': user_id,
        	'criteria': encodeURIComponent(criteria),
        	'sortby': sortby,
        	'cs_mcat': mcat,
        	'cs_scat': scat,
        	'sortby': sortby,
        	'switch_view': switch_view,
        	'page': page
        },
        success:function(data) {
						 jQuery('#cs_loading_label').css({display: 'none'});
						jQuery('#cs_product_list')
							.html(data)
							.css({opacity: 1});
						cs_imagePreview(); // Enable preview function

						FB.XFBML.parse(jQuery('#cs_product_list').get(0));
						twttr.widgets.load(jQuery('#cs_product_list').get(0));
        },  
        error: function (jQXHR, textStatus, errorThrown) {
			alert("An error occurred whilst trying to contact the server: " + jQXHR.status + " " + textStatus + " " + errorThrown);
		}
    });   
	jQuery('html, body').animate({scrollTop: page_top}, 1000);
	   

}