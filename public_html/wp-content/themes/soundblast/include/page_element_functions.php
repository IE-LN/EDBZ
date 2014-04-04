<?php 

// page bulider items start
// to make a copy of media image for slider start
function cs_slider_clone(){
	global $cs_node, $counter;
	if( isset($_POST['action']) ) {
		$cs_node = new stdClass();
		$cs_node->title = '';
		$cs_node->description = '';
		$cs_node->link = '';
		$cs_node->link_target = '';
		$cs_node->use_image_as = '';
		$cs_node->video_code = '';
	}
	if ( isset($_POST['counter']) ) $counter = $_POST['counter'];
	if ( isset($_POST['path']) ) $cs_node->path = $_POST['path'];
?>
    <li class="ui-state-default" id="<?php echo $counter?>">
        <div class="thumb-secs">
            <?php $image_path = wp_get_attachment_image_src( $cs_node->path, array( get_option("thumbnail_size_w"),get_option("thumbnail_size_h") ) );?>
            <img src="<?php echo $image_path[0]?>" alt="">
            <div class="gal-edit-opts">
                <!--<a href="#" class="resize"></a>-->
                <a href="javascript:slidedit(<?php echo $counter?>)" class="edit"></a>
                <a href="javascript:del_this(<?php echo $counter?>)" class="delete"></a>
            </div>
        </div>
        <div class="poped-up" id="edit_<?php echo $counter?>">
            <div class="opt-head">
                <h5>Edit Options</h5>
                <a href="javascript:slideclose(<?php echo $counter?>)" class="closeit">&nbsp;</a>
                <div class="clear"></div>
            </div>
            <div class="opt-conts">
                <ul class="form-elements">
                    <li class="to-label"><label>Image Title</label></li>
                    <li class="to-field"><input type="text" name="cs_slider_title[]" value="<?php echo htmlspecialchars($cs_node->title)?>" class="txtfield" /></li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Image Description</label></li>
                    <li class="to-field"><textarea class="txtarea" name="cs_slider_description[]"><?php echo htmlspecialchars($cs_node->description)?></textarea></li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Link</label></li>
                    <li class="to-field"><input type="text" name="cs_slider_link[]" value="<?php echo htmlspecialchars($cs_node->link)?>" class="txtfield" /></li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Link Target</label></li>
                    <li class="to-field">
                        <select name="cs_slider_link_target[]" class="select_dropdown">
                            <option <?php if($cs_node->link_target=="_self")echo "selected";?> >_self</option>
                            <option <?php if($cs_node->link_target=="_blank")echo "selected";?> >_blank</option>
                        </select>
                        <p>Please select image target.</p>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"></li>
                    <li class="to-field">
                        <input type="hidden" name="path[]" value="<?php echo $cs_node->path?>" />
                        <input type="button" value="Submit" onclick="javascript:slideclose(<?php echo $counter?>)" class="close-submit" />
                    </li>
                </ul>
                <div class="clear"></div>
            </div>
        </div>
    </li>
<?php
	if ( isset($_POST['action']) ) die();
}
add_action('wp_ajax_slider_clone', 'cs_slider_clone');
// to make a copy of media image for slider end

// to make a copy of media image for gallery start
function cs_gallery_clone(){
	global $cs_node, $counter;
	if( isset($_POST['action']) ) {
		$cs_node = new stdClass();
		$cs_node->title = "";
		$cs_node->description = "";
		$cs_node->use_image_as = "";
		$cs_node->video_code = "";
		$cs_node->link_url = "";
		$cs_node->use_image_as_db = "";
		$cs_node->link_url_db = '';
	}
	if ( isset($_POST['counter']) ) $counter = $_POST['counter'];
	if ( isset($_POST['path']) ) $cs_node->path = $_POST['path'];
?>
    <li class="ui-state-default" id="<?php echo $counter?>">
        <div class="thumb-secs">
            <?php $image_path = wp_get_attachment_image_src( $cs_node->path, array( get_option("thumbnail_size_w"),get_option("thumbnail_size_h") ) );?>
            <img src="<?php echo $image_path[0]?>" alt="">
            <div class="gal-edit-opts">
                <!--<a href="#" class="resize"></a>-->
                <a href="javascript:galedit(<?php echo $counter?>)" class="edit"></a>
                <a href="javascript:del_this(<?php echo $counter?>)" class="delete"></a>
            </div>
        </div>
        <div class="poped-up" id="edit_<?php echo $counter?>">
            <div class="opt-head">
                <h5>Edit Options</h5>
                <a href="javascript:galclose(<?php echo $counter?>)" class="closeit">&nbsp;</a>
            </div>
            <div class="opt-conts">
                <ul class="form-elements">
                    <li class="to-label"><label>Image Title</label></li>
                    <li class="to-field"><input type="text" name="title[]" value="<?php echo htmlspecialchars($cs_node->title)?>" class="txtfield" /></li>
                </ul>
                <!--<ul class="form-elements">
                    <li class="to-label"><label>Image Description</label></li>
                    <li class="to-field"><textarea class="txtarea" name="description[]"><?php //echo htmlspecialchars($cs_node->description)?></textarea></li>
                </ul>-->
                <ul class="form-elements">
                    <li class="to-label"><label>Use Image As</label></li>
                    <li class="to-field">
                        <select name="use_image_as[]" class="select_dropdown" onchange="cs_toggle_gal(this.value, <?php echo $counter?>)">
                            <option <?php if($cs_node->use_image_as=="0")echo "selected";?> value="0">LightBox to current thumbnail</option>
                            <option <?php if($cs_node->use_image_as=="1")echo "selected";?> value="1">LightBox to Video</option>
                            <option <?php if($cs_node->use_image_as=="2")echo "selected";?> value="2">Link URL</option>
                        </select>
                        <p>Please select Image link where it will go.</p>
                    </li>
                </ul>
                <ul class="form-elements" id="video_code<?php echo $counter?>" <?php if($cs_node->use_image_as=="0" or $cs_node->use_image_as=="" or $cs_node->use_image_as=="2")echo 'style="display:none"';?> >
                    <li class="to-label"><label>Video URL</label></li>
                    <li class="to-field">
                        <input type="text" name="video_code[]" value="<?php echo htmlspecialchars($cs_node->video_code)?>" class="txtfield" />
                        <p>(Enter Specific Video URL Youtube or Vimeo)</p>
                    </li>
                </ul>
                <ul class="form-elements" id="link_url<?php echo $counter?>" <?php if($cs_node->use_image_as=="0" or $cs_node->use_image_as=="" or $cs_node->use_image_as=="1")echo 'style="display:none"';?> >
                    <li class="to-label"><label>Link URL</label></li>
                    <li class="to-field">
                        <input type="text" name="link_url[]" value="<?php echo htmlspecialchars($cs_node->link_url)?>" class="txtfield" />
                        <p>(Enter Specific Link URL)</p>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"></li>
                    <li class="to-field">
                        <input type="hidden" name="path[]" value="<?php echo $cs_node->path?>" />
                        <input type="button" onclick="javascript:galclose(<?php echo $counter?>)" value="Submit" class="close-submit" />
                    </li>
                </ul>
                <div class="clear"></div>
            </div>
        </div>
    </li>
<?php
	if ( isset($_POST['action']) ) die();
}
add_action('wp_ajax_gallery_clone', 'cs_gallery_clone');
// to make a copy of media image for gallery end

// Album page builder function
function cs_pb_album($die = 0){
	global $cs_node, $count_node, $post;
	if ( isset($_POST['action']) ) {
		$name = $_POST['action'];
		$counter = $_POST['counter'];
		$album_element_size = '25';
		$cs_album_cat_db = '';
		$cs_album_view = '';
		$cs_album_title = '';
		$cs_album_filterable_db = '';
		$cs_album_cat_show_db = '';
		$cs_album_buynow_db = '';
		$cs_album_pagination_db = '';
 		$cs_album_per_page_db = '';
	}
	else {
		$name = $cs_node->getName();
			$count_node++;
			$album_element_size = $cs_node->album_element_size;
			$cs_album_title = $cs_node->cs_album_title;
			$cs_album_cat_db = $cs_node->cs_album_cat;
			$cs_album_view = $cs_node->cs_album_view;
			$cs_album_filterable_db = $cs_node->cs_album_filterable;
			$cs_album_cat_show_db = $cs_node->cs_album_cat_show;
			$cs_album_buynow_db = $cs_node->cs_album_buynow;
			$cs_album_pagination_db = $cs_node->cs_album_pagination;
 			$cs_album_per_page_db = $cs_node->cs_album_per_page;
				$counter = $post->ID.$count_node;
	}
?> 
	<div id="<?php echo $name.$counter?>_del" class="column parentdelete column_<?php echo $album_element_size?>" item="album" data="<?php echo element_size_data_array_index($album_element_size)?>" >
		<div class="column-in">
            <h5><?php echo ucfirst(str_replace("cs_pb_","",$name))?></h5>
            <input type="hidden" name="album_element_size[]" class="item" value="<?php echo $album_element_size?>" >
            <a href="javascript:hide_all('<?php echo $name.$counter?>')" class="options">Options</a>
            <a href="#" class="delete-it btndeleteit">Del</a> &nbsp; 
            <a class="decrement" onclick="javascript:decrement(this)">Dec</a> &nbsp; 
            <a class="increment" onclick="javascript:increment(this)">Inc</a>
		</div>
        <div class="poped-up" id="<?php echo $name.$counter?>" style="border:none; background:#f8f8f8;" >
            <div class="opt-head">
                <h5>Edit Album Options</h5>
                <a href="javascript:show_all('<?php echo $name.$counter?>')" class="closeit">&nbsp;</a>
            </div>
            <div class="opt-conts">
            	<ul class="form-elements">
                    <li class="to-label"><label>Album Title</label></li>
                    <li class="to-field">
                        <input type="text" name="cs_album_title[]" class="txtfield" value="<?php echo htmlspecialchars($cs_album_title)?>" />
                        <p>Album Page Title</p>
                    </li>                                            
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Choose Category</label></li>
                    <li class="to-field">
                        <select name="cs_album_cat[]" class="dropdown">
                        	<option value="0">-- Select Category --</option>
                        	<?php show_all_cats('', '', $cs_album_cat_db, "album-category");?>
                        </select>
                        <p>Choose category to show albums list</p>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Select View</label></li>
                    <li class="to-field">
                        <select name="cs_album_view[]" class="dropdown">
                         	<option <?php if($cs_album_view=="List View")echo "selected";?>>List View</option>
                            <option <?php if($cs_album_view=="single_view")echo "selected";?> value="single_view">Single View</option>
                          	<option <?php if($cs_album_view=="Grid View")echo "selected";?>>Grid View</option>
                            <option <?php if($cs_album_view=="home_view")echo "selected";?> value="home_view">Home page View</option>
                        </select>
                    </li>                                        
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Show Category</label></li>
                    <li class="to-field">
                        <select name="cs_album_cat_show[]" class="dropdown">
                            <option <?php if($cs_album_cat_show_db=="On")echo "selected";?> >On</option>
                            <option <?php if($cs_album_cat_show_db=="Off")echo "selected";?> >Off</option>
                        </select>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Buy Now</label></li>
                    <li class="to-field">
                        <select name="cs_album_buynow[]" class="dropdown">
                            <option <?php if($cs_album_buynow_db=="On")echo "selected";?> >On</option>
                            <option <?php if($cs_album_buynow_db=="Off")echo "selected";?> >Off</option>
                        </select>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Filterable</label></li>
                    <li class="to-field">
                        <select name="cs_album_filterable[]" class="dropdown">
                            <option <?php if($cs_album_filterable_db=="Off")echo "selected";?> >Off</option>
                            <option <?php if($cs_album_filterable_db=="On")echo "selected";?> >On</option>
                        </select>
                    </li>
                </ul>

				<ul class="form-elements">
                    <li class="to-label"><label>Pagination</label></li>
                    <li class="to-field">
                        <select name="cs_album_pagination[]" class="dropdown" >
                            <option <?php if($cs_album_pagination_db=="Show Pagination")echo "selected";?> >Show Pagination</option>
                            <option <?php if($cs_album_pagination_db=="Single Page")echo "selected";?> >Single Page</option>
                        </select>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>No. of Album Per Page</label></li>
                    <li class="to-field">
                        <input type="text" name="cs_album_per_page[]" class="txtfield" value="<?php echo $cs_album_per_page_db;?>" />
                        <p>To display all the records, leave this field blank.</p>
                    </li>
                </ul>
                <ul class="form-elements noborder">
                    <li class="to-label"><label></label></li>
                    <li class="to-field">
                    	<input type="hidden" name="cs_orderby[]" value="album" />
                        <input type="button" value="Save" style="margin-right:10px;" onclick="javascript:show_all('<?php echo $name.$counter?>')" />
                    </li>
                </ul>
            </div>
       </div>
    </div>
<?php
	if ( $die <> 1 ) die();
}
add_action('wp_ajax_cs_pb_album', 'cs_pb_album');

add_action('wp_ajax_cs_pb_parallax', 'cs_pb_parallax');
// parallax html form for page builder end

// add Album tracks function
function cs_add_track_to_list(){
	global $counter_track, $album_track_title, $album_track_mp3_url , $album_track_playable, $album_track_downloadable, $album_track_buy_mp3 ;
	foreach ($_POST as $keys=>$values) {
		$$keys = $values;
	}
?>
    <tr id="edit_track<?php echo $counter_track?>">
        <td id="album-title<?php echo $counter_track?>" style="width:80%;"><?php echo $album_track_title?></td>
        <td class="centr" style="width:20%;">
            <a href="javascript:openpopedup('edit_track_form<?php echo $counter_track?>')" class="actions edit">&nbsp;</a>
            <a onclick="javascript:return confirm('Are you sure! You want to delete this Track')" href="javascript:cs_div_remove('edit_track<?php echo $counter_track?>')" class="actions delete">&nbsp;</a>
            <div class="poped-up" id="edit_track_form<?php echo $counter_track?>">
                <div class="opt-head">
                    <h5>Track Settings</h5>
                    <a href="javascript:closepopedup('edit_track_form<?php echo $counter_track?>')" class="closeit">&nbsp;</a>
                    <div class="clear"></div>
                </div>
                <ul class="form-elements">
                    <li class="to-label"><label>Track Title</label></li>
                    <li class="to-field">
                        <input type="text" name="album_track_title[]" value="<?php echo htmlspecialchars($album_track_title)?>" id="album_track_title<?php echo $counter_track?>" />
                        <p>Put album track title</p>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Track MP3 URL</label></li>
                    <li class="to-field">
                        <input id="album_track_mp3_url<?php echo $counter_track?>" name="album_track_mp3_url[]" value="<?php echo htmlspecialchars($album_track_mp3_url)?>" type="text" class="small" />
                        <input id="album_track_mp3_url<?php echo $counter_track?>" name="album_track_mp3_url<?php echo $counter_track?>" type="button" class="uploadfile left" value="Browse"/>
                        <p>Put album track mp3 url</p>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Playable</label></li>
                    <li class="to-field">
                        <select name="album_track_playable[]" class="dropdown">
                            <option <?php if($album_track_playable=="Yes")echo "selected";?> >Yes</option>
                            <option <?php if($album_track_playable=="No")echo "selected";?> >No</option>
                        </select>
                        <p>Make Playable on/off</p>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Downloadable</label></li>
                    <li class="to-field">
                        <select name="album_track_downloadable[]" class="dropdown">
                            <option <?php if($album_track_downloadable=="Yes")echo "selected";?> >Yes</option>
                            <option <?php if($album_track_downloadable=="No")echo "selected";?> >No</option>
                        </select>
                        <p>Make Playable on/off</p>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Buy MP3 URL</label></li>
                    <li class="to-field">
                        <input type="text" name="album_track_buy_mp3[]" value="<?php echo htmlspecialchars($album_track_buy_mp3)?>" />
                        <p>Put album track mp3 url</p>
                    </li>
                </ul>
                <ul class="form-elements noborder">
                    <li class="to-label"><label></label></li>
                    <li class="to-field"><input type="button" value="Update Track" onclick="update_title(<?php echo $counter_track?>); closepopedup('edit_track_form<?php echo $counter_track?>')" /></li>
                </ul>
            </div>
        </td>
    </tr>
<?php
	if ( isset($action) ) die();
}
add_action('wp_ajax_cs_add_track_to_list', 'cs_add_track_to_list');

