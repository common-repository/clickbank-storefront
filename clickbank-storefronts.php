<?php

/*
Plugin Name: Clickbank Storefronts
Description: This plugin allows you to host a World Class featured Clickbank Storefront (Mall) to your blog with just few clicks.
Author: CBproAds.com
Version: 1.7
Author URI: https://www.cbproads.com/
Plugin URI: https://www.cbproads.com/clickbank_storefront_wordpress_plugin.asp
*/


$GLOBALS['cs_plugin_version'] = '1.7';
$GLOBALS['cs_plugin_filename'] = 'clickbank-storefronts/clickbank-storefronts.php';
$GLOBALS['cs_plugin_dir'] = plugin_dir_path(__FILE__);
$GLOBALS['cs_plugin_url'] = plugin_dir_url(__FILE__);
if (substr($GLOBALS['cs_plugin_url'], -1) === '/') {
    $GLOBALS['cs_plugin_url'] = substr($GLOBALS['cs_plugin_url'], 0, -1);
}


$GLOBALS['cs_available_tags'] = array('h1', 'h2', 'h3', 'strong', 'div', 'span');
$GLOBALS['cs_options'] = array(
    'cs_user_id' => array(
        'req' => true,
        'type' => 'int',
        'label' => 'Your CBproAds Account ID',
        'default' => '15750',
    ),
    'cs_display_layout' => array(
        'req' => true,
        'type' => 'select',
        'vals' => array(
            '2' => '2 columns',
			'3' => '3 columns',
            '4' => '4 columns',
            '5' => '5 columns',            
            '6' => '6 columns'),
        'label' => 'Display Layout for Products',
        'default' => '3',
    ), /*
    'cs_image_descr_layout' => array(
        'req' => true,
        'type' => 'select',
        'vals' => array(
            'stack' => 'Stack',
            'horizontal' => 'Horizontal'),
        'label' => 'Product\'s Orientation <div style="margin:5px; padding:7px; background:lightyellow;"><font style="font-size:12px;" color=maroon> <i>The above \'Display Layout\' option will be ignored if HORIZONTAL option is selected.</i> </font></div>',
        'default' => 'stack',
    ),*/
    
    'cs_product_review_column' => array(
        'req' => true,
        'type' => 'select',
        'vals' => array(
            '3' => '3 columns',
            '2' => '2 columns'),
        'label' => 'Display Layout for Product Reviews',
        'default' => '2',
    ),  
    
   'cs_product_review_layout' => array(
        'req' => true,
        'type' => 'select',
        'vals' => array(
            'stack' => 'Stack',
            'horizontal' => 'Horizontal'),
        'label' => 'Product Review\'s Orientation <div style="margin:5px; padding:7px; background:lightyellow;"><font style="font-size:12px;" color=maroon> <i>The above \'Display Layout\' option will be ignored if HORIZONTAL option is selected.</i> </font></div>',
        'default' => 'horizontal',
    ),
    
    'cs_switch_view' => array(
        'req' => true,
        'type' => 'select',
        'vals' => array(
           // 'ti' => 'Title & Image',
            'tdli' => 'Standard'),
        'label' => 'View Style',
        'default' => 'tdli',
    ),
    
    'cs_show_price' => array(
        'req' => true,
        'type' => 'checkbox',
        'label' => 'Show Price',
        'default' => '1', // 0 or 1
    ),
    'cs_items_per_page' => array(
        'req' => true,
        'type' => 'int',
        'label' => 'Products per Page',
        'default' => '12',
    ),
    'cs_image_size' => array(
        'req' => true,
        'type' => 'int',
        'label' => 'Image Resolution<div style="margin:5px; padding:7px; background:lightyellow;"><font style="font-size:12px;" color=maroon> <i>The product\'s image size is calculated automatically as per the screen size. Changing this value will affect only the resolution of the image.</i> </font></div>',
        'default' => '300',
    ),
    /*
    'cs_title_text_color' => array(
        'req' => true,
        'type' => 'text',
        'label' => 'Title Text Color <div style="margin:5px; padding:7px; background:lightyellow;"><font style="font-size:13px;" color=maroon><i>Please leave  to inherit the theme\'s color theme.</i></font></div>',
        'default' => '#',
    ),*/
    'cs_image_border_style' => array(
        'req' => true,
        'type' => 'select',
        'vals' => array(
            'normal' => 'Normal',
            'rounded' => 'Rounded'),
        'label' => 'Prodcut Image Border Style',
        'default' => 'normal',
    ),
    
    'cs_image_border' => array(
        'req' => true,
        'type' => 'select',
        'vals' => array(
            'Yes' => 'Thick Border',
            'thin_border' => 'Thin Border',
            'No' => 'No Border'),
            'label' => 'Product Image Border<br />&nbsp;Thickness <!--(not avialble on rounded border style)-->',
        'default' => 'No',
    ),
      'cs_theme_chosen' => array(
        'req' => true,
        'type' => 'select',
        'vals' => array(
            'corporacy' => 'Corporacy',
			'orchid' => 'Orchid Pro',
            'astra' => 'Astra'),
            'label' => 'Theme Installed <!--(not avialble on rounded border style)-->',
        'default' => 'corporacy',
    ),
    /*
 
    'cs_view_more_text' => array(
        'req' => true,
        'type' => 'text',
        'label' => '"Read More" Text',
        'default' => 'Read More',
    ),
    'cs_view_more_style' => array(
        'req' => true,
        'type' => 'select',
        'vals' => array(
            'button' => 'Button Link',
            'link' => 'Text Link'),
        'label' => '"Read More" Style',
        'default' => 'link',
    ),
       'cs_title_class' => array(
        'req' => true,
        'type' => 'text',
        'label' => 'Title class name of theme',
        'default' => '',
    ),
    'cs_button_class' => array(
        'req' => true,
        'type' => 'text',
        'label' => 'Button style class name of theme',
        'default' => '',
    ),*/
    
    'cs_primary_color' => array(
        'req' => true,
        'type' => 'text',
        'label' => 'Primary Color',
        'default' => '#ee4455',
    ),
    'cs_secondary_color' => array(
        'req' => true,
        'type' => 'text',
        'label' => 'Background Fill Color',
        'default' => '#fcfcfc',
    ),
    'cs_label_color' => array(
        'req' => true,
        'type' => 'text',
        'label' => 'Price Tag Color<div style="margin:5px; padding:7px; background:lightyellow;"><font style="font-size:15px;" color=maroon><i>Default value: #ffa500</i></font></div>',
        'default' => '#ffa500',
    ),/*
    'cs_prodbox_fill_color' => array(
        'req' => true,
        'type' => 'text',
        'label' => 'Product Box Fill Color<div style="margin:5px; padding:7px; background:lightyellow;"><font style="font-size:15px;" color=maroon><i>Default value: #ffffff</i></font></div>',
        'default' => '#ffffff',
    ),
     'cs_prodbox_border_color' => array(
        'req' => true,
        'type' => 'text',
        'label' => 'Product Box Border Color<div style="margin:5px; padding:7px; background:lightyellow;"><font style="font-size:15px;" color=maroon><i>Default value: #f3f3f3</i></font></div>',
        'default' => '#f3f3f3',
    ),*/

    
    'cs_home_banner' => array(
        'req' => true,
        'type' => 'checkbox',
        'label' => 'Display Banner On Home Page',
        'default' => '1',
    ),
	
	'cs_review_banner' => array(
        'req' => true,
        'type' => 'checkbox',
        'label' => 'Hide Read Review Badge',
        'default' => '0',
    ),
    
	
    /*
    'cs_attach_menu' => array(
        'req' => true,
        'type' => 'checkbox',
        'label' => 'Attach Product Categories<br>&nbsp;On Main Menu<div style="margin:5px; padding:7px; background:lightyellow;"><font style="font-size:12px;" color=maroon> <i>This may slow down the loading of the page. Instead you can display categories using our CB categories widget.</i> </font></div>',
        'default' => '0', // 0 or 1
    ),*/
    'cs_rank' => array(
        'req' => true,
        'type' => 'int',
        'label' => 'Show Products Only Having <br>&nbsp;Rank Value at Least',
        'default' => '50',
    ),
    'cs_gravity' => array(
        'req' => true,
        'type' => 'int',
        'label' => 'Show Products Only Having<br>&nbsp;Gravity Greater than<div style="margin:5px; padding:7px; background:lightyellow;"><font style="font-size:12px;" color=maroon> <i>Gravity is a score that defines the amount of sales generated through the affiliates.</i></font></div>',
        'default' => '1',
    ),/*
    'cs_products_page' => array(
        'req' => false,
        'type' => 'select',
        'vals' => array(
            '' => 'No Page'),
        'label' => 'Categories Link Page<div style="margin:5px; padding:7px; background:lightyellow;"><font style="font-size:12px;" color=maroon> <i>Please create a new page placing <b>shortcode</b> <font style="font-size:15px; font-weight:bold;">[clickbank-storefront-products]</font> as  the content and link it here.</i></font></div>',
        'default' => '',
    ),
    'cs_review_page' => array(
        'req' => false,
        'type' => 'select',
        'vals' => array(
            '' => 'No Page'),
        'label' => 'Reviews Link Page<div style="margin:5px; padding:7px; background:lightyellow;"><font style="font-size:12px;" color=maroon> <i>Please create a new page placing <b>shortcode</b> <font style="font-size:15px; font-weight:bold;">[clickbank-product-review-details]</font> as  the content and link it here.</i></font></div>',
        'default' => '',
    ),*/
    'cs_reviews_show_cats' => array(
        'req' => false,
        'type' => 'select',
        'vals' => array(),
        'label' => '&nbsp;Show Product Reviews<br />&nbsp;Only From ',
        'default' => '',
    ),
    
    'cs_cats_to_omit' => array(
        'req' => false,
        'type' => 'select',
        'vals' => array(),
        'label' => '&nbsp;Categories to Omit<br />&nbsp;(CB Categories Widget)',
        'default' => '',
    ),
    
	'cs_home_page_cats' => array(
        'req' => false,
        'type' => 'select',
        'vals' => array(),
        'label' => '&nbsp;Show Home Page Content<br />&nbsp;Only From These Categories ',
        'default' => '',
    ),
    
    
    // Bestselling / Featured / Popular
    'cs_view_other' => array(
        'req' => true,
        'type' => 'select',
        'vals' => array(
            'ti' => 'Title with Image',
            'tdi' => 'Title, Description & Image',
            'tdli' => 'Title, Description, Long Description & Image',
            'td' => 'Title & Description'),
        'label' => 'Bestselling / Featured / Popular View',
        'default' => 'tdi',
    ),
    'cs_featured_ids' => array(
        'req' => false,
        'type' => 'text',
        'label' => 'Featured Product IDs',
        'default' => '',
    ),
    /*'cs_bestselling_num' => array(
        'req' => true,
        'type' => 'int',
        'label' => 'No of Products to Display in Best Selling Section',
        'default' => '12',
    ),
    'cs_featured_num' => array(
        'req' => true,
        'type' => 'int',
        'label' => 'No of Products to Display in Featured (Custom Products) Section',
        'default' => '12',
    ),
    
    'cs_popular_num' => array(
        'req' => true,
        'type' => 'int',
        'label' => 'No of Products to Display in Popular Products Section',
        'default' => '12',
    ),*/
);

