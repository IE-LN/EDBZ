<?php
// display post page title
function cs_post_page_title(){
	if ( is_author() ) {
		global $author;
		$userdata = get_userdata($author);
		echo __('Author', 'Soundblast') . " " . __('Archives', 'Soundblast') . ": ".$userdata->display_name;
	}elseif ( is_tag() || is_tax('event-tag') ) {
		echo __('Tags', 'Soundblast') . " " . __('Archives', 'Soundblast') . ": " . single_cat_title( '', false );
	}elseif ( is_category() || is_tax('event-category') ) {
		echo __('Categories', 'Soundblast') . " " . __('Archives', 'Soundblast') . ": " . single_cat_title( '', false );
	}elseif( is_search()){
		printf( __( 'Search Results %1$s %2$s', 'Soundblast' ), ': ','<span>' . get_search_query() . '</span>' ); 
	}elseif ( is_day() ) {
		printf( __( 'Daily Archives: %s', 'Soundblast' ), '<span>' . get_the_date() . '</span>' );
	}elseif ( is_month() ) {
		printf( __( 'Monthly Archives: %s', 'Soundblast' ), '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', 'Soundblast' ) ) . '</span>' );
	}elseif ( is_year() ) {
		printf( __( 'Yearly Archives: %s', 'Soundblast' ), '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', 'Soundblast' ) ) . '</span>' );
	}elseif ( is_404()){
		_e( 'Error 404', 'Soundblast' );
	}elseif(!is_page()){
		_e( 'Archives', 'Soundblast' );
	}
}
// page elemect for pirce table
if ( ! function_exists( 'cs_pricetable_page' ) ) {
	function cs_pricetable_page(){
		global $cs_node;
		if(empty($cs_node->pricetable_featured)) $cs_node->pricetable_featured ='';
		$pricetable_featured ='';
		$price_color = '';
		if($cs_node->pricetable_style == ''){
			$cs_node->pricetable_style = 'style1';
		}
		if($cs_node->pricetable_featured == "Yes") $pricetable_featured = " price_featured";
		$html = '<div class="price-table price-'.$cs_node->pricetable_style.'"><div class="element_size_'.$cs_node->pricetable_element_size.'">';
		
		$html .= '<div class="pricing-box '.$pricetable_featured.'">';
		$html .= '<div class="plan-header">';
		if($cs_node->pricetable_style <> '' && $cs_node->pricetable_style <> 'style2') {
			$price_color = 'style="background:'.$cs_node->pricetable_bgcolor.'"';
		}
		$html .= '<div class="pricing-box">';
		if($cs_node->pricetable_style <> '' && $cs_node->pricetable_style == 'style2') {
			$html .= '<h6 class="heading-color"  style="background:'.$cs_node->pricetable_bgcolor.'">'.$cs_node->pricetable_title.'</h6>';
		} else {
			$html .= '<h6 class="heading-color" >'.$cs_node->pricetable_title.'</h6>';
		}
		$html .= '</div>';
		$html .= '<div class="price" '.$price_color.'><h1 class="webkit heading-color">'.$cs_node ->pricetable_price.' <span>'.$cs_node->pricetable_for_time.'</span></h1></div>';
		
		$html .= '</div>';
		$html .= '<div class="plan-inside">'.$cs_node ->pricetable_content.'</div>';
		if($cs_node->pricetable_style <> '' && $cs_node->pricetable_style == 'style1') {
			$html .= '<div class="period"><center><a href="'.$cs_node->pricetable_linkurl.'" class="button_large" style="background:'.$cs_node->pricetable_bgcolor.'">'.$cs_node->pricetable_linktitle.'</a></center></div>';
		}
		else if($cs_node->pricetable_style <> '' && $cs_node->pricetable_style == 'style2') {
		$html .= '<div class="period"><center><a href="'.$cs_node->pricetable_linkurl.'" class="button_large">'.$cs_node->pricetable_linktitle.'</a></center></div>';
		}
		$html .= '</div>';
		$html .= '</div></div>';
		echo $html;
	}
}

function cs_mailchimp_list($apikey){
	global $cs_theme_option;
	$MailChimp = new MailChimp($apikey);
	$mailchimp_list = $MailChimp->call('lists/list');
	return $mailchimp_list;
}
function cs_custom_mailchimp(){
	global $cs_theme_option;
	$counter = 1;
	if(isset($cs_theme_option['footer_newsletter']) and $cs_theme_option['footer_newsletter']=="on"){
 	?>
	<div class="widget widget_newsletter">
        <div class="container">
            <h4 class="cs-section-title"><?php if($cs_theme_option['trans_switcher'] == "on"){ _e('Weekly Newsletter','Atom Band');}else{ echo $cs_theme_option['trans_other_weekly_newsletter']; } ?></h4>
          
            <form action="javascript:cs_mailchimp_submit('<?php echo get_template_directory_uri()?>','<?php echo $counter; ?>')" id="mcform_<?php echo $counter;?>" method="post">
                    <div id="newsletter_mess_<?php echo $counter;?>" style="display:none"></div>
                <label>
                    <input id="cs_list_id" type="hidden" name="cs_list_id" value="<?php if(isset($cs_theme_option['cs-mc-list'])){ echo $cs_theme_option['cs-mc-list']; }?>" />
                    <input id="mc_email" type="text" name="mc_email" value="" placeholder="Enter your valid email address" />
                    <em class="fa fa-envelope-o"></em>
                    Keep up with Latest news. Read our latest newsletter
                </label>
                <input type="submit" id="btn_newsletter_<?php echo $counter;?>" name="submit" class="bgcolr cs-submit" value="submit"  />
                <div id="process_newsletter_<?php echo $counter;?>"></div>
            </form>
         </div>
     </div>
    <?php
	}
	$counter++;
}

// Dropcap shortchode with first letter in caps
if ( ! function_exists( 'cs_dropcap_page' ) ) {
	function cs_dropcap_page(){
		global $cs_node;
		$html = '<div class="element_size_'.$cs_node->dropcap_element_size.'">';
			if($cs_node->dropcap_style == "2"){
			$html .= '<div class="dropcaptwo">';
			}else{
			$html .= '<div class="dropcap">';
			}
				$html .= $cs_node->dropcap_content;
			$html .= '</div>';
		$html .= '</div>';
		return $html;
	}
}

// block quote short code
if ( ! function_exists( 'cs_quote_page' ) ) {
	function cs_quote_page(){
		global $cs_node;
		$html = '<div class="element_size_'.$cs_node->quote_element_size.'">';
			$html .= '<div class="blockquote styleicon">';
			$html .= '<blockquote style=" text-align:' .$cs_node->quote_align. '; color:' . $cs_node->quote_text_color . '">' . $cs_node->quote_content . '</blockquote>';
		$html .= '</div></div>';
		return $html . '<div class="clear"></div>';
	}
}

// video short code
if ( ! function_exists( 'cs_video_page' ) ) {
	function cs_video_page(){
		global $cs_node;
		$html = '<div class="element_size_'.$cs_node->video_element_size.'">';
			$html .= wp_oembed_get( $cs_node->video_url, array('width'=>$cs_node->video_width, 'height'=>$cs_node->video_height) );
		$html .= '</div>';
		return $html;
	}
}
// map shortcode with various options
if ( ! function_exists( 'cs_map_page' ) ) {
	function cs_map_page(){
		global $cs_node, $counter_node;
		if ( !isset($cs_node->map_lat) or $cs_node->map_lat == "" ) { $cs_node->map_lat = 0; }
		if ( !isset($cs_node->map_lon) or $cs_node->map_lon == "" ) { $cs_node->map_lon = 0; }
		if ( !isset($cs_node->map_zoom) or $cs_node->map_zoom == "" ) { $cs_node->map_zoom = 11; }
		if ( !isset($cs_node->map_info_width) or $cs_node->map_info_width == "" ) { $cs_node->map_info_width = 200; }
		if ( !isset($cs_node->map_info_height) or $cs_node->map_info_height == "" ) { $cs_node->map_info_height = 100; }
		if ( !isset($cs_node->map_show_marker) or $cs_node->map_show_marker == "" ) { $cs_node->map_show_marker = 'true'; }
		if ( !isset($cs_node->map_controls) or $cs_node->map_controls == "" ) { $cs_node->map_controls = 'false'; }
		if ( !isset($cs_node->map_scrollwheel) or $cs_node->map_scrollwheel == "" ) { $cs_node->map_scrollwheel = 'true'; }
		if ( !isset($cs_node->map_draggable) or $cs_node->map_draggable == "" )  { $cs_node->map_draggable = 'true'; }
		if ( !isset($cs_node->map_type) or $cs_node->map_type == "" ) { $cs_node->map_type = 'ROADMAP'; }
		if ( !isset($cs_node->map_info)) { $cs_node->map_info = ''; }
		if( !isset($cs_node->map_marker_icon)){ $cs_node->map_marker_icon = ''; }
		if( !isset($cs_node->map_title)){ $cs_node->map_title ='';}
		if( !isset($cs_node->map_element_size) or $cs_node->map_element_size == ""){ $cs_node->map_element_size ='default';}
		if( !isset($cs_node->map_height)){ $cs_node->map_height ='180';}
	 
		$map_show_marker = '';
		if ( $cs_node->map_show_marker == "true" ) { 
			$map_show_marker = " var marker = new google.maps.Marker({
						position: myLatlng,
						map: map,
						title: '',
						icon: '".$cs_node->map_marker_icon."',
						shadow:''
					});
			";
		}
	
		//wp_enqueue_script('googleapis', 'https://maps.googleapis.com/maps/api/js?sensor=true', '', '', true);
		$html = '<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=true"></script>';
		$html .= '<div class="element_size_'.$cs_node->map_element_size.' cs-map">';
			if($cs_node->map_title <> ''){$html .= '<h2 class="cs-heading-color section-title">'.$cs_node->map_title.'</h2>'; }
			$html .= '<div class="mapcode iframe mapsection gmapwrapp" id="map_canvas'.$counter_node.'" style="height:'.$cs_node->map_height.'px;"> </div>';
		$html .= '</div>';
		//mapTypeId: google.maps.MapTypeId.".$cs_node->map_type." ,
		$html .= "<script type='text/javascript'>
					function initialize() {
						var styles = [
							{
							  stylers: [
								{ hue: '#000000' },
								{ saturation: -100 }
							  ]
							},{
							  featureType: 'road',
							  elementType: 'geometry',
							  stylers: [
								{ lightness: -40 },
								{ visibility: 'simplified' }
							  ]
							},{
							  featureType: 'road',
							  elementType: 'labels',
							  stylers: [
								{ visibility: 'on' }
							  ]
							}
						  ];
		var styledMap = new google.maps.StyledMapType(styles,
		{name: 'Styled Map'});
						var myLatlng = new google.maps.LatLng(".$cs_node->map_lat.", ".$cs_node->map_lon.");
						var mapOptions = {
							zoom: ".$cs_node->map_zoom.",
							panControl: false,
							scrollwheel: ".$cs_node->map_scrollwheel.",
							draggable: ".$cs_node->map_draggable.",
							center: myLatlng,
							disableDefaultUI: true,
							disableDefaultUI: ".$cs_node->map_controls.",
							mapTypeControlOptions: {
							  mapTypeIds: [google.maps.MapTypeId.ROADMAP.".$cs_node->map_type.", 'map_style']
							}
						}
						var map = new google.maps.Map(document.getElementById('map_canvas".$counter_node."'), mapOptions);
						map.mapTypes.set('map_style', styledMap);
						map.setMapTypeId('map_style');
						var infowindow = new google.maps.InfoWindow({
							content: '".$cs_node->map_info."',
							maxWidth: ".$cs_node->map_info_width.",
							maxHeight:".$cs_node->map_info_height.",
						});
						".$map_show_marker."
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
				</script>";
		return $html;
	}
}
// Message Box with various options and multiple styles
if ( ! function_exists( 'cs_message_box_page' ) ) {
	function cs_message_box_page(){
		global $cs_node;
		$html = '<div class="element_size_'.$cs_node->mb_element_size.'">';
		$html .= '<div class="messagebox alert alert-info" style="background:'.$cs_node->mb_bg_color.'">
				<button data-dismiss="alert" class="close" type="button">&#88;</button>';
		$html .= '<h4>'.$cs_node->mb_title.'</h4>';
		$html .= $cs_node->mb_content;
		$html .= '</div>';
		$html .= '</div>';
		echo $html;
	}
}
// Divider shortcode use for sepratiion of page elements
if ( ! function_exists( 'cs_divider_page' ) ) { 
	function cs_divider_page(){
		global $cs_node;
		wp_enqueue_script('scrolltopcontrol_js', get_template_directory_uri() . '/scripts/frontend/scrolltopcontrol.js', '', '', true);
		$html = '<div class="devider element_size_'.$cs_node->divider_element_size.'>">';
		$html .= '<div style="margin-top:'.$cs_node->divider_mrg_top.'px;margin-bottom:'.$cs_node->divider_mrg_bottom.'px; " class="' . $cs_node->divider_style . '">';
		if(isset($cs_node->divider_backtotop) && strtolower($cs_node->divider_backtotop)=='yes'){
			$html .= '<a href="#" class="gotop" id="back-top">'.__('Top','Soundblast').'</a>';
		}
		$html .= '</div>';
		$html .= '</div>';
		return $html . '<div class="clear"></div>';
	}
}
// Services shortcode with multiple layout
if ( ! function_exists( 'cs_services_page' ) ) {
	function cs_services_page() {
    	global $cs_node, $post, $element_size_class, $cs_theme_option;
    	?>
        <div class="element_size_<?php echo $cs_node->services_element_size; ?>">
            <!-- Prayer Submit Start -->
            <div class="our_services fullwidth">
                <?php
                foreach ($cs_node->service as $service_info) {
					if ( $service_info->service_style == "service1" ) $service_style = "service-v1";
					elseif ( $service_info->service_style == "service2" ) $service_style = "service-v2";
					elseif ( $service_info->service_style == "service3" ) $service_style = "service-v3";
					elseif ( $service_info->service_style == "service4" ) $service_style = "service-v4";
					?>
					
					<article class="<?php echo $service_style?> viewme">
					<?php
					if ( $service_info->service_style == "service2" ){
                    ?>
					<figure class="viewme">
				   		<?php if ($service_info->service_icon <> '') { ?>
						<span class="icon-stack">
						 <span class="colrhover" onclick="<?php echo $service_info->service_url; ?>"><em class="fa fa-circle fa-stack-base"></em> <em class="fa <?php echo $service_info->service_icon; ?> fa-light"></em></span>
						</span>      
					    <?php } ?>
					</figure>
					<div class="text">
						<header class="heading">
							<h2 class="post-title">
								<a class="colrhover" href="<?php echo $service_info->service_url; ?>"><?php echo $service_info->service_title; ?></a>
							</h2>
						</header>
						<p>
							<?php echo do_shortcode($service_info->service_text); ?>
						</p>
					</div>
                    
					<?php
					}else if($service_info->service_style == "service3"){
					?>
						<?php if ($service_info->service_icon <> '') { ?>
						<figure class="viewme">
							<em class="fa <?php echo $service_info->service_icon; ?>"></em>
						</figure>
						<?php } ?>
						<div class="text">
							<header class="heading">
								<h2 class="post-title">
									<a class="colrhover" href="<?php echo $service_info->service_url; ?>"><?php echo $service_info->service_title; ?></a>
								</h2>
							</header>
							<p>
								<?php echo do_shortcode($service_info->service_text); ?>
							</p>
						</div>
					
				<?php
					}else if($service_info->service_style == "service4"){
					?>
					
						<figure class="viewme">
							<?php if ($service_info->service_icon <> '') { ?>
							<span class="icon-stack">
							 <em class="fa fa-sign-blank fa-stack-base"></em> <em class="fa <?php echo $service_info->service_icon; ?> fa-light"></em>
							</span>
							<?php } ?>
							<header class="heading">
								<h2 class="post-title">
									<a class="colrhover" href="<?php echo $service_info->service_url; ?>"><?php echo $service_info->service_title; ?></a>
								</h2>
							</header>
						</figure>
						<div class="text">
							<p>
								<?php echo do_shortcode($service_info->service_text); ?>
							</p>
						</div>
				<?php
					}else{
					?>	
						<?php if ($service_info->service_icon <> '') { ?>
						<figure class="viewme">
							<a class="bgcolrhover" href="<?php echo $service_info->service_url; ?>">
								<em class="fa fa-light <?php echo $service_info->service_icon; ?>"></em>
							</a>
						</figure>
						<?php } ?>
						<div class="text">
							<header class="heading">
								<h2 class="post-title">
									<a class="colrhover" href="<?php echo $service_info->service_url; ?>"><?php echo $service_info->service_title; ?></a>
								</h2>
							</header>
							<p>
								<?php echo do_shortcode($service_info->service_text); ?>
							</p>
						</div>
				<?php
					}
				?>
				</article>
				
				<?php
				}
				?>
                </div>
                <!-- Prayer Submit End -->
              <div class="clearfix"></div> 
            </div>
			
			
			
        <?php
    }
}	

