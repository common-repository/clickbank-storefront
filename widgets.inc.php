<?php
  
require_once $GLOBALS['cs_plugin_dir'].'xmldb.inc.php';


/**
* Register widgets
* 
*/


function cs_register_widgets()

{
    
    wp_register_sidebar_widget(
        'cs_widget_cats',
        '&nbsp;&nbsp;&nbsp;&raquo;&raquo; CB Categories Widget',
        'cs_widget_cats',array( 'description' => 'Display CB categories vertically' ));
    wp_register_sidebar_widget(
        'cs_widget_horizontal_cats',
        '&nbsp;&nbsp;&nbsp;&raquo;&raquo; CB Categories Widget (Horizontal)',
        'cs_widget_horizontal_cats', array( 'description' => 'Display CB categories horizontally' ));
    
        
    /*wp_register_sidebar_widget(
        'cs_widget_search',
        '&nbsp;&nbsp;&nbsp;&raquo;&raquo; CB Search Widget',
        'cs_widget_search');
   
     
    wp_register_sidebar_widget(
        'cs_cb_vertical_ads',
        '&nbsp;&nbsp;&nbsp;&raquo;&raquo; CB Ads Widget (Vertical)',
        'cs_cb_vertical_ads');
    
    wp_register_sidebar_widget(
        'cs_cb_horizontal_ads',
        '&nbsp;&nbsp;&nbsp;&raquo;&raquo; CB Ads Widget (Horizontal)',
        'cs_cb_horizontal_ads');
      */   
		
    wp_register_sidebar_widget(
        'cs_popular_categories',
        '&nbsp;&nbsp;&nbsp;&raquo;&raquo; CB Popular Categories',
        'cs_popular_categories');
        
    wp_register_sidebar_widget(
        'cs_widget_recent_reviews',
        '&nbsp;&nbsp;&nbsp;&raquo;&raquo; CB Recent Product Reviews Widget',
        'cs_widget_recent_reviews');        
        
    wp_register_sidebar_widget(
        'cs_reviews_cats',
        '&nbsp;&nbsp;&nbsp;&raquo;&raquo; <strong>CB Review Categories',
        'cs_reviews_cats',array( 'description' => 'Display CB product review categories'));  

     
    register_widget( 'cs_top_products_class' );
    register_widget( 'cs_widget_search_bar' );
    
    if (get_option('cbproads_premium_store')){  register_widget( 'cs_widget_ads_widget' ); }
   
     
}

/** Add our function to the widgets_init hook. **/





function cs_widget_recent_reviews($args)
{
        $user_id=$_SESSION['cs_user_id'];
		
		//this is susepended untill wehave reviews in all categoruiees, otherwise it will show nil reviews
		if (isset($_GET['cs_main_category'])){
			$cs_t_cat_code=$_GET['cs_main_category'];
		}elseif (isset($_GET['cs_temp_main_category'])){
			$cs_t_cat_code=$_GET['cs_temp_main_category'];
		}
		$cs_t_cat_code="";
		////till here, just remove the above line and take actual category inpit to display relevent reviewss of that category of page/.
        
        echo $args['before_widget'];
        //echo '<div style="background:#F0F0F0; border-radius:5px; padding:10px 10px;">';
        echo $args['before_title'], 'Recent Reviews', $args['after_title'];
        $url="https://cbproads.com/xmlfeed/wp/main/cb_reviews.asp" . '?start=0&id='.$user_id
            . '&end=10&mcat='.$cs_t_cat_code;
            
        $url=$url."&Dates=".date('Y-m-d')."&url=".rawurlencode(home_url());   
	    if ($_GET['cs_show_url']==='yes'){
			echo $section.' -> '.$url.'<br>'; 
			echo "current time is: ".date("h:i:sa").'<br><br>';
		}
		
         $rss = fetch_feed($url);
        if (is_wp_error($rss)) return $empty_answer;
        if (0 == $rss->get_item_quantity(400)) return $empty_answer;
    
        $review_link = cs_get_review_page('', '');
        $items = $rss->get_items(0, 400);
        $cnt=0;
		
		echo "<ul style='margin-left:0px;'>";
		 
        foreach ($items as $item) {
            $cnt=$cnt+1;     
            // Descriptions
            $paths = $item->get_item_tags(SIMPLEPIE_NAMESPACE_RSS_20, "description");
            $description = htmlspecialchars(cs_cdata($paths[0]['data']));
            
            $review_header = $item->get_item_tags(SIMPLEPIE_NAMESPACE_RSS_20, "header_image");
            $review_image = cs_cdata($review_header[0]['data']);
            
            $paths = $item->get_item_tags(SIMPLEPIE_NAMESPACE_RSS_20, "title");
            $title = htmlspecialchars(cs_cdata($paths[0]['data']));
            
            $mcatcode = $item->get_item_tags(SIMPLEPIE_NAMESPACE_RSS_20, "mccode");
            $mcatcd = cs_cdata($mcatcode[0]['data']);
            
            $sbtitle = $item->get_item_tags(SIMPLEPIE_NAMESPACE_RSS_20, "sub_title");
            $stitle = cs_cdata($sbtitle[0]['data']);
            
            $paths = $item->get_item_tags(SIMPLEPIE_NAMESPACE_RSS_20, "ids");
            $ids = cs_cdata($paths[0]['data']);
			       
			$pathss = $item->get_item_tags(SIMPLEPIE_NAMESPACE_RSS_20, "affiliate");
			 $affid = cs_cdata($pathss[0]['data']);

			 echo "<li list-style-type:none; '><a href='$review_link?mem=$affid&memnumber=$user_id&cs_mcat=$mcatcd&cs_review_id=$ids' style='font-weight:normal;' >".$title."</a></li>\n";
			  
			/*
          //  echo "<h6 style='font-weight:normal; line-height:1.1em; font-size:1em; margin-bottom:10px;'>".str_replace("Review","",$title).substr($stitle,0,100)."</h6>";
            if ($cnt%2==1){
                echo "<div align='center' style='display:flex; border:0px solid red; margin-top:10px;padding-bottom:5px;margin-bottom:0px; vertical-align:bottom; ".($cnt<5?"border-bottom:0px solid #d0d0d0;":"")."'>";
            }else{
            }
            
            echo "<div style='border:0px solid red; width:50%;". ($cnt%2==1?"margin-right:8px;margin-left:0px;":"margin-right:0px;margin-left:8px;")." position:relative;'>";
            echo    "<div style='width:100%; '><a href='$review_link?mem=$affid&memnumber=$user_id&cs_mcat=$mcatcd&cs_review_id=$ids'><img style='border-radius:2px;' src='".$review_image."' class='img-responsive'></a></div>";
            echo        "<div style=' width:100%; margin-top:15px; text-align:left; padding-left:0px; padding-right:0px; font-weight:normal; font-size:1.0em; line-height:1.15em;'>".str_replace("Review","",$title)." ".substr($stitle,0,100)." <br><br><br>&nbsp;".
                            "<div style='position:absolute; bottom:1px;text-transform:normal;  padding-top:3px; colors:#404040; font-size:1.00em; margin-bottom:15px;'>".
                            "<a href='$review_link?mem=$affid&memnumber=$user_id&cs_mcat=$mcatcd&cs_review_id=$ids' style='font-weight:normal;'>Read Review &raquo</a></div>".
                        "</div>";
            echo  "</div>";
            
            if ($cnt%2==0){
                echo "</div>";
            }*/
			
			
        }
        
		 echo "</ul>";
		
		//echo "</div>";
		echo $args['after_widget'];
    
}    


