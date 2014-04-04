<?php

// adding mce custom button for short codes start
class ShortcodesEditorSelector {

    var $buttonName = 'shortcode';

    function addSelector() {
        add_filter('mce_external_plugins', array($this, 'registerTmcePlugin'));
        add_filter('mce_buttons', array($this, 'registerButton'));
    }

    function registerButton($buttons) {
        array_push($buttons, "separator", $this->buttonName);
        return $buttons;
    }

    function registerTmcePlugin($plugin_array) {
        $plugin_array[$this->buttonName] = get_template_directory_uri() . '/include/mce_editor_plugin.js.php';
        //var_dump($plugin_array);
        return $plugin_array;
    }

}

if (!isset($shortcodesES)) {
    $shortcodesES = new ShortcodesEditorSelector();
    add_action('admin_head', array($shortcodesES, 'addSelector'));
}

// adding mce custom button for short codes end
//adding shortcode start 
// adding toggle start
function cs_shortcode_pb_toggle($atts, $content = "") {
    global $toggle_counter;
    $toggle_counter++;
	$active = "";
    if (!isset($atts['style'])){ $atts['style'] = '';}
    if (!isset($atts['title'])){ $atts['title'] = '';}
    if ( $atts["active"] == "yes" ){ 
		$active = "";
		$colapse = " in";
	}else{
		$active = " collapsed";
		$colapse = "";
	}
    $html = '<div class="panel-heading"><h4 class="panel-title"><a class="'.$active.'" data-toggle="collapse" data-target="#toggle' . $toggle_counter . '">' . $atts["title"] . '</a></h4></div>';
    $html .= '<div class="togglebox '.$colapse.' collapse" id="toggle' . $toggle_counter . '">' . $content . '</div>';
    $html = '<div class="panel panel-default toggle-sectn fullwidth">' . $html . '</div>';
    return do_shortcode($html) . '<div class="clear"></div>';
}

add_shortcode('toggle', 'cs_shortcode_pb_toggle');

// adding toggle end
// adding tabs start
function cs_shortcode_pb_tabs($atts, $content = "") {
    global $cs_node, $tab_counter;
    $tab_counter++;
    $content = str_replace("&Acirc;&nbsp;", "", htmlentities($content));
	$content = html_entity_decode($content);
	$content = htmlspecialchars($content, ENT_NOQUOTES, "UTF-8");
    $content = str_replace("[tab_item", "<tab_item", $content);
    $content = str_replace("[/tab_item]", "</tab_item>", $content);
    $content = str_replace('tabs="tabs"]', ">", $content);
    $content = str_replace("<br />", "", $content);
    $content = str_replace("<p>", "", $content);
    $content = str_replace("</p>", "", $content);
    $content = "<tab>" . $content . "</tab>";
	if (!isset($atts['style']) || $atts['style'] == ''){ echo $atts['style'] = 'horizontal';}

	$cs_node = new stdClass();
	$cs_node->tabs_element_size = "";
	$cs_node->tabs_content = $content;
	$cs_node->sytle = $atts['style'];
    return cs_tabs_page();
}
add_shortcode('tab', 'cs_shortcode_pb_tabs');

// adding tabs end
// adding accordion start
function cs_shortcode_pb_accordion($atts, $content = "") {
    global $cs_node, $acc_counter;
    $content = str_replace("&Acirc;&nbsp;", "", htmlentities($content));
	$content = html_entity_decode($content);
	$content = htmlspecialchars($content, ENT_NOQUOTES, "UTF-8");
    $content = str_replace("[accordion_item", "<accordion_item", $content);
    $content = str_replace("[/accordion_item]", "</accordion_item>", $content);
    $content = str_replace('accordion="accordion"]', ">", $content);
    $content = str_replace("<br />", "", $content);
    $content = str_replace("<p>", "", $content);
    $content = str_replace("</p>", "", $content);
    $content = "<accordion>" . $content . "</accordion>";

	$cs_node = new stdClass();
	$cs_node->accordion_element_size = "";
	$cs_node->accordion_content = $content;
    return cs_accordions_page();
}
add_shortcode('accordion', 'cs_shortcode_pb_accordion');

// adding accordion end

// adding quote start
function cs_shortcode_pb_quote($atts, $content = "") {
	global $cs_node;
	if (!isset($atts['color'])){ $atts['color'] = '';}
	if (!isset($atts['align'])){ $atts['align'] = '';}
	$cs_node = new stdClass();
	$cs_node->quote_element_size = '';
	$cs_node->quote_text_color = $atts['color'];
	$cs_node->quote_align = $atts['align'];
	$cs_node->quote_content = $content;
    return cs_quote_page();
}