function cs_next_prev_custom_links($post_type = ''){
	global $post;
	$previd = $nextid = '';
	$count_posts = wp_count_posts( "$post_type" )->publish;
	$cs_postlist_args = array(
	   'posts_per_page'  => -1,
	   'order'           => 'ASC',
	   'post_type'       => "$post_type",
	); 
	$cs_postlist = get_posts( $cs_postlist_args );

	$ids = array();
	foreach ($cs_postlist as $cs_thepost) {
	   $ids[] = $cs_thepost->ID;
	}
	$thisindex = array_search($post->ID, $ids);
	if(isset($ids[$thisindex-1])){
		$previd = $ids[$thisindex-1];
	} 
	if(isset($ids[$thisindex+1])){
		$nextid = $ids[$thisindex+1];
	} 
	if (isset($previd) &&  !empty($previd) && $previd >=0 ) {
	   ?>
        <a class="btncontrole" href="<?php echo get_permalink($previd); ?>"><i class="fa fa-caret-left"></i><?php _e('Prevoius Post','Atom Band'); ?></a>
		<?php
	}
	
	if (isset($nextid) &&   !empty($nextid) ) {
		?>
        <a class="btncontrole" href="<?php echo get_permalink($nextid); ?>"><?php _e('Next Post','Atom Band'); ?><i class="fa fa-caret-right"></i></a>
		<?php	
	}
 
}


// Column shortcode with 2/3/4 column option even you can use shortcode in column shortcode
if ( ! function_exists( 'cs_column_page' ) ) {
	function cs_column_page(){
		global $cs_node;
		$html = '<div class="element_size_'.$cs_node->column_element_size.' column">';
			$html .= do_shortcode($cs_node->column_text);
		$html .= '</div>';
		echo $html;
 	}
}

