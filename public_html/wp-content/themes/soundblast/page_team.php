<?php
	global $cs_node, $cs_theme_option, $counter_node, $post;
	if ( !isset($_GET['page_id']) || empty($_GET['page_id']) ) { $_GET['page_id'] = $post->ID; }
	if ( !isset($cs_node->var_pb_team_per_page) || empty($cs_node->var_pb_team_per_page) ) { $cs_node->var_pb_team_per_page = -1; }
	$filter_category = '';
	$row_cat = $wpdb->get_row("SELECT * from ".$wpdb->prefix."terms WHERE slug = '" . $cs_node->var_pb_team_cat ."'" );
	if ( isset($_GET['filter_category']) ) {$filter_category = $_GET['filter_category'];}
	else {
		if(isset($row_cat->slug)){
		$filter_category = $row_cat->slug;
		}
	}
	 if ( empty($_GET['page_id_all']) ) $_GET['page_id_all'] = 1;
			$args = array(
				'posts_per_page'			=> "-1",
				'post_type'					=> 'teams',
				'post_status'				=> 'publish',
				'order'						=> 'ASC',
	);
		if(isset($filter_category) && $filter_category <> '' && $filter_category <> '0'){
			$class_category_array = array('team-category' => "$filter_category");
			$args = array_merge($args, $class_category_array);
		}
		$custom_query = new WP_Query($args);
		$count_post = 0;
		$count_post = $custom_query->post_count;
	?>
	<div class="element_size_<?php echo $cs_node->var_pb_team_element_size;?>">
    	<?php if ($cs_node->var_pb_team_title <> '') { ?>
            <header class="cs-heading-title">
                <h2 class="cs-section-title cs-heading-color"><?php echo $cs_node->var_pb_team_title; ?></h2>
            </header>
        <?php  } ?>
		<?php 
            $args = array(
						'posts_per_page'			=> "$cs_node->var_pb_class_per_page",
						'paged'						=> $_GET['page_id_all'],
						'post_type'					=> 'class',
						'post_status'				=> 'publish',
						'order'						=> 'ASC',
					 );
					if(isset($filter_category) && $filter_category <> '' && $filter_category <> '0'){
						$event_category_array = array('class-category' => "$filter_category");
						$args = array_merge($args, $event_category_array);
					}
					$custom_query = new WP_Query($args);
					
                    $args = array(
							'posts_per_page'			=> "$cs_node->var_pb_team_per_page",
							'paged'						=> '$cs_node->var_pb_team_pagination',
							'post_type'					=> 'teams',
							'post_status'				=> 'publish',
							'order'						=> 'ASC',
						 );
						$custom_query = new WP_Query($args);
						if ( $custom_query->have_posts() <> "" ){
							$width = 330; 
							$height = 330;
					?>
					<div class="meet-artist">
                        <?php 
						$team_view = "team-v2";
						if($cs_node->var_pb_team_view == 'home_view'){
						$team_view = "team-v1";
						cs_cycleslider_script();
						?>
                        <div class="center">
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
                            data-cycle-prev="#prev">
                        <?php	
						}
                            while ( $custom_query->have_posts() ): $custom_query->the_post();
                                $cs_team = get_post_meta($post->ID, "cs_team", true);
                                if ( $cs_team <> "" ) {
                                    $cs_xmlObject_team = new SimpleXMLElement($cs_team);
                                }
                                $noimg = '';
                                $image_url = cs_attachment_image_src( get_post_thumbnail_id($post->ID),$width,$height ); 
                               if($image_url == ''){
										$noimg = 'no-img';
									}else{
										$noimg  ='post-img';
									}
                            ?>
                                <article class="<?php echo $team_view; ?>">
                                    <figure class="<?php echo $noimg;?>">
                                        <img src="<?php echo $image_url;?>" alt="">
                                        <figcaption>
                                            <h2 class="cs-post-title"><?php the_title();?></h2>
                                            <div class="cs-lead-sec">
                                                <p><a><?php $cs_xmlObject_team->var_cp_expertise; ?></a></p>
                                                <i class="fa fa-plus"></i>
                                            </div>
											<p><?php echo $cs_xmlObject_team->var_cp_about;?></p>
                                        </figcaption> 
                                        <div class="social-network">
											<?php foreach ( $cs_xmlObject_team->social as $social ){
                                                    $image_icon = '';
                                                        $filetype = wp_check_filetype($social->var_cp_image_url);
                                                        if($filetype['ext']=='jpg' || $filetype['ext']=='png' || $filetype['ext']=='gif' || $filetype['ext']=='ico' || $filetype['ext']=='JPEG'){
                                                            $image_icon = 'Yes';
                                                        }
                                                ?>
                                                    <a href="<?php echo $social->var_cp_url;?>"><?php if($image_icon == 'Yes'){echo '<img src="'.$social->var_cp_image_url.'" alt=""';} else {?>  <em class="fa <?php echo $social->var_cp_image_url;?>"></em><?php }?></a>
                                            <?php }?>
                                        </div>   
                                    </figure>
                                </article>
                         <?php endwhile; wp_reset_query();?>
                         
                         <?php 
						 if($cs_node->var_pb_team_view == 'home_view'){
						 ?>
                         </div>
                         <?php
						 }
						 ?>
					</div>
                    <?php }?>
                  <!-- Our Classes Close -->
					<?php 
                    //<!-- Pagination -->
                    if ($cs_node->var_pb_team_pagination == "Show Pagination" and $cs_node->var_pb_team_view <> 'home_view' ) {
                        $qrystr = '';
                        if(cs_pagination($count_post, $cs_node->var_pb_team_per_page, $qrystr) <> ''){
                            // pagination start
                            if ( $cs_node->var_pb_team_pagination == "Show Pagination" and $cs_node->var_pb_team_per_page > 0 ) {
                                    if ( isset($_GET['page_id']) ) $qrystr = "&page_id=".$_GET['page_id'];
                                    if ( isset($_GET['filter_category']) ) $qrystr .= "&filter_category=".$_GET['filter_category'];
                                    echo cs_pagination($count_post, $cs_node->var_pb_team_per_page, $qrystr);
                                }
                     // pagination end
                        }
                    }
					
					
			?>
</div>