function cs_reviews_cats($args)
{
    
    echo $args['before_widget'];
    //echo '<div style="background:#F0F0F0; padding-bottom:20px; border-radius:5px; padding:10px 10px;">';
    echo $args['before_title'], 'Reviews By Category', $args['after_title'];
     echo "<ul style='margin-left:5px;'>";
    
    $url="https://cbproads.com/xmlfeed/wp/main/review_categories.asp";
     $rss = fetch_feed($url);
    if (is_wp_error($rss)) return $empty_answer;
    if (0 == $rss->get_item_quantity(400)) return $empty_answer;

    $review_link = cs_get_review_page('', '');
    $items = $rss->get_items(0, 400);
    foreach ($items as $item) {
        
        $paths = $item->get_item_tags(SIMPLEPIE_NAMESPACE_RSS_20, "mainhead");
        $mainhead = htmlspecialchars(cs_cdata($paths[0]['data']));
        
        $paths = $item->get_item_tags(SIMPLEPIE_NAMESPACE_RSS_20, "mainhead_name");
        $mainhead_name = htmlspecialchars(cs_cdata($paths[0]['data']));
		//$mainhead_name=str_replace("&amp;","&",$mainhead_name);
				
         $turl=$review_link."?cs_mcat=".$mainhead."&cs_mcat_name=".urlencode($mainhead_name);
        if ($_GET['cs_mcat']===$mainhead) {
			
            echo "<li style='color:#696969; list-style-type:none; '>&raquo; <a href='".($turl)."' >".$mainhead_name."</a></li>\n";
        }
        else{
           
             echo "<li><a href='".($turl)."' >".$mainhead_name."</a></li>\n";
        }
    }
    echo "</ul>";
        
        
    
    // echo "</div>";
   
    echo $args['after_widget'];
   
}

/**
* Widget for categories
* 
* @param mixed $args
*/
function cs_widget_cats($args)
{
    //cs_widget_search($args);
    
    $cats = cs_get_categories();
    $display_model='collapsed';
    // Link to category page
    $cat_page = cs_get_products_page('cs_category', '');
   // var_dump($cats);
    // Output
    echo $args['before_widget'];
    
    if ($display_model==='collapsed'){ //collpased
        echo $args['before_title'], "Products By Category",$args['after_title']."";
         echo "<ul style='margin-left:5px;'>";
         foreach ($cats['cats'] as $cat_id => $cat) {
                if (!isset($_SESSION['cs_cats_to_omit'][$cat_id])) {
                    echo "<li><a href=\"".str_replace('cs_category','cs_main_category',$cat_page).$cat_id."&cs_main_category_name=".urlencode($cat['name'])."\">".htmlspecialchars($cat['name'])."</a>";
                }
                if (($_GET['cs_main_category']==$cat_id) || ($_GET['cs_temp_main_category']==$cat_id)) {
                     //echo "<div style='margin-left:5px; padding:3px;'>";
                     foreach ($cat['subcats'] as $sub_id => $subcat) {
                         $name_html = htmlspecialchars($subcat['name']);
                         if (($_GET['cs_category']==$sub_id)){
                              echo "<ol>&raquo; $name_html</ol>";
                         }else{
                             echo "<ol><a style='font-size:0.95em;' href=\"$cat_page". ($cat_page !== '#' ? $sub_id : ''). "&cs_temp_main_category=".$cat_id."\">$name_html</a></ol>";
                         }                             
                     }
                     //echo "</div>"        ;
                     
                }
                 echo "</li>";
        }
        echo "</ul>";
        
    }else{ //expanded
            echo $args['before_title'], "<span style='font-size:1.05em;color:inherit;'>Products By Category</span>",$args['after_title']."<hR>";
            foreach ($cats['cats'] as $cat_id => $cat) {
                if (!isset($_SESSION['cs_cats_to_omit'][$cat_id])) {
                    echo $args['before_title'], "<a href=\"".str_replace('cs_category','cs_main_category',$cat_page).$cat_id."&cs_main_category_name=".urlencode($cat['name'])."\">".htmlspecialchars($cat['name'])."</a>", $args['after_title'].'<div style="border-right:1px solid #f0f0f0; margin-bottom:23px;"\>';
                    foreach ($cat['subcats'] as $sub_id => $subcat) {
                        $name_html = htmlspecialchars($subcat['name']);
                        
                        if (isset($subcat['selected']) && $subcat['selected']) {
                            echo "&raquo; $name_html";
                           
                        } else {
                            echo "&nbsp;&nbsp;<a href=\"$cat_page". ($cat_page !== '#' ? $sub_id : ''). "&cs_temp_main_category=".$cat_id. "\">",
                            "$name_html</a>";
                               // echo "<textarea>". $args['before_title'], htmlspecialchars($cat['name']), $args['after_title']."</textarea>";
                              //  echo "<li>sss".$name_html."</li>";
                        }
                        echo "<br />\n";
                    }
                    echo "</div>\n";
                }
            }
    }//expanded/collpased
    
    
    echo $args['after_widget'];
}

/**
* Horizontal widget for categories
* 
* @param mixed $args
*/
function cs_widget_horizontal_cats($args)
{
    // Output
    echo $args['before_widget'];
    echo cs_widget_horizontal_cats_display($args['before_title'], $args['after_title']);
    
    echo $args['after_widget'];
}

/**
* Widget for quick search
* 
* @param mixed $args
*/
function cs_widget_search($args, $show_widget_title = true , $frame_widget = true)
{
    $search_page = cs_get_products_page('cs_keywords', '');
    #$search_page = cs_get_products_page();
    
    // Output
        echo ($frame_widget ? $args['before_widget'] : ''),
        ($show_widget_title ? $args['before_title']. 'Search Products'. $args['after_title'] : ''),
       // $args['before_title'], 'Search Products', $args['after_title'], "\n",
        
        "<div style=''>",
        
                    "<input placeholder=\"Search..\" type=\"text\" id=\"cs_quick_search\" ",
                    "style='float:left; width:80%; border-top-left-radius: 5px;  border-bottom-left-radius: 5px; height:3em; margin-top:0px; display:inline-block;",
                    "border-colors:".$_SESSION['cs_primary_color']."'; name=\"cs_keywords\" value=\"$_GET[cs_keywords]\" />\n",
                    
                    "<button type=\"submit\" style='float:right; height:3em; padding:14px; width:20%; margin-top:0px;   border-top-right-radius: 5px;  border-bottom-right-radius: 5px;  ",
                    "display:inline-block; background:".$_SESSION['cs_primary_color'].";' onclick=\"cs_quick_search('".htmlspecialchars($search_page). "', jQuery('#cs_quick_search').val()); return false\" />",
                    "<i class=\"fa fa-search\" style='color:white;'></i></button>\n",
                    
        "</div><div style='clear:both;'></div>",
        
        ($frame_widget ? $args['after_widget'] : "\n");
}