// tabs shortcode
if ( ! function_exists( 'cs_tabs_page' ) ) {
	function cs_tabs_page(){
		global $cs_node, $tab_counter;
		$html = "";
		if ( $cs_node->tabs_element_size == "" ) {
			$html .= '<ul class="nav nav-tabs" id="myTab">';
			$cs_xmlObject = simplexml_load_string($cs_node->tabs_content);
			$tabs_count = 0;
			if($cs_node->sytle == 'vertical'){
				$cs_node->sytle = 'vertical';
			} else {
				$cs_node->sytle = 'horizontal';
			}
			foreach ($cs_xmlObject as $val) {
				if (!isset($val["icon"])){ $val["icon"] = '';}
				if (!isset($val["title"])){ $val["title"] = '';}
				if (!isset($val["style"])){ $val["style"] = '';}
				$tabs_count++;
				if ( $val["active"] == "yes")
					$tab_active = " active";
				else
					$tab_active = "";
				$html .= '<li class="' . $tab_active . '"><a data-toggle="tab" href="#tab' . $tab_counter . $tabs_count . '"><i class="fa '.$val["icon"].'"></i> ' . $val["title"] . '</a></li>';
			}
			$html .= '</ul>';
			$html .= '<div class="tab-content">';
			$tabs_count = 0;
			foreach ($cs_xmlObject as $val) {
				$tabs_count++;
				if ( $val["active"] == "yes")
					$tab_active = " active";
				else
					$tab_active = "";
				$html .= '<div class="tab-pane fade in ' . $tab_active . '" id="tab' . $tab_counter . $tabs_count . '">' . $val . '</div>';
			}
			$html .= '</div>';
			
			$html = '<div class="tabs '.$cs_node->sytle.'">' . $html . '</div>';
		}
		else {
			$aaa = array();
			$tab_counter++;
			$tabs_count = 0;
				$html = '<div class="element_size_'.$cs_node->tabs_element_size.'"><div class="tabs horizontal">';
					$html .= '<ul class="nav nav-tabs" id="myTab">';
					foreach ( $cs_node->tab as $cs_node ){
						$aaa["$cs_node->tab_title"] = $cs_node->tab_text;
						$tabs_count++;
						if ($cs_node->tab_active == "yes")
							$tab_active = " active";
						else
							$tab_active = "";
						$html .= '<li class="' . $tab_active . '"><a data-toggle="tab" href="#tab' . $tab_counter . $tabs_count . '"><i class="'.$cs_node->tab_title_icon.'"></i>' . $cs_node->tab_title . '</a></li>';
					}
					$html .= '</ul>';
					$html .= '<div class="tab-content">';
					$tabs_count = 0;
					foreach( $aaa as $keys=>$vals ){
						$tabs_count++;
						if ($tabs_count == 1)
							$tab_active = " active";
						else
							$tab_active = "";
						$html .= '<div class="tab-pane fade in ' . $tab_active . '" id="tab' . $tab_counter . $tabs_count . '">' . $vals . '</div>';
					}
					$html .= '</div></div>';
			$html = $html ;
		}
		return do_shortcode($html) . '<div class="clear"></div>';
	}
}
// Accrodian shortcode
if ( ! function_exists( 'cs_accordions_page' ) ) {
	function cs_accordions_page(){
		global $cs_node, $acc_counter;
		$acc_counter = rand(5, 15);
		$acc_counter++;
		$accordion_count = 0;
		$html = "";
		
		$html .= '<div class="panel-group fullwidth" id="accordion-' . $acc_counter . '">';
		$cs_xmlObject = new SimpleXMLElement( $cs_node->accordion_content );
		foreach ($cs_xmlObject as $cs_node) {
			if (!isset($cs_node["icon"])){ $cs_node["icon"] = '';}
			if (!isset($cs_node["title"])){ $cs_node["title"] = '';}
	
			$accordion_count++;
			if ($accordion_count == 1 && $cs_node["active"] == "yes")
					$class_active = "";
				else
					$class_active = " collapsed";
					
			if ( $cs_node["active"] == "yes"){
				
				$accordion_active = " in";
				 
			}else{
				$accordion_active = "";
				
			}
			$html .= '<div class="panel panel-default">';
			$html .= '<div class="panel-heading">';
			$html .= '<h4 class="panel-title"><a class="accordion-toggle '.$class_active .'" data-toggle="collapse" data-parent="#accordion-' . $acc_counter . '" href="#accordion-' . str_replace(" ", "", $accordion_count . $acc_counter) . '"><i class="fa '.$cs_node["icon"].'"></i> ' . $cs_node["title"] . '</a></h4>';
			$html .= '</div>';
			$html .= '<div id="accordion-' . str_replace(" ", "", $accordion_count . $acc_counter) . '" class="panel-collapse collapse ' . $accordion_active . '">';
			$html .= '<div class="panel-body">' . $cs_node . '</div>';
			$html .= '</div>';
			$html .= '</div>';
		}
		$html .= '</div>';
		
		return do_shortcode($html) . '<div class="clear"></div>';
	}
}
// Corlor Switcher for front end
function cs_color_switcher(){
	global $cs_theme_option;
 	if ( $cs_theme_option['color_switcher'] == "on" ) {

		if ( empty($_POST['patter_or_bg']) ){
			$_POST['patter_or_bg'] = '';
		}
		
		if ( empty($_POST['color_option']) ) { 
			$_POST['color_option'] = "black";
		}
		if ( empty($_POST['reset_color_txt']) ) { 
			$_POST['reset_color_txt'] = "";
		}
		else if ( $_POST['reset_color_txt'] == "1" ) {
			$_POST['custome_pattern'] = "";
			$_POST['bg_img'] = "";
			$_POST['style_sheet'] = "";
			$_POST['heading_color'] = "";
			$_SESSION['Soundblast_sess_custome_pattern'] = '';
			$_SESSION['Soundblast_sess_bg_img'] = "";
			$_SESSION['Soundblast_sess_style_sheet'] = $cs_theme_option['custom_color_scheme'];
			$_SESSION['Soundblast_sess_heading_color'] = $cs_theme_option['heading_color_scheme'];
			$_SESSION['sess_layout_option'] = "wrapper_boxed";
 		}
		
		
		if ( $_POST['patter_or_bg'] == 0 ){
			$_SESSION['Soundblast_sess_bg_img'] = '';
		}
		else if ( $_POST['patter_or_bg'] == 1 ){
			$_SESSION['Soundblast_sess_custome_pattern'] = '';
		}
		
		if ( isset($_POST['layout_option']) ) {
			$_SESSION['sess_layout_option'] = $_POST['layout_option'];
		}
		
		if ( isset($_POST['style_sheet']) ) {
			$_SESSION['Soundblast_sess_style_sheet'] = $_POST['style_sheet'];
		}
		if ( isset($_POST['heading_color']) ) {
			$_SESSION['Soundblast_sess_heading_color'] = $_POST['heading_color'];
		}
		if ( isset($_POST['custome_pattern']) ) {
			$_SESSION['Soundblast_sess_custome_pattern'] = $_POST['custome_pattern'];
		}
		if ( isset($_POST['bg_img']) ) {
			$_SESSION['Soundblast_sess_bg_img'] = $_POST['bg_img'];
		}
		if ( isset($_POST['color_option']) ) {
			//$_SESSION['Soundblast_sess_color_option'] = $_POST['color_option'];
		}
		
		if ( empty($_SESSION['sess_layout_option']) or $_POST['reset_color_txt'] == "1" ) { $_SESSION['sess_layout_option'] = "wrapper_boxed"; }
		if ( empty($_SESSION['Soundblast_sess_header_styles']) or $_POST['reset_color_txt'] == "1" ) { $_SESSION['Soundblast_sess_header_styles'] = ""; }
		if ( empty($_SESSION['Soundblast_sess_style_sheet']) or $_POST['reset_color_txt'] == "1" ) { $_SESSION['Soundblast_sess_style_sheet'] = $cs_theme_option['custom_color_scheme']; }
		if ( empty($_SESSION['Soundblast_sess_heading_color']) or $_POST['reset_color_txt'] == "1" ) { $_SESSION['Soundblast_sess_heading_color'] = $cs_theme_option['heading_color_scheme']; }
		if ( empty($_SESSION['Soundblast_sess_custome_pattern']) or $_POST['reset_color_txt'] == "1" ) { $_SESSION['Soundblast_sess_custome_pattern'] = ""; }
		//if ( empty($_SESSION['Soundblast_sess_color_option']) or $_POST['reset_color_txt'] == "1" ) { $_SESSION['Soundblast_sess_color_option'] = "black"; }
		if ( empty($_SESSION['Soundblast_sess_bg_img']) or $_POST['reset_color_txt'] == "1" ) { $_SESSION['Soundblast_sess_bg_img'] = ''; }

		$theme_path = get_template_directory_uri();	
		wp_enqueue_style( 'wp-color-picker' );
		
		wp_enqueue_script('iris',admin_url( 'js/iris.min.js' ), array( 'jquery-ui-draggable', 'jquery-ui-slider', 'jquery-touch-punch' ),false, 1  );
		wp_enqueue_script('wp-color-picker',admin_url( 'js/color-picker.min.js' ),array( 'iris' ),false,1);
		$colorpicker_l10n = array(
			'clear' => 'Clear',
			'defaultString' => 'Default',
			'pick' => 'Select Color'
		);
		wp_localize_script( 'wp-color-picker', 'wpColorPickerL10n', $colorpicker_l10n );
?>

		<script type="text/javascript">

        jQuery(document) .ready(function($){
		   jQuery("#togglebutton").click(function(){
				jQuery("#sidebarmain").trigger('click')
				jQuery(this).toggleClass('btnclose');
				jQuery("#sidebarmain") .toggleClass('sidebarmain');
				return false; 
		   });
           $("#pattstyles li label") .click(function(){
				$("#backgroundimages li label") .removeClass("active");	
				$("#patter_or_bg") .attr("value","0");
      			var ah = $(this) .find('input[type="radio"]') .val();
      			$('body') .css({"background":"url(<?php echo $theme_path?>/images/pattern/pattern"+ah+".png)"});
      			//$('body') .css({"background":"url(<?php echo $theme_path?>/images/pattern/pattern"+ah+".png)"});
      });
      $("#backgroundimages li label") .click(function(){
 		  $("#patter_or_bg") .attr("value","1");
		$("#pattstyles li label") .removeClass("active");	
      var ah = $(this) .find('input[type="radio"]') .val();
 	  var bg_url = "<?php echo $theme_path?>/images/background/bg"+ah+".jpg";
      $('body').css({"background":"#000 url(<?php echo $theme_path?>/images/background/bg"+ah+".jpg) no-repeat center center / cover fixed"});
     });
   $("#backgroundimages li label,#pattstyles li label") .click(function(){
    var classname=$(".layoutoption li:first-child label") .hasClass("active"); 
    if(classname) {
    alert("Please select Boxed View")
    return false; 
    }else {
      $(this) .parents(".selectradio") .find("label") .removeClass("active");
      $(this) .addClass("active"); 
     }
    });
	$(".layoutoption li label") .click(function(){
    var th = $(this).find('input') .val();
    $("#wrappermain-pix") .attr('class','');
    $('#wrappermain-pix') .addClass(th);
                $(this) .parents(".selectradio") .find("label") .removeClass("active");
                $(this) .addClass("active");
     			jQuery(".top_strip").trigger('resize');
     				
                });
    
    $(".accordion-sidepanel .innertext") .hide();
    $(".accordion-sidepanel header") .click(function(){
     if ($(this) .next() .is(":visible")){
       $(".accordion-sidepanel .innertext") .slideUp(300);
       $(".accordion-sidepanel header") .removeClass("active");
       return false;
      }
    $(".accordion-sidepanel .innertext") .slideUp(300);
    $(".accordion-sidepanel header") .removeClass("active");
    $(this) .addClass("active");
    $(this).next() .slideDown(300);
    });
        });

	jQuery(document).ready(function($){
		$(".colorpicker-main").click(function(){
		$(this).find('.wp-color-result').trigger('click'); 
    });
	var cf = ".colr,.colrhover:hover,.comment-respond form p input[type='submit'],.meet-artist article .social-network a:hover,.navigation ul > li:hover > a,.navigation ul > li.current-menu-item > a,#lang_sel a.lang_sel_sel:hover,.jp-playlist-item.jp-playlist-current span,.services article:hover h2 a,.cs-event-catgories a:hover,.widget-latestnews article figure figcaption,.widget_gallery ul li a:before,.post-options li a:hover,.woocommerce-tabs ul.tabs li.active a,.sociol-icons ul li:hover a,.bay-album i,.tagcloud.post-tags a:hover,.new-releases .bay-btn:hover,.cs-upcoming-gigs a";
	
	
	var bc = '.backcolr,.backcolrhover:hover,.navigation ul > li:hover > a:before,.navigation ul > li.current-menu-item > a:before,.gallerysec ul li figure figcaption i,.cart-secc .cart-qnt,#lang_sel ul ul a:hover,.services article:hover .hex,.cs-heading-title h2:before,.event article:hover .map-marker,.blogimg-hover a:hover,.gotop,.woocommerce-message:before,.woocommerce-error:before,.woocommerce-info:before,.woocommerce .button,.onsale,.event article:hover .play-icon,.text-icon a:after,.flex-direction-nav a,.widget_recent_comments ul li:hover,.widget_recent_entries ul li:hover,.widget_recent_entries ul li:hover,.widget-event article:hover .text,.widget_layered_nav ul li:hover,.widget_categories ul li:hover,.widget_nav_menu ul li a:hover,.product-categories li:hover,.widget_archive ul li:hover,.widget_pages ul li a:hover,.widget_links ul li:hover,.widget_meta ul li:hover,#wp-calendar caption';

	var boc = ".woocommerce-message,.woocommerce-error,.woocommerce-info,.bordercolr,.bordercolrhover:hover,.navigation ul ul";
	var background = '.jp-play-bar:after,.jp-play-bar:before';
	var styleheading = "";
	$('#themecolor .bg_color').wpColorPicker({
		change:function(event,ui){
			var a = ui.color.toString();
			$("#stylecss") .remove();
			$("<style type='text/css' id='stylecss'>"+cf+"{color:"+a+" !important}"+bc+"{background-color:"+a+" !important}"+background+"{background:"+a+" !important}"+boc+"{border-color:"+a+" !important}</style>").insertAfter("#wrappermain-pix");
			} 
    	});
	jQuery("#colorpickerwrapp span.col-box") .live("click",function(event) {
			//alert('test');
			var a = jQuery(this).data('color');
			//alert(a);
			jQuery("#bgcolor").val(a);
			jQuery('.wp-color-result').css('background-color', a);
			$("#stylecss") .remove();
			$("<style type='text/css' id='stylecss'>"+cf+"{color:"+a+" !important}"+bc+"{background-color:"+a+" !important}"+boc+"{border-color:"+a+" !important}</style>").insertAfter("#wrappermain-pix");
			
			
			
			jQuery("#colorpickerwrapp span.col-box") .removeClass('active');
			jQuery(this).addClass("active");
		}); 
 	$('#headingcolor .bg_color').wpColorPicker({
		change:function(event,ui){
			var a = ui.color.toString();
			$("#stylecsstwo") .remove();
			$("<style type='text/css' id='stylecsstwo'>"+styleheading+"{color:"+a+" !important}</style>").insertAfter("#wrappermain-pix");
			} 
    	}); 
	});
	function reset_color(){
		jQuery("#reset_color_txt").attr('value',"1")
		jQuery('input[ value="black"]').attr('checked', true);
		jQuery("#bgcolor").attr('value',"<?php echo $cs_theme_option['custom_color_scheme'];?>")
		jQuery("#headingcolorbg").attr('value',"<?php echo $cs_theme_option['heading_color_scheme']?>")
		jQuery("#color_switcher").submit();
	}
        </script>
        <div id="sidebarmain">
            <span id="togglebutton">&nbsp;</span>
            <div id="sidebar">
                <form method="post" id="color_switcher" action="">
                	<aside class="rowside">
                    	<header><h4>Layout options</h4></header>
						<h5>Choose Your Layout Style</h5>
                        <ul class="layoutoption selectradio">
                        	<li><label class="label_radio <?php if($_SESSION['sess_layout_option']=="wrapper")echo "active";?> "><img src="<?php echo $theme_path?>/images/admin/bg-btnwide.png" alt=""><input type="radio" name="layout_option" value="wrapper" ></label></li>
                        	<li><label class="label_radio <?php if($_SESSION['sess_layout_option']=="wrapper_boxed")echo "active";?> "><img src="<?php echo $theme_path?>/images/admin/bg-btnboxed.png" alt=""><input type="radio" name="layout_option" value="wrapper_boxed" ></label></li>
                        </ul>
                        
                        <label>Select Color Scheme</label>
                        <div id="colorpickerwrapp">
                            <?php $cs_color_array= array('#45b363','#339a74', '#1d7f5b', '#3fb0c3', '#2293a6', '#137d8f', '#9374ae', '#775b8f', '#dca13a', '#c46d32', '#c44732', '#c44d55', '#425660', '#292f32');
                            foreach($cs_color_array as $colors){
                                $active = '';
                                if($colors == $cs_theme_option['custom_color_scheme']){$active = 'active';}
                                echo '<span class="col-box '.$active.'" data-color="'.$colors.'" style="background: '.$colors.'"></span>';
                            }
                            ?>
                        </div>
                       <label for="bgcolor" id="themecolor" class="colorpicker-main">
                        <img src="<?php echo $theme_path?>/images/admin/img-colorpan.png" alt="">
                        <h5>Theme Color</h5>
                        <input id="bgcolor" name="style_sheet" type="text" class="bg_color" value="<?php echo $_SESSION['Soundblast_sess_style_sheet'];?>" /></label>
                        
                    </aside>
                    
                    
                    <div class="accordion-sidepanel">
                    <aside class="rowside">
                      <header>  <h4>Pattren Styles</h4></header>
                      <div class="innertext">
                      
                        <div id="pattstyles" class="itemstyles selectradio">
                            <ul>
                                <li><label <?php if($_SESSION['Soundblast_sess_custome_pattern']=="1")echo "class='active'";?> ><img src="<?php echo $theme_path?>/images/pattern/pattern1.png" alt=""><input type="radio" name="custome_pattern" value="1"></label></li>
                                <li><label <?php if($_SESSION['Soundblast_sess_custome_pattern']=="2")echo "class='active'";?> ><img src="<?php echo $theme_path?>/images/pattern/pattern2.png" alt=""><input type="radio" name="custome_pattern" value="2"></label></li>
                                <li><label <?php if($_SESSION['Soundblast_sess_custome_pattern']=="3")echo "class='active'";?> ><img src="<?php echo $theme_path?>/images/pattern/pattern3.png" alt=""><input type="radio" name="custome_pattern" value="3"></label></li>
                                <li><label <?php if($_SESSION['Soundblast_sess_custome_pattern']=="4")echo "class='active'";?> ><img src="<?php echo $theme_path?>/images/pattern/pattern4.png" alt=""><input type="radio" name="custome_pattern" value="4"></label></li>
                                <li><label <?php if($_SESSION['Soundblast_sess_custome_pattern']=="5")echo "class='active'";?> ><img src="<?php echo $theme_path?>/images/pattern/pattern5.png" alt=""><input type="radio" name="custome_pattern" value="5"></label></li>
                                <li><label <?php if($_SESSION['Soundblast_sess_custome_pattern']=="6")echo "class='active'";?> ><img src="<?php echo $theme_path?>/images/pattern/pattern6.png" alt=""><input type="radio" name="custome_pattern" value="6"></label></li>
                                <li><label <?php if($_SESSION['Soundblast_sess_custome_pattern']=="7")echo "class='active'";?> ><img src="<?php echo $theme_path?>/images/pattern/pattern7.png" alt=""><input type="radio" name="custome_pattern" value="7"></label></li>
                                <li><label <?php if($_SESSION['Soundblast_sess_custome_pattern']=="8")echo "class='active'";?> ><img src="<?php echo $theme_path?>/images/pattern/pattern8.png" alt=""><input type="radio" name="custome_pattern" value="8"></label></li>
                                <li><label <?php if($_SESSION['Soundblast_sess_custome_pattern']=="9")echo "class='active'";?> ><img src="<?php echo $theme_path?>/images/pattern/pattern9.png" alt=""><input type="radio" name="custome_pattern" value="9"></label></li>
                                <li><label <?php if($_SESSION['Soundblast_sess_custome_pattern']=="10")echo "class='active'";?> ><img src="<?php echo $theme_path?>/images/pattern/pattern10.png" alt=""><input type="radio" name="custome_pattern" value="10"></label></li>
                                <li><label <?php if($_SESSION['Soundblast_sess_custome_pattern']=="11")echo "class='active'";?> ><img src="<?php echo $theme_path?>/images/pattern/pattern11.png" alt=""><input type="radio" name="custome_pattern" value="11"></label></li>
                                <li><label <?php if($_SESSION['Soundblast_sess_custome_pattern']=="12")echo "class='active'";?> ><img src="<?php echo $theme_path?>/images/pattern/pattern12.png" alt=""><input type="radio" name="custome_pattern" value="12"></label></li>
                                <li><label <?php if($_SESSION['Soundblast_sess_custome_pattern']=="13")echo "class='active'";?> ><img src="<?php echo $theme_path?>/images/pattern/pattern13.png" alt=""><input type="radio" name="custome_pattern" value="13"></label></li>
                                <li><label <?php if($_SESSION['Soundblast_sess_custome_pattern']=="14")echo "class='active'";?> ><img src="<?php echo $theme_path?>/images/pattern/pattern14.png" alt=""><input type="radio" name="custome_pattern" value="14"></label></li>
                                <li><label <?php if($_SESSION['Soundblast_sess_custome_pattern']=="15")echo "class='active'";?> ><img src="<?php echo $theme_path?>/images/pattern/pattern15.png" alt=""><input type="radio" name="custome_pattern" value="15"></label></li>
                            </ul>
                        </div>
                        </div>
                    </aside>
                    <aside class="rowside">
                        <header><h4>Background Images</h4></header>
                        <div class="innertext">
                      
                        <div id="backgroundimages" class="selectradio">
                            <ul>
                            	<li><label <?php if($_SESSION['Soundblast_sess_bg_img']=="1")echo "class='active'";?> ><img src="<?php echo $theme_path?>/images/background/background1.png" alt=""><input type="radio" name="bg_img" value="1"></label></li>
                                <li><label <?php if($_SESSION['Soundblast_sess_bg_img']=="2")echo "class='active'";?> ><img src="<?php echo $theme_path?>/images/background/background2.png" alt=""><input type="radio" name="bg_img" value="2"></label></li>
                                <li><label <?php if($_SESSION['Soundblast_sess_bg_img']=="3")echo "class='active'";?> ><img src="<?php echo $theme_path?>/images/background/background3.png" alt=""><input type="radio" name="bg_img" value="3"></label></li>
                                <li><label <?php if($_SESSION['Soundblast_sess_bg_img']=="4")echo "class='active'";?> ><img src="<?php echo $theme_path?>/images/background/background4.png" alt=""><input type="radio" name="bg_img" value="4"></label></li>
                                <li><label <?php if($_SESSION['Soundblast_sess_bg_img']=="5")echo "class='active'";?> ><img src="<?php echo $theme_path?>/images/background/background5.png" alt=""><input type="radio" name="bg_img" value="5"></label></li>
                                <li><label <?php if($_SESSION['Soundblast_sess_bg_img']=="6")echo "class='active'";?> ><img src="<?php echo $theme_path?>/images/background/background6.png" alt=""><input type="radio" name="bg_img" value="6"></label></li>
                                <li><label <?php if($_SESSION['Soundblast_sess_bg_img']=="7")echo "class='active'";?> ><img src="<?php echo $theme_path?>/images/background/background7.png" alt=""><input type="radio" name="bg_img" value="7"></label></li>
                                <li><label <?php if($_SESSION['Soundblast_sess_bg_img']=="8")echo "class='active'";?> ><img src="<?php echo $theme_path?>/images/background/background8.png" alt=""><input type="radio" name="bg_img" value="8"></label></li>
                                
                            </ul>
                        </div>
                        </div>
                    </aside>
                    </div>
                	<div class="buttonarea">
                    	<input type="submit" value="Apply" class="btn" />
                        <input type="hidden" name="patter_or_bg" id="patter_or_bg" value="1" />
                        <input type="hidden" name="reset_color_txt" id="reset_color_txt" value="" />
                    	<input type="reset" value="Reset" class="btn" onclick="javascript:reset_color()" />
                    </div>
            </form>
            </div>
        </div>
<?php
	}
}
// skin
function cs_custom_color_skin() {
	global $cs_theme_option;
	if(isset($cs_theme_option['color_option']) && !empty($cs_theme_option['color_option'])){ $sp_sess_color_option = $cs_theme_option['color_option'];} else {$sp_sess_color_option = 'black';}
	if(!isset($sp_sess_color_option) || empty($sp_sess_color_option) || $sp_sess_color_option ==''){ $sp_sess_color_option = 'black';}
	$colorid='black_css';
	if($sp_sess_color_option=='white'){
		$colorid='white_css';
	}
	wp_enqueue_style($colorid, get_template_directory_uri() . '/css/'.$sp_sess_color_option.'.css');
}
/*
 * Ccustom Header Styles
 */