// gallery html form for page builder start
function cs_pb_gallery($die = 0){
	global $cs_node, $count_node, $post;
	if ( isset($_POST['action']) ) {
			$name = $_POST['action'];
			$counter = $_POST['counter'];
			$gallery_element_size = '50';
			$cs_gal_header_title_db = '';
			$cs_gal_layout_db = '';
			$cs_gal_album_db = '';
 			$cs_gal_desc_db = '';
			$cs_gal_pagination_db = '';
			$cs_gal_media_per_page_db = get_option("posts_per_page");
	}
	else {
		$name = $cs_node->getName();
			$count_node++;
			$gallery_element_size = $cs_node->gallery_element_size;
			$cs_gal_header_title_db = $cs_node->header_title;
			$cs_gal_layout_db = $cs_node->layout;
			$cs_gal_album_db = $cs_node->album;
 			$cs_gal_desc_db = $cs_node->desc;
			$cs_gal_pagination_db = $cs_node->pagination;
			$cs_gal_media_per_page_db = $cs_node->media_per_page;
				$counter = $post->ID.$count_node;
	}
?> 
	<div id="<?php echo $name.$counter?>_del" class="column  parentdelete column_<?php echo $gallery_element_size?>" item="gallery" data="<?php echo element_size_data_array_index($gallery_element_size)?>" >
		<div class="column-in">
            <h5><?php echo ucfirst(str_replace("cs_pb_","",$name))?></h5>
            <input type="hidden" name="gallery_element_size[]" class="item" value="<?php echo $gallery_element_size?>" >
            <a href="javascript:hide_all('<?php echo $name.$counter?>')" class="options">Options</a> &nbsp; 
            <a href="#" class="delete-it btndeleteit">Del</a> &nbsp;  
            <a class="decrement" onclick="javascript:decrement(this)">Dec</a> &nbsp; 
            <a class="increment" onclick="javascript:increment(this)">Inc</a>
		</div>
        <div class="poped-up" id="<?php echo $name.$counter?>" style="border:none; background:#f8f8f8;" >
            <div class="opt-head">
                <h5>Edit Gallery Options</h5>
                <a href="javascript:show_all('<?php echo $name.$counter?>')" class="closeit">&nbsp;</a>
            </div>
            <div class="opt-conts">
            	<ul class="form-elements">
                    <li class="to-label"><label>Gallery Header Title</label></li>
                    <li class="to-field">
                        <input type="text" name="cs_gal_header_title[]" class="txtfield" value="<?php echo htmlspecialchars($cs_gal_header_title_db)?>" />
                        <p>Please enter gallery header title.</p>
                    </li>                    
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Choose Gallery Layout</label></li>
                    <li class="to-field">
                        <select name="cs_gal_layout[]" class="dropdown">
                            <option value="gallery-four-col" <?php if($cs_gal_layout_db=="gallery-four-col")echo "selected";?> >4 Column</option>
                            <option value="gallery-three-col" <?php if($cs_gal_layout_db=="gallery-three-col")echo "selected";?> >3 Column</option>
                            <option value="gallery-tow-col" <?php if($cs_gal_layout_db=="gallery-tow-col")echo "selected";?> >2 Column</option>
                        </select>
                        
                        <p>Select gallery layout, double column, three column or four column.</p>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Choose Gallery/Album</label></li>
                    <li class="to-field">
                        <select name="cs_gal_album[]" class="dropdown">
                        	<option value="0">-- Select Gallery --</option>
                            <?php
                                $query = array( 'posts_per_page' => '-1', 'post_type' => 'cs_gallery', 'orderby'=>'ID', 'post_status' => 'publish' );
                                $wp_query = new WP_Query($query);
                                while ($wp_query->have_posts()) : $wp_query->the_post();
                            ?>
                                <option <?php if($post->post_name==$cs_gal_album_db)echo "selected";?> value="<?php echo $post->post_name; ?>"><?php echo get_the_title()?></option>
                            <?php
                                endwhile;
                            ?>
                        </select>
                        <p>Select gallery album to show images.</p>
                    </li>
                </ul>
                <!--<ul class="form-elements">
                    <li class="to-label"><label>Show Description</label></li>
                    <li class="to-field">
                        <select name="cs_gal_desc[]" class="dropdown">
                            <option <?php //if($cs_gal_desc_db=="On")echo "selected";?> >On</option>
                            <option <?php //if($cs_gal_desc_db=="Off")echo "selected";?> >Off</option>
                        </select>
                    </li>
                </ul>-->
                <ul class="form-elements">
                    <li class="to-label"><label>Pagination</label></li>
                    <li class="to-field">
                        <select name="cs_gal_pagination[]" class="dropdown" >
                            <option <?php if($cs_gal_pagination_db=="Show Pagination")echo "selected";?> >Show Pagination</option>
                            <option <?php if($cs_gal_pagination_db=="Single Page")echo "selected";?> >Single Page</option>
                        </select>
                    </li>
                </ul>
				<ul class="form-elements" >
                    <li class="to-label"><label>No. of Media Per Page</label></li>
                    <li class="to-field">
                    	<input type="text" name="cs_gal_media_per_page[]" class="txtfield" value="<?php echo $cs_gal_media_per_page_db; ?>" />
                        <p>To display all the records, leave this field blank.</p>
                    </li>
                </ul>
                <ul class="form-elements noborder">
                    <li class="to-label"></li>
                    <li class="to-field">
                    	<input type="hidden" name="cs_orderby[]" value="gallery" />
                        <input type="button" value="Save" style="margin-right:10px;" onclick="javascript:show_all('<?php echo $name.$counter?>')" />
                    </li>
                </ul>
            </div>
       </div>
    </div>
<?php
	if ( $die <> 1 ) die();
}
add_action('wp_ajax_cs_pb_gallery', 'cs_pb_gallery');
// gallery html form for page builder end

// Sets gallery  html form for page builder start
function cs_pb_gallery_albums($die = 0){
	global $cs_node, $count_node, $post;
	if ( isset($_POST['action']) ) {
			$name = $_POST['action'];
			$counter = $_POST['counter'];
			$gallery_element_size = '50';
			$cs_gal_header_title_db = '';
			$cs_gal_album_db = '';
 			$cs_gal_desc_db = '';
			$cs_gal_album_view_title = '';
			$cs_gal_album_view_url = '';
			$cs_gal_pagination_db = '';
			$cs_gal_media_per_page_db = get_option("posts_per_page");
	}
	else {
		$name = $cs_node->getName();
			$count_node++;
			$gallery_element_size = $cs_node->cs_gallery_album_element_size;
			$cs_gal_header_title_db = $cs_node->cs_gal_album_header_title;
			$cs_gal_album_db = $cs_node->cs_gal_album;
			$cs_gal_album_view_title = $cs_node->cs_gal_album_view_title;
			$cs_gal_album_view_url = $cs_node->cs_gal_album_view_url;
			$cs_gal_pagination_db = $cs_node->cs_gal_album_pagination;
			$cs_gal_media_per_page_db = $cs_node->cs_gal_album_media_per_page;
				$counter = $post->ID.$count_node;
	}
?> 
	<div id="<?php echo $name.$counter?>_del" class="column  parentdelete column_<?php echo $gallery_element_size?>" item="gallery" data="<?php echo element_size_data_array_index($gallery_element_size)?>" >
		<div class="column-in">
            <h5><?php echo ucfirst(str_replace("cs_pb_","",$name))?></h5>
            <input type="hidden" name="cs_gallery_album_element_size[]" class="item" value="<?php echo $gallery_element_size?>" >
            <a href="javascript:hide_all('<?php echo $name.$counter?>')" class="options">Options</a> &nbsp; 
            <a href="#" class="delete-it btndeleteit">Del</a> &nbsp;  
            <a class="decrement" onclick="javascript:decrement(this)">Dec</a> &nbsp; 
            <a class="increment" onclick="javascript:increment(this)">Inc</a>
		</div>
        <div class="poped-up" id="<?php echo $name.$counter?>" style="border:none; background:#f8f8f8;" >
            <div class="opt-head">
                <h5>Edit Gallery Options</h5>
                <a href="javascript:show_all('<?php echo $name.$counter?>')" class="closeit">&nbsp;</a>
            </div>
            <div class="opt-conts">
            	<ul class="form-elements">
                    <li class="to-label"><label>Gallery Header Title</label></li>
                    <li class="to-field">
                        <input type="text" name="cs_gal_album_header_title[]" class="txtfield" value="<?php echo htmlspecialchars($cs_gal_header_title_db)?>" />
                        <p>Please enter gallery header title.</p>
                    </li>                    
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>View All Title</label></li>
                    <li class="to-field">
                        <input type="text" name="cs_gal_album_view_title[]" class="txtfield" value="<?php echo htmlspecialchars($cs_gal_album_view_title)?>" />
                        <p>Please enter gallery View All Title.</p>
                    </li>                    
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>View All URL</label></li>
                    <li class="to-field">
                        <input type="text" name="cs_gal_album_view_url[]" class="txtfield" value="<?php echo htmlspecialchars($cs_gal_album_view_url)?>" />
                        <p>Please enter gallery View All URL.</p>
                    </li>                    
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Choose Gallery/Album</label></li>
                    <li class="to-field">
                        <select name="cs_gal_album[]" class="dropdown">
                        	<option value="0">-- Select Gallery --</option>
                            <?php
								$categories = get_categories( array('taxonomy' => 'cs_gallery-category', 'hide_empty' => 0) );
								foreach ($categories as $category) {
                            ?>
                                <option <?php if($category->slug==$cs_gal_album_db)echo "selected";?> value="<?php echo $category->slug; ?>"><?php echo $category->cat_name?></option>
                            <?php
								}
                            ?>
                        </select>
                        <p>Select gallery album to show images.</p>
                    </li>
                </ul>
                
                <ul class="form-elements">
                    <li class="to-label"><label>Pagination</label></li>
                    <li class="to-field">
                        <select name="cs_gal_album_pagination[]" class="dropdown" >
                            <option <?php if($cs_gal_pagination_db=="Show Pagination")echo "selected";?> >Show Pagination</option>
                            <option <?php if($cs_gal_pagination_db=="Single Page")echo "selected";?> >Single Page</option>
                        </select>
                    </li>
                </ul>
				<ul class="form-elements" >
                    <li class="to-label"><label>No. of Media Per Page</label></li>
                    <li class="to-field">
                    	<input type="text" name="cs_gal_album_media_per_page[]" class="txtfield" value="<?php echo $cs_gal_media_per_page_db; ?>" />
                        <p>To display all the records, leave this field blank.</p>
                    </li>
                </ul>
                <ul class="form-elements noborder">
                    <li class="to-label"></li>
                    <li class="to-field">
                    	<input type="hidden" name="cs_orderby[]" value="gallery_albums" />
                        <input type="button" value="Save" style="margin-right:10px;" onclick="javascript:show_all('<?php echo $name.$counter?>')" />
                    </li>
                </ul>
            </div>
       </div>
    </div>
<?php
	if ( $die <> 1 ) die();
}
add_action('wp_ajax_cs_pb_gallery_albums', 'cs_pb_gallery_albums');
// Sets gallery html form for page builder end
// slider html form for page builder start
function cs_pb_slider($die = 0){
	global $cs_node, $count_node, $post;
	if ( isset($_POST['action']) ) {
		$name = $_POST['action'];
		$counter = $_POST['counter'];
		$slider_element_size = '50';
		$cs_slider_header_title_db = '';
		$cs_slider_db = '';
		$cs_slider_width_db = '';
		$cs_slider_height_db = '';
		$slider_view= '';
		$slider_id ='';
	}
	else {
		$name = $cs_node->getName();
			$count_node++;
			$slider_element_size = $cs_node->slider_element_size;
			$cs_slider_header_title_db = $cs_node->slider_header_title;
			$cs_slider_db = $cs_node->slider;
			$slider_view=  $cs_node->slider_view;
			$slider_id = $cs_node->slider_id;
			$cs_slider_width_db = $cs_node->width;
			$cs_slider_height_db = $cs_node->height;
				$counter = $post->ID.$count_node;
	}
?>
	<div id="<?php echo $name.$counter?>_del" class="column  parentdelete column_<?php echo $slider_element_size?>" item="slider" data="<?php echo element_size_data_array_index($slider_element_size)?>" >
		<div class="column-in">
            <h5><?php echo ucfirst(str_replace("cs_pb_","",$name))?></h5>
            <input type="hidden" name="slider_element_size[]" class="item" value="<?php echo $slider_element_size?>" >
            <a href="javascript:hide_all('<?php echo $name.$counter?>')" class="options">Options</a>
            <a href="#" class="delete-it btndeleteit">Del</a> &nbsp;
            <a class="decrement" onclick="javascript:decrement(this)">Dec</a> &nbsp; 
            <a class="increment" onclick="javascript:increment(this)">Inc</a>
		</div>
        <div class="poped-up" id="<?php echo $name.$counter?>" style="border:none; background:#f8f8f8;" >
            <div class="opt-head">
                <h5>Edit Slider Options</h5>
                <a href="javascript:show_all('<?php echo $name.$counter?>')" class="closeit">&nbsp;</a>
            </div>
            <div class="opt-conts">
            	<ul class="form-elements">
                    <li class="to-label"><label>Slider Header Title</label></li>
                    <li class="to-field">
                        <input type="text" name="cs_slider_header_title[]" class="txtfield" value="<?php echo htmlspecialchars($cs_slider_header_title_db)?>" />
                        <p>Please enter slider header title.</p>
                    </li>                    
                </ul>
            	
                <ul class="form-elements">
                    <li class="to-label"><label>Choose Slider</label></li>
                    <li class="to-field">
                        <select name="cs_slider[]" class="dropdown">
                             <?php
                                $query = array( 'posts_per_page' => '-1', 'post_type' => 'cs_slider', 'orderby'=>'ID', 'post_status' => 'publish' );
                                $wp_query = new WP_Query($query);
                                while ($wp_query->have_posts()) : $wp_query->the_post();
                            ?>
                                <option <?php if($post->post_name==$cs_slider_db)echo "selected";?> value="<?php echo $post->post_name; ?>"><?php the_title()?></option>
                            <?php
                                endwhile;
                            ?>
                        </select>
                    </li>
                </ul>
                <ul class="form-elements" >
                    <li class="to-label"><label>Slider View</label></li>
                    <li class="to-field">
                        <select name="slider_view[]" class="dropdown" >
                            <option <?php if($slider_view=="content")echo "selected";?> >content</option>
                            <option <?php if($slider_view=="header")echo "selected";?> >header</option>
                         </select>
                    </li>
                </ul>
                <ul class="form-elements noborder">
                    <li class="to-label"></li>
                    <li class="to-field">
                    	<input type="hidden" name="cs_orderby[]" value="slider" />
                        <input type="button" value="Save" style="margin-right:10px;" onclick="javascript:show_all('<?php echo $name.$counter?>')" />
                    </li>
                </ul>
            </div>
       </div>
    </div>
<?php
	if ( $die <> 1 ) die();
}
add_action('wp_ajax_cs_pb_slider', 'cs_pb_slider');
// slider html form for page builder end

