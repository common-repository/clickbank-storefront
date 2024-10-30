<?php

require_once $GLOBALS['cs_plugin_dir'].'xmldb.inc.php';


/**
* Add plugin's options into DB and reset their values (called on plugin activation)
*/
function cs_plugin_activate()
{
    
    
    global $cs_options, $cs_ad_options;
    

   // cs_version_update();
     
    
    cs_add_options_to_db($cs_options, $cs_ad_options);
    $remote_url = 'https://cbproads.com/wordpress_installs-activation.asp';
	$url=	get_site_url();
	
	
	$response = wp_remote_post( $remote_url, array(
		//'method' => 'POST',
		//'timeout' => 45,
		//'redirection' => 5,
		//'httpversion' => '1.0',
		//'blocking' => true,
		//'headers' => array(),
		'body' => array( 'url' =>  $url, 'endata' => md5($url), 'tp' => 'activation' )
		//'cookies' => array()
		)
	);
	
	


}

function cs_plugin_deactivate() {
    
    cs_plugin_removal();
    
   $remote_url = 'https://cbproads.com/wordpress_installs-activation.asp';
	$url=	get_site_url();
	
	
	$response = wp_remote_post( $remote_url, array(
		//'method' => 'POST',
		//'timeout' => 45,
		//'redirection' => 5,
		//'httpversion' => '1.0',
		//'blocking' => true,
		//'headers' => array(),
		'body' => array( 'url' =>  $url, 'endata' => md5($url), 'tp' => 'de-activation' )
		//'cookies' => array()
		)
	);
}
/**
* Add settings link on plugin page
* 
* @param array $links
*/

function cs_version_update(){
    
    if  (    get_option('cs_plugin_version') != $GLOBALS['cs_plugin_version']   ){
  
        update_option('cs_plugin_version',$GLOBALS['cs_plugin_version']);
    }else{
        return;
    }
       
     $found_post = null;

    if ( $posts = get_posts( array( 
        'name' => 'cs_product_reviews', 
        'post_type' => 'page',
        'post_status' => 'publish',
        'posts_per_page' => 1
    ) ) ) $found_post = $posts[0];


    $review_post  = array( 'post_title'     => 'Product Reviews',
                   'post_type'      => 'page',
                   'post_name'      => 'cs_product_reviews',
                   'post_content'   => '[clickbank-product-review-details]',
                   'post_status'    => 'publish',
                   'comment_status' => 'closed',
                   'ping_status'    => 'closed',
                   'post_author'    => 'admin',
                   'post_parent'    => '',
                   'page_template'  => '',
                   'menu_order'     => 0 );
                   
                    // Now, we can do something with $found_post
                    if (  is_null( $found_post ) ){
                        $result1=wp_insert_post( $review_post );
                    }
                    if ( is_wp_error($result1) ){
                        echo $result1->get_error_message();
                        die();
                    }
    
    
      $found_post = null;
                
                    if ( $posts = get_posts( array( 
                        'name' => 'cs_product_categories', 
                        'post_type' => 'page',
                        'post_status' => 'publish',
                        'posts_per_page' => 1
                    ) ) ) $found_post = $posts[0];

    $category_post  = array( 'post_title'     => 'Categories',
                   'post_type'      => 'page',
                   'post_name'      => 'cs_product_categories',
                   'post_content'   => '[clickbank-storefront-products]',
                   'post_status'    => 'publish',
                   'comment_status' => 'closed',
                   'ping_status'    => 'closed',
                   'post_author'    => 'admin',
                   'comment_status' => 'closed',
                   'post_parent'    => '',
                   'page_template'  => '',
                   'menu_order'     => 0 );
                   
                        // Now, we can do something with $found_post
                        if (  is_null( $found_post ) ){
                            $result=wp_insert_post( $category_post );
                        }
                        if ( is_wp_error($result) ){
                            echo $result->get_error_message();
                            die();
                        }
    
    $found_post = null;
                
                    if ( $posts = get_posts( array( 
                        'name' => 'cs_page_popular_products', 
                        'post_type' => 'page',
                        'post_status' => 'publish',
                        'posts_per_page' => 1
                    ) ) ) $found_post = $posts[0];

    $category_post  = array( 'post_title'     => 'Most Popular',
                   'post_type'      => 'page',
                   'post_name'      => 'cs_page_popular_products',
                   'post_content'   => '[clickbank-storefront-popular]',
                   'post_status'    => 'publish',
                   'comment_status' => 'closed',
                   'ping_status'    => 'closed',
                   'post_author'    => 'admin',
                   'comment_status' => 'closed',
                   'post_parent'    => '',
                   'page_template'  => '',
                   'menu_order'     => 0 );
                   
                        // Now, we can do something with $found_post
                        if (  is_null( $found_post ) ){
                            $result2=wp_insert_post( $category_post );
                        }
                        if ( is_wp_error($result2) ){
                            echo $result2->get_error_message();
                            die();
                        }
                        
                        
   $found_post = null;
                
                    if ( $posts = get_posts( array( 
                        'name' => 'cs_page_bestselling_products', 
                        'post_type' => 'page',
                        'post_status' => 'publish',
                        'posts_per_page' => 1
                    ) ) ) $found_post = $posts[0];

    $category_post  = array( 'post_title'     => 'Best Selling',
                   'post_type'      => 'page',
                   'post_name'      => 'cs_page_bestselling_products',
                   'post_content'   => '[clickbank-storefront-bestselling]',
                   'post_status'    => 'publish',
                   'comment_status' => 'closed',
                   'ping_status'    => 'closed',
                   'post_author'    => 'admin',
                   'comment_status' => 'closed',
                   'post_parent'    => '',
                   'page_template'  => '',
                   'menu_order'     => 0 );
                   
                        // Now, we can do something with $found_post
                        if (  is_null( $found_post ) ){
                            $result3=wp_insert_post( $category_post );
                        }
                        if ( is_wp_error($result3) ){
                            echo $result3->get_error_message();
                            die();
                        }
    
    
    $found_post = null;
                
                    if ( $posts = get_posts( array( 
                        'name' => 'cs_page_featured_products', 
                        'post_type' => 'page',
                        'post_status' => 'publish',
                        'posts_per_page' => 1
                    ) ) ) $found_post = $posts[0];

    $category_post  = array( 'post_title'     => 'Featured',
                   'post_type'      => 'page',
                   'post_name'      => 'cs_page_featured_products',
                   'post_content'   => '[clickbank-storefront-featured]',
                   'post_status'    => 'publish',
                   'comment_status' => 'closed',
                   'ping_status'    => 'closed',
                   'post_author'    => 'admin',
                   'comment_status' => 'closed',
                   'post_parent'    => '',
                   'page_template'  => '',
                   'menu_order'     => 0 );
                   
                        // Now, we can do something with $found_post
                        if (  is_null( $found_post ) ){
                            $result4=wp_insert_post( $category_post );
                        }
                        if ( is_wp_error($result4) ){
                            echo $result4->get_error_message();
                            die();
                        }                                           
                        
}



