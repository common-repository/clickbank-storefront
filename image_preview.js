/*
 * Image preview script 
 * powered by jQuery (http://www.jquery.com)
 * 
 * written by Alen Grakalic (http://cssglobe.com)
 * 
 * for more info visit http://cssglobe.com/post/1695/easiest-tooltip-and-image-preview-using-jquery
 *
 */

var cs_heightCur = null,
    cs_yCur = null,
    xScreen = null,
    yScreen = null,
    xOffset = 30,
    yOffset = -20,
    cs_curE = null,
    cs_xPlace = null,
    cs_yPlace = null,
    cs_xSign = null;


function cs_show_preview(e)
{
    cs_curE = e;
    cs_yCur = e.clientY + yOffset;
    if (cs_heightCur) {
        var diff = cs_yCur + cs_heightCur + 60 - yScreen;
        if (diff > 0) cs_yCur = cs_yCur - diff;
        if (cs_yCur < 30) cs_yCur = 30;
        jQuery('#cs_preview')
            .css('top', cs_yCur + 'px')
            .css('left', (e.clientX + xOffset) + 'px');
    } else {
        jQuery('#cs_preview')
            .css('top', cs_yCur + 'px')
            .css('left', (e.clientX + xOffset) + 'px');
    }
}
 
cs_imagePreview = function(){
	/* CONFIG */
    xScreen = jQuery(window).width();
    yScreen = jQuery(window).height();
    cs_xPlace = null;
    cs_yPlace = null;
    cs_xOffset = null;
    cs_xSign = null;
    
	
	// these 2 variable determine popup's distance from the cursor
	// you might want to adjust to get the right result
	
	/* END CONFIG */
	jQuery("a.cs_preview").hover(function(e){
	    
		this.t = this.title;
		this.title = "";
		var c = (this.t != "") ? "<br />" + this.t : "";
        jQuery("body").append(
            '<p id="cs_preview">'
            + '<img src="'+cs_pluginURL+'/ajax-loader.gif" alt="Image preview" '
            + 'class="'+jQuery(this).attr('index')+'" />'+c+'</p>');
        
        var preload = new Image();
        jQuery(preload).load(function() {
            jQuery('#cs_preview img')
                .attr('src', this.src)
                .load(function() {
                    cs_heightCur = jQuery(this).height();
                    if (cs_heightCur > yScreen - 50) {
                        cs_heightCur = yScreen - 100;
                        jQuery(this).height(cs_heightCur);
                    }
                    cs_show_preview(cs_curE);
                });
        });
        preload.src = jQuery(this).attr('src');
       // var isIE = navigator.userAgent.toUpperCase().indexOf('MSIE') >=0 ? 'click' : 'change' ;
       //alert('123'+navigator.userAgent.toUpperCase().indexOf('MSIE'));
       // if (jQuery.browser.msie && jQuery.browser.version.slice(0, 2) === '8.') {
        if (navigator.userAgent.toUpperCase().indexOf('MSIE') >=0 ) {
            jQuery(preload).trigger('load');
        }
        
        cs_heightCur = null;
        cs_yCur = e.clientY + yOffset;
        cs_curE = e;
		jQuery('#cs_preview')
            .css('top', cs_yCur + 'px')
            .css('left', (e.clientX + xOffset) + 'px')
            .fadeIn("fast");
    },
	function(){
		this.title = this.t;	
		jQuery("#cs_preview").remove();
    });
	jQuery("a.cs_preview").mousemove(function(e){
        cs_show_preview(e);
	});
};


// starting the script on page load
jQuery(document).ready(function(){
//jQuery(window).load(function() {
	cs_imagePreview();
});
