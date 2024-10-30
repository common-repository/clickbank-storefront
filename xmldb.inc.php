<?php

if (!defined('ABSPATH')) require_once '../../../wp-config.php';
include_once ABSPATH.WPINC.'/feed.php';

/**
* Add plugin options into WP
* 
* @param array $options
* @param array $ad_options
*/
function cs_add_options_to_db($options, $ad_options)
{
    global $wpdb;
    
    foreach ($options as $oname => $o) {
        update_option($oname, $wpdb->escape($o['default']));
       
    }
    // Advanced
    foreach ($ad_options as $oname => $o) {
        update_option($oname, $wpdb->escape($o['default']));
    }
}

/**
* Get site's domain name from Wordpress Address setting
*/
function cs_get_site_domain()
{
    static $domain = null;
    
    if ($domain === null) {
        $domain = substr(site_url('', 'http'), 7);
        if (false !== ($tmp = strpos($domain, '/'))) {
            $domain = substr($domain, 0, $tmp);
        }
    }
    
    return $domain;
}

/**
* Get URL with params (orig. URL can be with params already)
* 
* @param mixed $url
* @param mixed $params
*/
function cs_get_url($url, $params)
{
    $pos_q = strrpos($url, '?');
    if ($pos_q !== false) $url .= '&';
    else $url .= '?';
    
    foreach ($params as $k => &$v) {
        $v = rawurlencode($k).'='.rawurlencode($v);
    }
    $url .= implode('&', $params);
    
    return $url;
}

/**
* Get products page setting or '#'
*/
function cs_get_products_page($param_name = '', $param_val = '')
{
    /*
    #$page = get_option('cs_products_page');
    $page = $_SESSION['cs_products_page'];
    //http://icoreweb.com/twenty-twenty/index.php/clickbank-storefront-products/
   // echo $page;
    //change started////
    $found_post = null;

    if ( $posts = get_posts( array( 
        'name' => 'cs_product_categories', 
        'post_type' => 'page',
        'post_status' => 'publish',
        'posts_per_page' => 1
    ) ) ) $found_post = $posts[0];
    
    
    if (  !is_null( $found_post ) ){
        $page=get_permalink($posts[0]->ID);
    }
    //change ended////
    */
		global $wpdb;
	$sql="SELECT * FROM ". $wpdb->prefix."posts WHERE post_type='page' and  post_content like'%[clickbank-storefront-products%' and post_status='publish'";
				
	$result = $wpdb->get_results( $sql );
	$count_posts	=	intval(	count($result)	);
	//echo $count_posts."<br>";
	if ($count_posts >0 ) {
		//$post_id	=	$result[0]->ID;
		$page=get_permalink($result[0]->ID);
		//echo $result[1]->ID." - ". $result[1]->post_type."<br>";
	}else{$page='';}
	//echo $page;
	
    if ($page === '') {
        $page = '#';
    } else if ($param_name != '') {
        $pos_q = strrpos($page, '?');
        if ($pos_q !== false) $page .= '&';
        else $page .= '?';
        
        $page .= $param_name.'='.$param_val;
    }
    



    return $page;
}

function cs_get_review_page($param_name = '', $param_val = '')
{
	//echo 'yasar';
   /*
    $page = get_option('cs_products_page');
    $page = $_SESSION['cs_review_page'];
    
	
    if ( $posts = get_posts( array( 
        //'name' => 'cs_product_reviews', 
		'content'=> '[clickbank-product-review-details]',
        'post_type' => 'page',
        'post_status' => 'publish',
        'posts_per_page' => 1
    ) ) ) $found_post = $posts[0];
    
    // Now, we can do something with $found_post
    if (  !is_null( $found_post ) ){
        $page=get_permalink($posts[0]->ID);
    }
	*/


	global $wpdb;
	$sql="SELECT * FROM ". $wpdb->prefix."posts WHERE post_type='page' and  post_content like'%[clickbank-product-review-details%' and post_status='publish'  ";
				
	$result = $wpdb->get_results( $sql );
	$count_posts	=	intval(	count($result)	);
	//echo $count_posts."<br>";
	if ($count_posts >0 ) {
		//$post_id	=	$result[0]->ID;
		$page=get_permalink($result[0]->ID);
		//echo $result[1]->ID." - ". $result[1]->post_type."<br>";
	}else{$page='';}
	//echo $page."<br>";

    if ($page === '') {
        $page = '#';
    } else if ($param_name != '') {
        $pos_q = strrpos($page, '?');
        if ($pos_q !== false) $page .= '&';
        else $page .= '?';
        
        $page .= $param_name.'='.$param_val;
    }
    

    return $page;
    
}



function cs_products_review_rating($rating){
    
        //$rating=5;
        
     $cs_rating_color="#eb7823";
     $cs_rating_dim_color="#E8E8E8";
     
     $star      =   "<i class=\"fa fa-star\" style=\"font-size:16px;color:".$cs_rating_color ."\"></i>";
     $star_dim  =   "<i class=\"fa fa-star\" style=\"font-size:16px;color:".$cs_rating_dim_color ."\"></i>";
     
     for ($x = 0; $x <= $rating-1; $x++) {
      $star_plus.=$star;
    } 
    
    for ($x = 0; $x <=4- $rating; $x++) {
      $star_plus.=$star_dim;
    } 
    
    return "<div align=\"center\">".$star_plus."</div>";
    
    /*
    return "<div align=\"center\"><i class=\"fa fa-star\" style=\"font-size:18px;color:".$cs_rating_color ."\"></i>".
     "<i class=\"fa fa-star\" style=\"font-size:18px;color:".$cs_rating_color ."\"></i>".
     "<i class=\"fa fa-star\" style=\"font-size:18px;color:".$cs_rating_color ."\"></i>".
     "<i class=\"fa fa-star\" style=\"font-size:18px;color:".$cs_rating_color ."\"></i>".
     "<i class=\"fa fa-star\" style=\"font-size:18px;color:".$cs_rating_color ."\"></i></div>";*/
}

