<?php

if (isset($GLOBALS['cs_plugin_dir'])) {
    require_once $GLOBALS['cs_plugin_dir'].'xmldb.inc.php';
} else {
    require_once 'xmldb.inc.php';
}


/**
* Remove <![CDATA[ and ]]> tags if exist
* ke
* @param string $data
* @return string
*/
if (!function_exists('cs_cdata')){
	function  cs_cdata($data)
	{
		if (substr($data, 0, 9) === '<![CDATA[' && substr($data, -3) === ']]>') {
			$data = substr($data, 9, -3);
		}

		return $data;
	}
}

/**
* Return formatted title
* 
* @param string $title
* @param bool $include_css_js
* @return string
*/
function cs_product_title_fmt($title, $link, $include_css_js = false)
{
    $t_title= (!$include_css_js
            ? "<$_SESSION[cs_title_tag]"
            . ($_SESSION['cs_title_style'] != ''
                ? " style=\"display: inline-block; "
                . ($_SESSION['cs_title_tag'] === 'div' ? 'text-align: center; ' : '')
                . "$_SESSION[cs_title_style]\""
                : '')
            . ">"
            : '')
        . "<a target=\"_blank\" href=\"$link\" rel=\"nofollow\">"
        . $title
        . "</a>"
        . (!$include_css_js
            ? "</$_SESSION[cs_title_tag]>"
            : '');
    
    $t_title = "<strong><a target=\"_blank\" href=\"$link\" rel=\"nofollow\" "
                ."style=\"line-height: 1.2; font-weight:bold; text-decoration:none;"
              
                ."color:" .((strlen($_SESSION['cs_title_text_color'])>2) ? $_SESSION['cs_title_text_color'] : ""). ";\">"
               
                .html_entity_decode($title)
                ."</a></strong>";
    
    if ($_SESSION['cs_display_layout']==2)      { $line_size="1.10em";  $line_height="1.20em";}
    elseif ($_SESSION['cs_display_layout']==3){ $line_size="1.05em"; $line_height="1.15em";}
    elseif ($_SESSION['cs_display_layout']==4){ $line_size="1.02em"; $line_height="1.12em";}
    elseif ($_SESSION['cs_display_layout']==6){ $line_size="1.00em"; $line_height="1.10em";}
    
     if (get_option('cbproads_premium_store')) {$cs_font_wt="bold";} else {$cs_font_wt="inherit";}
    
    $title="<a href='".$link."' target='_blank' >".$title."</a>";
    
    $t_title =        html_entity_decode($title);         
    return $t_title;
}

/**
* Get all CSS and JS code
* 
* @param int $totalp
* @param int $items_per_page
*/
function cs_get_css_js($totalp, $items_per_page)
{
    global $cs_plugin_version;
    
    #wp_register_style('cs_stylesheet', $_SESSION['cs_plugin_url'].'/style.css');
    #wp_enqueue_style('cs_stylesheet');
    if ($totalp > $items_per_page) cs_show_paging_css();
    
    /*wp_enqueue_script(
        'cs_script',
        $_SESSION['cs_plugin_url'].'/init.js'
        . '?plugin_url='.htmlspecialchars($_SESSION['cs_plugin_url']),
        array('jquery'),
        $cs_plugin_version);
		*/
}

/**
* Good htmlspecialchars
* 
* @param mixed $str
* @return string
*/
function hsc($str)
{
    return htmlspecialchars($str, ENT_QUOTES);
}

/**
 * Function to display product box
**/
function cs_product_box ($dummy,$p_title,$p_content,$link,$section,$price,$score,$description,$show_more_link,$read_review=null,$review_url){
    
						
						$cs_temp_col_cnt=substr($_SESSION['cs_display_layout'],0,1);
						if (	(($section==="search") ||($section==="category") ||($section==="main_category") ) && ($cs_temp_col_cnt==4) && ($_SESSION['cs_theme_chosen']==='orchid') ) {
						//	$cs_temp_col_cnt=3;
						}
                        

        
                        $cur_view = $_SESSION['cs_switch_view'];
                        $view_similar=(   (($section==='supplement') || ($section==='bestselling') || ($section==='featured') || ($section==='popular'))  && ($_SESSION['cs_switch_view'] ==='tdli')
                                                                              ?"<div align='center' style='padding:0px; margin-right:4px; margin-top:5px; margin-bottom:2px; ' ><a href='$show_more_link'  style='font-weight:normal;text-decoration:none; font-size:12px;color:#B8B8B8;' tagrget='_blank'><i class='fa fa-eye' aria-hidden='true' style='font-size:12px;color:#B8B8B8;'></i> View Similar</a></div>  "
                                                                              :''
                                                                             );
                            
                        $item_list_box .="<div ". (($dummy=="dummy")? "id=\"cs_hide_col\"" : ($_SESSION['cs_image_descr_layout']=='horizontal' ? "id=\"cs_horizontal\"": '') )." class=\"cs_column_".$cs_temp_col_cnt."\" style=\"\">\n\n";
                     
                        if (($read_review==='yes') && ($_SESSION['cs_review_banner']!='1')  ){
                               $item_list_box .="<a href='".$review_url."' style='text-decoration:none; color:white;' target='_blank'><div id='cs_read_review_ribbon' ><span style='position:absolute; top:12px; right:0px; text-align:center;z-index: 2; '>Read Review</span></div></a> ";
                        }

	   				


						
                        $item_list_box .= "<div align='center' class=\"cs_img_center\" style=\" margin-bottom:5px;  line-height:150%;   \"> \n";
                         
                        $item_list_box .= $p_content;
						$item_list_box .= "<div class='cbpro_title' >".$p_title."</div>"
											.cs_products_description($cur_view,$description,$tirm_mdescr,$section,$show_more_link,$read_review)
											.cs_price_view_more_similar_details($price)
											.cs_products_rating($score);
                                            
                                             
                    
                            
						//$item_list_box .= "<div class='cbpro_desc' >".
						//					cs_products_description($cur_view,$description,$tirm_mdescr,$section,$show_more_link,$read_review)
						//				     ."</div>";
                               
						$item_list_box .=  "\n</div> <!-- end of align=center -->\n";            // align=center

                        
                         
                        $item_list_box .=  "<div align='center' class='cbpro_view_more' >".
											"<a href='$link' target=_blank class='btn-general' style='background:".$_SESSION['cs_primary_color'].";'>".
											"<i class='fa fa-external-link' aria-hidden='true' style=''></i> More Details</a>".
											 		((  ($section==='supplement') ||($section==='bestselling') || ($section==='featured') || ($section==='popular'))
													 ?
											 		
													 "<a href='$show_more_link' target=_blank class='btn-general' style='margin-left:20px; background:".$_SESSION['cs_primary_color']."; '>
													 <i class='fa fa-eye' aria-hidden='true' style=''></i> Similar</a>"
													 :
													 ""
													 )
										   ."</div>\n <!-- end of cs position absoulte -->";
										
                                           
                        
	
                        $item_list_box .= "</div>\n<!-- end of cs cloumn -->\n\n";          // cs_column
                        
                        return $item_list_box;
                    
                }
                
                
                
/**
* Return HTML product list to insert into post / page / etc
* 
* @param string $section
* @param int $user_id
* @param int $criteria
* @param int $page
* @param int $product_number
* @return string
*/
function cs_show_related_reviews($user_id, $criteria){
    
        $output='';
       
        $p_data = cs_get_items('review-details', $user_id, 'related-reviews',4,        1,"","", false);
        if (empty($p_data['posts'])) {
           // $item_list = '<strong>Sorry, no results.</strong>';
        } else {
                
            $output.= '<div style="margin-top:100px;"><div align="center">'.cs_display_title("RELATED PRODUCT REVIEWS",$_SESSION['cs_primary_color'],"","show_title").'</div>'.$section;
                 
            $output.=  "<div id=\"cs_product_list\" style='border:1px solid #dcdcdc; background:#ffffff;//padding:10px; padding-top:20px;'>";
                
                $rows_count=0;
                
                foreach ($p_data['posts'] as $p) {
                    $rows_count=$rows_count+1;
                    
                    if (  ($rows_count==1) ||  ($rows_count==3) ||  ($rows_count==5) ) {
                            $item_list .="<div class='cs_row' style='margin-bottom:10px; border:1px; padding:5px;'>";
                    }
                     $item_list .="<div  class='cs_column_review' style='text-align:center; border:0px solid red; padding-left:20px; padding-right:20px;'>";
                     
                     $item_list .='<a href="'.$p['target_url'].'" >'.$p['post_content'].'</a>';
                     $item_list .='<div style="font-weight:normal; margin-top:0px; padding:3px;">'.$p['post_title'].'</div>';
                     $item_list .='</div>';
                     
                     if (($rows_count==2) ||(($rows_count==4))   ||(($rows_count==6))        ) {
                            $item_list .='</div>';
                    }
                }
            
            $output.=  $item_list.'';
            $output.=  "</div>"; //product list
            $output.=  "</div><div style='clear:both;'></div>";
           
        }
        
        return $output;
        
        
}