$GLOBALS['cs_ad_options'] = array( // Advanced options
    'cs_title_tag' => array(
        'req' => true,
        'type' => 'select',
        'vals' => $GLOBALS['cs_available_tags'],
        'label' => 'Product Title HTML Tag',
        'default' => 'h3',
    ),/*
    'cs_title_style' => array(
        'req' => false,
        'type' => 'text',
        'label' => 'Product Title CSS Style',
        'default' => 'line-height: 1.3; font-size: 130%; font-weight: bold; padding: 0.4em;',
    ),
    'cs_subtitle_tag' => array(
        'req' => true,
        'type' => 'select',
        'vals' => $GLOBALS['cs_available_tags'],
        'label' => 'Product Description HTML Tag',
        'default' => 'strong',
    ),
    'cs_subtitle_style' => array(
        'req' => false,
        'type' => 'text',
        'label' => 'Product Description CSS Style',
        'default' => 'font-size: 120%; padding-bottom: 1em;',
    ),*/
    
);


$GLOBALS['cs_option_names'] = $GLOBALS['cs_options'];

$GLOBALS['cs_option_names'] = array_merge(
    array_keys($GLOBALS['cs_options']), array_keys($GLOBALS['cs_ad_options']));
    /*
$GLOBALS['cs_tw_defaults'] = array(
    'title' => 'Categories',
    'title_css' => '',
    'thumb_size' => 'large',
    'thumb_num' => 4,
    'bg_color' => 'F9F9F9',
    'border_color' => 'D6D6D6');
*/