function cs_products_rating($rating){
   //$rating=3;
        $font_size=(substr($_SESSION['cs_display_layout'],0,1)>2 ?'13':'14');
        
        $cs_rating_color=$_SESSION['cs_primary_color'];
        $cs_rating_color="orange";
        $cs_rating_color_dim="#E8E8E8";
        ($_SESSION['cs_image_descr_layout']=='horizontal'? $alignn='right' : $alignn='center');
        
        
             $star      =   "<i class=\"fa fa-star\" style=\"font-size:".$font_size."px;color:".$cs_rating_color ."\"></i>";
             $star_dim  =   "<i class=\"fa fa-star\" style=\"font-size:".$font_size."px;color:".$cs_rating_color_dim ."\"></i>";
             
             for ($x = 0; $x <= $rating-1; $x++) {
              $star_plus.=$star;
            } 
            
            for ($x = 0; $x <=4- $rating; $x++) {
              $star_plus.=$star_dim;
            } 
            
        return "<div align=".$alignn." style=\"letter-spacing:4px; margin-bottom:20px; text-align: center;  margin-left: auto;    margin-right: auto;\">".$star_plus."</div>";
        
        /*return "<div align=".$alignn." style=\"letter-spacing:3px; margin-bottom:0px; \">"
                .(($section === '1bestselling')  || ($section === '1featured')  ||($section === 'popular')  
                    ?   
                         "<i class=\"fa fa-star\" style=\"font-size:16px;color:".$cs_rating_color ."\"></i>"
                        . "<i class=\"fa fa-star\" style=\"font-size:16px;color:".$cs_rating_color."\"></i>"
                        . "<i class=\"fa fa-star\" style=\"font-size:16px;color:".$cs_rating_color."\"></i>"
                        . "<i class=\"fa fa-star\" style=\"font-size:16px;color:".$cs_rating_color ."\"></i>"
                        . "<i class=\"fa fa-star\" style=\"font-size:16px;color:".$cs_rating_color ."\"></i>"
                        
                    :
                         "<i class=\"fa fa-star\" style=\"font-size:16px;color:".$cs_rating_color ."\"></i>"
                        . "<i class=\"fa fa-star\" style=\"font-size:16px;color:".$cs_rating_color ."\"></i>"
                        . "<i class=\"fa fa-star\" style=\"font-size:16px;color:".$cs_rating_color ."\"></i>"
                        . ( (($rank < 6 ) && ($gravity >11) )
                            ?     "<i class=\"fa fa-star\" style=\"font-size:16px;color:".$cs_rating_color ."\"></i>"
                                  ."<i class=\"fa fa-star\" style=\"font-size:16px;color:".$cs_rating_color ."\"></i>"
                            :
                                 (  (($rank < 6 ) || ($gravity >11))
                                 ?  "<i class=\"fa fa-star\" style=\"font-size:16px;color:".$cs_rating_color .";\"></i>"
                                    . "<i class=\"fa fa-star\" style=\"font-size:16px; color:".$cs_rating_color_dim.";\"></i>"
                                 :
                                      "<i class=\"fa fa-star\" style=\"font-size:16px; color".$cs_rating_color_dim.";\"></i>"
                                     . "<i class=\"fa fa-star\" style=\"font-size:16px; color".$cs_rating_color_dim.";\"></i>"
                                 )
                            )
                    )
            ."</div>";*/
                    //.( $_SESSION['cs_show_price'] == '1' && $price != '' ?'':''.                      
                     //   ($_SESSION['cs_view_more_style'] == 'button' ?'<br>&nbsp;':'')
                      //  );
}
function cs_price_view_more_similar_details($price){
        
            return ""
                   // ."\n<div  align=center style=\"border:0px solid silver; padding:3px; padding-top:15px; display:inline-block; width:100%;\"><!-- start of  price and view more box-->\n"
                  //  . "     <div style=\"float:left; width:38%; \"> \n"
                    .( $_SESSION['cs_show_price'] == '1' && $price != ''
                    ? "             <div class=\"cs_show_price\" style=\" border:0px solid #dcdcdc; border-radius:5px; color:". $_SESSION['cs_label_color']  .";  \" > \$".number_format($price,2)."</div>\n"
                    
                    : '             ');
           
                 
               
                
                 
                 
            
}