function cs_plugin_removal(){
    
    update_option('cbproads_menu_check', false);
    update_option('cbproads_main_menu_check', false);
    update_option('cbproads_menu_review_check', false);
    update_option('cs_plugin_version', 0);
    
    $postid = null;
    if ( $posts = get_posts( array( 
            'name' => 'cs_product_reviews', 
            'post_type' => 'page',
            'post_status' => 'publish',
            'posts_per_page' => 1
        ) ) ) $postid = $posts[0];
    
    if (  is_null( $postid ) ){}
    else{ wp_delete_post( $postid->ID, true ); }
    
    
    $postid = null;
    if ( $posts = get_posts( array( 
            'name' => 'cs_product_categories', 
            'post_type' => 'page',
            'post_status' => 'publish',
            'posts_per_page' => 1
        ) ) ) $postid = $posts[0];
    
    if (  is_null( $postid ) ){}
    else{ wp_delete_post( $postid->ID, true ); }
    
    
    $postid = null;
    if ( $posts = get_posts( array( 
            'name' => 'cs_page_featured_products', 
            'post_type' => 'page',
            'post_status' => 'publish',
            'posts_per_page' => 1
        ) ) ) $postid = $posts[0];
      
    if (  is_null( $postid ) ){}
    else{ wp_delete_post( $postid->ID, true ); }
    
    
    $postid = null;
    if ( $posts = get_posts( array( 
            'name' => 'cs_page_bestselling_products', 
            'post_type' => 'page',
            'post_status' => 'publish',
            'posts_per_page' => 1
        ) ) ) $postid = $posts[0];
        
    if (  is_null( $postid ) ){}
    else{ wp_delete_post( $postid->ID, true ); }
    
    
    $postid = null;
    if ( $posts = get_posts( array( 
            'name' => 'cs_page_popular_products', 
            'post_type' => 'page',
            'post_status' => 'publish',
            'posts_per_page' => 1
        ) ) ) $postid = $posts[0];
    
    if (  is_null( $postid ) ){}
    else{ wp_delete_post( $postid->ID, true ); }
}



  
  