function cs_get_header() { 
global $cs_theme_option;
?>
    <header class="header">
        <!-- Container Strat -->
		<?php
            //<!-- Logo Start -->
            echo '<div class="logo">';
             cs_logo($cs_theme_option['logo'], $cs_theme_option['logo_width'], $cs_theme_option['logo_height']);
            echo '</div>';
            //<!-- Logo End -->
        ?>
         <!-- Navigation Start -->
        <nav class="navigation">
            <?php cs_navigation('main-menu'); ?>
        </nav>
        <!-- Navigation End -->
       <!-- <div class="header-right">
        <?php
		/*if ( class_exists( 'woocommerce' ) ){
			if(!isset($cs_theme_option['header_cart'])){$cs_theme_option['header_cart'] = 'on';}
			if($cs_theme_option['header_cart'] == 'on'){ cs_woocommerce_header_cart(); }
		}
		?>
        
        <?php 
		 if(isset($cs_theme_option['header_languages'])){
			 if(isset($cs_theme_option['header_languages']) && $cs_theme_option['header_languages'] == 'on'){
				do_action('icl_language_selector');
			 }
		 }*/
		?>
        </div>-->
    </header>
    
    <div class="clear"></div>
   
    <!-- Header End -->  
<?php 
}
/*
 * Ccustom Header Style End
 */
/*
Dynamic Css styles changes by color switcher
*/
function cs_custom_styles() {
	global $cs_theme_option;
 
	if ( isset($_POST['heading_color']) ) {
		$_SESSION['Soundblast_sess_heading_color'] = $_POST['heading_color'];
		$heading_color_scheme = $_SESSION['Soundblast_sess_heading_color'];
	}
	elseif (isset($_SESSION['Soundblast_sess_heading_color']) and $_SESSION['Soundblast_sess_heading_color'] <> '') {
		 $heading_color_scheme = $_SESSION['Soundblast_sess_heading_color'];
	}
	else{
		$heading_color_scheme = $cs_theme_option['heading_color_scheme'];
	}

  	if ( isset($_POST['style_sheet']) ) {
		$_SESSION['Soundblast_sess_style_sheet'] = $_POST['style_sheet'];
		$cs_color_scheme = $_SESSION['Soundblast_sess_style_sheet'];
	}
	elseif (isset($_SESSION['Soundblast_sess_style_sheet']) and $_SESSION['Soundblast_sess_style_sheet'] <> '') {
		$cs_color_scheme = $_SESSION['Soundblast_sess_style_sheet'];
	}
	else{
		$cs_color_scheme = $cs_theme_option['custom_color_scheme'];
	}
 ?>
	<style type="text/css">
		@charset "utf-8";
		/* Theme Color */
		.colr,.colrhover:hover,.comment-respond form p input[type="submit"],.meet-artist article .social-network a:hover,.navigation ul > li:hover > a,.navigation ul > li.current-menu-item > a,#lang_sel a.lang_sel_sel:hover,.jp-playlist-item.jp-playlist-current span,.services article:hover h2 a,.cs-event-catgories a:hover,.widget-latestnews article figure figcaption,.widget_gallery ul li a:before,.post-options li a:hover,.woocommerce-tabs ul.tabs li.active a,.sociol-icons ul li:hover a,.bay-album i,.tagcloud.post-tags a:hover,.new-releases .bay-btn:hover,.cs-upcoming-gigs a{
			color: <?php echo $cs_color_scheme;?> !important;
		}
		/* Theme Background Color */
		.backcolr,.backcolrhover:hover,.navigation ul > li:hover > a:before,.navigation ul > li.current-menu-item > a:before,.gallerysec ul li figure figcaption i,.cart-secc .cart-qnt,#lang_sel ul ul a:hover,.services article:hover .hex,.cs-heading-title h2:before,.event article:hover .map-marker,.blogimg-hover a:hover,.gotop,.woocommerce-message:before,.woocommerce-error:before,.woocommerce-info:before,.woocommerce .button,.onsale,.event article:hover .play-icon,.text-icon a:after,.flex-direction-nav a,.widget_recent_comments ul li:hover,.widget_recent_entries ul li:hover,.widget_recent_entries ul li:hover,.widget-event article:hover .text,.widget_layered_nav ul li:hover,.widget_categories ul li:hover,.widget_nav_menu ul li a:hover,.product-categories li:hover,.widget_archive ul li:hover,.widget_pages ul li a:hover,.widget_links ul li:hover,.widget_meta ul li:hover,#wp-calendar caption{
			background-color: <?php echo $cs_color_scheme;?> !important;
		}
		.jp-play-bar:after,.jp-play-bar:before{
			background:  <?php echo $cs_color_scheme;?> !important;
		}
		/* Theme Border Color */
		.woocommerce-message,.woocommerce-error,.woocommerce-info,.bordercolr,.bordercolrhover:hover,.navigation ul ul{
			border-color:  <?php echo $cs_color_scheme;?> !important;
		}
		.cs-heading-title, .page-title, .cs-section-title, .cs-heading-color{
			color: <?php echo $heading_color_scheme;?> !important;
		}
	</style>
<?php 
}
// Get post meta in xml form
function cs_meta_page($meta) {
    global $cs_meta_page;
    $meta = get_post_meta(get_the_ID(), $meta, true);
    if ($meta <> '') {
        $cs_meta_page = new SimpleXMLElement($meta);
        return $cs_meta_page;
    }
}
function cs_meta_shop_page($meta, $id){
    global $cs_meta_page;
    $meta = get_post_meta($id, $meta, true);
    if ($meta <> '') {
        $cs_meta_page = new SimpleXMLElement($meta);
        return $cs_meta_page;
    }
}
// pages sidebar
if ( ! function_exists( 'cs_meta_sidebar' ) ) { 
	function cs_meta_sidebar(){
		global $cs_meta_page;
		if ( $cs_meta_page->sidebar_layout->cs_layout <> '' and $cs_meta_page->sidebar_layout->cs_layout == 'right') {
			 echo "<aside class='sidebar-right span3'><div class='column'>";
			if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar($cs_meta_page->sidebar_layout->cs_sidebar_right) ) : endif;
			echo "</div></aside>";
		}
		else if ( $cs_meta_page->sidebar_layout->cs_layout <> '' and $cs_meta_page->sidebar_layout->cs_layout == 'left'  ) {
			echo "<aside class='sidebar-left span3'><div class='column'>";
			if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar($cs_meta_page->sidebar_layout->cs_sidebar_left) ) : endif;
			echo "</div></aside>";
		}
	}
}
// content class
if ( ! function_exists( 'cs_meta_content_class' ) ) {
	function cs_meta_content_class(){
		global $cs_meta_page,$video_width;
		if ( $cs_meta_page->sidebar_layout->cs_layout == '' or $cs_meta_page->sidebar_layout->cs_layout == 'none' ) {
			$content_class = "col-md-12 col-sm-12";
		}
		else if ( $cs_meta_page->sidebar_layout->cs_layout <> '' and $cs_meta_page->sidebar_layout->cs_layout == 'right' ) {
			$content_class = "col-sm-9 col-md-9";
		}
		else if ( $cs_meta_page->sidebar_layout->cs_layout <> '' and $cs_meta_page->sidebar_layout->cs_layout == 'left' ) {
			$content_class = "col-sm-9 col-md-9";
		}
		else{
			$content_class = "col-md-12 col-sm-12";
		}
		return $content_class;
	}
}
// sidebar class
if ( ! function_exists( 'cs_meta_sidebar_class' ) ) {
	function cs_meta_sidebar_class(){
		global $cs_meta_page;
		if ( $cs_meta_page->sidebar_layout->cs_layout <> '' and $cs_meta_page->sidebar_layout->cs_layout == 'right' ) {
			echo "sidebar-right span3";
		}
		else if ( $cs_meta_page->sidebar_layout->cs_layout <> '' and $cs_meta_page->sidebar_layout->cs_layout == 'left' ) {
			echo "sidebar-left span3";
		}
	}
}
// Content pages Meta Class
if ( ! function_exists( 'cs_default_pages_meta_content_class' ) ) { 
	function cs_default_pages_meta_content_class($layout){
		if ( $layout == '' or $layout == 'none' ) {
			echo "col-lg-12 col-md-12";
		}
		else if ( $layout <> '' and $layout == 'right' ) {
			echo "col-lg-9 col-md-9";
		}
		else if ( $layout <> '' and $layout == 'left' ) {
			echo "col-lg-9 col-md-9";
		}
	}	
}
// Default pages sidebar class
if ( ! function_exists( 'cs_default_pages_sidebar_class' ) ) { 
	function cs_default_pages_sidebar_class($layout){
		if ( $layout <> '' and $layout == 'right' ) {
			echo "col-lg-3 col-md-3";
		}
		else if ( $layout <> '' and $layout == 'left' ) {
			echo "col-lg-3 col-md-3";
		}
	}
}
// Default page sidebar
function cs_default_pages_sidebar(){
	global $cs_theme_option;
  	if ( $cs_theme_option['cs_layout'] <> '' and $cs_theme_option['cs_layout'] == 'right' ) {
		if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar($cs_theme_option['cs_sidebar_right']) ) : endif;
	}
	else if ( $cs_theme_option['cs_layout'] <> '' and $cs_theme_option['cs_layout'] == 'left' ) {
		if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar($cs_theme_option['cs_sidebar_left']) ) : endif;
	}
 }