add_shortcode('quote', 'cs_shortcode_pb_quote');

// adding quote end
// adding button start
function cs_shortcode_pb_button($atts, $content = "") {
    if (!isset($atts['src'])){ $atts['src'] = '';}
    if (!isset($atts['color'])){ $atts['color'] = '';}
    if (!isset($atts['background'])){  $atts['background'] = '';}
    if (!isset($atts['style'])){  $atts['style'] = '';}
    if (!isset($atts['type'])){  $atts['type'] = '';}
    if (!isset($atts['target'])){  $atts['target'] = '';}else{ $atts['target'] = '_self'; }
    
    $html = '<a href="' . $atts['src'] . '" class="' . $atts['style']. '-btn ' . $atts['type'] . '" target="' . $atts['target'] . '" style=" cursor:pointer; color:' . $atts['color'] . ' ;background-color:' . $atts['background'] . '">' . $content . '</a>';
    $html = '<div class="button">'.$html.'</div>';
    return do_shortcode($html);
}

add_shortcode('button', 'cs_shortcode_pb_button');

// adding button end
// adding column start
function cs_shortcode_pb_column($atts, $content = "") {
    if (!isset($atts['size'])){ $atts['size'] = '';}
    list($top, $bottom) = explode('/', $atts['size']);
    $width = $top / $bottom * 100;
    $html = '<div class="shortgrid fullwidth" style="width:' . $width . '%">'.$content.'</div>';
    return do_shortcode(htmlspecialchars_decode($html));
}

add_shortcode('column', 'cs_shortcode_pb_column');

// adding column end
// adding dropcap start
function cs_shortcode_pb_dropcap($atts, $content = "") {
	if (!isset($atts['style'])){ $atts['style'] = '';}
	global $cs_node;
	$cs_node = new stdClass();
	$cs_node->dropcap_element_size = '';
	$cs_node->dropcap_style = $atts["style"];
	$cs_node->dropcap_content = $content;
    return cs_dropcap_page();
}

add_shortcode('dropcap', 'cs_shortcode_pb_dropcap');

// adding dropcap end
// adding message_box start
function cs_shortcode_pb_message_box($atts, $content = "") {
	if (!isset($atts['style'])){ $atts['style'] = '';}
    if (!isset($atts['background'])){ $atts['background'] = '';}
    if (!isset($atts['color'])){ $atts['color'] = '';}
    if (!isset($atts['border_color'])){ $atts['border_color'] = '';}
	if (!isset($atts['box_shadow_color'])){ $atts['box_shadow_color'] = '';}
    if (!isset($atts['title'])){ $atts['title'] = '';}
    if (!isset($atts['align'])){ $atts['align'] = '';}
    if (!isset($atts['icon'])){ $atts['icon'] = '';}
    if (!isset($atts['close'])){ $atts['close'] = '';}
	$shadow_value = "";
	if(isset($atts['box_shadow_color']) and $atts['box_shadow_color'] <> ""){
		$shadow_value = "0px 0px 0px 5px " . $atts['box_shadow_color'] . " inset";
	}
    $html = "";
	$class = "";
	$round_class = "";
    $html .= '<div class="messagebox alert alert-info" style="text-align:' . $atts["align"] . '; background:' . $atts["background"] . '; color:' . $atts["color"] . '; border:1px solid ' . $atts["border_color"] . '; box-shadow:'.$shadow_value.';">';
    if (isset($atts['close']) && $atts['close']=='yes'){
        $html .= '<button type="button" class="close" data-dismiss="alert"><em class="fa fa-times-circle"></em></button>';
    }
	if (isset($atts['icon']) and $atts['icon'] <> ""){
		if(isset($atts['style']) and $atts['style'] <> "2"){
			$class = " round_smal";
		}else{
			$class = "";
		}
		if(isset($atts['style']) and $atts['style'] <> "3"){
			$round_class = " round";
		}else{
			$round_class = "";
		}
		$html .= '<em class="fa ' . $atts["icon"] . $round_class . $class . '"></em>';
	}
    if(isset($atts["title"]) && $atts["title"]<>''){
         $html .= '<div class="massegbox_text"><h4 class="colr">' . $atts["title"] . '</h4></div>';
    }
    if(isset($content) && $content<>''){
        $html .= $content;
    }
        $html .= '</div>';
    return do_shortcode($html) . '<div class="clear"></div>';
}

