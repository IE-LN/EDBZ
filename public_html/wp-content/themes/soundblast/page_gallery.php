<?php
	global $cs_node,$counter_node;
 	$count_post =0;
 	// galery slug to id start
		$args=array(
			'name' => $cs_node->album,
			'post_type' => 'cs_gallery',
			'post_status' => 'publish',
			'showposts' => 1,
		);
 		$get_posts = get_posts($args);
		if($get_posts){
			$gal_album_db = $get_posts[0]->ID;
		}
	// galery slug to id end
	$cs_meta_gallery_options = get_post_meta($gal_album_db, "cs_meta_gallery_options", true);
	if ( empty($_GET['page_id_all']) ) $_GET['page_id_all'] = 1;
	// pagination start
	if ( $cs_meta_gallery_options <> "" ) {
		$cs_xmlObject = new SimpleXMLElement($cs_meta_gallery_options);
		if ($cs_node->media_per_page > 0 ) {
			$limit_start = $cs_node->media_per_page * ($_GET['page_id_all']-1);
			$limit_end = $limit_start + $cs_node->media_per_page;
			$count_post = count($cs_xmlObject->gallery);
				if ( $limit_end > count($cs_xmlObject->gallery) ) 
					$limit_end = count($cs_xmlObject->gallery);
		}
		else {
			$limit_start = 0;
			$limit_end = count($cs_xmlObject->gallery);
			$count_post = count($cs_xmlObject->gallery);
		}
	}
	$layout=cs_meta_content_class();
	if($layout == 'col-sm-9 col-md-9'){
		if($cs_node->layout == 'gallery-four-col'){
			$cs_node->layout = 'gallery-three-col';
		} else if($cs_node->layout == 'gallery-three-col'){
			$cs_node->layout = 'gallery-tow-col';
		}
	}
	?>
    <script type="text/javascript">
	   jQuery(document).ready(function() {
			cs_gallery_js();
		 });
    </script>
    <div class="element_size_<?php echo $cs_node->gallery_element_size; ?>">
    <?php
		if ($cs_node->header_title <> '') { ?>
                <header class="cs-heading-title">
                    <h2 class="cs-section-title cs-heading-color"><?php echo $cs_node->header_title; ?></h2>
                </header>
        <?php  } ?>
     <div class="gallerysec gallery">
        <ul class="<?php echo $cs_node->layout;?> lightbox clearfix">
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
 					$image_url = cs_attachment_image_src($path, 330, 330);
                    $image_url_full = cs_attachment_image_src($path, 0, 0);
					$gallery_video_class = "";
					if($use_image_as==1){
						$gallery_video_class = 'class="video-item"';
					}
 					?>
            <li <?php echo $gallery_video_class; ?>>
                <figure>
                    <img src="<?php echo $image_url;?>" alt="">
                    <figcaption>
                            <a  data-rel="<?php if($use_image_as==1)echo "prettyPhoto";  elseif($use_image_as==2) echo ""; else echo "prettyPhoto[gallery1]"?>" href="<?php if($use_image_as==1)echo $video_code; elseif($use_image_as==2) echo $link_url; else echo $image_url_full;?>" target="<?php if($use_image_as==2) echo '_blank'; ?>" data-title="<?php //if ( $cs_node->desc == "On" ) { echo $description; }?>">
                            <?php 
							  if($use_image_as==1){
								  echo '<i class="fa fa-play"></i>';
							  }elseif($use_image_as==2){
								  echo '<i class="fa fa-link"></i>';	
							  }else{
								  echo '<i class="fa fa-search-plus"></i>';
							  }
							?>
                            </a>
                    </figcaption>
                </figure>
            </li>
   <?php }}?>
   		</ul>
   </div>
   <?php
	// pagination start
	$qrystr = '';
	 if ( $cs_node->pagination == "Show Pagination" and $count_post > $cs_node->media_per_page and $cs_node->media_per_page > 0 ) {
			$qrystr = '';
			if ( isset($_GET['page_id']) ) $qrystr = "&page_id=".$_GET['page_id'];						
		echo cs_pagination( $count_post, $cs_node->media_per_page,$qrystr );
	}
	// pagination end
	?>
</div>