// blog html form for page builder start
function cs_pb_blog($die = 0){
	global $cs_node, $count_node, $post;
	if ( isset($_POST['action']) ) {
		$name = $_POST['action'];
		$counter = $_POST['counter'];
		$blog_element_size = '50';
		$cs_blog_title_db = '';
		$cs_blog_view_db = '';
		$cs_blog_cat_db = '';
		$cs_blog_excerpt_db = '255';
		$cs_blog_num_post_db = get_option("posts_per_page");
		$cs_blog_pagination_db = '';
		$cs_blog_pagination_db = '';
	}
	else {
		$name = $cs_node->getName();
			$count_node++;
			$blog_element_size = $cs_node->blog_element_size;
			$cs_blog_title_db = $cs_node->cs_blog_title;
			$cs_blog_view_db = $cs_node->cs_blog_view;
			$cs_blog_cat_db = $cs_node->cs_blog_cat;
			$cs_blog_excerpt_db = $cs_node->cs_blog_excerpt;
			$cs_blog_num_post_db = $cs_node->cs_blog_num_post;
			$cs_blog_pagination_db = $cs_node->cs_blog_pagination;
			$cs_blog_description_db = $cs_node->cs_blog_description;
				$counter = $post->ID.$count_node;
}
?> 
	<div id="<?php echo $name.$counter?>_del" class="column  parentdelete column_<?php echo $blog_element_size?>" item="blog" data="<?php echo element_size_data_array_index($blog_element_size)?>" >
		<div class="column-in">
            <h5><?php echo ucfirst(str_replace("cs_pb_","",$name))?></h5>
            <input type="hidden" name="blog_element_size[]" class="item" value="<?php echo $blog_element_size?>" >
            <a href="javascript:hide_all('<?php echo $name.$counter?>')" class="options">Options</a>
            <a href="#" class="delete-it btndeleteit">Del</a> &nbsp;
            <a class="decrement" onclick="javascript:decrement(this)">Dec</a> &nbsp; 
            <a class="increment" onclick="javascript:increment(this)">Inc</a>
		</div>
       	<div class="poped-up" id="<?php echo $name.$counter?>" style="border:none; background:#f8f8f8;" >
            <div class="opt-head">
                <h5>Edit Blog Options</h5>
                <a href="javascript:show_all('<?php echo $name.$counter?>')" class="closeit">&nbsp;</a>
            </div>
            <div class="opt-conts">
            	<ul class="form-elements">
                    <li class="to-label"><label>Blog Header Title</label></li>
                    <li class="to-field">
                        <input type="text" name="cs_blog_title[]" class="txtfield" value="<?php echo htmlspecialchars($cs_blog_title_db)?>" />
                        <p>Please enter Blog header title.</p>
                    </li>                    
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Select View</label></li>
                    <li class="to-field">
                        <select name="cs_blog_view[]" class="dropdown">
                         	<option <?php if($cs_blog_view_db=="blog-large")echo "selected";?> value="blog-large">Blog Large Image</option>
                            <option <?php if($cs_blog_view_db=="blog-medium")echo "selected";?> value="blog-medium">Blog Medium Image</option>
                            <option <?php if($cs_blog_view_db=="blog-home")echo "selected";?> value="blog-home">Blog Home</option>
                         </select>
                        <p>3 and 4 column with both sidebars will display 2 column</p>
                    </li>                                        
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Choose Category</label></li>
                    <li class="to-field">
                        <select name="cs_blog_cat[]" class="dropdown">
                        	<option value="0">-- Select Category --</option>
							<?php show_all_cats('', '', $cs_blog_cat_db, "category");?>
                        </select>
                        <p>Please select category to show posts.</p>
                    </li>                                        
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Post Description</label></li>
                    <li class="to-field">
                        <select name="cs_blog_description[]" class="dropdown" >
                            <option <?php if($cs_blog_pagination_db=="yes")echo "selected";?> value="yes">Yes</option>
                            <option <?php if($cs_blog_pagination_db=="no")echo "selected";?> value="no">No</option>
                        </select>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Length of Excerpt</label></li>
                    <li class="to-field">
                        <input type="text" name="cs_blog_excerpt[]" class="txtfield" value="<?php echo $cs_blog_excerpt_db;?>" />
                        <p>Enter number of character for short description text.</p>
                    </li>                         
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Pagination</label></li>
                    <li class="to-field">
                        <select name="cs_blog_pagination[]" class="dropdown" >
                            <option <?php if($cs_blog_pagination_db=="Show Pagination")echo "selected";?> >Show Pagination</option>
                            <option <?php if($cs_blog_pagination_db=="Single Page")echo "selected";?> >Single Page</option>
                        </select>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>No. of Post Per Page</label></li>
                    <li class="to-field">
                    	<input type="text" name="cs_blog_num_post[]" class="txtfield" value="<?php echo $cs_blog_num_post_db; ?>" />
                        <p>To display all the records, leave this field blank.</p>
                    </li>
                </ul>
                <ul class="form-elements noborder">
                    <li class="to-label"></li>
                    <li class="to-field">
                    	<input type="hidden" name="cs_orderby[]" value="blog" />
                        <input type="button" value="Save" style="margin-right:10px;" onclick="javascript:show_all('<?php echo $name.$counter?>')" />
                    </li>
                </ul>
            </div>
       </div>
    </div>
<?php
	if ( $die <> 1 ) die();
}
add_action('wp_ajax_cs_pb_blog', 'cs_pb_blog');
// blog html form for page builder end

// event html form for page builder start
function cs_pb_event($die = 0){
	global $cs_node, $count_node, $post;
	if ( isset($_POST['action']) ) {
		$name = $_POST['action'];
		$counter = $_POST['counter'];
		$event_element_size = '50';
		$cs_event_title_db = '';
		$cs_event_type_db = '';
		$cs_event_view_db = '';
		$cs_event_category_db = '';
		$cs_event_time_db = '';
		$cs_event_organizer_db = '';
		$cs_event_excerpt_db = '120';
 		$cs_event_filterables_db = '';
		$cs_event_pagination_db = '';
		
		$cs_event_per_page_db = get_option("posts_per_page");
	}
	else {
		$name = $cs_node->getName();
			$count_node++;
			$event_element_size = $cs_node->event_element_size;
			$cs_event_title_db = $cs_node->cs_event_title;
			$cs_event_type_db = $cs_node->cs_event_type;
			$cs_event_view_db = $cs_node->cs_event_view;
			$cs_event_category_db = $cs_node->cs_event_category;
			$cs_event_time_db = $cs_node->cs_event_time;
			$cs_event_organizer_db = $cs_node->cs_event_organizer;
 			$cs_event_filterables_db = $cs_node->cs_event_filterables;
			$cs_event_pagination_db = $cs_node->cs_event_pagination;
			$cs_event_excerpt_db = $cs_node->cs_event_excerpt;
			$cs_event_per_page_db = $cs_node->cs_event_per_page;
				$counter = $post->ID.$count_node;
}
?> 
	<div id="<?php echo $name.$counter?>_del" class="column  parentdelete column_<?php echo $event_element_size?>" item="event" data="<?php echo element_size_data_array_index($event_element_size)?>" >
		<div class="column-in">
            <h5><?php echo ucfirst(str_replace("cs_pb_","",$name))?></h5>
            <input type="hidden" name="event_element_size[]" class="item" value="<?php echo $event_element_size?>" >
            <a href="javascript:hide_all('<?php echo $name.$counter?>')" class="options">Options</a>
            <a href="#" class="delete-it btndeleteit">Del</a> &nbsp;
            <a class="decrement" onclick="javascript:decrement(this)">Dec</a> &nbsp; 
            <a class="increment" onclick="javascript:increment(this)">Inc</a>
		</div>
        <div class="poped-up" id="<?php echo $name.$counter?>" style="border:none; background:#f8f8f8;" >
            <div class="opt-head">
                <h5>Edit Event Options</h5>
                <a href="javascript:show_all('<?php echo $name.$counter?>')" class="closeit">&nbsp;</a>
            </div>
            <div class="opt-conts">
            	<ul class="form-elements">
                    <li class="to-label"><label>Event Title</label></li>
                    <li class="to-field">
                        <input type="text" name="cs_event_title[]" class="txtfield" value="<?php echo htmlspecialchars($cs_event_title_db)?>" />
                        <p>Event Page Title</p>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Event View</label></li>
                    <li class="to-field">
                        <select name="cs_event_view[]" class="dropdown">
                            <option <?php if($cs_event_view_db=="With Images")echo "selected";?> >With Images</option>
                            <option <?php if($cs_event_view_db=="Without Images")echo "selected";?> >Without Images</option>
                        </select>
                        <p>Select event view</p>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Event Types</label></li>
                    <li class="to-field">
                        <select name="cs_event_type[]" class="dropdown">
                            <option <?php if($cs_event_type_db=="All Events")echo "selected";?> >All Events</option>
                            <option <?php if($cs_event_type_db=="Upcoming Events")echo "selected";?> >Upcoming Events</option>
                            <option <?php if($cs_event_type_db=="Past Events")echo "selected";?> >Past Events</option>
                        </select>
                        <p>Select event type</p>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Select Category</label></li>
                    <li class="to-field">
                        <select name="cs_event_category[]" class="dropdown">
                        	<option value="0">-- Select Category --</option>
                            <?php show_all_cats('', '', $cs_event_category_db, "event-category");?>
                        </select>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Show Time</label></li>
                    <li class="to-field">
                        <select name="cs_event_time[]" class="dropdown">
                            <option value="Yes" <?php if($cs_event_time_db=="Yes")echo "selected";?> >Yes</option>
                            <option value="No" <?php if($cs_event_time_db=="No")echo "selected";?> >No</option>
                        </select>
                    </li>
                </ul>
                <ul class="form-elements" style="display:none;">
                    <li class="to-label"><label>Show Organizer</label></li>
                    <li class="to-field">
                        <select name="cs_event_organizer[]" class="dropdown">
                            <option value="Yes" <?php if($cs_event_organizer_db=="Yes")echo "selected";?> >Yes</option>
                            <option value="No" <?php if($cs_event_organizer_db=="No")echo "selected";?> >No</option>
                        </select>
                    </li>
                </ul>
                 <ul class="form-elements">
                    <li class="to-label"><label>Filterables</label></li>
                    <li class="to-field">
                        <select name="cs_event_filterables[]" class="dropdown" >
                            <option value="No" <?php if($cs_event_filterables_db=="No")echo "selected";?> >No</option>
                            <option value="Yes" <?php if($cs_event_filterables_db=="Yes")echo "selected";?> >Yes</option>
                        </select>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Length of Excerpt</label></li>
                    <li class="to-field">
                        <input type="text" name="cs_event_excerpt[]" class="txtfield" value="<?php echo $cs_event_excerpt_db;?>" />
                        <p>Enter number of character for short description text.</p>
                    </li>                         
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Pagination</label></li>
                    <li class="to-field">
                        <select name="cs_event_pagination[]" class="dropdown" >
                            <option <?php if($cs_event_pagination_db=="Show Pagination")echo "selected";?> >Show Pagination</option>
                            <option <?php if($cs_event_pagination_db=="Single Page")echo "selected";?> >Single Page</option>
                        </select>
                        <p>Show navigation only at List View.</p>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>No. of Events Per Page</label></li>
                    <li class="to-field">
                        <input type="text" name="cs_event_per_page[]" class="txtfield" value="<?php echo $cs_event_per_page_db; ?>" />
                        <p>To display all the records, leave this field blank.</p>
                    </li>
                </ul>
                <ul class="form-elements noborder">
                    <li class="to-label"></li>
                    <li class="to-field">
                    	<input type="hidden" name="cs_orderby[]" value="event" />
                        <input type="button" value="Save" style="margin-right:10px;" onclick="javascript:show_all('<?php echo $name.$counter?>')" />
                    </li>
                </ul>
            </div>
       </div>
    </div>
<?php
	if ( $die <> 1 ) die();
}
add_action('wp_ajax_cs_pb_event', 'cs_pb_event');
// event html form for page builder end