function cs_add_mega_menu_items(){

    global $wp;
    $run_once = get_option('cbproads_menu_check');
    $curr_path=add_query_arg( $wp->query_vars, home_url( $wp->request ) );
    $cat_page = cs_get_products_page('cs_category', '');

    
    if (    (!$run_once) ){         // && (  strpos($curr_path, "wp-admin/nav-menus.php") === false)    )  {
    
        	$empty_answer = 'Error in accessing Cbproads';
           //give your menu a name
            $menu_name = 'CB Mega Menu for Categories';
            //create the menu
            $menu_exists = wp_get_nav_menu_object($menu_name);
             
            if (!$menu_exists) {
                
                 $menu_id = wp_create_nav_menu($menu_name);
            
                //else{
                //$menu_id = get_term_by('name', ($menu_name), 'nav_menu' ); 
                // }
    
              
                $url='https://cbproads.com/xmlfeed/wp/main/custom_categories_v5.asp';
                $url=$url."?Date-".date('Y-m-d');
                 
        		$rss = fetch_feed($url);
        		
                if (is_wp_error($rss)) return $empty_answer;
                if (0 == $rss->get_item_quantity(400)) return $empty_answer;
            
                
                $items = $rss->get_items(0, 400);
                $cnt=0;
                
                foreach ($items as $item) {
                    
                    //$cnt=$cnt+1;
                    $paths = $item->get_item_tags(SIMPLEPIE_NAMESPACE_RSS_20, "mainhead");
                    $mainhead = htmlspecialchars(cs_cdata($paths[0]['data']));
        			
        			$paths = $item->get_item_tags(SIMPLEPIE_NAMESPACE_RSS_20, "mainhead_name");
                    $mainhead_name = htmlspecialchars(cs_cdata($paths[0]['data']));

                        $top_menu= wp_update_nav_menu_item($menu_id, 0, array(
                        'menu-item-title' =>  __($mainhead_name),
                        'menu-item-classes' => '',
                        'menu-item-url' => '' , 
                        'menu-item-status' => 'publish',
                        'menu-item-parent-id' => 0,
                        ));  
                        
                        			
    					//getting second child details
    					$url2='https://cbproads.com/xmlfeed/wp/main/custom_categories_sub_v5.asp?test=test&main_cat_id='.$mainhead;
    					//echo "urlis.......................................................".$url2;
    					$rss2 = fetch_feed($url2);
    					if (is_wp_error($rss2)) return $empty_answer;
    					if (0 == $rss2->get_item_quantity(400)) return $empty_answer;
    					
    					$items_sc = $rss2->get_items(0, 400);

    					foreach ($items_sc as $item_sc) {
    					    //echo $url;
    					
    					    $paths = $item_sc->get_item_tags(SIMPLEPIE_NAMESPACE_RSS_20, "mccode");
                            $mccode = htmlspecialchars(cs_cdata($paths[0]['data']));
                            
                            $paths = $item_sc->get_item_tags(SIMPLEPIE_NAMESPACE_RSS_20, "mcname");
                            $mcname = htmlspecialchars(cs_cdata($paths[0]['data']));
                            //$mcname=str_replace("&","%26",$mcname);
                            $surl=str_replace("?cs_category=","",$cat_page)."?cs_main_category=".$mccode."&cs_main_category_name=".urlencode($mcname);
                                //echo "urlis.......................................................".$surl;
                                 $second_menu=wp_update_nav_menu_item($menu_id, 0, array(
                                'menu-item-title' =>  __($mcname),
                                'menu-item-classes' => '',
                                'menu-item-url' => $surl, 
                                'menu-item-status' => 'publish',
                                'menu-item-parent-id' => $top_menu,
                                ));  
                                
                                	//getting second child details
                					$url3='https://cbproads.com/xmlfeed/wp/main/sub_categories.asp?test=test&main_cat_id='.$mccode;
                					//echo "urlis.......................................................".$url3;
                					$rss3 = fetch_feed($url3);
                					if (is_wp_error($rss3)) return $empty_answer;
                					if (0 == $rss3->get_item_quantity(400)) return $empty_answer;
                					
                					$items_tr = $rss3->get_items(0, 400);
            
                					foreach ($items_tr as $item_tr) {
                					    //echo $url;
                					
                					    $paths = $item_tr->get_item_tags(SIMPLEPIE_NAMESPACE_RSS_20, "mainhead");
                                        $mainheads = htmlspecialchars(cs_cdata($paths[0]['data']));
                                        
                                        $paths = $item_tr->get_item_tags(SIMPLEPIE_NAMESPACE_RSS_20, "subhead");
                                        $sccode = htmlspecialchars(cs_cdata($paths[0]['data']));
                                        
                                        $paths = $item_tr->get_item_tags(SIMPLEPIE_NAMESPACE_RSS_20, "subhead_name");
                                        $subhead_name = htmlspecialchars(cs_cdata($paths[0]['data']));
                                        
                                        $turl=str_replace("?cs_category=","",$cat_page)."?cs_category=".$sccode."&cs_temp_main_category=".urlencode($mainheads);
                                       // echo "urlis.......................................................".$surl;
                                             wp_update_nav_menu_item($menu_id, 0, array(
                                            'menu-item-title' =>  __($subhead_name),
                                            'menu-item-classes' => '',
                                            'menu-item-url' => $turl, 
                                            'menu-item-status' => 'publish',
                                            'menu-item-parent-id' => $second_menu,
                                            ));  
                                        
                					}// loop end of third level menu
                            
    					}// loop end of second level menu
                        
    
                } // loop end of top level menu
                
            } //if menu not exits 'cbprodcut categories'
            

                

             update_option('cbproads_menu_check', true);
     
    }
}