function cs_show_external_reviews($title, $url_return){
	
		
	    

	    
	    
	        $url="https://cbproads.com/xmlfeed/wp/main/cb_external_reviews.asp?cs_review_id=".$_GET['cs_review_id'];
	        $url=$url."&".date('Y-m-d');
	        //echo $url;
            $rss = fetch_feed($url);
            if (is_wp_error($rss)) return $empty_answer;
            if (0 == $rss->get_item_quantity(400)) { $totalp=0;}
            else{
        
          
                $items = $rss->get_items(0, 400);
                $tmp = $rss->get_item()->get_item_tags(SIMPLEPIE_NAMESPACE_RSS_20, 'total_products');
                $totalp = cs_cdata($tmp[0]['data']);
            }
            
            $item_list="";
            $rows_count=0;
           // echo 'total'.$totalp;
            
            if ($totalp>0) {
                
                $output= '<div style="margin-top:100px;"><h3>Customer Reviews </h3>';
	        
	      
	            $output.= "<div id=\"cs_product_list\" >";
                
                    foreach ($items as $item) {
        
                        $paths = $item->get_item_tags(SIMPLEPIE_NAMESPACE_RSS_20, "title");
                        $title = htmlspecialchars(cs_cdata($paths[0]['data']));
                  
                        $paths = $item->get_item_tags(SIMPLEPIE_NAMESPACE_RSS_20, "author");
                        $author = htmlspecialchars(cs_cdata($paths[0]['data']));
                        
                        $paths = $item->get_item_tags(SIMPLEPIE_NAMESPACE_RSS_20, "score");
                        $score = htmlspecialchars(cs_cdata($paths[0]['data']));
                        
                        $paths = $item->get_item_tags(SIMPLEPIE_NAMESPACE_RSS_20, "review");
                        $review = htmlspecialchars(cs_cdata($paths[0]['data']));
                        
                        $paths = $item->get_item_tags(SIMPLEPIE_NAMESPACE_RSS_20, "pdate");
                        $pdate = htmlspecialchars(cs_cdata($paths[0]['data']));
                        
                        $rows_count=$rows_count+1;
                            
                          
                             $item_list .="<div class='cs_row_external'>";
                         
                                 $item_list .="<div  class='cs_column_external_review_1'>";
                                 $item_list .="<img src='https://cbproads.com/reviews/images/author-avatar.jpg' class='img-responsive'>"."<div align='center'>".$author."</div>".cs_products_review_rating($score);
                                 $item_list .='</div>';
                                 
                                 $item_list .="<div  class='cs_column_external_review_2'>";
                                 $item_list .='<h5>'.$title.'</h5>';
                                 $item_list .='<p><i><span style="font-size:.87em; color:#A0A0A0;"> on '.$pdate.'</span></i></p>';
                                 $item_list .='<p id="review">'.$review.'</p>';
                                 $item_list .='</div>';
                             
                         
                            $item_list .='</div>';
                         
                    }
                    $output.= $item_list;
                    
                $output.=  "</div>"; //product list
                $output.=  "</div><div style='clear:both;'></div>";                                       
            }
            
            
                 $output.=  '<div style="margin-top:70px; background:#f0f0f0;  padding:20px; border-radius:5px;"><h3>Write A Review </h3>';
                 $output.=  '<p>Your email address will not be published. Please limit the review content to maximum 500 characters. </p>';
                 $output.=  "<div id=\"cs_product_list\" style='border:0px;'>";
                
                                
                    		    global $wp;

                              
                                //input form
                                $input_form.="<form class='form_external_Reviews' method='post' action='https://cbproads.com/xmlfeed/wp/main/grab_external_reviews.asp'>\n";
                                
                                 $input_form.="<h6>Rating</h6>";
                                 $input_form.='  <div class="rating_scale">';
                                
                                $input_form.='   <label>';
                                $input_form.='   <input type="radio" value="1" name="score"/><span>1</span>';
                                $input_form.='   </label>';
                                $input_form.='                                    <label>';
                                $input_form.='                                      <input type="radio" value="2" name="score"/><span>2</span>';
                                $input_form.='                                   </label>';
                                $input_form.='                                    <label>';
                                $input_form.='                                     <input type="radio" value="3" name="score"/><span>3</span>';
                                $input_form.='                                   </label>';
                                $input_form.='                                  <label>';
                                $input_form.='                                     <input type="radio" value="4" name="score"/><span>4</span>';
                                $input_form.='                                   </label>';
                                $input_form.='                                  <label>';
                                $input_form.='                                   <input type="radio" value="5" name="score"/ checked><span>5</span>';
                                $input_form.='                                 </label>';
                                $input_form.='                               </div><br>';
                                                
                                $input_form.="<h6>Headline</h6><input type='text' style='width:100%;' name='headline'><br \>\n";
                                $input_form.=  "<h6>Your Review</h6><textarea name='review'></textarea><br \>\n";
                                $input_form.="<h6>Name</h6><input  type='text' name='names'><br \>\n";
                                $input_form.="<h6>Email</h6><input  type='text' name='email'><br \>\n";
                                $input_form.="<input type=hidden name='id' value='".$_GET['cs_review_id']."'>\n";
                                $input_form.="<input type=hidden name='title' value='".$title."'>\n";
                                $input_form.="<input type=hidden name='ret_url' value='".$url_return."?".$_SERVER['QUERY_STRING']."'>\n";
                                 $input_form.="<input type=submit value='Submit Review'>\n<br \><br \>\n</form>";
                                    
                                             
                               // $input_form.='</div>';
                                
                                $output.=  $input_form;
            
            
        		$output.=  "</div>"; //product list
                $output.=  "</div><div style='clear:both;'></div>";
                return $output;
}






function cs_display_title($title,$pad_color,$section,$show_title){
	if ($show_title==="no"){
		return;
	}
    
    $title=htmlspecialchars_decode($title);
    $title=str_replace('&amp;','&',$title);
    $title=strip_tags($title);
    $title=htmlspecialchars($title);
    $title=cs_xss_clean($title);
    
    //var_dump($title);
    //wp_die();
      $review_writeup_new='';         
     $arr_res = explode(' ',trim(($title)));
     
    
     
          if ($section==="reviews"){
        
             $review_writeup_new.='<p>In this section, you will find unbiased <strong>reviews</strong> of the best performing products of Clickbank. '.
                                'Most of the products are proven with the highest buyer satisfaction rate.<br></p>';
                          
        }elseif ($section==="popular"){
            
            $review_writeup_new.='<p>Features the best rated products</p> ';
                            
        }elseif ($section==="bestselling"){
            
            $review_writeup_new.='<p>Features the best rated products of Clickbank</p> ';
                            
        }elseif ($section==="featured"){
            
            $review_writeup_new.='<p>Features the best rated products of Clickbank</p> ';
                            
        }else{
             $review_writeup_new.='';
        }
        
       
       
        return ('<div id="cs_heading_title" class="cs_heading_div" style="margin-left:20px; margin-right:20px; padding-top:0px; padding-bottom:20px; border:0px solid '.$_SESSION["cs_primary_color"].';" >'.
            '<h2><span>'.
            '<strong style="color:'.$pad_color.';">'.$arr_res[0].'</strong> '. $arr_res[1].' '. $arr_res[2].' '. $arr_res[3] .' '.$arr_res[4]. ' '.$arr_res[5].' '.$arr_res[6].' '.$arr_res[7].'</span></h2>'.
            $review_writeup_news.'</div>');
}
    