// custom pagination start
if ( ! function_exists( 'cs_pagination' ) ) {
	function cs_pagination($total_records, $per_page, $qrystr = '') {
		global $cs_theme_option;
		/////////// Trans for Prev /////////
		$cs_prev_page = "";
		/////////// Trans for Prev end /////////
		if (empty($_GET['page_id_all'])) $_GET['page_id_all'] = 1;
		$html = '';
		$dot_pre = '';
		$dot_more = '';
		$total_page = ceil($total_records / $per_page);
		$loop_start = $_GET['page_id_all'] - 2;
		$loop_end = $_GET['page_id_all'] + 2;
		if ($_GET['page_id_all'] < 3) {
			$loop_start = 1;
			if ($total_page < 5)
				$loop_end = $total_page;
			else
				$loop_end = 5;
		}
		else if ($_GET['page_id_all'] >= $total_page - 1) {
			if ($total_page < 5)
				$loop_start = 1;
			else
				$loop_start = $total_page - 4;
			$loop_end = $total_page;
		}
		$html .="<nav class='pagination fullwidth'><ul>";
		if ($_GET['page_id_all'] > 1)
			
			$html .= "<li class='previs'><a href='?page_id_all=" . ($_GET['page_id_all'] - 1) . "$qrystr' >".__('Previous','Soundblast')."</a></li>";
		if ($_GET['page_id_all'] > 3 and $total_page > 5)
			$html .= "<li><a href='?page_id_all=1$qrystr'>1</a></li>";
		if ($_GET['page_id_all'] > 4 and $total_page > 6)
			$html .= "<li> <a>. . .</a> </li>";
		if ($total_page > 1) {
			for ($i = $loop_start; $i <= $loop_end; $i++) {
				if ($i <> $_GET['page_id_all'])
					$html .= "<li><a href='?page_id_all=$i$qrystr'>" . $i . "</a></li>";
				else
					$html .= "<li><a class='active'>" . $i . "</a></li>";
			}
		}
		if ($loop_end <> $total_page and $loop_end <> $total_page - 1)
			$html .= "<li> <a>. . .</a> </li>";
		if ($loop_end <> $total_page)
			$html .= "<li><a href='?page_id_all=$total_page$qrystr'>$total_page</a></li>";
		if ($_GET['page_id_all'] < $total_records / $per_page)
			$html .= "<li class='next'><a href='?page_id_all=" . ($_GET['page_id_all'] + 1) . "$qrystr' >".__('Next','Soundblast')."</a></li>";
			$html .="</ul></nav>";
		return $html;
	}
}

// pagination end
// Post image attachment function
function cs_attachment_image_src($attachment_id, $width, $height) {
    $image_url = wp_get_attachment_image_src($attachment_id, array($width, $height), true);
     if ($image_url[1] == $width and $image_url[2] == $height)
        ;
    else
        $image_url = wp_get_attachment_image_src($attachment_id, "full", true);
    	$parts = explode('/uploads/',$image_url[0]);
		if ( count($parts) > 1 ) return $image_url[0];
}
// Post image attachment source function
function cs_get_post_img_src($cs_post_id, $width, $height) {
    if(has_post_thumbnail()){
		$image_id = get_post_thumbnail_id($cs_post_id);
		$image_url = wp_get_attachment_image_src($image_id, array($width, $height), true);
		if ($image_url[1] == $width and $image_url[2] == $height) {
			return $image_url[0];
		} else {
			$image_url = wp_get_attachment_image_src($image_id, "full", true);
			return $image_url[0];
		}
	}
}
// Get Post image attachment
function cs_get_post_img($cs_post_id, $width, $height) {
    $image_id = get_post_thumbnail_id($cs_post_id);
    $image_url = wp_get_attachment_image_src($image_id, array($width, $height), true);
    if ($image_url[1] == $width and $image_url[2] == $height) {
        return get_the_post_thumbnail($cs_post_id, array($width, $height));
    } else {
        return get_the_post_thumbnail($cs_post_id, "full");
    }
}
// Get Main background
function cs_bg_image(){
	global $cs_theme_option;
	$bg_img = '';
 	if ( isset($_POST['bg_img']) ) {
		$_SESSION['Soundblast_sess_bg_img'] = $_POST['bg_img'];
		$bg_img = get_template_directory_uri()."/images/background/bg".$_SESSION['Soundblast_sess_bg_img'].".jpg";
	}
	else if ( isset($_SESSION['Soundblast_sess_bg_img']) and !empty($_SESSION['Soundblast_sess_bg_img'])){
		$bg_img = get_template_directory_uri()."/images/background/bg".$_SESSION['Soundblast_sess_bg_img'].".jpg";
	}
	else {
		if (isset($cs_theme_option['bg_img_custom']) and $cs_theme_option['bg_img_custom'] == "" ) {
			if (isset($cs_theme_option['bg_img']) and $cs_theme_option['bg_img'] <> 0 ){
				$bg_img = get_template_directory_uri()."/images/background/bg".$cs_theme_option['bg_img'].".jpg";
			}
		}
		else { 
			if(isset($cs_theme_option['bg_img_custom']) and !empty($cs_theme_option['bg_img_custom'])){ 
				$bg_img = $cs_theme_option['bg_img_custom'];
			}else{ 
			 $bg_img = get_template_directory_uri()."/images/background/bg1.jpg";
			}
		}
	}
	// bg color start
	if ( isset($_POST['bg_color']) ) {
		$_SESSION['Soundblast_sess_bg_color'] = $_POST['bg_color'];
		$bg_color = $_SESSION['Soundblast_sess_bg_color'];
	}
	else if ( isset($_SESSION['Soundblast_sess_bg_color']) ){
		$bg_color = $_SESSION['Soundblast_sess_bg_color'];
	}
	else {
		$bg_color = $cs_theme_option['bg_color'];
	}
	// bg color end
	if ( $bg_img <> "" ) {
		echo ' style="background:'.$bg_color.' url('.$bg_img.') ' . $cs_theme_option['bg_repeat'] . ' top ' . $cs_theme_option['bg_position'] . ' ' . $cs_theme_option['bg_attach'].'"';
	}
}

// Get Background color Pattren
function cs_bgcolor_pattern(){
	global $cs_theme_option;
	// pattern start
	$pattern = '';
	$bg_color = '';
	if ( isset($_POST['custome_pattern']) ) {
		$_SESSION['Soundblast_sess_custome_pattern'] = $_POST['custome_pattern'];
		$pattern = get_template_directory_uri()."/images/pattern/pattern".$_SESSION['Soundblast_sess_custome_pattern'].".png";
	}
	else if ( isset($_SESSION['Soundblast_sess_custome_pattern']) and !empty($_SESSION['Soundblast_sess_custome_pattern'])){
		$pattern = get_template_directory_uri()."/images/pattern/pattern".$_SESSION['Soundblast_sess_custome_pattern'].".png";
	}
	else {
		if ( $cs_theme_option['custome_pattern'] == "" ) {
			if ( $cs_theme_option['pattern_img'] <> 0 ){
				$pattern = get_template_directory_uri()."/images/pattern/pattern".$cs_theme_option['pattern_img'].".png";
			}
		}
		else { 
			$pattern = $cs_theme_option['custome_pattern'];
		}
	}
	// pattern end
	// bg color start
	if ( isset($_POST['bg_color']) ) {
		$_SESSION['Soundblast_sess_bg_color'] = $_POST['bg_color'];
		$bg_color = $_SESSION['Soundblast_sess_bg_color'];
	}
	else if ( isset($_SESSION['Soundblast_sess_bg_color']) ){
		$bg_color = $_SESSION['Soundblast_sess_bg_color'];
	}
	else {
		$bg_color = $cs_theme_option['bg_color'];
	}
	// bg color end
	echo ' style="background:'.$bg_color.' url('.$pattern.')"';
}
// Get Background color Pattren
function cs_bgcolor_patternnn(){
	global $cs_theme_option;
	// pattern start
	$bg_color_pattern = '';
	$pattern = '';
	$bg_color = '';
	//echo $_SESSION['sess_custome_pattern'];
	if ( isset($_POST['custome_pattern']) ) {
		$_SESSION['Soundblast_sess_custome_pattern'] = $_POST['custome_pattern'];
		$pattern = get_template_directory_uri()."/images/pattern/pattern".$_SESSION['Soundblast_sess_custome_pattern'].".png";
	}
	else if ( isset($_SESSION['Soundblast_sess_custome_pattern']) and !empty($_SESSION['Soundblast_sess_custome_pattern'])){
		$pattern = get_template_directory_uri()."/images/pattern/pattern".$_SESSION['Soundblast_sess_custome_pattern'].".png";
	}
	else {
		if ( $cs_theme_option['custome_pattern'] == "" ) {
			if ( $cs_theme_option['pattern_img'] <> 0 ){
				$pattern = get_template_directory_uri()."/images/pattern/pattern".$cs_theme_option['pattern_img'].".png";
			}
		}
		else { 
			$pattern = $cs_theme_option['custome_pattern'];
		}
	}
	// pattern end
	// bg color start
	if ( isset($_POST['bg_color']) ) {
		$_SESSION['Soundblast_sess_bg_color'] = $_POST['bg_color'];
		$bg_color = $_SESSION['Soundblast_sess_bg_color'];
	}
	else if ( isset($_SESSION['Soundblast_sess_bg_color']) ){
		$bg_color = $_SESSION['Soundblast_sess_bg_color'];
	}
	else {
		$bg_color = $cs_theme_option['bg_color'];
	}
	if((isset($bg_color) && !empty($bg_color)) || isset($pattern) && !empty($pattern)){
		$bg_color_pattern .= ' style="background:'.$bg_color.' url('.$pattern.')" ';
	}
	// bg color end
	echo $bg_color_pattern;
}

// Main wrapper class function
function cs_wrapper_class(){
	global $cs_theme_option;
 	
	if ( isset($_POST['layout_option']) ) {
		echo $_SESSION['sess_layout_option'] = $_POST['layout_option'];
	}
	elseif ( isset($_SESSION['sess_layout_option']) and !empty($_SESSION['sess_layout_option'])){
		echo $_SESSION['sess_layout_option'];
	}
	else {
		echo $cs_theme_option['layout_option'];
	}
}
  
/* Logo Function */
if ( ! function_exists( 'cs_logo' ) ) {
	function cs_logo($logo_url, $log_width, $logo_height){?>
            <a href="<?php echo home_url(); ?>">
        	<?php  if(isset($cs_theme_option['logo'])){ ?>
        	<img src="<?php echo $cs_theme_option['logo']; ?>" width="<?php echo $cs_theme_option['logo_width']; ?>" height="<?php echo $cs_theme_option['logo_height']; ?>" alt="<?php echo bloginfo('name'); ?>" />
        	<?php }else{ ?>
				<img src="<?php echo get_template_directory_uri();?>/images/logo.png" alt="<?php echo bloginfo('name'); ?>" /> 
			<?php }?>
        </a>
           <?php
	}
}

