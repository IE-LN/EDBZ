<?php
	cs_slider_gallery_template_redirect();
	global $cs_node,$cs_theme_option,$counter_node,$video_width;
	$cs_node = new stdClass();
  	get_header();
	$cs_layout = '';
	if (have_posts()):
	while (have_posts()) : the_post();
	$post_xml = get_post_meta($post->ID, "post", true);	
	if ( $post_xml <> "" ) {
		$cs_xmlObject = new SimpleXMLElement($post_xml);
		$cs_layout = $cs_xmlObject->sidebar_layout->cs_layout;
 		$cs_sidebar_left = $cs_xmlObject->sidebar_layout->cs_sidebar_left;
		$cs_sidebar_right = $cs_xmlObject->sidebar_layout->cs_sidebar_right;
		if ( $cs_layout == "left") {
			$cs_layout = "content-left col-md-9 col-sm-9";
			$custom_height = 411;
 		}
		else if ( $cs_layout == "right" ) {
			$cs_layout = "content-right col-md-9 col-sm-9";
			$custom_height = 411;
 		}
		else {
			$cs_layout = "col-md-12";
			$custom_height = 411;
		}
 	}else{
		$cs_layout = "col-md-12";
	}

			$image_id = get_post_thumbnail_id($post->ID);
			$post_xml = get_post_meta($post->ID, "post", true);	
			if ( $post_xml <> "" ) {
				$cs_xmlObject = new SimpleXMLElement($post_xml);
				$post_view = $cs_xmlObject->inside_post_thumb_view;
 				$post_video = $cs_xmlObject->inside_post_thumb_video;
				$post_audio = $cs_xmlObject->inside_post_thumb_audio;
				$post_slider = $cs_xmlObject->inside_post_thumb_slider;
				$post_slider_type = $cs_xmlObject->inside_post_thumb_slider_type;
				$post_featured_image = $cs_xmlObject->inside_post_featured_image_as_thumbnail;
				$width = 1060;
				$height = 470;
				$image_url = cs_get_post_img_src($post->ID, $width, $height);
			}
			else {
				$cs_xmlObject = new stdClass();
				$post_view = '';
 				$post_video = '';
				$post_audio = '';
				$post_slider = '';
				$post_slider_type = '';
				$width = 0;
				$height = 0;
				$image_id = 0;
				$cs_xmlObject->post_social_sharing = '';
				$cs_xmlObject->post_related = '';
			}								
			?>
                        <!-- Need to add code below in function file to call it on all pages -->
                        <!--Left Sidebar Starts-->
                      <?php if ($cs_layout == 'content-left col-md-9 col-sm-9'){ ?>
                            <div class="col-md-3 col-sm-3"><?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar($cs_sidebar_left) ) : ?><?php endif; ?></div>
                        <?php } ?>
                        <!--Left Sidebar End-->
                        <!-- Blog Detail Start -->
                        <div class="<?php echo $cs_layout; ?>">
							<!-- Blog Start -->
                            <article class="figure_detail">
                                <figure>
                                	<?php
											if( $post_view == "Slider" and $post_slider <> "" and $post_view <> ''){
                                                 cs_flex_slider($width, $height,$post_slider);
                                            } elseif($post_view == "Single Image"){ 
                                                echo '<a><img src="'.$image_url.'" ></a>';
                                              }elseif($post_view == "Video" and $post_video <> '' and $post_view <> ''){
												  
                                                $url = parse_url($post_video);
												
                                                if($url['host'] == $_SERVER["SERVER_NAME"]){?>
                                                    <video width="<?php echo $width;?>" class="mejs-wmp" height="100%"  style="width: 100%; height: 100%;" src="<?php echo $post_video ?>"  id="player1" poster="<?php if($post_featured_image == "on"){ echo $image_url; } ?>" controls="controls" preload="none"></video>
                                                <?php
                                                }else{
                                                      echo wp_oembed_get($post_video,array('height'=>$custom_height));
                                                }
                                            }elseif($post_view == "Audio" and $post_view <> ''){
												?>
												<audio style="width:100%;" src="<?php echo $post_audio; ?>" type="audio/mp3" controls="controls"></audio>
                                                <?php
											}
											?>
                                </figure>
                                <header class="cs-heading-title">
                                    <h2 class="cs-section-title cs-heading-color"><?php the_title(); ?></h2>
                                </header>
                                <ul class="post-options">
                                    <li><i class="fa fa-clock-o"></i><time datetime="<?php get_the_date();?>"><?php echo get_the_date();?></time></li>
                                    <li><i class="fa fa-user"></i><a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>"> <?php echo get_the_author(); ?></a></li>
                                    <?php
										  /* translators: used between list items, there is a space after the comma */
										  $before_cat = "<li><i class='fa fa-list'></i>".__( '','Soundblast')."";
										  $categories_list = get_the_term_list ( get_the_id(), 'category', $before_cat, ', ', '</li>' );
										  if ( $categories_list ){
											  printf( __( '%1$s', 'Soundblast'),$categories_list );
										  }
									?>
                                    <?php 
									if ( comments_open() ) {  echo "<li><i class='fa fa-comment'></i>"; comments_popup_link( __( '0 Comment', 'Soundblast' ) , __( '1 Comment', 'Soundblast' ), __( '% Comment', 'Soundblast' ) ); } ?>
                                    
                                </ul>
                            </article>
                            <!-- Detail Text Strat -->
                            <div class="detail_text rich_editor_text"><?php 
								the_content();
								wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'Soundblast' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) );
							?></div>
                            <!-- Detail Text End -->
                            <div class="tagcloud post-tags">
								<?php 
                                    $before_cat = '<i class="fa fa-tag"></i>&nbsp;';
                                    $tags_list = get_the_term_list ( get_the_id(), 'post_tag', $before_cat, ', ', '' );
                                    if ( $tags_list ){ printf( __( '%1$s', 'SoundBlast' ),$tags_list ); }
                                ?>
                            </div>
                            <div class="share_post">
                            	<?php 
								if($cs_xmlObject->post_social_sharing == 'on') { cs_social_share();}
								?>
								<div class="right-sec">
								   <?php 
									cs_next_prev_custom_links('post');
									?>
								</div>
                            </div>
                            <!-- About Author Start -->
                            <div class="devider-1"></div>
                            <?php 
							if (get_the_author_meta('description')){ ?>
                     			<div class="about-author">
                                     <figure><a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>" class="float-left"><?php echo get_avatar(get_the_author_meta('user_email'), apply_filters('PixFill_author_bio_avatar_size', 80)); ?></a></figure>
                                     <div class="text">
                                     	<div class="user-info">
                                        <h2 class="cs-post-title cs-heading-color"><a class="colrhover" href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>"><?php the_author_meta('nicename'); ?></a></h2>
                                        <a class="view-all-post" href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>"><i class="fa fa-caret-right"></i><?php if($cs_theme_option['trans_switcher'] == "on"){ _e('View all Posts','Soundblast');}else{ echo $cs_theme_option['trans_view_all']; } ?></a>
                                        </div>
                                        <p><?php the_author_meta('description'); ?></p>
                                        <?php if(get_the_author_meta('twitter') <> ''){?><a class="follow-tweet" href="http://twitter.com/<?php the_author_meta('twitter'); ?>"><i class="fa fa-twitter"></i>@<?php the_author_meta('twitter'); ?></a><?php }?>
                                    </div>
                              	</div>
                                <!-- About Author End -->
                                <div class="devider-1"></div>
                        	<?php } ?>
                        	<?php comments_template('', true); ?>
					</div>                            
                <!--Content Area End-->
                <!--Right Sidebar Starts-->
                  <?php if ( $cs_layout  == 'content-right col-md-9 col-sm-9'){ ?>
                			<div class="col-md-3 col-sm-3"><?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar($cs_sidebar_right) ) : ?><?php endif; ?></div>
                <?php } ?>
<?php endwhile;   endif;?>
<!--Footer-->
<?php get_footer(); ?>