function cs_image_show_box($altimage,$image,$title,$count,$imageFull,$altimageFull,$link,$section){
    //return "yasar";
    //incase you wnat to enable image preview, please remove yes
    $cs_show_img_preview="yes";
    if ($cs_show_img_preview==="yes"){
            $cs_show_img_preview="cs_preview";
    }
  //  echo 'image: '.$image.'<br>';
  //  echo 'alt: '.$altimage.'<br>';
       return   ( isset($altimage) || isset($image) 
                ? "<div class=\"cs_image_holder\" align=center style=\" text-align: center; ". ($_SESSION['cs_image_descr_layout']=='horizontal' ? "float:left;width:48%;" : '' ) ."\" >"
                		. (isset($altimage)
                        ? "<a class=\"cs_image_$count $cs_show_img_preview\" "
                        . "title=\"".htmlspecialchars($title)."\" "
                        . "href=\"$link\" src=\"$altimageFull\" "
                        . "index=\"cs_image_$count\" rel=\"nofollow\" "
                        . "onclick=\"window.open('$link'); return false\">"
                         . "<img class=\"cbpro_img_render\" style=\"".($_SESSION['cs_image_border_style']==="rounded"?'border-radius:50%;border:2px dotted silver; ':'')."  widths: 100%;\" alt=\"cs_image_$count\" src=\"$image\" /></a>\n"
                        
                        : (isset($image)
                            ? "<a class=\"cs_image_$count $cs_show_img_preview\" "
                            . "title=\"".htmlspecialchars($title)."\" "
                            . "href=\"$link\" src=\"$imageFull\" "
                            . "index=\"cs_image_$count\" rel=\"nofollow\" "
                            . "onclick=\"window.open('$link'); return false\">"
                            . "<img class=\"cbpro_img_render\" style=\"".($_SESSION['cs_image_border_style']==="rounded"?'border-radius:50%;border:2px dotted silver; ':'')."  widths: 100%;\" alt=\"cs_image_$count\" src=\"$image\" /></a>\n"
                            : '')
                           
                        )
                                      
                  ."</div>"
                  
                : "<div class=\"cs_image_holder\"></div>"
                );
            
}