/* Under Construction logo Function */
function cs_uc_logo(){
	global $cs_theme_option;
	?>
	<a href="<?php echo home_url(); ?>"><img src="<?php echo $cs_theme_option['logo']; ?>"  style="width:<?php echo $cs_theme_option['logo_width']; ?>px; height:<?php echo $cs_theme_option['logo_height']; ?>px" alt="<?php echo bloginfo('name'); ?>" /></a>
 <?php
}
/* Top and Main Navigation */
if ( ! function_exists( 'cs_navigation' ) ) {
	function cs_navigation($nav='', $menus = 'menus'){
		global $cs_theme_option;
		// Menu parameters	
		$defaults = array(
			'theme_location' => "$nav",
			'menu' => '',
			'container' => '',
			'container_class' => '',
			'container_id' => '',
			'menu_class' => "$menus",
			'menu_id' => "$menus",
			'echo' => false,
			'fallback_cb' => 'wp_page_menu',
			'before' => '',
			'after' => '',
			'link_before' => '',
			'link_after' => '',
			'items_wrap' => '<ul id="%1$s" class="%2$s">%3$s</ul>',
			'depth' => 0,
			'walker' => '',);
		echo do_shortcode(wp_nav_menu($defaults));
	}
}


 // Header simple, toggle and custom Search at front end//
function cs_header_search(){ ?>
    
    <!-- Search Start -->
    <div class="search-sec">
        <form action="<?php echo home_url() ?>" id="searchform" method="get" role="search">
            <input type="text" name="s" class="search-input" value="<?php _e('Search for:', "Soundblast"); ?>">
            <label><input type="submit" name="" value="" class="search-btn"></label>
        </form>  
    </div>
    <!-- Search End -->
<?php
}

if ( ! function_exists( 'cs_under_construction_id' ) ) {
	function cs_under_construction_id(){ 
		$under_id = '';
		global $cs_theme_option, $post;
		if(isset($post)){ $post_name = $post->post_name;  }else{ $post_name = ''; }
		if ( $cs_theme_option['under-construction'] == "on" or $post_name == "pf-under-construction" ) { 
			$under_id = 'id="under-construction"';
		}
		return $under_id;
	}
}

/* Under Construction Page */
if ( ! function_exists( 'cs_under_construction' ) ) {
	function cs_under_construction(){ 
		global $cs_theme_option, $post;
		if(isset($post)){ $post_name = $post->post_name;  }else{ $post_name = ''; }
		if ( $cs_theme_option['under-construction'] == "on" or $post_name == "pf-under-construction" ) { 
		?>
	<div class="wrapper wrapper_boxed" id="wrappermain-pix">
        <div class="bottom_strip">
          <div class="container">
            <div class="logo">
                    <?php if($cs_theme_option['showlogo'] == "on"){ cs_uc_logo(); } ?>
                </div>
          </div>
        </div>
        <div id="undercontruction">
          <div id="midarea">
              <?php
			  if($cs_theme_option['under_construction_text'] <> ""){
				  echo htmlspecialchars_decode($cs_theme_option['under_construction_text']);
			  }
			  ?>
            <script type="text/javascript" src="js/jquery.countdown.js"></script>
            <div class="countdownit"><div id="defaultCountdown3543"></div></div>
            </div>
            
                  <?php
                    $launch_date = $cs_theme_option['launch_date'];
                    $year = date("Y", strtotime($launch_date));
                    $month = date("m", strtotime($launch_date));
                    $month_event_c = date("M", strtotime($launch_date));							
                    $day = date("d", strtotime($launch_date));
                    $time_left = date("H,i,s", strtotime($launch_date));
                    
                    ?>
                    <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/scripts/frontend/jquery.countdown.js"></script>
                    <script type="text/javascript">
                        //Countdown callback function
                        jQuery(function () {
                            var austDay = new Date();
                            austDay = new Date(<?php echo $year; ?>,<?php echo $month; ?>-1,<?php echo $day; ?>);
                            jQuery('#defaultCountdown3543').countdown({until: austDay});
                            jQuery('#year').text(austDay.getFullYear());
                        });
                    
                    </script>
        
        </div>
    <div class="clear"></div>
    </div>
<?php die();
	 }
	}
} 
/* Widget Section Start */
// widget_facebook start
class cs_facebook_module extends WP_Widget
{
  function cs_facebook_module()
  {
		$widget_ops = array('classname' => 'facebok_widget', 'description' => 'Facebook widget like box total customized with theme.' );
		$this->WP_Widget('cs_facebook_module', 'CS : Facebook', $widget_ops);
  }
  function form($instance)
  {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
		$title = $instance['title'];
		$pageurl = isset( $instance['pageurl'] ) ? esc_attr( $instance['pageurl'] ) : '';
		$showfaces = isset( $instance['showfaces'] ) ? esc_attr( $instance['showfaces'] ) : '';
		$showstream = isset( $instance['showstream'] ) ? esc_attr( $instance['showstream'] ) : '';
		$showheader = isset( $instance['showheader'] ) ? esc_attr( $instance['showheader'] ) : '';
		$fb_bg_color = isset( $instance['fb_bg_color'] ) ? esc_attr( $instance['fb_bg_color'] ) : '';
		//$likebox_width = isset( $instance['likebox_width'] ) ? esc_attr( $instance['likebox_width'] ) : '';
		$likebox_height = isset( $instance['likebox_height'] ) ? esc_attr( $instance['likebox_height'] ) : '';						
	?>
	  <p>
	  <label for="<?php echo $this->get_field_id('title'); ?>">
		  Title: 
		  <input class="upcoming" id="<?php echo $this->get_field_id('title'); ?>" size='40' name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
	  </label>
	  </p> 
	  <p>
	  <label for="<?php echo $this->get_field_id('pageurl'); ?>">
		  Page URL: 
		  <input class="upcoming" id="<?php echo $this->get_field_id('pageurl'); ?>" size='40' name="<?php echo $this->get_field_name('pageurl'); ?>" type="text" value="<?php echo esc_attr($pageurl); ?>" />
		<br />
		  <small>Please enter your page or User profile url example: http://www.facebook.com/profilename OR <br />
		  https://www.facebook.com/pages/wxyz/123456789101112
		</small><br />
		<!--<strong>Only People Will Be Shown Please Use Height to Manage Your View.</strong>-->
	  </label>
	  </p> 
	  <p>
 	  <label for="<?php echo $this->get_field_id('showfaces'); ?>">
		  Show Faces: 
		  <input class="upcoming" id="<?php echo $this->get_field_id('showfaces'); ?>" name="<?php echo $this->get_field_name('showfaces'); ?>" type="checkbox" <?php if(esc_attr($showfaces) != '' ){echo 'checked';}?> />
	  </label>
	  </p> 
	  <p>
	  <label for="<?php echo $this->get_field_id('showstream'); ?>">
		  Show Stream: 
		  <input class="upcoming" id="<?php echo $this->get_field_id('showstream'); ?>" name="<?php echo $this->get_field_name('showstream'); ?>" type="checkbox" <?php if(esc_attr($showstream) != '' ){echo 'checked';}?> />
	  </label>
	  </p> 
	  <!--<p>
	  <label for="<?php echo $this->get_field_id('likebox_width'); ?>">
		  Like Box Width:
		  <input class="upcoming" id="<?php echo $this->get_field_id('likebox_width'); ?>" size='5' name="<?php echo $this->get_field_name('likebox_width'); ?>" type="text" value="<?php echo esc_attr($likebox_width); ?>" />
	  </label>
	  </p>-->
	  <p>
	  <label for="<?php echo $this->get_field_id('likebox_height'); ?>">
		  Like Box Height:
		  <input class="upcoming" id="<?php echo $this->get_field_id('likebox_height'); ?>" size='2' name="<?php echo $this->get_field_name('likebox_height'); ?>" type="text" value="<?php echo esc_attr($likebox_height); ?>" />
	  </label>
	  </p>
      <p>		
     <label for="<?php echo $this->get_field_id('fb_bg_color'); ?>">
     	Background Color:
  		<input type="text" name="<?php echo $this->get_field_name('fb_bg_color'); ?>" size='4' id="<?php echo $this->get_field_id('fb_bg_color'); ?>"  value="<?php if(!empty($fb_bg_color)){ echo $fb_bg_color;}else{ echo "#fff";}; ?>" class="fb_bg_color upcoming"  />
    </label>
    </p>
	<?php
	  }
	  function update($new_instance, $old_instance)
	  {
		$instance = $old_instance;
		$instance['title'] = $new_instance['title'];
		$instance['pageurl'] = $new_instance['pageurl'];
		$instance['showfaces'] = $new_instance['showfaces'];	
		$instance['showstream'] = $new_instance['showstream'];
		$instance['showheader'] = $new_instance['showheader'];
		$instance['fb_bg_color'] = $new_instance['fb_bg_color'];
		//$instance['likebox_width'] = $new_instance['likebox_width'];
		$instance['likebox_height'] = $new_instance['likebox_height'];
		return $instance;
	  }
		function widget($args, $instance)
		{
			extract($args, EXTR_SKIP);
			$title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
			$pageurl = empty($instance['pageurl']) ? ' ' : apply_filters('widget_title', $instance['pageurl']);
			$showfaces = empty($instance['showfaces']) ? ' ' : apply_filters('widget_title', $instance['showfaces']);
			$showstream = empty($instance['showstream']) ? ' ' : apply_filters('widget_title', $instance['showstream']);
			$showheader = empty($instance['showheader']) ? ' ' : apply_filters('widget_title', $instance['showheader']);
			$fb_bg_color = empty($instance['fb_bg_color']) ? ' ' : apply_filters('widget_title', $instance['fb_bg_color']);								
			//$likebox_width = empty($instance['likebox_width']) ? ' ' : apply_filters('widget_title', $instance['likebox_width']);								
			$likebox_height = empty($instance['likebox_height']) ? ' ' : apply_filters('widget_title', $instance['likebox_height']);													
			if(isset($showfaces) AND $showfaces == 'on'){$showfaces ='true';}else{$showfaces = 'false';}
			if(isset($showstream) AND $showstream == 'on'){$showstream ='true';}else{$showstream ='false';}
			
			echo $before_widget;	
			// WIDGET display CODE Start
			if (!empty($title) && $title <> ' '){
				echo $before_title;
				echo $title;
				echo $after_title;
			}
				global $wpdb, $post;?>
				<style type="text/css" >
					.facebookOuter {
						background-color:<?php echo $fb_bg_color ?>; 
						width:100%; 
						padding:0;
						float:left;
					}
					.facebookInner {
						float: left;
						width: 100%;
					}
					.facebook_module, .fb_iframe_widget > span, .fb_iframe_widget > span > iframe {
					 width: 100% !important;
					}
					.fb_iframe_widget, .fb-like-box div span iframe {
					 width: 100% !important;
					 float: left;
					}
				</style>
				<div class="facebook">
					<div class="facebookOuter">
				 <div class="facebookInner">
				  <div class="fb-like-box" 
					  colorscheme="light" data-height="<?php echo $likebox_height;?>"  data-width="190" 
					  data-href="<?php echo $pageurl;?>" 
					  data-border-color="#fff" data-show-faces="<?php echo $showfaces;?>"  data-show-border="false"
					  data-stream="<?php echo $showstream;?>" data-header="false">
				  </div>          
				 </div>
				</div>
				</div>
 				<script>(function(d, s, id) {
				  var js, fjs = d.getElementsByTagName(s)[0];
				  if (d.getElementById(id)) return;
				  js = d.createElement(s); js.id = id;
				  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
				  fjs.parentNode.insertBefore(js, fjs);
				}(document, 'script', 'facebook-jssdk'));
				</script>
		<?php echo $after_widget;
			}
			
		}
add_action( 'widgets_init', create_function('', 'return register_widget("cs_facebook_module");') );
	// widget_facebook end


// widget_gallery start
class cs_gallery extends WP_Widget {
	
		function cs_gallery() {
			$widget_ops = array('classname' => 'widget_gallery', 'description' => 'Select any gallery to show in widget.');
			$this->WP_Widget('cs_gallery', 'CS : Gallery Widget', $widget_ops);
		}
	
		function form($instance) {
			$instance = wp_parse_args((array) $instance, array('title' => '', 'get_names_gallery' => 'new'));
			$title = $instance['title'];
			$get_names_gallery = isset($instance['get_names_gallery']) ? esc_attr($instance['get_names_gallery']) : '';
			$showcount = isset($instance['showcount']) ? esc_attr($instance['showcount']) : '';
			?>
			<p>
				<label for="<?php echo $this->get_field_id('title'); ?>">
					Title: 
					<input class="upcoming" id="<?php echo $this->get_field_id('title'); ?>" size="40" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
				</label>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id('get_names_gallery'); ?>">
					Select Gallery:
					<select id="<?php echo $this->get_field_id('get_names_gallery'); ?>" name="<?php echo $this->get_field_name('get_names_gallery'); ?>" style="width:225px;">
						<?php
						global $wpdb, $post;
						$newpost = 'posts_per_page=-1&post_type=cs_gallery&order=ASC&post_status=publish';
						$newquery = new WP_Query($newpost);
						while ($newquery->have_posts()): $newquery->the_post();
							?>
							<option <?php
							if (esc_attr($get_names_gallery) == $post->post_name) {
								echo 'selected';
							}
							?> value="<?php echo $post->post_name; ?>" >
							<?php echo substr(get_the_title($post->ID), 0, 20);
							if (strlen(get_the_title($post->ID)) > 20)
								echo "...";
							?>
							</option>						
						<?php endwhile; ?>
					</select>
				</label>
			</p>  
			 
			<p>
				<label for="<?php echo $this->get_field_id('showcount'); ?>">
					Number of Images: 
					<input class="upcoming" id="<?php echo $this->get_field_id('showcount'); ?>" size="2" name="<?php echo $this->get_field_name('showcount'); ?>" type="text" value="<?php echo esc_attr($showcount); ?>" />
				</label>
			</p>  
			<?php
		}
	