function cs_show($section, $user_id, $criteria = null, $page = 1, $get_mcat, $get_scat, $product_number = null)
{
    if (in_array($section, array('main_category','category', 'search'), true)) {
        $cur_view = $_SESSION['cs_switch_view'];
    } else {
        $cur_view = $_SESSION['cs_view_other'];
    }
  
  
    $p_data = cs_get_items($section, $user_id, $criteria,
        ($product_number !== null ? $product_number : $_SESSION['cs_items_per_page']),
        $page, $get_mcat,$get_scat, false);
        
    if (empty($p_data['posts'])) {
        $item_list = '<strong>Sorry, no results.</strong>';
    } else {
        $item_list = '';
        $row_count=0;
       // $column_limit=$_SESSION['cs_items_per_page']/$_SESSION['cs_display_layout'] + 1;
        $column_limit=substr($_SESSION['cs_display_layout'],0,1);
    
		if (	(($section==="search") ||($section==="category") ||($section==="main_category") )  && ($column_limit==4) && ($_SESSION['cs_theme_chosen']==='orchid') ) {
			$column_limit=3;
		}
		
        // $item_list .="<div class=\"cs_row\">\n\n";
         //var_dump($p_data);
         
        $pad_color=(strlen($_SESSION['cs_primary_color'])>2 ? $_SESSION['cs_primary_color']: '#cccccc');
        

        
        foreach ($p_data['posts'] as $p) {
            
            $row_count=$row_count+1;
            
            if(  ($section==="reviews") || ($section==="review-details")){
               
               
                
                if ($_SESSION['cs_product_review_layout']==='horizontal'){
                            $item_list .="<div class=\"cs_row_horizontal\"  style='border-top:".($row_count>1?'0':'0')."px dotted #dcdcdc;'>\n\n";
                            $item_list .=      "<div  class='cs_column_review_1' style='text-align:left;margin-bottom:5px; '>".                        
                                                    
                                                    "<div style='overflow: hidden;'><a href='".$p['target_url']."'>".$p['post_content']."</a></div>".
                                              
                                                    
                                                "</div>";
                                                
                                                
                                                //color:".((strlen($_SESSION['cs_title_text_color'])>2) ? $_SESSION['cs_title_text_color'] : 'inherit')
                            $item_list .=      "<div  class='cs_column_review_2' style='text-align:left;border:0px solid red;'>".       
                                                    //"<header class='entry-header'>".
                                                    
                                                       "<h4 ".(strlen($_SESSION['cs_title_class'])>4 ? 'class="'.$_SESSION['cs_title_class']."\"": '').
                                                       " style='font-weight:inherit; margin-top:0px; margin-bottom:5px;  text-transform:capitalize; line-height:1.33em; font-size:1.3em;   '  ><a style='color:#404040; text-decoration:none;' href='".$p['target_url']."'>".str_replace("Review","Review",$p['post_title']).
                                                        (($section==="review-details")? '':'').
                                                        "</a></h4>".  
                                                    //"</header>".
                                                    "<span style='font-size:0.8em;color:#B0B0B0;'><i class='fa fa-user' aria-hidden='true' style='font-size:16px;color:silver;'></i> by admin   ".
                                                    "<i class='fa fa-calendar' aria-hidden='true' style='font-size:16px;color:silver;'></i> ".date('d/F/Y', strtotime($p['pdate'])).'</span>'.
                                                    "<p style='margin-top:12px; margin-bottom:0px; padding-right:8px;'>".substr($p['review_desc'], 0, 150).' [...]</p>'.
             
                                                    "<div style='".($_SESSION['cs_view_more_style']==='button' 
                                                                    ? 'text-align:left; margin-bottom:15px; margin-top:15px;'
                                                                    : 'text-align:right; margin-right:12px; margin-top:7px;').
                                                                "'>".
                                                                    ($_SESSION['cs_view_more_style']==='button' 
                                                                    ? '<a href="'.$p['target_url'].'"   class="'.$_SESSION['cs_button_class'] .'" style="text-decoration:none;">Full Review &raquo;</a>'
                                                                    : '<a href="'.$p['target_url'].'"   style="text-decoration:none;">Full Review &raquo;</a>'
                                                                    ).
                                                     "</div>".
                                                     
                                                     
                                                  "</div><div style='clear:both;'></div>";
                                                
                             $item_list .="</div>". //cs_row
                                            "\n<!-- end of reviews row -->";
                                            
                }else{                  ///********************** stack model layout**********************************
              
              
                    if ( isset($_SESSION['cs_product_review_column'])  && $_SESSION['cs_product_review_column']>0    ) {
                        $cs_product_review_columns=$_SESSION['cs_product_review_column'];
                       $cs_product_review_columns=str_replace(" columns","",$cs_product_review_columns);
                       if ($cs_product_review_columns==3){ $trim_descr=130;}else{$trim_descr=200;}
                    }
                    else{
                        $cs_product_review_columns=2;
                        $trim_descr=200;
                    }
                   
                    //if($row_count %$cs_product_review_columns==1) { 
                     if ( $row_count==1 ) {
                         $item_list .="\n\n<div  class='cs_column_review_stack_main'   >\n\n\n";  
                    }
                         $item_list.=  "<div class='cs_column_review_stack_$cs_product_review_columns' style='position:relative; margin-bottom:30px;  border:1px dotted #dcdcdc; text-align:left; background:#ffffff; '>\n" ; 
                                         $item_list .="<div style='overflow: hidden;'><a href='".$p['target_url']."'>".$p['post_content']."</a></div>\n".  
                                                    "<div style=' padding-left:2px; padding-bottom:5px; padding-right:2px;'>".
                                                        "<h4 style='margin-top:12px; margin-bottom:3px; font-weight:inherit; text-transforms:capitalize; line-height:1.33em; font-size:1.3em;  ' ".(strlen($_SESSION['cs_title_class'])>2 ? 'class="'.$_SESSION['cs_title_class']."\"": '').
                                                       " ><a style='color:#404040;text-decoration:none;' ".
                                                            "href='".$p['target_url']."'>".
                                                            str_replace("Review","Review",$p['post_title']).
                                                            
                                                            
                                                        (($section==="review-details")? "":"").
                                                        "</a></h4>".
                                                        "<span style='margin-top:0px; font-size:0.85em;color:#B0B0B0;'><i class='fa fa-user' aria-hidden='true' style='font-size:12px;color:silver;'></i> by admin   ".
                                                        "<i class='fa fa-calendar' aria-hidden='true' style='font-size:12px;color:silver;'></i> ".date('d/M/Y', strtotime($p['pdate'])).'</span>';
                                                         
                                                         if (   ($_SESSION['cs_switch_view'] ==='tdli') && ( ($section==="review-details") ||($section==="reviews") )){ //
                                        $item_list .=           // "<div id='bread_crumb_reviews' align='left' style=' margin-top:10px; '>\n".
                                                                " <span> <i class='fa fa-folder-open' style='font-size:12px;color:silver;' aria-hidden='true'></i> ".
                                                                    "<a style='font-size:0.85em; font-weight:normal;' href='".$p['m_target_url']."'>".$p['mcname']."</a></span> ";
                                                                   //"<i class='fa fa-angle-right' style='font-size:12px;color:silver;'aria-hidden='true'></i> ".
                                                                   // "<a style='font-size:13px; font-weight:normal;' href='".$p['s_target_url']."'>".$p['scname']."</a>".
                                                                   //"</div>\n<!-- of bread crumb-->\n";
                                                         }
                                                        if (   $_SESSION['cs_switch_view'] ==='tdli'){ //standard
                                                            $item_list .=  '<p align="left" style="margin-top:15px; margin-bottom:5px; font-size:1em;">'.substr($p['review_desc'], 0, $trim_descr).'...</p><br>'.(($_SESSION['cs_view_more_style']==='button' ) ? '<br>' :'' );
                                                        }else{
                                                            $item_list .= (($_SESSION['cs_view_more_style']==='button' ) ? '<br><br>&nbsp;' :'<br>&nbsp;' ) ;
                                                        }
                                           $item_list.="</div><!-- of h4-->\n\n ";             
                                            
                                           $item_list .=           "<div style='position:absolute; bottom:25px; padding-left:7px;  padding-right:5px; ".($_SESSION['cs_view_more_style']==='button' 
                                                                    ? 'text-align:left; margin-bottoms:15px; margin-tops:15px;'
                                                                    : 'text-align:left; margin-rights:5px; margin-tops:27px;').
                                                                "'>\n".
                                                                    ($_SESSION['cs_view_more_style']==='button' 
                                                                    ? '<a href="'.$p['target_url'].'"   class="'.$_SESSION['cs_button_class'] .'" style="text-decoration:none;">Full Review &raquo;</a>'
                                                                    : '<a href="'.$p['target_url'].'"   style="text-decoration:none;">Full Review &raquo;</a>'
                                                                    ).
                                                                "</div>\n<!-- end fof view style ==button-->";
                                             
                                        $item_list.="</div><!-- of  review column stack div-->\n\n";
                                        
                    if($row_count %$cs_product_review_columns==0) { 
                        // $item_list .="</div><!-- end of row complete stack main -->\n\n\n";  
                    } 
                } //end iof stack or horizontal
     
     
     
     
     
     
      
     
            }else{
                
                   // $title_new="$p[post_title]";
                    $item_list .= "\n";
                    if (in_array($cur_view, array( 'td'), true)) {
                        $item_list .=
                            /*"<span class=\"cs_pr_title_link\" onclick=\"window.open('$p[target_url]')\">"
                            . "$p[post_title]</span><br />\n"*/
                            "$p[post_title]<br />\n"
                            . "$p[post_content]<br />\n"
                            . "<hr />\n";
                    } else {
                       //echo  $p['review_desc'] ;
                        
                        //  if ((($row_count % $column_limit==1) || ($row_count==1))   ) {
                        if ( $row_count==1 ) {
                           $item_list .="<div class=\"cs_row\" >\n\n";
                        }
                         
                                $item_list .=cs_product_box("",$p['post_title'],$p['post_content'],$p['link'],$section,$p['price'],$p['score'],$p['descr'],$p['show_more_link'],$p['read_review'],$p['review_url']);        
         
                     //  if ($row_count % $column_limit ==0) {
                            //remnove block // to put dummy box
                            // $item_list .=cs_product_box("dummy",$p['post_title'],$p['post_content'],$p['link'],$section,$p['price'],$p['score'],$p['descr'],$p['show_more_link']); 
                          //  $item_list .="</div>\n<!-- end of cs_row -->\n\n\n\n";
                      // }
                       
                    }
            }//end of section reviews
        }
        //adding that extra </div> if rowcount is not matched to fulfill al the colmuns in the last cs_row of products.
        if(  ($section==="reviews") || ($section==="review-details")){
               if ($_SESSION['cs_product_review_layout']!='horizontal'){
                   $item_list .="</div><!-- end of row complete stack main ...-->\n\n\n";  
               }
        }else{
            
             //$item_list .="i have added". $row_count % $column_limit ;
                //if ($row_count % $column_limit !=0) {  
                 // $item_list .="i have added";
               $item_list .="</div>\n<!-- end of cs_row added at end -->\n\n\n\n";
                //}        
        }
       
    }
    
    
    //related reviews show
    if ((strlen($_GET['cs_review_id'])>10)  && ($section==='review-single') ){
        //echo 'sectio is'.$section.$p['post_content'];
        //$p_data = cs_get_items('review-details', $user_id, $criteria,2,        1, false);
        //VAR_DUMP($p_data['posts'][0]['post_title']);
        //print_r($p_data);
            $item_list = $p['post_content'];
            $item_list .= cs_show_external_reviews($p_data['posts'][0]['post_title'], $p_data['posts'][0]['urls']);
            $item_list .= cs_show_related_reviews($user_id, $criteria);
            // $item_list .="</div>\n";
            //echo $criteria.$section.$product_number;;
            //cs_show($section, $_SESSION['cs_user_id'], $criteria, 1, $_GET['cs_mcat'],$_GET['cs_scat'],$product_number);
    } //end if related reviews
    
    
    
    
    if (in_array($cur_view, array('tdli','tdi', 'ti'), true)) {
       // $item_list .= "<br /><br />\n";
    }
    
    $cs = '';
    

   // $cs .= "<hr />\n";
    
    $list_center_align =
        in_array($section, array('main_category','category', 'search'), true)
        && in_array($_SESSION['cs_switch_view'], array('ti', 'tdi'), true)
        || !in_array($section, array('main_category','category', 'search'), true)
        && in_array($_SESSION['cs_view_other'], array('ti', 'tdi'), true);
    if (    (   $list_center_align) &&  ($section!='review-single') ){
        $cs .= "<div style=\"text-align: center\">\n";
    }
    if (in_array($section, array('main_category','category', 'search'), true)
        && !empty($p_data['posts']))
    {
        $cur_sortby = (isset($_SESSION['cs_sortby']) ? $_SESSION['cs_sortby'] : 'rank');
       
        
        // Sort criteria
        if (($section === 'main_category') || ($section === 'category')) {
            $cs .= "<div style=\"margin-right:15px; text-align: right\">";
               // . "<strong>Sort</strong> ";
            $sortby_vals = array(
                'rank' => 'By Higher Rank',
                'gravity' => 'By Higher Gravity');
            if ($_SESSION['cs_show_price'] == '1') {
                ///$sortby_vals['price_h'] = 'High to Low Price';
               // $sortby_vals['price_l'] = 'Low to High Price';
            } elseif (
                isset($_SESSION['cs_sortby'])
                && in_array($_SESSION['cs_sortby'], array('price_h', 'price_l'), true))
            {
                $_SESSION['cs_sortby'] = 'rank';
            }
            $cs .= "<select id=\"cs_sotrby\" "
                . "onchange=\"cs_show_page('$section', '$user_id', '$criteria', "
                . "1, this.value, '$cur_view', '$get_mcat' , '$get_mcat')\" "
                . "style=\"width: 11em\">\n";
            foreach ($sortby_vals as $val => $text) {
                $cs .= "<option value=\"$val\"";
                if ($val === $cur_sortby) $cs .= " selected=\"selected\"";
                $cs .= ">$text</option>\n";
            }
            $cs .= "</select>\n"
                . "</div>\n";
        }
         $cs .= "<!--<br />-->\n";
    }
    if (in_array($section, array('main_category','category', 'search'), true)) {
        $cs .= cs_show_paging($section, $user_id, $criteria,
            $p_data['totalp'], $_SESSION['cs_items_per_page'], $get_mcat, $get_scat, $page);
    } elseif (in_array($section, array('review-details'), true)){
      $cs .= cs_show_paging($section, $user_id, $criteria,
            $p_data['totalp'], $_SESSION['cs_items_per_page'], $get_mcat, $get_scat, $page);
    }
    
    $cs .= $item_list;
//    if ($list_center_align) {
    if (    (   $list_center_align) &&  ($section!='review-single') ){

        $cs .= "</div>\n";
    }
    if (in_array($section, array('main_category','category', 'search'), true)) {
        $cs .= "<div style=\"border:0px solid red; margin-top:30px; margin-bottom:30px; text-align: center\">".
                cs_show_paging($section, $user_id, $criteria,
                $p_data['totalp'], $_SESSION['cs_items_per_page'], $get_mcat, $get_scat, $page).
                "</div>";
        
            if($section==='category'){
               //  $cs.=cs_show_related_categories($_GET['cs_category'],"sub");
              
            }
            if($section==='main_category'){
                 
                // $cs.=cs_show_related_categories($_GET['cs_main_category'],"main");
              
            }
       // $cs .= 'i comes here';    
    } elseif (in_array($section, array('review-details'), true)){
     //  echo 'yasaraaa'.$section;
      $cs .= cs_show_paging($section, $user_id, $criteria,
            $p_data['totalp'], $_SESSION['cs_items_per_page'], $get_mcat, $get_scat , $page);
    } elseif (in_array($section, array('reviews'), true)) {
    
    } else {
        //$cs .= "<br />\n";
    }
    
    return array('output' => $cs, 'totalp' => $p_data['totalp']);
}