function cs_products_description($cur_view,$description,$tirm_mdescr,$section,$show_more_link,$read_review){
    //this fucntion has been discountinued
   // echo $cur_view;
    $question = substr(trim($description), -1); 
    if ($question != '.') { $description.= '.'; } 
    
    $view_similar=(   (($section==='supplement') || ($section==='bestselling') || ($section==='featured') || ($section==='popular'))  && ($_SESSION['cs_switch_view'] ==='tdli')
                                                                              ?"<br><a href='$show_more_link'  style='text-decoration:none; margin-right:4px; margin-top:3px; margin-bottom:3px; font-size:12px;color:#dcdcdc;' tagrget='_blank'><i class='fa fa-eye' aria-hidden='true' style='font-size:12px;color:#dcdcdc;'></i> Similar Products</a>  "
                                                                              :''
                                                                             );

    return  ($_SESSION['cs_image_descr_layout']=='horizontal'
                ? "<div style=\"float:right; padding-top:10px; width:47%; border:0px solid silver;\">"
                : ""
            )
            
            .(($cur_view === 'tdi')
                    
                    
                        
                        ? (get_option('cbproads_premium_store')?"":"<br><br><br>"). "\n"
                        
                          : "<p  style='padding-top:7px;  font-size:0.95em; color:#808080; margin:10px;  text-align:left; text-align:left; color:#808080;  overflow: hidden;    text-overflow: ellipsis;   display: -webkit-box;   -webkit-line-clamp: 3; /* number of lines to show */           line-clamp: 3;    -webkit-box-orient: vertical;' />".
                                            ucwords(strtolower($description)). "</p>".(get_option('cbproads_premium_store')?"":"<br>")
                                            ."\n"
            )
            
            
            
           // . cs_products_rating($section)   
            
            .($_SESSION['cs_image_descr_layout']=='horizontal'
                ? "</div><div style=\"clear: both;\"></div>"
                : ""
            );
}
/**
* Get products from the XML feed
* 
* @param int $user_id
* @param int $user_id
* @param int $criteria
* @param int $items_per_page
* @param int $page
* @param bool $include_css_js
* @return array
*/
function cs_get_items($section, $user_id, $criteria = null, $items_per_page,
    $page = 1, $get_mcat,$get_scat, $include_css_js = false)
{
    
    

    if (isset($_SESSION['cs_home_page_cats']) ){
        $home_page_cats=($_SESSION['cs_home_page_cats']);
        
        
       if (	(is_array($home_page_cats)) && (	sizeof($home_page_cats)>0)		){
           foreach($home_page_cats as $x => $x_value) {
            $home_page_cat= "-" . $x .$home_page_cat;
            }
       }


       $home_page_cat=ltrim($home_page_cat, '-');
       // echo sizeof($home_page_cats)."NEWVALUE<br>";
    }
    
    
    if ($section === 'main_category') {
        $url = 'https://cbproads.com/xmlfeed/wp/main/cb_category_code.asp'
            . '?id='.$user_id
            . ($criteria != '' ? '&main_category_cd='.$criteria : '')
            . '&start='.(($page-1) * $items_per_page)
            . '&end='.$items_per_page
            . '&rank='.$_SESSION['cs_rank']
            . '&gravity='.$_SESSION['cs_gravity']
            . '&sortby='.(isset($_SESSION['cs_sortby']) ? $_SESSION['cs_sortby'] : 'rank');
        $cur_view = $_SESSION['cs_switch_view'];
        $show_more_link = false;
        //echo $url;
       
    } elseif ($section === 'related_products') {
        $url = 'https://cbproads.com/xmlfeed/wp/main/cb_category_code.asp'
            . '?s=d&id='.$user_id
            . ($criteria != '' ? '&main_category_cd='.$criteria : '')
            . '&start=0'
            . '&end='. str_replace(" columns","",$_SESSION['cs_display_layout'])
            . '&rank='.$_SESSION['cs_rank']
            . '&gravity='.$_SESSION['cs_gravity']
            . '&sortby='.(isset($_SESSION['cs_sortby']) ? $_SESSION['cs_sortby'] : 'rank');
        $cur_view = $_SESSION['cs_switch_view'];
        $show_more_link = false;
      //echo $url;  
    } elseif ($section === 'category') {
        $url = 'https://cbproads.com/xmlfeed/wp/main/cb_category_code.asp'
            . '?id='.$user_id
            . ($criteria != '' ? '&category_cd='.$criteria : '')
            . '&start='.(($page-1) * $items_per_page)
            . '&end='.$items_per_page
            . '&rank='.$_SESSION['cs_rank']
            . '&gravity='.$_SESSION['cs_gravity']
            . '&sortby='.(isset($_SESSION['cs_sortby']) ? $_SESSION['cs_sortby'] : 'rank');
        $cur_view = $_SESSION['cs_switch_view'];
        $show_more_link = false;
        
    } elseif ($section === 'search') {
        $url = 'https://cbproads.com/xmlfeed/wp/main/cb_search.asp'
            . '?id='.$user_id
            . '&keywords='.rawurlencode($criteria)
            . '&start='.(($page-1) * $items_per_page)
            . '&end='.$items_per_page;
        $cur_view = $_SESSION['cs_switch_view'];
        $show_more_link = false;
    } elseif ($section === 'bestselling') {
        $url = 'https://cbproads.com/xmlfeed/wp/main/cb_gravity.asp'
            . '?id='.$user_id
            . '&no_of_products='.$items_per_page
            . '&cat_filter='.$home_page_cat;
           
        $cur_view = $_SESSION['cs_switch_view'];
        $show_more_link = true;
    } elseif ($section === 'featured') {
        $url = 'https://cbproads.com/xmlfeed/wp/main/cb_featured.asp'
            . '?id='.$user_id
            . '&no_of_products='.$items_per_page
            . '&product_ids='.rawurlencode($criteria)
            . '&cat_filter='.$home_page_cat;
        $cur_view = $_SESSION['cs_switch_view'];
        $show_more_link = true;
    } elseif ($section === 'popular') {
        $url = 'https://cbproads.com/xmlfeed/wp/main/cb_popular.asp'
            . '?id='.$user_id
            . '&no_of_products='.$items_per_page
            . '&cat_filter='.$home_page_cat;
        $cur_view = $_SESSION['cs_switch_view'];
        $show_more_link = true;
    }
    elseif ($section === 'supplement') {
        $url = 'https://cbproads.com/xmlfeed/wp/main/cb_supplement.asp'
            . '?id='.$user_id
            . '&no_of_products='.$items_per_page
            . '&cat_filter='.$home_page_cat;
        $cur_view = $_SESSION['cs_switch_view'];
        $show_more_link = true;
    }
     elseif ($section === 'reviews') {
                if (strlen($_SESSION['cs_reviews_show_cats'])>5){
                    $tmcat=substr ( $_SESSION['cs_reviews_show_cats'],   0,  strpos($_SESSION['cs_reviews_show_cats'],">")       );
                }else
                {
                    $tmcat=$get_mcat;
                }
                
        $url = 'https://cbproads.com/xmlfeed/wp/main/cb_reviews.asp'
            . '?id='.$user_id
             . '&mcat='.$tmcat
            . '&no_of_products=6';//.(intval($items_per_page)-0);
        
        $cur_view = $_SESSION['cs_switch_view'];
        $show_more_link = true;
    } elseif ($section === 'review-single') {
        $url = 'https://cbproads.com/xmlfeed/wp/main/cb_reviews.asp'
            . '?id='.$user_id
            . '&cs_review_id='.$_GET['cs_review_id'];
        $cur_view = $_SESSION['cs_switch_view'];
        $show_more_link = true;
         
     }elseif ($section === 'review-details') {
         
            if($criteria==='related-reviews'){
                
               $url = 'https://cbproads.com/xmlfeed/wp/main/cb_reviews.asp'
                    . '?id='.$user_id
                    . '&start='.(($page-1) * $items_per_page)
                    . '&end='.$items_per_page
                    . '&mcat='.$_GET['cs_mcat'];
                    
            }else{     
                if (strlen($_SESSION['cs_reviews_show_cats'])>5){
                    $tmcat=substr ( $_SESSION['cs_reviews_show_cats'],   0,  strpos($_SESSION['cs_reviews_show_cats'],">")       );
                }else
                {
                    $tmcat=$get_mcat;
                }
                //$items_per_page=6;
                $url = 'https://cbproads.com/xmlfeed/wp/main/cb_reviews.asp'
                    . '?id='.$user_id
                    . ($criteria != '' ? '&category_cd='.$criteria : '')
                    . '&start='.(($page-1) * $items_per_page)
                    . '&end='.$items_per_page
                    . '&mcat='.$tmcat
                    . '&scat='.$get_scat
                    . '&cs_review_id='.$_GET['cs_review_id'];
                  
            }
        $cur_view = $_SESSION['cs_switch_view'];
        $show_more_link = false;
    }
   // echo $url;
    //die();
   
    // Answer when there is nothing to show
    if ($section === 'search') {
        $empty_answer = array('posts' => array(), 'totalp' => 0);
    } else {
        $empty_answer = array(
            'posts' => array(
                array(
                    'post_title' => cs_product_title_fmt('Sorry', '#', $include_css_js),
                    'post_content' => 'No products in this list yet!')),
            'totalp' => 1);
    }
//die($url.$section);
    $url=$url."&Datem=".date('Y-m-d')."&url=".rawurlencode(home_url());
    
    if ($_GET['cs_show_url']==='yes'){

		echo $section.' -> '.$url.'<br>'; 

	}
   //echo $url; 
    // Load data
    //$doc = new DOMDocument();
    $rss = fetch_feed($url);
	if ( is_wp_error( $rss ) ) {
    // If the request has failed, show the error message
		echo "Error:".$rss->get_error_message();
	}
    if (is_wp_error($rss)) return $empty_answer;
    //if (false === @$doc->load($url)) return $empty_answer;
    //$items = $doc->getElementsByTagName('item');
    //if (0 === $items->length) return $empty_answer;
    if (0 == $rss->get_item_quantity(400)) return $empty_answer;

    //$totalp = cs_cdata(
    //    $items
    //    ->item(0)->getElementsByTagName('totalp')
    //    ->item(0)->nodeValue
    //);
    $tmp = $rss->get_item()->get_item_tags(SIMPLEPIE_NAMESPACE_RSS_20, 'totalp');
    $totalp = cs_cdata($tmp[0]['data']);
    $cat_link = cs_get_products_page('cs_category', '');
    $review_link = cs_get_review_page('', '');
    
    $review_link_final=$review_link;
//echo $review_link;

    $count = 0;
    $item_list = array();
    $items = $rss->get_items(0, 400);
   // var_dump($items);
    foreach ($items as $item) {
        //$cnt=$cnt+1;
     //   echo "Total:".$totalp;   
        // Title
        $paths = $item->get_item_tags(SIMPLEPIE_NAMESPACE_RSS_20, "title");
        $title = htmlspecialchars(cs_cdata($paths[0]['data']));
        
        $paths = $item->get_item_tags(SIMPLEPIE_NAMESPACE_RSS_20, "review_yes_no");
        $review_available=htmlspecialchars(cs_cdata($paths[0]['data']));
        
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
        $paths = $item->get_item_tags(SIMPLEPIE_NAMESPACE_RSS_20, "mdescr");
        $mdescr = htmlspecialchars(cs_cdata($paths[0]['data']));
        ( (strlen($mdescr)>180 && $_SESSION['cs_image_descr_layout']!='horizontal') 
                        ?($tirm_mdescr=substr($mdescr,0,180)."..." )  
                        :($tirm_mdescr=$mdescr )
                      );
        
        $review_header = $item->get_item_tags(SIMPLEPIE_NAMESPACE_RSS_20, "header_image");
        $review_image = cs_cdata($review_header[0]['data']);
        
        $mcats = $item->get_item_tags(SIMPLEPIE_NAMESPACE_RSS_20, "mcat");
        $mcat = cs_cdata($mcats[0]['data']);
        
        $mcatcode = $item->get_item_tags(SIMPLEPIE_NAMESPACE_RSS_20, "mccode");
        $mcatcd = cs_cdata($mcatcode[0]['data']);
        
        $scatcode = $item->get_item_tags(SIMPLEPIE_NAMESPACE_RSS_20, "sccode");
        $scatcd = cs_cdata($scatcode[0]['data']);
        
        $scats = $item->get_item_tags(SIMPLEPIE_NAMESPACE_RSS_20, "scat");
        $scat = cs_cdata($scats[0]['data']);
        
        $pdates = $item->get_item_tags(SIMPLEPIE_NAMESPACE_RSS_20, "pdate");
        $pdate = cs_cdata($pdates[0]['data']);
        
        $sbtitle = $item->get_item_tags(SIMPLEPIE_NAMESPACE_RSS_20, "sub_title");
        $stitle = cs_cdata($sbtitle[0]['data']);
        
         $review_desc = $item->get_item_tags(SIMPLEPIE_NAMESPACE_RSS_20, "description");
        $review_descr = cs_cdata($review_desc[0]['data']);
        
        $review_link_final=htmlspecialchars(cs_get_review_page('', ''))
            . '?memnumber='.$user_id
            . '&mem='.$mem
            . '&cs_review_id='.$tar
            . '&cs_mcat='.$mcatcd;
        // Images
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
        
        // Price
        $paths = $item->get_item_tags(SIMPLEPIE_NAMESPACE_RSS_20, "price");
        $price = htmlspecialchars(cs_cdata($paths[0]['data']));
        
        // Content
        $contents = $item->get_item_tags(SIMPLEPIE_NAMESPACE_RSS_20, "content");
        $contentr = htmlspecialchars(cs_cdata($contents[0]['data']));
        
      
     //die($contentr.$section);   
        // Rank & Gravity
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
       // echo 'gr: '. $gravity.' rank: '. $rank.' - '.$score.'<br>';
       
        if ($show_more_link) {
            // Category
            $paths = $item->get_item_tags(SIMPLEPIE_NAMESPACE_RSS_20, "category");
            $category = cs_cdata($paths[0]['data']);
        }
        
        // Add record
        $list_item = array('target_url' => $link,
            'post_title' => cs_product_title_fmt($title, $link, $include_css_js));
            
              //  echo '<h1>aadsdsds</h1>'.$cur_view;
			//	exit;
				
            // str_replace(" ","&nbsp; ",str_pad($title, 40, " ", STR_PAD_RIGHT))
        if (($cur_view === 'ti') &&( ($section != 'reviews') && ($section != 'review-details') && ($section != 'review-single')) ){
            
            $list_item['review_url'] = $review_link_final;
            $list_item['read_review'] = $review_available;
            $list_item['show_more_link'] =    $cat_link.$category.'&cs_temp_main_category='.$mcatcd;                  
            $list_item['descr'] =    $description;   
            $list_item['score'] =    $score;
            $list_item['price'] =    $price;
             $list_item['link'] =    $link;
            $list_item['post_content'] =
                (isset($altimage) || isset($image)
                    ? "<div align=center ><div class=\"cs_image_holder\" align=center style=\"text-align: center\">"
                    . (isset($altimage)
                        ? "<a class=\"cs_image_$count cs_preview\" "
                        . "title=\"".htmlspecialchars($title)."\" "
                        . "href=\"$link\" src=\"$altimageFull\" "
                        . "index=\"cs_image_$count\" rel=\"nofollow\" "
                        . "onclick=\"window.open('$link'); return false\">"
                         . "<img class=\"cbpro_img_render\" style=\"width: 100%;\" alt=\"cs_image_$count\" src=\"$image\" /></a>\n"
                        
                        : (isset($image)
                            ? "<a class=\"cs_image_$count cs_preview\" "
                            . "title=\"".htmlspecialchars($title)."\" "
                            . "href=\"$link\" src=\"$imageFull\" "
                            . "index=\"cs_image_$count\" rel=\"nofollow\" "
                            . "onclick=\"window.open('$link'); return false\">"
                            . "<img  class=\"cbpro_img_render\" style=\"width: 100%;\" alt=\"cs_image_$count\" src=\"$image\" /></a>\n"
                            : '')
                           
                        )
                    . "</div></div>\n"
                    : '')
                    // ."<p style=\"padding-top:5px; padding-bottom:5px; color:#989898; font-weight:normal; font-size:13px; line-height:16px;\" />".str_replace(" ","&nbsp; ",str_pad($description, 100, " ", STR_PAD_RIGHT))."</p> \n"
                . ($_SESSION['cs_show_price'] == '1' && $price != ''
                    ? "<div align=center ><div class=\"cs_show_price\" style=\"background:". $_SESSION['cs_label_color']  .";  background-color:". $_SESSION['cs_label_color']  .";\" > \$".number_format($price,2)."</div></div>\n"
                    
                    : '')
                
                . ($_SESSION['cs_view_more_style'] == 'button' 
                   ? "<div><a href=\"$link\" target=_blank ><button style=\"border-radius:3px; font-size:0.875em; border:1px solid". $_SESSION['cs_button_color']."; padding:7px; margin-bottom:10px; background:". $_SESSION['cs_button_color']  .";  background-color:". $_SESSION['cs_button_color']  .";\"   >". $_SESSION['cs_view_more_text']  ." ?</button></a></div>\n"
                 : "<div><a href=\"$link\" target=_blank style=\"font-weight:bold; margin-bottom:10px; text-decoration:underline; font-size:120%; color:". $_SESSION['cs_button_color']  .";\" >". $_SESSION['cs_view_more_text']  ."</a></div>\n")
                      
                . "<div style=\" text-align: right\">"
                . ($show_more_link
                    ? "<a href=\"$cat_link$category\" style=\"font-size:13px; margin-bottom:3px; font-weight:normal; text-decoration:none; color:silver;\">&#8667; view similar products</a>"
                 
                    : '')
                . "</div><!-- end of  view more productcs-->\n";
                
        } elseif (  (($cur_view === 'tdi') || ($cur_view === 'tdli')) && ($section != 'reviews') && ($section != 'review-details') && ($section != 'review-single')  ) {

            
            $list_item['post_content'] =
                
                    " <div align=center>"
                        . cs_image_show_box($altimage,$image,$title,$count,$imageFull,$altimageFull,$link,$section)  
                       
                    . "</div>\n";
                    //. cs_products_description($cur_view,$description,$tirm_mdescr,$section);
                    //. cs_products_rating($section)
                   // . cs_price_view_more_similar_details($show_more_link,$cat_link,$category,$price,$link);
            
             $list_item['review_url'] = $review_link_final;
             $list_item['read_review'] = $review_available;
             $list_item['show_more_link'] =    $cat_link.$category.'&cs_temp_main_category='.$mcatcd;                        
             $list_item['descr'] =    $description;                    
             $list_item['link'] =    $link;
             $list_item['price'] =    $price;
             $list_item['score'] =    $score;
                
                
        } elseif (($cur_view === 'td') && ($section != 'reviews') && ($section != 'review-details') && ($section != 'review-single') ) {
            
            $list_item['review_url'] = $review_link_final;
            $list_item['read_review'] = $review_available;
            $list_item['show_more_link'] =    $cat_link.$category.'&cs_temp_main_category='.$mcatcd;                    
            $list_item['descr'] =    $description;   
            $list_item['price'] =    $price;
            $list_item['link'] =    $link;
            $list_item['score'] =    $score;
            $list_item['post_content'] =
                "<div>\n"
                . "$description\n"
                . "<div class=\"cs_rank_gravity\" style=\"padding-top: 1em\">\n"
                . ($_SESSION['cs_show_price'] == '1' && $price != ''
                    ? " \$$price"
                    . "<div style=\"padding-top: 0.5em\">\n"
                    : '')
                . "<div style=\"text-align: right\" style=\"float: right\">\n"
                . ($show_more_link
                    ? "<br />\n<a href=\"$cat_link$category\">Show similar products</a>"
                    : '')
                . "</div>"
                . ($_SESSION['cs_show_price'] == '1' && $price != ''
                    ? "</div>" : '')
                . "</div>"
                . "<div style=\"clear: both\"></div>"
                . "</div>\n";
        }
        elseif(   ($section === 'reviews') || ($section === 'review-details')  && ($section != 'review-single')  ){
                $list_item = array(   'target_url' => $review_link.'?cs_review_id='.$tar.'&mem='.$mem.'&memnumber='.$user_id.'&cs_mcat='.$mcatcd,
                                      'm_target_url' => $review_link.'?cs_mcat='.$mcatcd,
                                      's_target_url' => $review_link.'?cs_mcat='.$mcatcd.'&cs_scat='.$scatcd,
                                      'pdate' => $pdate,
                                      'mcname' => $mcat,
                                      'scname' => ($scat),
                                      'stitle' => $stitle,
                                      'post_title' => htmlspecialchars_decode($title),
                                      'review_desc' => $review_descr,
                                      'post_content' =>
                                                    (   (strlen($_GET['cs_review_id'])>10)
                                                        ?
                                                        "<img style='margin-bottom:2px; //max-width:300px; height:auto; margin-rights:20px; padding:3px;  border:0px solid #D3D3D3;'  src='".$review_image."' class='img-responsive' alt='".$title."' >"
                                                        :
                                                        "<img src='".$review_image."' class='img-responsive' alt='".$title."' style='border-radius:1px;'>"
                                                        )
                                   );
                                      
        } elseif(   ($section === 'review-single')   ){
            
                                   $link = htmlspecialchars($_SESSION['cs_plugin_url'].'/product.php'
                                        . '?memnumber='.$_GET['memnumber']
                                        . '&mem='.$_GET['mem']
                                        . '&tar='.$_GET['cs_review_id']
                                        . '&niche='.$niche);
                                   $ftr="<div align='center' style='margin:30px;'>".
                                                "<form method='get' action='' target='_blank'>".
                                                "<input type='hidden' name='tar' value='".$_GET['cs_review_id']."'>".
                                                "<input type='hidden' name='memnumber' value='".$_SESSION['cs_user_id']."'>".
                                                "<input type='hidden' name='mem' value='".$_GET['mem']."'>".
                                                 "<input type='submit' value='Get ".str_replace('Review','',$title).
                                                    " Now &raquo;' style='white-space: normal; border-radius:7px; line-height:1.2em; margin-bottom:20px; cursor: pointer; padding:18px; background:".
                                                    $_SESSION['cs_primary_color'] ."; color:white; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19); height:130%; font-size:130%; max-width:92%; max-height:80px;' >".
                                               "</form>".
                                                "</div>".
                                        "<div align='center' style='margin:10px; margin-top:30px;'>All orders are protected by SSL encryption - the highest industry standard for online security from trusted vendors.<br><br>".
                                         "<img style='width:35%;  height:auto;' src='https://cbproads.com/clickbankstorefront/v5/assets/images/60-Day-Money-Back-Guarantee.jpg' class='img-responsive'><br>".
                                        "<i>This product is backed with a 30-60 Day No Questions Asked Money Back Guarantee. If within the first 30-60 days of receipt you are not satisfied with the product, you can request a refund by sending an email to the ClickBank email address given inside the product and ClickBank&reg; will immediately refund your entire purchase price, with no questions asked.</i>".
                                        "</div>".
                                        "<BR><BR><br>".
                                        // cs_show_cb_banner_ads('horizontal',1,"",true,"").
                                        "<br>";
                                    
                                    $postedby="<div align='left' style='font-size:0.79em; font-weight:normal; margin-bottom:25px;'>&nbsp;<i class='fa fa-user' aria-hidden='true' style='font-size:12px;color:silver;'></i> <a href=''>admin</a>  &nbsp;&nbsp;&nbsp;".
                                  
                                        "  <i class='fa fa-calendar' style='font-size:12px;color:silver;' aria-hidden='true'></i> ".  $pdate. "</div>";
                                     
                                     $bread_crumb=" <div align='left' style='font-size:0.85em; font-weight:normal; margin-bottom:15px;'> ".
                                           // "<a href='".get_home_url()."'>Home</a> ".
                                            "<i class='fa fa-folder' style='font-size:12px;color:silver;' aria-hidden='true'></i> ".
                                            "<a href='".$review_link."' style='text-decoration:none;'>Product Reviews</a> ".
                                            "<i class='fa fa-angle-right' style='font-size:12px;color:silver;' aria-hidden='true'></i> ".
                                            "<a href='".$review_link.'?cs_mcat='.$mcatcd."&cs_mcat_name=".urlencode($mcat)."' style='text-decoration:none;'>".$mcat."</a>". //$p['scname']."</a> ".
                                             //"<i class='fa fa-angle-right' aria-hidden='true'></i> ".
                                            "</div>" ;     
                                            
                                   if ($_GET['cs_message']==='success'){
                                            $baner_msg= '<div style="padding:20px; border-radius:10px; margin:20px; background:lightblue; color:blue;">Your review has been submitted. It will be published shortly.</div>';
                                   } 
                                 //  echo cs_show_cb_banner_ads('horizontal',1);
                                   
                                  $contentr=htmlspecialchars_decode($baner_msg).
                                            
                                            htmlspecialchars_decode('<div id="cbpro-product-detail" style="border:0px; padding:0px;" >') .
                                            htmlspecialchars_decode ($bread_crumb).
                                            htmlspecialchars_decode ('<h1>'.$title.$stitle.'</h1>'.$postedby).
                                            htmlspecialchars_decode($contentr).
                                            htmlspecialchars_decode($ftr).
                                            htmlspecialchars_decode( '</div>').
												(get_option('cbproads_premium_store')
												?	htmlspecialchars_decode( '<br>').htmlspecialchars_decode(cs_show_cb_banner_ads('horizontal',1))
												: ""
												).
												
										htmlspecialchars_decode( '<br>');
                                            
                                   //echo htmlspecialchars_decode('<div id="cbpro-product-detail">');
                                  // echo htmlspecialchars_decode ($bread_crumb);
                                  
                                   
                                  
                                   //echo htmlspecialchars_decode ('<h1>'.$title.$stitle.'</h1></header>'.$postedby);
                                    
                                  // echo htmlspecialchars_decode($contentr);
                                   //echo htmlspecialchars_decode($ftr);
                                   //echo htmlspecialchars_decode( '</div>');
                                   
                                   $list_item = array(   'target_url' => $review_link.'?cs_review_id='.$tar,
                                      //'m_target_url' => $review_link.'?mcat='.$mcatcd,
                                      //'s_target_url' => $review_link.'?mcat='.$mcatcd.'&scat='.$scatcd,
                                      //'pdate' => $pdate,
                                      //'mcname' => $mcat,
                                      //'scname' => $scat,
                                      'total' =>  1,
									  'urls' => $review_link,
                                      'post_title' => $title,
                                     // 'review_desc' => $review_descr,
                                      'post_content' => $contentr
                
                                                    //" <div align=center>"
                                                       // . cs_image_show_box($review_header,$review_header,$title,$count,$imageFull,$altimageFull,$link,$section)  
                                                      //  "<img style='margin-bottom:5px; max-width:350px; height:auto; margin-right:20px; padding:3px; box-shadow: 0px 0px 15px #888888; border:1px solid #D3D3D3;'  src='".$review_image."' class='img-responsive' alt='".$title."' align='left'>"
                                                   // . "</div>\n"
                                   ); 
        }
        
       //die($section);
        $item_list[] = $list_item;
        $count++;
    }
    
    return array('posts' => $item_list, 'totalp' => $totalp);
}

