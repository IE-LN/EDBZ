<?php 
	global $cs_node,$counter_node,$cs_theme_option;
?>
	<div class="element_size_<?php echo $cs_node->slider_element_size; ?> column"> 
    <?php	if ($cs_node->slider_header_title <> '') { ?>
    	<header class="heading">
        	<h2 class="cs-headding-color section-title"><?php echo $cs_node->slider_header_title; ?></h2>
       	</header>
    <?php  } ?>
 	<?php
 		if(!empty($cs_node->slider)){
		// slider slug to id start
			$args=array(
			  'name' => $cs_node->slider,
			  'post_type' => 'cs_slider',
			  'post_status' => 'publish',
			  'showposts' => 1,
			);
 			$get_posts = get_posts($args);
			if($get_posts){
				$slider_id = $get_posts[0]->ID;
					echo cs_flex_slider('1080','468',$slider_id);
			}
		}else{
		echo "Please Select Slider";
	}
	?>
</div>