// contact us html form for page builder start
function cs_pb_contact($die = 0){
	global $cs_node, $count_node, $post;
	if ( isset($_POST['action']) ) {
		$name = $_POST['action'];
		$counter = $_POST['counter'];
		$contact_element_size = '50';
 		$cs_contact_email_db = '';
		$cs_contact_succ_msg_db = '';
	}
	else {
		$name = $cs_node->getName();
			$count_node++;
			$contact_element_size = $cs_node->contact_element_size;
 			$cs_contact_email_db = $cs_node->cs_contact_email;
			$cs_contact_succ_msg_db = $cs_node->cs_contact_succ_msg;
				$counter = $post->ID.$count_node;
}
?> 
	<div id="<?php echo $name.$counter?>_del" class="column  parentdelete column_<?php echo $contact_element_size?>" item="contact" data="<?php echo element_size_data_array_index($contact_element_size)?>" >
		<div class="column-in">
            <h5><?php echo ucfirst(str_replace("cs_pb_","",$name))?></h5>
            <input type="hidden" name="contact_element_size[]" class="item" value="<?php echo $contact_element_size?>" >
            <a href="javascript:hide_all('<?php echo $name.$counter?>')" class="options">Options</a>
            <a href="#" class="delete-it btndeleteit">Del</a> &nbsp;
            <a class="decrement" onclick="javascript:decrement(this)">Dec</a> &nbsp; 
            <a class="increment" onclick="javascript:increment(this)">Inc</a>
		</div>
       	<div class="poped-up" id="<?php echo $name.$counter?>" style="border:none; background:#f8f8f8;" >
            <div class="opt-head">
                <h5>Edit Contact Form</h5>
                <a href="javascript:show_all('<?php echo $name.$counter?>')" class="closeit">&nbsp;</a>
            </div>
            <div class="opt-conts">
				<ul class="form-elements">
                    <li class="to-label"><label>Contact Email</label></li>
                    <li class="to-field">
                        <input type="text" name="cs_contact_email[]" class="txtfield" value="<?php if($cs_contact_email_db=="") echo get_option("admin_email"); else echo $cs_contact_email_db;?>" />
                        <p>Please enter Contact email Address.</p>
                    </li>                    
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Successful Message</label></li>
                    <li class="to-field"><textarea name="cs_contact_succ_msg[]"><?php if($cs_contact_succ_msg_db=="")echo "Email Sent Successfully.\nThank you, your message has been submitted to us."; else echo $cs_contact_succ_msg_db;?></textarea></li>
                </ul>
                <ul class="form-elements noborder">
                    <li class="to-label"></li>
                    <li class="to-field">
                    	<input type="hidden" name="cs_orderby[]" value="contact" />
                        <input type="button" value="Save" style="margin-right:10px;" onclick="javascript:show_all('<?php echo $name.$counter?>')" />
                    </li>
                </ul>
            </div>
       </div>
    </div>
<?php
	if ( $die <> 1 ) die();
}
add_action('wp_ajax_cs_pb_contact', 'cs_pb_contact');
// contact us html form for page builder end

// column html form for page builder start
function cs_pb_column($die = 0){
	global $cs_node, $count_node, $post;
	if ( isset($_POST['action']) ) {
		$name = $_POST['action'];
		$counter = $_POST['counter'];
		$column_element_size = '25';
		$column_text = '';
	}
	else {
		$name = $cs_node->getName();
			$count_node++;
			$column_element_size = $cs_node->column_element_size;
			$column_text = $cs_node->column_text;
				$counter = $post->ID.$count_node;
}
?> 
	<div id="<?php echo $name.$counter?>_del" class="column  parentdelete column_<?php echo $column_element_size?>" item="column" data="<?php echo element_size_data_array_index($column_element_size)?>" >
    	<div class="column-in">
            <h5><?php echo ucfirst(str_replace("cs_pb_","",$name))?></h5>
            <input type="hidden" name="column_element_size[]" class="item" value="<?php echo $column_element_size?>" >
            <a href="javascript:hide_all('<?php echo $name.$counter?>')" class="options">Options</a> &nbsp; 
            <a href="#" class="delete-it btndeleteit">Del</a> &nbsp;  
            <a class="decrement" onclick="javascript:decrement(this)">Dec</a> &nbsp; 
            <a class="increment" onclick="javascript:increment(this)">Inc</a>
		</div>
       	<div class="poped-up" id="<?php echo $name.$counter?>" style="border:none; background:#f8f8f8;" >
            <div class="opt-head">
                <h5>Edit Column Options</h5>
                <a href="javascript:show_all('<?php echo $name.$counter?>')" class="closeit">&nbsp;</a>
            </div>
            <div class="opt-conts">
            	<ul class="form-elements">
                    <li class="to-label"><label>Column Text</label></li>
                    <li class="to-field">
                    	<textarea name="column_text[]"><?php echo $column_text?></textarea>
                        <p>Shortcodes and HTML tags allowed.</p>
                    </li>                  
                </ul>
                <ul class="form-elements noborder">
                    <li class="to-label"></li>
                    <li class="to-field">
                    	<input type="hidden" name="cs_orderby[]" value="column" />
                        <input type="button" value="Save" style="margin-right:10px;" onclick="javascript:show_all('<?php echo $name.$counter?>')" />
                    </li>
                </ul>
            </div>
       </div>
    </div>
<?php
	if ( $die <> 1 ) die();
}
add_action('wp_ajax_cs_pb_column', 'cs_pb_column');
// column html form for page builder end 

// add Team Scoial function
function cs_add_social_to_list(){
	global $counter_social, $var_cp_title, $var_cp_image_url , $var_cp_url;
	foreach ($_POST as $keys=>$values) {
		$$keys = $values;
	}
?>
    <tr id="edit_track<?php echo $counter_social?>">
        <td id="album-title<?php echo $counter_social?>" style="width:80%;"><?php echo $var_cp_title?></td>
        <td class="centr" style="width:20%;">
            <a href="javascript:openpopedup('edit_track_form<?php echo $counter_social?>')" class="actions edit">&nbsp;</a>
            <a onclick="javascript:return confirm('Are you sure! You want to delete this social icon')" href="javascript:cs_div_remove('edit_track<?php echo $counter_social?>')" class="actions delete">&nbsp;</a>
            <div class="poped-up" id="edit_track_form<?php echo $counter_social?>">
                <div class="opt-head">
                    <h5>Settings</h5>
                    <a href="javascript:closepopedup('edit_track_form<?php echo $counter_social?>')" class="closeit">&nbsp;</a>
                    <div class="clear"></div>
                </div>
                <ul class="form-elements">
                    <li class="to-label"><label>Title</label></li>
                    <li class="to-field">
                        <input type="text" name="var_cp_title[]" value="<?php echo htmlspecialchars($var_cp_title)?>" id="var_cp_title<?php echo $counter_social?>" />
                        <p>Put album track title</p>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>icon/image URL</label></li>
                    <li class="to-field">
                        <input id="var_cp_image_url<?php echo $counter_social?>" name="var_cp_image_url[]" value="<?php echo htmlspecialchars($var_cp_image_url)?>" type="text" class="small" />
                        <input id="var_cp_image_url<?php echo $counter_social?>" name="var_cp_image_url<?php echo $counter_track?>" type="button" class="uploadfile left" value="Browse"/>
                        <p>Put icon/image url</p>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>URL</label></li>
                    <li class="to-field">
                        <input type="text" name="var_cp_url[]" value="<?php echo htmlspecialchars($var_cp_url)?>" />
                        <p>Put URL</p>
                    </li>
                </ul>
                <ul class="form-elements noborder">
                    <li class="to-label"><label></label></li>
                    <li class="to-field"><input type="button" value="Update Social link" onclick="update_title(<?php echo $counter_social?>); closepopedup('edit_track_form<?php echo $counter_social?>')" /></li>
                </ul>
            </div>
        </td>
    </tr>
<?php
	if ( isset($action) ) die();
}
add_action('wp_ajax_cs_add_social_to_list', 'cs_add_social_to_list');

// divider html form for page builder start
function cs_pb_divider($die = 0){
	global $cs_node, $count_node, $post;
	if ( isset($_POST['action']) ) {
		$name = $_POST['action'];
		$counter = $_POST['counter'];
		$divider_element_size = '25';
		$divider_style = '';
		$divider_backtotop = '';
		$divider_mrg_top = '20';
		$divider_mrg_bottom = '20';
	}
	else {
		$name = $cs_node->getName();
			$count_node++;
			$divider_element_size = $cs_node->divider_element_size;
			$divider_style = $cs_node->divider_style;
			$divider_backtotop = $cs_node->divider_backtotop;
			$divider_mrg_top = $cs_node->divider_mrg_top;
			$divider_mrg_bottom = $cs_node->divider_mrg_bottom;
				$counter = $post->ID.$count_node;
}
?> 
	<div id="<?php echo $name.$counter?>_del" class="column  parentdelete column_<?php echo $divider_element_size?>" item="divider" data="<?php echo element_size_data_array_index($divider_element_size)?>" >
    	<div class="column-in">
            <h5><?php echo ucfirst(str_replace("cs_pb_","",$name))?></h5>
            <input type="hidden" name="divider_element_size[]" class="item" value="<?php echo $divider_element_size?>" >
            <a href="javascript:hide_all('<?php echo $name.$counter?>')" class="options">Options</a> &nbsp; 
            <a href="#" class="delete-it btndeleteit">Del</a> &nbsp;  
            <a class="decrement" onclick="javascript:decrement(this)">Dec</a> &nbsp; 
            <a class="increment" onclick="javascript:increment(this)">Inc</a>
		</div>
       	<div class="poped-up" id="<?php echo $name.$counter?>" style="border:none; background:#f8f8f8;" >
            <div class="opt-head">
                <h5>Edit Divider Options</h5>
                <a href="javascript:show_all('<?php echo $name.$counter?>')" class="closeit">&nbsp;</a>
            </div>
            <div class="opt-conts">
            	<ul class="form-elements">
                    <li class="to-label"><label>Style</label></li>
                    <li class="to-field">
                        <select name="divider_style[]" class="dropdown" >
                            <option <?php if($divider_style=="divider1")echo "selected";?> >divider1</option>
                            <option <?php if($divider_style=="divider2")echo "selected";?> >divider2</option>
                            <option <?php if($divider_style=="divider3")echo "selected";?> >divider3</option>
                            <option <?php if($divider_style=="divider4")echo "selected";?> >divider4</option>
                            <option <?php if($divider_style=="divider5")echo "selected";?> >divider5</option>
                        </select>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Back to Top</label></li>
                    <li class="to-field">
                        <select name="divider_backtotop[]" class="dropdown" >
                            <option value="yes" <?php if($divider_backtotop=="yes")echo "selected";?> >Yes</option>
                            <option value="no" <?php if($divider_backtotop=="no")echo "selected";?> >No</option>
                        </select>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Margin Top</label></li>
                    <li class="to-field">
                    	<input type="text" name="divider_mrg_top[]" value="<?php echo $divider_mrg_top ?>" />
                        <p>Set the top margin (In PX)</p>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Margin Bottom</label></li>
                    <li class="to-field">
                    	<input type="text" name="divider_mrg_bottom[]" value="<?php echo $divider_mrg_bottom ?>" />
                        <p>Set the bottom margin (In PX)</p>
                    </li>
                </ul>
                <ul class="form-elements noborder">
                    <li class="to-label"></li>
                    <li class="to-field">
                    	<input type="hidden" name="cs_orderby[]" value="divider" />
                        <input type="button" value="Save" style="margin-right:10px;" onclick="javascript:show_all('<?php echo $name.$counter?>')" />
                    </li>
                </ul>
            </div>
       </div>
    </div>
<?php
	if ( $die <> 1 ) die();
}
add_action('wp_ajax_cs_pb_divider', 'cs_pb_divider');
// divider html form for page builder end

// image frame html form for page builder start
function cs_pb_image($die = 0){
	global $cs_node, $count_node, $post;
	if ( isset($_POST['action']) ) {
		$name = $_POST['action'];
		$counter = $_POST['counter'];
		$image_element_size = '25';
		$image_width = '';
		$image_height = '';
		$image_lightbox = '';
		$image_source = '';
		$image_style = '';
		$image_caption = '';
	}
	else {
		$name = $cs_node->getName();
			$count_node++;
			$image_element_size = $cs_node->image_element_size;
			$image_width = $cs_node->image_width;
			$image_height = $cs_node->image_height;
			$image_lightbox = $cs_node->image_lightbox;
			$image_source = $cs_node->image_source;
			$image_style = $cs_node->image_style;
			$image_caption = $cs_node->image_caption;
				$counter = $post->ID.$count_node;
}
?> 
	<div id="<?php echo $name.$counter?>_del" class="column  parentdelete column_<?php echo $image_element_size?>" item="image_frame" data="<?php echo element_size_data_array_index($image_element_size)?>" >
    	<div class="column-in">
            <h5><?php echo ucfirst(str_replace("cs_pb_","",$name))?></h5>
            <input type="hidden" name="image_element_size[]" class="item" value="<?php echo $image_element_size?>" >
            <a href="javascript:hide_all('<?php echo $name.$counter?>')" class="options">Options</a> &nbsp; 
            <a href="#" class="delete-it btndeleteit">Del</a> &nbsp;  
            <a class="decrement" onclick="javascript:decrement(this)">Dec</a> &nbsp; 
            <a class="increment" onclick="javascript:increment(this)">Inc</a>
		</div>
       	<div class="poped-up" id="<?php echo $name.$counter?>" style="border:none; background:#f8f8f8;" >
            <div class="opt-head">
                <h5>Edit Image Options</h5>
                <a href="javascript:show_all('<?php echo $name.$counter?>')" class="closeit">&nbsp;</a>
            </div>
            <div class="opt-conts">
            	<ul class="form-elements">
                    <li class="to-label"><label>Width</label></li>
                    <li class="to-field">
                    	<input type="text" name="image_width[]" class="txtfield" value="<?php echo $image_width?>" />
                        <p>Enter value in PX</p>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Height</label></li>
                    <li class="to-field">
                    	<input type="text" name="image_height[]" class="txtfield" value="<?php echo $image_height?>" />
                        Enter value in PX
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Lightbox</label></li>
                    <li class="to-field">
                    	<select name="image_lightbox[]">
                        	<option value="yes" <?php if($image_lightbox=="yes")echo "selected";?> >Yes</option>
                        	<option value="no" <?php if($image_lightbox=="no")echo "selected";?> >No</option>
                        </select>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Source</label></li>
                    <li class="to-field">
                    	<input type="text" name="image_source[]" class="txtfield" value="<?php echo $image_source?>" />
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Style</label></li>
                    <li class="to-field">
                    	<select name="image_style[]">
                        	<option <?php if($image_style=="frame1")echo "selected";?> >frame1</option>
                        	<option <?php if($image_style=="frame2")echo "selected";?> >frame2</option>
                        	<option <?php if($image_style=="frame3")echo "selected";?> >frame3</option>
                        	<option <?php if($image_style=="frame4")echo "selected";?> >frame4</option>
                        	<option <?php if($image_style=="frame5")echo "selected";?> >frame5</option>
                        	<option <?php if($image_style=="frame6")echo "selected";?> >frame6</option>
                        </select>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Caption</label></li>
                    <li class="to-field">
                    	<input type="text" name="image_caption[]" class="txtfield" value="<?php echo $image_caption?>" />
                    </li>
                </ul>
                <ul class="form-elements noborder">
                    <li class="to-label"></li>
                    <li class="to-field">
                    	<input type="hidden" name="cs_orderby[]" value="image" />
                        <input type="button" value="Save" style="margin-right:10px;" onclick="javascript:show_all('<?php echo $name.$counter?>')" />
                    </li>
                </ul>
            </div>
       </div>
    </div>
<?php
	if ( $die <> 1 ) die();
}
add_action('wp_ajax_cs_pb_image', 'cs_pb_image');
// image frame html form for page builder end

