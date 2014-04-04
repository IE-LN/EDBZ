<?php
	// Gallery start
		//adding columns start
    add_filter('manage_cs_gallery_posts_columns', 'gallery_columns_add' );
		function gallery_columns_add($columns) {
			$columns['category'] = 'Categories';
			$columns['author'] = 'Author';
			return $columns;
	    }
    add_action('manage_cs_gallery_posts_custom_column', 'gallery_columns');
		function gallery_columns($name) {
			global $post;
			switch ($name) {
				case 'category':
					$categories = get_the_terms( $post->ID, 'cs_gallery-category' );
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
	function cs_gallery_register() {  
		$labels = array(
			'name' => 'Galleries',
			'add_new_item' => 'Add New Gallery',
			'edit_item' => 'Edit Gallery',
			'new_item' => 'New Gallery Item',
			'add_new' => 'Add New Gallery',
			'view_item' => 'View Gallery Item',
			'search_items' => 'Search Gallery',
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
			'menu_icon' => get_stylesheet_directory_uri() . '/images/admin/gallery-icon.png',
			'rewrite' => true,
			'capability_type' => 'post',
			'hierarchical' => false,
			'menu_position' => null,
			'has_archive' => true,
			'supports' => array('title','thumbnail')
		);
		
        register_post_type( 'cs_gallery' , $args );
	}
	
	add_action('init', 'cs_gallery_register');
	function cs_gallery_categories() 
	{
		  $labels = array(
			'name' => 'Gallery Albums',
			'search_items' => 'Search Gallery Albums',
			'edit_item' => 'Edit Gallery Album',
			'update_item' => 'Update Gallery Album',
			'add_new_item' => 'Add New Album',
			'menu_name' => 'Gallery Albums',
		  ); 	
		  register_taxonomy('cs_gallery-category',array('cs_gallery'), array(
			'hierarchical' => true,
			'labels' => $labels,
			'show_ui' => true,
			'query_var' => true,
			'rewrite' => array( 'slug' => 'cs_gallery-category' ),
		  ));
	}
	add_action( 'init', 'cs_gallery_categories');

		// adding Gallery meta info start
			add_action( 'add_meta_boxes', 'cs_meta_gallery_add' );
			function cs_meta_gallery_add()
			{  
				add_meta_box( 'cs_meta_gallery', 'Gallery Options', 'cs_meta_gallery', 'cs_gallery', 'normal', 'high' );  
			}
			function cs_meta_gallery( $post ) {
				?>
					<div class="page-wrap" style="overflow:hidden;">
					<div class="option-sec">
                            <div class="opt-conts-in">
                                <div class="to-social-network">
                                    <div class="gal-active">
                                        <div class="clear"></div>
                                        <div class="dragareamain">
                                        <div class="placehoder">Gallery is Empty. Please Select Media <img src="<?php echo get_template_directory_uri()?>/images/admin/bg-arrowdown.png" alt="" /></div>
										<ul id="gal-sortable">
											<?php 
												global $cs_node, $counter;
												$counter_gal = 0;
                                                $cs_meta_gallery_options = get_post_meta($post->ID, "cs_meta_gallery_options", true);
                                                if ( $cs_meta_gallery_options <> "" ) {
                                                    $cs_xmlObject = new SimpleXMLElement($cs_meta_gallery_options);
                                                        foreach ( $cs_xmlObject->children() as $cs_node ){
															if ( $cs_node->getName() == "gallery" ) {
																$counter_gal++;
																$counter = $post->ID.$counter_gal;
																cs_gallery_clone();
															}
                                                        }
                                                }
                                            ?>
                                        </ul>
                                        </div>
                                    </div>
                                    <div class="to-social-list">
                                        <div class="soc-head">
                                            <h5>Select Media</h5>
                                            <div class="right">
                                                <input type="button" class="button reload" value="Reload" onclick="refresh_media()" />
                                                <input id="cs_log" name="cs_logo" type="button" class="uploadfile button" value="Upload Media" />
                                            </div>
                                            <div class="clear"></div>
                                        </div>
                                        <div class="clear"></div>
                                        <script type="text/javascript">
											function show_next(page_id, total_pages){
												var dataString = 'action=cs_media_pagination&page_id='+page_id+'&total_pages='+total_pages;
												jQuery("#pagination").html("<img src='<?php echo get_template_directory_uri()?>/images/admin/ajax_loading.gif' />");
												jQuery.ajax({
													type:'POST', 
													url: "<?php echo home_url()?>/wp-admin/admin-ajax.php",
													data: dataString,
													success: function(response) {
														jQuery("#pagination").html(response);
													}
												});
											}
											function refresh_media(){
												var dataString = 'action=cs_media_pagination';
												jQuery("#pagination").html("<img src='<?php echo get_template_directory_uri()?>/images/admin/ajax_loading.gif' />");
												jQuery.ajax({
													type:'POST', 
													url: "<?php echo home_url()?>/wp-admin/admin-ajax.php",
													data: dataString,
													success: function(response) {
														jQuery("#pagination").html(response);
													}
												});
											}
										</script>
        <script type="text/javascript" src="<?php echo get_template_directory_uri()?>/scripts/admin/prettyCheckable.js"></script>
                    <script type="text/javascript" src="<?php echo get_template_directory_uri()?>/scripts/admin/jquery.scrollTo-min.js"></script>
					<script>
                        jQuery(document).ready(function($) {
							$("#gal-sortable").sortable({
								cancel:'li div.poped-up',
							});
							$(this).append("#gal-sortable").clone() ;
                            });
                            var counter = 0;
							var count_items = <?php echo $counter_gal?>;
							if ( count_items > 0 ) {
								jQuery(".dragareamain") .addClass("noborder");	
							}
							function clone(path){
								counter = counter + 1;
								var dataString = 'path='+path+'&counter='+counter+'&action=gallery_clone';
								
								jQuery("#gal-sortable").append("<li id='loading'><img src='<?php echo get_template_directory_uri()?>/images/admin/ajax_loading.gif' /></li>");
								jQuery.ajax({
									type:'POST', 
									url: "<?php echo home_url()?>/wp-admin/admin-ajax.php",
									data: dataString,
									success: function(response) {
										jQuery("#loading").remove();
										jQuery("#gal-sortable").append(response);
										count_items = jQuery("#gal-sortable li") .length;
											if ( count_items > 0 ) {
												jQuery(".dragareamain") .addClass("noborder");	
											}
									}
								});
							}
                            function del_this(id){
                                jQuery("#"+id).remove();
								count_items = jQuery("#gal-sortable li") .length;
									if ( count_items == 0 ) {
										jQuery(".dragareamain") .removeClass("noborder");	
									}
                            }
                    </script>
					<script type="text/javascript">
                     var contheight;
                          function galedit(id){
                      var $ = jQuery;
                      $(".to-social-list,.gal-active h4.left,#gal-sortable li,#gal-sortable .thumb-secs") .not("#"+id) .fadeOut(200);
                      $.scrollTo( '.page-wrap', 400, {easing:'swing'} );
                            $('.poped-up').animate({
                             top: 0,
                            }, 300, function() {
                      $("#edit_" + id+" li")  .show(); 
                            $("#edit_" + id)   .slideDown(300); 
                            });
                           };
                           function galclose(id){
                      var $ = jQuery;
                      $("#edit_" + id) .slideUp(300);
                      $(".to-social-list,.gal-active h4.left,#gal-sortable li,#gal-sortable .thumb-secs")  .fadeIn(300);
                      };
                    
                    </script>                    
										<div id="pagination"><?php cs_media_pagination();?></div>
	                                    <input type="hidden" name="gallery_meta_form" value="1" />
                                        <div class="clear"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="clear"></div>
                    </div>
                <?php
			}
			// adding Gallery meta info end
			// saving Gallery meta start
			if ( isset($_POST['gallery_meta_form']) and $_POST['gallery_meta_form'] == 1 ) {
				add_action( 'save_post', 'cs_meta_gallery_options' );
				function cs_meta_gallery_options( $cs_post_id )
				{
					$counter = 0;
					$sxe = new SimpleXMLElement("<gallery_options></gallery_options>");
						if ( isset($_POST['path']) ) {
							foreach ( $_POST['path'] as $count ) {
								$gallery = $sxe->addChild('gallery');
									$gallery->addChild('path', $_POST['path'][$counter] );
									$gallery->addChild('title', htmlspecialchars($_POST['title'][$counter]) );
									$gallery->addChild('description', htmlspecialchars($_POST['description'][$counter]) );
									$gallery->addChild('use_image_as', $_POST['use_image_as'][$counter] );
									$gallery->addChild('video_code', htmlspecialchars($_POST['video_code'][$counter]) );
									$gallery->addChild('link_url', htmlspecialchars($_POST['link_url'][$counter]) );
									$counter++;
							}
						}
					update_post_meta( $cs_post_id, 'cs_meta_gallery_options', $sxe->asXML() );
				}
			}
			// saving Gallery meta end
	// Gallery end
?>