<?php
	global $cs_node,$post,$cs_theme_option,$counter_node,$wpdb;
	if ( !isset($cs_node->cs_event_per_page) || empty($cs_node->cs_event_per_page) ) { $cs_node->cs_event_per_page = -1; }
	  $meta_compare = '';
        $filter_category = '';
        if ( $cs_node->cs_event_type == "Upcoming Events" ) $meta_compare = ">=";
        else if ( $cs_node->cs_event_type == "Past Events" ) $meta_compare = "<";
        $row_cat = $wpdb->get_row("SELECT * from ".$wpdb->prefix."terms WHERE slug = '" . $cs_node->cs_event_category ."'" );
        if ( isset($_GET['filter_category']) ) {$filter_category = $_GET['filter_category'];}
        else {
            if(isset($row_cat->slug)){
            $filter_category = $row_cat->slug;
            }
        }
		$counter_events = 0;
	if ( empty($_GET['page_id_all']) ) $_GET['page_id_all'] = 1;
		if ( $cs_node->cs_event_type == "All Events" ) {
			$args = array(
				'posts_per_page'			=> "-1",
				'post_type'					=> 'events',
				'post_status'				=> 'publish',
				'orderby'					=> 'meta_value',
				'order'						=> 'ASC',
			);
		}
		else {
			$args = array(
				'posts_per_page'			=> "-1",
				'post_type'					=> 'events',
				'post_status'				=> 'publish',
				'meta_key'					=> 'cs_event_to_date',
				'meta_value'				=> date('Y-m-d'),
				'meta_compare'				=> $meta_compare,
				'orderby'					=> 'meta_value',
				'order'						=> 'ASC',
			);
		}
		if(isset($filter_category) && $filter_category <> '' && $filter_category <> '0'){
			$event_category_array = array('event-category' => "$filter_category");
			$args = array_merge($args, $event_category_array);
		}
		$custom_query = new WP_Query($args);
		$count_post = 0;
		$count_post = $custom_query->post_count;
		if ( $cs_node->cs_event_pagination == "Single Page") { $cs_node->cs_event_per_page = $cs_node->cs_event_per_page; }
	
					if ( $cs_node->cs_event_type == "Upcoming Events") {
						$args = array(
							'posts_per_page'			=> "$cs_node->cs_event_per_page",
							'paged'						=> $_GET['page_id_all'],
							'post_type'					=> 'events',
							'post_status'				=> 'publish',
							'meta_key'					=> 'cs_event_from_date',
							'meta_value'				=> date('Y-m-d'),
							'meta_compare'				=> ">=",
							'orderby'					=> 'meta_value',
							'order'						=> 'ASC',
						 );
					}else if ( $cs_node->cs_event_type == "All Events" ) {
						$args = array(
							'posts_per_page'			=> "$cs_node->cs_event_per_page",
							'paged'						=> $_GET['page_id_all'],
							'post_type'					=> 'events',
							'meta_key'					=> 'cs_event_from_date',
							'meta_value'				=> '',
							'post_status'				=> 'publish',
							'orderby'					=> 'meta_value',
							'order'						=> 'ASC',
						);
					}
					else {
						$args = array(
							'posts_per_page'			=> "$cs_node->cs_event_per_page",
							'paged'						=> $_GET['page_id_all'],
							'post_type'					=> 'events',
							'post_status'				=> 'publish',
							'meta_key'					=> 'cs_event_from_date',
							'meta_value'				=> date('Y-m-d'),
							'meta_compare'				=> $meta_compare,
							'orderby'					=> 'meta_value',
							'order'						=> 'ASC',
						 );
					}
					if(isset($filter_category) && $filter_category <> '' && $filter_category <> '0'){
						$event_category_array = array('event-category' => "$filter_category");
						$args = array_merge($args, $event_category_array);
					}
					$custom_query = new WP_Query($args);
					if ( $custom_query->have_posts() <> "" ){?>
                    
                    <div class=" element_size_<?php echo $cs_node->event_element_size;?>">
                    <div class="event <?php if($cs_node->cs_event_view == "With Images"){ echo "event-v2"; } ?>">
                        <script type="text/javascript">
							jQuery(document).ready(function($){
								// Add Tag Last child Script
								cs_add_class_last_child();
								// Add Tag Last child Script
							});
						</script>
                        
                        <header class="cs-heading-title">
                        <?php if ($cs_node->cs_event_title <> ''){?><h2 class="cs-section-title cs-heading-color"><?php echo $cs_node->cs_event_title; ?></h2><?php  } ?>
                        <?php if($cs_node->cs_event_filterables == "Yes"){
                                $qrystr= "";
                                if ( isset($_GET['page_id']) ) $qrystr = "&page_id=".$_GET['page_id'];
                            ?>  
                            <div class="sortby">
                                <ul>
                                    <?php
                                        if(isset($cs_node->cs_event_category) && $cs_node->cs_event_category <> '' && $cs_node->cs_event_category <> '0'){
                                            $categories = get_categories( array('child_of' => "$row_cat->term_id", 'taxonomy' => 'event-category', 'hide_empty' => 0) );
											if(count($categories)>0){
											?>
                                            <li class="<?php if(($cs_node->cs_event_category==$filter_category)){echo 'active';}?>"><a href="<?php the_permalink();?>"><?php _e("All",'Soundblast');?></a></li>
                                            <?php
											}
                                        } else {
                                            $categories = get_categories( array('taxonomy' => 'event-category', 'hide_empty' => 0) );
                                        }
                                        foreach ($categories as $category) {
                                    ?>
                                        <li <?php if($category->slug==$filter_category){echo 'class="active"';}?>><a href="?<?php echo $qrystr."&filter_category=".$category->slug?>"><?php echo $category->cat_name?></a></li>
                                       <?php }?>
                                </ul>
                                
                            </div>
                            <?php }?>
                        </header>
    				<?php 
						echo '<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=true"></script>';
						$width = 150; 
						$height = 150;
						$counter_events = 0;
						while ( $custom_query->have_posts() ): $custom_query->the_post();
							$counter_events++;
							$cs_event_meta = get_post_meta($post->ID, "cs_event_meta", true);
							if ( $cs_event_meta <> "" ) {
								$cs_event_meta = new SimpleXMLElement($cs_event_meta);
								if($cs_event_meta->event_address <> ''){
									$address_map = get_the_title("$cs_event_meta->event_address");	
								}else{
									$address_map = '';
								}
							}
							$cs_event_loc = get_post_meta($cs_event_meta->event_address, "cs_event_loc_meta", true);
							if ( $cs_event_loc <> "" ) {
								$cs_xmlObject = new SimpleXMLElement($cs_event_loc);
								$loc_address = $cs_xmlObject->loc_address;
								$event_loc_lat = $cs_xmlObject->event_loc_lat;
								$event_loc_long = $cs_xmlObject->event_loc_long;
								$event_loc_zoom = $cs_xmlObject->event_loc_zoom;
								$loc_city = $cs_xmlObject->loc_city;
								$loc_postcode = $cs_xmlObject->loc_postcode;
								$loc_country = $cs_xmlObject->loc_country;
								
							} else {
								$loc_address = '';
								$event_loc_lat = '';
								$event_loc_long = '';
								$event_loc_zoom = '';
								$loc_city = '';
								$loc_postcode = '';
								$loc_country = '';
							}
							$location = $noimg = '';
							if($loc_address <> ''){
								$location .=$loc_address;
							} else if($loc_city <> ''){
								$location .= ' '.$loc_city;
							} else if($loc_postcode <> ''){
								$location .= ' '.$loc_postcode;
							} else if($loc_country <> ''){
								$location .= ' '.$loc_country;
							}
							$event_from_date = get_post_meta($post->ID, "cs_event_from_date", true);
							$image_url = cs_get_post_img_src($post->ID, 150, 150);
							$no_image_class = '';
							if($image_url == ""){
								$no_image_class = 'class="no-img"';
							}
					?>
                                <article <?php post_class($no_image_class);?>>
                                	<?php if($cs_node->cs_event_view == "With Images"){ ?>
                                    <h5 class="day"><?php echo get_the_date('l'); ?></h5>
                                    <?php } ?>
                                    <?php if($cs_node->cs_event_view == "Without Images"){ ?>
                                	<figure>
                                    	<span><span><?php echo date('M',strtotime($event_from_date));?></span> <br /> <?php echo date('d',strtotime($event_from_date));?></span>
                                    </figure>
                                    <?php }else{ 
                                    $image_url = cs_get_post_img_src($post->ID, 150, 150);
									if($image_url <> ""){
									?>
                                    <figure>
                                    	<img src="<?php echo $image_url; ?>" alt="" />
                                    </figure>
                                    <?php }} ?>
                                 
                                    <div class="text <?php if($cs_event_meta->event_ticket_options == "Cancelled"){?>cs-main-cancel<?php } ?>">
                                        <h2 class="cs-post-title cs-heading-color"><a class="colrhover" href="<?php the_permalink();?>"><?php echo substr(get_the_title(), '0', '40');if(strlen(get_the_title())>40){ echo '...';} ?></a></h2>
                                       
                                       		<?php if($cs_node->cs_event_view == "With Images"){ ?>
                                            <p><?php echo cs_get_the_excerpt($cs_node->cs_event_excerpt,false) ?>...</p>
                                            <!--<span><i class="fa fa-calendar"></i><?php echo get_the_date(); ?></span>-->
                                            <?php } ?>
                                            
									   		<?php 
											  if ( $cs_node->cs_event_time == "Yes" ) {
											   echo "<span><time>";
												if ( $cs_event_meta->event_all_day != "on" ) {
													echo $cs_event_meta->event_start_time; if($cs_event_meta->event_end_time <> ''){ echo "-";  echo $cs_event_meta->event_end_time; }
													if($cs_event_meta->event_end_time <> '' or $cs_event_meta->event_end_time <> ''){
														if($cs_node->cs_event_view <> "With Images"){
															echo ' :: ';
														}
													}
												}else{
													_e("All",'Soundblast') . printf( __("%s day",'Soundblast'), ' ').' :: ';
												}
												echo "</time></span>";
											  }
											?>                                            <?php if($cs_node->cs_event_view == "With Images"){ 
											if($loc_address <> ""){
											?>
                                            <!--<br />
                                            <p><i class="fa fa-map-marker"></i><?php echo $loc_address; ?></p>
-->                                            <?php }} ?>
                                       
                                       <?php if($cs_node->cs_event_view == "Without Images"){ ?>
                                       <p><?php echo cs_get_the_excerpt($cs_node->cs_event_excerpt,false) ?></p>
                                       <?php } ?>
                                       
                                    </div>
                                
								<?php /*if($event_loc_lat <> ""  && $event_loc_long <> '' && $cs_event_meta->event_map == 'on'){?> <div class="gray-box"><a class="map-marker" onclick="show_mapp('<?php echo $post->ID; ?>', '<?php echo $address_map;?>', '<?php echo $event_loc_lat;?>', '<?php echo $event_loc_long;?>', '<?php echo $event_loc_zoom;?>', '<?php echo home_url() ?>','<?php echo get_template_directory_uri() ?>')"><i class="fa fa-play fa-2x"></i></a></div><?php }*/?>
								
                                <?php if($cs_node->cs_event_view == "With Images"){ ?>
                                <a class="map-marker" href="<?php the_permalink();?>"><i class="fa fa-play fa-2x"></i></a>
                                <?php } ?>
                                
                                <?php 
								 $cs_map_show = false;
								   if($cs_event_meta->event_map == 'on'){
									   $cs_map_show =true;
								   }
								   if($event_loc_lat <> ""  && $event_loc_long <> '' && $cs_event_meta->event_map == 'on'){
								?>

                                <div class="event-map post-<?php echo $post->ID;?>" id="event-<?php echo $post->ID;?>">
                                	<div class="mapcode fullwidth mapsection gmapwrapp" id="map_canvas<?php echo $post->ID; ?>" style="height:182px; width:100%;"></div>
										
                                    
                                </div>
                                <?php }?>
                            </article>
                        
			    <?php endwhile;
				
				echo '</div>';
				
					$qrystr = '';
					if(cs_pagination($count_post, $cs_node->cs_event_per_page, $qrystr) <> ''){
						// pagination start
						if ( $cs_node->cs_event_pagination == "Show Pagination" and $cs_node->cs_event_per_page < $count_post ) {
							if ( isset($_GET['page_id']) ) $qrystr = "&page_id=".$_GET['page_id'];
							if ( isset($_GET['filter_category']) ) $qrystr .= "&filter_category=".$_GET['filter_category'];
							echo cs_pagination($count_post, $cs_node->cs_event_per_page, $qrystr);
						}
						// pagination end
					}
				echo '</div>';
				 ?>
            
            
	 <?php } else { ?>
    	<h2><?php _e('No results found.', "Soundblast") ?></h2>
    <?php  }?>
	