/*
function cs_cb_vertical_ads($args)
{
   
    echo $args['before_widget'];
   //  echo $args['before_title'], "Sponsored Ads",$args['after_title']."";
    echo cs_show_cb_banner_ads('vertical',1);
    echo $args['after_widget']; 
}

function cs_cb_horizontal_ads($args)
{
   
    echo $args['before_widget'];
    // echo $args['before_title'], "Sponsored Ads",$args['after_title']."";
    echo cs_show_cb_banner_ads('horizontal',1);
    echo $args['after_widget']; 
}
*/

function cs_popular_categories($args)
{
   
    echo $args['before_widget'];
     echo $args['before_title'], "Popular Categories",$args['after_title']."";
    echo cs_popular_categories_shortcode('widget_yes');
    echo $args['after_widget']; 
}




class cs_widget_top_products extends WP_Widget {
    
    function __construct()
    {
        $widget_top_products_ops = array(
            'classname' => 'cs_widget_top_products',
            /*'description' => 'Displays your upcoming posts to tease your readers'*/);
        $control_top_products_ops = array('id_base' => 'cs_widget_top_products');
             parent::__construct(
            'cs_widget_top_products',
            'CB Top Products Widget',
            $widget_top_products_ops, $control_top_products_ops);
    }
    
    function widget( $args, $instance ) {
		extract( $args );
		$title = apply_filters( 'widget_title', $instance['title'] );
		global $post;
		if($post->post_parent):
			$children = wp_list_pages("title_li=&child_of=".$post->post_parent."&echo=0&sort_column=menu_order");
		else:
			$children = wp_list_pages("title_li=&child_of=".$post->ID."&echo=0&sort_column=menu_order");
		endif;
		if ($children) {
			echo $before_widget;
			if ( $title ) echo $before_title . $title . $after_title;
			?>
			<ul id="submenu">
			<?php echo $children; ?>
			</ul>
			<?php
			echo $after_widget;
		}
	}
    
    function update( $new_instance, $old_instance ) {
         $instance = $old_instance;
         $instance['title'] = strip_tags( $new_instance['title'] );
         $instance['text'] = strip_tags( $new_instance['text'] );
         $instance['link'] = strip_tags( $new_instance['link'] );
         return $instance;          
    
    }
    
    // Widget Control Panel //
    function form( $instance ) {

     $title = ! empty( $instance['title'] ) ? $instance['title'] : '';
     $link = ! empty( $instance['link'] ) ? $instance['link'] : 'Your link here';
     $text = ! empty( $instance['text'] ) ? $instance['text'] : 'Your text here';
    ?>
        
        <p>
         <label for="<?php echo $this->get_field_id( 'title'); ?>">Title:</label>
         <input class="widefat" type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $title ); ?>" /></p>
        
        <p>
         <label for="<?php echo $this->get_field_id( 'text'); ?>">Text in the call to action box:</label>
         <input class="widefat" type="text" id="<?php echo $this->get_field_id( 'text' ); ?>" name="<?php echo $this->get_field_name( 'text' ); ?>" value="<?php echo esc_attr( $text ); ?>" /></p>
        
        <p>
         <label for="<?php echo $this->get_field_id( 'link'); ?>">Your link:</label>
         <input class="widefat" type="text" id="<?php echo $this->get_field_id( 'link' ); ?>" name="<?php echo $this->get_field_name( 'link' ); ?>" value="<?php echo esc_attr( $link ); ?>" /></p>
        
    <?php 
    }
}    





/**
* Thumbnails widget for categories
*/
class cs_widget_thumb_cats extends WP_Widget {
    function __construct()
    {
        $widget_ops = array(
            'classname' => 'cs_widget_thumb_cats',
            /*'description' => 'Displays your upcoming posts to tease your readers'*/);
        $control_ops = array('id_base' => 'cs_widget_thumb_cats');
             parent::__construct(
            'cs_widget_thumb_cats',
            'CB Categories Widget (Horizontal Thumbnails)',
            $widget_ops, $control_ops);
    }
    
