<?php
	//adding columns start
    add_filter('manage_albums_posts_columns', 'album_columns_add');
		function album_columns_add($columns) {
			$columns['category'] = 'Category';
			$columns['author'] = 'Author';
			return $columns;
    }
    add_action('manage_albums_posts_custom_column', 'album_columns');
		function album_columns($name) {
			global $post;
			switch ($name) {
				case 'category':
					$categories = get_the_terms( $post->ID, 'album-category' );
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

	function cs_album_register() {
		$labels = array(
			'name' => 'Albums',
			'add_new_item' => 'Add New Album',
			'edit_item' => 'Edit Album',
			'new_item' => 'New Album Item',
			'add_new' => 'Add New Album',
			'view_item' => 'View Album Item',
			'search_items' => 'Search Album',
			'not_found' =>  'Nothing found',
			'not_found_in_trash' => 'Nothing found in Trash',
			'parent_item_colon' => ''
		);
		$args = array(
			'labels' => $labels,
			'public' => true,
			'publicly_queryable' => true,
			'show_ui' => true,
			'query_var' => true,
			'menu_icon' => get_stylesheet_directory_uri() . '/images/admin/album-icon.png',
			'rewrite' => true,
			'capability_type' => 'post',
			'hierarchical' => false,
			'menu_position' => null,
			'supports' => array('title','editor','thumbnail', 'comments' )
		); 
        register_post_type( 'albums' , $args );
	}
	add_action('init', 'cs_album_register');

		// adding cat start
		  $labels = array(
			'name' => 'Album Categories',
			'search_items' => 'Search Album Categories',
			'edit_item' => 'Edit Album Category',
			'update_item' => 'Update Album Category',
			'add_new_item' => 'Add New Category',
			'menu_name' => 'Album Categories',
		  ); 	
		  register_taxonomy('album-category',array('albums'), array(
			'hierarchical' => true,
			'labels' => $labels,
			'show_ui' => true,
			'query_var' => true,
			'rewrite' => array( 'slug' => 'album-category' ),
		  ));
		// adding cat end
		// adding tag start
		  $labels = array(
			'name' => 'Album Tags',
			'singular_name' => 'album-tag',
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
			'menu_name' => 'Album Tags',
		  ); 
		  register_taxonomy('album-tag','albums',array(
			'hierarchical' => false,
			'labels' => $labels,
			'show_ui' => true,
			'update_count_callback' => '_update_post_term_count',
			'query_var' => true,
			'rewrite' => array( 'slug' => 'album-tag' ),
		  ));
		// adding tag end

	// adding album meta info start
		add_action( 'add_meta_boxes', 'cs_meta_album_add' );
		function cs_meta_album_add()
		{  
			add_meta_box( 'cs_meta_album', 'Album Options', 'cs_meta_album', 'albums', 'normal', 'high' );  
		}
		function cs_meta_album( $post ) {
			$cs_album = get_post_meta($post->ID, "cs_album", true);
			global $cs_xmlObject;
			if ( $cs_album <> "" ) {
				$cs_xmlObject = new SimpleXMLElement($cs_album);
					$album_release_date_db = $cs_xmlObject->album_release_date;
					$album_social_share_db = $cs_xmlObject->album_social_share;
					$cs_album_rating = $cs_xmlObject->cs_album_rating;
					$album_buynow = $cs_xmlObject->album_buynow;
					$album_buy_amazon_db = $cs_xmlObject->album_buy_amazon;
					$album_buy_apple_db = $cs_xmlObject->album_buy_apple;
					$album_buy_groov_db = $cs_xmlObject->album_buy_groov;
					$album_buy_cloud_db = $cs_xmlObject->album_buy_cloud;
					
					$album_related_db = $cs_xmlObject->album_related;
					$album_related_title_db = $cs_xmlObject->album_related_title;
					$album_tracks_title = $cs_xmlObject->album_tracks_title;
					$album_label = $cs_xmlObject->album_label;
					$album_price = $cs_xmlObject->album_price;
					if(isset($cs_xmlObject->var_cp_trainer) && $cs_xmlObject->var_cp_trainer <> ''){
						$var_cp_trainer = $cs_xmlObject->var_cp_trainer;
						if ($var_cp_trainer)
						{
							$var_cp_trainer = explode(",", $var_cp_trainer);
		
						}
					} else {
						$var_cp_trainer = array();
					}
 			}
			else {
				$album_release_date_db = '';
				$album_social_share_db = '';
				$cs_album_rating = '';
				$album_buynow = '';
				$album_buy_amazon_db = '';
				$album_buy_apple_db = '';
				$album_buy_groov_db = '';
				$album_buy_cloud_db = '';
				
				$album_related_db = '';
				$album_related_title_db = '';
				$album_tracks_title = '';
				$album_label = '';
				$album_price = '';
				$var_cp_trainer =  array();
 			}
?>
            <div class="page-wrap page-opts left" style="overflow:hidden; position:relative;">
            <script type="text/javascript" src="<?php echo get_template_directory_uri()?>/scripts/admin/jquery.scrollTo-min.js"></script>
			<script type="text/javascript" src="<?php echo get_template_directory_uri()?>/scripts/admin/select.js"></script>
            <script type="text/javascript" src="<?php echo get_template_directory_uri()?>/scripts/admin/prettyCheckable.js"></script>
                <div class="option-sec" style="margin-bottom:0;">
                    <div class="opt-conts">
                    	<ul class="form-elements">
                            <li class="to-label"><label>Release Date</label></li>
                            <li class="to-field">
                                    <!--date picker start-->
                                        <link rel="stylesheet" href="<?php echo get_template_directory_uri()?>/css/admin/jquery.ui.datepicker.css">
                                        <link rel="stylesheet" href="<?php echo get_template_directory_uri()?>/css/admin/jquery.ui.datepicker.theme.css">
                                        <script>
                                        jQuery(function($) {
                                            $( "#album_release_date" ).datepicker({
                                                defaultDate: "+1w",
                                                dateFormat: "yy-mm-dd",
												changeMonth: true,
                                                numberOfMonths: 1,
                                                //onSelect: function( selectedDate ) {
                                                    //$( "#cs_event_to_date" ).datepicker( "option", "minDate", selectedDate );
                                                //}
                                            });
                                        });
                                        </script>
                                    <!--date picker end-->
                                <input type="text" id="album_release_date" name="album_release_date" value="<?php if ($album_release_date_db=="") echo gmdate("Y-m-d"); else echo $album_release_date_db?>" />
                                <p>Put album release date</p>
                            </li>
                        </ul>
                        <ul class="form-elements">
                        <li class="to-label"><label>Singers</label></li>
                        <li class="to-field">
                            <select name="var_cp_trainer[]"  multiple="multiple"  class="dropdown" style="height: 100px !important;">
                                <option value="0">Select Performer</option>
                                <?php
                                    query_posts( array('posts_per_page' => "-1", 'post_status' => 'publish', 'post_type' => 'teams') );
                                        while ( have_posts()) : the_post();
                                        ?>
                                            <option <?php if (in_array(get_the_ID(), $var_cp_trainer)) { echo 'selected="selected"';}?> value="<?php the_ID()?>"><?php the_title()?></option>
                                        <?php
                                        endwhile;
                                ?>
                            </select>
                        </li>
                    </ul>
                        <ul class="form-elements">
                            <li class="to-label"><label>Album Label</label></li>
                            <li class="to-field">
                                <div class="on-off"><input type="text" name="album_label" value="<?php echo htmlspecialchars($album_label)?>" class="social" /></div>
                            </li>
                        </ul>
                        <ul class="form-elements">
                            <li class="to-label"><label>Album Price</label></li>
                            <li class="to-field">
                                <div class="on-off"><input type="text" name="album_price" value="<?php echo htmlspecialchars($album_price)?>" class="social" /></div>
                            </li>
                        </ul>
                        <ul class="form-elements">
                            <li class="to-label"><label>Social Sharing</label></li>
                            <li class="to-field">
                                <div class="on-off"><input type="checkbox" name="album_social_share" value="on" class="myClass" <?php if($album_social_share_db=='on')echo "checked"?> /></div>
                                <p>Make Social Sharing On/Off</p>
                            </li>
                        </ul>
                        <ul class="form-elements">
                            <li class="to-label"><label>Related Albums</label></li>
                            <li class="to-field">
                                <div class="on-off"><input type="checkbox" name="album_related" value="on" class="myClass" <?php if($album_related_db=='on')echo "checked"?> /></div>
                                <p>Make Related Albums On/Off</p>
                            </li>
                        </ul>
                        <ul class="form-elements">
                            <li class="to-label"><label>Related Albums Title</label></li>
                            <li class="to-field">
                                <div class="on-off"><input type="text" name="album_related_title" value="<?php echo htmlspecialchars($album_related_title_db)?>" class="social" /></div>
                            </li>
                        </ul>
                        
                       <div class="option-sec row" style="margin-bottom:0;">
                    <div class="opt-head">
                        <h4>Buy Now</h4>
                        <div class="clear"></div>
                    </div>
                    <div class="opt-conts">
                        <ul class="form-elements">
                            <li class="to-label"><label>Amazon</label></li>
                            <li class="to-field">
                            	<div class="social-preview"><span class="so-icon amazon">&nbsp;</span></div>
                                <input type="text" name="album_buy_amazon" value="<?php echo htmlspecialchars($album_buy_amazon_db)?>" class="social" />
                            </li>
                        </ul>
                        <ul class="form-elements">
                            <li class="to-label"><label>Apple ITunes</label></li>
                            <li class="to-field">
                                <div class="social-preview"><span class="so-icon itunes">&nbsp;</span></div>
                                <input type="text" name="album_buy_apple" value="<?php echo htmlspecialchars($album_buy_apple_db)?>" class="social" />
                            </li>
                        </ul>
                        <ul class="form-elements">
                            <li class="to-label"><label>Grooveshark</label></li>
                            <li class="to-field">
                                <div class="social-preview"><span class="so-icon groovshark">&nbsp;</span></div>
                                <input type="text" name="album_buy_groov" value="<?php echo htmlspecialchars($album_buy_groov_db)?>" class="social" />
                            </li>
                        </ul>
                        <ul class="form-elements noborder">
                            <li class="to-label"><label>Sound Cloud</label></li>
                            <li class="to-field">
                                <div class="social-preview"><span class="so-icon soundcloud">&nbsp;</span></div>
                                <input type="text" name="album_buy_cloud" value="<?php echo htmlspecialchars($album_buy_cloud_db)?>" class="social" />
                            </li>
                        </ul>
                        
                    </div>
					<div class="clear"></div>
                </div>
						
                       <ul class="form-elements">
                            <li class="to-label">
                                <label>Buy Now URL</label>
                            </li>
                        	<li class="to-field">
                            	<input type="text" name="album_buynow" value="<?php echo $album_buynow ?>" />
                            </li>
                       </ul>
                    </div>
					<div class="clear"></div>
                    <ul class="form-elements">
                        <li class="to-label">
                            <label>Album Tracks Title</label>
                        </li>
                        <li class="to-field"><input type="text" name="album_tracks_title" value="<?php echo $album_tracks_title ?>" />
                        <p>Put Album Tracks Area Title</p></li>
                   </ul>
                    
                </div>
                <div class="boxes tracklists">
                	<div id="add_track" class="poped-up">
                        <div class="opt-head">
                            <h5>Track Settings</h5>
                            <a href="javascript:closepopedup('add_track')" class="closeit">&nbsp;</a>
                            <div class="clear"></div>
                        </div>
                        <ul class="form-elements">
                            <li class="to-label"><label>Track Title</label></li>
                            <li class="to-field">
                            	<input type="text" id="album_track_title_dummy" name="album_track_title_dummy" value="Track Title" />
                                <p>Put album track title</p>
                            </li>
                        </ul>
                        <ul class="form-elements">
                            <li class="to-label"><label>Track MP3 URL</label></li>
                            <li class="to-field">
								<input id="album_track_mp3_url" name="album_track_mp3_url" value="" type="text" class="small" />
								<input id="album_track_mp3_url" name="album_track_mp3_url" type="button" class="uploadfile left" value="Browse"/>
                                <p>Put album track mp3 url</p>
                            </li>
                        </ul>
                        <ul class="form-elements">
                            <li class="to-label"><label>Playable</label></li>
                            <li class="to-field">
                                <select name="album_track_playable" id="album_track_playable" class="dropdown">
                                    <option>Yes</option>
                                    <option>No</option>
                                </select>
                                <p>Make Playable on/off</p>
                            </li>
                        </ul>
                        <ul class="form-elements">
                            <li class="to-label"><label>Downloadable</label></li>
                            <li class="to-field">
                                <select name="album_track_downloadable" id="album_track_downloadable" class="dropdown">
                                    <option>Yes</option>
                                    <option>No</option>
                                </select>
                                <p>Make Downloadable on/off</p>
                            </li>
                        </ul>
                        <ul class="form-elements">
                            <li class="to-label"><label>Buy MP3 URL</label></li>
                            <li class="to-field">
                            	<input type="text" name="album_track_buy_mp3" id="album_track_buy_mp3" value="" />
                                <p>Put mp3 url to buy</p>
                            </li>
                        </ul>
                        <ul class="form-elements noborder">
                            <li class="to-label"></li>
                            <li class="to-field"><input type="button" value="Add Track to List" onclick="add_track_to_list('<?php echo home_url()?>', '<?php echo get_template_directory_uri()?>')" /></li>
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
                        <h4 style="padding-top:12px;">Album Tracks</h4>
                        <a href="javascript:openpopedup('add_track')" class="button">Add Track</a>
                        <div class="clear"></div>
                    </div>
                    <table class="to-table" border="0" cellspacing="0">
                        <thead>
                            <tr>
                                <th style="width:80%;">Track Title</th>
                                <th style="width:80%;" class="centr">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="total_tracks">
                            <?php
								global $counter_track, $album_track_title, $album_track_mp3_url , $album_track_playable, $album_track_downloadable, $album_track_lyrics, $album_track_buy_mp3 ;
								$counter_track = $post->ID;
								if ( $cs_album <> "" ) {
									foreach ( $cs_xmlObject as $track ){
										if ( $track->getName() == "track" ) {
											$album_track_title = $track->album_track_title;
											$album_track_mp3_url = $track->album_track_mp3_url;
											$album_track_playable = $track->album_track_playable;
											$album_track_downloadable = $track->album_track_downloadable;
											$album_track_buy_mp3 = $track->album_track_buy_mp3;
											$counter_track++;
 											cs_add_track_to_list();
										}
									}
								}
							?>
                        </tbody>
                    </table>
                </div>
                <?php cs_meta_layout()?>
                <input type="hidden" name="album_meta_form" value="1" />
                <div class="clear"></div>
            </div>
            <div class="clear"></div>
<?php
		}

		if ( isset($_POST['album_meta_form']) and $_POST['album_meta_form'] == 1 ) {
			if ( empty($_POST['cs_layout']) ) $_POST['cs_layout'] = 'none';
			add_action( 'save_post', 'cs_meta_album_save' );  
			function cs_meta_album_save( $cs_post_id )
			{  
				$sxe = new SimpleXMLElement("<album></album>");
					if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return; 
					if ( empty($_POST["album_release_date"]) ) $_POST["album_release_date"] = "";
					if ( empty($_POST["album_social_share"]) ) $_POST["album_social_share"] = "";
					if ( empty($_POST["cs_album_rating"]) ) $_POST["cs_album_rating"] = "";
					if ( empty($_POST["album_buynow"]) ) $_POST["album_buynow"] = "";
					if ( empty($_POST["album_buy_amazon"]) ) $_POST["album_buy_amazon"] = "";
					if ( empty($_POST["album_buy_apple"]) ) $_POST["album_buy_apple"] = "";
					if ( empty($_POST["album_buy_groov"]) ) $_POST["album_buy_groov"] = "";
					if ( empty($_POST["album_buy_cloud"]) ) $_POST["album_buy_cloud"] = "";
					if ( empty($_POST["album_price"]) ) $_POST["album_price"] = "";
					if ( empty($_POST["album_tracks_title"]) ) $_POST["album_tracks_title"] = "";
					
					if ( empty($_POST["album_related_title"]) ) $_POST["album_related_title"] = "";
					if ( empty($_POST["album_related"]) ) $_POST["album_related"] = "";
					if ( empty($_POST["album_label"]) ) $_POST["album_label"] = "";
					if (empty($_POST["var_cp_trainer"])){ $var_cp_trainer = "";} else {
						$var_cp_trainer = implode(",", $_POST["var_cp_trainer"]);
					}
					
						$sxe = save_layout_xml($sxe);
								$sxe->addChild('album_release_date', $_POST['album_release_date'] );
								$sxe->addChild('album_social_share', $_POST['album_social_share'] );
								$sxe->addChild('cs_album_rating', $_POST['cs_album_rating'] );
 								$sxe->addChild('album_buynow', htmlspecialchars($_POST['album_buynow']) );
								$sxe->addChild('album_buy_amazon', htmlspecialchars($_POST['album_buy_amazon']) );
								$sxe->addChild('album_buy_apple', htmlspecialchars($_POST['album_buy_apple']) );
								$sxe->addChild('album_buy_groov', htmlspecialchars($_POST['album_buy_groov']) );
								$sxe->addChild('album_buy_cloud', htmlspecialchars($_POST['album_buy_cloud']) );
								
								$sxe->addChild('album_tracks_title', htmlspecialchars($_POST['album_tracks_title']) );
								$sxe->addChild('album_related_title', htmlspecialchars($_POST['album_related_title']) );
								$sxe->addChild('album_related', htmlspecialchars($_POST['album_related']) );
								$sxe->addChild('album_label', htmlspecialchars($_POST['album_label']) );
								$sxe->addChild('album_price', htmlspecialchars($_POST['album_price']) );
								$sxe->addChild('var_cp_trainer', $var_cp_trainer);
							$counter = 0;
							if ( isset($_POST['album_track_title']) ) {
								foreach ( $_POST['album_track_title'] as $count ){
									$track = $sxe->addChild('track');
										$track->addChild('album_track_title', htmlspecialchars($_POST['album_track_title'][$counter]) );
										$track->addChild('album_track_mp3_url', htmlspecialchars($_POST['album_track_mp3_url'][$counter]) );
										$track->addChild('album_track_playable', $_POST['album_track_playable'][$counter] );
										$track->addChild('album_track_downloadable', $_POST['album_track_downloadable'][$counter] );
		
										$track->addChild('album_track_buy_mp3', htmlspecialchars($_POST['album_track_buy_mp3'][$counter]) );
										$counter++;
								}
							}
				update_post_meta( $cs_post_id, 'cs_album', $sxe->asXML() );
			}
		}
		// adding album meta info end
?>