/**
* Get products from the XML feed
* 
* @param int $selected_cat
* @return array
*/
function limit_text($s, $limit=3) {
        
    return preg_replace('/((\w+\W*){'.($limit-1).'}(\w+))(.*)/', '${1}', $s).' ...';   

    }
    
function cs_get_categories($selected_cat = null)
{
    static $item_list = null;
    
    if ($item_list === null) {
        $url = 'https://cbproads.com/xmlfeed/wp/main/categories.asp';
       $url=$url."?".date('Y-m-d');
       // echo $url;
        $error_answer = array(
            'cats' => array(
                0 => array(
                    'name' => 'Categories',
                    'subcats' => array('Sorry, no categories for now.')
                )
            )
        );
        //$xml = @simplexml_load_file($url);
        $rss = fetch_feed($url);
        //if (false === $xml) {
        if (is_wp_error($rss)) {
            trigger_error(
                'Problem while connecting to clickbankproads.com. '
                . 'Clickbank Storefronts can\'t work properly.', E_USER_WARNING);
            return $error_answer;
        }
        //$items = $xml->channel[0]->item;
        if (0 == $rss->get_item_quantity(400)) return $error_answer;
        $items = $rss->get_items(0, 400);
        
        $item_list = array(
            'selected_id' => null,
            'selected_name' => null,
            'cats' => array()
        );
        foreach ($items as $item) {
            // Get data
            //$cat_id = (int)$item->mainhead[0];
            $tmp = $item->get_item_tags(SIMPLEPIE_NAMESPACE_RSS_20, 'mainhead');
            $cat_id = (int)$tmp[0]['data'];
            $tmp = $item->get_item_tags(SIMPLEPIE_NAMESPACE_RSS_20, 'mainhead_name');
            //$cat_name = (string)$item->mainhead_name[0];
            $cat_name = (string)$tmp[0]['data'];
            $tmp = $item->get_item_tags(SIMPLEPIE_NAMESPACE_RSS_20, 'subhead');
            //$subcat_id = (int)$item->subhead[0];
            $subcat_id = (int)$tmp[0]['data'];
            $tmp = $item->get_item_tags(SIMPLEPIE_NAMESPACE_RSS_20, 'subhead_name');
            //$subcat_name = (string)$item->subhead_name[0];
            $subcat_name = (string)$tmp[0]['data'];

            // Add record
            if (!isset($item_list['cats'][$cat_id])) {
                $tmp = array(
                    $item->get_item_tags(SIMPLEPIE_NAMESPACE_RSS_20, 'thumbnail_main'),
                    $item->get_item_tags(SIMPLEPIE_NAMESPACE_RSS_20, 'thumbnail_grey'),
                    $item->get_item_tags(SIMPLEPIE_NAMESPACE_RSS_20, 'thumbnail_small_main'),
                    $item->get_item_tags(SIMPLEPIE_NAMESPACE_RSS_20, 'thumbnail_small_grey')
                );
                $item_list['cats'][$cat_id] = array(
                    'ID' => $cat_id,
                    'name' => $cat_name,
                    'thumbnail_main' => (string)$tmp[0][0]['data'],
                    'thumbnail_grey' => (string)$tmp[1][0]['data'],
                    'thumbnail_small_main' => (string)$tmp[2][0]['data'],
                    'thumbnail_small_grey' => (string)$tmp[3][0]['data'],
                    'subcats' => array()
                );
            }
            $item_list['cats'][$cat_id]['subcats'][$subcat_id] =
                array('name' => $subcat_name);
            
            // Check if selected
            if ($subcat_id == $selected_cat) {
                $item_list['cats'][$cat_id]['subcats'][$subcat_id]['selected'] = true;
                $item_list['selected_id'] = $subcat_id;
                $item_list['selected_name'] = $subcat_name;
               
            }
        }
    }
    
    return $item_list;
}

?>