    // Extract Args //
    function widget($args, $instance)
    {
        global $cs_plugin_url, $cs_plugin_version, $cs_tw_defaults;
        
        foreach ($cs_tw_defaults as $k => $v) {
            if (!isset($instance[$k])) {
                $instance[$k] = $cs_tw_defaults[$k];
            }
        }
        $thumb_num = (int)$instance['thumb_num'];
        
        // Widget output //
        $cats = cs_get_categories();
        // Link to category page
        $cat_page = cs_get_products_page('cs_category', '');
        if ($instance['thumb_size'] === 'large') {
            $cat_width = 142;
            $cat_height = 160;
            $arrow_left = 'https://cbproads.com/wp_plugin_thumb_images/thumb_arrow_left.png';
            $arrow_left_hover = 'https://cbproads.com/wp_plugin_thumb_images/thumb_arrow_left_hover.png';
            $arrow_right = 'https://cbproads.com/wp_plugin_thumb_images/thumb_arrow_right.png';
            $arrow_right_hover = 'https://cbproads.com/wp_plugin_thumb_images/thumb_arrow_right_hover.png';
        } else {
            $cat_width = 101;
            $cat_height = 115;
            $arrow_left = 'https://cbproads.com/wp_plugin_thumb_images/thumb_arrow_small_left.png';
            $arrow_left_hover = 'https://cbproads.com/wp_plugin_thumb_images/thumb_arrow_small_left_hover.png';
            $arrow_right = 'https://cbproads.com/wp_plugin_thumb_images/thumb_arrow_small_right.png';
            $arrow_right_hover = 'https://cbproads.com/wp_plugin_thumb_images/thumb_arrow_small_right_hover.png';
        }
        
        // Output
        $preview = array(
            "preview[0]=".hsc(rawurlencode(str_replace('/', '^', $arrow_left_hover))),
            "preview[1]=".hsc(rawurlencode(str_replace('/', '^', $arrow_right_hover))));
        $preview_count = 2;
        foreach ($cats['cats'] as $cat_id => $cat) {
            if (!isset($_SESSION['cs_cats_to_omit'][$cat_id])) {
                if ($instance['thumb_size'] === 'large') $thumb_grey = $cat['thumbnail_grey'];
                else $thumb_grey = $cat['thumbnail_small_grey'];
                $preview[] = "preview[$preview_count]="
                    . hsc(rawurlencode(str_replace('/', '^', $thumb_grey)));
                $preview_count++;
            }
        }
        echo "<script id=\"cs_thumbnails_script\" type=\"text/javascript\" ",
            "src=\"$_SESSION[cs_plugin_url]/thumbnails.js?",
            implode('&amp;', array_merge($preview,
            array("thumb_num=$thumb_num",
            "cat_width=$cat_width",
            "cat_height=$cat_height",
            "version=$cs_plugin_version"))),
            "\">  ",
            "</script>\n";
        ?>
        <?php echo $args['before_widget'] ?>
        <?php if ($instance['title'] != ''): ?>
            <?php if ($instance['title_css'] == ''): ?>
                <?php echo $args['before_title'], hsc($instance['title']), $args['after_title'] ?>
            <?php else: ?>
                <div style="<?php echo $instance['title_css'] ?>"><?php echo hsc($instance['title']) ?></div>
            <?php endif ?>
        <?php endif ?>
        
        <div style="width: 100%; white-space: nowrap; text-align: center">
            <div style="display: block; width: <?php echo $thumb_num*$cat_width + 126 ?>px">
                <div class="cs_tw_larrow">
                    <div style="height: <?php echo $cat_height ?>px">
                        <img src="<?php echo $arrow_left ?>"
                        alt="" onclick="if (typeof cs_tw_scroll !== 'undefined') cs_tw_scroll('left')"
                        onmouseover="this.src='<?php echo $arrow_left_hover ?>'"
                        onmouseout="this.src='<?php echo $arrow_left ?>'">
                    </div>
                </div>
                <div class="cs_tw_frame"
                style="width: <?php echo $thumb_num*$cat_width ?>px; text-align: left">
                    <div class="cs_tw_cats">
                        <?php $i = 0; ?>
                        <?php foreach ($cats['cats'] as $cat_id => $cat): ?>
                            <?php if (!isset($_SESSION['cs_cats_to_omit'][$cat_id])):
                                if ($instance['thumb_size'] === 'large') {
                                    $thumb_main = hsc($cat['thumbnail_main']);
                                    $thumb_grey = hsc($cat['thumbnail_grey']);
                                } else {
                                    $thumb_main = hsc($cat['thumbnail_small_main']);
                                    $thumb_grey = hsc($cat['thumbnail_small_grey']);
                                }
                                ?>
                                <div class="cs_tw_cat"
                                onmouseover="if (typeof cs_tw_cat_mouseover !== 'undefined') cs_tw_cat_mouseover(this, '<?php echo $thumb_grey ?>', <?php echo $cat_id ?>, <?php echo $i ?>)"
                                onmouseout="if (typeof cs_tw_cat_mouseout !== 'undefined') cs_tw_cat_mouseout(this, '<?php echo $thumb_main ?>', <?php echo $cat_id ?>)"
                                style="height: <?php echo $cat_height ?>px">
                                    <img id="cs_tw_img_<?php echo $cat_id ?>"
                                    src="<?php echo $thumb_main ?>"
                                    alt="<?php echo hsc($cat['name']) ?>">
                                    <?php
                                    /*$preview[] = "preview[$preview_count]="
                                        . str_replace('/', '^', $thumb_grey);
                                    $preview_count++;*/
                                    ?>
                                </div>
                                <?php $i++; ?>
                            <?php endif ?>
                        <?php endforeach ?>
                    </div>
                    <?php foreach ($cats['cats'] as $cat_id => $cat): ?>
                        <?php if (!isset($_SESSION['cs_cats_to_omit'][$cat_id])):
                            if ($instance['thumb_size'] === 'large') {
                                $thumb_main = hsc($cat['thumbnail_main']);
                                $thumb_grey = hsc($cat['thumbnail_grey']);
                            } else {
                                $thumb_main = hsc($cat['thumbnail_small_main']);
                                $thumb_grey = hsc($cat['thumbnail_small_grey']);
                            }
                            ?>
                            <div class="cs_tw_subcats" id="cs_tw_subcats_<?php echo $cat_id ?>"
                            onmouseover="if (typeof cs_tw_subcats_mouseover !== 'undefined') cs_tw_subcats_mouseover(this, <?php echo $cat_id ?>)"
                            onmouseout="if (typeof cs_tw_subcats_mouseout !== 'undefined') cs_tw_subcats_mouseout(this, '<?php echo $thumb_main ?>', <?php echo $cat_id ?>)"
                            style="background: #<?php echo $instance['bg_color'] ?>; border-color: #<?php echo $instance['border_color'] ?>;">
                                <?php foreach ($cat['subcats'] as $sub_id => $subcat): ?>
                                    <!--img src="<?php echo $cs_plugin_url ?>/little_right_arrow.gif" alt=""-->
                                    <img src="https://cbproads.com/wp_plugin_thumb_images/arrow_small.png" alt="">
                                    <?php if (isset($subcat['selected']) && $subcat['selected']): ?>
                                        <strong><?php echo hsc($subcat['name']) ?></strong>
                                    <?php else: ?>
                                        <a href="<?php echo $cat_page, ($cat_page !== '#' ? $sub_id : '') ?>">
                                            <?php echo hsc($subcat['name']) ?></a>
                                    <?php endif ?>
                                    <br />
                                <?php endforeach ?>
                            </div>
                        <?php endif ?>
                    <?php endforeach ?>
                </div>
                <div class="cs_tw_rarrow">
                    <div style="height: <?php echo $cat_height ?>px">
                        <img src="<?php echo $arrow_right ?>" alt=""
                        onclick="if (typeof cs_tw_scroll !== 'undefined') cs_tw_scroll('right', <?php echo ceil(count($cats['cats']) / $thumb_num) ?>)"
                        onmouseover="this.src='<?php echo $arrow_right_hover ?>'"
                        onmouseout="this.src='<?php echo $arrow_right ?>'">
                    </div>
                </div>
            </div>
        </div>
        
        <?php echo $args['after_widget'] ?>
        <?php
    }
    
    // Update Settings //
    function update($new_instance, $old_instance)
    {
        return $new_instance;
    }
    
