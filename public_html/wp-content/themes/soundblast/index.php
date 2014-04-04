<?php
// Header File
 get_header();
 if ( have_posts() ) : ?>
	<div class="postlist blog">
                 <!-- Blog Post Start -->
                 <?php
				 if (empty($_GET['page_id_all']))
                        $_GET['page_id_all'] = 1;
                    if (!isset($_GET["s"])) {
                        $_GET["s"] = '';
                    }
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
                                
                                <p><?php the_excerpt()?></p>
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

 endif;
 //Footer FIle
 get_footer();
?>