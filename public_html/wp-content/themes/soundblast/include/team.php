<?php
		//adding columns start
		add_filter('manage_team_posts_columns', 'team_columns_add');
			function team_columns_add($columns) {
				$columns['category'] = 'Category';
				$columns['author'] = 'Author';
				return $columns;
		}
		add_action('manage_team_posts_custom_column', 'team_columns');
			function team_columns($name) {
				global $post;
				switch ($name) {
					case 'category':
						$categories = get_the_terms( $post->ID, 'team-category' );
							if($categories <> ""){
								$couter_comma = 0;
								foreach ( $categories as $category ) {
									echo $category->name;
									$couter_comma++;
									if ( $couter_comma < count($categories) ) {
										echo ", ";
									}
								}
							}
						break;
					case 'author':
						echo get_the_author();
						break;
				}
			}
		//adding columns end
	
		function cs_team_register() {
			// adding Team start
			$labels = array(
				'name' => 'Team',
				'add_new_item' => 'Add New Member',
				'edit_item' => 'Edit Member',
				'new_item' => 'New Member',
				'add_new' => 'Add New Member',
				'view_item' => 'View Member',
				'search_items' => 'Search Member',
				'not_found' => 'Nothing found',
				'not_found_in_trash' => 'Nothing found in Trash',
				'parent_item_colon' => ''
			);
			$args = array(
				'labels' => $labels,
				'public' => true,
				'publicly_queryable' => true,
				'show_ui' => true,
				'query_var' => true,
				'menu_icon' => get_stylesheet_directory_uri() . '/images/admin/team-icon.png',
				//'show_in_menu' => 'edit.php?post_type=albums',
				'show_in_nav_menus'=>true,
				'rewrite' => true,
				'capability_type' => 'post',
				'hierarchical' => false,
				'menu_position' => null,
				'supports' => array('title', 'thumbnail')
			); 
			register_post_type( 'teams' , $args );  
		}
			// adding Team end
		add_action('init', 'cs_team_register');
		// adding tag start
		  $labels = array(
			'name' => 'Team Tags',
			'singular_name' => 'team-tag',
			'search_items' => 'Search Tags',
			'popular_items' => 'Popular Tags',
			'all_items' => 'All Tags',
			'parent_item' => null,
			'parent_item_colon' => null,
			'edit_item' => 'Edit Tag', 
			'update_item' => 'Update Tag',
			'add_new_item' => 'Add New Tag',
			'new_item_name' => 'New Tag Name',
			'separate_items_with_commas' => 'Separate tags with commas',
			'add_or_remove_items' => 'Add or remove tags',
			'choose_from_most_used' => 'Choose from the most used tags',
			'menu_name' => 'Team Tags',
		  ); 
		  register_taxonomy('team-tag','teams',array(
			'hierarchical' => false,
			'labels' => $labels,
			'show_ui' => true,
			'update_count_callback' => '_update_post_term_count',
			'query_var' => true,
			'rewrite' => array( 'slug' => 'team-tag' ),
		  ));
		  	function cs_team_categories() 
			{
				  $labels = array(
					'name' => 'Team Categories',
					'search_items' => 'Search Team Categories',
					'edit_item' => 'Edit Team Category',
					'update_item' => 'Update Team Category',
					'add_new_item' => 'Add New Category',
					'menu_name' => 'Team Categories',
				  ); 	
				  register_taxonomy('team-category',array('teams'), array(
					'hierarchical' => true,
					'labels' => $labels,
					'show_ui' => true,
					'query_var' => true,
					'rewrite' => array( 'slug' => 'team-category' ),
				  ));
			}
			add_action( 'init', 'cs_team_categories');
		// adding tag end
		// adding Team meta info start
		add_action( 'add_meta_boxes', 'cs_meta_team_add' );
		function cs_meta_team_add()
		{  
			add_meta_box( 'cs_meta_team', 'Team Options', 'cs_meta_team', 'teams', 'normal', 'high' );  
		}
		function cs_meta_team( $post ) {
			$cs_team = get_post_meta($post->ID, "cs_team", true);
			global $cs_xmlObject;
			if ( $cs_team <> "" ) {
				$cs_xmlObject = new SimpleXMLElement($cs_team);
					$var_cp_expertise = $cs_xmlObject->var_cp_expertise;
					$var_cp_about = $cs_xmlObject->var_cp_about;
 			}
			else {
				$var_cp_expertise ='';
				$var_cp_about = '';
 			}
		?>
            <div class="page-wrap page-opts left" style="overflow:hidden; position:relative;">
            	<script type="text/javascript" src="<?php echo get_template_directory_uri()?>/scripts/admin/jquery.scrollTo-min.js"></script>
				<script type="text/javascript" src="<?php echo get_template_directory_uri()?>/scripts/admin/select.js"></script>
                <script type="text/javascript" src="<?php echo get_template_directory_uri()?>/scripts/admin/prettyCheckable.js"></script>
                <div class="option-sec" style="margin-bottom:0;">
                    <div class="opt-conts">
				        <ul class="form-elements">
                            <li class="to-label"><label>Expertise</label></li>
                            <li class="to-field">
                                <input type="text" name="var_cp_expertise" value="<?php echo htmlspecialchars($var_cp_expertise)?>"/>
                            </li>
                        </ul>
                        <ul class="form-elements">
                            <li class="to-label"><label>About Text</label></li>
                            <li class="to-field">
                            	<textarea name="var_cp_about" rows="8" cols="20"><?php echo htmlspecialchars($var_cp_about)?></textarea>
                                <p>For best view please add maximum 150 characters</p>
                            </li>
                        </ul>
                    </div>
					<div class="clear"></div>
                </div>
                <div class="boxes tracklists">
                	<div id="add_track" class="poped-up">
                        <div class="opt-head">
                            <h5>Social Settings</h5>
                            <a href="javascript:closepopedup('add_track')" class="closeit">&nbsp;</a>
                            <div class="clear"></div>
                        </div>
                        <ul class="form-elements">
                            <li class="to-label"><label>Title</label></li>
                            <li class="to-field">
                            	<input type="text" id="var_cp_title" name="var_cp_title" value="Title" />
                                <p>Put album track title</p>
                            </li>
                        </ul>
                        <ul class="form-elements">
                            <li class="to-label"><label>Icon Shortcode/URL</label></li>
                            <li class="to-field">
								<input id="var_cp_image_url" name="var_cp_image_url" value="" type="text" class="small" />
								<input id="var_cp_image_url" name="var_cp_image_url" type="button" class="uploadfile left" value="Browse"/>
                                <p>Put Fontsome Icon or Icon URL</p>
                            </li>
                        </ul>
                        
                        
                        <ul class="form-elements">
                            <li class="to-label"><label>URL</label></li>
                            <li class="to-field">
                            	<input type="text" id="var_cp_url" name="var_cp_url" value="" />
                                <p>Put URL</p>
                            </li>
                        </ul>
                        
                        <ul class="form-elements noborder">
                            <li class="to-label"></li>
                            <li class="to-field"><input type="button" value="Add Social icon to List" onclick="add_social_to_list('<?php echo home_url()?>', '<?php echo get_template_directory_uri()?>')" /></li>
                        </ul>
                    </div>
                    <script>
						jQuery(document).ready(function($) {
							$("#total_tracks").sortable({
								cancel : 'td div.poped-up',
							});
						});
					</script>
                    <div class="opt-head">
                        <h4 style="padding-top:12px;">Social listings</h4>
                        <a href="javascript:openpopedup('add_track')" class="button">Add Social link</a>
                        <div class="clear"></div>
                    </div>
                    <table class="to-table" border="0" cellspacing="0">
                        <thead>
                            <tr>
                                <th style="width:80%;">Title</th>
                                <th style="width:80%;" class="centr">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="total_tracks">
                            <?php
								global $counter_social, $var_cp_title, $var_cp_image_url , $var_cp_url;
								$counter_social = $post->ID;
								if ( $cs_team <> "" ) {
									foreach ( $cs_xmlObject as $social ){
										if ( $social->getName() == "social" ) {
											$var_cp_title = $social->var_cp_title;
											$var_cp_image_url = $social->var_cp_image_url;
											$var_cp_url = $social->var_cp_url;
											$counter_social++;
 											cs_add_social_to_list();
										}
									}
								}
							?>
                        </tbody>
                    </table>
                </div>
				<?php cs_meta_layout() ?>
                <input type="hidden" name="team_meta_form" value="1" />
                <div class="clear"></div>
            </div>
            <div class="clear"></div>
	<?php
		}
		if ( isset($_POST['team_meta_form']) and $_POST['team_meta_form'] == 1 ) {
			if ( empty($_POST['cs_layout']) ) $_POST['cs_layout'] = 'none';
			add_action( 'save_post', 'cs_meta_team_save' );  
			function cs_meta_team_save( $cs_post_id )
			{  
				$sxe = new SimpleXMLElement("<team></team>");
					if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return; 
					if (empty($_POST["var_cp_expertise"])){ $_POST["var_cp_expertise"] = "";}
					if (empty($_POST["var_cp_about"])){ $_POST["var_cp_about"] = "";}
						$sxe = save_layout_xml($sxe);
						$sxe->addChild('var_cp_expertise', $_POST['var_cp_expertise'] );
						$sxe->addChild('var_cp_about', $_POST['var_cp_about'] );
						$counter = 0;
						if ( isset($_POST['var_cp_title']) ) {
							foreach ( $_POST['var_cp_title'] as $count ){
								$track = $sxe->addChild('social');
									$track->addChild('var_cp_title', htmlspecialchars($_POST['var_cp_title'][$counter]) );
									$track->addChild('var_cp_image_url', htmlspecialchars($_POST['var_cp_image_url'][$counter]) );
									$track->addChild('var_cp_url', $_POST['var_cp_url'][$counter] );
									$counter++;
							}
						}
				update_post_meta( $cs_post_id, 'cs_team', $sxe->asXML() );
			}
		}
		// adding Team meta info end
	?>