    // Widget Control Panel //
    function form($instance)
    {
        global $cs_tw_defaults;
        
        $instance = wp_parse_args((array)$instance, $cs_tw_defaults); ?>
        
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>">
                <?php _e('Title') ?>:
            </label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>"
            name="<?php echo $this->get_field_name('title'); ?>"
            type="text" value="<?php echo $instance['title']; ?>" /><br />
            <span class="description">Leave blank to disable</span>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('title_css'); ?>">
                <?php _e('Title CSS Style (Advanced)') ?>:
            </label>
            <input class="widefat" id="<?php echo $this->get_field_id('title_css'); ?>"
            name="<?php echo $this->get_field_name('title_css'); ?>"
            type="text" value="<?php echo $instance['title_css']; ?>" /><br />
            <span class="description">
                Example:
                <span style="font-style: normal; font: 8pt Courier">
                    font: 18pt Georgia; color: #FF44CC;
                </span><br />
                Leave blank to show the title as a normal widget title (using WP theme's style)
            </span>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('thumb_size'); ?>">Thumbnail Size:</label>
            <select id="<?php echo $this->get_field_id('thumb_size'); ?>"
            name="<?php echo $this->get_field_name('thumb_size'); ?>"
            class="widefat" style="width:100%">
                <?php
                $values = array('large' => 'Large', 'small' => 'Small');
                foreach ($values as $val => $text):
                ?>
                    <option value="<?php echo $val ?>" <?php selected($val, $instance['thumb_size']) ?>>
                        <?php echo hsc($text) ?>
                    </option>
                <?php endforeach ?>
            </select>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('thumb_num'); ?>">Show Thumbnails at Once:</label>
            <select id="<?php echo $this->get_field_id('thumb_num'); ?>"
            name="<?php echo $this->get_field_name('thumb_num'); ?>"
            class="widefat" style="width:100%">
                <?php
                $values = array(3 => '3', 4 => '4', 5 => '5', 6 => '6', 7 => '7',
                    8 => '8', 9 => '9', 10 => '10', 11 => '11', 12 => '12');
                foreach ($values as $val => $text):
                ?>
                    <option value="<?php echo $val ?>" <?php selected($val, $instance['thumb_num']) ?>>
                        <?php echo hsc($text) ?>
                    </option>
                <?php endforeach ?>
            </select>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('bg_color'); ?>">
                <?php _e('Subcats Menu BG Color') ?>:
            </label>
            <input class="widefat" id="<?php echo $this->get_field_id('bg_color'); ?>"
            name="<?php echo $this->get_field_name('bg_color'); ?>"
            type="text" value="<?php echo $instance['bg_color']; ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('border_color'); ?>">
                <?php _e('Subcats Menu Border Color') ?>:
            </label>
            <input class="widefat" id="<?php echo $this->get_field_id('border_color'); ?>"
            name="<?php echo $this->get_field_name('border_color'); ?>"
            type="text" value="<?php echo $instance['border_color']; ?>" />
        </p>
        <?php
    }
}








/** Define the Widget as an extension of WP_Widget **/

class cs_top_products_class extends WP_Widget {
    
/*    function cs_top_products_class() {
		
		$widget_ops = array( 'classname' => 'widget_top_products', 'description' => 'Display CB Top/ Featured/ Popular products' );

	
		$control_ops = array( 'id_base' => 'top-products-widget' );

	
		$this->WP_Widget( 'top-products-widget', '&raquo;&raquo; CB Top/ Featured/ Popular Products', $widget_ops, $control_ops );
	}
*/	
	function __construct()
    {
        $widget_top_products_ops = array(
            'classname' => 'cs_top_products_class',
            'description' => 'Display CB Top/ Featured/ Popular products');
            
        $control_top_products_ops = array('id_base' => 'cs_top_products_class');
             parent::__construct(
            'cs_top_products_class',
            '&raquo;&raquo; CB Top/ Featured/ Popular Products',
            $widget_top_products_ops, $control_top_products_ops);
    }
    

	function widget( $args, $instance ) {
		extract( $args );
		$user_id=$_SESSION['cs_user_id'];
		if ($instance['genre']==='trending' ) {
		    $new_title="Top Products";
		    $url='https://cbproads.com/xmlfeed/wp/main/cb_gravity.asp?id='.$user_id. '&no_of_products=5&random=yes&product_ids='.rawurlencode($criteria);
            
		}elseif ($instance['genre']==='popular' ) {
		    $new_title="Popular Products";
		    $url='https://cbproads.com/xmlfeed/wp/main/cb_popular.asp?id='.$user_id. '&no_of_products=5&random=yes&product_ids='.rawurlencode($criteria);
		}elseif ($instance['genre']==='top' ) {
		      $new_title="Featured Products";
		      $url='https://cbproads.com/xmlfeed/wp/main/cb_featured.asp?id='.$user_id. '&no_of_products=5&random=yes&product_ids='.rawurlencode($criteria);
		}
		 $url=$url."&dated=".date('Y-m-d')."&url=".rawurlencode(home_url());
		 
	    if ($_GET['cs_show_url']==='yes'){
		echo $section.' -> '.$url.'<br>'; 
		}
		//$new_title=$instance['genre'];
		$title = apply_filters( 'widget_title', $new_title );
	
	    echo $args['before_widget'];
        //echo '<div style="background:#F0F0F0; border-radius:5px; padding:10px 10px;">';
        echo $before_title . $title . $after_title;
        
        
         $rss = fetch_feed($url);
        if (is_wp_error($rss)) return $empty_answer;
        if (0 == $rss->get_item_quantity(400)) return $empty_answer;
    
        $review_link = cs_get_review_page('', '');
        $items = $rss->get_items(0, 400);
        $cnt=0;
        foreach ($items as $item) {
            
            $paths = $item->get_item_tags(SIMPLEPIE_NAMESPACE_RSS_20, "title");
            $title = htmlspecialchars(cs_cdata($paths[0]['data']));
            
            // URL
            $paths = $item->get_item_tags(SIMPLEPIE_NAMESPACE_RSS_20, "affiliate");
            $mem = cs_cdata($paths[0]['data']);
            $paths = $item->get_item_tags(SIMPLEPIE_NAMESPACE_RSS_20, "ids");
            $tar = cs_cdata($paths[0]['data']);
            $paths = $item->get_item_tags(SIMPLEPIE_NAMESPACE_RSS_20, "niche");
            $niche = cs_cdata($paths[0]['data']);
            $link =  '?memnumber='.$user_id
            . '&mem='.$mem
            . '&tar='.$tar
            . '&niche='.$niche;
            
            // Descriptions
            $paths = $item->get_item_tags(SIMPLEPIE_NAMESPACE_RSS_20, "description");
            $description = htmlspecialchars(cs_cdata($paths[0]['data']));
                    
            $paths = $item->get_item_tags(SIMPLEPIE_NAMESPACE_RSS_20, "images");
            $imageFilename = cs_cdata($paths[0]['data']);
           // $_SESSION['cs_image_size']=330;
            if ($imageFilename != '' && $imageFilename != 'no') {
                $image = 'https://cbproads.com/clickbankstorefront/v4/send_binary.asp'
                    . '?Path=D:/hshome/cbproads/cbproads.com/cbbanners/'
                    . $imageFilename.'&show_border='.$_SESSION['cs_image_border'].'&resize='.$_SESSION['cs_image_size'];
                $image = htmlspecialchars($image);
                $imageFull = 'https://cbproads.com/cbbanners/'.$imageFilename;
                $imageFull = htmlspecialchars($imageFull);
                // $image = htmlspecialchars($imageFull);
            } else {
                unset($image, $imageFull);
            }
            $paths = $item->get_item_tags(SIMPLEPIE_NAMESPACE_RSS_20, "altimage");
            $altimageFilename = cs_cdata($paths[0]['data']);
            if ($altimageFilename != '' && $altimageFilename != 'no' && $imageFilename == 'blank.gif' ) {
                $altimage = 'https://cbproads.com/clickbankstorefront/v4/send_binary.asp'
                    . '?Path=D:/hshome/cbproads/cbproads.com/cbbanners/alter/'
                    . $altimageFilename.'&show_border='.$_SESSION['cs_image_border'].'&resize='.$_SESSION['cs_image_size'];
                $altimage = htmlspecialchars($altimage);
                $altimageFull = 'https://cbproads.com/cbbanners/alter/'. $altimageFilename;
                $altimageFull = htmlspecialchars($altimageFull);
               // $altimage     = htmlspecialchars($altimageFull);
            } else {
                unset($altimage, $altimageFull);
            }
            
            $image_new=(isset($altimage) || isset($image)
                    ? "<!-- star t of image part --><div align=center ><div class=\"cs_image_holder\" align=center style=\"text-align: center\">"
                    . (isset($altimage)
                        ? "<a class=\"cs_image_$count cs_preview\" "
                        . "title=\"".htmlspecialchars($title)."\" "
                        . "href=\"$link\" src=\"$altimageFull\" "
                        . "index=\"cs_image_$count\" rel=\"nofollow\" "
                        . "onclick=\"window.open('$link'); return false\">"
                         . "<img style=\"width: 100%;\" alt=\"cs_image_$count\" src=\"$image\" /></a>\n"
                        
                        : (isset($image)
                            ? "<a class=\"cs_image_$count cs_preview\" "
                            . "title=\"".htmlspecialchars($title)."\" "
                            . "href=\"$link\" src=\"$imageFull\" "
                            . "index=\"cs_image_$count\" rel=\"nofollow\" "
                            . "onclick=\"window.open('$link'); return false\">"
                            . "<img style=\"width: 100%;\" alt=\"cs_image_$count\" src=\"$image\" /></a>\n"
                            : '')
                           
                        )
                    . "</div></div>\n<!-- end of image part -->"
                    : '');
                    
                    
            $paths = $item->get_item_tags(SIMPLEPIE_NAMESPACE_RSS_20, "rank");
            $rank = cs_cdata($paths[0]['data']);
            $paths = $item->get_item_tags(SIMPLEPIE_NAMESPACE_RSS_20, "gravity");
            $gravity = cs_cdata($paths[0]['data']);
            
            if (    ($gravity>200) || ($rank<5) ) {
                $score=5; 
            }elseif (    ($gravity>100) || ($rank<15) ) {
                 $score=4;
            }elseif (    ($gravity>0) || ($rank<30) ) {
                 $score=3;
            }elseif (    ($gravity>0) || ($rank<30) ) {
                 $score=3;
            }else{
                 $score=2;
            }
            
            $cnt=$cnt+1;
            //$score=5;
            echo "<div style='".($cnt%2==1?'backgrounds:#f0f0f0;':'backgrounds:#E0E0E0;'). " margin-top:5px;paddings:2px;padding:7px; margin-bottom:0px; vertical-align:bottom; '>";
            echo "<div style='padding-bottom:10px; display:flex; ".($cnt<5?" border-bottom:1px dotted #F0F0F0;":"")." width:100%;'>";
            
             echo "  <div style='width:30%; '>".$image_new.cs_products_rating($score)."</div>";
             echo "  <div style='width:70%; padding-left:10px; padding-right:0px; '>".
                    "<div style='font-weight:bold; text-transform:Capitalize; padding-top:0px; line-height:1.0em; font-size:1.00em; margin-top:0px; margin-bottom:15px;'>".str_replace("Review","",$title)."</div><p style='font-size:1.0em;'>".substr($description,0,120)."</p>".
                    "</div>";
            
            echo "</div></div>";
           
            
        }
        
        
       // echo "</div>";
        echo $args['after_widget'];
    
        
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags (if needed) and update the widget settings. */
		$instance['genre'] = strip_tags( $new_instance['genre'] );
		$instance['title'] = strip_tags( $new_instance['genre'] );
		return $instance;
}