/**
* Return HTML product list to insert into post / page / etc
* 
* @param string $section
* @param string $criteria
* @param string $title
* @param int $product_number
*/
function cs_show_filter_contents($section, $criteria, $title, $product_number = null,$show_title)
{

    if ($section==='null-category'){
              //$tt=cs_widget_horizontal_cats_display('',''); 
    }else{
        
        $product_list = cs_show($section, $_SESSION['cs_user_id'], $criteria,
        1, $_GET['cs_mcat'],$_GET['cs_scat'],$product_number);
       
        cs_get_css_js($product_list['totalp'], $_SESSION['cs_items_per_page']);
    }
    
    $_SESSION['cs_cur_url'] = get_permalink();
    $_SESSION['cs_site_url'] = site_url();
    if (false === $_SESSION['cs_cur_url']) $_SESSION['cs_cur_url'] = $_SESSION['cs_site_url'];
    if ($section === 'category') {
        $_SESSION['cs_cur_url'] = cs_get_url($_SESSION['cs_cur_url'], array('cs_category' => $criteria));
    } elseif ($section === 'search') {
        $_SESSION['cs_cur_url'] = cs_get_url($_SESSION['cs_cur_url'], array('cs_keywords' => $criteria));
    }
    $_SESSION['cs_cur_url'] = htmlspecialchars($_SESSION['cs_cur_url'], ENT_QUOTES);
    $pad_color=(strlen($_SESSION['cs_primary_color'])>2 ? $_SESSION['cs_primary_color']: '#808080');



    
   if (($section==="bestselling") || ($section==="featured") || ($section==="popular") || ($section==="reviews") ){
        //  $margin_writeup="margin-top:70px;";
          
          if ($section==="bestselling") {
             $tt='<div class="cs_row_banners" >'.
                        '<div class="cs_row_banner_column_1">'.
                        '<a  href="'.str_replace("?cs_category=","",cs_get_products_page('cs_category', '')).'?cs_keywords=make money online"><img src="https://cbproads.com/clickbankstorefront/v5/assets/images/Onlinemarketing.png" class="img-responsive"></a></div>'.
                  '</div>';
          }
          if ($section==="popular") {
               $tt='<div class="cs_row_banners" >'.
                        '<div class="cs_row_banner_column_1" >'.
                        '<a href="'.str_replace("?cs_category=","",cs_get_products_page('cs_category', '')).'?cs_keywords=forex">'.
                            '<img src="https://cbproads.com/clickbankstorefront/v5/assets/images/forex.jpg" class="img-responsive">'.
                        '</a></div>'.
                  '</div>';
                
          }
          
           if ($section==="featured") {
               $tt='<div class="cs_row_banners" >'.
                        '<div class="cs_row_banner_column_1" >'.
                        ' </div>'.
                    '</div>';
          }
          if ($section==="reviews") {
              
                 $tt='<div class="cs_row_banners" style="margin-bottom:20px; margin-top:20px;">'.
                      
                  '</div>';
          }
          
    }
    
   if($section != 'review-single'){
        
                   if( ($_SESSION['cs_home_banner'] == '1') ){
                       //$banner_reviews= "<div align='center' style='margin:0px; margin-top:0px; margin-bottom:30px;'><img src='https://cbproads.com/reviews/images/banner-1000x385-crisp.png' class='img-responsive' ></div>";
                   }
                       
                   $review_writeup.= cs_xss_clean(cs_display_title($title,$pad_color,$section,$show_title));
             
            		if     ($title==="do_not_show_title"){
            		    
            		    
            		    if ($section === 'review-details')    {    $review_writeup= $banner_reviews;}
            		    else{		    $review_writeup= "";}
            		}
            		else{
            		     if ($section === 'review-details')    {    $review_writeup= $banner_reviews.$review_writeup ;}
            		}
    }
    
   
    
        if (
            ($section!='related_products') &&
            ($section!='reviews') 
        )
        {
            //$cb_ads=cs_show_cb_banner_ads('horizontal',($section==="popular"?'2':'1'))."<br\>";
        }
    
    
    //implementing KET & pLAEO other special categories serches
    if (get_option('cbproads_premium_store')) {
        if ($_GET['cs_keywords']==="keto") {
            $res= file_get_contents('https://cbproads.com/xmlfeed/WP/main/special_searches/keto/keto1.asp?theme='.$_SESSION['cs_theme_chosen']);
        }
        if ($_GET['cs_keywords']==="paleo") {
            $res= file_get_contents('https://cbproads.com/xmlfeed/WP/main/special_searches/paleo/paleo1.asp?theme='.$_SESSION['cs_theme_chosen']);
        }
        if ($_GET['cs_keywords']==="vegan") {
            $res= file_get_contents('https://cbproads.com/xmlfeed/WP/main/special_searches/vegan/vegan1.asp?theme='.$_SESSION['cs_theme_chosen']);
        }
    }
    
    $res .= <<<HD
         $review_writeup
    
        <div id="cs_loading_label" style="display: none; position: fixed; text-align: center">
          <h1 style="font-weight: bold">
            Loading the page...
          </h1>
        </div>\n
        HD;

 
    if ($section!="review-single")  {  
    
        if (  
           (get_option('cbproads_premium_store')) 
           && 
           ( ($_GET['cs_keywords']==="keto") ||
             ($_GET['cs_keywords']==="paleo") || 
             ($_GET['cs_keywords']==="vegan") 
           )
         )
            
        {
                
                $res .= "<div id=\"cs_product_list\" style=\" background:#F0F1F1;\">\n"
                    . "$product_list[output]\n";
                         if ($section==='null-category'){
                           $res .=cs_widget_horizontal_cats_display('',''); 
                        }
                $res .= "</div>\n".$cb_ads;
        }else{
                $res .= "<div id=\"cs_product_list\" style=\" background:".(strlen($_SESSION['cs_secondary_color'])>2?$_SESSION["cs_secondary_color"]:'#F0F0F0')."; \">\n"
                    . "$product_list[output]\n";
                         if ($section==='null-category'){
                           $res .=cs_widget_horizontal_cats_display('',''); 
                        }
                $res .= "</div>\n".$cb_ads;
        }
    }
    
    //implementing KET & pLAEO other special categories serches
    if (get_option('cbproads_premium_store')) {
        if ($_GET['cs_keywords']==="keto") {
            $res.= file_get_contents('https://cbproads.com/xmlfeed/WP/main/special_searches/keto/keto2.asp?theme='.$_SESSION['cs_theme_chosen']);
        }
        if ($_GET['cs_keywords']==="paleo") {
            $res.= file_get_contents('https://cbproads.com/xmlfeed/WP/main/special_searches/paleo/paleo2.asp?theme='.$_SESSION['cs_theme_chosen']);
        }
         if ($_GET['cs_keywords']==="vegan") {
            $res.= file_get_contents('https://cbproads.com/xmlfeed/WP/main/special_searches/vegan/vegan2.asp?theme='.$_SESSION['cs_theme_chosen']);
        }
    }
 
        
    if ( ($section==="null-category")  ){
        
       // $res .=cs_widget_horizontal_cats_display('','');
    }
    
    if($section==='category'){
        $res.=cs_show_related_categories($_GET['cs_category'],"sub");
    }
    if($section==='main_category'){
         
         $res.=cs_show_related_categories($_GET['cs_main_category'],"main");
   }
    
    if ($section==="review-single"){ 
        return $product_list['output'];   }
    else{     
        return $res;   }
}

