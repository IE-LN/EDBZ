<?php
	get_header();
	global  $cs_theme_option; 
 	$cs_layout = $cs_theme_option['cs_layout'];

		if ( $cs_layout <> '' and $cs_layout  <> "none" and $cs_layout  == 'left') :  ?>
			<aside class="<?php cs_default_pages_sidebar_class($cs_layout )?>"><?php cs_default_pages_sidebar()?></aside>
	<?php endif; ?>	
        	<div class="<?php cs_default_pages_meta_content_class( $cs_layout ); ?>">
             	<div class="postlist blog">
                 <!-- Blog Post Start -->
                 <?php
               		if ( have_posts() ) : 
						 while ( have_posts() ) : the_post();
						 ?>	
                         <article <?php post_class(); ?>>
                        <div class="blog-text webkit">
                        	
                            <div class="text">
                                <h2 class="cs-post-title cs-heading-color"><a href="<?php the_permalink();?>" class="colrhover"><?php echo substr(get_the_title(), 0, 130); if(strlen(get_the_title())>130) echo '...'; ?></a></h2>
                                 <ul class="post-options">
                                    <li><i class="fa fa-clock-o"></i><?php echo get_the_date(); ?></li>
                                    
                                    <li><i class="fa fa-user"></i><a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>"> <?php echo get_the_author(); ?></a></li>
                                     <?php
                                        if ( comments_open() ) {  echo "<li><i class='fa fa-comment'></i>"; comments_popup_link( __( '0 Comment', 'Soundblast' ) , __( '1 Comment', 'Soundblast' ), __( '% Comment', 'Soundblast' ) ); }
                                         ?>
                                         <?php edit_post_link( __( '<li><i class="fa fa-pencil-square-o"></i>Edit</li>', 'Soundblast'), '', '' ); ?>
                                </ul>
                                
                                <p><?php echo cs_get_the_excerpt(255,true);?></p>
                            </div>
                        </div>
                       
                    </article>
                         
				<?php endwhile; else:?>
                    <div class="pagenone">
                        <span class="icon-warning-sign icon-4"></span>
                        <h1><?php _e( 'No results found.', 'Soundblast'); ?></h1>
                        <div class="password_protected">
                            <?php get_search_form(); ?>
                        </div>
                    </div>
                	<?php endif;?>
               	</div>
                <?php
                	$qrystr = '';
                    // pagination start
					if ($wp_query->found_posts > get_option('posts_per_page')) {

							if ( isset($_GET['s']) ) $qrystr = "&s=".$_GET['s'];
							if ( isset($_GET['page_id']) ) $qrystr .= "&page_id=".$_GET['page_id'];
							echo cs_pagination($wp_query->found_posts,get_option('posts_per_page'), $qrystr);
					}
					// pagination end
             	?>                    
             </div>
			<?php
                if ( $cs_layout <> '' and $cs_layout  <> "none" and $cs_layout  == 'right') :  ?>
                    <aside class="<?php cs_default_pages_sidebar_class( $cs_theme_option['cs_layout'] )?>"><?php cs_default_pages_sidebar()?></aside>
            <?php endif; ?>	
<?php get_footer();?>
<!-- Columns End -->