	function form( $instance ) {

		/* Set up some default widget spopularettings. */
	    $defaults = array( 'genre' => 'popular', 'title'=>'' );
	    $instance = wp_parse_args( (array) $instance, $defaults ); ?>
		 
		<p>
	
	
		<!--<label type="hidden"  for="<?php echo $this->get_field_id( 'title' ); ?>">Title:</label>-->
		<input type="hidden" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
		
		<label for="<?php echo $this->get_field_id( 'genre' ); ?>">Genre:</label>
		<select class="widefat" id="<?php echo $this->get_field_id( 'genre' ); ?>" name="<?php echo $this->get_field_name( 'genre' ); ?>">
		    	    <option value="top"         <?php echo ($instance['genre']==='top'?   'selected' :''); ?> >Top Products</option>
		   			<option value="popular"     <?php echo ($instance['genre']==='popular'?   'selected' :'') ; ?> >Popular Products</option>
		    	    <option value="trending"    <?php echo ($instance['genre']==='trending'?   'selected' :''); ?> >Trending Products</option>
		</select>
		
		</p>
		<?php
	}
}


// Creating the search bar widget 
class cs_widget_search_bar extends WP_Widget {
    
    function __construct()
    {
        $widget_top_products_ops = array(
            'classname' => 'cs_widget_search_bar',
            'description' => 'CB Products Search Bar');
        $control_top_products_ops = array('id_base' => 'cs_widget_search_bar');
             parent::__construct(
            'cs_widget_search_bar',
            '&raquo;&raquo; CB Products Search',
            $widget_top_products_ops, $control_top_products_ops);
    }
    
    function widget( $args, $instance ) {
        
        
        cs_widget_search($args,$instance['cs_show_title'],$instance['cs_show_frame']);
        
        /*
		extract( $args );
		$title = apply_filters( 'widget_title', $instance['title'] );
		global $post;
		if($post->post_parent):
			$children = wp_list_pages("title_li=&child_of=".$post->post_parent."&echo=0&sort_column=menu_order");
		else:
			$children = wp_list_pages("title_li=&child_of=".$post->ID."&echo=0&sort_column=menu_order");
		endif;
		if ($children) {
			echo $before_widget;
			if ( $title ) echo $before_title . $title . $after_title;
			?>
			<ul id="submenu">
			<?php echo $children; ?>
			</ul>
			<?php
			echo $after_widget;
		}
		*/
	}
    
    function update( $new_instance, $old_instance ) {
        
         $instance = $old_instance;
         $instance['cs_show_title'] = strip_tags( $new_instance['cs_show_title'] );
         $instance['cs_show_frame'] = strip_tags( $new_instance['cs_show_frame'] );
        
		 if ($instance['cs_show_title']) {
             $instance['cs_show_frame'] =true;
         }
         
         return $instance;          
    
    }
    
    // Widget Control Panel //
    function form( $instance ) {
        

     
     $cs_show_title = isset( $instance['cs_show_title'] ) ? (bool) $instance['cs_show_title'] : true;
     $cs_show_frame = isset( $instance['cs_show_frame'] ) ? (bool) $instance['cs_show_frame'] : true;
   
    
    ?>
        
        <p>
         
         
         
        <input class="checkbox" type="checkbox" <?php (checked( $cs_show_title )?'checked="checked"':''); ?> id="<?php echo $this->get_field_id( 'cs_show_title' ); ?>" name="<?php echo $this->get_field_name( 'cs_show_title' ); ?>" />
         		
         <label for="<?php echo $this->get_field_id( 'cs_show_title'); ?>">Show Title</label>
         </p>
         
         <p>
         
        <input class="checkbox" type="checkbox" <?php (checked( $cs_show_frame )?'checked="checked"':''); ?> id="<?php echo $this->get_field_id( 'cs_show_frame' ); ?>" name="<?php echo $this->get_field_name( 'cs_show_frame' ); ?>" />
         		
         <label for="<?php echo $this->get_field_id( 'cs_show_frame'); ?>">Show Frame</label>
         </p>

      
        
    <?php 
    }
}    






//===========================================================================================
// Creating the ad widget vertical/horizontal 
class cs_widget_ads_widget extends WP_Widget {
    
