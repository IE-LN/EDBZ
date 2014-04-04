<?php global $cs_theme_option;  
 if($cs_theme_option['show_partners'] == "on" and (is_home() || is_front_page())){
	  				cs_cycleslider_script();
	  				$gal_album_db = '';
					if($cs_theme_option['partner_gallery_name'] <> ''){
						$args=array(
								'name' => $cs_theme_option['partner_gallery_name'],
								'post_type' => 'cs_gallery',
								'post_status' => 'publish',
								'showposts' => 1,
							);
							$get_posts = get_posts($args);
							if($get_posts){
								$gal_album_db = $get_posts[0]->ID;
						
						// galery slug to id end
						$cs_meta_gallery_options = get_post_meta($gal_album_db, "cs_meta_gallery_options", true);
						if($gal_album_db <> '' && $cs_meta_gallery_options <> ''){
						// pagination start
							$cs_xmlObject = new SimpleXMLElement($cs_meta_gallery_options);
								$limit_start = 0;
								$limit_end = count($cs_xmlObject->gallery);
								$count_post = count($cs_xmlObject->gallery);
								if($count_post>0){
								?>
									<div class="clear"></div>
									<div class="col-md-12">
									<!-- Partners Start -->
										<div class="partners">
											<div class="left-area">
											   <?php if($cs_theme_option['partner_gallery_title'] <> ''){?> <header><h2 class="cs-section-title cs-heading-color"><?php echo $cs_theme_option['partner_gallery_title']; ?></h2></header><?php }?>
												<div class="center">
													<a id="prev588" href="#" class="prev-btn"><i class="fa fa-angle-left fa-1x"></i></a>
													<a id="next588" href="#" class="next-btn"><i class="fa fa-angle-right fa-1x"></i></a>
												</div>
											</div>
											<div class="right-area">
												<div class="cycle-slideshow"
												data-cycle-timeout=4000
												data-cycle-fx=carousel
												data-cycle-slides="article"
												
												data-cycle-carousel-fluid="false"
												data-allow-wrap="true"
													data-cycle-next="#next588"
													data-cycle-prev="#prev588">
													<?php
													if ( $cs_meta_gallery_options <> "" ) {
														for ( $i = $limit_start; $i < $limit_end; $i++ ) {
															$path = $cs_xmlObject->gallery[$i]->path;
															$title = $cs_xmlObject->gallery[$i]->title;
															$description = $cs_xmlObject->gallery[$i]->description;
															$social_network = $cs_xmlObject->gallery[$i]->social_network;
															$use_image_as = $cs_xmlObject->gallery[$i]->use_image_as;
															$video_code = $cs_xmlObject->gallery[$i]->video_code;
															$link_url = $cs_xmlObject->gallery[$i]->link_url;
															$image_url = cs_attachment_image_src($path, 0, 0);
															if($image_url <> ''){
															?>
															<article>
																<figure><a href="#"><img src="<?php echo $image_url;?>" alt=""></a></figure>
															</article>
												 <?php }}}?>
											</div>  
										</div>
									  </div>
								 <!-- Partners End -->
							<div class="clear"></div>
							</div>
				<?php }}}}}?>
        	<!-- Col Md 12 End -->
           
        </div>
        <!-- Row End -->
        <?php if(isset($cs_theme_option['footer_widget']) && $cs_theme_option['footer_widget'] == 'on'){?>
        <!-- Footer Widgets Start -->
        <div id="footer-widgets">
			<?php if (!function_exists('dynamic_sidebar') || !dynamic_sidebar('footer-widget')) : ?><?php endif; ?>
            <!-- Footer Widgets End -->
        </div>
            <!-- Footer Start -->
    <?php }?>	
    <!-- Footer Start -->
    <div class="clear"></div>
    </div>
    <!-- Container End -->
    <div class="clear"></div>
    <!-- Content Section End -->
    <?php 
	cs_custom_mailchimp();
	?>
	<footer>
    <!-- Copyright Start -->
    <div class="container">
        <div class="copyright">
            <!-- Container Start -->
            
                <p>
				<?php 
						  if(isset($cs_theme_option['copyright']) and $cs_theme_option['copyright'] <> ''){
							  echo do_shortcode(htmlspecialchars_decode($cs_theme_option['copyright'])); 
						  }else{ 
						  echo "&copy; ".gmdate("Y"). " ".get_option('blogname')." Wordpress All rights reserved"; 
					  }
				?> 
				<?php echo do_shortcode(htmlspecialchars_decode($cs_theme_option['powered_by'])); ?></p>
                <?php cs_social_network();?>
                <a id="back-top" class="gotop" href="#"><i class="fa fa-reply"></i></a>
            
            <!-- Container End -->
        </div>
    </div>
    <!-- Copyright End -->
    </footer>
    <!-- Footer End -->
 </div>

        <!-- Footer End -->
<div class="clear"></div>
</div>
 </div>
<!-- Wrapper End --> 
<?php
	cs_footer_settings();
	wp_footer();
 ?>
</body>
</html>