		function update($new_instance, $old_instance) {

			$instance = $old_instance;
			$instance['title'] = $new_instance['title'];
			$instance['get_names_gallery'] = $new_instance['get_names_gallery'];
			$instance['showcount'] = $new_instance['showcount'];
  			return $instance;
		}
	
		function widget($args, $instance) {
			extract($args, EXTR_SKIP);
			global $wpdb, $post;
			$title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
			$get_names_gallery = isset($instance['get_names_gallery']) ? esc_attr($instance['get_names_gallery']) : '';
			$showcount = isset($instance['showcount']) ? esc_attr($instance['showcount']) : '';
			if (empty($showcount)) {
				 $showcount = '12';
			}
			
			// WIDGET display CODE Start
			echo $before_widget;
			if (strlen($get_names_gallery) <> 1 || strlen($get_names_gallery) <> 0) {
				echo $before_title . $title . $after_title;
			}
 			if ($get_names_gallery <> '') {
 				// galery slug to id start
				$get_gallery_id = '';
				$args=array(
					'name' => $get_names_gallery,
					'post_type' => 'cs_gallery',
					'post_status' => 'publish',
					'showposts' => 1,
				);
				$get_posts = get_posts($args);
 				if($get_posts){
					$get_gallery_id = $get_posts[0]->ID;
				}
				// galery slug to id end
				if($get_gallery_id <> ''){
				$cs_meta_gallery_options = get_post_meta($get_gallery_id, "cs_meta_gallery_options", true);
				if ($cs_meta_gallery_options <> "") {
					$cs_xmlObject = new SimpleXMLElement($cs_meta_gallery_options);
					if ($showcount > count($cs_xmlObject->gallery)) {
						$showcount = count($cs_xmlObject->gallery);
					}
				?>
				<ul class="gallery-list lightbox">
					<?php
  						for ($i = 0; $i < $showcount; $i++) {
							$path = $cs_xmlObject->gallery[$i]->path;
							$title = $cs_xmlObject->gallery[$i]->title;
							$description = $cs_xmlObject->gallery[$i]->description;
							$social_network = $cs_xmlObject->gallery[$i]->social_network;
							$use_image_as = $cs_xmlObject->gallery[$i]->use_image_as;
							$video_code = $cs_xmlObject->gallery[$i]->video_code;
							$link_url = $cs_xmlObject->gallery[$i]->link_url;
							$image_url = cs_attachment_image_src($path, 150, 150);
							$image_url_full = cs_attachment_image_src($path, 0, 0);
						?>
						 <li>
							<a <?php if ( $description <> '' ) { echo 'data-title="'.$description.'"'; }?> href="<?php if ($use_image_as == 1)echo $video_code;  elseif($use_image_as==2) echo $link_url; else echo $image_url_full;?>" target="<?php if($use_image_as==2){ echo '_blank'; }else{ echo '_self'; }; ?>" class="link" data-rel="<?php if ($use_image_as == 1) echo "prettyPhoto"; elseif($use_image_as==2) echo ""; else echo "prettyPhoto[gallery1]"?>"><?php echo "<img src='" . $image_url . "' data-alt='" . $title . "' alt='' />" ?></a>
						</li>
				<?php } ?>
				</ul>
			 <?php }}else{
				 echo '<p>'.__( 'No results found.', 'Soundblast' ).'</p>';
				 }}     // endif of Category Selection?>
				
			 <?php
 			echo $after_widget; // WIDGET display CODE End
		}
	
	}
	
	add_action('widgets_init', create_function('', 'return register_widget("cs_gallery");'));
	// widget_gallery end

	
	// widget_recent_post start
class cs_recentposts extends WP_Widget {
	  function cs_recentposts()
	  {
		$widget_ops = array('classname' => 'widget-latestnews', 'description' => 'Recent Posts from category.' );
		$this->WP_Widget('cs_recentposts', 'CS : Recent Posts', $widget_ops);
	  }
	 
	  function form($instance)
	  {
		$instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
		$title = $instance['title'];
		$select_category = isset( $instance['select_category'] ) ? esc_attr( $instance['select_category'] ) : '';
		$showcount = isset( $instance['showcount'] ) ? esc_attr( $instance['showcount'] ) : '';	
		$thumb = isset( $instance['thumb'] ) ? esc_attr( $instance['thumb'] ) : '';
	?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>">
				Title: 
				<input class="upcoming" id="<?php echo $this->get_field_id('title'); ?>" size="40" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
			</label>
		</p> 
		<p>
			<label for="<?php echo $this->get_field_id('select_category'); ?>">
			  Select Category:            
			  <select id="<?php echo $this->get_field_id('select_category'); ?>" name="<?php echo $this->get_field_name('select_category'); ?>" style="width:225px">
				<?php
				$categories = get_categories();
					if($categories <> ""){
						foreach ( $categories as $category ) {?>
							<option <?php if($select_category == $category->slug){echo 'selected';}?> value="<?php echo $category->slug;?>" ><?php echo $category->name;?></option>						
						<?php }?>
					<?php }?>            
			  </select>
			</label>
		</p>  
		<p>
			<label for="<?php echo $this->get_field_id('showcount'); ?>">
				Number of Posts To Display:
				<input class="upcoming" id="<?php echo $this->get_field_id('showcount'); ?>" size='2' name="<?php echo $this->get_field_name('showcount'); ?>" type="text" value="<?php echo esc_attr($showcount); ?>" />
			</label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('thumb'); ?>">
				Display Thumbnails:
				<input class="upcoming" id="<?php echo $this->get_field_id('thumb'); ?>" size='2' name="<?php echo $this->get_field_name('thumb'); ?>" value="true" type="checkbox"  <?php if(isset($instance['thumb']) && $instance['thumb']=='true' ) echo 'checked="checked"'; ?> />
			</label>
		</p>
	<?php
	  }
	 
	  function update($new_instance, $old_instance)
	  {
		$instance = $old_instance;
		$instance['title'] = $new_instance['title'];
		$instance['select_category'] = $new_instance['select_category'];
		$instance['showcount'] = $new_instance['showcount'];
		$instance['thumb'] = $new_instance['thumb'];
		return $instance;
	  }
	 
		function widget($args, $instance)
		{
			global $cs_node;
			extract($args, EXTR_SKIP);
			$title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
			$select_category = empty($instance['select_category']) ? ' ' : apply_filters('widget_title', $instance['select_category']);		
			$showcount = empty($instance['showcount']) ? ' ' : apply_filters('widget_title', $instance['showcount']);	
			$thumb = isset( $instance['thumb'] ) ? esc_attr( $instance['thumb'] ) : '';						
	
			if($instance['showcount'] == ""){$instance['showcount'] = '-1';}
			echo $before_widget;	
			// WIDGET display CODE Start
			if (!empty($title) && $title <> ' '){
				echo $before_title;
				echo $title;
				echo $after_title;
			}	$cs_theme_option = get_option('cs_theme_option');
				global $wpdb, $post, $cs_theme_options;?>
				<!-- Recent Posts Start -->
 						<?php
							wp_reset_query();
							$args = array( 'posts_per_page' => "$showcount",'post_type' => 'post','category_name' => "$select_category"); 
							$custom_query = new WP_Query($args);
							$no_image = $image_url =  "";
							if ( $custom_query->have_posts() <> "" ) {
								while ( $custom_query->have_posts()) : $custom_query->the_post();
								$post_xml = get_post_meta($post->ID, "post", true);	
								$cs_xmlObject = new stdClass();
								if ( $post_xml <> "" ) {
									$cs_xmlObject = new SimpleXMLElement($post_xml);
									$post_view = '';
									$post_view = $cs_xmlObject->post_thumb_view;
									$post_image = $cs_xmlObject->post_thumb_image;
									$post_video = $cs_xmlObject->post_thumb_video;
									$post_audio = $cs_xmlObject->post_thumb_audio;
									$post_slider = $cs_xmlObject->post_thumb_slider;
									$post_slider_type = $cs_xmlObject->post_thumb_slider_type;
 									$width 	= 150;
									$height = 150;
 									$image_url = cs_get_post_img_src($post->ID, $width, $height);
									if($image_url == ""){$no_image = 'class="no-image"';}
 									}
								?>
									<!-- Upcoming Widget Start -->
                                    <article <?php echo $no_image; ?>>
                                    <?php if($thumb == "true" && $image_url <> ''){?>
                                        <figure><a href="<?php echo get_permalink(); ?>"><img src="<?php echo $image_url; ?>" alt=""></a>
                                        <figcaption>
                                        	<i class="fa fa-plus"></i>
                                        </figcaption>
                                        </figure>
                                        <?php }?>
                                        <div class="text webkit">
                                            <h2 class="cs-post-title cs-heading-color"><a href="<?php echo get_permalink(); ?>" class="colrhover"><?php echo substr(get_the_title(),0,30); if ( strlen(get_the_title()) > 30) echo "..."; ?></a></h2>
                                         
                                        <time datetime="<?php echo get_the_date();?>"><?php echo get_the_date();?></time>
                                        </div>
                                    </article>
								<?php endwhile; ?>
							<?php
                            }
							else {
								echo '<p>'.__( 'No results found.', 'Soundblast' ).'</p>';
							}?>
  				<!-- Recent Posts End -->    
				<?php
				echo $after_widget;
			}
		}
		add_action( 'widgets_init', create_function('', 'return register_widget("cs_recentposts");') );
	// widget_recent_post end
	// widget_twitter start
 	class cs_twitter_widget extends WP_Widget {
		function cs_twitter_widget() {
			$widget_ops = array('classname' => 'widget-twitter', 'description' => 'Twitter Widget');
			$this->WP_Widget('cs_twitter_widget', 'CS : Twitter Widget', $widget_ops);
		}
		function form($instance) {
			$instance = wp_parse_args((array) $instance, array('title' => ''));
			$title = $instance['title'];
			$username = isset($instance['username']) ? esc_attr($instance['username']) : '';
			$numoftweets = isset($instance['numoftweets']) ? esc_attr($instance['numoftweets']) : '';
 		?>
          	<label for="<?php echo $this->get_field_id('title'); ?>">
				<span>Title: </span>
				<input class="upcoming" id="<?php echo $this->get_field_id('title'); ?>" size="40" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
			</label>
			<label for="screen_name">User Name<span class="required">(*)</span>: </label>
				<input class="upcoming" id="<?php echo $this->get_field_id('username'); ?>" size="40" name="<?php echo $this->get_field_name('username'); ?>" type="text" value="<?php echo esc_attr($username); ?>" />
            <label for="tweet_count">
			<span>Num of Tweets: </span>
			<input class="upcoming" id="<?php echo $this->get_field_id('numoftweets'); ?>" size="2" name="<?php echo $this->get_field_name('numoftweets'); ?>" type="text" value="<?php echo esc_attr($numoftweets); ?>" />
			<div class="clear"></div>
			</label>
  		<?php
		}
	
		function update($new_instance, $old_instance) {
			$instance = $old_instance;
			$instance['title'] = $new_instance['title'];
			$instance['username'] = $new_instance['username'];
			$instance['numoftweets'] = $new_instance['numoftweets'];
			
 			return $instance;
		}
  		function widget($args, $instance) {
			global $cs_theme_option;
			extract($args, EXTR_SKIP);
			$title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
			$username = $instance['username'];
 			$numoftweets = $instance['numoftweets'];		
	 		if($numoftweets == ''){$numoftweets = 2;}
			echo $before_widget;
  			// WIDGET display CODE Start
			if (!empty($title) && $title <> ' '){
				echo $before_title . $title . $after_title;
			}
			if(strlen($username) > 1){
					$text ='';
					$return = '';
					require_once "include/twitteroauth/twitteroauth.php"; //Path to twitteroauth library
					$consumerkey = $cs_theme_option['consumer_key'];
					$consumersecret = $cs_theme_option['consumer_secret'];
					$accesstoken = $cs_theme_option['access_token'];
					$accesstokensecret = $cs_theme_option['access_token_secret'];
 					$connection = new TwitterOAuth($consumerkey, $consumersecret, $accesstoken, $accesstokensecret);
 					$tweets = $connection->get("https://api.twitter.com/1.1/statuses/user_timeline.json?screen_name=".$username."&count=".$numoftweets);
  					if(!is_wp_error($tweets) and is_array($tweets)){
						$return .= "<div class='twitter_sign webkit'>
						<div class='tweets-wrapper'>";
							foreach($tweets as $tweet) {
								$text = $tweet->text; 
								$large_ts = time();
								$n = $large_ts - strtotime($tweet->{'created_at'});
								if($n < (60)){ $posted = sprintf(__('%d seconds ago','Soundblast'),$n); }
								elseif($n < (60*60)) { $minutes = round($n/60); $posted = sprintf(_n('About a Minute Ago','@%d Minutes Ago',$minutes,'Soundblast'),$minutes); }
								elseif($n < (60*60*16)) { $hours = round($n/(60*60)); $posted = sprintf(_n('About an Hour Ago','@%d Hours Ago',$hours,'Soundblast'),$hours); }
								elseif($n < (60*60*24)) { $hours = round($n/(60*60)); $posted = sprintf(_n('About an Hour Ago','@%d Hours Ago',$hours,'Soundblast'),$hours); }
								elseif($n < (60*60*24*6.5)) { $days = round($n/(60*60*24)); $posted = sprintf(_n('About a Day Ago','@%d Days Ago',$days,'Soundblast'),$days); }
								elseif($n < (60*60*24*7*3.5)) { $weeks = round($n/(60*60*24*7)); $posted = sprintf(_n('About a Week Ago','%d Weeks Ago',$weeks,'Soundblast'),$weeks); } 
								elseif($n < (60*60*24*7*4*11.5)) { $months = round($n/(60*60*24*7*4)) ; $posted = sprintf(_n('About a Month Ago','%d Months Ago',$months,'Soundblast'),$months);}
								elseif($n >= (60*60*24*7*4*12)){$years=round($n/(60*60*24*7*52)) ; $posted = sprintf(_n('About a year Ago','%d years Ago',$years,'Soundblast'),$years);}
								$return .="<article><div class='text webkit'>";
								$return .= "<p>" . $text . "</p>";
								$return .= "<a>" . $posted. "</a>";
								$return .="</div></article>";
						}
				$return .= "</div>
				<i class='fa fa-twitter'></i>
				
				<div class='clear'></div></div>";
				echo $return;
 		}else{
			if($tweets->errors[0] <> ""){
				echo $tweets->errors[0]->message.".<br> Please enter valid Twitter API Keys";
			}else{
				_e( 'No results found.', 'Soundblast' );	
			}
		}
	}else{ 				
			echo '<h4>No User information given.</h4>';
		}
		echo $after_widget;
		// WIDGET display CODE End
		}
 	}
 	add_action('widgets_init', create_function('', 'return register_widget("cs_twitter_widget");'));
	
	// widget_twitter end

