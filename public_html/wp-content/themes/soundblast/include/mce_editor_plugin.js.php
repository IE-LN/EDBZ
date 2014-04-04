<?php 
	require_once '../../../../wp-load.php';
	require_once '../../../../wp-admin/includes/admin.php';
	do_action('admin_init');
	
	if ( ! is_user_logged_in() )
		die('You must be logged in to access this script.');
	
	if(!isset($shortcodesES))
		$shortcodesES = new ShortcodesEditorSelector();
	
	global $shortcode_tags;
	$ordered_sct = array_keys($shortcode_tags);
	$neworder = sort($ordered_sct);

?>

(function() {
	tinymce.create('tinymce.plugins.<?php echo $shortcodesES->buttonName; ?>', {
		init : function(ed, url) {
		},	
		createControl : function(n, cm) {
			if(n=='<?php echo $shortcodesES->buttonName; ?>'){
                var mlb = cm.createListBox('<?php echo $shortcodesES->buttonName; ?>', {
                     title : 'Shortcode',
                         onselect : function(v) { //Add shortcode data onClick
                             if(v == 'toogle'){
                                        tinyMCE.activeEditor.selection.setContent('[toggle active="yes" title="Toggle Title 1"]Toggle Content 1[/toggle]<br /><br />');
                                }
                             else if(v == 'tabs'){
                                        tinyMCE.activeEditor.selection.setContent('[tab style="horizontal/vertical"] <br />\
                                            [tab_item active="yes" icon="fa-twitter" title="Tab Title 1" tabs="tabs"]Tab Content 1[/tab_item]<br />\
                                            [tab_item icon="" title="Tab Title 2" tabs="tabs"]Tab Content 2[/tab_item]<br />\
                                            [tab_item icon="" title="Tab Title 3" tabs="tabs"]Tab Content 3[/tab_item]<br />\
                                            [/tab]<br /><br />');
                                }
                             else if(v == 'accordion'){
                                        tinyMCE.activeEditor.selection.setContent('[accordion] <br />\
                                            [accordion_item active="yes" icon="fa-twitter" title="Accordion Title 1" accordion="accordion"]Accordion Content 1[/accordion_item] <br />\
                                            [accordion_item title="Accordion Title 2" accordion="accordion"]Accordion Content 2[/accordion_item] <br />\
                                            [accordion_item title="Accordion Title 3" accordion="accordion"]Accordion Content 3[/accordion_item] <br />\
                                            [/accordion]<br /><br />');
                                }
                             else if(v == 'quote'){
                                        tinyMCE.activeEditor.selection.setContent('[quote align="center" color="#COLOR_CODE"]Quote Content[/quote]<br /><br />');
                                }
                             else if(v == 'button'){
                                        tinyMCE.activeEditor.selection.setContent('[button style="medium" type="rounded" color="#COLOR_CODE" background="#COLOR_CODE" src="LINK_URL" target="_blank"]Button Content[/button]<br /><br />');
                                }
                             else if(v == 'column'){
                                        tinyMCE.activeEditor.selection.setContent('[column size="1/2"]Column Content[/column]<br /><br />');
                                }
                             else if(v == 'dropcap'){
                                        tinyMCE.activeEditor.selection.setContent('[dropcap style="1"]Dropcap Content[/dropcap]<br /><br />');
                                }
                             else if(v == 'message_box'){
                                        tinyMCE.activeEditor.selection.setContent('[message_box align="left" icon="fa-info-sign" close="yes" color="#COLOR_CODE" background="#COLOR_CODE" border_color="#COLOR_CODE" box_shadow_color="#COLOR_CODE" title="Message Title"]Message Content[/message_box]<br /><br />');
                                }
                             else if(v == 'table'){
                                        tinyMCE.activeEditor.selection.setContent('[table color="#Color_Code"]<br />\
                                                [thead]<br />\
                                                  [tr]<br />\
                                                    [th]Column 1[/th]<br />\
                                                    [th]Column 2[/th]<br />\
                                                    [th]Column 3[/th]<br />\
                                                    [th]Column 4[/th]<br />\
                                                  [/tr]<br />\
                                                [/thead]<br />\
                                                [tbody]<br />\
                                                  [tr]<br />\
                                                    [td]Item 1[/td]<br />\
                                                    [td]Item 2[/td]<br />\
                                                    [td]Item 3[/td]<br />\
                                                    [td]Item 4[/td]<br />\
                                                  [/tr]<br />\
                                                  [tr]<br />\
                                                    [td]Item 11[/td]<br />\
                                                    [td]Item 22[/td]<br />\
                                                    [td]Item 33[/td]<br />\
                                                    [td]Item 44[/td]<br />\
                                                  [/tr]<br />\
                                                [/tbody]<br />\
                                         [/table]<br /><br />');
                                }
                             else if(v == 'heading'){
                                        tinyMCE.activeEditor.selection.setContent('[heading size="1" color="#fff000"]Heading Text[/heading]<br /><br />');
                                }
                             else if(v == 'contact'){
                                        tinyMCE.activeEditor.selection.setContent('[contact link="#" target="_blank" icon="fa-star" title="Booking" desc="111-222-333" ]<br /><br />');
                                }
                             else if(v == 'map'){
                                        tinyMCE.activeEditor.selection.setContent('[map height="200" latitude="51.511214" longitude="-0.119824" zoom="11" type="ROADMAP" info_text="" info_width="" info_height="" marker_icon_url="" marker="true" disable_controls="false" draggable="true" scrollwheel="true"][/map]<br /><br />');
                                }
                             else if(v == 'video'){
                                        tinyMCE.activeEditor.selection.setContent('[video-item url="" width="400" height="250"][/video-item]<br /><br />');
                                }
                              else if(v == 'icon'){
                                        tinyMCE.activeEditor.selection.setContent('[icon class="fa-twitter" type="rounded" size="fa-4x" border="no" bgcolor="#000" color="#ff0000"][/icon]<br /><br />');
                                }
                             else if(v == 'testimonials'){
                                        tinyMCE.activeEditor.selection.setContent('[testimonials type="v1" ]<br />\
                                        [testimonial_item job="Designer" image="image-url" name="John Deo" testimonial="testimonial"]Content 1[/testimonial_item]<br />\
                                        [testimonial_item job="Designer" image="image-url" name="John Deo" testimonial="testimonial"]Content 2[/testimonial_item]<br />\
                                        [testimonial_item job="Designer" image="image-url" name="John Deo" testimonial="testimonial"]Content 3[/testimonial_item]<br />\
                                        [/testimonials]<br /><br />');
                             }
                              else if(v == 'services'){
                                        tinyMCE.activeEditor.selection.setContent('[services]<br />\
                                        [service-item icon="fa-star" title="Service Title 1" link="service_url"]<br />\
                                        [content]Service Detail[/content]<br />\
                                        [/service-item]<br />\
                                        [service-item icon="fa-cog" title="Service Title 2" link="service_url"]<br />\
                                        [content]Service Detail[/content]<br />\
                                        [/service-item]<br />\
                                        [/services]<br /><br />');
                             }
                             else if(v == 'team'){
                                        tinyMCE.activeEditor.selection.setContent('[team-sec style="team-v1"]<br />\
                                        [team name="JOHN DOE" job="CEO" email="abc@example.com" image=""]<br />\
                                        [content]Team content 1[/content]<br />\
                                        [social_links]<br />\
                                        [social link="#" target="_blank" icon="fa-facebook-square" tabs="tabs"]<br />\
                                        [social link="#" target="_blank" icon="fa-twitter-square" tabs="tabs"]<br />\
                                        [/social_links]<br />\
                                        [/team]<br />\
                                        [team name="JOHN DOE" job="CEO" image=""]<br />\
                                        [content]Team content 2[/content]<br />\
                                        [social_links]<br />\
                                        [social link="#" target="_blank" icon="fa-facebook-square" tabs="tabs"]<br />\
                                        [social link="#" target="_blank" icon="fa-twitter-square" tabs="tabs"]<br />\
                                        [/social_links]<br />\
                                        [/team]<br />\
                                        [/team-sec]<br /><br />');
                             }
                             
                     }
                });
                // Add Elements for DropDown
                	mlb.add('accordion','accordion');
                    mlb.add('button','button');
                    mlb.add('contact','contact');
                    mlb.add('column','column');
                	mlb.add('dropcap','dropcap');
                	mlb.add('heading','heading');
                    mlb.add('message_box','message_box');
                    mlb.add('map','map');
                    mlb.add('quote','quote');
                    mlb.add('services','services');
                    mlb.add('testimonials','testimonials');
                    mlb.add('team','team');
                    mlb.add('toogle','toogle');
                    mlb.add('icon','icon');
                	mlb.add('tabs','tabs');
                	mlb.add('table','table');
                	mlb.add('video','video');
                	
                // Return the new listbox instance
                return mlb;
             }
             return null;
		},
	});
	// Register plugin
	tinymce.PluginManager.add('<?php echo $shortcodesES->buttonName; ?>', tinymce.plugins.<?php echo $shortcodesES->buttonName; ?>);
})();
