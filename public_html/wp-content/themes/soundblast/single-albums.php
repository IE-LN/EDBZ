<?php
get_header();
	global $cs_node, $cs_theme_option, $video_width;
	$cs_layout = '';
	$counter_album_tracks = 0;
	$counter_load_tracks = 0;
 if ( have_posts() ) :
while ( have_posts() ) : the_post();
 	$cs_album = get_post_meta($post->ID, "cs_album", true);
	if ( $cs_album <> "" ) {
		$cs_xmlObject = new SimpleXMLElement($cs_album);
  		$cs_layout = $cs_xmlObject->sidebar_layout->cs_layout;
		$cs_sidebar_left = $cs_xmlObject->sidebar_layout->cs_sidebar_left;
		$cs_sidebar_right = $cs_xmlObject->sidebar_layout->cs_sidebar_right;
		$counter_album_tracks = count($cs_xmlObject->track);
		if ( $cs_layout == "left") {
			$cs_layout = "content-right col-lg-9 col-md-9";
 		}
		else if ( $cs_layout == "right" ) {
			$cs_layout = "content-left col-lg-9 col-md-9";
 		}elseif( $cs_layout == "both_right" ){
			$cs_layout = "content-left col-lg-6 col-md-6";
		}
		elseif( $cs_layout == "both_left" ){
			$cs_layout = "content-right col-lg-6 col-md-6";
		}
		elseif( $cs_layout == "both" ){
			$cs_layout = "col-lg-6 col-md-6";
		}
		else {
			$cs_layout = "col-lg-12 col-md-12";
		}
  	}
	$width = 330;
	$height = 330;
	$image_id = cs_get_post_img($post->ID, $width,$height);
	
	$col_md_class = "col-md-8";
	
	if($image_id == ''){
		$col_md_class = "col-md-12";
	}
	?>
    <?php if ($cs_layout == 'content-right col-lg-9 col-md-9'){ ?>
        <div class="col-md-3 col-sm-3"><?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar($cs_sidebar_left) ) : ?><?php endif; ?></div>
    <?php wp_reset_query();}?>
    <div class="<?php echo $cs_layout;?>">

	<!-- Col-Md-4 Start -->
        <div class="detail-cover-style">
            <figure><?php if($image_id <> ''){echo $image_id;} else { echo '<img src="'.get_template_directory_uri().'/images/Dummy.jpg" height="314" width="314" alt="'.get_the_title().'">';}?></figure>
            <?php if($cs_xmlObject->sidebar_layout->cs_layout == 'none' || $cs_xmlObject->sidebar_layout->cs_layout == ''){?>
                <ul class="post-options">
                    <?php 
                        $before_cat = "<li>".__( 'Gener: ','Soundblast')."<span class='cs-album-cat'>";
                        $categories_list = get_the_term_list ( get_the_id(), 'album-category', $before_cat, ', ', '</span></li>' );
                        if ( $categories_list ){ printf( __( '%1$s', 'Soundblast' ),$categories_list ); }
                    ?>
                   <?php if($cs_xmlObject->album_release_date <> ''){?> <li><?php if($cs_theme_option['trans_switcher'] == "on"){ _e('Released:','Soundblast');}else{ echo $cs_theme_option['trans_album_release_date']; } ?>: <?php echo date("d F, Y",strtotime($cs_xmlObject->album_release_date)); ?></li><?php }?>
                    <li><?php if($cs_xmlObject->album_label <> ''){?><li><?php if($cs_theme_option['trans_switcher'] == "on"){ _e('Label','Soundblast');}else{ echo $cs_theme_option['trans_album_label']; } ?> : <?php echo $cs_xmlObject->album_label;?></li><?php }?></li>
                </ul>
                <?php if($cs_xmlObject->album_price <> ''){ ?>
            	<a href="<?php echo $cs_xmlObject->album_buynow;?>" class="bay-album webkit"><i class="fa fa-shopping-cart"></i><span><?php echo $cs_xmlObject->album_price;?></span></a>
            	<?php } ?>    
            <?php } ?>
        </div>

    <!-- Col-Md-4 End -->
    <div class="cs-album-right-side">
    
        <article class="album-detail-sec">
                   <?php if($cs_xmlObject->album_tracks_title <> ''){?> <header class="cs-heading-title"><h2 class="cs-section-title cs-heading-color"><?php echo $cs_xmlObject->album_tracks_title;?></h2></header><?php }?>
            <ul class="post-options">
               <li> 
               <?php 
					if ($cs_xmlObject->var_cp_trainer <> ''){
						_e( 'By:','Soundblast');
						$var_cp_trainer = explode(",", $cs_xmlObject->var_cp_trainer);
						$num_trainers = count($var_cp_trainer);
						$i = 0;
						foreach($var_cp_trainer as $var_trainer_id){
							if(++$i === $num_trainers) {
							?>
                            <a><?php echo get_the_title($var_trainer_id); ?></a>
							<?php 
							}else{
							?>
                            <a><?php echo get_the_title($var_trainer_id); ?></a>,&nbsp;
							<?php 	
							}
						}
					}
				?>  
               
               </li>
                <li><i class="fa fa-music"></i> <?php echo $counter_album_tracks; ?> <?php if($cs_theme_option['trans_switcher'] == "on"){ _e('Tracks','Soundblast');}else{ echo $cs_theme_option['trans_album_tracks']; } ?> </li>
                <li>
                <?php
					$cs_like_counter = '0';
					$cs_like_counter = get_post_meta(get_the_id(), "cs_like_counter", true);
					if ( !isset($cs_like_counter) or empty($cs_like_counter) ) { $cs_like_counter = 0; }
					if ( isset($_COOKIE["cs_like_counter".get_the_id()]) ) { 
				?>
					   <a class="colrhover likes"><i class="fa fa-heart"></i></a><?php echo $cs_like_counter; ?> <?php if($cs_theme_option['trans_switcher'] == "on"){ _e('Likes','Soundblast');}else{ echo $cs_theme_option['trans_album_likes']; } ?>
				<?php	
					} else { ?>
					  <a href="javascript:cs_like_counter('<?php echo get_template_directory_uri()?>',<?php echo get_the_id()?>)" id="like_this<?php echo get_the_id()?>" ><i class="fa fa-heart"></i> <?php echo $cs_like_counter; ?> <?php if($cs_theme_option['trans_switcher'] == "on"){ _e('Likes','Soundblast');}else{ echo $cs_theme_option['trans_album_likes']; } ?></a>
						<a class="likes" id="you_liked<?php echo get_the_id()?>" style="display:none;"><i class="fa fa-heart"></i><span class="count-numbers like_counter<?php echo get_the_id()?>"><?php echo $cs_like_counter; ?></span> <?php if($cs_theme_option['trans_switcher'] == "on"){ _e('Likes','Soundblast');}else{ echo $cs_theme_option['trans_album_likes']; } ?></a>
						<div id="loading_div<?php echo get_the_id()?>" style="display:none;"><i class="fa fa-spinner fa-spin"></i></div>
				<?php } ?>
				</li>
                
            </ul>
			<?php if($cs_xmlObject->sidebar_layout->cs_layout <> 'none' && $cs_xmlObject->sidebar_layout->cs_layout <> ''){?>
                			<ul class="post-options post-options-sidebar">
                    <?php 
                        $before_cat = "<li>".__( 'Gener: ','Soundblast')."<span class='cs-album-cat'>";
                        $categories_list = get_the_term_list ( get_the_id(), 'album-category', $before_cat, ', ', '</span></li>' );
                        if ( $categories_list ){ printf( __( '%1$s', 'Soundblast' ),$categories_list ); }
                    ?>
                   <?php if($cs_xmlObject->album_release_date <> ''){?> <li><?php if($cs_theme_option['trans_switcher'] == "on"){ _e('Released:','Soundblast');}else{ echo $cs_theme_option['trans_album_release_date']; } ?>: <?php echo $cs_xmlObject->album_release_date; ?></li><?php }?>
                    <li><?php if($cs_xmlObject->album_label <> ''){?><li><?php if($cs_theme_option['trans_switcher'] == "on"){ _e('Label','Soundblast');}else{ echo $cs_theme_option['trans_album_label']; } ?> : <?php echo $cs_xmlObject->album_label;?></li><?php }?></li>
                </ul>
            	<a href="<?php echo $cs_xmlObject->album_buynow;?>" class="bay-album webkit"><i class="fa fa-shopping-cart"></i><?php if($cs_xmlObject->album_price <> ''){?><span><?php echo $cs_xmlObject->album_price;?></span><?php }?></a>
                	
                <?php } ?>
            
            
           
        </article>
        
         <?php
			 $counter_load_tracks = count($cs_xmlObject->track);
			 if($counter_load_tracks >0){
			 $playtracks = '';
			 cs_enqueue_jplayer();
			 	 foreach ( $cs_xmlObject->track as $track ){
							$filetype = wp_check_filetype($track->album_track_mp3_url);
							if(isset($track->album_track_playable) && $track->album_track_playable == 'Yes' && $filetype['ext'] == 'mp3'){
								$counter_load_tracks++;
								$playtracks .= '{
											title:"'.$track->album_track_title.'",
											appstore:"'.$cs_xmlObject->album_buy_apple.'",
											grvstore:"'.$cs_xmlObject->album_buy_groov.'",
											soundcloud:"'.$cs_xmlObject->album_buy_cloud.'",
											mp3:"'.$track->album_track_mp3_url.'",
											url:"'.$track->album_track_buy_mp3.'"
										},';
							}
			 	}
			?>
            <script>
					jQuery(document).ready(function($) {
						 var myPlaylist2 = new jPlayerPlaylist({
								jPlayer: "#jquery_jplayer_1",
								cssSelectorAncestor: "#jp_container_1"
							}, [
								<?php echo $playtracks;?>
							], {
								swfPath: "<?php echo get_template_directory_uri();?>/scripts/frontend/Jplayer.swf",
								supplied: "oga, mp3",
								wmode: "window",
								currentTime: '.jp-current-time',
								smoothPlayBar: true,
								displayTime: 'slow',
								keyEnabled: true
						});
				        jQuery("#jp_container_1").css("opacity",1)

					});
			</script>
            
                <div class="album-detail fullwidth">
                    <div class="audio-plyer">
                        <div id="jquery_jplayer_1" class="jp-jplayer "></div>
                        <div id="jp_container_1" class="jp-audio" style="opacity:0">
                            <div class="jp-type-playlist">
                                <div class="jp-gui">
                                    <div class="jp-interface">
                                        <div class="jp-controls-holder">
                                            <ul class="jp-controls audio-control">
                                                <li>
                                                    <a href="javascript:;" class="jp-previous" tabindex="1"> <em class="fa fa-step-backward"></em>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:;" class="jp-play" tabindex="1"> <em class="fa fa-play"></em>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:;" class="jp-pause" tabindex="1">
                                                        <em class="fa fa-pause"></em>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:;" class="jp-next" tabindex="1">
                                                        <em class="fa fa-step-forward"></em>
                                                    </a>
                                                </li>
                                            </ul>
                                            <div class="volume-wrap">
                                                <ul class="jp-controls">
                                                    <li>
                                                        <a title="mute" tabindex="1" class="jp-mute" href="javascript:;"> <em class="fa fa-volume-up"></em>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a title="unmute" tabindex="1" class="jp-unmute" href="javascript:;" style="display: none;"> <em class="fa fa-volume-down"></em>
                                                        </a>
                                                    </li>
                                                </ul>
                                                <div class="vbtop">
                                                    <a href="javascript:;">
                                                        <em class="fa fa-volume-off"></em>
                                                    </a>
                                                    <div class="jp-volume-bar">
    
                                                        <div class="jp-volume-bar-value bgcolr"></div>
    
                                                    </div>
                                                    <a href="javascript:;">
                                                        <em class="fa fa-volume-up"></em>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="jp-play-wrap">
                                                <div class="fullwidth">
                                                    <div class="jp-title gallery">
                                                        <ul>
                                                            <li></li>
                                                        </ul>
                                                    </div>
                                                    <div class="jp-current-time float-right"></div>
                                                </div>
                                                <div class="jp-progress">
                                                    <div class="jp-seek-bar">
                                                        <div class="jp-play-bar bgcolr"></div>
                                                    </div>
                                                </div>
                                                <ul class="jp-toggles">
                                            	<li>
                                            		<a href="javascript:;" class="jp-shuffle" tabindex="1" title="shuffle"><i class="fa fa-random"></i></a>
                                            	</li>
                                            	<li>
                                            		<a href="javascript:;" class="jp-shuffle-off" tabindex="1" title="shuffle off"><i class="fa fa-random"></i></a>
                                            	</li>
                                            	<li>
                                            		<a href="javascript:;" class="jp-repeat" tabindex="1" title="repeat"><i class="fa fa-repeat"></i></a>
                                            	</li>
                                            	<li>
                                            		<a href="javascript:;" class="jp-repeat-off" tabindex="1" title="repeat off"><i class="fa fa-rotate-left"></i></a>
                                            	</li>
                                            </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="jp-playlist">
                                    <div class="wrapper-payerlsit">
                                        <ul>
                                            <!-- The method Playlist.displayPlaylist() uses this unordered list -->                         
                                            <li></li>
                                        </ul>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>
                <?php }?>
        
       
        <!-- Detail Text Strat -->
        <div class="detail_text rich_editor_text">
		<?php 
        the_content();
        wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'Soundblast' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) );
        ?>
        </div>
        <!-- Detail Text End -->
        <div class="tagcloud post-tags">
			<?php 
                $before_cat = '<i class="fa fa-tag"></i>&nbsp;';
                $tags_list = get_the_term_list ( get_the_id(), 'album-tag', $before_cat, ', ', '' );
                if ( $tags_list ){ printf( __( '%1$s', 'SoundBlast' ),$tags_list ); }
            ?>
        </div>
        <!-- Share Post Start -->
        <div class="share_post">
			<?php 
            if($cs_xmlObject->album_social_share == 'on') { cs_social_share();}
            ?>
            <div class="right-sec">
               <?php 
                cs_next_prev_custom_links('albums');
                ?>
            </div>
        </div>
        <!-- Share Post End -->
    <!-- Col-Md-8 End -->
    </div>
    <?php 
	if ($cs_xmlObject->album_related== "on") {
			cs_cycleslider_script();
		?>
		<?php
			$custom_taxterms='';
			 $custom_taxterms = wp_get_object_terms( $post->ID, array('album-category','album-tag'), array('fields' => 'ids') );
			  // arguments
			  $args = array(
			  'post_type' => 'albums',
			  'post_status' => 'publish',
			  'posts_per_page' => -1, // you may edit this number
			  'orderby' => 'DESC',
			  'tax_query' => array(
				  'relation' => 'OR',
				  array(
					  'taxonomy' => 'album-tag',
					  'field' => 'id',
					  'terms' => $custom_taxterms
				  ),
				  array(
					  'taxonomy' => 'album-category',
					  'field' => 'id',
					  'terms' => $custom_taxterms
				  )
			  ),
			  'post__not_in' => array ($post->ID),
			  ); 
			  $custom_query = new WP_Query($args);
			  $count = 0;
			  $count = $custom_query->post_count;
			  
			  if ($count) {
		?>
        <!-- New Releases Start -->
        <div class="new-releases">
            <header class="cs-heading-title"><h2 class="cs-section-title cs-heading-color"><?php echo $cs_xmlObject->album_related_title;?></h2></header>
                <div class="center">
                    <a id="prev3" href="#" class="prev-btn"><i class="fa fa-angle-left fa-1x"></i></a>
                    <a id="next3" href="#" class="next-btn"><i class="fa fa-angle-right fa-1x"></i></a>
                </div>
                <div class="cycle-slideshow"
                data-cycle-timeout=4000
                data-cycle-fx=carousel
                data-cycle-slides="article"
                data-cycle-carousel-fluid="false"
                data-allow-wrap="true"
                    data-cycle-next="#next3"
                    data-cycle-prev="#prev3">
                     <?php
						while ( $custom_query->have_posts() ): $custom_query->the_post();
							$cs_album = get_post_meta($post->ID, "cs_album", true);
							if ( $cs_album <> "" ) {
								$counter_album_tracks = 0;
								$album_track_mp3_url_audio = '';
								$cs_xmlObject = new SimpleXMLElement($cs_album);
									$album_release_date_db = $cs_xmlObject->album_release_date;
									$album_buynow = $cs_xmlObject->album_buynow;
							}
							$image_url = cs_attachment_image_src( get_post_thumbnail_id($post->ID),330,330 ); 
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
                                    <a href="<?php echo $cs_xmlObject->album_buynow;?>"><span class="album-price"><?php echo $cs_xmlObject->album_price;?></span></a>
                                    <ul>
                                        <li><a href="#" class="colrhover"><i class="fa fa-music"></i> <?php echo count($cs_xmlObject->track);?></a></li>
                                        
                                        <li>
                                        <?php
											$cs_like_counter = '0';
											$cs_like_counter = get_post_meta(get_the_id(), "cs_like_counter", true);
											if ( isset($_COOKIE["cs_like_counter".get_the_id()]) ) { 
											if ( !isset($cs_like_counter) or empty($cs_like_counter) ) { $cs_like_counter = 0; }
										?>
											   <a class="colrhover"><i class="fa fa-heart"></i></a><?php echo $cs_like_counter; ?>
										<?php	
											} else { ?>
											  <a href="javascript:cs_like_counter('<?php echo get_template_directory_uri()?>',<?php echo get_the_id()?>)" id="like_this<?php echo get_the_id()?>" ><i class="fa fa-heart"></i></a><?php echo $cs_like_counter; ?>
												<a class="likes" id="you_liked<?php echo get_the_id()?>" style="display:none;"><i class="fa fa-heart"></i></a>
												<div id="loading_div<?php echo get_the_id()?>" style="display:none;"><i class="fa fa-spinner fa-spin"></i></div>
										<?php } ?>
										</li>
                                    </ul>
                                </div>
                                </div>
                            </div>
                        </article>
                        
  				<?php endwhile; wp_reset_query();?>
            </div>
        </div>
        <!-- New Releases End -->
    <?php }}?>
 <?php comments_template('', true); ?>
 </div>
 <?php if ( $cs_layout  == 'content-left col-lg-9 col-md-9'){ ?>
            <div class="col-md-3 col-sm-3"><?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar($cs_sidebar_right) ) : ?><?php endif; ?></div>
<?php wp_reset_query();} ?>
<?php
 endwhile; endif;
 get_footer();
 ?>