// widget end
// Event Widget

class cs_upcoming_events extends WP_Widget
{
  function cs_upcoming_events()
  {
    $widget_ops = array('classname' => 'widget-event', 'description' => 'Select Event to show its countdown.' );
    $this->WP_Widget('cs_upcoming_events', 'CS : Upcoming Events', $widget_ops);
  }
 
  function form($instance)
  {
    $instance = wp_parse_args( (array) $instance, array( 'title' => '' ,'widget_names_events' =>'new') );
    $title = $instance['title'];
	$get_post_slug = isset( $instance['get_post_slug'] ) ? esc_attr( $instance['get_post_slug'] ) : '';
	$showcount = isset( $instance['showcount'] ) ? esc_attr( $instance['showcount'] ) : '';	
?>
  <p>
  <label for="<?php echo $this->get_field_id('title'); ?>">
	  Title: 
	  <input class="upcoming" id="<?php echo $this->get_field_id('title'); ?>" size="40" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
  </label>
  </p>
  <p>
  <label for="<?php echo $this->get_field_id('get_post_slug'); ?>">
	  Select Event:
	  <select id="<?php echo $this->get_field_id('get_post_slug'); ?>" name="<?php echo $this->get_field_name('get_post_slug'); ?>" style="width:225px">
      	<option value=""> Select Category</option>
		<?php
        global $wpdb,$post;
		$categories = get_categories('taxonomy=event-category&child_of=0&hide_empty=0'); 
			if($categories != ''){}
				foreach ( $categories as $category){ ?>
                    <option <?php if(esc_attr($get_post_slug) == $category->slug){echo 'selected';}?> value="<?php echo $category->slug;?>" >
	                    <?php echo substr($category->name, 0, 20);	if ( strlen($category->name) > 20 ) echo "...";?>
                    </option>						
			<?php }?>
      </select>
  </label>
  </p>  
  <p>
  <label for="<?php echo $this->get_field_id('showcount'); ?>">
	  Number of Events: 
	  <input class="upcoming" id="<?php echo $this->get_field_id('showcount'); ?>" size="2" name="<?php echo $this->get_field_name('showcount'); ?>" type="text" value="<?php echo esc_attr($showcount); ?>" />
  </label>
  </p>  
<?php
  }
 
  function update($new_instance, $old_instance)
  {
    $instance = $old_instance;
    $instance['title'] = $new_instance['title'];
	$instance['get_post_slug'] = $new_instance['get_post_slug'];	
	$instance['showcount'] = $new_instance['showcount'];		
    return $instance;
  }
 function widget($args, $instance)
	{
		extract($args, EXTR_SKIP);
		$title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
		$get_post_slug = isset( $instance['get_post_slug'] ) ? esc_attr( $instance['get_post_slug'] ) : '';
		$showcount = isset( $instance['showcount'] ) ? esc_attr( $instance['showcount'] ) : '';		
		if(empty($showcount)){$showcount = '4';}
		// WIDGET display CODE Start
		echo $before_widget;	
		wp_reset_query();	
		if (!empty($title) && $title <> ' '){
				echo $before_title . $title . $after_title;
			}
			global $cs_theme_option, $wpdb, $post;
 			//$term = get_term( $get_names_events, 'event-category' );
 			if($get_post_slug <> ''){
				$newterm = get_term_by('slug', $get_post_slug, 'event-category'); 
					$args = array(
						'posts_per_page'			=> $showcount,
						'post_type'					=> 'events',
						'event-category'			=> "$get_post_slug",
                        'post_status'				=> 'publish',
                        'meta_key'					=> 'cs_event_from_date',
                        'meta_value'				=> date('Y-m-d'),
                        'meta_compare'				=> ">=",
                        'orderby'					=> 'meta_value',
                        'order'						=> 'ASC'
 					);
                    $custom_query = new WP_Query($args);
					if ( $custom_query->have_posts() <> "" ) {
 						$counter_events = 0;
						$width = 228; 
						$height = 205;
						$days_to_go = "";
                        while ( $custom_query->have_posts() ): $custom_query->the_post();
							$counter_events++;
							$cs_event_from_date = get_post_meta($post->ID, "cs_event_from_date", true); 
							$year_event = date("Y", strtotime($cs_event_from_date));
							$month_event = date("M", strtotime($cs_event_from_date));
							$day_event = date("d", strtotime($cs_event_from_date));
							$cs_event_meta = get_post_meta($post->ID, "cs_event_meta", true);
							$image_url = cs_attachment_image_src( get_post_thumbnail_id($post->ID),$width,$height ); 
							if ( $cs_event_meta <> "" ) {
								$cs_event_meta = new SimpleXMLElement($cs_event_meta);
								$event_start_time = $cs_event_meta->event_start_time;
							}
							$cs_event_loc = get_post_meta($cs_event_meta->event_address, "cs_event_loc_meta", true);
							if ( $cs_event_loc <> "" ) {
								$xmlObject = new SimpleXMLElement($cs_event_loc);
								$loc_address = $xmlObject->loc_address;
							}else{
								$loc_address = '';
							}
 						?>
                         <!-- Events Widget Start -->
                         <article>
                            <?php if($counter_events==1 && $image_url <> '' ){?><figure><a href="<?php the_permalink();?>"><img src="<?php echo $image_url;?>" alt=""></a></figure><?php }?>
                            <div class="text">
                                <h2 class="cs-post-title cs-heading-color"><a href="<?php the_permalink();?>"><?php echo substr(get_the_title(), '0', '20');if(strlen(get_the_title())>20){ echo '...';} ?></a></h2>
                                <?php if($counter_events==1 && $image_url <> '' ){?>
                                <time datetime="<?php echo $days_to_go;?>">
									<?php 
                                        if(strtotime($cs_event_from_date) > strtotime(date('Y-m-d'))){
                                        	echo cs_dateDiff(date('Y-m-d'), $cs_event_from_date).' ';
											if($cs_theme_option['trans_switcher'] == "on"){ _e('Days to go','Soundblast');}else{ echo $days_to_go = $cs_theme_option['trans_event_days_to_go']; }
                                    	}
                                    ?>
                                </time>
                                <?php } else {?>
                                		<time datetime="<?php echo date('d.m.Y',strtotime($cs_event_from_date));?>"><?php echo date('F d, Y',strtotime($cs_event_from_date));?></time>
                                <?php }?>
                            </div>
                        </article>
                        <!-- Events Widget End -->		
 						<?php endwhile;?>
 					<?php }else{
							echo '<p>'.__( 'No results found.', 'Soundblast' ).'</p>';
						}
			}	// endif of Category Selection
			echo $after_widget;	// WIDGET display CODE End
		}
	}
add_action( 'widgets_init', create_function('', 'return register_widget("cs_upcoming_events");') );

/**
 * Archives widget class
 */
class chimp_Widget_Archives extends WP_Widget {

    function chimp_Widget_Archives() {
        $widget_ops = array('classname' => 'widget_archive', 'description' =>'A monthly archive Widget');
        $this->WP_Widget('chimp_archives', 'Archives', $widget_ops);
    }

    function widget($args, $instance) {
        global $wpdb, $wp_locale;
        $output = $selectbox = '';

        extract($args);
        $title = apply_filters('widget_title', empty($instance['title']) ? 'Archives' : $instance['title']);
        $count = $instance['count'];
        $dropdown = $instance['dropdown'];

        echo $before_widget;
        if (!empty($title) && $title <> ' '){
            echo $before_title . $title . $after_title;
		}
        $post_types = array('post', 'events' );

        // 
        $where = apply_filters('getarchives_where', "WHERE (post_type='post' || post_type='events' ) AND post_status = 'publish'", '');
        $join = apply_filters('getarchives_join', "", '');
        $query = "SELECT YEAR(post_date) AS `year`, MONTH(post_date) AS `month`, count(ID) as posts FROM $wpdb->posts $join $where GROUP BY YEAR(post_date), MONTH(post_date) ORDER BY post_date DESC";
        $key = md5($query);
        $cache = wp_cache_get('wp_get_archives', 'general');
        if (!isset($cache[$key])) {
            $arcresults = $wpdb->get_results($query);
            $cache[$key] = $arcresults;
            wp_cache_add('wp_get_archives', $cache, 'general');
        } else {
            $arcresults = $cache[$key];
        }
        if ($arcresults) {
            //$afterafter = $after;
            foreach ((array) $arcresults as $arcresult) {
                $url = get_month_link($arcresult->year, $arcresult->month);
                $text = sprintf(__('%1$s %2$d','Soundblast'), $wp_locale->get_month($arcresult->month), $arcresult->year);

                if (isset($count) && $count <> '')
                    $text .= '&nbsp;(' . $arcresult->posts . ')';


                $output .= get_archives_link($url, $text, '', '<li>', '</li>');
                if (isset($dropdown) && $dropdown <> '') {
                    $selectbox.='<option value="' . $url . '">' . $text . '</option>';
                }
            }
        }

        if (isset($dropdown) && $dropdown <> '') {
            ?>
            <ul>
            	<li>
                    <select name="archive-dropdown" onchange='document.location.href = this.options[this.selectedIndex].value;'>
                        <option value=""><?php echo _e('Select Month',"Soundblast"); ?></option>
                        <?php echo $selectbox; ?>
                    </select>
                 </li>
            </ul>
            <?php
        } else {
            echo '<ul>' . $output . '</ul>';
        }
        echo $after_widget;
    }

    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $new_instance = wp_parse_args((array) $new_instance, array('title' => '', 'count' => 0, 'dropdown' => ''));
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['count'] = $new_instance['count'] ? 1 : 0;
        $instance['dropdown'] = $new_instance['dropdown'] ? 1 : 0;

        return $instance;
    }

    function form($instance) {
        $instance = wp_parse_args((array) $instance, array('title' => '', 'count' => 0, 'dropdown' => ''));
        $title = strip_tags($instance['title']);
        $count = $instance['count'] ? 'checked="checked"' : '';
        $dropdown = $instance['dropdown'] ? 'checked="checked"' : '';
        ?>
        <p><label for="<?php echo $this->get_field_id('title'); ?>">Title:</label> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></p>
        <p>
            <input class="checkbox" type="checkbox" <?php echo $count; ?> id="<?php echo $this->get_field_id('count'); ?>" name="<?php echo $this->get_field_name('count'); ?>" /> <label for="<?php echo $this->get_field_id('count'); ?>">Show post counts</label>
            <br />
            <input class="checkbox" type="checkbox" <?php echo $dropdown; ?> id="<?php echo $this->get_field_id('dropdown'); ?>" name="<?php echo $this->get_field_name('dropdown'); ?>" /> <label for="<?php echo $this->get_field_id('dropdown'); ?>">Display as a drop down</label>
        </p>
        <?php
    }

} 
 ?>