add_shortcode('message_box', 'cs_shortcode_pb_message_box');

// adding message_box end

// adding table start
function cs_shortcode_pb_table($atts, $content = "") {
    if (!isset($atts['color'])){ $atts['color'] = '';}
    $table_class = "table_" . str_replace("#", "", $atts["color"]);
    $content = "<table class='table table-condensed " . $table_class . "'>" . $content . "</table>";
    $content = str_replace("[thead]", "<thead>", $content);
    $content = str_replace("[/thead]", "</thead>", $content);
    $content = str_replace("[tr]", "<tr>", $content);
    $content = str_replace("[/tr]", "</tr>", $content);
    $content = str_replace("[th]", "<th>", $content);
    $content = str_replace("[/th]", "</th>", $content);
    $content = str_replace("[tbody]", "<tbody>", $content);
    $content = str_replace("[/tbody]", "</tbody>", $content);
    $content = str_replace("[td]", "<td>", $content);
    $content = str_replace("[/td]", "</td>", $content);
    $content = str_replace("<br />", "", $content);
    //$content = do_shortcode(htmlspecialchars_decode($content));
    $html = '
			<style>
			.' . $table_class . ' {border:1px solid ' . $atts["color"] . ';}
			.' . $table_class . ' td {border-top: 1px solid ' . $atts["color"] . '; border-left: 1px solid ' . $atts["color"] . ';}
			.' . $table_class . ' tr {border-bottom: 1px solid ' . $atts["color"] . '; border-left: 1px solid ' . $atts["color"] . ';}
			.' . $table_class . ' thead {background:' . $atts["color"] . ';}
			</style>
		';
    $html .= '<div class="tables-code">' . $content . '</div>';
    return do_shortcode(htmlspecialchars_decode($html)) . '<div class="clear"></div>';
}
add_shortcode('table', 'cs_shortcode_pb_table');

// adding table end

// adding icon start
function cs_shortcode_pb_icon($atts, $content = "") {
        if (!isset($atts['border'])){ $atts['border'] = '';}
        if (!isset($atts['color'])){ $atts['color'] = '';}
        if (!isset($atts['bgcolor'])){ $atts['bgcolor'] = '';}
        if (!isset($atts['type'])){ $atts['type'] = '';}
        if (!isset($atts['class'])){ $atts['class'] = '';}
	$icon_border = "";
        if ( $atts["border"] == "yes" ){ $icon_border = "icon-border";}
	$html = '<em class="fa '.$atts["class"].' '.$atts["type"].' '.$atts["size"].' '.$icon_border.'" style="color:'.$atts["color"].'; background-color:'.$atts["bgcolor"].'"></em>';
	return $html;
}
add_shortcode('icon', 'cs_shortcode_pb_icon');
// adding icon end

// adding heading start
function cs_shortcode_pb_heading($atts, $content = "") {
        if (!isset($atts['size'])){ $atts['size'] = '';}
        if (!isset($atts['color'])){ $atts['color'] = '';}
	$html = '<h'.$atts["size"].' style="color:'.$atts["color"].';">'.$content.'</h'.$atts["size"].'>';
	return $html;
}
add_shortcode('heading', 'cs_shortcode_pb_heading');
// adding heading end

// adding Contact Social icons start
function cs_shortcode_pb_contact($atts, $content = "") {
	if (!isset($atts["title"])){ $atts["title"] = '';}
	if (!isset($atts["icon"])){ $atts["icon"] = 'fa-star';}
	if (!isset($atts["desc"])){ $atts["desc"] = '';}
	if (!isset($atts["link"])){ $atts["link"] = '';}
	if (!isset($atts["target"])){ $atts["target"] = '';}
	$html = '<div class="sociol-icons ">
                	<ul>
                    	<li>
                        	<div class="icon-detail">
                            	<i class="fa '.$atts["icon"].' fa-3x"></i>
                                <div class="text-icon">
                                	<a href="'.$atts["link"].'" target="'.$atts["target"].'">'.$atts["title"].'</a>
                                    <p>'.$atts["desc"].'</p>
                                </div>
                            </div>
                        </li>
                      </ul>
                  </div>';
    return $html;
}
add_shortcode('contact', 'cs_shortcode_pb_contact');
// adding code end

