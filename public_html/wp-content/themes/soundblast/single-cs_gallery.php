<?php
	global $cs_node,$cs_theme_option,$counter_node,$video_width;
	$cs_node = new stdClass();
	$cs_node->media_per_page = -1;
	if(!isset($cs_node->desc)){ $cs_node->desc = "On"; }
	
  	get_header();
	if (have_posts()):
	while (have_posts()) : the_post();
 	$count_post =0;
 	// galery slug to id start

	// galery slug to id end
	$cs_meta_gallery_options = get_post_meta($post->ID, "cs_meta_gallery_options", true);
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
	?>
    <script type="text/javascript">
	   jQuery(document).ready(function() {
			cs_gallery_js();
		 });
    </script>
  <div class="col-sm-12 col-md-12">
     <div class="gallerysec gallery">
        <ul class="gallery-four-col lightbox clearfix">
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
 					$image_url = cs_attachment_image_src($path, 492, 370);
                    $image_url_full = cs_attachment_image_src($path, 0, 0);
 					?>
            <li>
                <figure>
                    <img src="<?php echo $image_url;?>" alt="">
                    <figcaption>
                            <a  data-rel="<?php if($use_image_as==1)echo "prettyPhoto";  elseif($use_image_as==2) echo ""; else echo "prettyPhoto[gallery1]"?>" href="<?php if($use_image_as==1)echo $video_code; elseif($use_image_as==2) echo $link_url; else echo $image_url_full;?>" target="<?php if($use_image_as==2) echo '_blank'; ?>" data-title="<?php if ( $cs_node->desc == "On" ) { echo $description; }?>" rel="prettyPhoto"><i class="fa fa-search-plus"></i></a>
                    </figcaption>
                </figure>
            </li>
   <?php }}?>
   		</ul>
   </div>
</div>      
<?php endwhile;   endif;?>
<!--Footer-->
<?php get_footer(); ?>