/**
* Return HTML product list to insert into post / page / etc
* 
* @param array $attrs
* @return string
*/
function cs_show_filter($attrs = array())
{
    
    if (isset($_GET['cs_section'])) {
        $section = $_GET['cs_section'];
        $product_list_criteria = $title = '';
    } elseif (isset($_GET['cs_main_category'])) {
        $section = 'main_category';
        $selected_cat = $_GET['cs_main_category'];
       //$category = cs_get_categories($selected_cat);
        //$category = cs_get_categories(247);
        //print_r($category);
        $category = $_GET['cs_main_category_name'];
        $title = "$category";
       // echo 'yasar                 jkkkkkkkkkkkkkkkkkkkk'.$category;
        
        $product_list_criteria = $selected_cat;
    } elseif (isset($_GET['cs_category'])) {
        $section = 'category';
        $selected_cat = $_GET['cs_category'];
        $category = cs_get_categories($selected_cat);
        //$category = cs_get_categories(247);
        //print_r($category);
        $category = $category['selected_name'];
        $title = "$category";
        $product_list_criteria = $selected_cat;
    } elseif (isset($_GET['cs_keywords'])) {
        $section = 'search';
        $product_list_criteria = $_GET['cs_keywords'];
        $title = "Search Results for \"".htmlspecialchars($product_list_criteria)."\"";
       if ($_GET['cs_keywords']==="keto") {
            $title = "Recommended ".htmlspecialchars($product_list_criteria)." Prorgams";
       }
       if ($_GET['cs_keywords']==="vegan") {
            $title = "Recommended ".htmlspecialchars($product_list_criteria)." Prorgams";
       }
       if ($_GET['cs_keywords']==="paleo") {
            $title = "Recommended ".htmlspecialchars($product_list_criteria)." Prorgams";
       }
    } elseif (isset($_GET['cs_review_id'])) {
        $section = 'review-single';
    }else{
        
        if(strpos(cs_get_products_page(), $_SERVER['REQUEST_URI']) >0){
                    $section = 'null-category';
                    $title = "ClickBank Product Categories";
                    
        //}elseif(strpos(cs_get_review_page(),$_SERVER['REQUEST_URI']) >0 )
		}elseif(strpos(cs_get_review_page(),         $_SERVER['REQUEST_SCHEME'] .'://'. $_SERVER['HTTP_HOST']  . explode('?', $_SERVER['REQUEST_URI'], 2)[0]   ) ==0 )
        {
                    $section = 'review-details';
                    echo $review_writeup;       
      
                    if ( (isset($_GET['cs_mcat']))  &&  (isset($_GET['cs_scat']))    ){
                        $selected_cat = $_GET['cs_scat'];
                        $category = cs_get_categories(11);
                        //print_r($category);
                        $category = $category['selected_name'];
                       // echo 'fff'.$selected_cat;
                        $title = "Reviews: ".htmlspecialchars($category);
                        
                            $title = "do_not_show_title";
                       
                    }elseif (isset($_GET['cs_mcat']) || (strlen($_SESSION['cs_reviews_show_cats'])>5 )    ) {
                         //echo 'aaa'.$selected_cat;
                         $t_cat="";
                         
                         if (strlen($_SESSION['cs_reviews_show_cats'])>5 ){
                            $t_cat=trim(substr ( $_SESSION['cs_reviews_show_cats'],     strpos($_SESSION['cs_reviews_show_cats'],">") +1      ));
                         $title= ($t_cat);
                         }else{
                                 if (    isset($_GET['cs_mcat_name']) && (strlen($_GET['cs_mcat_name'])>5) ){
                                    $title = "Reviews: ".htmlspecialchars(($_GET['cs_mcat_name']));
                                }else{
                                    $title = "do_not_show_title";
                                    $title = "Product Reviews";
                                }
                         }
                         
                    }else{
                         $title = "Top Product Reviews";
                         //$title = "do_not_show_title";
                    }
        }
        
        
        $title=$banner_reviews.$title;
        
    }


   return cs_show_filter_contents($section, $product_list_criteria, $title,null,'show_title')
        .( ( 
            (($section === 'review-details') && (isset($_GET['cs_mcat']))
          ) 
          || ($section === 'review-single')
            ) ?'<br><br>'.
            cs_show_filter_contents('related_products',$_GET['cs_mcat'],'Related Products',null,'show_title') :'' 
        );
                
}


function cs_show_intro(){
    
    
    if( ($_SESSION['cs_home_banner'] == '1') ){
           $banner_home= "<div align='center' style='margin:0px; margin-top:3px; margin-bottom:30px;'><img src='https://cbproads.com/clickbankstorefront/v5/assets/images/slider2.png' class='img-responsive' ></div>";
    }    
    return  $banner_home.


    
        "<div style='padding-top:10px; margin-bottom:50px; border:0px solid red;'>".
        
                "<div style='text-align:center;'>".
                "<h2 id='cbpro_browse_title'>    Browse To Your Hearts<br>Content At Our Full Range Of Products</h2>".
             
               
                "</div>".
                "<p>Welcome to the world's largest online marketplace for digital information products. This is an excellent OneStop e-Storefront where you can download a great selection e-books and software on every subject.</p>".
                
                
                "<p>".
                "With over 10,000 info-products on ebooks, health, weight loss, fitness, diet supplements, business, home and garden, food and wine, parenting, internet, employment and jobs, education, student loans, self-help, home improvement, forex and marketing products to choose from, you are sure to find the information. </p>".
                
               // "<div style='text-align:center;'><h2>Clickbank&reg; is the world's largest source of Info-products</h2></div>".
                //"<p>Clickbank holds the record for most sales of over $3 billion. They partner with more than six million sellers. If buyers are not happy with any product, they offer a 60-day refund policy with no questions asked. Your satisfaction is their priority!  They were also rated A+ by the Better Business Bureau (BBB) as of January 2018. So, why are you waiting? You can browse the Clickbank online store today and enjoy all their great products. </p>".
        
        "</div>";
        
        


   
     
                        //$review_writeup.= 
                        "<div style='display:flex; justify-content: space-between;  margin-top:40px; margin-bottom:70px; '>".
                    	    
                    	    "<div style='display: flex;    width:30%; border-right:0px solid #dcdcdc;'>".
                        	
                        		"<img src='https://cbproads.com/clickbankstorefront/v5/assets/images/s1.jpg' alt=''>".
                        		
                        		"<h5 class='name'>IMMEDIATE ACCESS</h5>".
                        		"<span class='desc' style='font-size:0.8em; line-height:0.7em;'>Instantly download the products just after the payment.</span>".
                        	
                        	"</div>".
                        	
                        	
                        	"<div style='display: flex;   width:30%; border-right:0px solid #dcdcdc;'>".
                        	    
                        		"<img src='https://cbproads.com/clickbankstorefront/v5/assets/images/s2.jpg' alt=''>".
                        	
                        		"<h5 class='name'>60 DAY REFUND</h5>".
                        	
                        		"<span class='desc' style='font-size:0.8em; line-height:0.7em;'>Hassle free refunds in 60 day period. No questions asked!</span>".
                        		
                        	
                        	"</div>".
                        	
                        	
                        	
                        	
                        	"<div style='display: flex; width:30%;'>".
                        	  
                        		"<img src='https://cbproads.com/clickbankstorefront/v5/assets/images/s3.jpg' alt=''>".
                        
                        		"<h5 class='name'>SAFE SHOPPING</h5>".
                        		"<span class='desc' style='font-size:0.8em; line-height:0.7em;'>ClickBank is the payment processer between you and the product vendor.</span>".
                        		
                        	"</div>".
                        "</div>";    
     
}
/**
* Return BestSelling Products
* 
* @param array $attrs
* @return string
*/
function cs_show_bestselling($attrs = array())
{
   
    return cs_show_filter_contents('bestselling', '', 'Bestselling Products', $_SESSION['cs_bestselling_num'],  ( isset($attrs['show_title'])   ? $attrs['show_title'] :'')		);
}