// adding video start
function cs_shortcode_pb_video($atts, $content = "") {
	global $cs_node;
	if (!isset($atts['url'])){ $atts['url'] = '';}
	if (!isset($atts['width'])){ $atts['width'] = '';}
	if (!isset($atts['height'])){ $atts['height'] = '';}
	$cs_node = new stdClass();
	$cs_node->video_element_size= '';
	$cs_node->video_url = $atts['url'];
	$cs_node->video_width = $atts['width'];
	$cs_node->video_height = $atts['height'];
    return cs_video_page();
}
add_shortcode('video-item', 'cs_shortcode_pb_video');
// adding video end
// adding map shortcode
function cs_shortcode_pb_map($atts, $content = "") {
	global $cs_node, $counter_node;
	$counter_node++;
	
	if ( !isset($atts['height']) ) $atts['height'] = '';
	if ( !isset($atts['latitude']) ) $atts['latitude'] = '';
	if ( !isset($atts['longitude']) ) $atts['longitude'] = '';
	if ( !isset($atts['zoom']) ) $atts['zoom'] = '';
	if ( !isset($atts['type']) ) $atts['type'] = '';
	if ( !isset($atts['info_text']) ) $atts['info_text'] = '';
	if ( !isset($atts['info_width']) ) $atts['info_width'] = '';
	if ( !isset($atts['info_height']) ) $atts['info_height'] = '';
	if ( !isset($atts['marker_icon_url']) ) $atts['marker_icon_url'] = '';
	if ( !isset($atts['marker']) ) $atts['marker'] = '';
	if ( !isset($atts['draggable']) ) $atts['draggable'] = '';
	if ( !isset($atts['disable_controls']) ) $atts['disable_controls'] = '';
	if ( !isset($atts['scrollwheel']) ) $atts['scrollwheel'] = '';
	if ( !isset($atts['map_view']) ) $atts['map_view'] = 'content';
	
	$cs_node = new stdClass();
	$cs_node->map_title = '';
	$cs_node->map_element_size = '';
	$cs_node->map_height = $atts['height'];
	$cs_node->map_lat = $atts['latitude'];
	$cs_node->map_lon = $atts['longitude'];
	$cs_node->map_zoom = $atts['zoom'];
	$cs_node->map_type = $atts['type'];
	$cs_node->map_info = $atts['info_text'];
	$cs_node->map_info_width = $atts['info_width'];
	$cs_node->map_info_height = $atts['info_height'];
	$cs_node->map_marker_icon = $atts['marker_icon_url'];
	$cs_node->map_show_marker = $atts['marker'];
	$cs_node->map_draggable = $atts['draggable'];
	$cs_node->map_controls = $atts['disable_controls'];
	$cs_node->map_scrollwheel = $atts['scrollwheel'];
	$cs_node->map_view = $atts['map_view'];
	return cs_map_page();
}
add_shortcode('map', 'cs_shortcode_pb_map');
// adding map end

