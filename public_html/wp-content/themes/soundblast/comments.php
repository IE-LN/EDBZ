<?php
if ( comments_open() ) {
	if ( post_password_required() ) return;
?>
		<?php if ( have_comments() ) : ?>
			<div id="comments">
				 <header class="heading">
					<h2 class="cs-heading-color section-title"><?php echo comments_number(__('No Comments', 'Soundblast'), __('1 Comment', 'Soundblast'), __('% Comments', 'Soundblast') );?></h2>
				</header>
                 <ul>
                    <?php wp_list_comments( array( 'callback' => 'cs_comment' ) );	?>
                </ul>
				<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
					<div class="navigation">
						<div class="nav-previous"><?php previous_comments_link( __( '<span class="meta-nav">&larr;</span> Older Comments', 'Soundblast') ); ?></div>
						<div class="nav-next"><?php next_comments_link( __( 'Newer Comments <span class="meta-nav">&rarr;</span>', 'Soundblast') ); ?></div>
					</div> <!-- .navigation -->
				<?php endif; // check for comment navigation ?>
                
				<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
                    <div class="navigation">
                        <div class="nav-previous"><?php previous_comments_link( __( '<span class="meta-nav">&larr;</span> Older Comments', 'Soundblast') ); ?></div>
                        <div class="nav-next"><?php next_comments_link( __( 'Newer Comments <span class="meta-nav">&rarr;</span>', 'Soundblast') ); ?></div>
                    </div><!-- .navigation -->
                <?php endif; ?>
			</div>
		<?php endif; // end have_comments() ?>
 		<div class="fullwidth" id="respond">
		<?php 
			global $cs_post_id;
			$you_may_use = __( 'You may use these <abbr title="HyperText Markup Language">HTML</abbr> tags and attributes: %s', 'Soundblast');
			$must_login = __( 'You must be <a href="%s">logged in</a> to post a comment.', 'Soundblast');
			$logged_in_as = __('Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>', 'Soundblast');
			$required_fields_mark = ' ' . __('Required fields are marked %s', 'Soundblast');
			$required_text = sprintf($required_fields_mark , '<span class="required">*</span>' );
	
			$defaults = array( 'fields' => apply_filters( 'comment_form_default_fields', 
				array(
					'notes' => '<p class="comment-notes">
                                Your email is <em>never</em> published nor shared. Required fields are marked <strong class="required">(Required)</strong>
                            </p>',
					'author' => '<p class="comment-form-author">'.
					'<label for="author"  class="fa fa-user"></label>'.
					'<input id="author" name="author" class="nameinput" type="text" value=""  size="30" tabindex="1"  /><strong>(Required)</strong>' .
					'</p><!-- #form-section-author .form-section -->',
					
					'email'  => '<p class="comment-form-email">' .
					'<label for="email" class="fa fa-envelope"></label>'.
					'<input id="email" name="email" class="emailinput" type="text"  value="" size="30" tabindex="2"/><strong>(Required)</strong>' .
					'</p><!-- #form-section-email .form-section -->',
					
					'url'    => '<p class="comment-form-website">' .
					'<label for="url" class="fa fa-align-left"></label>' .
					'<input id="url" name="url" type="text" class="websiteinput"  value="" size="30" tabindex="3" /><strong>(Required)</strong>' .
					'</p>' ) ),
					
					'comment_field' => '<p class="comment-form-comment">'.
					'<label for="comment"></label>' .
					'<textarea id="comment" name="comment"  class="commenttextarea" rows="4" cols="39"></textarea>' .
					'</p><!-- #form-section-comment .form-section -->',
					
					'must_log_in' => '<p class="must-log-in">' .  sprintf( $must_login,	wp_login_url( apply_filters( 'the_permalink', get_permalink( $cs_post_id ) ) ) ) . '</p>',
					'logged_in_as' => '<p class="logged-in-as">' . sprintf( $logged_in_as, admin_url( 'profile.php' ), $user_identity, wp_logout_url( apply_filters( 'the_permalink', get_permalink( $cs_post_id ) ) ) ),
					'comment_notes_before' => '',
					'comment_notes_after' =>  '',
					'id_form' => 'commentform',
					'id_submit' => 'submit-comment',
					'class_submit' => 'submit-comment',
					'title_reply' => __( 'Leave us a Comment ', 'Soundblast' ),
					'title_reply_to' => __( 'Leave a Reply to %s', 'Soundblast' ),
					'cancel_reply_link' => __( 'Cancel reply', 'Soundblast' ),
					'label_submit' => __( 'Post Comment', 'Soundblast' ),); 
					comment_form($defaults, $cs_post_id); 
				?>
	 </div>
<?php }?>