function cs_add_menu_reviews_items(){
	   
    $run_once = get_option('cbproads_menu_review_check');
    $review_link = cs_get_review_page('', '');

    
    if (    (!$run_once) ){         // && (  strpos($curr_path, "wp-admin/nav-menus.php") === false)    )  {
    
        $empty_answer = 'Error in accessing Cbproads';
		$menu_name = 'CB Product Reviews';
            //create the menu
            $menu_exists = wp_get_nav_menu_object($menu_name);
             
            if (!$menu_exists) {
                
                 $menu_id = wp_create_nav_menu($menu_name);
            
              
                $url="https://cbproads.com/xmlfeed/wp/main/review_categories.asp";
                $url=$url."?Date-".date('Y-m-d');
        		$rss = fetch_feed($url);
        		
                if (is_wp_error($rss)) return $empty_answer;
                if (0 == $rss->get_item_quantity(400)) return $empty_answer;
            
                
                $items = $rss->get_items(0, 400);
                $cnt=0;
                
                foreach ($items as $item) {
                    
                    //$cnt=$cnt+1;
                    $paths = $item->get_item_tags(SIMPLEPIE_NAMESPACE_RSS_20, "mainhead");
                    $mainhead = htmlspecialchars(cs_cdata($paths[0]['data']));
        			
        			$paths = $item->get_item_tags(SIMPLEPIE_NAMESPACE_RSS_20, "mainhead_name");
                    $mainhead_name = htmlspecialchars(cs_cdata($paths[0]['data']));
					$turl=$review_link."?cs_mcat=".$mainhead."&cs_mcat_name=".urlencode($mainhead_name);

                        $top_menu= wp_update_nav_menu_item($menu_id, 0, array(
                        'menu-item-title' =>  __($mainhead_name),
                        'menu-item-classes' => '',
                        'menu-item-url' => $turl, 
                        'menu-item-status' => 'publish',
                        'menu-item-parent-id' => 0,
                        ));  
                        
                  
				}
			}
		update_option('cbproads_menu_review_check', true);
	}
}


