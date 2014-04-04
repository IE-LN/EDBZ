<?php
	global $cs_node, $cs_theme_option, $counter_node;
	if ( !isset($cs_node->cs_album_per_page) || empty($cs_node->cs_album_per_page) ) { $cs_node->cs_album_per_page = -1; }
	$filter_category = '';
	$row_cat = $wpdb->get_row("SELECT * from ".$wpdb->prefix."terms WHERE slug = '" . $cs_node->cs_album_cat ."'" );
	        if ( isset($_GET['filter_category']) ) {$filter_category = $_GET['filter_category'];}
        else {
            if(isset($row_cat->slug)){
            $filter_category = $row_cat->slug;
            }
        }
		 if ( empty($_GET['page_id_all']) ) $_GET['page_id_all'] = 1;
				$args = array(
					'posts_per_page'			=> "-1",
					'post_type'					=> 'albums',
					'post_status'				=> 'publish',
					'order'						=> 'ASC',
				);
			if(isset($filter_category) && $filter_category <> '' && $filter_category <> '0'){
				$event_category_array = array('album-category' => "$filter_category");
				$args = array_merge($args, $event_category_array);
			}
			$custom_query = new WP_Query($args);
			$count_post = 0;
			$count_post = $custom_query->post_count;
?>
 <script type="text/javascript">
    jQuery(document).ready(function($){
        jQuery('.icon-btn').tooltip();
    });
</script>