//Testimonials Shortcode
function cs_shortcode_pb_testimonials($atts, $content = "") {
    global $testimonial_counter;
    $testimonial_counter++;
    if (!isset($atts['type'])){ $atts['type'] = '';}
    $content = str_replace("&Acirc;&nbsp;", "", htmlentities($content));
	$content = html_entity_decode($content);
	$content = htmlspecialchars($content, ENT_NOQUOTES, "UTF-8");
    $content = str_replace("[testimonial_item", "<testimonial_item", $content);
    $content = str_replace("[/testimonial_item]", "</testimonial_item>", $content);
    $content = str_replace('testimonial="testimonial"]', ">", $content);
    $content = str_replace("<br />", "", $content);
    $content = str_replace("<p>", "", $content);
    $content = str_replace("</p>", "", $content);
    $content = "<testimonials>" . $content . "</testimonials>";
    $show_class='';
	$att_style = "";
	$no_image = '';
	if (!isset($atts["type"])){ $atts["type"] = '';}
	else{
		$att_style = $atts["type"];
		switch ($att_style)
		{
		case "v1":
		  $show_class = "testimonial-v1";
		  break;
		case "v2":
		  $show_class = "testimonial-v2";
		  break;
		case "v3":
		  $show_class = "testimonial-v5";
		  break;
		default:
		  $show_class = "testimonial-v1";
		}
	}
    $html = '';
    $cs_xmlObject = simplexml_load_string($content);
    $testimonial_count = 0;

    foreach ($cs_xmlObject as $cs_node) {
        $testimonial_count++;
       if (!isset($cs_node["image"])){ $cs_node["image"] = '';}
       if (!isset($cs_node["name"])){ $cs_node["name"] = '';}
       if (!isset($cs_node["job"])){ $cs_node["job"] = '';}
	   
	   if(isset($cs_node["image"]) && $cs_node["image"]==''){
		   $no_image = " no-image";
	   }
	   
       		$html .= '<article class="viewme '.$show_class.$no_image.'">';
			
			if($atts["type"] == 'v1' || $atts["type"] == 'v2' || $atts["type"] == 'v3'){
				if($atts["type"] == 'v3'){
					$html .= '<span class="fa-stack fa-lg">
								  <i class="fa fa-circle fa-stack-2x"></i>
								  <i class="fa fa-quote-left fa-stack-1x fa-inverse"></i>
							  </span>';
				}
				
				if(isset($cs_node["image"]) && $cs_node["image"]<>'' && ($atts["type"] == 'v2')){
					$html .= '<figure class="viewme">';
					$html .= '<img src="' . $cs_node["image"]  . '" alt="' . $cs_node["name"]  . '"><figcaption>
							   <span class="fa-stack fa-lg">
								  <i class="fa fa-circle fa-stack-2x"></i>
								  <i class="fa  fa-comment fa-stack-1x fa-inverse"></i>
							   </span>
							</figcaption>'; 
					$html .= '</figure>';
				} else if($atts["type"] == 'v1') {
					$html .= '<span class="fa-stack fa-lg">
								  <i class="fa fa-circle fa-stack-2x"></i>
								  <i class="fa fa-quote-left fa-stack-1x fa-inverse"></i>
							 </span>';
				}
				$html .= '<div class="text"><div class="testimonial-box"><blockquote>'.html_entity_decode($cs_node).'</blockquote></div><div class="clear"></div>';
				
				if(isset($cs_node["image"]) && $cs_node["image"]<>'' && ($atts["type"] == 'v3')){
				$html .= '<figure>
							 <img alt="" src="' . $cs_node["image"]  . '" width="57" height="57">
						  </figure>';
				}
				if($atts["type"] == 'v1' || $atts["type"] == 'v2'){
					$html .= '<div class="btmtestimonial bdrcolrse">';
				}
						$html .= '<p class="author-name"><strong class="colr">'.$cs_node["name"].'</strong>';
						if($atts["type"] == 'v3'){
							$html .= '<br/>';
						}
						$html .= $cs_node["job"].'</p>';
						
				if($atts["type"] == 'v1' || $atts["type"] == 'v2'){
					$html .= '</div>';
				}
			} 
			$html .= '</div></article>';
			
		
		
    }
    $html =  '<div class="testimonial-shortcode">'.$html.'</div>' ;
    return do_shortcode($html) . '<div class="clear"></div>';
}
add_shortcode('testimonials', 'cs_shortcode_pb_testimonials');
//Testimonials Shortcode end