// google map html form for page builder start
function cs_pb_map($die = 0){
	global $cs_node, $count_node, $post;
	if ( isset($_POST['action']) ) {
		$name = $_POST['action'];
		$counter = $_POST['counter'];
		$map_element_size = '25';
		$map_title = '';
		$map_height = '';
		$map_lat = '';
		$map_lon = '';
		$map_zoom = '';
		$map_type = '';
		$map_info = '';
		$map_info_width = '';
		$map_info_height = '';
		$map_marker_icon = '';
		$map_show_marker = '';
		$map_controls = '';
		$map_draggable = '';
		$map_scrollwheel = '';
		$map_view= '';
	}
	else {
		$name = $cs_node->getName();
			$count_node++;
			$map_element_size = $cs_node->map_element_size;
			$map_title 	= $cs_node->map_title;
			$map_height = $cs_node->map_height;
			$map_lat 	= $cs_node->map_lat;
			$map_lon 	= $cs_node->map_lon;
			$map_zoom 	= $cs_node->map_zoom;
			$map_type = $cs_node->map_type;
			$map_info = $cs_node->map_info;
			$map_info_width = $cs_node->map_info_width;
			$map_info_height = $cs_node->map_info_height;
			$map_marker_icon = $cs_node->map_marker_icon;
			$map_show_marker = $cs_node->map_show_marker;
			$map_controls = $cs_node->map_controls;
			$map_draggable = $cs_node->map_draggable;
			$map_scrollwheel = $cs_node->map_scrollwheel;
			$map_view 	= $cs_node->map_view;
			$counter 	= $post->ID.$count_node;
}
?> 
	<div id="<?php echo $name.$counter?>_del" class="column  parentdelete column_<?php echo $map_element_size?>" item="map" data="<?php echo element_size_data_array_index($map_element_size)?>" >
    	<div class="column-in">
            <h5><?php echo ucfirst(str_replace("cs_pb_","",$name))?></h5>
            <input type="hidden" name="map_element_size[]" class="item" value="<?php echo $map_element_size?>" >
            <a href="javascript:hide_all('<?php echo $name.$counter?>')" class="options">Options</a> &nbsp; 
            <a href="#" class="delete-it btndeleteit">Del</a> &nbsp;  
            <a class="decrement" onclick="javascript:decrement(this)">Dec</a> &nbsp; 
            <a class="increment" onclick="javascript:increment(this)">Inc</a>
		</div>
       	<div class="poped-up" id="<?php echo $name.$counter?>" style="border:none; background:#f8f8f8;" >
            <div class="opt-head">
                <h5>Edit Map Options</h5>
                <a href="javascript:show_all('<?php echo $name.$counter?>')" class="closeit">&nbsp;</a>
            </div>
            <div class="opt-conts">
            	<ul class="form-elements">
                    <li class="to-label"><label>Title</label></li>
                    <li class="to-field"><input type="text" name="map_title[]" class="txtfield" value="<?php echo $map_title?>" /></li>
                </ul>
				<ul class="form-elements">
                    <li class="to-label"><label>Map Height</label></li>
                    <li class="to-field">
                    	<input type="text" name="map_height[]" class="txtfield" value="<?php echo $map_height?>" />
                        <p>Info Max Height in PX (Default is 200)</p>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Latitude</label></li>
                    <li class="to-field">
                    	<input type="text" name="map_lat[]" class="txtfield" value="<?php echo $map_lat?>" />
                        <p>Put Latitude (Default is 0)</p>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Longitude</label></li>
                    <li class="to-field">
                    	<input type="text" name="map_lon[]" class="txtfield" value="<?php echo $map_lon?>" />
                        <p>Put Longitude (Default is 0)</p>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Zoom</label></li>
                    <li class="to-field">
                    	<input type="text" name="map_zoom[]" class="txtfield" value="<?php echo $map_zoom?>" />
                        <p>Put Zoom Level (Default is 11)</p>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Map Types</label></li>
                    <li class="to-field">
                        <select name="map_type[]" class="dropdown" >
                            <option <?php if($map_type=="ROADMAP")echo "selected";?> >ROADMAP</option>
                            <option <?php if($map_type=="HYBRID")echo "selected";?> >HYBRID</option>
                            <option <?php if($map_type=="SATELLITE")echo "selected";?> >SATELLITE</option>
                            <option <?php if($map_type=="TERRAIN")echo "selected";?> >TERRAIN</option>
                        </select>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Info Text</label></li>
                    <li class="to-field"><input type="text" name="map_info[]" class="txtfield" value="<?php echo $map_info?>" /></li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Info Max Width</label></li>
                    <li class="to-field">
                    	<input type="text" name="map_info_width[]" class="txtfield" value="<?php echo $map_info_width?>" />
                        <p>Info Max Width in PX (Default is 200)</p>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Info Max Height</label></li>
                    <li class="to-field">
                    	<input type="text" name="map_info_height[]" class="txtfield" value="<?php echo $map_info_height?>" />
                        <p>Info Max Height in PX (Default is 100)</p>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Marker Icon Path</label></li>
                    <li class="to-field">
                    	<input type="text" name="map_marker_icon[]" class="txtfield" value="<?php echo $map_marker_icon?>" />
                        <p>e.g. http://yourdomain.com/logo.png</p>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Show Marker</label></li>
                    <li class="to-field">
                        <select name="map_show_marker[]" class="dropdown" >
                            <option value="true" <?php if($map_show_marker=="true")echo "selected";?> >On</option>
                            <option value="false" <?php if($map_show_marker=="false")echo "selected";?> >Off</option>
                        </select>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Disable Map Controls</label></li>
                    <li class="to-field">
                        <select name="map_controls[]" class="dropdown" >
                            <option value="false" <?php if($map_controls=="false")echo "selected";?> >Off</option>
                            <option value="true" <?php if($map_controls=="true")echo "selected";?> >On</option>
                        </select>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Draggable</label></li>
                    <li class="to-field">
                        <select name="map_draggable[]" class="dropdown" >
                            <option value="true" <?php if($map_draggable=="true")echo "selected";?> >On</option>
                            <option value="false" <?php if($map_draggable=="false")echo "selected";?> >Off</option>
                        </select>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Scroll Wheel</label></li>
                    <li class="to-field">

                        <select name="map_scrollwheel[]" class="dropdown" >
                            <option value="true" <?php if($map_scrollwheel=="true")echo "selected";?> >On</option>
                            <option value="false" <?php if($map_scrollwheel=="false")echo "selected";?> >Off</option>
                        </select>
                    </li>
                </ul>
                 <ul class="form-elements">
                    <li class="to-label"><label>Map View</label></li>
                    <li class="to-field">
                        <select name="map_view[]" class="dropdown" >
                            <option <?php if($map_view=="content")echo "selected";?> >content</option>
                            <option <?php if($map_view=="header")echo "selected";?> >header</option>
                         </select>
                    </li>
                </ul>
                <ul class="form-elements noborder">
                    <li class="to-label"></li>
                    <li class="to-field">
                    	<input type="hidden" name="cs_orderby[]" value="map" />
                        <input type="button" value="Save" style="margin-right:10px;" onclick="javascript:show_all('<?php echo $name.$counter?>')" />
                    </li>
                </ul>
            </div>

       </div>
    </div>
<?php
	if ( $die <> 1 ) die();
}
add_action('wp_ajax_cs_pb_map', 'cs_pb_map');
// google map html form for page builder end

// video html form for page builder start
function cs_pb_video($die = 0){
	global $cs_node, $count_node, $post;
	if ( isset($_POST['action']) ) {
		$name = $_POST['action'];
		$counter = $_POST['counter'];
		$video_element_size = '25';
		$video_url = '';
		$video_width = '';
		$video_height = '';
	}
	else {
		$name = $cs_node->getName();
			$count_node++;
			$video_element_size = $cs_node->video_element_size;
			$video_url = $cs_node->video_url;
			$video_width = $cs_node->video_width;
			$video_height = $cs_node->video_height;
				$counter = $post->ID.$count_node;
}
?> 
	<div id="<?php echo $name.$counter?>_del" class="column  parentdelete column_<?php echo $video_element_size?>" item="video" data="<?php echo element_size_data_array_index($video_element_size)?>" >
    	<div class="column-in">
            <h5><?php echo ucfirst(str_replace("cs_pb_","",$name))?></h5>
            <input type="hidden" name="video_element_size[]" class="item" value="<?php echo $video_element_size?>" >
            <a href="javascript:hide_all('<?php echo $name.$counter?>')" class="options">Options</a> &nbsp; 
            <a href="#" class="delete-it btndeleteit">Del</a> &nbsp;  
            <a class="decrement" onclick="javascript:decrement(this)">Dec</a> &nbsp; 
            <a class="increment" onclick="javascript:increment(this)">Inc</a>
		</div>
       	<div class="poped-up" id="<?php echo $name.$counter?>" style="border:none; background:#f8f8f8;" >
            <div class="opt-head">
                <h5>Edit Video Options</h5>
                <a href="javascript:show_all('<?php echo $name.$counter?>')" class="closeit">&nbsp;</a>
            </div>
            <div class="opt-conts">
                <ul class="form-elements">
                    <li class="to-label"><label>Video URL</label></li>
                    <li class="to-field">
                    	<input type="text" name="video_url[]" class="txtfield" value="<?php echo $video_url?>" />
                        <p>Enter Video URL (Youtube, Vimeo or any other supported by wordpress)</p>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Width</label></li>
                    <li class="to-field"><input type="text" name="video_width[]" class="txtfield" value="<?php echo $video_width?>" /></li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Height</label></li>
                    <li class="to-field"><input type="text" name="video_height[]" class="txtfield" value="<?php echo $video_height?>" /></li>
                </ul>
                <ul class="form-elements noborder">
                    <li class="to-label"></li>
                    <li class="to-field">
                    	<input type="hidden" name="cs_orderby[]" value="video" />
                        <input type="button" value="Save" style="margin-right:10px;" onclick="javascript:show_all('<?php echo $name.$counter?>')" />
                    </li>
                </ul>
            </div>
       </div>
    </div>
<?php
	if ( $die <> 1 ) die();
}
add_action('wp_ajax_cs_pb_video', 'cs_pb_video');
// video html form for page builder end 

// quote html form for page builder start
function cs_pb_quote($die = 0){
	global $cs_node, $count_node, $post;
	if ( isset($_POST['action']) ) {
		$name = $_POST['action'];
		$counter = $_POST['counter'];
		$quote_element_size = '25';
		$quote_text_color = '';
		$quote_align = '';
		$quote_content = '';
	}
	else {
		$name = $cs_node->getName();
			$count_node++;
			$quote_element_size = $cs_node->quote_element_size;
			$quote_text_color = $cs_node->quote_text_color;
			$quote_align = $cs_node->quote_align;
			$quote_content = $cs_node->quote_content;
				$counter = $post->ID.$count_node;
}
?> 
	<div id="<?php echo $name.$counter?>_del" class="column  parentdelete column_<?php echo $quote_element_size?>" item="quote" data="<?php echo element_size_data_array_index($quote_element_size)?>" >
    	<div class="column-in">
            <h5><?php echo ucfirst(str_replace("cs_pb_","",$name))?></h5>
            <input type="hidden" name="quote_element_size[]" class="item" value="<?php echo $quote_element_size?>" >
            <a href="javascript:hide_all('<?php echo $name.$counter?>')" class="options">Options</a> &nbsp; 
            <a href="#" class="delete-it btndeleteit">Del</a> &nbsp;  
            <a class="decrement" onclick="javascript:decrement(this)">Dec</a> &nbsp; 
            <a class="increment" onclick="javascript:increment(this)">Inc</a>
		</div>
       	<div class="poped-up" id="<?php echo $name.$counter?>" style="border:none; background:#f8f8f8;" >
            <div class="opt-head">
                <h5>Edit Quote Options</h5>
                <a href="javascript:show_all('<?php echo $name.$counter?>')" class="closeit">&nbsp;</a>
            </div>
            <div class="opt-conts">
            	<ul class="form-elements">
                    <li class="to-label"><label>Text Color</label></li>
                    <li class="to-field">
                    	<input type="text" name="quote_text_color[]" class="txtfield" value="<?php echo $quote_text_color?>" />
                        <p>Enter the color code like #000000</p>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Align</label></li>
                    <li class="to-field">
                        <select name="quote_align[]" class="dropdown" >
                            <option <?php if($quote_align=="left")echo "selected";?> >left</option>
                            <option <?php if($quote_align=="right")echo "selected";?> >right</option>
                            <option <?php if($quote_align=="center")echo "selected";?> >center</option>
                        </select>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Quote Content</label></li>
                    <li class="to-field"><textarea name="quote_content[]"><?php echo $quote_content?></textarea></li>
                </ul>
                <ul class="form-elements noborder">
                    <li class="to-label"></li>
                    <li class="to-field">
                    	<input type="hidden" name="cs_orderby[]" value="quote" />
                        <input type="button" value="Save" style="margin-right:10px;" onclick="javascript:show_all('<?php echo $name.$counter?>')" />
                    </li>
                </ul>
            </div>
       </div>
    </div>
<?php
	if ( $die <> 1 ) die();
}
add_action('wp_ajax_cs_pb_quote', 'cs_pb_quote');
// quote html form for page builder start

// dropcap html form for page builder start
function cs_pb_dropcap($die = 0){
	global $cs_node, $count_node, $post;
	if ( isset($_POST['action']) ) {
		$name = $_POST['action'];
		$counter = $_POST['counter'];
		$dropcap_element_size = '25';
		$dropcap_content = '';
	}
	else {
		$name = $cs_node->getName();
			$count_node++;
			$dropcap_element_size = $cs_node->dropcap_element_size;
			$dropcap_content = $cs_node->dropcap_content;
				$counter = $post->ID.$count_node;
}
?> 
	<div id="<?php echo $name.$counter?>_del" class="column  parentdelete column_<?php echo $dropcap_element_size?>" item="dropcap" data="<?php echo element_size_data_array_index($dropcap_element_size)?>" >
    	<div class="column-in">
            <h5><?php echo ucfirst(str_replace("cs_pb_","",$name))?></h5>
            <input type="hidden" name="dropcap_element_size[]" class="item" value="<?php echo $dropcap_element_size?>" >
            <a href="javascript:hide_all('<?php echo $name.$counter?>')" class="options">Options</a> &nbsp; 
            <a href="#" class="delete-it btndeleteit">Del</a> &nbsp;  
            <a class="decrement" onclick="javascript:decrement(this)">Dec</a> &nbsp; 
            <a class="increment" onclick="javascript:increment(this)">Inc</a>
		</div>
       	<div class="poped-up" id="<?php echo $name.$counter?>" style="border:none; background:#f8f8f8;" >
            <div class="opt-head">
                <h5>Edit Dropcap Options</h5>
                <a href="javascript:show_all('<?php echo $name.$counter?>')" class="closeit">&nbsp;</a>
            </div>
            <div class="opt-conts">
            	<ul class="form-elements">
                    <li class="to-label"><label>Content</label></li>
                    <li class="to-field"><textarea name="dropcap_content[]"><?php echo $dropcap_content?></textarea></li>
                </ul>
                <ul class="form-elements noborder">
                    <li class="to-label"></li>
                    <li class="to-field">
                    	<input type="hidden" name="cs_orderby[]" value="dropcap" />
                        <input type="button" value="Save" style="margin-right:10px;" onclick="javascript:show_all('<?php echo $name.$counter?>')" />
                    </li>
                </ul>
            </div>
       </div>
    </div>
<?php
	if ( $die <> 1 ) die();
}
add_action('wp_ajax_cs_pb_dropcap', 'cs_pb_dropcap');
// dropcap html form for page builder end