require_once $GLOBALS['cs_plugin_dir'].'admin.inc.php'; // Defines all functions for Admin Panel
require_once $GLOBALS['cs_plugin_dir'].'functions.inc.php'; // Defines all functions (Product List)
require_once $GLOBALS['cs_plugin_dir'].'widgets.inc.php'; // Defines all widgets
require_once $GLOBALS['cs_plugin_dir'].'cb_menu.inc.php'; // Defines all widgets

if (!session_id()) session_start();

session_write_close();

// Fill session with current values & global values
$_SESSION['cs_plugin_url'] = plugins_url('', __FILE__);
foreach ($GLOBALS['cs_option_names'] as $o) {
    //if ($o !== 'cs_switch_view' || $_SESSION[$o] == '') {
        $_SESSION[$o] = get_option($o);
   // }
  // echo $o.": ".$_SESSION[$o]."<br>";
}

if ((int)$_SESSION['cs_image_size']>350){
    $_SESSION['cs_image_size']=350;
}
if ((int)$_SESSION['cs_items_per_page']>18){
    $_SESSION['cs_items_per_page']=18;
}


if ($_SESSION['cs_image_descr_layout']=='horizontal'){
     $_SESSION['cs_display_layout']='2';
     update_option('cs_display_layout', '2');
}