/**
* Return Featured Products
* 
* @param array $attrs
* @return string
*/
function cs_show_featured($attrs = array())
{
    if ($_SESSION['cs_featured_ids'] == '') {
     //   return '';
    }
	
   
    return cs_show_filter_contents(
        'featured',
        trim($_SESSION['cs_featured_ids']),
        'Featured Products',
        $_SESSION['cs_featured_num'],
	   ( isset($attrs['show_title'])   ? $attrs['show_title'] :'')			);
}

/**
* Return Popular Products
* 
* @param array $attrs
* @return string
*/
function cs_show_popular($attrs = array())
{
   
     return cs_show_filter_contents('popular', '', 'Popular Products', $_SESSION['cs_popular_num'], ( isset($attrs['show_title'])   ? $attrs['show_title'] :'') 	);
}

function cs_show_supplement($attrs = array())
{
   
     return cs_show_filter_contents('supplement', '', 'Top Dietary Supplements', $_SESSION['cs_popular_num'], ( isset($attrs['show_title'])   ? $attrs['show_title'] :'') 	);
}

function cs_show_reviews($attrs = array())
{
   
     return cs_show_filter_contents('reviews', '', 'Best Product Reviews', $_SESSION['cs_items_per_page'], ( isset($attrs['show_title'])   ? $attrs['show_title'] :'')    	);
    //$product_list=cs_show('reviews','','','','','');
    //return $product_list['output'];
}





/**
* Return CSS style code for pagination buttons
* 
* @return string
*/
function cs_show_paging_css()
{
    wp_register_style('cs_paging', $_SESSION['cs_plugin_url'].'/paging.css');
    wp_enqueue_style('cs_paging');
}

/**
* Return HTML code for pagination buttons
* 
* @param string $section
* @param int $user_id
* @param string $criteria
* @param int $totalp
* @param int $items_per_page
* @param int $page
*/
function cs_show_paging($section, $user_id, $criteria, $totalp, $items_per_page, $mcat, $scat, $page = 1)
{
    if ($totalp <= $items_per_page) {
        $html = '&nbsp;';
    } else {
        $totalp = (int)ceil($totalp / $items_per_page);
        $pages_to_show = array();
        if ($totalp < 3) $loop_end = $totalp+1;
        else $loop_end = 4;
        for ($i = 1; $i < $loop_end; $i++) $pages_to_show[$i] = true;
        $loop_end = $totalp-3;
        if ($loop_end < 0) $loop_end = 0;
        for ($i = $totalp; $i > $loop_end; $i--) $pages_to_show[$i] = true;
        if ($page > 2 && $page < $totalp-1) {
            for ($i = $page-1; $i < $page+2; $i++) {
                $pages_to_show[$i] = true;
            }
        }
        ksort($pages_to_show);
        
        $cur_sortby = (isset($_SESSION['cs_sortby']) ? $_SESSION['cs_sortby'] : 'rank');
       // echo $section;
        $cur_view = (in_array($section, array('main_category', 'category', 'search','review-details'), true)
            ? $_SESSION['cs_switch_view']
            : $_SESSION['cs_view_other']);
        
        $html = '';
        $prev_i = 0;
        if(($page>1 )  ) { 
                $html .= "<span class=\"cs_page_button\" "; 
                        
                $html .= " onclick=\"cs_show_page('$section', '$user_id', '$criteria', $page-1, "
                     . "'$cur_sortby', '$cur_view', '$mcat', '$scat'); return false\">";
                $html .= "<a style='color: ".$_SESSION['cs_primary_color']."; text-decoration:none;' href=\"javascript:#\" >❮  </a>";
                 $html .= "</span>";
         }
         foreach (array_keys($pages_to_show) as $i) {
            if ($i - $prev_i > 1) $html .= "<span class=\"cs_page_button\"  style='border:0px solid ".$_SESSION['cs_primary_color'].";  border-left:0px;  ".
                                                "'>". 
                                            '...'.
                                            "</span>";
            
            
            if ($page == $i) {
                $html .= "<span class=\"cs_page_button_current\" style='background: ".$_SESSION['cs_primary_color']."; color:white; cursor: auto; '";
            }else{
                $html .= "<span class=\"cs_page_button\" ";
            }
            $html .= " onclick=\"cs_show_page('$section', '$user_id', '$criteria', $i, "
                . "'$cur_sortby', '$cur_view', '$mcat', '$scat'); return false\">";
            if ($page != $i) {
                $html .= "<a style='color: ".$_SESSION['cs_primary_color']."; text-decoration:none;' href=\"javascript:#\" >";
            }
            $html .= $i;
            if ($page != $i) $html .= "</a>";
            $html .= "</span>";
            
            $prev_i = $i;
        }
        
        if(($i>1 ) && ($page!=$i) ) { 
                $html .= "<span class=\"cs_page_button\"  ";
                        
                        
                $html .= " onclick=\"cs_show_page('$section', '$user_id', '$criteria', $page+1, "
                     . "'$cur_sortby', '$cur_view', '$mcat', '$scat'); return false\">";
                $html .= "<a style='color: ".$_SESSION['cs_primary_color']."; text-decoration:none;' href=\"javascript:#\" >  ❯</a>";
                 $html .= "</span>";
        }
         
    }
    
        if (strlen($html)>10 ) {
           //  return "<br />\n"
           // . "<br />\n"
            return "<div style=\"margin-bottom:15px; margin-top:15px; margin-right:15px; text-align: right\">$html</div>";
        }else{
            return '';
        }
    
    
   
}

function cs_popular_categories_shortcode($widget_yes_no){
    $pad_color=(strlen($_SESSION['cs_primary_color'])>2 ? $_SESSION['cs_primary_color']: '#808080');
    $tt= ($widget_yes_no!='widget_yes'?'<div style="margin-top:35px; ">'.cs_display_title("Popular Categories",$pad_color,"","show_title").'</div>':'');
    
    $tt.=           '<div class="cs_row_banners"  >'.
                        
                        '<div class="cs_row_banner_column_3">'.
                            '<a href="'.str_replace("?cs_category=","",cs_get_products_page('cs_category', '')).'?cs_keywords=fat+loss">'.
                            '<img src="https://cbproads.com/clickbankstorefront/v5/assets/images/WeightLoss.png" class="img-responsive"></a>'.
                        '</div>'.
                        
                        '<div class="cs_row_banner_column_3">'.
                            '<a href="'.str_replace("","",cs_get_products_page('cs_category', '')).'116&cs_temp_main_category=12">'.
                            '<img src="https://cbproads.com/clickbankstorefront/v5/assets/images/HomeImprovments.png" class="img-responsive"></a>'.
                        '</div>'.
                        
                        '<div class="cs_row_banner_column_3">'.
                            '<a href="'.str_replace("","",cs_get_products_page('cs_category', '')).'110&cs_temp_main_category=12">'.
                            '<img src="https://cbproads.com/clickbankstorefront/v5/assets/images/PetCare.jpg" class="img-responsive"></a>'.
                        '</div>'.

                  '</div>';
    return $tt;
}