// price table html form for page builder start
function cs_pb_pricetable($die = 0){
	global $cs_node, $count_node, $post;
	if ( isset($_POST['action']) ) {
		$name = $_POST['action'];
		$counter = $_POST['counter'];
		$pricetable_element_size = '25';
		$pricetable_style= '';
		$pricetable_title = '';
		$pricetable_package = '';
		$pricetable_price = '';
		$pricetable_for_time = '';
		$pricetable_content= '';
		$pricetable_linktitle = '';
		$pricetable_linkurl = '';
		$pricetable_featured = '';
		$pricetable_bgcolor = '';
 	}
	else {
		$name = $cs_node->getName();
			$count_node++;
			$pricetable_element_size = $cs_node->pricetable_element_size;
			$pricetable_style = $cs_node->pricetable_style;
			$pricetable_package = $cs_node->pricetable_package;
			$pricetable_title = $cs_node->pricetable_title;
			$pricetable_price = $cs_node ->pricetable_price;
			$pricetable_for_time = $cs_node->pricetable_for_time;
			$pricetable_content = $cs_node->pricetable_content;
			$pricetable_linktitle = $cs_node->pricetable_linktitle;
			$pricetable_linkurl = $cs_node->pricetable_linkurl;
			$pricetable_featured = $cs_node->pricetable_featured;
			$pricetable_bgcolor = $cs_node->pricetable_bgcolor;
 			$counter = $post->ID.$count_node;
}
?> 
	<div id="<?php echo $name.$counter?>_del" class="column  parentdelete column_<?php echo $pricetable_element_size?>" item="pricetable" data="<?php echo element_size_data_array_index($pricetable_element_size)?>" >
    	<div class="column-in">
            <h5><?php echo ucfirst(str_replace("cs_pb_","",$name))?></h5>
            <input type="hidden" name="pricetable_element_size[]" class="item" value="<?php echo $pricetable_element_size?>" >
            <a href="javascript:hide_all('<?php echo $name.$counter?>')" class="options">Options</a> &nbsp; 
            <a href="#" class="delete-it btndeleteit">Del</a> &nbsp;  
            <a class="decrement" onclick="javascript:decrement(this)">Dec</a> &nbsp; 
            <a class="increment" onclick="javascript:increment(this)">Inc</a>
		</div>
       	<div class="poped-up" id="<?php echo $name.$counter?>" style="border:none; background:#f8f8f8;" >
            <div class="opt-head">
                <h5>Edit Price Table Options</h5>
                <a href="javascript:show_all('<?php echo $name.$counter?>')" class="closeit">&nbsp;</a>
            </div>
            <div class="opt-conts">
            	<ul class="form-elements">
                    <li class="to-label"><label>Price Table Style</label></li>
                    <li class="to-field">
                        <select name="pricetable_style[]" class="dropdown" onchange="javascript:toggle_pricetable_style(this.value)">
                            <option <?php if($pricetable_style=="style1")echo "selected";?> >style1</option>
                            <option <?php if($pricetable_style=="style2")echo "selected";?> >style2</option>
                            <option <?php if($pricetable_style=="style3")echo "selected";?> >style3</option>
                         </select>
                    </li>
                </ul>
				<ul class="form-elements" id="price_pakage" style="display:<?php if($pricetable_style == "style3")echo "inline"; else echo "none"; ?>">
                    <li class="to-label"><label>Package</label></li>
                    <li class="to-field"><input type="text" name="pricetable_package[]" class="txtfield" value="<?php echo $pricetable_package?>" /></li>
                </ul>
            	<ul class="form-elements">
                    <li class="to-label"><label>Title</label></li>
                    <li class="to-field"><input type="text" name="pricetable_title[]" class="txtfield" value="<?php echo $pricetable_title?>" /></li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Price</label></li>
                    <li class="to-field"><input type="text" name="pricetable_price[]" class="txtfield" value="<?php echo $pricetable_price?>" /></li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>For Time Period</label></li>
                    <li class="to-field"><input type="text" name="pricetable_for_time[]" class="txtfield" value="<?php echo $pricetable_for_time?>" /></li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Content</label></li>
                    <li class="to-field"><textarea name="pricetable_content[]" class="txtfield" rows="20" cols="20"><?php echo $pricetable_content?></textarea></li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Link Title</label></li>
                    <li class="to-field"><input type="text" name="pricetable_linktitle[]" class="txtfield" value="<?php echo $pricetable_linktitle?>" /></li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Link</label></li>
                    <li class="to-field"><input type="text" name="pricetable_linkurl[]" class="txtfield" value="<?php echo $pricetable_linkurl?>" /></li>
                </ul>
               	<ul class="form-elements">
                    <li class="to-label"><label>Button Background Color</label></li>
					<li><input type="text"  name="pricetable_bgcolor[]" class="pricetable_bgcolor" value="<?php echo $pricetable_bgcolor?>" data-default-color=""  /></li>
                    <script type="text/javascript">
						jQuery(document).ready(function($){
							$('.pricetable_bgcolor').wpColorPicker(); 
						});
					</script>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Featured</label></li>
                    <li class="to-field">
                        <select name="pricetable_featured[]" class="dropdown" >
                            <option <?php if($pricetable_featured=="Yes")echo "selected";?> >Yes</option>
                            <option <?php if($pricetable_featured=="No")echo "selected";?> >No</option>
                        </select>
                    </li>
                </ul>
                <ul class="form-elements noborder">
                    <li class="to-label"></li>
                    <li class="to-field">
                    	<input type="hidden" name="cs_orderby[]" value="pricetable" />
                        <input type="button" value="Save" style="margin-right:10px;" onclick="javascript:show_all('<?php echo $name.$counter?>')" />
                    </li>
                </ul>
            </div>
       </div>
    </div>
<?php
	if ( $die <> 1 ) die();
}
add_action('wp_ajax_cs_pb_pricetable', 'cs_pb_pricetable');
// price table html form for page builder end

// our client html form for page builder start
function cs_pb_client($die = 0){
	global $cs_node, $count_node, $post;
	if ( isset($_POST['action']) ) {
			$name = $_POST['action'];
			$counter = $_POST['counter'];
			$client_element_size = '50';
			$client_header_title = '';
			$client_gallery = '';
			$client_view = '';
	}
	else {
		$name = $cs_node->getName();
			$count_node++;
			$client_header_title = $cs_node->client_header_title;
			$client_gallery = $cs_node->client_gallery;
			$client_view = $cs_node->client_view;
			$client_element_size = $cs_node->client_element_size;
				$counter = $post->ID.$count_node;
	}
?> 
	<div id="<?php echo $name.$counter?>_del" class="column  parentdelete column_<?php echo $client_element_size?>" item="client" data="<?php echo element_size_data_array_index($client_element_size)?>" >
		<div class="column-in">
            <h5><?php echo ucfirst(str_replace("cs_pb_","",$name))?></h5>
            <input type="hidden" name="client_element_size[]" class="item" value="<?php echo $client_element_size?>" >
            <a href="javascript:hide_all('<?php echo $name.$counter?>')" class="options">Options</a> &nbsp; 
            <a href="#" class="delete-it btndeleteit">Del</a> &nbsp;  
            <a class="decrement" onclick="javascript:decrement(this)">Dec</a> &nbsp; 
            <a class="increment" onclick="javascript:increment(this)">Inc</a>
		</div>
        <div class="poped-up" id="<?php echo $name.$counter?>" style="border:none; background:#f8f8f8;" >
            <div class="opt-head">
                <h5>Edit Client's Options</h5>
                <a href="javascript:show_all('<?php echo $name.$counter?>')" class="closeit">&nbsp;</a>
            </div>
            <div class="opt-conts">
            	<ul class="form-elements">
                    <li class="to-label"><label>Header Title</label></li>
                    <li class="to-field">
                        <input type="text" name="client_header_title[]" class="txtfield" value="<?php echo htmlspecialchars($client_header_title)?>" />
                        <p>Please enter header title.</p>
                    </li>                    
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Choose Gallery/Album</label></li>
                    <li class="to-field">
                        <select name="client_gallery[]" class="dropdown">
                        	<option value="0">-- Select Gallery --</option>
                            <?php
                                $query = array( 'posts_per_page' => '-1', 'post_type' => 'cs_gallery', 'orderby'=>'ID', 'post_status' => 'publish' );
                                $wp_query = new WP_Query($query);
                                while ($wp_query->have_posts()) : $wp_query->the_post();
                            ?>
                                <option <?php if($post->post_name==$client_gallery)echo "selected";?> value="<?php echo $post->post_name; ?>"><?php echo get_the_title()?></option>
                            <?php
                                endwhile;
                            ?>
                        </select>
                        <p>Select gallery to show images.</p>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Select View</label></li>
                    <li class="to-field">
                        <select name="client_view[]" class="dropdown">
                            <option <?php if($client_view=="List View")echo "selected";?> >List View</option>
                            <option <?php if($client_view=="Carousel View")echo "selected";?> >Carousel View</option>
                        </select>
                    </li>                    
                </ul>
                <ul class="form-elements noborder">
                    <li class="to-label"></li>
                    <li class="to-field">
                    	<input type="hidden" name="cs_orderby[]" value="client" />
                        <input type="button" value="Save" style="margin-right:10px;" onclick="javascript:show_all('<?php echo $name.$counter?>')" />
                    </li>
                </ul>
            </div>
       </div>
    </div>
<?php
	if ( $die <> 1 ) die();
}
add_action('wp_ajax_cs_pb_client', 'cs_pb_client');
// our client html form for page builder end 

// Team page builder function
function cs_pb_team($die = 0){
	global $cs_node, $count_node, $post;
	if ( isset($_POST['action']) ) {
		$name = $_POST['action'];
		$counter = $_POST['counter'];
		$var_pb_team_element_size = '50';
		$var_pb_team_title = '';
		$var_pb_team_cat = '';
		$var_pb_team_view = '';
		$var_pb_team_excerpt = '255';
		$var_pb_team_filterable = '';
		$var_pb_cat_team_show = '';
		$var_pb_team_per_page = get_option("posts_per_page");
	}
	else {
		$name = $cs_node->getName();
			$count_node++;
			$var_pb_team_element_size = $cs_node->var_pb_team_element_size;
			$var_pb_team_title = $cs_node->var_pb_team_title;
			$var_pb_team_cat = $cs_node->var_pb_team_cat;
			$var_pb_team_view = $cs_node->var_pb_team_view;
			$var_pb_team_excerpt = $cs_node->var_pb_team_excerpt;
			$var_pb_team_filterable = $cs_node->var_pb_team_filterable;
			$var_pb_cat_team_show = $cs_node->var_pb_cat_team_show;
			$var_pb_team_pagination = $cs_node->var_pb_team_pagination;
 			$var_pb_team_per_page = $cs_node->var_pb_team_per_page;
				$counter = $post->ID.$count_node;
	}
?> 
	<div id="<?php echo $name.$counter?>_del" class="column parentdelete column_<?php echo $var_pb_team_element_size?>" item="album" data="<?php echo element_size_data_array_index($var_pb_team_element_size)?>" >
		<div class="column-in">
            <h5><?php echo ucfirst(str_replace("cs_pb_","",$name))?></h5>
            <input type="hidden" name="var_pb_team_element_size[]" class="item" value="<?php echo $var_pb_team_element_size?>" >
            <a href="javascript:hide_all('<?php echo $name.$counter?>')" class="options">Options</a>
            <a href="#" class="delete-it btndeleteit">Del</a> &nbsp; 
            <a class="decrement" onclick="javascript:decrement(this)">Dec</a> &nbsp; 
            <a class="increment" onclick="javascript:increment(this)">Inc</a>
		</div>
        <div class="poped-up" id="<?php echo $name.$counter?>" style="border:none; background:#f8f8f8;" >
            <div class="opt-head">
                <h5>Edit Album Options</h5>
                <a href="javascript:show_all('<?php echo $name.$counter?>')" class="closeit">&nbsp;</a>
            </div>
            <div class="opt-conts">
            	<ul class="form-elements">
                    <li class="to-label"><label>Team Title</label></li>
                    <li class="to-field">
                        <input type="text" name="var_pb_team_title[]" class="txtfield" value="<?php echo htmlspecialchars($var_pb_team_title)?>" />
                        <p>Team Page Title</p>
                    </li>                                            
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Choose Category</label></li>
                    <li class="to-field">
                        <select name="var_pb_team_cat[]" class="dropdown">
                        	<option value="0">-- Select Category --</option>
                        	<?php show_all_cats('', '', $var_pb_team_cat, "team-category");?>
                        </select>
                        <p>Choose category to show Class list</p>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Select View</label></li>
                    <li class="to-field">
                        <select name="var_pb_team_view[]" class="dropdown">
                         	<option <?php if($var_pb_team_view=="List View")echo "selected";?>>List View</option>
                            <option <?php if($var_pb_team_view=="home_view")echo "selected";?> value="home_view">Home View</option>
                        </select>
                    </li>                                        
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>Length of Excerpt</label></li>
                    <li class="to-field">
                        <input type="text" name="var_pb_team_excerpt[]" class="txtfield" value="<?php echo $var_pb_team_excerpt;?>" />
                        <p>Enter number of Words for short description text.</p>
                    </li>                         
                </ul>

				<ul class="form-elements">
                    <li class="to-label"><label>Pagination</label></li>
                    <li class="to-field">
                        <select name="var_pb_team_pagination[]" class="dropdown" >
                            <option <?php if($var_pb_team_pagination=="Show Pagination")echo "selected";?> >Show Pagination</option>
                            <option <?php if($var_pb_team_pagination=="Single Page")echo "selected";?> >Single Page</option>
                        </select>
                    </li>
                </ul>
                <ul class="form-elements">
                    <li class="to-label"><label>No. of Team Per Page</label></li>
                    <li class="to-field">
                        <input type="text" name="var_pb_team_per_page[]" class="txtfield" value="<?php echo $var_pb_team_per_page;?>" />
                        <p>To display all the records, leave this field blank.</p>
                    </li>
                </ul>
                <ul class="form-elements noborder">
                    <li class="to-label"><label></label></li>
                    <li class="to-field">
                    	<input type="hidden" name="cs_orderby[]" value="team" />
                        <input type="button" value="Save" style="margin-right:10px;" onclick="javascript:show_all('<?php echo $name.$counter?>')" />
                    </li>
                </ul>
            </div>
       </div>
    </div>
<?php
	if ( $die <> 1 ) die();
}
add_action('wp_ajax_cs_pb_team', 'cs_pb_team');