function cs_add_main_menu(){
    
    
    function cs_get_top_product_page($cs_page_slug){
        
	    	if ( $posts = get_posts( array( 
										'name' => $cs_page_slug, 
										'post_type' => 'page',
										'post_status' => 'publish',
										'posts_per_page' => 1
									) ) ) $found_post = $posts[0];

									// Now, we can do something with $found_post
									if (  !is_null( $found_post ) ){
										$surl=get_permalink($posts[0]->ID);
									}
			return $surl;
	}
	 


    $run_once = get_option('cbproads_main_menu_check');
    $review_link = cs_get_review_page('', '');
    $cat_page = cs_get_products_page('cs_category', '');
	 
    if (    (!$run_once) ){         // && (  strpos($curr_path, "wp-admin/nav-menus.php") === false)    )  {
	
		$empty_answer = 'Error in accessing Cbproads';
		$menu_name = 'CBPro Main Menu';
		
		$menu_exists = wp_get_nav_menu_object($menu_name);
             
        if (!$menu_exists) {
			
			$menu_id = wp_create_nav_menu($menu_name);
			
			//home
			$top_menu= wp_update_nav_menu_item($menu_id, 0, array(
                        'menu-item-title' =>  __('Home'),
                        'menu-item-classes' => '',
                        'menu-item-url' => home_url(''), 
                        'menu-item-status' => 'publish',
                        'menu-item-parent-id' => 0,
                        ));  
    
			//Top Products
			$top_menu= wp_update_nav_menu_item($menu_id, 0, array(
                        'menu-item-title' =>  __('Top Products'),
                        'menu-item-classes' => '',
                        'menu-item-url' => '', 
                        'menu-item-status' => 'publish',
                        'menu-item-parent-id' => 0,
                        ));  
								   
								$surl=cs_get_top_product_page('cs_page_bestselling_products');
								wp_update_nav_menu_item($menu_id, 0, array(
                                'menu-item-title' =>  'Best Selling',
                                'menu-item-classes' => '',
                                'menu-item-url' => $surl, 
                                'menu-item-status' => 'publish',
                                'menu-item-parent-id' => $top_menu,
                                ));
								
								
								$surl=cs_get_top_product_page('cs_page_featured_products');
								wp_update_nav_menu_item($menu_id, 0, array(
                                'menu-item-title' =>  'Featured',
                                'menu-item-classes' => '',
                                'menu-item-url' => $surl, 
                                'menu-item-status' => 'publish',
                                'menu-item-parent-id' => $top_menu,
                                ));
								
								
								$surl=cs_get_top_product_page('cs_page_popular_products');
								wp_update_nav_menu_item($menu_id, 0, array(
                                'menu-item-title' =>  'Most Popular',
                                'menu-item-classes' => '',
                                'menu-item-url' => $surl, 
                                'menu-item-status' => 'publish',
                                'menu-item-parent-id' => $top_menu,
                                ));
			
			
			//Top Reviews
			$top_menu= wp_update_nav_menu_item($menu_id, 0, array(
                        'menu-item-title' =>  __('Best Product Reviews'),
                        'menu-item-classes' => '',
                        'menu-item-url' => $review_link, 
                        'menu-item-status' => 'publish',
                        'menu-item-parent-id' => 0,
                        ));
                        
                        $url="https://cbproads.com/xmlfeed/wp/main/review_categories.asp";
                        $url=$url."?Date-".date('Y-m-d');
                		$rss = fetch_feed($url);
                		
                        if (is_wp_error($rss)) return $empty_answer;
                        if (0 == $rss->get_item_quantity(400)) return $empty_answer;
                    
                        
                        $items = $rss->get_items(0, 400);
                        $cnt=0;
                        
                        foreach ($items as $item) {
                            
                            //$cnt=$cnt+1;
                            $paths = $item->get_item_tags(SIMPLEPIE_NAMESPACE_RSS_20, "mainhead");
                            $mainhead = htmlspecialchars(cs_cdata($paths[0]['data']));
                			
                			$paths = $item->get_item_tags(SIMPLEPIE_NAMESPACE_RSS_20, "mainhead_name");
                            $mainhead_name = htmlspecialchars(cs_cdata($paths[0]['data']));
        					$turl=$review_link."?cs_mcat=".$mainhead."&cs_mcat_name=".urlencode($mainhead_name);
        
                                wp_update_nav_menu_item($menu_id, 0, array(
                                'menu-item-title' =>  __($mainhead_name),
                                'menu-item-classes' => '',
                                'menu-item-url' => $turl, 
                                'menu-item-status' => 'publish',
                                'menu-item-parent-id' => $top_menu,
                                ));  
                                
                          
        				}
			
			//Categories
			$top_menu= wp_update_nav_menu_item($menu_id, 0, array(
                        'menu-item-title' =>  __('Product Categories'),
                        'menu-item-classes' => '',
                        'menu-item-url' => str_replace("?cs_category=","",$cat_page), 
                        'menu-item-status' => 'publish',
                        'menu-item-parent-id' => 0,
                        ));  
                        
                        $cats = cs_get_categories();
                        //var_dump($cats);
                        
                        foreach ($cats['cats'] as $cat_id => $cat) {
                            
                            if (!isset($_SESSION['cs_cats_to_omit'][$cat_id])) {
                                
                                 $surl=str_replace("?cs_category=","",$cat_page)."?cs_main_category=".$cat_id."&cs_main_category_name=".urlencode($cat['name']);
                                    //echo "urlis.......................................................".$surl;
                                     $second_menu=wp_update_nav_menu_item($menu_id, 0, array(
                                    'menu-item-title' =>  __($cat['name']),
                                    'menu-item-classes' => '',
                                    'menu-item-url' => $surl, 
                                    'menu-item-status' => 'publish',
                                    'menu-item-parent-id' => $top_menu,
                                ));  
                    
                            }
                        }
            
            	//contact
			            	//own a store
			$top_menu= wp_update_nav_menu_item($menu_id, 0, array(
                        'menu-item-title' =>  __('Own A Store'),
                        'menu-item-classes' => '',
                        'menu-item-url' => "https://cbproads.com/join.asp?id=".$_SESSION["cs_user_id"], 
                        'menu-item-status' => 'publish',
                        'menu-item-parent-id' => 0,
                        ));  
                        
                        
            //contact
			/*
            $top_menu= wp_update_nav_menu_item($menu_id, 0, array(
                        'menu-item-title' =>  __('Contact Us'),
                        'menu-item-classes' => '',
                        'menu-item-url' => home_url(''), 
                        'menu-item-status' => 'publish',
                        'menu-item-parent-id' => 0,
                        ));        */              
    
			update_option('cbproads_main_menu_check', true);
		}
	}
	//else{echo "ssssshttps://cbproads.com/join.asp?id=".$_SESSION["cs_user_id"];}
}



/**
* Add plugin's settings page to the WP admin panel menu
*/
function cs_add_to_menu()
{
    add_options_page(
        'Clickbank Storefronts',
        'Clickbank Storefronts',
        'manage_options',
        'cs_menu',
        'cs_option');
}







