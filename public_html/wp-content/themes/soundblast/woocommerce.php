<?php get_header();
	
	/***************** Shop Page ******************/
	if(is_shop()){
		$cs_shop_id = woocommerce_get_page_id( 'shop' );
		wp_reset_query();
		if (post_password_required($cs_shop_id)) { 
			echo '<div class="rich_editor_text">'.cs_password_form().'</div>';
		}else{
		$cs_meta_page = cs_meta_shop_page('cs_page_builder', $cs_shop_id);
		if (count($cs_meta_page) > 0) {
			if ( $cs_meta_page->sidebar_layout->cs_layout <> '' and $cs_meta_page->sidebar_layout->cs_layout <> "none" and $cs_meta_page->sidebar_layout->cs_layout == 'left' or  $cs_meta_page->sidebar_layout->cs_layout == 'both') :   ?>
				<div class="col-md-3 col-sm-3">
					<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar($cs_meta_page->sidebar_layout->cs_sidebar_left) ) : endif; ?>
				</div>
			<?php endif; ?>
			<?php if ( $cs_meta_page->cs_layout == 'both_left') :   ?>
			   <?php cs_meta_sidebar(); ?>
			<?php endif; ?>
			<div class="<?php echo cs_meta_content_class();  ?> ">
			<?php
			wp_reset_query();
			if($cs_meta_page->page_content == "Yes"){
				echo '<div class="rich_editor_text">';
					$content_post = get_post($cs_shop_id);
					$content = $content_post->post_content;
					$content = apply_filters('the_content', $content);
					$content = str_replace(']]>', ']]&gt;', $content);
					echo $content;
				echo '</div>';
				
			}
			if ( have_posts() ) :
				echo "<div class='cs_shop_wrap'>";
					woocommerce_content();
				echo "</div>";
			endif;
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
				elseif($cs_node->getName() == "map" and $cs_node->map_view == "content"){
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
		<?php }
		
		} 
	}
	/***************** Shop Page End ******************/
	
	/***************** Product Page Start ******************/
	else if(is_product()){
		$cs_layout = "col-md-12";
		if ( have_posts() ) :
			$post_xml = get_post_meta($post->ID, "product", true);	
			if ( $post_xml <> "" ) {
				$cs_xmlObject = new SimpleXMLElement($post_xml);
				$sub_title = $cs_xmlObject->sub_title;
				
				$cs_layout = $cs_xmlObject->sidebar_layout->cs_layout;
				$cs_sidebar_left = $cs_xmlObject->sidebar_layout->cs_sidebar_left;
				$cs_sidebar_right = $cs_xmlObject->sidebar_layout->cs_sidebar_right;
				if ( $cs_layout == "right") {
					$cs_layout = "content-right col-md-9 col-sm-9";
				}
				else if ( $cs_layout == "left" ) {
					$cs_layout = "content-left col-md-9 col-sm-9";
				}
				else {
					$cs_layout = "col-md-12";
				}
			}
			if ($cs_layout == 'content-left col-md-9 col-sm-9'){ ?>
                <div class="col-md-3 col-sm-3"><?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar($cs_sidebar_left) ) : ?><?php endif; ?></div>
            <?php } ?>
		   
			<div class="<?php echo $cs_layout; ?> cs_shop_wrap">
				<?php woocommerce_content(); ?>
			</div>
			
			<?php if ( $cs_layout  == 'content-right col-md-9 col-sm-9'){ ?>
                <div class="col-md-3 col-sm-3"><?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar($cs_sidebar_right) ) : ?><?php endif; ?></div>
            <?php } ?>
		
		<?php
		endif;
	}
	/***************** Shop Taxonomies pages ******************/
	else if(is_product_category() or is_product_tag()){
		global  $cs_theme_option; 
		isset($cs_theme_option['cs_layout']); $cs_layout = $cs_theme_option['cs_layout'];
		if ( have_posts() ) :
	?>
		<?php
			if ( $cs_layout <> '' and $cs_layout  <> "none" and $cs_layout  == 'left') :  ?>
				<aside class="left-content col-md-3">
					<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar($cs_theme_option['cs_sidebar_left']) ) : endif; ?>
				</aside>
			<?php endif; ?>	
			
			<div class="<?php cs_default_pages_meta_content_class( $cs_layout ); ?> cs_shop_wrap">
				<?php woocommerce_content(); ?>
			</div>
			
			<?php
			if ( $cs_layout <> '' and $cs_layout  <> "none" and $cs_layout  == 'right') :  ?>
				<aside class="left-content col-md-3">
					<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar($cs_theme_option['cs_sidebar_left']) ) : endif; ?>
				</aside>
			<?php endif; ?>	
		
		<?php endif; ?>
		
	<?php
	}
	
	/***************** Shop Other Pages ******************/
	
	else{
		if ( have_posts() ) :
	?>
			<div class="cs_shop_wrap">
				<?php woocommerce_content(); ?>
			</div>
		
		<?php endif; ?>
	<?php
	}
?>

<?php get_footer();?>
<!-- Columns End -->