    function __construct()
    {
        $widget_adp_ops = array(
            'classname' => 'cs_widget_ads_widget',
            'description' => 'Displays Ads Widget of CB Products');
            
        $control_ads_ops = array('id_base' => 'cs_widget_ads_widget');
             parent::__construct(
            'cs_widget_ads_widget',
            '&raquo;&raquo; CB Text/ Banner Ads',
            $widget_adp_ops, $control_ads_ops);
    }
    
    function widget( $args, $instance ) {
        
		//return $testvalue;
        
        //cs_widget_search($args,$instance['cs_show_ad_orientation'],$instance['cs_show_frame']);
        
        if ($instance['cs_show_ad_orientation']==='V'){
            $cs_t_or="vertical";
        }else{ $cs_t_or="horizontal";}
        
        // $args['before_widget'];
        
        if ($instance['cs_show_ad_frame']){
            echo $args['before_widget'] ;
        }
        
        
        if ($instance['cs_show_ad_title']){
           echo $args['before_title'], "Sponsored Ads",$args['after_title']."";
        }
        
        
        echo cs_show_cb_banner_ads($cs_t_or,1,$instance['cs_show_ad_size'],$instance['cs_show_ad_footer'],$instance['cs_show_http_ads'],$instance['cs_ad_strech'], $instance['cs_ad_alignment'] );
		
        
        if ($instance['cs_show_ad_frame']){
            echo $args['after_widget']; 
        }
        
       
	}
    
    function update( $new_instance, $old_instance ) {
        
         $instance = $old_instance;
         $instance['cs_show_ad_orientation']    = strip_tags( $new_instance['cs_show_ad_orientation'] );
         $instance['cs_show_ad_title']          = strip_tags( $new_instance['cs_show_ad_title'] );
         $instance['cs_show_ad_size']          = strip_tags( $new_instance['cs_show_ad_size'] );
         $instance['cs_show_ad_footer']          = strip_tags( $new_instance['cs_show_ad_footer'] );
         $instance['cs_show_ad_frame']          = strip_tags( $new_instance['cs_show_ad_frame'] );
         $instance['cs_show_http_ads']          = strip_tags( $new_instance['cs_show_http_ads'] );
		 $instance['cs_ad_strech']          	= strip_tags( $new_instance['cs_ad_strech'] );
		 $instance['cs_ad_alignment']          	= strip_tags( $new_instance['cs_ad_alignment'] );
         
         if ($instance['cs_show_ad_title']) {
             $instance['cs_show_ad_frame'] =true;
         }
        
         return $instance;          
    
    }
    
