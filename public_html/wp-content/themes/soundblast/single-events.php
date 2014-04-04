<?php
get_header();
	global $cs_node, $cs_theme_option, $video_width;
	$cs_layout = '';
	$counter_events=1;
	cs_event_countdown_scripts();
if ( have_posts() ) while ( have_posts() ) : the_post();
 	$post_xml = get_post_meta($post->ID, "cs_event_meta", true);	
	if ( $post_xml <> "" ) {
		$cs_xmlObject = new SimpleXMLElement($post_xml);
  		$cs_layout = $cs_xmlObject->sidebar_layout->cs_layout;
		$cs_sidebar_left = $cs_xmlObject->sidebar_layout->cs_sidebar_left;
		$cs_sidebar_right = $cs_xmlObject->sidebar_layout->cs_sidebar_right;
		$event_social_sharing = $cs_xmlObject->event_social_sharing;
		$event_address = $cs_xmlObject->event_address;
		$inside_event_map = $cs_xmlObject->event_map;
		$width = 330;
		$height = 330;
		$image_id = cs_get_post_img($post->ID, $width,$height);
		if ( $cs_layout == "left") {
			$cs_layout = "content-right col-lg-9 col-md-9";
 		}
		else if ( $cs_layout == "right" ) {
			$cs_layout = "content-left col-lg-9 col-md-9";
 		}
		else {
			$cs_layout = "col-lg-12 col-md-12";
		}
  	}else{
		$event_social_sharing = '';
	}
	$cs_event_loc = get_post_meta($cs_xmlObject->event_address, "cs_event_loc_meta", true);
	if ( $cs_event_loc <> "" ) {
		$cs_event_loc = new SimpleXMLElement($cs_event_loc);
 			$event_loc_lat = $cs_event_loc->event_loc_lat;
			$event_loc_long = $cs_event_loc->event_loc_long;
			$event_loc_zoom = $cs_event_loc->event_loc_zoom;
			$loc_address = $cs_event_loc->loc_address;
			$loc_city = $cs_event_loc->loc_city;
			$loc_postcode = $cs_event_loc->loc_postcode;
			$loc_region = $cs_event_loc->loc_region;
			$loc_country = $cs_event_loc->loc_country;
	}
	else {
		$event_loc_lat = '';
		$event_loc_long = '';
		$event_loc_zoom = '';
		$loc_address = '';
		$loc_city = '';
		$loc_postcode = '';
		$loc_region = '';
		$loc_country = '';
	}
	$location = '';
	if($loc_address <> ''){
		$location .=$loc_address;
	} else if($loc_city <> ''){
		$location .= ' '.$loc_city;
	} else if($loc_postcode <> ''){
		$location .= ' '.$loc_postcode;
	} else if($loc_country <> ''){
		$location .= ' '.$loc_country;
	}
	$cs_event_to_date = get_post_meta($post->ID, "cs_event_to_date", true); 
	$cs_event_from_date = get_post_meta($post->ID, "cs_event_from_date", true); 
	$year_event = date("Y", strtotime($cs_event_from_date));
	$month_event = date("m", strtotime($cs_event_from_date));
	$month_event_c = date("M", strtotime($cs_event_from_date));							
	$date_event_day = date("d", strtotime($cs_event_from_date));
	$cs_event_meta = get_post_meta($post->ID, "cs_event_meta", true);
	$date_format = get_option( 'date_format' );
	$time_format = get_option( 'time_format' );
	if ( $cs_event_meta <> "" ) {
		$cs_event_meta = new SimpleXMLElement($cs_event_meta);
	}	
	$address_map = '';
	$address_map = get_the_title("$cs_xmlObject->event_address");		
	$time_left = date("H,i,s", strtotime("$cs_event_meta->event_start_time"));
	$current_date = date('Y-m-d');
		$cs_event_meta = get_post_meta($post->ID, "cs_event_meta", true);
		if ( $cs_event_meta <> "" ) $cs_event_meta = new SimpleXMLElement($cs_event_meta);
		if($cs_xmlObject->sidebar_layout->cs_layout <> 'none' || $cs_xmlObject->sidebar_layout->cs_layout <> ''){
			 $cs_event_layout = $cs_layout;
		 }
		 if($image_id == '' && $cs_xmlObject->event_map <> "on" && $cs_xmlObject->var_cp_trainer == ''){
			 $cs_event_layout = "col-md-12";

		 } if(($image_id == '' && $cs_xmlObject->event_map <> "on" && $cs_xmlObject->var_cp_trainer == '') && ($cs_xmlObject->sidebar_layout->cs_layout == 'none' || $cs_xmlObject->sidebar_layout->cs_layout == '')){
			 $cs_event_layout = "col-md-12";
		
		 } else {
			 
			 $cs_event_layout = "col-md-8";
			 
		 }
		 if($cs_xmlObject->sidebar_layout->cs_layout <> 'none' && $cs_xmlObject->sidebar_layout->cs_layout <> ''){
			  $cs_event_layout = "col-md-9";
		 }
		 
		 
		 
	?>
          <!-- Col-Md-12 Start -->
         	<?php if ($cs_layout == 'content-right col-lg-9 col-md-9'){ ?>
                <div class="col-md-3 col-sm-3"><?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar($cs_sidebar_left) ) : ?><?php endif; ?></div>
            <?php wp_reset_query();}?>
          
           <?php if(($image_id <> '' || $cs_xmlObject->event_map == "on" || $cs_xmlObject->var_cp_trainer <> '') && ($cs_xmlObject->sidebar_layout->cs_layout == 'none' || $cs_xmlObject->sidebar_layout->cs_layout == '')){?>
                    <div class="col-md-4">
                    <!-- Event Detail Start -->
                    <!-- Detail Content Left Start -->
                   
                    <article class="detail-cont-left">
                        <?php if($image_id <> ''){?>
                        <figure><a><?php echo $image_id;?></a></figure>
                        <?php }?>
                        <?php if ($cs_xmlObject->event_map == "on"){ ?>
                        <div class="header_element">
                         <?php if($location <> "" && $event_loc_lat <> "" && $event_loc_long <>"" && $event_loc_long <> '' && $event_loc_zoom <> ''){?>
                         	<header class="cs-heading-title">
                                <h2 class="cs-section-title cs-heading-color"><?php if($cs_theme_option['trans_switcher'] == "on"){ _e('Event Location','Soundblast');}else{ echo $cs_theme_option['trans_event_location']; } ?></h2>
                            </header>
                                <div class="mapcode fullwidth mapsection gmapwrapp" id="map_canvas<?php echo $post->ID; ?>" style="height:248px; width:100%; float:left;"></div>
                                    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=true"></script>
                                    <script type="text/javascript">
                                        jQuery(document).ready(function(){
                                            event_map("<?php echo $location ?>",<?php echo $event_loc_lat ?>,<?php echo $event_loc_long ?>,<?php echo $event_loc_zoom; ?>, <?php echo $post->ID; ?>);
                                        });
                                    </script>
                            <?php } ?>
                        </div> 
                        <?php } ?>
                    </article>
                    
                    <?php 
						if ($cs_xmlObject->var_cp_trainer <> ''){
							if ($cs_xmlObject->event_performers_title <> ""){
								?>
								<header class="cs-heading-title">
									<h2 class="cs-section-title cs-heading-color"><?php echo $cs_xmlObject->event_performers_title; ?></h2>
								</header>
								<?php							
							}
						
							echo '<div class="event-performers">';
							$var_cp_trainer = explode(",", $cs_xmlObject->var_cp_trainer);
							$num_trainers = count($var_cp_trainer);
							$i = 0;
							foreach($var_cp_trainer as $var_trainer_id){
								$width = 150;
								$height = 150;
								$Perf_image_id = cs_get_post_img($var_trainer_id, $width,$height);
								if($Perf_image_id <> ''){?>
                                    <figure><a data-toggle="tooltip" data-original-title="<?php echo get_the_title($var_trainer_id); ?>"><?php echo $Perf_image_id;?></a></figure>
                                <?php 
								}
							}
							echo '</div>';
						}
					?>  
                    </div>
                    <?php }?>
                    <div class="<?php echo $cs_event_layout.' '.$cs_xmlObject->sidebar_layout->cs_layout;?>">
                    	
                        <!-- Detail Text Strat -->
						<script type="text/javascript">
							jQuery(document).ready(function($){
								cs_map_toggle();
							});
						</script>
                        <!-- Detail Content Left End -->
                         <?php if($image_id <> '' && ($cs_xmlObject->sidebar_layout->cs_layout <>'none' && $cs_xmlObject->sidebar_layout->cs_layout <> '')){?>
                               			<figure class="cs-event-figure"><a><?php echo $image_id;?></a></figure>
                               <?php }?>
                        <!-- Detail Content Right Start -->
                        <article class="detail-section <?php if($image_id == '' && ($cs_xmlObject->sidebar_layout->cs_layout <>'none' && $cs_xmlObject->sidebar_layout->cs_layout <> '')){?> cs-no-image<?php }?>">
                        	
                        	<?php if($cs_xmlObject->event_sub_title <> ""){ ?>
                                <header class="cs-heading-title">
                                    <h2 class="cs-section-title cs-heading-color"><?php echo $cs_xmlObject->event_sub_title; ?></h2>
                                </header>
                                <?php } ?>
                                <ul class="post-options">
                                	 <?php 
										$before_cat = '<li><i class="fa fa-list"></i>';
										$categories_list = get_the_term_list ( get_the_id(), 'event-category', $before_cat, ', ', '</li>' );
										if ( $categories_list ){ printf( __( '%1$s', 'SoundBlast' ),$categories_list ); }
									?>
                                    <li>
                                    <?php if($cs_event_from_date <> ""){ ?>
                                    <i class="fa fa-calendar"></i><?php echo date("F d, Y", strtotime($cs_event_from_date));?>
                                    <?php } ?>
                                    </li>
                                    <li>
                                    <i class="fa fa-clock-o"></i>
                                    <?php if ( $cs_event_meta->event_all_day != "on" ) {
										echo $cs_event_meta->event_start_time; if($cs_event_meta->event_end_time <> ''){ echo "-";  echo $cs_event_meta->event_end_time; }
									}else{
										_e("All",'Soundblast') . printf( __("%s day",'Soundblast'), ' ');
									}
									?>
                                    </li>
                                    <?php if($location <> ""){ ?>
                                    <li><i class="fa fa-map-marker"></i><?php echo get_the_title((int) $cs_xmlObject->event_address);?></li>
                                    <?php } ?>
                                </ul>
                            
                            <!-- Icons Section Start -->
                            <div class="icons-sec">
                                <div class="detail-sec">
                                    <ul>
                                    <?php if($cs_event_meta->event_ticket_price <> ""){ ?>
                                      <li><span class="cs-small">$</span><?php echo $cs_event_meta->event_ticket_price; ?></li> 
                                      <li><div class="star-rating">
                                        <span style="width:<?php echo ($cs_event_meta->event_rating)*10; ?>%"></span>
                                    </div></li>
                                    <?php } ?>
                                        
									<?php if($cs_event_meta->event_ticket_options <> ''){?> 
                                           <li>
                                                <?php if($cs_event_meta->event_ticket_options == "Buy Now"){?> 
                                                <a class="cs-buynow" href="<?php echo $cs_event_meta->event_buy_now;?>"><?php if($cs_theme_option['trans_switcher'] == "on"){ _e('Buy Ticket','Soundblast');}else{ echo $cs_theme_option['trans_event_buy_ticket']; } ?></a>
                                                <?php } ?>
                                                <?php if($cs_event_meta->event_ticket_options == "Free"){?> 
                                                <a class="cs-free" href="<?php echo $cs_event_meta->event_buy_now;?>"><?php if($cs_theme_option['trans_switcher'] == "on"){ _e('Free Entry','Soundblast');}else{ echo $cs_theme_option['trans_event_free_entry']; } ?></a>
                                                <?php } ?>
                                                <?php if($cs_event_meta->event_ticket_options == "Cancelled"){?> 
                                                <a class="cs-cancel"><?php if($cs_theme_option['trans_switcher'] == "on"){ _e('Cancelled','Soundblast');}else{ echo $cs_theme_option['trans_event_cancelled']; } ?></a>
                                                <?php } ?>
                                                <?php if($cs_event_meta->event_ticket_options == "Full Booked"){?> 
                                                <a class="cs-fullbook" href="<?php echo $cs_event_meta->event_buy_now;?>"></i><?php if($cs_theme_option['trans_switcher'] == "on"){ _e('Sold Out','Soundblast');}else{ echo $cs_theme_option['trans_event_sold_out']; } ?></a>
                                                <?php } ?>
                                            </li>
                                        <?php }?>
                                
                                    </ul>
                                </div>
                            </div>
                            <!-- Icons Section End -->
                            
                        </article>
                        <div class="devider-1"></div>
                        <!-- Detail Content Right End -->
                    <div class="detail_text rich_editor_text">
                       <?php 
					   		the_content();
					   		wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'Soundblast' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) );
					   ?>
                    </div>
                    <!-- Detail Text End -->
                    
                    
                    <!-- Share Post Start -->
                    
                    <div class="share_post">
                    	<div class="tagcloud post-tags">
						<?php 
                            $before_cat = '<i class="fa fa-tag"></i>&nbsp;';
                            $tags_list = get_the_term_list ( get_the_id(), 'event-tag', $before_cat, ', ', '' );
                            if ( $tags_list ){ printf( __( '%1$s', 'SoundBlast' ),$tags_list ); }
                        ?>
                    </div>
						<?php 
						if($cs_xmlObject->event_social_sharing == 'on') { cs_social_share();
						}
                        ?>
                        
                        <div class="right-sec">
                        
                           <?php 
                            cs_next_prev_custom_links('events');
                            ?>
                        </div>
                    </div>
                    
                    <div class="devider-1"></div>
                    <!-- Share Post End -->
                    <!-- About Author Start -->
                    <?php 
							if (get_the_author_meta('description')){ ?>
                     			<div class="about-author">
                                     <figure><a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>" class="float-left"><?php echo get_avatar(get_the_author_meta('user_email'), apply_filters('PixFill_author_bio_avatar_size', 80)); ?></a></figure>
                                     <div class="text">
                                     	<div class="user-info">
                                        <h2 class="cs-post-title cs-heading-color"><a class="colrhover" href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>"><?php the_author_meta('nicename'); ?></a></h2>
                                        <a class="view-all-post" href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>"><i class="fa fa-caret-right"></i><?php if($cs_theme_option['trans_switcher'] == "on"){ _e('Event Location','Soundblast');}else{ echo $cs_theme_option['trans_event_location']; } ?></a>
                                        </div>
                                        <p><?php the_author_meta('description'); ?></p>
                                        <?php if(get_the_author_meta('twitter') <> ''){?><a class="follow-tweet" href="http://twitter.com/<?php the_author_meta('twitter'); ?>"><i class="fa fa-twitter"></i>@<?php the_author_meta('twitter'); ?></a><?php }?>
                                    </div>
                              	</div>
                                <!-- About Author End -->
                                <div class="devider-1"></div>
                        	<?php } ?>
                            <?php if ($cs_xmlObject->event_map == "on"  && ($cs_xmlObject->sidebar_layout->cs_layout <>'none' && $cs_xmlObject->sidebar_layout->cs_layout <> '')){ ?>
                        <div class="header_element">
                         <?php if($location <> "" && $event_loc_lat <> "" && $event_loc_long <>"" && $event_loc_long <> '' && $event_loc_zoom <> ''){?>
                         	<header class="cs-heading-title">
                                <h2 class="cs-section-title cs-heading-color"><?php if($cs_theme_option['trans_switcher'] == "on"){ _e('Event Location','Soundblast');}else{ echo $cs_theme_option['trans_event_location']; } ?></h2>
                            </header>
                                <div class="mapcode fullwidth mapsection gmapwrapp" id="map_canvas<?php echo $post->ID; ?>" style="height:248px; width:100%; float:left;"></div>
                                    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=true"></script>
                                    <script type="text/javascript">
                                        jQuery(document).ready(function(){
                                            event_map("<?php echo $location ?>",<?php echo $event_loc_lat ?>,<?php echo $event_loc_long ?>,<?php echo $event_loc_zoom; ?>, <?php echo $post->ID; ?>);
                                        });
                                    </script>
                            <?php } ?>
                        </div> 
                        <?php } ?>
                        <?php 
						if ($cs_xmlObject->var_cp_trainer <> '' && ($cs_xmlObject->sidebar_layout->cs_layout <>'none' && $cs_xmlObject->sidebar_layout->cs_layout <> '')){
							if ($cs_xmlObject->event_performers_title <> ""){
								?>
								<header class="cs-heading-title">
									<h2 class="cs-section-title cs-heading-color"><?php echo $cs_xmlObject->event_performers_title; ?></h2>
								</header>
								<?php							
							}
						
							echo '<div class="event-performers">';
							$var_cp_trainer = explode(",", $cs_xmlObject->var_cp_trainer);
							$num_trainers = count($var_cp_trainer);
							$i = 0;
							foreach($var_cp_trainer as $var_trainer_id){
								$width = 150;
								$height = 150;
								$Perf_image_id = cs_get_post_img($var_trainer_id, $width,$height);
								if($Perf_image_id <> ''){?>
                                    <figure><a title="<?php echo get_the_title($var_trainer_id); ?>"><?php echo $Perf_image_id;?></a></figure>
                                <?php 
								}
							}
							echo '</div>';
						}
					?> 
                    <!-- About Author End -->
                    <?php if($cs_xmlObject->event_related_events == "on"){ 
                     if($cs_xmlObject->event_related_events_title <> ""){ ?>
                    	<header class="cs-heading-title">
                            <h2 class="cs-section-title cs-heading-color"><?php echo $cs_xmlObject->event_related_events_title; ?></h2>
                        </header>
					<?php } ?>
                    <div class="event">
                    <?php
					wp_reset_query();
					$custom_taxterms='';
					$custom_taxterms = wp_get_object_terms( $post->ID, array('event-category', 'event-tag'), array('fields' => 'ids') );
					// arguments
					$args = array(
						'post_type' => 'events',
						'post_status' => 'publish',
						'posts_per_page' => 4, // you may edit this number
						'orderby' => 'DESC',
						'tax_query' => array(
							'relation' => 'OR',
							array(
								'taxonomy' => 'event-tag',
								'field' => 'id',
								'terms' => $custom_taxterms
							),
							array(
								'taxonomy' => 'event-category',
								'field' => 'id',
								'terms' => $custom_taxterms
							)
						),
						'post__not_in' => array ($post->ID),
					); 
					$custom_query = new WP_Query($args);
					$counter_posts_db = 0;
					if($custom_query->have_posts()):
					while ( $custom_query->have_posts()) : $custom_query->the_post();
						 $counter_events++;
							$cs_event_meta = get_post_meta($post->ID, "cs_event_meta", true);
							if ( $cs_event_meta <> "" ) {
								$cs_event_meta = new SimpleXMLElement($cs_event_meta);
							}
							$event_from_date = get_post_meta($post->ID, "cs_event_from_date", true);
							
					?>
                            <article <?php post_class();?>>
                            
                                <figure>
                                    <span><span><?php echo date('M',strtotime($event_from_date));?></span> <br /> <?php echo date('d',strtotime($event_from_date));?></span>
                                </figure>
                             
                                <div class="text <?php if($cs_event_meta->event_ticket_options == "Cancelled"){?>cs-main-cancel<?php } ?>">
                                    <h2 class="cs-post-title cs-heading-color"><a class="colrhover" href="<?php the_permalink();?>"><?php echo substr(get_the_title(), '0', '40');if(strlen(get_the_title())>40){ echo '...';} ?></a></h2>
                                   <time>
                                        <?php 
                                            if ( $cs_event_meta->event_all_day != "on" ) {
                                                echo $cs_event_meta->event_start_time; if($cs_event_meta->event_end_time <> ''){ echo "-";  echo $cs_event_meta->event_end_time; }
                                            }else{
                                                _e("All",'Soundblast') . printf( __("%s day",'Soundblast'), ' ');
                                            }
                                        ?>
                                   </time>
                                   <p><?php echo cs_get_the_excerpt(80,false) ?>...</p>
                                   
                                </div>
                            
                            
                        </article>
					<?php endwhile; endif;
					wp_reset_query();
					?> 
                    </div>
                    <?php } 
                    
                     comments_template('', true); ?>
                    </div>
				<?php if ( $cs_layout  == 'content-left col-lg-9 col-md-9'){ ?>
                			<div class="col-md-3 col-sm-3"><?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar($cs_sidebar_right) ) : ?><?php endif; ?></div>
                <?php wp_reset_query();} ?>
            <!-- Col-Md-12 End -->
	<?php
    endwhile;
    $counter_events++;
  get_footer();