function cs_show_related_categories($cat,$main_sub){
                
                $cs = "<div style='padding:10px; padding-top:20px; margin-left:5px; margin-right:5px; margin-top:50px; margin-bottom:50px; background:white; '><h3>RELATED CATEGORIES</h3>";
                   // $cs .= $main_sub;   
                $cs .=      "<div style='display:flex;justify-content: space-between; text-align:center; flex-wrap: wrap; border:0px solid red; '>";
                
                            if($main_sub==='sub'){
                                $url="https://cbproads.com/xmlfeed/wp/main/sub_categories.asp?cat_id=".$cat;
                            }else{
                                $url="https://cbproads.com/xmlfeed/wp/main/sub_categories.asp?main_cat_id=".$cat;
                            }
                            $url=$url."&".date('Y-m-d');
                            
                            $rss = fetch_feed($url);
                            if (is_wp_error($rss)) return $empty_answer;
                            
                            if (0 == $rss->get_item_quantity(400)) return $empty_answer;
                            $items = $rss->get_items(0, 400);
                            
                            foreach ($items as $item) {
                                $scat_name = $item->get_item_tags(SIMPLEPIE_NAMESPACE_RSS_20, "subhead_name");
                                $scat = cs_cdata($scat_name[0]['data']);
  
                                
                                $scat_cd = $item->get_item_tags(SIMPLEPIE_NAMESPACE_RSS_20, "subhead");
                                $scat_cd = cs_cdata($scat_cd[0]['data']);
                                
                                $thumbnail = $item->get_item_tags(SIMPLEPIE_NAMESPACE_RSS_20, "thumbnails");
                                $thumbs = cs_cdata($thumbnail [0]['data']);
                                 //$cs .=  $thumbs;
                                
                                //$cat_link = cs_get_products_page('cs_category', '') .$scat_cd."&cs_temp_main_category=".$_GET['cs_temp_main_category'];
                                
                                 if (isset($_GET['cs_main_category']) && strlen($_GET['cs_main_category'])>0) {
                                   $cat_link = cs_get_products_page('cs_category', '') .$scat_cd."&cs_temp_main_category=".$_GET['cs_main_category'];
                                }elseif (isset($_GET['cs_temp_main_category']) && strlen($_GET['cs_temp_main_category'])>0) {
                                   $cat_link = cs_get_products_page('cs_category', '') .$scat_cd."&cs_temp_main_category=".$_GET['cs_temp_main_category'];
                                }
                                                            
                                $thumb_img="https://cbproads.com/category_thumbnails/".$thumbs;
                                if ($scat_cd !=$cat){
                                        $cs .=          "<div class='cs_related_categories' style='position:relative;'><a style='text-decoration:none;font-size:0.92em;' href=\"$cat_link\">".
                                                            "<div style='position:relative; margin-top:7px;margin-bottom:7px; '><img src='$thumb_img'></a>".
                                                            "<div  id='cs_show_related_cat_div' style='lefts:10%; rights:10%; background:#fff; border-radius:1px; max-width:200px; font-size:12px; width:100%; text-align:center; padding:3px; position:absolute; bottom:18px;'>$scat</div></div>".
                                                        "</div>";
                                }
                            }    
                $cs .=      "</div>";
                    
                $cs .= "</div>";
    return $cs;
}

function cs_show_cb_banner_ads($orientation,$no_of_columns,$cs_ad_size=null,$cs_show_footer=null,$cs_show_http_ads=null,$cs_strech_ads=null,$cs_ad_align=null ){
     
	 if ($no_of_columns==2) {echo "Not supported any mor two colums"; return;}

    $url="https://cbproads.com/xmlfeed/wp/main/ads/cb_ads.asp?size=".(strlen($cs_ad_size)>3? $cs_ad_size."_as":"")."&show_http=".($cs_show_http_ads==true ? "yes" :"no")."&".
                                                                    ($no_of_columns==1?'columns=1':'columns=2')."&".($orientation==='vertical'?'vertical=yes&':'')."id=".$_SESSION['cs_user_id'];
	
	
   	if (isset($_GET['cs_category']) && strlen($_GET['cs_category'])>0) {
        $url=$url."&sccat=".$_GET['cs_category']."&mcat=".$_GET['cs_temp_main_category'];
		
    }elseif (isset($_GET['cs_main_category']) && strlen($_GET['cs_main_category'])>0) {
        $url=$url."&mcat=".$_GET['cs_main_category'];
        
    }elseif (isset($_GET['cs_temp_main_category']) && strlen($_GET['cs_temp_main_category'])>0) {
        $url=$url."&mcat=".$_GET['cs_temp_main_category'];
        
    }elseif (isset($_GET['cs_keywords']) && strlen($_GET['cs_keywords'])>0) {
        
        if (    ($_GET['cs_keywords']==="keto") || ($_GET['cs_keywords']==="paleo")  || ($_GET['cs_keywords']==="vegan") ){
            $url=$url."&mcat10";
        }
        
    }elseif (isset($_GET['cs_mcat']) && strlen($_GET['cs_mcat'])>0) {
        $url=$url."&mcat=".$_GET['cs_mcat'];
    }
    
    
    //echo $url.$cs_ad_size;

    $url=$url."&as=".date('Y-m-d')."&url=".rawurlencode(home_url());
    if ($_GET['cs_show_url']=='yes'){
        echo $url;
    }
    $rand_num="";
    $rand_num_2="";
    $rand_ok="";
    
                             $rss = fetch_feed($url);
                            if (is_wp_error($rss)) return $empty_answer;
                            
                            if (0 == $rss->get_item_quantity(1)) return $empty_answer;
                            $items = $rss->get_items(0, 1);
                            
                            foreach ($items as $item) {
                                    $ide = $item->get_item_tags(SIMPLEPIE_NAMESPACE_RSS_20, "cnt");
                                    $cnts = intval(cs_cdata($ide[0]['data']));
                            }
							 if ($_GET['cs_show_count']=='yes'){
                                 echo "<br>banner_count:".$cnts."<br>";
                             }
                            
    $rand_num=rand(1,$cnts);
    
   if (($orientation==="verticalsssss") || ($no_of_columns==2) ){ 
	                                /*	do{
                                           $t_rand=rand(1,5);
                                            if ($rand_num!=$t_rand){  $rand_num_2=$t_rand;  $rand_ok="ok";  }
                                       }while ($rand_ok!="ok");*/
                                        $rand_num_2=rand(1,$cnts);
    }
                       
                            $cnt_num=0;
                            $ret_htm='';
                           // echo $url;
                            
                            
                             
                             
                             
                                
            //echo ($rand_num).'-'.$rand_num_2.' count:'.$cnts.'  BEFOE <br>';   
              /*
                                if (($no_of_columns==1) && ($cnts==1)  ) {$rand_num=1;  }
                                if (($no_of_columns==1) && ($cnts==2)  ) {$rand_num=1;  }
                                if (($no_of_columns==1) && ($cnts==3)  ) {$rand_num=2;  }
                                if (($no_of_columns==1) && ($cnts==4)  ) {$rand_num=4;  }
                                if (($no_of_columns==1) && ($cnts==5)  ) {$rand_num=3;  }    
                                if (($no_of_columns==1) && ($cnts==6)  ) {$rand_num=6;  }
                                if (($no_of_columns==1) && ($cnts==7)  ) {$rand_num=7;  }
                              
            
              echo ($rand_num).'-'.$rand_num_2.'- counted:'.$cnts.'AFTER <br>';   
               */ 
               
                             $rss = fetch_feed($url);
                            if (is_wp_error($rss)) return $empty_answer;
                            
                            if (0 == $rss->get_item_quantity(400)) return $empty_answer;
                            $items = $rss->get_items(0, 400);
                            
                            
                             if ($no_of_columns==2){
                                  $ret_htm="<div class='cs_row_banners' style='border-radius:0px; padding-top:10x; padding-bottom:24px; border:0px dashed ".$_SESSION['cs_primary_color'].";'>";
                             }
                            if ($cs_show_footer==true){
                                $footerurl="https://cbproads.com/?id=".$_SESSION['cs_user_id'];
                                $cs_show_footer_text="<span style='margin-top:0px; padding-top:0px;display:block';><a href='$footerurl' target='_blank' style='font-size:0.75em; color:#808080; text-decoration:none; '>Ads By CBProAds</a></span>";
                            }
                            
                          //  if ($no_of_columns==1) { $rand_num=1; }
                           
                            
                            foreach ($items as $item) {
                                $cnt_num=$cnt_num+1;
                                
                                
                               
                  
              
                               if(($cnt_num==$rand_num)  ||($cnt_num==$rand_num_2)) {
                                //if(($cnt_num==1)  ||($cnt_num==2)) {
                                    
                                    $ide = $item->get_item_tags(SIMPLEPIE_NAMESPACE_RSS_20, "ide");
                                    $id = cs_cdata($ide[0]['data']);
                                    
                                    
                                    
                                    
                                    $mccodes = $item->get_item_tags(SIMPLEPIE_NAMESPACE_RSS_20, "mccode");
                                    $mccode = cs_cdata($mccodes[0]['data']);
                                    
                                    $images = $item->get_item_tags(SIMPLEPIE_NAMESPACE_RSS_20, "images");
                                    $image_url = cs_cdata($images[0]['data']);
                                    //echo $image_url;
                                    $linkurl="https://cbproads.com/track.asp?channel=cbpro_wp_plugin&vid=".$_SESSION['cs_user_id']."&id=".$id."&member=".$_SESSION['cs_user_id']."&mccode=".$mccode;
                                    
                                    
                                    if ($no_of_columns==2){
                                        $ret_htm.= "<div class='cs_row_banner_column_2' style='width:50%; padding-right:0px;' >".
                                                    "<a href='$linkurl' target='_blank'><img src='".$image_url."' class='img-responsive' style='border:1px solid silver; padding:0px; max-width:100%; border-radius:3px; margin-bottom:0px; '></a>"."</div>";
                                                    
                                        
                                    }else{
										$cs_strech_ads=filter_var($cs_strech_ads, FILTER_VALIDATE_BOOLEAN); 
										
										if ($cs_strech_ads==true)  
											$width_img="width:100%; height:auto;";
										if ($cs_ad_align=="L") $cs_ad_align="left";
										if ($cs_ad_align=="R") $cs_ad_align="right";
										if ($cs_ad_align=="M") $cs_ad_align="center";
										
										$ret_htm.="<div align='".$cs_ad_align."' >".
												"<a href='$linkurl' target='_blank'><img src='".$image_url."' class='img-responsive' style='".$width_img."'></a></div>";
                                               $cs_show_footer_text;
												
                                    }        
                                    
                                    
                                }
                                
                            }
                            if ($no_of_columns==2){
                                  $ret_htm.="</div><!--<div align='right'><a href='$footerurl' target='_blank' style='font-size:0.75em; color:#808080; text-decoration:none; '>Ads by CBProAds</a></div>--><br>";
                             }
                            return $ret_htm;
                           
                            
    
}

