<?php get_header();
					wp_reset_query();
					if (post_password_required()) { 
						echo '<div class="rich_editor_text">'.cs_password_form().'</div>';
					}else{
					$cs_meta_page = cs_meta_page('cs_page_builder');
					if (count($cs_meta_page) > 0) {
						if ( $cs_meta_page->sidebar_layout->cs_layout <> '' and $cs_meta_page->sidebar_layout->cs_layout <> "none" and $cs_meta_page->sidebar_layout->cs_layout == 'left' or  $cs_meta_page->sidebar_layout->cs_layout == 'both') :   ?>
            				<div class="col-md-3 col-sm-3">
                     			<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar($cs_meta_page->sidebar_layout->cs_sidebar_left) ) : endif; ?>
                     		</div>
                		<?php endif; ?>
                        <?php if ( $cs_meta_page->cs_layout == 'both_left') :   ?>
						   <?php cs_meta_sidebar();?>
                        <?php endif; ?>
               	 		<div class="<?php echo cs_meta_content_class();  ?> ">
						<?php
 						wp_reset_query();
						if($cs_meta_page->page_content == "Yes" && get_the_content() <> ''){
 							echo '<div class="rich_editor_text">';
								the_content();
 							echo '</div>';
						}
						global $counter_node;
						foreach ( $cs_meta_page->children() as $cs_node ) {
   							if ( $cs_node->getName() == "blog" ) {
								$counter_node++;
								$layout = $cs_meta_page->sidebar_layout->cs_layout;
								if ( $cs_node->cs_blog_cat <> "") 
								get_template_part( 'page_blog', 'page' );
 							}
							else if ( $cs_node->getName() == "gallery" ) {
								$counter_node++;
  								if ( $cs_node->album <> "" and $cs_node->album <> "0" ) {
									get_template_part( 'page_gallery', 'page' );
								}
							}
							else if ( $cs_node->getName() == "gallery_albums" ) {
								$counter_node++;
  								if ( $cs_node->cs_gal_album <> "" ) {
									get_template_part( 'page_gallery_albums', 'page' );
								}
							}
							else if ( $cs_node->getName() == "event" ) {
								$counter_node++;
 								if ( $cs_node->cs_event_category <> "" ) {
									get_template_part( 'page_event', 'page' );
								}
							}
							else if ( $cs_node->getName() == "album" ) {
								$counter_node++;
 								if ( $cs_node->cs_album_cat <> "") {
									get_template_part( 'page_album', 'page' );
								}
							}
							else if ( $cs_node->getName() == "slider"  and $cs_node->slider_view == "content") {
								$counter_node++;
 								get_template_part( 'page_slider', 'page' );
 							}
							elseif($cs_node->getName() == "contact"){
							   $counter_node++;
							   get_template_part('page_contact','page');
 							}
							elseif($cs_node->getName() == "column"){
								$counter_node++;
								cs_column_page();
							}
							elseif($cs_node->getName() == "divider"){
								$counter_node++;
								echo cs_divider_page();
							}
							elseif($cs_node->getName() == "message_box"){
								$counter_node++;
								cs_message_box_page();
							}
							elseif($cs_node->getName() == "image"){
								$counter_node++;
								echo cs_image_page();
							}
							else if ( $cs_node->getName() == "team" ) {
								$counter_node++;
								get_template_part( 'page_team', 'page' );
							}
							elseif($cs_node->getName() == "map"){
								$counter_node++;
								echo cs_map_page();
							}
							elseif($cs_node->getName() == "video"){
								$counter_node++;
								echo cs_video_page();
							}
							elseif($cs_node->getName() == "quote"){
								$counter_node++;
								echo cs_quote_page();
							}
							elseif($cs_node->getName() == "dropcap"){
								$counter_node++;
								echo cs_dropcap_page();
							}
							elseif($cs_node->getName() == "pricetable"){
								$counter_node++;
								cs_pricetable_page();
							}
							elseif($cs_node->getName() == "tabs"){
								$counter_node++;
								echo cs_tabs_page();
							}
							elseif($cs_node->getName() == "accordions"){
								$counter_node++;
								cs_accordions_page();
							}
						}
                     	wp_reset_query(); 
					 	if ( comments_open() ) : 
					 		comments_template('', true); 
		   				endif; 
						?>
                 </div>
						<?php if ( $cs_meta_page->sidebar_layout->cs_layout <> '' and $cs_meta_page->sidebar_layout->cs_layout <> "none" and $cs_meta_page->sidebar_layout->cs_layout == 'right' or $cs_meta_page->sidebar_layout->cs_layout == 'both') : ?>
                            <div class="col-md-3 col-sm-3">
                                    <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar($cs_meta_page->sidebar_layout->cs_sidebar_right) ) : endif; ?>
                             </div>
                        <?php endif; ?>
                        <?php if ( $cs_meta_page->cs_layout <> '' and $cs_meta_page->cs_layout <> "none" and $cs_meta_page->cs_layout == 'both_right') : ?>
                     <?php cs_meta_sidebar()?> 
                <?php endif; ?>
             		<?php }else{ ?>
            		<div class="rich_editor_text">
					<?php 
                        while (have_posts()) : the_post();
                            the_content();
                        endwhile; 
						if ( comments_open() ) { 
					 		comments_template('', true); 
						}
                    ?>
                </div>
			<?php }
			wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'Soundblast' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) );
			wp_reset_query();
			} 
		?>
<?php get_footer();?>
<!-- Columns End -->