// tabs html form for page builder start
function cs_pb_tabs($die = 0){
	global $cs_node, $count_node, $post;
	if ( isset($_POST['action']) ) {
		$name = $_POST['action'];
		$counter = $_POST['counter'];
		$tabs_element_size = '50';
		$tab_title = '';
		$tab_text = '';
	}
	else {
		$name = $cs_node->getName();
			$count_node++;
			$tabs_element_size = $cs_node->tabs_element_size;
			$tab_title = $cs_node->tab_title;
			$tab_text = $cs_node->tab_text;
				$counter = $post->ID.$count_node;
}
?> 
	<div id="<?php echo $name.$counter?>_del" class="column  parentdelete column_<?php echo $tabs_element_size?>" item="tabs" data="<?php echo element_size_data_array_index($tabs_element_size)?>" >
    	<div class="column-in">
            <h5><?php echo ucfirst(str_replace("cs_pb_","",$name))?></h5>
            <input type="hidden" name="tabs_element_size[]" class="item" value="<?php echo $tabs_element_size?>" >
            <a href="javascript:hide_all('<?php echo $name.$counter?>')" class="options">Options</a> &nbsp; 
            <a href="#" class="delete-it btndeleteit">Del</a> &nbsp;  
            <a class="decrement" onclick="javascript:decrement(this)">Dec</a> &nbsp; 
            <a class="increment" onclick="javascript:increment(this)">Inc</a>
		</div>
       	<div class="poped-up" id="<?php echo $name.$counter?>" style="border:none; background:#f8f8f8;" >
            <div class="opt-head">
                <h5>Edit Tabs Options</h5>
                <a href="javascript:show_all('<?php echo $name.$counter?>')" class="closeit">&nbsp;</a>
            </div>
				<div class="wrapptabbox">
                    <div class="clone_append">
                        <?php
						$tabs_num = 0;
                        if ( isset($cs_node) ){
							$tabs_num = count($cs_node->tab);
                            foreach ( $cs_node->tab as $tab ){
								if ( $tab->tab_active == "yes" ) { $tab_active = "selected"; }
								else { $tab_active = ""; }
								echo "<div class='clone_form'>";
									echo "<a href='#' class='deleteit_node'>Delete it</a>";
									echo '<label>Tab Title:</label> <input class="txtfield" type="text" name="tab_title[]" value="'.$tab->tab_title.'" />';
									echo '<label>Tab Text:</label> <textarea class="txtfield" name="tab_text[]">'.$tab->tab_text.'</textarea>';
									echo '<label>Title Icon:</label> <input class="txtfield" type="text" name="tab_title_icon[]" value="'.$tab->tab_title_icon.'" />';
									echo '<label>Active:</label> <select name="tab_active[]"><option>no</option><option '.$tab_active.'>yes</option></select> ';
								echo "</div>";
                            }
                        }
                        ?>
                    </div>
                    <div class="opt-conts">
                        <ul class="form-elements">
                            <li class="to-label"><label></label></li>
                            <li class="to-field"><a href="#" class="addedtab">Add Tab</a></li>
                        </ul>
                        <ul class="form-elements noborder">
                            <li class="to-label"></li>
                            <li class="to-field">
                                <input type="hidden" name="tabs_num[]" value="<?php echo $tabs_num?>" class="fieldCounter"  />
                                <input type="hidden" name="cs_orderby[]" value="tabs" />
                                <input type="button" value="Save" style="margin-right:10px;" onclick="javascript:show_all('<?php echo $name.$counter?>')" />
                            </li>
                        </ul>
                    </div>
            	</div>
                            
       </div>
    </div>
<?php
	if ( $die <> 1 ) die();
}
add_action('wp_ajax_cs_pb_tabs', 'cs_pb_tabs');
// tabs html form for page builder end

// services html form for page builder start
function cs_pb_services($die = 0){
	global $cs_node, $count_node, $post;
	if ( isset($_POST['action']) ) {
		$name = $_POST['action'];
		$counter = $_POST['counter'];
		$services_element_size = '50';
		$service_title = '';
		$service_text = '';
	}
	else {
		$name = $cs_node->getName();
			$count_node++;
			$services_element_size = $cs_node->services_element_size;
			$service_title = $cs_node->service_title;
			$service_text = $cs_node->service_text;
				$counter = $post->ID.$count_node;
}
?> 
	<div id="<?php echo $name.$counter?>_del" class="column parentdelete column_<?php echo $services_element_size?>" item="services" data="<?php echo element_size_data_array_index($services_element_size)?>" >
    	<div class="column-in">
            <h5><?php echo ucfirst(str_replace("cs_pb_","",$name))?></h5>
            <input type="hidden" name="services_element_size[]" class="item" value="<?php echo $services_element_size?>" >
           	<a href="javascript:hide_all('<?php echo $name.$counter?>')" class="options">Options</a> &nbsp; 
            <a href="#" class="delete-it btndeleteit">Del</a> &nbsp;  
            <a class="decrement" onclick="javascript:decrement(this)">Dec</a> &nbsp; 
            <a class="increment" onclick="javascript:increment(this)">Inc</a>
        </div>
       	<div class="poped-up" id="<?php echo $name.$counter?>" style="border:none; background:#f8f8f8;" >
            <div class="opt-head">
                <h5>Edit Services Options</h5>
                <a href="javascript:show_all('<?php echo $name.$counter?>')" class="closeit">&nbsp;</a>
            </div>
				<div class="wrapptabbox">
                    <div class="clone_append">
                        <?php
						$services_num = 0;
                        if ( isset($cs_node) ){
							$services_num = count($cs_node->service);
                            foreach ( $cs_node->service as $service ){
						?>
								<div class='clone_form'>
									<a href='#' class='deleteit_node'>Delete it</a>
									<label>Service Title:</label> <input class="txtfield" type="text" name="service_title[]" value="<?php echo $service->service_title ?>" />
									<label>Service Icon:</label> <input class="txtfield" type="text" name="service_icon[]" value="<?php echo $service->service_icon ?>" />
									<label>Link URL:</label> <input class="txtfield" type="text" name="service_url[]" value="<?php echo $service->service_url ?>" />
									<label>Service Text:</label> <textarea class="txtfield" name="service_text[]"><?php echo $service->service_text ?></textarea>
									<label>Style</label>
                                    <select name="service_style[]">
                                    	<option <?php if($service->service_style == "service1") echo "selected";?> >service1</option>
                                        <option <?php if($service->service_style == "service2") echo "selected";?> >service2</option>
                                        <option <?php if($service->service_style == "service3") echo "selected";?> >service3</option>
                                        <option <?php if($service->service_style == "service4") echo "selected";?> >service4</option>
                                    </select>
								</div>
                        
                        <?php
                            }
                        }
                        ?>
                    </div>
                    <div class="opt-conts">
                        <ul class="form-elements">
                            <li class="to-label"><label></label></li>
                            <li class="to-field"><a href="#" class="add_services">Add service</a></li>
                        </ul>
                        <ul class="form-elements noborder">
                            <li class="to-label"></li>
                            <li class="to-field">
                                <input type="hidden" name="services_num[]" value="<?php echo $services_num?>" class="fieldCounter"  />
                                <input type="hidden" name="cs_orderby[]" value="services" />
                                <input type="button" value="Save" style="margin-right:10px;" onclick="javascript:show_all('<?php echo $name.$counter?>')" />
                            </li>
                        </ul>
                    </div>
            	</div>
                            
       </div>
    </div>
<?php
	if ( $die <> 1 ) die();
}
add_action('wp_ajax_cs_pb_services', 'cs_pb_services');
// services html form for page builder end

// accordion html form for page builder start
function cs_pb_accordion($die = 0){
	global $cs_node, $count_node, $post;
	if ( isset($_POST['action']) ) {
		$name = $_POST['action'];
		$counter = $_POST['counter'];
		$accordion_element_size = '50';
		$accordion_title = '';
		$accordion_text = '';
	}
	else {
		$name = $cs_node->getName();
			$count_node++;
			$accordion_element_size = $cs_node->accordion_element_size;
			$accordion_title = $cs_node->accordion_title;
			$accordion_text = $cs_node->accordion_text;
				$counter = $post->ID.$count_node;
}
?> 
	<div id="<?php echo $name.$counter?>_del" class="column  parentdelete column_<?php echo $accordion_element_size?>" item="accordion" data="<?php echo element_size_data_array_index($accordion_element_size)?>" >
    	<div class="column-in">
            <h5><?php echo ucfirst(str_replace("cs_pb_","",$name))?></h5>
            <input type="hidden" name="accordion_element_size[]" class="item" value="<?php echo $accordion_element_size?>" >
            <a href="javascript:hide_all('<?php echo $name.$counter?>')" class="options">Options</a> &nbsp; 
            <a href="#" class="delete-it btndeleteit">Del</a> &nbsp;  
            <a class="decrement" onclick="javascript:decrement(this)">Dec</a> &nbsp; 
            <a class="increment" onclick="javascript:increment(this)">Inc</a>
		</div>
       	<div class="poped-up" id="<?php echo $name.$counter?>" style="border:none; background:#f8f8f8;" >
            <div class="opt-head">
                <h5>Edit Accordion Options</h5>
                <a href="javascript:show_all('<?php echo $name.$counter?>')" class="closeit">&nbsp;</a>
            </div>
				<div class="wrapptabbox">
                    <div class="clone_append">
                        <?php
						$accordion_num = 0;
                        if ( isset($cs_node) ){
							$accordion_num = count($cs_node->accordion);
                            foreach ( $cs_node->accordion as $val ){
								if ( $val->accordion_active == "yes" ) { $tab_active = "selected"; }
								else { $tab_active = ""; }
								echo "<div class='clone_form'>";
									echo "<a href='#' class='deleteit_node'>Delete it</a>";
									echo '<label>Tab Title:</label> <input class="txtfield" type="text" name="accordion_title[]" value="'.$val->accordion_title.'" />';
									echo '<label>Tab Text:</label> <textarea class="txtfield" name="accordion_text[]">'.$val->accordion_text.'</textarea>';
									echo '<label>Title Icon:</label> <input class="txtfield" type="text" name="accordion_title_icon[]" value="'.$val->accordion_title_icon.'" />';
									echo '<label>Active:</label> <select name="accordion_active[]"><option>no</option><option '.$tab_active.'>yes</option></select> ';
								echo "</div>";
                            }
                        }
                        ?>
                    </div>
                    <div class="opt-conts">
                        <ul class="form-elements">
                            <li class="to-label"><label></label></li>
                            <li class="to-field"><a href="#" class="add_accordion">Add Tab</a></li>
                        </ul>
                        <ul class="form-elements noborder">
                            <li class="to-label"></li>
                            <li class="to-field">
                                <input type="hidden" name="accordion_num[]" value="<?php echo $accordion_num?>" class="fieldCounter"  />
                                <input type="hidden" name="cs_orderby[]" value="accordions" />
                                <input type="button" value="Save" style="margin-right:10px;" onclick="javascript:show_all('<?php echo $name.$counter?>')" />
                            </li>
                        </ul>
                    </div>
            	</div>
                            
       </div>
    </div>
<?php
	if ( $die <> 1 ) die();
}
add_action('wp_ajax_cs_pb_accordion', 'cs_pb_accordion');
// accordion html form for page builder end
// page bulider items end


// side bar layout in pages, post and default page(theme options) start
function cs_meta_layout(){
	global $cs_xmlObject;
	if ( empty($cs_xmlObject->sidebar_layout->cs_layout) ) $cs_layout = ""; else $cs_layout = $cs_xmlObject->sidebar_layout->cs_layout;
	if ( empty($cs_xmlObject->sidebar_layout->cs_sidebar_left) ) $cs_sidebar_left = ""; else $cs_sidebar_left = $cs_xmlObject->sidebar_layout->cs_sidebar_left;
	if ( empty($cs_xmlObject->sidebar_layout->cs_sidebar_right) ) $cs_sidebar_right = ""; else $cs_sidebar_right = $cs_xmlObject->sidebar_layout->cs_sidebar_right;
  ?>
	<div class="elementhidden">
        <div class="clear"></div>
    	<div class="opt-head">
            <h4>Layout Options</h4>
            <div class="clear"></div>
        </div>
        <ul class="form-elements">
            <li class="to-label">
                <label>Select Layout</label>
            </li>
            <li class="to-field">
                <div class="meta-input">
                    <div class='radio-image-wrapper'>
                        <input <?php if($cs_layout=="none")echo "checked"?> onclick="show_sidebar('none')" type="radio" name="cs_layout" class="radio" value="none" id="radio_1" />
                        <label for="radio_1">
                            <span class="ss"><img src="<?php echo get_template_directory_uri()?>/images/admin/1.gif"  alt="" /></span>
                            <span <?php if($cs_layout=="none")echo "class='check-list'"?> id="check-list"><img src="<?php echo get_template_directory_uri()?>/images/admin/1-hover.gif" alt="" /></span>
                        </label>
                    </div>
                    <div class='radio-image-wrapper'>
                        <input <?php if($cs_layout=="right")echo "checked"?> onclick="show_sidebar('right')" type="radio" name="cs_layout" class="radio" value="right" id="radio_2"  />
                        <label for="radio_2">
                            <span class="ss"><img src="<?php echo get_template_directory_uri()?>/images/admin/2.gif" alt="" /></span>
                            <span <?php if($cs_layout=="right")echo "class='check-list'"?> id="check-list"><img src="<?php echo get_template_directory_uri()?>/images/admin/2-hover.gif" alt="" /></span>
                        </label>
                    </div>
                    <div class='radio-image-wrapper'>
                        <input <?php if($cs_layout=="left")echo "checked"?> onclick="show_sidebar('left')" type="radio" name="cs_layout" class="radio" value="left" id="radio_3" />
                        <label for="radio_3">
                            <span class="ss"><img src="<?php echo get_template_directory_uri()?>/images/admin/3.gif" alt="" /></span>
                            <span <?php if($cs_layout=="left")echo "class='check-list'"?> id="check-list"><img src="<?php echo get_template_directory_uri()?>/images/admin/3-hover.gif" alt="" /></span>
                        </label>
                    </div>
                </div>
            </li>
        </ul>
        <ul class="form-elements meta-body" style=" <?php if($cs_sidebar_left == ""){echo "display:none";}else echo "display:block";?>" id="sidebar_left" >
            <li class="to-label">
                <label>Select Left Sidebar</label>
            </li>
            <li class="to-field">
                <select name="cs_sidebar_left" class="select_dropdown" id="page-option-choose-left-sidebar">
                    <?php
                    $cs_theme_option = get_option('cs_theme_option');
                    if ( isset($cs_theme_option['sidebar']) and count($cs_theme_option['sidebar']) > 0 ) {
                        foreach ( $cs_theme_option['sidebar'] as $sidebar ){
                        ?>
                            <option <?php if ($cs_sidebar_left==$sidebar)echo "selected";?> ><?php echo $sidebar;?></option>
                        <?php
                        }
                    }
                    ?>
                </select>
            </li>
        </ul>
        <ul class="form-elements meta-body" style=" <?php if($cs_sidebar_right == ""){echo "display:none";}else echo "display:block";?>" id="sidebar_right" >
            <li class="to-label">
                <label>Select Right Sidebar</label>
            </li>
            <li class="to-field">
                <select name="cs_sidebar_right" class="select_dropdown" id="page-option-choose-right-sidebar">
                    <?php
                    if ( isset($cs_theme_option['sidebar']) and count($cs_theme_option['sidebar']) > 0 ) {
                        foreach ( $cs_theme_option['sidebar'] as $sidebar ){
                        ?>
                            <option <?php if ($cs_sidebar_right==$sidebar)echo "selected";?> ><?php echo $sidebar;?></option>
                        <?php
                        }
                    }
                    ?>
                </select>
                <input type="hidden" name="cs_orderby[]" value="meta_layout" />
            </li>
        </ul>
	</div>
	<div class="clear"></div>
<?php	
}
// side bar layout in pages, post and default page(theme options) end