function cs_xss_clean($data)
{
// Fix &entity\n;
$data = str_replace(array('&amp;','&lt;','&gt;'), array('&amp;amp;','&amp;lt;','&amp;gt;'), $data);
$data = preg_replace('/(&#*\w+)[\x00-\x20]+;/u', '$1;', $data);
$data = preg_replace('/(&#x*[0-9A-F]+);*/iu', '$1;', $data);
$data = html_entity_decode($data, ENT_COMPAT, 'UTF-8');

// Remove any attribute starting with "on" or xmlns
$data = preg_replace('#(<[^>]+?[\x00-\x20"\'])(?:on|xmlns)[^>]*+>#iu', '$1>', $data);

// Remove javascript: and vbscript: protocols
$data = preg_replace('#([a-z]*)[\x00-\x20]*=[\x00-\x20]*([`\'"]*)[\x00-\x20]*j[\x00-\x20]*a[\x00-\x20]*v[\x00-\x20]*a[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2nojavascript...', $data);
$data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*v[\x00-\x20]*b[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2novbscript...', $data);
$data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*-moz-binding[\x00-\x20]*:#u', '$1=$2nomozbinding...', $data);

// Only works in IE: <span style="width: expression(alert('Ping!'));"></span>
$data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?expression[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
$data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?behaviour[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
$data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:*[^>]*+>#iu', '$1>', $data);

// Remove namespaced elements (we do not need them)
$data = preg_replace('#</*\w+:\w[^>]*+>#i', '', $data);

do
{
    // Remove really unwanted tags
    $old_data = $data;
    $data = preg_replace('#</*(?:applet|b(?:ase|gsound|link)|embed|frame(?:set)?|i(?:frame|layer)|l(?:ayer|ink)|meta|object|s(?:cript|tyle)|title|xml)[^>]*+>#i', '', $data);
}
while ($old_data !== $data);

// we are done...
return $data;
}


function cs_sql_inject_check()
{
   //$cs_error_info = cs_sql_inject_check_detail($_GET['page'],"int",3,'page');
   $cs_error_info = cs_sql_inject_check_detail($_GET['user_id'],"int",10,'user_id');
   $cs_error_info = cs_sql_inject_check_detail($_GET['cs_mcat'],"int",5,'cs_mcat');
   $cs_error_info = cs_sql_inject_check_detail($_GET['cs_scat'],"int",5,'cs_scat');
   $cs_error_info = cs_sql_inject_check_detail($_GET['cs_category'],"int",3,'cs_category');
   $cs_error_info = cs_sql_inject_check_detail($_GET['cs_temp_main_category'],"int",3,'cs_temp_main_category');
   $cs_error_info = cs_sql_inject_check_detail($_GET['cs_main_category'],"int",3,'cs_main_category');
   $cs_error_info = cs_sql_inject_check_detail($_GET['memnumber'],"int",10,'memnumber');
   
   $cs_error_info = cs_sql_inject_check_detail($_GET['switch_view'],"text",4,'switch_view');
   $cs_error_info = cs_sql_inject_check_detail($_GET['sortby'],"text",30,'sortby');
   
   //$cs_error_info = cs_sql_inject_check_detail($_GET['niche'],"text",1,'niche');
   
   $cs_error_info = cs_sql_inject_check_detail($_GET['tar'],"text",100,'tar');
   //$cs_error_info = cs_sql_inject_check_detail($_GET['section'],"text",15,'section');
   
   $cs_error_info = cs_sql_inject_check_detail($_GET['cs_main_category_name'],"text",100    ,'cs_main_category_name');
   $cs_error_info = cs_sql_inject_check_detail($_GET['cs_mcat_name'],"text",100,'cs_mcat_name');
   $cs_error_info = cs_sql_inject_check_detail($_GET['mem'],"text",150,'mem');
   $cs_error_info = cs_sql_inject_check_detail($_GET['cs_review_id'],"text",100,'cs_review_id');
   $cs_error_info = cs_sql_inject_check_detail($_GET['criteria'],"text",30,'criteria');
   $cs_error_info = cs_sql_inject_check_detail($_GET['cs_keywords'],"text",30,'cs_keywords');
   
   
   
   

}

function cs_sql_inject_check_detail($cs_input,$cs_input_type,$cs_max_length,$cs_query_string)
{
     if (   ($cs_input_type==="int")  && (strlen($cs_input)>0)  )  {
        
        if (    (is_numeric($cs_input)) && ( strlen($cs_input) <= $cs_max_length )     ){}
        else { echo 'Error_code: ['.$cs_query_string.']['.$cs_input."][numeric_mx$cs_max_length]<br \>\n";                      wp_die();
                                    
             }
     }
     
     if (   ($cs_input_type==="text") && (strlen($cs_input)>0)  ){
        
        if (    ( strlen($cs_input) <= $cs_max_length )        ){}
        else { echo 'Error_code: ['.$cs_query_string.']['.$cs_input."][text_mx$cs_max_length] <br \>\n";                      wp_die();
        
            }
     }
}


//shortcode for  3 popular diet
function cs_diet_3_columns($cs_bg_color){
	
		if ($_SESSION['cs_theme_chosen']==="corporacy"){
			
			$cs_Code	='<div class="section-heading-wrapper">'.
						'<!-- <div class="section-tagline">Diets that Helps To Lose Weight</div><!-- .section-description-wrapper -->'.
						'<div class="section-title-wrapper"><h2 class="section-title">Popular Diet Plans</h2></div>'.
					 '</div><!-- .section-heading-wrapper -->';
		}else{
			$cs_Code	= '<div class="section-heading-wrapper"><h2>Please make your heading specific to your theme incs_diet_3_coulmns function</h2></div>';
		}
	
		//$cs_Code='<h4 style="margin-bottom:20px; text-align:center;">Popular Diet Plans</h4>'.
	    $cs_Code=''.			
					'<div class="cs_service_wrapper'.$cs_bg_color[0].'">'.
					
					//$cs_Code.
					'<div class="cs_service_row">'.
						'<div class="cs_service_col">'.
							'<div><a href="'.cs_get_products_page('cs_keywords', 'paleo').'">'.
								'<img src="https://cbproads.com/xmlfeed/WP/main/fetch_images_for_themes.asp?niche=paleo&theme='.$_SESSION['cs_theme_chosen'].'"></a></div>'.
							'<div><h6>Paleo</h6></div>'.
							//'<div><p>A paleo diet typically includes lean meats, fish, fruits, vegetables, nuts and seeds — foods that in the past …</p></div>'.
							//'<button class="cs-btn"><a href="'.cs_get_products_page('cs_keywords', 'paleo').'" class="more-link">Browse Products<span class="screen-reader-text">Paleo</span></a></button>'.
						 '</div>'.

						'<div class="cs_service_col">'.
							'<div><a href="'.cs_get_products_page('cs_keywords', 'keto').'">'.
								'<img src="https://cbproads.com/xmlfeed/WP/main/fetch_images_for_themes.asp?niche=keto&theme='.$_SESSION['cs_theme_chosen'].'"></a></div>'.
							'<div><h6>Keto</h6></div>'.
							//'<div><p>A paleo diet typically includes lean meats, fish, fruits, vegetables, nuts and seeds — foods that in the past …</p></div>'.
							//'<button class="cs-btn"><a href="'.cs_get_products_page('cs_keywords', 'keto').'" class="more-link">Browse Products<span class="screen-reader-text"></span></a></button>'.
						 '</div>'.
			
					'</div>'.
					'<div class="cs_service_row">'.
						'<div class="cs_service_col">'.
							'<div><a href="'.cs_get_products_page('cs_keywords', 'vegan').'">'.
								'<img src="https://cbproads.com/xmlfeed/WP/main/fetch_images_for_themes.asp?niche=vegan&theme='.$_SESSION['cs_theme_chosen'].'"></a></div>'.
							'<div><h6>Vegan</h6></div>'.
							//'<div><p>A paleo diet typically includes lean meats, fish, fruits, vegetables, nuts and seeds — foods that in the past …</p></div>'.
							//'<button class="cs-btn"><a href="'.cs_get_products_page('cs_keywords', 'vegan').'" class="more-link">Browse Products<span class="screen-reader-text"></span></a></button>'.
						 '</div>'.

					'<div class="cs_service_col">'.
							'<div><a href="'.cs_get_products_page('cs_keywords', 'diabetic').'">'.
								'<img src="https://cbproads.com/xmlfeed/WP/main/fetch_images_for_themes.asp?niche=diabetic&theme='.$_SESSION['cs_theme_chosen'].'"></a></div>'.
							'<div><h6>Diabetic</h6></div>'.
							//'<div><p>A paleo diet typically includes lean meats, fish, fruits, vegetables, nuts and seeds — foods that in the past …</p></div>'.
							//'<button class="cs-btn"><a href="'.cs_get_products_page('cs_keywords', 'vegan').'" class="more-link">Browse Products<span class="screen-reader-text"></span></a></button>'.
						 '</div>'.
			
					'</div><!--row-->'.
				'</div> <!--wrapper-->';
							  
		return $cs_Code;
}

?>