    // Widget Control Panel //
    function form( $instance ) {
        
	
     
    
     $cs_show_ad_orientation =$instance['cs_show_ad_orientation'];
     $cs_show_ad_size =$instance['cs_show_ad_size'];
	 $cs_ad_alignment =$instance['cs_ad_alignment'];
     $cs_show_ad_title = isset( $instance['cs_show_ad_title'] )     ? (bool) $instance['cs_show_ad_title'] : true;
     $cs_show_ad_footer = isset( $instance['cs_show_ad_footer'] )   ? (bool) $instance['cs_show_ad_footer'] : true;
     $cs_show_ad_frame = isset( $instance['cs_show_ad_frame'] )   ? (bool) $instance['cs_show_ad_frame'] : true;
     $cs_show_http_ads = isset( $instance['cs_show_http_ads'] )   ? (bool) $instance['cs_show_http_ads'] : true;
	 $cs_ad_strech 		= isset( $instance['cs_ad_strech'] )   ? (bool) $instance['cs_ad_strech'] : true;
     
   
   
    if (    isset( $instance['cs_show_ad_size'] )  && (strlen($instance['cs_show_ad_size'])>3)   ){
    }else{    $cs_show_selected="";
             $cs_show_selected="selected";
    }
    
    ?>
        
        <p>
         
         <label for="<?php echo $this->get_field_id( 'cs_show_ad_orientation'); ?>">Orientation</label>
         
        <select id="<?php echo $this->get_field_id( 'cs_show_ad_orientation' ); ?>" name='<?php echo $this->get_field_name( 'cs_show_ad_orientation' ); ?>'>
            <option  value=""> </option>
            <option  value="V" <?php echo ($cs_show_ad_orientation==="V"? $cs_show_selected :"") ?>>From all vertical size formats</option>
            <option  value="H" <?php echo ($cs_show_ad_orientation==="H"? $cs_show_selected :"") ?>>From all horizontal size formats</option>
        </select>
       
         </p>
         
         
        <p>
         
         <label for="<?php echo $this->get_field_id( 'cs_show_ad_size'); ?>">Preferred Size</label>
         
        <select id="<?php echo $this->get_field_id( 'cs_show_ad_size' ); ?>" name='<?php echo $this->get_field_name( 'cs_show_ad_size' ); ?>'>
            <option  value=""> </option>
            <option  value="970x250" <?php echo ($cs_show_ad_size==="970x250"? "selected" :"") ?>>970x250</option>
            <option  value="970x90" <?php echo ($cs_show_ad_size==="970x90"? "selected" :"") ?>>970x90</option>
            <option  value="728x90" <?php echo ($cs_show_ad_size==="728x90"? "selected" :"") ?>>728x90</option>
            <option  value="468X60" <?php echo ($cs_show_ad_size==="468X60"? "selected" :"") ?>>468X60</option>
            <option  value="320X100" <?php echo ($cs_show_ad_size==="320X100"? "selected" :"") ?>>320X100</option>
            
            
            <option  value="120X600" <?php echo ($cs_show_ad_size==="120X600"? "selected" :"") ?>>120X600</option>
            <option  value="160X600" <?php echo ($cs_show_ad_size==="160X600"? "selected" :"") ?>>160X600</option>
            <option  value="300X600" <?php echo ($cs_show_ad_size==="300X600"? "selected" :"") ?>>300X600</option>
            
            <option  value="336X280" <?php echo ($cs_show_ad_size==="336X280"? "selected" :"") ?>>336X280</option>
            <option  value="300X250" <?php echo ($cs_show_ad_size==="300X250"? "selected" :"") ?>>300X250</option>
            <option  value="250X250" <?php echo ($cs_show_ad_size==="250X250"? "selected" :"") ?>>250X250</option>
            <option  value="125X125" <?php echo ($cs_show_ad_size==="125X125"? "selected" :"") ?>>125X125</option>
            
            <option  value="120X60" <?php echo ($cs_show_ad_size==="120X60"? "selected" :"") ?>>120X60</option>
            <option  value="120X240" <?php echo ($cs_show_ad_size==="120X240"? "selected" :"") ?>>120X240</option>
            <option  value="234X60" <?php echo ($cs_show_ad_size==="234X60"? "selected" :"") ?>>234X60</option>
            <option  value="320x50" <?php echo ($cs_show_ad_size==="320x50"? "selected" :"") ?>>320x50</option>

            
        </select>
       
         </p>
         
         
         <p>
         
        <input class="checkbox" type="checkbox" <?php (checked( $cs_show_ad_title )?'checked="checked"':''); ?> id="<?php echo $this->get_field_id( 'cs_show_ad_title' ); ?>" name="<?php echo $this->get_field_name( 'cs_show_ad_title' ); ?>" />
         		
         <label for="<?php echo $this->get_field_id( 'cs_show_ad_title'); ?>">Show Title</label>
         </p>
         
          <p>
         
        <input class="checkbox" type="checkbox" <?php (checked( $cs_show_ad_footer )?'checked="checked"':''); ?> id="<?php echo $this->get_field_id( 'cs_show_ad_footer' ); ?>" name="<?php echo $this->get_field_name( 'cs_show_ad_footer' ); ?>" />
         		
         <label for="<?php echo $this->get_field_id( 'cs_show_ad_footer'); ?>">Show Footer</label>
         </p>
         
         <p>
         
        <input class="checkbox" type="checkbox" <?php (checked( $cs_show_ad_frame )?'checked="checked"':''); ?> id="<?php echo $this->get_field_id( 'cs_show_ad_frame' ); ?>" name="<?php echo $this->get_field_name( 'cs_show_ad_frame' ); ?>" />
         		
         <label for="<?php echo $this->get_field_id( 'cs_show_ad_frame'); ?>">Show in Widget Frame</label>
         </p>
         
        <p>
         
        <input class="checkbox" type="checkbox" <?php (checked( $cs_show_http_ads )?'checked="checked"':''); ?> id="<?php echo $this->get_field_id( 'cs_show_http_ads' ); ?>" name="<?php echo $this->get_field_name( 'cs_show_http_ads' ); ?>" />
         		
         <label for="<?php echo $this->get_field_id( 'cs_show_http_ads'); ?>">Show HTTP Ads</label>
         </p>
        

		<p>
         
        <input class="checkbox" type="checkbox" <?php (checked( $cs_ad_strech )?'checked="checked"':''); ?> id="<?php echo $this->get_field_id( 'cs_ad_strech' ); ?>" name="<?php echo $this->get_field_name( 'cs_ad_strech' ); ?>" />
         		
         <label for="<?php echo $this->get_field_id( 'cs_ad_strech'); ?>">Strech to Container</label>
        		
         
        <p>
         
         <label for="<?php echo $this->get_field_id( 'cs_ad_alignment'); ?>">Align</label><?php $cs_show_selected="selected"?>
         
        <select id="<?php echo $this->get_field_id( 'cs_ad_alignment' ); ?>" name='<?php echo $this->get_field_name( 'cs_ad_alignment' ); ?>'>
            <option  value=""> </option>
            <option  value="L" <?php echo ($cs_ad_alignment==="L"? $cs_show_selected :"") ?>>Left</option>
            <option  value="R" <?php echo ($cs_ad_alignment==="R"? $cs_show_selected :"") ?>>Right</option>
			<option  value="M" <?php echo ($cs_ad_alignment==="M"? $cs_show_selected :"") ?>>Middle</option>
        </select>
       
         </p>
         
         	
        
         

      
        
    <?php 
    }
    
}    
///////////////////////////////////////////////////////////////




function cs_widget_horizontal_cats_display($before_title, $after_title){
    
    $turn_html= "<div id='cs_column_horizontal_cats_id' style=\"width:100%; margin-top:40px; backgrounds:#f5f5f5;\">\n";
    
     if (    strlen($before_title)<3 ){
        $pad_color=(strlen($_SESSION['cs_primary_color'])>2 ? $_SESSION['cs_primary_color']: '#808080');
       // $turn_html.= '<div style="margin-tops:35px; ">Catalog / Categories</div><!-- end of title-->';
     }else{
          //$turn_html.= $before_title.'Sub Categories'.$after_title;
     }
    
    $cats = cs_get_categories();
    
    // Link to category page
    $cat_page = cs_get_products_page('cs_category', '');
    
    
    
    $cats_per_column = 72;
    $columns = 4;
    
    $i = 0;
    $cols = 0;
    $first = true;
   // $turn_html.= "<div id='cs_column_horizontal_cats_id' style=\"width: 100%;\">\n";
    foreach ($cats['cats'] as $cat_id => $cat) {
        if (!isset($_SESSION['cs_cats_to_omit'][$cat_id])) {
            if ($i >= $cats_per_column) {
                $turn_html.= "</div>\n";
                $cols++;
            }
            if ($first ||
                $i >= $cats_per_column && $cols % $columns === 0)
            {
                if ($cols !== 0) $turn_html.=  "</div>\n<br />\n";
                $turn_html.=  "<div style=\"display: flex; padding-left:15px; flex-wrap: wrap; vertical-align: top; text-align: center; width: 100%; margin-bottom: 1em;\">\n";
            }
            if ($first || $i >= $cats_per_column) {
                $turn_html.=  "<div class='cs_column_horizontal_cats' style=\"position: initial; padding-right: 1em; text-align: left;\">\n";
                
                $i = 0;
                
            }
            if ($first) $first = false;
            
            if (    strlen($before_title)<3 ){
                    $turn_html.='<br><h6 style="margin-top:0px; color:'.$_SESSION["cs_primary_color"].'">'.htmlspecialchars($cat['name']).'</h6><hr>';
            }else{
                    $turn_html.=  $before_title. htmlspecialchars($cat['name']). $after_title."<br />\n";
            }
            
            $i += 2;
            
            foreach ($cat['subcats'] as $sub_id => $subcat) {
                $name_html = htmlspecialchars($subcat['name']);
                
                if (isset($subcat['selected']) && $subcat['selected']) {
                    $turn_html.=  "&raquo; $name_html";
                } else {
                    $turn_html.=  "<a style='text-decoration:none;font-size:0.92em;' href=\"$cat_page". ($cat_page !== '#' ? $sub_id : ''). "&cs_temp_main_category=".$cat_id. "\">$name_html</a>";
                   
                }
                $turn_html.=  "<br />\n";
                
                $i++;
            }
        }
		$turn_html.=  "<br /><br />\n";
    }
    $turn_html.=  "</div>\n  </div>\n </div>\n";
    return $turn_html;
}
function cs_widget_horizontal_cats_display_shortcode(){
     
 return cs_widget_horizontal_cats_display('','');
 //return ' iam from shotcode';
}

function cs_ads_shortcode($attr){
	
	$args = shortcode_atts( array(
     
            'size' => '728x90',
            'strech' => false,
            'align' => 'L'
 
        ), $attr );
     
 return cs_show_cb_banner_ads('horizontal',1,$args['size'],false,true,$args['strech'],$args['align']);
 //cs_show_cb_banner_ads($cs_t_or,1,$instance['cs_show_ad_size'],$instance['cs_show_ad_footer'],$instance['cs_show_http_ads'], strech, alignment);
 }



?>