//update_option('cs_reviews_show_cats','');

//echo ' aim first'.$_SESSION['cs_display_layout'].'-----'.get_option('cs_display_layout');

$_SESSION['cs_switch_view_vals'] = $GLOBALS['cs_options']['cs_switch_view']['vals'];

// Attack WP actions, filters, hooks
register_activation_hook(__FILE__, 'cs_plugin_activate');
register_deactivation_hook(__FILE__, 'cs_plugin_deactivate');
if (is_admin()) {
    add_action('admin_menu', 'cs_add_to_menu');
    /*if (trim($_GET['page']) == 'cs_menu') {
        add_action('admin_head', 'cs_option_js');
    }*/
} else {
    /*
    if (isset($_GET['id']) && ($_GET['id'] = trim($_GET['id'])) != '') {
        setcookie('cs_user_id', $_GET['id'], time()+60*60*24*365, '/', cs_get_site_domain());
        $_SESSION['cs_user_id'] = $_COOKIE['cs_user_id'] = $_GET['id'];
    } elseif (isset($_COOKIE['cs_user_id'])) {
        $_SESSION['cs_user_id'] = $_COOKIE['cs_user_id'];
    }
    
    if (isset($_GET['tid']) && ($_GET['tid'] = trim($_GET['tid'])) != '') {
        setcookie('cs_tid', $_GET['tid'], time()+60*60*24*365, '/', cs_get_site_domain());
        $_SESSION['cs_tid'] = $_COOKIE['cs_tid'] = $_GET['tid'];
    } elseif (isset($_COOKIE['cs_tid'])) {
        $_SESSION['cs_tid'] = $_COOKIE['cs_tid'];
    }
    */
}

add_shortcode('clickbank-storefront-products', 'cs_show_filter');
add_shortcode('clickbank-storefront-bestselling', 'cs_show_bestselling');
add_shortcode('clickbank-storefront-featured', 'cs_show_featured');
add_shortcode('clickbank-storefront-popular', 'cs_show_popular');
(get_option('cbproads_premium_store')? add_shortcode('clickbank-storefront-supplements', 'cs_show_supplement'):"");
add_shortcode('clickbank-product-reviews', 'cs_show_reviews');
add_shortcode('clickbank-product-review-details', 'cs_show_filter');
add_shortcode('clickbank-storefront-intro', 'cs_show_intro');
add_shortcode('clickbank-horizontal-categories', 'cs_widget_horizontal_cats_display_shortcode');
add_shortcode('clickbank-popular-categories', 'cs_popular_categories_shortcode');
add_shortcode('clickbank-ads', 'cs_ads_shortcode');





/*if ($_SESSION['cs_show_storefront_after_posts'] != 'no') {
    add_filter('the_posts', 'cs_show_products');
}*/

