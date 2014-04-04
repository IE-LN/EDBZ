<?php
	global $cs_node,$post,$cs_theme_option,$counter_node,$wpdb;
	if ( !isset($cs_node->cs_gal_album_media_per_page) || empty($cs_node->cs_gal_album_media_per_page) ) { $cs_node->cs_gal_album_media_per_page = -1; }
	if (empty($_GET['page_id_all'])) $_GET['page_id_all'] = 1;
	$args = array('posts_per_page' => "-1", 'paged' => $_GET['page_id_all'], 'post_type' => 'cs_gallery', 'category_name' => "$cs_node->cs_gal_album",'post_status' => 'publish');
	$custom_query = new WP_Query($args);
	$post_count = $custom_query->post_count;
	$args = array('posts_per_page' => "$cs_node->cs_gal_album_media_per_page", 'post_type' => 'cs_gallery', 'paged' => $_GET['page_id_all'], 'cs_gallery-category' => "$cs_node->cs_gal_album");
     $custom_query = new WP_Query($args);
	 ?>
	 <div class=" element_size_<?php echo $cs_node->cs_gallery_album_element_size;?>">
       <!-- Latest Video Start -->
        <div class="latest-video">
        	 <?php if($cs_node->cs_gal_album_header_title <> ''){?><header class="cs-heading-title"><h2 class="cs-section-title cs-heading-color"><?php echo $cs_node->cs_gal_album_header_title;?></h2></header><?php }?>
             
             <?php if($cs_node->cs_gal_album_view_title <> '' AND $cs_node->cs_gal_album_view_url <> '' ){?><a href="<?php echo $cs_node->cs_gal_album_view_url;?>" class="view-all"><?php echo $cs_node->cs_gal_album_view_title;?></a><?php }?>
            <!-- Minus Column Start -->
            <div class="minus-column">
            <?php if($custom_query->have_posts()):
				$qrystr= "";
				$width 	=230;
				$height	=172;
				
                if ( isset($_GET['page_id']) ) $qrystr = "&page_id=".$_GET['page_id'];
				while ($custom_query->have_posts()) : $custom_query->the_post();
				$pos_class = '';
				$image_url = cs_attachment_image_src(get_post_thumbnail_id($post->ID),$width,$height);
				if($image_url == ''){$image_url = get_template_directory_uri().'/images/default-video-set.jpg';}
				?>
                <article <?php post_class($pos_class); ?>>
                    <figure ><a <?php if(isset($pos_class) && $pos_class <> ''){echo 'class="'.$pos_class.'"';}?> href="<?php the_permalink();?>"><img src="<?php echo $image_url;?>" alt=""></a>
                        <figcaption>
                        <h2 class="cs-post-title cs-heading-color"><a href="<?php the_permalink();?>"><?php the_title();?></a></h2>
                        <time datetime="2008-02-14"><?php echo get_the_date();?></time>
                        </figcaption>
                    </figure>
                </article>
                <?php endwhile; endif;?>
            </div>
            <!-- Minus Column End -->
        </div>
         <?php
		// pagination start
		$qrystr = '';
		 if ( $cs_node->cs_gal_album_pagination == "Show Pagination" and $post_count > $cs_node->cs_gal_album_media_per_page and $cs_node->cs_gal_album_media_per_page > 0 ) {
				$qrystr = '';
				if ( isset($_GET['page_id']) ) $qrystr = "&page_id=".$_GET['page_id'];						
			echo cs_pagination( $count_post, $cs_node->cs_gal_album_media_per_page,$qrystr );
		}
		// pagination end
		?>
      <!-- Latest Video End -->
      <div class="clear"></div>
	</div>      
                  