/**
* Echo plugin's settings page HTML code
*/
function cs_option()
{
   
    
    
   
    
    
    global $wpdb, $cs_options, $cs_ad_options;
    
    // Selects
    $cs_options['cs_rank']['cur_val'] = $_SESSION['cs_rank'];
    $cs_options['cs_gravity']['cur_val'] = $_SESSION['cs_gravity'];
    $cs_options['cs_products_page']['cur_val'] = $_SESSION['cs_products_page'];
    $cs_options['cs_cats_to_omit']['cur_val'] = $_SESSION['cs_cats_to_omit'];
    $cs_options['cs_home_page_cats']['cur_val'] = $_SESSION['cs_home_page_cats'];
    $cs_options['cs_reviews_show_cats']['cur_val'] = $_SESSION['cs_reviews_show_cats'];
    //$cs_ad_options['cs_title_tag']['cur_val'] = $_SESSION['cs_title_tag'];
   // $cs_ad_options['cs_subtitle_tag']['cur_val'] = $_SESSION['cs_subtitle_tag'];
    
    // Category Page
    $pages = get_pages();
    foreach ($pages as $page) {
        $cs_options['cs_products_page']['vals'][get_page_link($page->ID)]
            = $page->post_title;
    }
    
    // Review Page
    $pages = get_pages();
    foreach ($pages as $page) {
        $cs_options['cs_review_page']['vals'][get_page_link($page->ID)]
            = $page->post_title;
    }
    
    // Categories to omit & product reviews to show only from
    $cats = cs_get_categories();
    //print_r($cats['cats']);
    $cs_options['cs_reviews_show_cats']['vals'][$cat_id] ="";
    $loop_count=0;
    foreach ($cats['cats'] as $cat_id => $cat) {
        
        $cs_options['cs_cats_to_omit']['vals'][$cat_id] = $cat['name'];
        $cs_options['cs_home_page_cats']['vals'][$cat_id] = $cat['name'];
        $loop_count=$loop_count+1;
        if ($loop_count==0){
            //$cs_options['cs_reviews_show_cats']['vals'][$cat_id] ="-----";
             echo "<h1>".$cs_options['cs_reviews_show_cats']['vals']."</h1>";
             print_r($cs_options['cs_reviews_show_cats']['vals']);
        }else{
            $cs_options['cs_reviews_show_cats']['vals'][$cat_id] =$cat['ID'].'>'.htmlspecialchars($cat['name']);
        }
        
    }
    
    
    
    echo "<h1>Clickbank Storefronts</h1>\n";
    echo "<h3>Plugin Installation Help? "
          ."Please see <a href=\"https://cbproads.com/clickbank_storefront_wordpress_plugin.asp\" target=\"_blank\">this</a> URL.</h3>";
    if (@$_POST['cs_submit']) {
        if (!isset($_POST['cs_cats_to_omit'])) $_POST['cs_cats_to_omit'] = array();
        if (!isset($_POST['cs_home_page_cats'])) $_POST['cs_home_page_cats'] = array();
            if (isset($_POST['cs_featured_ids'] )) {
                if ($_POST['cs_featured_ids'] != '') {
                    $_POST['cs_featured_ids'] = explode(',', $_POST['cs_featured_ids']);
                    $_POST['cs_featured_ids'] = array_map('trim', $_POST['cs_featured_ids']);
                    $_POST['cs_featured_ids'] = implode(',', $_POST['cs_featured_ids']);
                }
            }
            
        // echo 'ttil'.  print_r($_POST['cs_home_page_cats'] );
            
        $opts = array('cs_options', 'cs_ad_options');
        foreach ($opts as $options_changed) {
            foreach ($$options_changed as $oname => $o) {
                
                if (isset($_POST[$oname]) || $o['type'] === 'checkbox') {
                    
                    if (($oname !== 'cs_cats_to_omit') && ($oname !== 'cs_home_page_cats')) $oval = trim($_POST[$oname]);
                    //else if ($oname !== 'cs_home_page_cats')  $oval = trim($_POST[$oname]);
                    else $oval = $_POST[$oname];
                    
                    switch ($o['type']) {
                        case 'checkbox':
                            if ($oval != '1') $oval = '0';
                            break;
                        case 'int':
                            if ($oval !== '') {
                                if (!ctype_digit("$oval")) {
                                    $oval = get_option($oname);
                                }
                            }
                            break;
                    }
                    
                    if ($oname === 'cs_cats_to_omit') {
                        $tmp = $oval;
                        $oval = array();
                        foreach ($tmp as $val) $oval[$val] = '1';
                       // echo 'dddd';
                      //  print_r($oval)."<br>";
                    }
                    elseif ($oname === 'cs_home_page_cats') {
                        $tmp = $oval;
                        $oval = array();
                        foreach ($tmp as $val) $oval[$val] = '1';
                       // echo 'mmmmm';
                     //   print_r($oval)."<br>";
                    }elseif ($o['req'] && $oval === '' && ($oname === 'cs_title_text_color' || $oname === 'cs_secondary_color' || $oname === 'cs_title_bg_color' || $oname === 'cs_button_class'  || $oname === 'cs_prodbox_fill_color' || $oname === 'cs_title_class')    ) {
                         $oval = "#";
                    } elseif ($o['req'] && $oval === '') {
                        $oval = get_option($oname);
                    }
                    
                    update_option($oname, $wpdb->escape($oval));
                    //echo "Yasar Plesw hi say hi" .$oname.":". print_r($oval)."<br>";
                }
            }
        }
    }
    ?>
    
    <form name="cs_form" method="post" action="" >
        <table class="form-table" border=1 bordercolor=silver cellpadding=10 cellspacing=10>
            <?php foreach ($cs_options as $oname => $o): ?>
                <?php if (true): 
                //echo $oname."<br>";
                ?>
                    <?php if ($oname === 'cs_view_other'): ?>
                         
                         <tr valign="top">
                            <th colspan="2" scope="row">
                                <h2>Bestselling / Featured / Popular Product Lists</h2>
                                <p class="description">(Store Home Page Options)</p>
                            </th>
                        </tr>
                       
                    <?php endif ?>
                    
                    <?php if ($oname === 'cs_cats_to_omit') : $oval = get_option($oname); ?>
                        <tr valign="top">
                            <th scope="row">
                                <label for="<?php echo $oname ?>"><?php echo $o['label'] ?></label>
                            </th>
                            <td>
                                <select name="<?php echo $oname ?>[]" id="<?php echo $oname ?>"
                                multiple="multiple">
                                    <?php foreach ($o['vals'] as $k => $v): ?>
                                        <option
                                        <?php if (isset($oval[(int)$k])): ?>
                                            selected="selected"
                                        <?php endif ?>
                                        value="<?php echo htmlspecialchars($k) ?>">
                                            <?php echo $v ?>
                                        </option>
                                    <?php endforeach ?>
                                </select> Press CTRL button to select multiple categories
                            </td>
                        </tr>
                    <?php elseif   ($oname === 'cs_home_page_cats') : $oval = get_option($oname); ?>
                        <tr valign="top">
                            <th scope="row">
                                <label for="<?php echo $oname ?>"><?php echo $o['label'] ?></label>
                            </th>
                            <td>
                                <select name="<?php echo $oname ?>[]" id="<?php echo $oname ?>"
                                multiple="multiple">
                                    <?php foreach ($o['vals'] as $k => $v): ?>
                                        <option
                                        <?php if (isset($oval[(int)$k])): ?>
                                            selected="selected"
                                        <?php endif ?>
                                        value="<?php echo htmlspecialchars($k) ?>">
                                            <?php echo $v ?>
                                        </option>
                                    <?php endforeach ?>
                                </select> Press CTRL button to select multiple categories
                            </td>
                        </tr>
                    
                   <!--
                    <?php elseif ($oname === 'cs_featured_ids'): ?>
                        <tr valign="top">
                            <th scope="row">
                                <label for="<?php echo $oname ?>"><?php echo $o['label'] ?></label>
                            </th>
                            <td>
                                <textarea style="width: 35em;" name="<?php echo $oname ?>"
                                id="<?php echo $oname ?>" class="regular-text"><?php echo get_option($oname) ?></textarea>
                                <p class="description">
                                    Fill this field to make Featured Products list work. Example: mikegeary1,1free,go4buck<br />
                                    50 IDs maximum.
                                </p>
                            </td>
                        </tr>
                    -->
                    <?php elseif ($o['type'] === 'checkbox'): ?>
                        <tr valign="top">
                            <th scope="row">&nbsp;<?php echo $o['label'] ?></th>
                            <td>
                                <fieldset>
                                    <legend class="screen-reader-text">
                                        <span><?php echo $o['label'] ?></span>
                                    </legend>
                                    <label for="<?php echo $oname ?>">
                                        <input name="<?php echo $oname ?>" type="checkbox"
                                        id="<?php echo $oname ?>" value="1"
                                        <?php if(get_option($oname)=='1'): ?>
                                            checked="checked"
                                        <?php endif; ?> />
                                        <!--Tick to reverse-->
                                    </label>
                                </fieldset>
                            </td>
                        </tr>
                    <?php elseif ($o['type'] === 'select'): $oval = get_option($oname); ?>
                        <?php  if ($oname !=='cs_theme_chosen') : ?>
                                                <tr valign="top">
                                                    <th scope="row">
                                                        <label for="<?php echo $oname ?>">&nbsp;<?php echo $o['label'] ?></label>
                                                    </th>
                                                    <td>
                                                        <select name="<?php echo $oname ?>" id="<?php echo $oname ?>">
                                                            <?php foreach ($o['vals'] as $k => $v): ?>
                                                                <option
                                                                <?php
                                                                if (gettype($k) === 'integer'
                                                                    && $oval == $v || gettype($k) !== 'integer'
                                                                    && $oval == $k):
                                                                ?>
                                                                    selected='selected'
                                                                <?php endif ?>
                                                                value='<?php
                                                                    echo htmlspecialchars(
                                                                        gettype($k) === 'integer' ? $v : $k)
                                                                ?>'><?php echo $v ?></option>
                                                            <?php endforeach ?>
                                                        </select>
                                                    </td>
                                                </tr>
                                <?php elseif ( get_option('cbproads_premium_store')) : ?>
                                             <tr valign="top">
                                                <th scope="row">
                                                    <label for="<?php echo $oname ?>">&nbsp;<?php echo $o['label'] ?></label>
                                                </th>
                                                <td>
                                                    <select name="<?php echo $oname ?>" id="<?php echo $oname ?>">
                                                        <?php foreach ($o['vals'] as $k => $v): ?>
                                                            <option
                                                            <?php
                                                            if (gettype($k) === 'integer'
                                                                && $oval == $v || gettype($k) !== 'integer'
                                                                && $oval == $k):
                                                            ?>
                                                                selected='selected'
                                                            <?php endif ?>
                                                            value='<?php
                                                                echo htmlspecialchars(
                                                                    gettype($k) === 'integer' ? $v : $k)
                                                            ?>'><?php echo $v ?></option>
                                                        <?php endforeach ?>
                                                    </select>
                                                </td>
                                            </tr>
                                 <?php endif; ?>
                                 
                    <?php   elseif ($o['type'] === 'int'): ?>
                       <?php  if (($oname !="cs_popular_num") ) : ?>
                        <tr valign="top">
                            <th scope="row">
                                <label for="<?php echo $oname ?>">&nbsp;<?php echo $o['label'] ?></label>
                            </th>
                            <td>
                                <input style="width: 5em;" type="text"
                                value="<?php echo get_option($oname) ?>" name="<?php echo $oname ?>"
                                id="<?php echo $oname ?>" class="regular-text" />
                                <?php if ($oname == 'cs_user_id'): ?>
                                    <p class="description">
                                        If you don't have one, get one at
                                        <a href="http://www.cbproads.com/" target="_blank">CBproAds.com</a>
                                    </p>
                                <?php elseif (substr($oname, -4) == '_num'): ?>
                                    <p class="description">
                                        For first 2 view variants use a multiple of number of products per line
                                    </p>
                                <?php elseif ($oname == 'cs_image_margin'): ?>
                                    <p class="description">
                                        Affects <strong>Title & Img</strong>
                                        and <strong>Title, Desc & Img</strong> views
                                    </p>
                                <?php endif ?>
                            </td>
                        </tr>
                        <?php endif ?>
                    <?php else: /* text */ ?>
                           <?php if( ( $oname!='cs_products_page') && ( $oname!='cs_review_page') ) { ?>
                                <tr valign="top">
                                    <th scope="row">
                                       <label for="<?php echo $oname ?>"> &nbsp;<?php echo $o['label'] ?></label>
                                    </th>
                                    <td>
                                        <input style="width: 7em;" type="text"
                                        value="<?php echo get_option($oname) ?>" name="<?php echo $oname ?>"
                                        id="<?php echo $oname ?>" class="regular-text" />
                                    </td>
                                </tr>
                            <?php } ?>
                    <?php endif ?>
                <?php endif ?>
            <?php endforeach ?>
        </table>
        <!--
        <h2>Advanced Options</h2>
        Attention! Please remember the default values of these options
        before changing them to have ability to roll back your changes.
        <table class="form-table">
            <?php foreach ($cs_ad_options as $oname => $o): ?>
                <?php if ($o['type'] === 'select'): $oval = get_option($oname); ?>
                    <tr valign="top">
                        <th scope="row">
                            <label for="<?php echo $oname ?>"><?php echo $o['label'] ?></label>
                        </th>
                        <td>
                            <select name="<?php echo $oname ?>" id="<?php echo $oname ?>">
                                <?php foreach ($o['vals'] as $k => $v): ?>
                                    <option
                                    <?php if (
                                        gettype($k) === 'integer' && $oval == $v
                                        || gettype($k) !== 'integer' && $oval == $k):
                                    ?>
                                        selected='selected'
                                    <?php endif ?>
                                    value='<?php
                                        echo htmlspecialchars(gettype($k) === 'integer' ? $v : $k)
                                    ?>'><?php echo $v ?></option>
                                <?php endforeach ?>
                            </select>
                        </td>
                    </tr>
                <?php else: /* text */ ?>
                    <tr valign="top">
                        <th scope="row">
                            <label for="<?php echo $oname ?>"><?php echo $o['label'] ?></label>
                        </th>
                        <td>
                            <input style="width: 35em;" type="text"
                            value="<?php echo get_option($oname) ?>" name="<?php echo $oname ?>"
                            id="<?php echo $oname ?>" class="regular-text" />
                        </td>
                    </tr>
                <?php endif ?>
            <?php endforeach ?>
        </table>
        -->
        <p class="submit">
            <input type="submit" name="cs_submit" id="cs_submit" class="button-primary"
            value="Update" />
        </p>
    </form>
    
    
    <?php
}

/**
 * Display JavaScript on the WP options page
 */
/*function cs_option_js()
{
    global $cs_options;
    
?>
<script type="text/javascript">
//<![CDATA[
    jQuery(document).ready(function($) {
        //var select = $('#cs_show_storefront_after_posts'),
        //    show_storefront_after_posts_change = function() {
        //        $('#cs_list_title').prop('disabled', select.val() == 'no');
        //    };
        //show_storefront_after_posts_change();
        //select.change(show_storefront_after_posts_change);
        //alert(jQuery('#cs_cats_to_omit').val());
        
        // Selects
        //<?php foreach ($cs_options['cs_cats_to_omit']['cur_val'] as $val => $tmp): ?>
            //jQuery('#cs_cats_to_omit option').val()
            //alert('<?php echo $val ?> => <?php echo $tmp ?>');
        //<?php endforeach ?>
    });
//]]>
</script>
<?php
}*/

?>