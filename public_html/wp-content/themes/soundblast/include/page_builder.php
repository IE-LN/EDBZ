<?php
global $cs_theme_option;
add_action( 'add_meta_boxes', 'cs_page_bulider_add' );
function cs_page_bulider_add() {
	add_meta_box( 'id_page_builder', 'Page Options', 'cs_page_bulider', 'page', 'normal', 'high' );  
}  
function cs_page_bulider( $post ) {
?>
    <div class="page-wrap page-opts" style="overflow:hidden; position:relative; height: 705px;">
        <div class="page-builder">
            <div class="page-head">
                <h5>Layout Sections</h5>
                <div class="add-widget">
                    <span class="addwidget">+ Add Page Elements</span>
                    <div class="widgets-list">
                        <a href="javascript:ajaxSubmit('cs_pb_album')">Album</a>
                        <a href="javascript:ajaxSubmit('cs_pb_blog')">Blog</a>
                        <a href="javascript:ajaxSubmit('cs_pb_column')">Column</a>
                        <a href="javascript:ajaxSubmit('cs_pb_contact')">Contact</a>
                        <a href="javascript:ajaxSubmit('cs_pb_event')">Events</a>
                        <a href="javascript:ajaxSubmit('cs_pb_gallery')">Gallery</a>
                        <a href="javascript:ajaxSubmit('cs_pb_gallery_albums')">Gallery Album</a>
                        <a href="javascript:ajaxSubmit('cs_pb_map')">Map</a>
                        <a href="javascript:ajaxSubmit('cs_pb_slider')">Slider</a>
                        <a href="javascript:ajaxSubmit('cs_pb_team')">Team</a>
                     </div>
                </div>
            </div>
        </div>
        <div class="clear"></div>
        <div id="add_page_builder_item">
            <?php
				global $cs_node, $count_node, $cs_xmlObject,$cs_theme_option;
                $count_node = 0;
				$count_widget = 0;
				$page_title = '';
				$page_content = '';
				$header_banner_options = '';
				$header_banner = '';
				$slider_id = '';
				$header_styles = '';
                $cs_page_bulider = get_post_meta($post->ID, "cs_page_builder", true);
				if ( $cs_page_bulider <> "" ) {
                   	$cs_xmlObject = new stdClass();
					$cs_xmlObject = new SimpleXMLElement($cs_page_bulider);
						$count_widget = count($cs_xmlObject->children())-9;
                        foreach ( $cs_xmlObject->children() as $cs_node ){
							if ( $cs_node->getName() == "gallery_albums" ) { cs_pb_gallery_albums(1); }
							else if ( $cs_node->getName() == "gallery" ) { cs_pb_gallery(1); }
							else if ( $cs_node->getName() == "album" ) { cs_pb_album(1); }
							else if ( $cs_node->getName() == "slider" ) { cs_pb_slider(1); }
							else if ( $cs_node->getName() == "blog" ) { cs_pb_blog(1); }
 							else if ( $cs_node->getName() == "event" ) { cs_pb_event(1); }
 							else if ( $cs_node->getName() == "contact" ) { cs_pb_contact(1); }
							else if ( $cs_node->getName() == "column" ) { cs_pb_column(1); }
							else if ( $cs_node->getName() == "divider" ) { cs_pb_divider(1); }
 							else if ( $cs_node->getName() == "image" ) { cs_pb_image(1); }
							else if ( $cs_node->getName() == "map" ) { cs_pb_map(1); }
							else if ( $cs_node->getName() == "video" ) { cs_pb_video(1); }
							else if ( $cs_node->getName() == "quote" ) { cs_pb_quote(1); }
							else if ( $cs_node->getName() == "dropcap" ) { cs_pb_dropcap(1); }
							else if ( $cs_node->getName() == "pricetable" ) { cs_pb_pricetable(1); }
							else if ( $cs_node->getName() == "tabs" ) { cs_pb_tabs(1); }
							else if ( $cs_node->getName() == "accordions" ) { cs_pb_accordion(1); }
							else if ( $cs_node->getName() == "parallax" ) { cs_pb_parallax(1); }
							else if ( $cs_node->getName() == "team" ) { cs_pb_team(1); }
                         }
                }
 				if ( $cs_page_bulider <> "" ) {
					if ( isset($cs_xmlObject->page_title) ) $page_title = $cs_xmlObject->page_title;
					if ( isset($cs_xmlObject->page_content) ) $page_content = $cs_xmlObject->page_content;
					if ( isset($cs_xmlObject->page_headline_text) ){ $page_headline_text = $cs_xmlObject->page_headline_text;} else { $page_headline_text = '';}
  				}else{
					//$header_styles = $cs_theme_option['default_header'];	
				}
			?>
            <div id="no_widget" class="placehoder">Page Builder in Empty, Please Select Page Element. <img src="<?php echo get_template_directory_uri()?>/images/admin/bg-arrowup.png" alt="" /></div>
        </div>
		<div id="loading" class="builderload"></div>
         <div class="clear"></div>
           <script type="text/javascript" src="<?php echo get_template_directory_uri()?>/scripts/admin/prettyCheckable.js"></script>
            <div class="elementhidden">
                <ul class="form-elements">
                    <li class="to-label"><label>Show Page Title</label></li>
                    <li class="to-field">
                        <select name="page_title" class="dropdown">
                            <option value="Yes" <?php if($page_title=="Yes")echo "selected";?> >Yes</option>
                            <option value="No" <?php if($page_title=="No")echo "selected";?> >No</option>
                        </select>
                        <p>Show the title of the page.</p>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Page Headline Text</label></li>
                    <li class="to-field">
                    	<input type="text" name="page_headline_text" value="<?php echo $page_headline_text;?>" />
                        <p>Enter Page Headline text.</p>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Show Page Description</label></li>
                    <li class="to-field">
                        <select name="page_content" class="dropdown">
                            <option value="Yes" <?php if($page_content=="Yes")echo "selected";?> >Yes</option>
                            <option value="No" <?php if($page_content=="No")echo "selected";?> >No</option>
                        </select>
                        <p>Show the description of the page.</p>
                    </li>
                </ul>
            </div>
		<?php cs_meta_layout() ?>
        <input type="hidden" name="page_builder_form" value="1" />
        <div class="clear"></div>
    </div>
<div class="clear"></div>
	
    <script type="text/javascript" src="<?php echo get_template_directory_uri()?>/scripts/admin/jquery.scrollTo-min.js"></script>
    <script>
		jQuery(function() {
			jQuery( "#add_page_builder_item" ).sortable({
				cancel : 'div div.poped-up'
			});
			//jQuery( "#add_page_builder_item" ).disableSelection();
		});
    </script>
	<script type="text/javascript">
		var count_widget = <?php echo $count_widget ; ?>;
        function ajaxSubmit(action){
 			counter++;
			count_widget++;
            var newCustomerForm = "action=" + action + '&counter=' + counter;
            jQuery.ajax({
                type:"POST",
                url: "<?php echo home_url()?>/wp-admin/admin-ajax.php",
                data: newCustomerForm,
                success:function(data){
                    jQuery("#add_page_builder_item").append(data);
					if (count_widget > 0) jQuery("#add_page_builder_item").addClass('hasclass');
					//alert(count_widget);
                }
            });
            //return false;
        }
    </script>

<?php  
}
	if ( isset($_POST['page_builder_form']) and $_POST['page_builder_form'] == 1 ) {
		add_action( 'save_post', 'save_page_builder' );
		function save_page_builder( $cs_post_id ) {
			if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
				if ( isset($_POST['cs_orderby']) ) {
					//creating xml page builder start
					$sxe = new SimpleXMLElement("<pagebuilder></pagebuilder>");
						$sxe->addChild('page_title', $_POST['page_title']);
						$sxe->addChild('page_headline_text', $_POST['page_headline_text']);
						$sxe->addChild('page_content', $_POST['page_content']);
						$sxe->addChild('header_styles', $_POST['header_styles']);
						$sxe = save_layout_xml($sxe);
							if ( isset($_POST['cs_orderby']) ) {
								$counter = 0;
								$counter_gal = 0;
								$counter_gal_album = 0;
								$counter_parallax = 0;
								$counter_port = 0;
								$counter_event = 0;
								$counter_slider = 0;
								$counter_blog = 0;
								$counter_news = 0;
								$counter_contact = 0;
								$counter_testimonial = 0;
								$counter_client = 0;
 								$counter_column = 0;
								$counter_divider = 0;
								$counter_mb = 0;
								$counter_image = 0;
								$counter_map = 0;
								$counter_video = 0;
								$counter_quote = 0;
								$counter_dropcap = 0;
								$counter_pricetable = 0;
								$counter_services_node = 0;
								$counter_tabs = 0;
								$counter_tabs_node = 0;
								$counter_accordion = 0;
								$counter_accordion_node = 0;
								$counter_testimonial = 0;
								$counter_testimonial_node = 0;
								$counter_team = 0;
								$counter_team_node = 0;
								$counter_album = 0;
 								foreach ( $_POST['cs_orderby'] as $count ){
									if ( $_POST['cs_orderby'][$counter] == "gallery" ) {
										$gallery = $sxe->addChild('gallery');
											$gallery->addChild('header_title', $_POST['cs_gal_header_title'][$counter_gal] );
											$gallery->addChild('layout', $_POST['cs_gal_layout'][$counter_gal] );
											$gallery->addChild('album', $_POST['cs_gal_album'][$counter_gal] );
											//$gallery->addChild('desc', $_POST['cs_gal_desc'][$counter_gal] );
											$gallery->addChild('pagination', $_POST['cs_gal_pagination'][$counter_gal] );
											$gallery->addChild('media_per_page', $_POST['cs_gal_media_per_page'][$counter_gal] );
											$gallery->addChild('gallery_element_size', $_POST['gallery_element_size'][$counter_gal] );
										$counter_gal++;
									}
									else if ( $_POST['cs_orderby'][$counter] == "gallery_albums" ) {
										$gallery = $sxe->addChild('gallery_albums');
											$gallery->addChild('cs_gal_album_header_title', $_POST['cs_gal_album_header_title'][$counter_gal_album] );
											$gallery->addChild('cs_gal_album_view_title', $_POST['cs_gal_album_view_title'][$counter_gal_album] );
											$gallery->addChild('cs_gal_album_view_url', $_POST['cs_gal_album_view_url'][$counter_gal_album] );
											$gallery->addChild('cs_gal_album', $_POST['cs_gal_album'][$counter_gal_album] );
											$gallery->addChild('cs_gal_album_pagination', $_POST['cs_gal_album_pagination'][$counter_gal_album] );
											$gallery->addChild('cs_gal_album_media_per_page', $_POST['cs_gal_album_media_per_page'][$counter_gal_album] );
											$gallery->addChild('cs_gallery_album_element_size', $_POST['cs_gallery_album_element_size'][$counter_gal_album] );
										$counter_gal_album++;
									}
 									else if ( $_POST['cs_orderby'][$counter] == "album" ) {
										$album = $sxe->addChild('album');
											$album->addChild('cs_album_title', htmlspecialchars($_POST['cs_album_title'][$counter_album]) );
											$album->addChild('cs_album_cat', $_POST['cs_album_cat'][$counter_album] );
											$album->addChild('cs_album_view', $_POST['cs_album_view'][$counter_album] );
											$album->addChild('cs_album_filterable', $_POST['cs_album_filterable'][$counter_album] );
											$album->addChild('cs_album_cat_show', $_POST['cs_album_cat_show'][$counter_album] );
											$album->addChild('cs_album_buynow', $_POST['cs_album_buynow'][$counter_album] );
 											$album->addChild('cs_album_pagination', $_POST['cs_album_pagination'][$counter_album] );
 											$album->addChild('cs_album_per_page', $_POST['cs_album_per_page'][$counter_album] );
											$album->addChild('album_element_size', $_POST['album_element_size'][$counter_album] );
										$counter_album++;
									}
									else if ( $_POST['cs_orderby'][$counter] == "slider" ) {
										$slider = $sxe->addChild('slider');
											$slider->addChild('slider_header_title', $_POST['cs_slider_header_title'][$counter_slider] );
											//$slider->addChild('slider_type', $_POST['cs_slider_type'][$counter_slider] );
											$slider->addChild('slider', $_POST['cs_slider'][$counter_slider] );
											$slider->addChild('slider_view', $_POST['slider_view'][$counter_slider] );
											$slider->addChild('slider_id', htmlspecialchars($_POST['cs_slider_id'][$counter_slider]) );
											//$slider->addChild('width', $_POST['cs_slider_width'][$counter_slider] );
											//$slider->addChild('height', $_POST['cs_slider_height'][$counter_slider] );
											$slider->addChild('slider_element_size', $_POST['slider_element_size'][$counter_slider] );
										$counter_slider++;
									}
									else if ( $_POST['cs_orderby'][$counter] == "blog" ) {
										$blog = $sxe->addChild('blog');
											$blog->addChild('cs_blog_title', htmlspecialchars($_POST['cs_blog_title'][$counter_blog]) );
											$blog->addChild('cs_blog_view', $_POST['cs_blog_view'][$counter_blog] );
											$blog->addChild('cs_blog_cat', $_POST['cs_blog_cat'][$counter_blog] );
											$blog->addChild('cs_blog_excerpt', $_POST['cs_blog_excerpt'][$counter_blog] );
											$blog->addChild('cs_blog_num_post', $_POST['cs_blog_num_post'][$counter_blog] );
											$blog->addChild('cs_blog_pagination', $_POST['cs_blog_pagination'][$counter_blog] );
											$blog->addChild('cs_blog_description', $_POST['cs_blog_description'][$counter_blog] );
											$blog->addChild('blog_element_size', $_POST['blog_element_size'][$counter_blog] );
										$counter_blog++;
									}
 									else if ( $_POST['cs_orderby'][$counter] == "event" ) {
										$event = $sxe->addChild('event');
											$event->addChild('cs_event_title', htmlspecialchars($_POST['cs_event_title'][$counter_event]) );
											$event->addChild('cs_event_excerpt', htmlspecialchars($_POST['cs_event_excerpt'][$counter_event]) );
											$event->addChild('cs_event_type', $_POST['cs_event_type'][$counter_event] );
											$event->addChild('cs_event_view', $_POST['cs_event_view'][$counter_event] );
											$event->addChild('cs_event_category', $_POST['cs_event_category'][$counter_event] );
											$event->addChild('cs_event_time', $_POST['cs_event_time'][$counter_event] );
											$event->addChild('cs_event_organizer', $_POST['cs_event_organizer'][$counter_event] );
 											$event->addChild('cs_event_filterables', $_POST['cs_event_filterables'][$counter_event] );
											$event->addChild('cs_event_pagination', $_POST['cs_event_pagination'][$counter_event] );
											$event->addChild('cs_event_per_page', $_POST['cs_event_per_page'][$counter_event] );
											$event->addChild('event_element_size', $_POST['event_element_size'][$counter_event] );
										$counter_event++;
									}
									else if ( $_POST['cs_orderby'][$counter] == "contact" ) {
										$contact = $sxe->addChild('contact');
 											$contact->addChild('cs_contact_email', $_POST['cs_contact_email'][$counter_contact] );
											$contact->addChild('cs_contact_succ_msg', $_POST['cs_contact_succ_msg'][$counter_contact] );
											$contact->addChild('contact_element_size', $_POST['contact_element_size'][$counter_contact] );
										$counter_contact++;
									}
									else if ( $_POST['cs_orderby'][$counter] == "column" ) {
										$column = $sxe->addChild('column');
											$column->addChild('column_element_size', htmlspecialchars($_POST['column_element_size'][$counter_column]) );
											$column->addChild('column_text', $_POST['column_text'][$counter_column] );
										$counter_column++;
									}
									else if ( $_POST['cs_orderby'][$counter] == "team" ) {
										$album = $sxe->addChild('team');
											$album->addChild('var_pb_team_title', htmlspecialchars($_POST['var_pb_team_title'][$counter_team]) );
											$album->addChild('var_pb_team_cat', $_POST['var_pb_team_cat'][$counter_team] );
											$album->addChild('var_pb_team_view', $_POST['var_pb_team_view'][$counter_team] );
											$album->addChild('var_pb_team_excerpt', $_POST['var_pb_team_excerpt'][$counter_team] );
											$album->addChild('var_pb_team_filterable', $_POST['var_pb_team_filterable'][$counter_team] );
											$album->addChild('var_pb_cat_team_show', $_POST['var_pb_cat_team_show'][$counter_team] );
											$album->addChild('var_pb_team_pagination', $_POST['var_pb_team_pagination'][$counter_team] );
 											$album->addChild('var_pb_team_per_page', $_POST['var_pb_team_per_page'][$counter_team] );
											$album->addChild('var_pb_team_element_size', $_POST['var_pb_team_element_size'][$counter_team] );
										$counter_team++;
									}
									else if ( $_POST['cs_orderby'][$counter] == "divider" ) {
										$divider = $sxe->addChild('divider');
											$divider->addChild('divider_element_size', htmlspecialchars($_POST['divider_element_size'][$counter_divider]) );
											$divider->addChild('divider_style', $_POST['divider_style'][$counter_divider] );
											$divider->addChild('divider_backtotop', $_POST['divider_backtotop'][$counter_divider] );
											$divider->addChild('divider_mrg_top', $_POST['divider_mrg_top'][$counter_divider] );
											$divider->addChild('divider_mrg_bottom', $_POST['divider_mrg_bottom'][$counter_divider] );
										$counter_divider++;
									}
									
									else if ( $_POST['cs_orderby'][$counter] == "image" ) {
										$divider = $sxe->addChild('image');
											$divider->addChild('image_element_size', htmlspecialchars($_POST['image_element_size'][$counter_image]) );
											$divider->addChild('image_width', htmlspecialchars($_POST['image_width'][$counter_image]) );
											$divider->addChild('image_height', htmlspecialchars($_POST['image_height'][$counter_image]) );
											$divider->addChild('image_lightbox', htmlspecialchars($_POST['image_lightbox'][$counter_image]) );
											$divider->addChild('image_source', htmlspecialchars($_POST['image_source'][$counter_image]) );
											$divider->addChild('image_style', htmlspecialchars($_POST['image_style'][$counter_image]) );
											$divider->addChild('image_caption', htmlspecialchars($_POST['image_caption'][$counter_image]) );
										$counter_image++;
									}
									else if ( $_POST['cs_orderby'][$counter] == "map" ) {
										$divider = $sxe->addChild('map');
											$divider->addChild('map_element_size', htmlspecialchars($_POST['map_element_size'][$counter_map]) );
											$divider->addChild('map_title', htmlspecialchars($_POST['map_title'][$counter_map]) );
											$divider->addChild('map_height', htmlspecialchars($_POST['map_height'][$counter_map]) );
											$divider->addChild('map_lat', htmlspecialchars($_POST['map_lat'][$counter_map]) );
											$divider->addChild('map_lon', htmlspecialchars($_POST['map_lon'][$counter_map]) );
											$divider->addChild('map_zoom', htmlspecialchars($_POST['map_zoom'][$counter_map]) );
											$divider->addChild('map_type', htmlspecialchars($_POST['map_type'][$counter_map]) );
											$divider->addChild('map_info', $_POST['map_info'][$counter_map] );
											$divider->addChild('map_info_width', $_POST['map_info_width'][$counter_map] );
											$divider->addChild('map_info_height', $_POST['map_info_height'][$counter_map] );
											$divider->addChild('map_marker_icon', $_POST['map_marker_icon'][$counter_map] );
											$divider->addChild('map_show_marker', $_POST['map_show_marker'][$counter_map] );
											$divider->addChild('map_controls', $_POST['map_controls'][$counter_map] );
											$divider->addChild('map_draggable', htmlspecialchars($_POST['map_draggable'][$counter_map]) );
											$divider->addChild('map_scrollwheel', htmlspecialchars($_POST['map_scrollwheel'][$counter_map]) );
											$divider->addChild('map_view', htmlspecialchars($_POST['map_view'][$counter_map]) );

										$counter_map++;
									}
									else if ( $_POST['cs_orderby'][$counter] == "video" ) {
										$divider = $sxe->addChild('video');
											$divider->addChild('video_element_size', htmlspecialchars($_POST['video_element_size'][$counter_video]) );
											$divider->addChild('video_url', htmlspecialchars($_POST['video_url'][$counter_video]) );
											$divider->addChild('video_width', htmlspecialchars($_POST['video_width'][$counter_video]) );
											$divider->addChild('video_height', htmlspecialchars($_POST['video_height'][$counter_video]) );
										$counter_video++;
									}
									else if ( $_POST['cs_orderby'][$counter] == "quote" ) {
										$divider = $sxe->addChild('quote');
											$divider->addChild('quote_element_size', htmlspecialchars($_POST['quote_element_size'][$counter_quote]) );
											$divider->addChild('quote_text_color', htmlspecialchars($_POST['quote_text_color'][$counter_quote]) );
											$divider->addChild('quote_align', htmlspecialchars($_POST['quote_align'][$counter_quote]) );
											$divider->addChild('quote_content', htmlspecialchars($_POST['quote_content'][$counter_quote]) );
										$counter_quote++;
									}
									else if ( $_POST['cs_orderby'][$counter] == "dropcap" ) {
										$divider = $sxe->addChild('dropcap');
											$divider->addChild('dropcap_element_size', htmlspecialchars($_POST['dropcap_element_size'][$counter_dropcap]) );
											$divider->addChild('dropcap_content', htmlspecialchars($_POST['dropcap_content'][$counter_dropcap]) );
										$counter_dropcap++;
									}
									else if ( $_POST['cs_orderby'][$counter] == "pricetable" ) {
										$divider = $sxe->addChild('pricetable');
											$divider->addChild('pricetable_element_size', htmlspecialchars($_POST['pricetable_element_size'][$counter_pricetable]) );
											$divider->addChild('pricetable_style', htmlspecialchars($_POST['pricetable_style'][$counter_pricetable]) );
											$divider->addChild('pricetable_title', htmlspecialchars($_POST['pricetable_title'][$counter_pricetable]) );
											$divider->addChild('pricetable_package', htmlspecialchars($_POST['pricetable_package'][$counter_pricetable]) );
											$divider->addChild('pricetable_price', htmlspecialchars($_POST['pricetable_price'][$counter_pricetable]) );
											$divider->addChild('pricetable_for_time', htmlspecialchars($_POST['pricetable_for_time'][$counter_pricetable]) );
											$divider->addChild('pricetable_content', htmlspecialchars($_POST['pricetable_content'][$counter_pricetable]) );
											$divider->addChild('pricetable_linktitle', htmlspecialchars($_POST['pricetable_linktitle'][$counter_pricetable]) );
											$divider->addChild('pricetable_linkurl', htmlspecialchars($_POST['pricetable_linkurl'][$counter_pricetable]) );
											$divider->addChild('pricetable_featured', htmlspecialchars($_POST['pricetable_featured'][$counter_pricetable]) );
											$divider->addChild('pricetable_bgcolor', htmlspecialchars($_POST['pricetable_bgcolor'][$counter_pricetable]) );
  										$counter_pricetable++;
									}
									else if ( $_POST['cs_orderby'][$counter] == "tabs" ) {
										$tabs = $sxe->addChild('tabs');
											$tabs->addChild('tabs_element_size', htmlspecialchars($_POST['tabs_element_size'][$counter_tabs]) );
											for ( $i = 1; $i <= $_POST['tabs_num'][$counter_tabs]; $i++ ){
												$tab = $tabs->addChild('tab');
												$tab->addChild('tab_title', htmlspecialchars( $_POST['tab_title'][$counter_tabs_node] ) );
												$tab->addChild('tab_text', htmlspecialchars( $_POST['tab_text'][$counter_tabs_node] ) );
												$tab->addChild('tab_title_icon', htmlspecialchars( $_POST['tab_title_icon'][$counter_tabs_node] ) );
												$tab->addChild('tab_active', htmlspecialchars( $_POST['tab_active'][$counter_tabs_node] ) );
												$counter_tabs_node++;
											}
										$counter_tabs++;
									}
									else if ( $_POST['cs_orderby'][$counter] == "accordions" ) {
										$accordions = $sxe->addChild('accordions');
											$accordions->addChild('accordion_element_size', htmlspecialchars($_POST['accordion_element_size'][$counter_accordion]) );
											for ( $i = 1; $i <= $_POST['accordion_num'][$counter_accordion]; $i++ ){
												$accordion = $accordions->addChild('accordion');
												$accordion->addChild('accordion_title', htmlspecialchars( $_POST['accordion_title'][$counter_accordion_node] ) );
												$accordion->addChild('accordion_text', htmlspecialchars( $_POST['accordion_text'][$counter_accordion_node] ) );
												$accordion->addChild('accordion_title_icon', htmlspecialchars( $_POST['accordion_title_icon'][$counter_accordion_node] ) );
												$accordion->addChild('accordion_active', htmlspecialchars( $_POST['accordion_active'][$counter_accordion_node] ) );
												$counter_accordion_node++;
											}
										$counter_accordion++;
									}
									$counter++;
								}
							}
							update_post_meta( $cs_post_id, 'cs_page_builder', $sxe->asXML() );
					//creating xml page builder end
				}
		}
	}
?>