//Team Shortcode
function cs_shortcode_pb_team($atts, $content = "") {
    $content = str_replace(']', ">", $content);
    $content = str_replace("[team", "<team", $content);
    $content = str_replace("[/team", "</team", $content);
    $content = str_replace("[content", "<content", $content);
    $content = str_replace("[/content", "</content", $content);
    $content = str_replace("[social_links", "<social_links", $content);
    $content = str_replace("[/social_links", "</social_links", $content);
    $content = str_replace('tabs="tabs"', "></social", $content);
    $content = str_replace("[social", "<social", $content);
    $content = str_replace("<br />", "", $content);
    $content = str_replace('&nbsp;=""', "", $content);
    $content = str_replace("<p>", "", $content);
    $content = str_replace("</p>", "", $content);
    $content = "<team-sec>" . $content . "</team-sec>";
    $html = "";
	$style = "";
	$width = "";
	if (!isset($atts["style"])){ $atts["style"] = '';}
	else{
		$att_style = $atts["style"];
		switch ($att_style)
		{
		case "team-v1":
		  $style = "team-v1";
		  break;
		case "team-v2":
		  $style = "team-v2";
		  break;
		default:
		  $style = "team-v2";
		}
	}
    $cs_xmlObject = simplexml_load_string($content);
    $team_count = 0;
    $cs_node["image"]='';
	$bg_colr = "";
	
	if($style == "team-v1"){
	cs_cycleslider_script();
	$html .= '<div class="center">
				<a id="prev" href="#" class="prev-btn"><i class="fa fa-angle-left fa-1x"></i></a>
				<a id="next" href="#" class="next-btn"><i class="fa fa-angle-right fa-1x"></i></a>
			</div>
        <div class="cycle-slideshow"
        data-cycle-timeout=40000
        data-cycle-fx=carousel
        data-cycle-slides="article"
        data-cycle-carousel-fluid="false"
        data-allow-wrap="true"
            data-cycle-next="#next"
            data-cycle-prev="#prev">';
	}
			
    foreach ($cs_xmlObject as $cs_node) {
        if (!isset($cs_node["name"])){ $cs_node["name"] = '';}
        if (!isset($cs_node["image"])){ $cs_node["image"] = '';}
        if (!isset($cs_node["job"])){ $cs_node["job"] = '';}
        $html .= '<article class="'.$style.'">';
		$html .= '<figure>';
		if (isset($cs_node["image"]) and $cs_node["image"] <> ""){
		$html .= '<img width="261" src="'.$cs_node["image"].'" alt="">';
		}
		
		
		$html .= '<figcaption>';
			 $html .= '<h2 class="cs-post-title">'.$cs_node["name"].'</h2>';
			  $html .= '<div class="cs-lead-sec">
						 <p>
							 <a>'.$cs_node["job"].'</a>
							</p>
							<i class="fa fa-plus"></i>
						</div>';
			  if(isset($cs_node->content) && $cs_node->content <> ''){
				  $html .= '<p>'.$cs_node->content.'</p>';
			  }
			  
			  $html .= '</figcaption>';
			  $html .= '<div class="social-network">';
				foreach ($cs_node as $cs_node1) {
					foreach ($cs_node1 as $cs_node2) {
						if (!isset($cs_node2["link"])){ $cs_node2["link"] = '';}
						if (!isset($cs_node2["icon"])){ $cs_node2["icon"] = '';}
						$html .= '<a href="'.$cs_node2["link"].'" target="'.$cs_node2["link"].'"><em class="fa '.$cs_node2["icon"].'"></em></a>';
					}
				}
				$html .= '</div>';
		
		
		
        $html .= '</figure></article>';
    }
	if($style == "team-v1"){
	$html .= '</div>';
	}
	
    $html = '<div class="meet-artist">' . $html . '</div>';
    return do_shortcode($html) . '<div class="clear"></div>';
}
add_shortcode('team-sec', 'cs_shortcode_pb_team');
//Team Shortcode end

//Services Shortcode
function cs_shortcode_pb_services($atts, $content = "") {
    $content = str_replace(']', ">", $content);
    $content = str_replace("[service-item", "<service-item", $content);
    $content = str_replace("[/service-item", "</service-item", $content);
    $content = str_replace("[content", "<content", $content);
    $content = str_replace("[/content", "</content", $content);
    $content = str_replace("<br />", "", $content);
    $content = str_replace('&nbsp;=""', "", $content);
    $content = str_replace("<p>", "", $content);
    $content = str_replace("</p>", "", $content);
    $content = "<services>" . $content . "</services>";
    
	$html = "";
    $cs_xmlObject = simplexml_load_string($content);
    $services_count = 0;

    foreach ($cs_xmlObject as $cs_node) {
		$services_count++;
        if (!isset($cs_node["icon"])){ $cs_node["icon"] = '';}
        if (!isset($cs_node["title"])){ $cs_node["title"] = '';}
        if (!isset($cs_node["link"])){ $cs_node["link"] = '#';}
		
		$item_f_class = "";
		if($services_count == 4){
			$item_f_class = " listitem4";
		}
        
		$html .= '<article class="service-v1'.$item_f_class.'">';
			if($cs_node["icon"] <> ""){
				$html .= '<div class="service-icon hex"><span><i class="fa '.$cs_node["icon"].'"></i></span><div class="corner-1"></div><div class="corner-2"></div></div><div class="clear"></div>';
			}
			if($cs_node["title"] <> ""){
				$html .= '<h2><a href="'.$cs_node["link"].'">'.$cs_node["title"].'</a></h2>';
			}
			$html .= '<p>' . $cs_node->content . '</p>';
		$html .= '</article>';
    }
    $html = '<div class="services">' . $html . '</div>';

    return do_shortcode($html) . '<div class="clear"></div>';
	
}
add_shortcode('services', 'cs_shortcode_pb_services');
//Services Shortcode end


?>