<div class="element_size_<?php echo $cs_node->album_element_size;?>">
 <div class="<?php if($cs_node->cs_album_view == 'Grid View'){ echo 'new-releases album-grid-view-four';} else if($cs_node->cs_album_view == 'List View') { echo 'event albums-list';}  else if($cs_node->cs_album_view == 'single_view') { echo 'new-releases single-view';} else { echo 'new-releases';}?>">
 <?php if ($cs_node->cs_album_title <> '' || $cs_node->cs_album_filterable == "On") {?>
     <header class="cs-heading-title">
        <?php if ($cs_node->cs_album_title <> '') { ?><h2 class="cs-section-title cs-heading-color"><?php echo $cs_node->cs_album_title;?></h2>
        <?php if($cs_node->cs_album_filterable == "On" && $cs_node->cs_album_view == 'Grid View'){
                            $qrystr= "";
                            if ( isset($_GET['page_id']) ) $qrystr = "&page_id=".$_GET['page_id'];
                        ?>  
                        <div class="sortby">
                            <ul>
                                <li><a href="<?php the_permalink();?>"><?php _e('All', 'Soundblast');?></a></li>
                                <?php  if($cs_node->cs_album_cat <> ''  && $cs_node->cs_album_cat <> '0'){
									$categories = get_categories( array('child_of' => "$row_cat->term_id", 'taxonomy' => 'album-category', 'hide_empty' => 0) );
								} else {
									$categories = get_categories( array('taxonomy' => 'album-category', 'hide_empty' => 0) );
								}
								foreach ($categories as $category) {?>
								<li <?php if($category->slug==$filter_category){echo 'class="active"';}?>><a href="?<?php echo $qrystr."&filter_category=".$category->slug?>"><?php echo $category->cat_name?></a></li>
                                <?php }?>
							</ul>
                	</div>
                    <?php }?>
        
    </header>
 
 <?php 
	}}
 if($cs_node->cs_album_view == 'Grid View'){
 	$args = array(
				'posts_per_page'			=> "$cs_node->cs_album_per_page",
				'paged'						=> $_GET['page_id_all'],
				'post_type'					=> 'albums',
				'post_status'				=> 'publish',
				'order'						=> 'ASC',
			 );
			if(isset($filter_category) && $filter_category <> '' && $filter_category <> '0'){
				$event_category_array = array('album-category' => "$filter_category");
				$args = array_merge($args, $event_category_array);
			}
			$custom_query = new WP_Query($args);
			if ( $custom_query->have_posts() <> "" ):
 	  	$width = 330; 
		$height = 330;
		$counter_album = $counter_count = 0;
		echo "<div class='cs-minus'>";
		while ( $custom_query->have_posts() ): $custom_query->the_post();
		$cs_album = get_post_meta($post->ID, "cs_album", true);
		if ( $cs_album <> "" ) {
			$counter_album_tracks = 0;
			$album_track_mp3_url_audio = '';
			$cs_xmlObject = new SimpleXMLElement($cs_album);
				$album_release_date_db = $cs_xmlObject->album_release_date;
				$album_buynow = $cs_xmlObject->album_buynow;
				
				$counter_album_tracks = count($cs_xmlObject->track);
		}
		$image_url = cs_attachment_image_src( get_post_thumbnail_id($post->ID),$width,$height ); 
		if($image_url == ''){
			$noimg = 'no-img';
		}else{
			$noimg  ='';
		}
 ?>
        <article <?php post_class($noimg);?> style="position:relative;">
            <figure>
                <a href="<?php the_permalink();?>"><?php if($image_url <> ''){?><img src="<?php echo $image_url;?>" alt=""><?php }?></a>
            </figure>
            <div class="text webkit">
                <h2 class="cs-post-title cs-heading-color"><a class="colrhover" href="<?php the_permalink();?>"><?php echo substr(get_the_title(), 0, 33); if(strlen(get_the_title())>33) echo '...'; ?></a></h2>
                <div class="album_heading">
                
                <time class="date-time"><span> <?php if($cs_theme_option['trans_switcher'] == "on"){ _e('Released:','Soundblast');}else{ echo $cs_theme_option['trans_album_release_date']; } ?>: </span><?php echo date('d F, Y', strtotime($cs_xmlObject->album_release_date));?></time>
                	
                <div class="social-area">
                	<?php if($cs_xmlObject->album_price <> ""){ ?>
					<a href="<?php echo $cs_xmlObject->album_buynow;?>"><span class="album-price"><?php echo $cs_xmlObject->album_price;?></span></a>
                    <?php } ?>
                    <ul>
                    	<li><a class="colrhover"><i class="fa fa-music"></i> <?php echo $counter_album_tracks; ?></a></li>
                        <li>
                        <?php
						$cs_like_counter = '0';
						$cs_like_counter = get_post_meta(get_the_id(), "cs_like_counter", true);
						if ( !isset($cs_like_counter) or empty($cs_like_counter) ) { $cs_like_counter = 0; }
						if ( isset($_COOKIE["cs_like_counter".get_the_id()]) ) { 
						
					?>
						   <a class="colrhover"><i class="fa fa-heart"></i></a><?php echo $cs_like_counter; ?>
					<?php	
						} else { ?>
						  <a href="javascript:cs_like_counter('<?php echo get_template_directory_uri()?>',<?php echo get_the_id()?>)" id="like_this<?php echo get_the_id()?>" ><i class="fa fa-heart"></i><?php echo $cs_like_counter; ?></a>
							<a class="likes" id="you_liked<?php echo get_the_id()?>" style="display:none;"><i class="fa fa-heart"></i><p class="count-numbers like_counter<?php echo get_the_id()?>"><?php echo $cs_like_counter; ?></p></a>
							<div id="loading_div<?php echo get_the_id()?>" style="display:none;"><i class="fa fa-spinner fa-spin"></i></div>
					<?php } ?>
                    </li>
                    </ul>
                </div>
                </div>
            </div>
        </article>
        <?php endwhile; endif;
		echo "</div>";
 } else if($cs_node->cs_album_view == 'home_view') {
	 cs_cycleslider_script();
	 ?>
        <div class="center">
            <a id="prev<?php echo $counter_node;?>" href="#" class="prev-btn"><i class="fa fa-angle-left fa-1x"></i></a>
            <a id="next<?php echo $counter_node;?>" href="#" class="next-btn"><i class="fa fa-angle-right fa-1x"></i></a>
        </div>
        <div class="cycle-slideshow"
        data-cycle-timeout=40000
        data-cycle-fx=carousel
        data-cycle-slides="article"
        data-cycle-carousel-fluid="false"
        data-allow-wrap="true"
            data-cycle-next="#next<?php echo $counter_node;?>"
            data-cycle-prev="#prev<?php echo $counter_node;?>">
    <?php    $args = array(
				'posts_per_page'			=> "$cs_node->cs_album_per_page",
				'paged'						=> $_GET['page_id_all'],
				'post_type'					=> 'albums',
				'post_status'				=> 'publish',
				'order'						=> 'ASC',
			 );
			if(isset($filter_category) && $filter_category <> '' && $filter_category <> '0'){
				$event_category_array = array('album-category' => "$filter_category");
				$args = array_merge($args, $event_category_array);
			}
			$custom_query = new WP_Query($args);
			if ( $custom_query->have_posts() <> "" ):
 	  	$width = 330; 
		$height = 330;
		$counter_album = $counter_count = 0;
		while ( $custom_query->have_posts() ): $custom_query->the_post();
		$cs_album = get_post_meta($post->ID, "cs_album", true);
		if ( $cs_album <> "" ) {
			$counter_album_tracks = 0;
			$album_track_mp3_url_audio = '';
			$cs_xmlObject = new SimpleXMLElement($cs_album);
				$album_release_date_db = $cs_xmlObject->album_release_date;
				$album_buynow = $cs_xmlObject->album_buynow;
		}
		$image_url = cs_attachment_image_src( get_post_thumbnail_id($post->ID),$width,$height ); 
		if($image_url == ''){
			$noimg = 'no-img';
		}else{
			$noimg  ='';
		}
 ?>
        <article <?php post_class($noimg);?> style="position:relative;">
            <figure>
                <a href="<?php the_permalink();?>"><?php if($image_url <> ''){?><img src="<?php echo $image_url;?>" alt=""><?php }?></a>
            </figure>
            <div class="text webkit">
                <h2 class="cs-post-title cs-heading-color"><a class="colrhover" href="<?php the_permalink();?>"><?php echo substr(get_the_title(), 0, 33); if(strlen(get_the_title())>33) echo '...'; ?></a></h2>
                <div class="album_heading">
                
                <time class="date-time"><span> <?php if($cs_theme_option['trans_switcher'] == "on"){ _e('Released:','Soundblast');}else{ echo $cs_theme_option['trans_album_release_date']; } ?>: </span><?php echo date('d F, Y', strtotime($cs_xmlObject->album_release_date));?></time>
                	
                <div class="social-area">
                	<?php if($cs_xmlObject->album_price <> ""){ ?>
					<a href="<?php echo $cs_xmlObject->album_buynow;?>"><span class="album-price"><?php echo $cs_xmlObject->album_price;?></span></a>
                    <?php } ?>
                    <ul>
                    	<li><a class="colrhover"><i class="fa fa-music"></i> <?php echo $counter_album_tracks; ?></a></li>
                        <li>
                        <?php
							$cs_like_counter = '0';
							$cs_like_counter = get_post_meta(get_the_id(), "cs_like_counter", true);
							if ( !isset($cs_like_counter) or empty($cs_like_counter) ) { $cs_like_counter = 0; }
							if ( isset($_COOKIE["cs_like_counter".get_the_id()]) ) { 
							
						?>
							   <a class="colrhover"><i class="fa fa-heart"></i></a><?php echo $cs_like_counter; ?>
						<?php	
							} else { ?>
							  <a href="javascript:cs_like_counter('<?php echo get_template_directory_uri()?>',<?php echo get_the_id()?>)" id="like_this<?php echo get_the_id()?>" ><i class="fa fa-heart"></i><?php echo $cs_like_counter; ?></a>
								<a class="likes" id="you_liked<?php echo get_the_id()?>" style="display:none;"><i class="fa fa-heart"></i><p class="count-numbers like_counter<?php echo get_the_id()?>"><?php echo $cs_like_counter; ?></p></a>
								<div id="loading_div<?php echo get_the_id()?>" style="display:none;"><i class="fa fa-spinner fa-spin"></i></div>
						<?php } ?>
						</li>
                        
                    </ul>
                </div>
                </div>
            </div>
        </article>
        <?php endwhile; endif;?>
    </div>
 	
 <?php }
 else if($cs_node->cs_album_view == 'single_view') {
	   $args = array(
				'posts_per_page'			=> "$cs_node->cs_album_per_page",
				'paged'						=> $_GET['page_id_all'],
				'post_type'					=> 'albums',
				'post_status'				=> 'publish',
				'order'						=> 'ASC',
			 );
		$custom_query = new WP_Query($args);
		if ( $custom_query->have_posts() <> "" ):
 	  	$width = 330; 
		$height = 330;
		$counter_album = $counter_count = 0;
		echo "<div class='cs-minus'>";
		while ( $custom_query->have_posts() ): $custom_query->the_post();
		$cs_album = get_post_meta($post->ID, "cs_album", true);
		if ( $cs_album <> "" ) {
			$counter_album_tracks = 0;
			$album_track_mp3_url_audio = '';
			$cs_xmlObject = new SimpleXMLElement($cs_album);
				$album_release_date_db = $cs_xmlObject->album_release_date;
				$album_buynow = $cs_xmlObject->album_buynow;
		}
		$image_url = cs_attachment_image_src( get_post_thumbnail_id($post->ID),$width,$height ); 
		if($image_url == ''){
			$noimg = 'no-img';
		}else{
			$noimg  ='';
		}
 ?>
        <article <?php post_class($noimg);?> style="position:relative;">
            <figure>
                <a href="<?php the_permalink();?>"><?php if($image_url <> ''){?><img src="<?php echo $image_url;?>" alt=""><?php }?></a>
            </figure>
            <div class="text webkit">
                <h2 class="cs-post-title cs-heading-color"><a class="colrhover" href="<?php the_permalink();?>"><?php echo substr(get_the_title(), 0, 33); if(strlen(get_the_title())>33) echo '...'; ?></a></h2>
                <div class="album_heading">
               
                	
                <div class="social-area">
					<?php if($cs_xmlObject->album_price <> ""){ ?>
					<a href="<?php echo $cs_xmlObject->album_buynow;?>"><span class="album-price"><?php echo $cs_xmlObject->album_price;?></span></a>
                    <?php } ?>
                    <ul>
                    	<li><a class="colrhover"><i class="fa fa-music"></i> <?php echo $counter_album_tracks; ?></a></li>
                        <li>
                        <?php
							$cs_like_counter = '0';
							$cs_like_counter = get_post_meta(get_the_id(), "cs_like_counter", true);
							if ( !isset($cs_like_counter) or empty($cs_like_counter) ) { $cs_like_counter = 0; }
							if ( isset($_COOKIE["cs_like_counter".get_the_id()]) ) { 
							
						?>
							   <a class="colrhover"><i class="fa fa-heart"></i></a><?php echo $cs_like_counter; ?>
						<?php	
							} else { ?>
							  <a href="javascript:cs_like_counter('<?php echo get_template_directory_uri()?>',<?php echo get_the_id()?>)" id="like_this<?php echo get_the_id()?>" ><i class="fa fa-heart"></i><?php echo $cs_like_counter; ?></a>
								<a class="likes" id="you_liked<?php echo get_the_id()?>" style="display:none;"><i class="fa fa-heart"></i><p class="count-numbers like_counter<?php echo get_the_id()?>"><?php echo $cs_like_counter; ?></p></a>
								<div id="loading_div<?php echo get_the_id()?>" style="display:none;"><i class="fa fa-spinner fa-spin"></i></div>
						<?php } ?>
						</li>
                    </ul>
                </div>
                </div>
            </div>
        </article>
        <?php endwhile; endif;
		echo "</div>";
 }
 else {
	$args = array(
				'posts_per_page'			=> "$cs_node->cs_album_per_page",
				'paged'						=> $_GET['page_id_all'],
				'post_type'					=> 'albums',
				'post_status'				=> 'publish',
				'order'						=> 'ASC',
			 );
			if(isset($filter_category) && $filter_category <> '' && $filter_category <> '0'){
				$event_category_array = array('album-category' => "$filter_category");
				$args = array_merge($args, $event_category_array);
			}
			$custom_query = new WP_Query($args);
		if ( $custom_query->have_posts() <> "" ):
 	  	$width = 150; 
		$height = 150;
		$counter_album = $counter_count = 0;
		while ( $custom_query->have_posts() ): $custom_query->the_post();
		$cs_album = get_post_meta($post->ID, "cs_album", true);
		if ( $cs_album <> "" ) {
			$counter_album_tracks = 0;
			$album_track_mp3_url_audio = '';
			$cs_xmlObject = new SimpleXMLElement($cs_album);
				$album_release_date_db = $cs_xmlObject->album_release_date;
				$album_buynow = $cs_xmlObject->album_buynow;
		}
		$image_url = cs_attachment_image_src( get_post_thumbnail_id($post->ID),$width,$height ); 
		if($image_url == ''){
			$noimg = 'no-img';
		}else{
			$noimg  ='';
		}
	 ?>
 	<article <?php post_class($noimg);?>>
        <div class="event-inn">
            <figure><a href="<?php the_permalink();?>"><img src="<?php echo $image_url;?>" alt=""></a></figure>
            <div class="text">
               <h2 class="cs-post-title cs-heading-color"><a class="colrhover" href="<?php the_permalink();?>"><?php echo substr(get_the_title(), 0, 33); if(strlen(get_the_title())>33) echo '...'; ?></a></h2>
                <ul>
                    <?php if($album_release_date_db <> ''){?><li><span><?php if($cs_theme_option['trans_switcher'] == "on"){ _e('Released Date','Soundblast');}else{ echo $cs_theme_option['trans_album_release_date']; } ?> :</span> <?php echo date('d F, Y', strtotime($cs_xmlObject->album_release_date));?></li><?php } ?>
                    <?php if($cs_xmlObject->album_buy_amazon <> '' or $cs_xmlObject->album_buy_apple <> '' or $cs_xmlObject->album_buy_groov <> '' or $cs_xmlObject->album_buy_cloud <> ''){?>
                    <li><span><?php if($cs_theme_option['trans_switcher'] == "on"){ _e('Available on','Soundblast');}else{ echo $cs_theme_option['trans_album_available']; } ?> :</span>
                    	<?php
						$cs_alb_amzon = "";
						$cs_alb_itune = "";
						$cs_alb_grove = "";
						$cs_alb_scloud = "";
						if($cs_theme_option['trans_switcher'] == "on"){ $cs_alb_amzon = __('Amazon','Soundblast');}else{ $cs_alb_amzon = $cs_theme_option['trans_album_amazon']; }
						if($cs_theme_option['trans_switcher'] == "on"){ $cs_alb_itune = __('Itunes','Soundblast');}else{ $cs_alb_itune = $cs_theme_option['trans_album_itunes']; }
						if($cs_theme_option['trans_switcher'] == "on"){ $cs_alb_grove = __('Grooveshark','Soundblast');}else{ $cs_alb_grove = $cs_theme_option['trans_album_groove']; }
						if($cs_theme_option['trans_switcher'] == "on"){ $cs_alb_scloud = __('Soundcloud','Soundblast');}else{ $cs_alb_scloud = $cs_theme_option['trans_album_soundc']; }
						?> 
                        <?php if($cs_xmlObject->album_buy_amazon <> ''){?><a title="" data-placement="top" data-toggle="tooltip" data-original-title="<?php echo $cs_alb_amzon; ?>" class="icon-btn" href="<?php echo $cs_xmlObject->album_buy_amazon;?>"></a><?php }?>
                        <?php if($cs_xmlObject->album_buy_apple <> ''){?><a title="" data-placement="top" data-toggle="tooltip" data-original-title="<?php echo $cs_alb_itune; ?>" class="icon-btn icon-btn-2" href="<?php echo $cs_xmlObject->album_buy_apple;?>"></a><?php }?>
                        <?php if($cs_xmlObject->album_buy_groov <> ''){?><a title="" data-placement="top" data-toggle="tooltip" data-original-title="<?php echo $cs_alb_grove; ?>" class="icon-btn icon-btn-3" href="<?php echo $cs_xmlObject->album_buy_groov;?>"></a><?php }?>
                        <?php if($cs_xmlObject->album_buy_cloud <> ''){?><a title="" data-placement="top" data-toggle="tooltip" data-original-title="<?php echo $cs_alb_scloud; ?>" class="icon-btn icon-btn-4" href="<?php echo $cs_xmlObject->album_buy_cloud;?>"></a><?php }?>
                    </li>
                    <?php } ?>
                </ul>
               <?php if($album_buynow <> ''){?> <a href="<?php echo $album_buynow;?>" class="bay-btn uppercase"><?php if($cs_theme_option['trans_switcher'] == "on"){ _e('Buy Now','Soundblast');}else{ echo $cs_theme_option['trans_album_buynow']; } ?></a><?php }?>
                <a class="play-icon" href="<?php the_permalink();?>"><i class="fa fa-play fa-2x"></i></a>
            </div>
        </div>
    </article>
<?php 
 endwhile; endif;
}?>
</div>
<?php 
	//<!-- Pagination -->
	if ($cs_node->cs_album_pagination == "Show Pagination" && $cs_node->cs_album_view <> 'home_view' ) {
		$qrystr = '';
		if(cs_pagination($count_post, $cs_node->cs_album_per_page, $qrystr) <> ''){
			// pagination start
			if ( $cs_node->cs_album_pagination == "Show Pagination" and $cs_node->cs_album_per_page > 0 ) {
					if ( isset($_GET['page_id']) ) $qrystr = "&page_id=".$_GET['page_id'];
					if ( isset($_GET['filter_category']) ) $qrystr .= "&filter_category=".$_GET['filter_category'];
					echo cs_pagination($count_post, $cs_node->cs_album_per_page, $qrystr);
				}
	 // pagination end
		}
	}
	?>
</div>	