// get element size
function element_size_data_array_index($size){
	if ( $size == "" or $size == 100 ) return 0;
	else if ( $size == 75 ) return 1;
	else if ( $size == 67 ) return 2;
	else if ( $size == 50 ) return 3;
	else if ( $size == 33 ) return 4;
	else if ( $size == 25 ) return 5;
}
// Show all Categories
function show_all_cats($parent, $separator, $selected = "", $taxonomy) {
    if ($parent == "") {
        global $wpdb;
        $parent = 0;
    }
    else
        $separator .= " &ndash; ";
    $args = array(
        'parent' => $parent,
        'hide_empty' => 0,
        'taxonomy' => $taxonomy
    );
    $categories = get_categories($args);
    foreach ($categories as $category) {
        ?>
        <option <?php if ($selected == $category->slug) echo "selected"; ?> value="<?php echo $category->slug ?>"><?php echo $separator . $category->cat_name ?></option>
        <?php
        show_all_cats($category->term_id, $separator, $selected, $taxonomy);
    }
}
// Events Meta data save
function cs_events_meta_save($cs_post_id) {
    global $wpdb;
    if (empty($_POST["sub_title"])){ $_POST["sub_title"] = "";}
    if (empty($_POST["inside_event_thumb_view"])){ $_POST["inside_event_thumb_view"] = "";}
    if (empty($_POST["inside_event_featured_image_as_thumbnail"])){ $_POST["inside_event_featured_image_as_thumbnail"] = "";}
	if (empty($_POST["inside_event_thumb_audio"])){ $_POST["inside_event_thumb_audio"] = "";}
	if (empty($_POST["inside_event_thumb_video"])){ $_POST["inside_event_thumb_video"] = "";}
	if (empty($_POST["inside_event_thumb_slider"])){ $_POST["inside_event_thumb_slider"] = "";}
	if (empty($_POST["inside_event_thumb_slider_type"])){ $_POST["inside_event_thumb_slider_type"] = "";}
	if (empty($_POST["inside_event_thumb_map_lat"])){ $_POST["inside_event_thumb_map_lat"] = "";}
    if (empty($_POST["inside_event_thumb_map_lon"])){ $_POST["inside_event_thumb_map_lon"] = "";}
    if (empty($_POST["inside_event_thumb_map_zoom"])){ $_POST["inside_event_thumb_map_zoom"] = "";}
    if (empty($_POST["inside_event_thumb_map_address"])){ $_POST["inside_event_thumb_map_address"] = "";}
    if (empty($_POST["inside_event_thumb_map_controls"])){ $_POST["inside_event_thumb_map_controls"] = "";}
    if (empty($_POST["event_social_sharing"])){ $_POST["event_social_sharing"] = "";}
	if (empty($_POST["event_rating"])){ $_POST["event_rating"] = "";}
	if (empty($_POST["event_related"])){ $_POST["event_related"] = "";}
	if (empty($_POST["inside_event_related_post_title"])){ $_POST["inside_event_related_post_title"] = "";}
	if (empty($_POST["event_start_time"])){ $_POST["event_start_time"] = "";}
	if (empty($_POST["event_end_time"])){ $_POST["event_end_time"] = "";}
    if (empty($_POST["event_all_day"])){ $_POST["event_all_day"] = "";}
    if (empty($_POST["event_buy_now"])){ $_POST["event_buy_now"] = "";}
    if (empty($_POST["event_ticket_price"])){ $_POST["event_ticket_price"] = "";}
    if (empty($_POST["event_gallery"])){ $_POST["event_gallery"] = "";}
    if (empty($_POST["event_address"])){ $_POST["event_address"] = "";}
    if (empty($_POST["event_map"])){ $_POST["event_map"] = "";}
	if (empty($_POST["event_sub_title"])){ $_POST["event_sub_title"] = "";}
	if (empty($_POST["event_related_events"])){ $_POST["event_related_events"] = "";}
	if (empty($_POST["event_related_events_title"])){ $_POST["event_related_events_title"] = "";}
	if (empty($_POST["event_performers_title"])){ $_POST["event_performers_title"] = "";}
	if (empty($_POST["event_ticket_options"])){ $_POST["event_ticket_options"] = "";}
	if (empty($_POST["var_cp_trainer"])){ $var_cp_trainer = "";} else {
		$var_cp_trainer = implode(",", $_POST["var_cp_trainer"]);
	}
    	
    $sxe = new SimpleXMLElement("<event></event>");
		$sxe->addChild('sub_title', $_POST['sub_title'] );
		$sxe->addChild('header_banner_options', $_POST['header_banner_options'] );
		$sxe->addChild('header_banner', $_POST['header_banner'] );
		$sxe->addChild('slider_id', $_POST['slider_id'] );
		$sxe->addChild('inside_event_thumb_view', $_POST['inside_event_thumb_view'] );
		$sxe->addChild('inside_event_featured_image_as_thumbnail', $_POST['inside_event_featured_image_as_thumbnail'] );
		$sxe->addChild('inside_event_thumb_audio', $_POST['inside_event_thumb_audio'] );
		$sxe->addChild('inside_event_thumb_video', $_POST['inside_event_thumb_video'] );
		$sxe->addChild('inside_event_thumb_slider', $_POST['inside_event_thumb_slider'] );
		$sxe->addChild('inside_event_thumb_slider_type', $_POST['inside_event_thumb_slider_type'] );
		$sxe->addChild('inside_event_thumb_map_lat', $_POST['inside_event_thumb_map_lat'] );
		$sxe->addChild('inside_event_thumb_map_lon', $_POST['inside_event_thumb_map_lon'] );
		$sxe->addChild('inside_event_thumb_map_zoom', $_POST['inside_event_thumb_map_zoom'] );
		$sxe->addChild('inside_event_thumb_map_address', $_POST['inside_event_thumb_map_address'] );
		$sxe->addChild('inside_event_thumb_map_controls', $_POST['inside_event_thumb_map_controls'] );
		$sxe->addChild('event_social_sharing', $_POST["event_social_sharing"]);
		$sxe->addChild('event_rating', $_POST["event_rating"]);
		$sxe->addChild('event_related', $_POST["event_related"]);
		$sxe->addChild('inside_event_related_post_title', $_POST["inside_event_related_post_title"]);
 		$sxe->addChild('event_start_time', $_POST["event_start_time"]);
		$sxe->addChild('event_end_time', $_POST["event_end_time"]);
		$sxe->addChild('event_all_day', $_POST["event_all_day"]);
		$sxe->addChild('event_buy_now', $_POST["event_buy_now"]);
		$sxe->addChild('event_ticket_price', $_POST["event_ticket_price"]);
		$sxe->addChild('event_gallery', $_POST["event_gallery"]);
 		$sxe->addChild('event_address', $_POST["event_address"]);
		$sxe->addChild('event_map', $_POST["event_map"]);
		$sxe->addChild('event_sub_title', $_POST["event_sub_title"]);
		$sxe->addChild('event_related_events', $_POST["event_related_events"]);
		$sxe->addChild('event_related_events_title', $_POST["event_related_events_title"]);
		$sxe->addChild('event_performers_title', $_POST["event_performers_title"]);
		$sxe->addChild('event_ticket_options', $_POST["event_ticket_options"]);
		$sxe->addChild('var_cp_trainer', $var_cp_trainer);
    $sxe = save_layout_xml($sxe);
    update_post_meta($cs_post_id, 'cs_event_meta', $sxe->asXML());
}

// Default xml data save
function save_layout_xml($sxe) {
	
	if (empty($_POST['page_title']))
        $_POST['page_title'] = "";
    if (empty($_POST['cs_layout']))
        $_POST['cs_layout'] = "";
    if (empty($_POST['cs_sidebar_left']))
        $_POST['cs_sidebar_left'] = "";
    if (empty($_POST['cs_sidebar_right']))
        $_POST['cs_sidebar_right'] = "";
	$sxe->addChild('page_title', $_POST['page_title']);
	$sidebar_layout = $sxe->addChild('sidebar_layout');
		$sidebar_layout->addChild('cs_layout', $_POST["cs_layout"]);
		if ($_POST["cs_layout"] == "left") {
			$sidebar_layout->addChild('cs_sidebar_left', $_POST['cs_sidebar_left']);
		} else if ($_POST["cs_layout"] == "right") {
			$sidebar_layout->addChild('cs_sidebar_right', $_POST['cs_sidebar_right']);
		}else if ($_POST["cs_layout"] == "both_right" or $_POST["cs_layout"] == "both_left" or $_POST["cs_layout"] == "both") {
			$sidebar_layout->addChild('cs_sidebar_left', $_POST['cs_sidebar_left']);
			$sidebar_layout->addChild('cs_sidebar_right', $_POST['cs_sidebar_right']);
		}
    return $sxe;
}

/* Theme option Fucntions Start */

// stripslashes / htmlspecialchars for theme option save start
function cs_stripslashes_htmlspecialchars($value)
{
    $value = is_array($value) ? array_map('cs_stripslashes_htmlspecialchars', $value) : stripslashes(htmlspecialchars($value));
    return $value;
}
// stripslashes / htmlspecialchars for theme option save end


// saving all the theme options start
function cs_theme_option_save() {
	if ( isset($_POST['logo']) ) {
		$_POST = cs_stripslashes_htmlspecialchars($_POST);
		if ( $_SERVER["REQUEST_METHOD"] == "POST" and isset($_POST['twitter_setting'])){
			update_option( "cs_theme_option", $_POST );
			echo "All Settings Saved";
 		}else{
			update_option( "cs_theme_option", $_POST );
			echo "All Settings Saved";
			
		}
		// upating config file end
			
	}
	else {
		$target_path_mo = get_template_directory()."/languages/".$_FILES["mofile"]["name"][0];
		if ( move_uploaded_file($_FILES["mofile"]["tmp_name"][0], $target_path_mo) ) {
			chmod($target_path_mo,0777);
		}
		echo "New Language Uploaded Successfully";
	}
	die();
}
add_action('wp_ajax_cs_theme_option_save', 'cs_theme_option_save');
// saving all the theme options end

function cs_theme_option_import_export() {
	$a = unserialize(base64_decode($_POST['theme_option_data']));
	update_option( "cs_theme_option", $a );
	echo "Otions Imported";
	die();
}
add_action('wp_ajax_cs_theme_option_import_export', 'cs_theme_option_import_export');
// saving theme options import export end

// restoring default theme options start

function theme_option_restore_default() {
	cs_activation_data();
	//update_option( "cs_theme_option", get_option('cs_theme_option_restore') );

	echo "Default Theme Options Restored";

	die();

}

add_action('wp_ajax_theme_option_restore_default', 'theme_option_restore_default');

// restoring default theme options end

// saving theme options backup start
function cs_theme_option_backup() {
	update_option( "cs_theme_option_backup", get_option('cs_theme_option') );
	update_option( "cs_theme_option_backup_time", gmdate("Y-m-d H:i:s") );
	echo "Current Backup Taken @ " . gmdate("Y-m-d H:i:s");
	die();
}
add_action('wp_ajax_cs_theme_option_backup', 'cs_theme_option_backup');
// saving theme options backup end

// restore backup start
function cs_theme_option_backup_restore() {
	update_option( "cs_theme_option", get_option('cs_theme_option_backup') );
	echo "Backup Restored";
	die();
}
add_action('wp_ajax_cs_theme_option_backup_restore', 'cs_theme_option_backup_restore');
// restore backup end

/* Theme option Fucntions End  */
  
// media pagination for slider/gallery in admin side start
function cs_media_pagination(){
	foreach ( $_REQUEST as $keys=>$values) {
		$$keys = $values;
	}
	$records_per_page = 10;
	if ( empty($page_id) ) $page_id = 1;
	$offset = $records_per_page * ($page_id-1);
?>
	<ul class="gal-list">
      <?php
        $query_images_args = array('post_type' => 'attachment', 'post_mime_type' =>'image', 'post_status' => 'inherit', 'posts_per_page' => -1,);
        $query_images = new WP_Query( $query_images_args );
        if ( empty($total_pages) ) $total_pages = count( $query_images->posts );
		$query_images_args = array('post_type' => 'attachment', 'post_mime_type' =>'image', 'post_status' => 'inherit', 'posts_per_page' => $records_per_page, 'offset' => $offset,);
        $query_images = new WP_Query( $query_images_args );
        $images = array();
        foreach ( $query_images->posts as $image) {
        	$image_path = wp_get_attachment_image_src( $image->ID, array( get_option("thumbnail_size_w"),get_option("thumbnail_size_h") ) );
        ?>
        	<li style="cursor:pointer"><img src="<?php echo $image_path[0]?>" onclick="javascript:clone('<?php echo $image->ID?>')" alt="" /></li>
         <?php
         }
         ?>
      </ul>
      <br />
      <div class="pagination-cus">
        	<ul>
				<?php
                if ( $page_id > 1 ) echo "<li><a href='javascript:show_next(".($page_id-1).",$total_pages)'>Prev</a></li>";
                    for ( $i = 1; $i <= ceil($total_pages/$records_per_page); $i++ ) {
                        if ( $i <> $page_id ) echo "<li><a href='javascript:show_next($i,$total_pages)'>" . $i . "</a></li> ";
                        else echo "<li class='active'><a>" . $i . "</a></li>";
                    }
                if ( $page_id < $total_pages/$records_per_page ) echo "<li><a href='javascript:show_next(".($page_id+1).",$total_pages)'>Next</a></li>";
                ?>
			</ul>
        </div>
<?php
	if ( isset($_POST['action']) ) die();
}
add_action('wp_ajax_cs_media_pagination', 'cs_media_pagination');
// media pagination for slider/gallery in admin side end