// Add settings link on plugin page
$plugin = plugin_basename(__FILE__); 
add_filter("plugin_action_links_$plugin", 'cs_settings_link' );
//cs_settings_link

// Add widgets
add_action("widgets_init", 'cs_register_widgets');
add_action("init", 'cs_version_update');
if (get_option('cbproads_premium_store')){
	add_action("init", 'cs_add_mega_menu_items');
	add_action("init", 'cs_add_menu_reviews_items');
	add_action("init", 'cs_add_main_menu');
}
add_action("init", 'cs_sql_inject_check');

add_action( 'wp_ajax_cs_pagination_ajax_request', 'cbpro_show_pages' ); 
add_action("wp_ajax_nopriv_cs_pagination_ajax_request", "cbpro_show_pages");

// Get categories for all further calls
cs_get_categories((isset($_GET['cs_category']) ? $_GET['cs_category'] : null));

function cs_settings_link($links)
{
    
    $settings_link = '<a href="options-general.php?page=cs_menu">Settings</a>';
    array_unshift($links, $settings_link);
    
    return $links;
}

function cs_enqueue_scripts(){

	
	wp_register_style('cs_stylesheet', $GLOBALS['cs_plugin_url'].'/style.css?dgdsddddddsds'.date('Y-m-d'));
	wp_enqueue_style('cs_stylesheet');
	
	wp_register_style( 'Font_Awesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css' );
    wp_enqueue_style('Font_Awesome');
	
	//wp_enqueue_script('cbpro_jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js', array('jquery'), null, true);
	wp_enqueue_script('cbpro_main_script', plugin_dir_url(__FILE__).'/init.js');
	wp_localize_script( 'cbpro_main_script', 'cbpro_paging_ajax_object',
            array( 'global_cbpro_nonce' => wp_create_nonce('local_cbpro_nonce'), 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
	

	/*wp_register_style( 'Font_Awesome', 'https://ebookssolutions.com/wp-content/themes/flatsome/assets/css/fl-icons.css?ver=3.11' );
    wp_enqueue_style('Flat_icons');
	
		wp_register_style( 'Font_Awesome', 'https://ebookssolutions.com/wp-content/themes/flatsome/assets/css/flatsome.css?ver=3.11.3' );
    wp_enqueue_style('Flat_style');*/
	
	
	
	wp_enqueue_script(
		'cs_script_search',
		$GLOBALS['cs_plugin_url'].'/quick_search.js',
		array(),
		$GLOBALS['cs_plugin_version']);
}
add_action("wp_enqueue_scripts","cs_enqueue_scripts");

add_shortcode('clickbank-diet-3-columns', 'cs_diet_3_columns'); 
add_action('init', 'cs_redirect_product');

function cs_redirect_product(){
   if ( (isset($_GET['memnumber']))  && (isset($_GET['mem'])) & (isset($_GET['tar'])) ) {
        $link = ('https://cbproads.com/xmlfeed/wp/main/tracksf.asp'
            . '?memnumber='.$_GET['memnumber']
            . '&mem='.$_GET['mem']
            . '&tar='.$_GET['tar']
            . (isset($_SESSION['cs_tid'])
                ? '&tid='.$_SESSION['cs_tid']
                : (isset($_COOKIE['cs_tid'])
                    ? '&tid='.$_COOKIE['cs_tid']
                    : ''))
            . '&niche='.$_GET['niche']);
           // echo $link;
         //   exit;
        wp_redirect($link);
        exit;
    
   }
}


function cbpro_show_pages() {
	
	// verify the nonce as part of security measures
   	if ( !isset($_POST['cbpro_nonce']) || !wp_verify_nonce( $_POST['cbpro_nonce'], "local_cbpro_nonce")) {
      			//die ("No naughty business please");
  	} 
     

    if (!session_id()) session_start();

	if (isset($_GET['sortby'])) $_SESSION['cs_sortby'] = $_GET['sortby'];
	if (isset($_GET['switch_view'])) $_SESSION['cs_switch_view'] = $_GET['switch_view'];

	$output = cs_show($_GET['section'], $_GET['user_id'], $_GET['criteria'], $_GET['page'],$_GET['cs_mcat'],$_GET['cs_scat']);
	//echo $_GET['section'].$_GET['criteria'];
	echo $output['output'];

    // Always die in functions echoing AJAX content
   die();
}



   
?>