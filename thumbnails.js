var cs_previews = null,
    cs_wt_cur_page = 0,
    cs_tw_scroll_in_work = false,
    cs_tw_timer_to_collapse = null,
    cs_tw_cat_to_collapse = null,
    cs_tw_thumb_num = 0,
    cs_tw_cat_width = 0,
    cs_tw_cat_height = 0;


function cs_get_offset(el)
{
    var _x = 0;
    var _y = 0;
    while (el && !isNaN(el.offsetLeft) && !isNaN(el.offsetTop)) {
        _x += el.offsetLeft - el.scrollLeft;
        _y += el.offsetTop - el.scrollTop;
        el = el.offsetParent;
    }
    
    return {top: _y, left: _x};
}

function escapeHTML(str)
{
    var div = document.createElement('div');
    var text = document.createTextNode(str);
    div.appendChild(text);
    return div.innerHTML;
}
 
function cs_tw_scroll(dir, page_count)
{
    var cat_list = jQuery('div.cs_tw_cats');
    
    if (dir === 'right') {
        if (!cs_tw_scroll_in_work && cs_wt_cur_page !== page_count-1) {
            cs_tw_scroll_in_work = true;
            var left = cat_list.css('left');
            if (left === 'auto') left = 0;
            else left = parseInt(left);
            cat_list.animate(
                {'left': left - cs_tw_thumb_num * cs_tw_cat_width + 'px'},
                {'duration': 700,
                'complete': function() { cs_tw_scroll_in_work = false; }});
            cs_wt_cur_page++;
        }
    } else { // left
        if (!cs_tw_scroll_in_work && cs_wt_cur_page !== 0) {
            cs_tw_scroll_in_work = true;
            var left = cat_list.css('left');
            if (left === 'auto') left = 0;
            else left = parseInt(left);
            cat_list.animate(
                {'left': left + cs_tw_thumb_num * cs_tw_cat_width + 'px'},
                {'duration': 700,
                'complete': function() { cs_tw_scroll_in_work = false; }});
            cs_wt_cur_page--;
        }
    }
}

function cs_tw_cat_mouseover(that, img_src, cat_id, cat_ind)
{
    if (cs_tw_timer_to_collapse && cs_tw_cat_to_collapse === cat_id) {
        clearTimeout(cs_tw_timer_to_collapse);
        cs_tw_timer_to_collapse = null;
    } else {
        var subcats = jQuery('#cs_tw_subcats_'+cat_id),
            img = jQuery('#cs_tw_img_'+cat_id, that),
            position = cs_get_offset(that.parentNode.parentNode);
        
        img.attr('src', img_src);
        var top_add = cs_tw_cat_height - 10,
            left_add = 5;
        subcats
            .detach()
            .css({
                'display': 'block',
                'top': position.top+top_add+'px',
                'left': position.left+parseInt(cat_ind%cs_tw_thumb_num*cs_tw_cat_width)+left_add+'px'})
            .prependTo('body');
    }
}

function cs_tw_cat_mouseout(that, img_src, cat_id)
{
    cs_tw_cat_to_collapse = cat_id;
    cs_tw_timer_to_collapse = setTimeout(function() {
        jQuery('#cs_tw_img_'+cat_id, that).attr('src', img_src);
        jQuery('#cs_tw_subcats_'+cat_id).css('display', 'none');
        cs_tw_timer_to_collapse = null;
    }, 100);
}

function cs_tw_subcats_mouseover(that, cat_id)
{
    if (cs_tw_timer_to_collapse) {
        clearTimeout(cs_tw_timer_to_collapse);
        cs_tw_timer_to_collapse = null;
    }
}

function cs_tw_subcats_mouseout(that, img_src, cat_id)
{
    cs_tw_cat_to_collapse = cat_id;
    cs_tw_timer_to_collapse = setTimeout(function() {
        jQuery('#cs_tw_img_'+cat_id, that.parentNode).attr('src', img_src);
        jQuery(that).css('display', 'none');
        cs_tw_timer_to_collapse = null;
    }, 100);
}


/*jQuery(window).load(function() {
    jQuery('body').append('<p style="display: none">'+cs_previews_fmt+'</p>');
});*/
jQuery(document).ready(function() {
    cs_previews = jQuery("script#cs_thumbnails_script")
            //.last()
            .attr("src")
            .split('?')[1]
            .split('&');
    
    var cs_previews_fmt = '';
    for (i in cs_previews) {
        var cs_opt = cs_previews[i].split('=');
        var tmp = '';
        if (cs_opt[0].substr(0, 7) === 'preview') {
            tmp = decodeURIComponent(cs_opt[1]);
            tmp = tmp.replace(/\^/g, '/');
            cs_previews_fmt += '<img src="'+tmp+'" alt="Image preview" />\n';
        } else if (cs_opt[0] === 'thumb_num') {
            tmp = decodeURIComponent(cs_opt[1]);
            cs_tw_thumb_num = parseInt(tmp);
        } else if (cs_opt[0] === 'cat_width') {
            tmp = decodeURIComponent(cs_opt[1]);
            cs_tw_cat_width = parseInt(tmp);
        } else if (cs_opt[0] === 'cat_height') {
            tmp = decodeURIComponent(cs_opt[1]);
            cs_tw_cat_height = parseInt(tmp);
        }
    }
    
    if (jQuery.browser.opera) {
        var margin = parseInt(cs_tw_cat_height / 2 - 30);
        jQuery('.cs_tw_larrow div, .cs_tw_rarrow div').css('top', '-'+margin+'px');
    }
    
    jQuery('body').append('<p style="display: none">'+cs_previews_fmt+'</p>');
});