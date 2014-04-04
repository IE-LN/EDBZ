<?php
function theme_option() {
	global $post;
	$g_fonts = cs_get_google_fonts();
	$cs_theme_option = get_option('cs_theme_option');
	                         	
                                          
?>
<link href="<?php echo get_template_directory_uri()?>/css/admin/datePicker.css" rel="stylesheet" type="text/css" />
<form id="frm" method="post" action="javascript:cs_theme_option_save('<?php echo home_url()?>', '<?php echo get_template_directory_uri()?>');">
  <div class="theme-wrap fullwidth">
    <div class="loading_div"></div>
    <div class="form-msg"></div>
    <div class="inner">
      <div class="row"> 
        <!-- Left Column Start -->
        <div class="col1">
          <div class="logo"><a href="#"><img src="<?php echo get_template_directory_uri()?>/images/admin/logo.png" /></a></div>
          <div class="arrowlistmenu" id="paginate-slider2">
            <h3 class="menuheader expandable"><a href="#"><span class="nav-icon g-setting">&nbsp;</span>General Settings</a></h3>
            <ul class="categoryitems">
              <li class="tab-color active"><a href="#tab-color" onClick="toggleDiv(this.hash);return false;">Color and Style</a></li>
              <li class="tab-logo"><a href="#tab-logo" onClick="toggleDiv(this.hash);return false;">Logo / Fav Icon</a></li>
              <li class="tab-head-scripts"><a href="#tab-head-scripts" onClick="toggleDiv(this.hash);return false;">Header Settings</a></li>
              <li class="tab-foot-setting"><a href="#tab-foot-setting" onClick="toggleDiv(this.hash);return false;">Footer Settings</a></li>
              <li class="tab-under-consturction"><a href="#tab-under-consturction" onClick="toggleDiv(this.hash);return false;">Under Constrution</a></li>
              <li class="tab-other"><a href="#tab-other" onClick="toggleDiv(this.hash);return false;">Other Settings</a></li>
              <li class="tab-mailchimp-key"><a href="#tab-mailchimp-key" onClick="toggleDiv(this.hash);return false;">MailChimp Settings</a></li>
              <li class="tab-api-key"><a href="#tab-api-key" onClick="toggleDiv(this.hash);return false;">API Settings</a></li>
            </ul>
            <h3 class="menuheader expandable"><a href="#"><span class="nav-icon h-setting">&nbsp;</span>Home Page Settings</a></h3>
            <ul class="categoryitems">
              <li class="tab-slider"><a href="#tab-slider" onClick="toggleDiv(this.hash);return false;">Home Page Slider</a></li>
              <li class="tab-player"><a href="#tab-player" onClick="toggleDiv(this.hash);return false;">Home Page Player</a></li>
              <li class="tab-partner"><a href="#tab-partner" onClick="toggleDiv(this.hash);return false;">Home Page Partners</a></li>
            </ul>
            <h3 class="menuheader expandable"><a href="#"><span class="nav-icon side-bar">&nbsp;</span>Side Bars</a></h3>
            <ul class="categoryitems">
              <li class="tab-manage-sidebars"><a href="#tab-manage-sidebars" onClick="toggleDiv(this.hash);return false;">Manage Sidebars</a></li>
            </ul>
            <h3 class="menuheader expandable"><a href="#"><span class="nav-icon slider-setting">&nbsp;</span>Slider Setting</a></h3>
            <ul class="categoryitems">
              <li class="tab-flex-slider"><a href="#tab-flex-slider" onClick="toggleDiv(this.hash);return false;">Flex Slider</a></li>
            </ul>
            <h3 class="menuheader expandable"><a href="#"><span class="nav-icon s-network">&nbsp;</span>Social Settings</a></h3>
            <ul class="categoryitems">
              <li class="tab-social-network"><a href="#tab-social-network" onClick="toggleDiv(this.hash);return false;">Social Network</a></li>
              <li class="tab-social-sharing"><a href="#tab-social-sharing" onClick="toggleDiv(this.hash);return false;">Social Sharing</a></li>
            </ul>
            <h3 class="menuheader expandable"><a href="#"><span class="nav-icon languages">&nbsp;</span>Language</a></h3>
            <ul class="categoryitems">
              <li class="tab-upload-languages"><a href="#tab-upload-languages" onClick="toggleDiv(this.hash);return false;">Upload New Languages</a></li>
            </ul>
            <h3 class="menuheader expandable"><a href="#"><span class="nav-icon translation">&nbsp;</span>Translation</a></h3>
            <ul class="categoryitems">
              <li class="tab-album-translation"><a href="#tab-album-translation" onClick="toggleDiv(this.hash);return false;">Albums</a></li>
              <li class="tab-event-translation"><a href="#tab-event-translation" onClick="toggleDiv(this.hash);return false;">Events</a></li>
              <li class="tab-contact-translation"><a href="#tab-contact-translation" onClick="toggleDiv(this.hash);return false;">Contact</a></li>
              <li class="tab-other-translation"><a href="#tab-other-translation" onClick="toggleDiv(this.hash);return false;">Others</a></li>
            </ul>
            <h3 class="menuheader expandable"><a href="#"><span class="nav-icon default-pages">&nbsp;</span>Default Pages</a></h3>
            <ul class="categoryitems">
              <li class="tab-default-pages"><a href="#tab-default-pages" onClick="toggleDiv(this.hash);return false;">Default Pages</a></li>
            </ul>
            <h3 class="menuheader expandable"><a href="#"><span class="nav-icon default-pages">&nbsp;</span>Backup Options</a></h3>
            <ul class="categoryitems">
              <li class="tab-import-export"><a href="#tab-import-export" onClick="toggleDiv(this.hash);return false;">Theme Options Backup and restore settings</a></li>
            </ul>
          </div>
          <div class="clear"></div>
        </div>
        <!-- Left Column End -->
        <div class="col2">
         <input type="button" value="Reset Option" class="top_btn_reset" onclick="cs_to_restore_default('<?php echo home_url()?>', '<?php echo get_template_directory_uri()?>')" />
          <input type="submit" id="submit_btn" name="submit_btn" class="top_btn_save" value="Save All Settings" />
          <!-- Color And Style Start -->
          <div id="tab-color">
            <div class="theme-header">
              <h1>General Settings</h1>
            </div>
            <div class="theme-help">
              <h4>Color And Styles</h4>
              <p>Theme color scheme and styling setting.</p>
            </div>
            <ul class="form-elements">
              <li class="to-label">
                <label>Custom Color Scheme</label>
              </li>
              <li class="to-field">
                <input type="text" name="custom_color_scheme" value="<?php echo $cs_theme_option['custom_color_scheme']?>" class="bg_color" />
                <p>Pick a custom color for Scheme of the theme e.g. #697e09</p>
              </li>
            </ul>
            <ul class="form-elements" style="display:none;">
              <li class="to-label">
                <label>Heading Color Scheme</label>
              </li>
              <li>
                <input type="text" name="heading_color_scheme" value="<?php echo $cs_theme_option['heading_color_scheme']?>" class="bg_color" />
                <p>Pick a custom color for Scheme of the headings e.g. #333</p>
              </li>
            </ul>
            <ul class="form-elements">
              <li class="to-label">
                <label>Layout Option</label>
              </li>
              <li class="to-field">
                <input type="radio" name="layout_option" value="wrapper_boxed" <?php if($cs_theme_option['layout_option']=="wrapper_boxed")echo "checked"?> class="styled" />
                <label>Boxed</label>
                <input type="radio" name="layout_option" value="wrapper" <?php if($cs_theme_option['layout_option']=="wrapper")echo "checked"?> class="styled" />
                <label>Wide</label>
              </li>
            </ul>
            <div class="opt-head">
              <h4>Layout Options</h4>
              <div class="clear"></div>
            </div>
            
            <ul class="form-elements">
              <li class="to-label">
                <label>Color Option</label>
              </li>
              <li class="to-field">
                <input type="radio" name="color_option" value="black" <?php if($cs_theme_option['color_option']=="black")echo "checked"?> class="styled" />
                <label>Dark</label>
                <input type="radio" name="color_option" value="white" <?php if($cs_theme_option['color_option']=="white")echo "checked"?> class="styled" />
                <label>Light</label>
              </li>
            </ul>
            <ul class="form-elements">
              <li class="to-label">
                <label>Background Image</label>
              </li>
              <li class="to-field">
                <div class="meta-input pattern">
                  <?php
										for ( $i = 0; $i < 9; $i++ ) {
										?>
                  <div class='radio-image-wrapper'>
                    <input <?php if($cs_theme_option['bg_img']==$i)echo "checked"?> onclick="select_bg()" type="radio" name="bg_img" class="radio" value="<?php echo $i?>" />
                    <label for="radio_<?php echo $i?>"> <span class="ss"><img src="<?php echo get_template_directory_uri()?>/images/background/background<?php echo $i?>.png" /></span> <span <?php if($cs_theme_option['bg_img']==$i)echo "class='check-list'"?> id="check-list">&nbsp;</span> </label>
                  </div>
                  <?php }?>
                </div>
              </li>
              <li class="full">&nbsp;</li>
              <li class="to-label">
                <label>Background Image</label>
              </li>
              <li class="to-field">
                <input id="bg_img_custom" name="bg_img_custom" value="<?php echo $cs_theme_option['bg_img_custom'] ?>" type="text" class="small" />
                <input id="bg_img_custom" name="bg_img_custom" type="button" class="uploadfile left" value="Browse"/>
                <?php if ( $cs_theme_option['bg_img_custom'] <> "" ) { ?>
                <div class="thumb-preview" id="bg_img_custom_img_div"> <img src="<?php echo $cs_theme_option['bg_img_custom']?>" /> <a href="javascript:remove_image('bg_img_custom')" class="del">&nbsp;</a> </div>
                <?php } ?>
              </li>
              <li class="full">&nbsp;</li>
              <li class="to-label">
                <label>Position</label>
              </li>
              <li class="to-field">
                <input type="radio" name="bg_position" value="left" <?php if($cs_theme_option['bg_position']=="left")echo "checked"?> class="styled" />
                <label>Left</label>
                <input type="radio" name="bg_position" value="center" <?php if($cs_theme_option['bg_position']=="center")echo "checked"?> class="styled" />
                <label>Center</label>
                <input type="radio" name="bg_position" value="right" <?php if($cs_theme_option['bg_position']=="right")echo "checked"?> class="styled" />
                <label>Right</label>
              </li>
              <li class="full">&nbsp;</li>
              <li class="to-label">
                <label>Repeat</label>
              </li>
              <li class="to-field">
                <input type="radio" name="bg_repeat" value="no-repeat" <?php if($cs_theme_option['bg_repeat']=="no-repeat")echo "checked"?> class="styled" />
                <label>No Repeat</label>
                <input type="radio" name="bg_repeat" value="repeat" <?php if($cs_theme_option['bg_repeat']=="repeat")echo "checked"?> class="styled" />
                <label>Tile</label>
                <input type="radio" name="bg_repeat" value="repeat-x" <?php if($cs_theme_option['bg_repeat']=="repeat-x")echo "checked"?> class="styled" />
                <label>Tile Horizontally</label>
                <input type="radio" name="bg_repeat" value="repeat-y" <?php if($cs_theme_option['bg_repeat']=="repeat-y")echo "checked"?> class="styled" />
                <label>Tile Vertically</label>
              </li>
              <li class="full">&nbsp;</li>
              <li class="to-label">
                <label>Attachment</label>
              </li>
              <li class="to-field">
                <input type="radio" name="bg_attach" value="scroll" <?php if($cs_theme_option['bg_attach']=="scroll")echo "checked"?> class="styled" />
                <label>Scroll</label>
                <input type="radio" name="bg_attach" value="fixed" <?php if($cs_theme_option['bg_attach']=="fixed")echo "checked"?> class="styled" />
                <label>Fixed</label>
              </li>
            </ul>
            <ul class="form-elements">
              <li class="to-label">
                <label>Background Pattern</label>
              </li>
              <li class="to-field">
                <div class="meta-input pattern">
                  <?php
										for ( $i = 0; $i < 16; $i++ ) {
										?>
                  <div class='radio-image-wrapper'>
                    <input <?php if($cs_theme_option['pattern_img']==$i)echo "checked"?> onclick="select_pattern()" type="radio" name="pattern_img" class="radio" value="<?php echo $i?>" />
                    <label for="radio_<?php echo $i?>"> <span class="ss"><img src="<?php echo get_template_directory_uri()?>/images/pattern/pattern<?php echo $i?>.png" /></span> <span <?php if($cs_theme_option['pattern_img']==$i)echo "class='check-list'"?> id="check-list">&nbsp;</span> </label>
                  </div>
                  <?php }?>
                </div>
              </li>
              <li class="full">&nbsp;</li>
              <li class="to-label">
                <label>Background Pattern</label>
              </li>
              <li class="to-field">
                <input id="custome_pattern" name="custome_pattern" value="<?php echo $cs_theme_option['custome_pattern']; ?>" type="text" class="small" />
                <input id="custome_pattern" name="custome_pattern" type="button" class="uploadfile left" value="Browse"/>
                <?php if ( $cs_theme_option['custome_pattern'] <> "" ) { ?>
                <div class="thumb-preview" id="custome_pattern_img_div"> <img src="<?php echo $cs_theme_option['custome_pattern'];?>" /> <a href="javascript:remove_image('custome_pattern')" class="del">&nbsp;</a> </div>
                <?php }?>
              </li>
              <li class="full">&nbsp;</li>
              <li class="to-label">
                <label>Background Color</label>
              </li>
              <li>
                <input type="text" name="bg_color" value="<?php echo $cs_theme_option['bg_color']?>" class="bg_color" data-default-color="" />
              </li>
            </ul>
          </div>
          <!-- Color And Style End --> 
          <!-- Logo Tabs -->
					<div id="tab-logo" style="display:none;">
                                    <div class="theme-header"><h1>Logo / Sticky Logo / Fav Icon Settings</h1></div>
                                    <div class="theme-help">
                                        <h4>Logo / Fav Icon Settings</h4><p>Add your logo/sticky logo and fav icon.</p>
                                    </div>
                                        <ul class="form-elements">
                                            <li class="to-label"><label>Upload Logo</label></li>
                                            <li class="to-field">
                                                <input id="logo" name="logo" value="<?php echo $cs_theme_option['logo']?>" type="text" class="small {validate:{accept:'jpg|jpeg|gif|png|bmp'}}" />
                                                <input id="logo" name="logo" type="button" class="uploadfile left" value="Browse"/>
                                                <?php if ( $cs_theme_option['logo'] <> "" ) { ?>
                                                    <div class="thumb-preview" id="main_logo_img_div">
                                                        <img width="<?php echo $cs_theme_option['logo_width']?>" height="<?php echo $cs_theme_option['logo_height']?>" src="<?php echo $cs_theme_option['logo']?>" />
                                                        <a href="javascript:remove_image('logo')" class="del">&nbsp;</a>
                                                    </div>
                                                <?php } ?>
                                                <p>Browse a logo, only jpg|jpeg|gif|png|bmp formats are allowed.</p>
                                            </li>
                                        </ul>
                                        <ul class="form-elements">
                                            <li class="to-label"><label>Width</label></li>
                                            <li class="to-field">
                                                <input type="text" name="logo_width" id="width-value" value="<?php echo $cs_theme_option['logo_width']?>" class="vsmall" />
                                                <span class="short">px</span><p>Please enter the required size.</p>
                                            </li>
                                        </ul>
                                        
                                        <ul class="form-elements">
                                            <li class="to-label"><label>Height</label></li>
                                            <li class="to-field">
                                                <input type="text" name="logo_height" id="height-value" value="<?php echo $cs_theme_option['logo_height']?>" class="vsmall" />
                                                <span class="short">px</span><p>Please enter the required size.</p>
                                            </li>
                                        </ul>
                                        
                                        <ul class="form-elements">
                                            <li class="to-label"><label>FAV Icon</label></li>
                                            <li class="to-field">
                                                <input id="fav_icon" name="fav_icon" value="<?php echo $cs_theme_option['fav_icon']?>" type="text" class="small {validate:{accept:'ico|png'}}" />
                                                <input id="fav_icon" name="fav_icon" type="button" class="uploadfile left" value="Browse" />
                                                <p>Browse a small fav icon, only .ICO or .PNG formats are allowed.</p>
                                            </li>
                                        </ul>
                                </div>
           <!-- Logo Tabs End --> 

          
         <div id="tab-head-scripts" style="display:none;">
            <div class="theme-header">
              <h1>Header Settings</h1>
            </div>
            <div class="theme-help">
              <h4>Header Settings</h4>
              <p>Modify your header settings</p>
            </div>
            <div class="header-section" id="header_banner1">
            <?php 
			   $wpmlsettings=get_option('icl_sitepress_settings');
 
 				if ( function_exists('icl_object_id') ) {
					if(!isset($cs_theme_option['header_languages'])){$cs_theme_option['header_languages'] = 'on';}
   			  ?>
              <ul class="form-elements">
                <li class="full">&nbsp;</li>
                <li class="to-label">
                  <label>Header Languages</label>
                </li>
                <li class="to-field">
                  <input type="hidden" name="header_languages" value="" />
                  <input type="checkbox" class="myClass" name="header_languages" <?php if ($cs_theme_option['header_languages'] == "on") echo "checked" ?> />
                </li>
              </ul>
              <?php } ?>
            <?php if ( function_exists( 'is_woocommerce' ) ){
						if(!isset($cs_theme_option['header_cart'])){$cs_theme_option['header_cart'] = 'on';}
				 ?> 
                <ul class="form-elements">
                    <li class="full">&nbsp;</li>
                    <li class="to-label">
                       <label>Cart Count</label>
                    </li>
                    <li class="to-field">
                      <input type="hidden" name="header_cart" value=""/>
                      <input type="checkbox" class="myClass" name="header_cart" <?php if ($cs_theme_option['header_cart'] == "on") echo "checked" ?>/>
                    </li>
                  </ul>
            <?php } ?>
            </div>
             <ul class="form-elements">
              <li class="to-label">
                <label>Header Code</label>
              </li>
              <li class="to-field">
                <textarea rows="" cols="" name="header_code"><?php echo $cs_theme_option['header_code']?></textarea>
                <p>Paste your Html or Css Code here.</p>
              </li>
            </ul>
          </div>
          <!-- Header Script End --> 
        <!-- Footer Settings -->
        <div id="tab-foot-setting" style="display:none;">
          <div class="theme-header">
            <h1>Footer Settings</h1>
          </div>
          <div class="theme-help">
            <h4>Footer Settings</h4>
            <p>Add footer setting detail.</p>
          </div>
            <ul class="form-elements">
            <li class="to-label">
              <label>Footer Widget</label>
            </li>
            <li class="to-field">
              <input type="hidden" name="footer_widget" value="" />
              <input type="checkbox" class="myClass" name="footer_widget" <?php if($cs_theme_option['footer_widget']=="on") echo "checked" ?> />
              <p>Set show Footer Widget On/Off</p>
            </li>
          </ul>
          
          <ul class="form-elements">
            <li class="to-label">
              <label>Footer Newsletter</label>
            </li>
            <li class="to-field">
              <input type="hidden" name="footer_newsletter" value="" />
              <input type="checkbox" class="myClass" name="footer_newsletter" <?php if($cs_theme_option['footer_newsletter']=="on") echo "checked" ?> />
              <p>Set show Footer Newsletter On/Off</p>
            </li>
          </ul>
          
          <ul class="form-elements">
            <li class="to-label">
              <label>Custom Copyright</label>
            </li>
            <li class="to-field">
              <textarea rows="2" cols="4" name="copyright"><?php echo $cs_theme_option['copyright']?></textarea>
              <p>Write Custom Copyright text.</p>
            </li>
          </ul>
          <ul class="form-elements">
            <li class="to-label">
              <label>Powered By Text</label>
            </li>
            <li class="to-field">
            <textarea rows="2" cols="4" name="powered_by"><?php echo $cs_theme_option['powered_by']?></textarea>
              <p>Please enter powered by text.</p>
            </li>
          </ul>
          
          <ul class="form-elements">
            <li class="to-label">
              <label>HTML, CSS or JS Code</label>
            </li>
            <li class="to-field">
              <textarea rows="" cols="" name="analytics"><?php echo $cs_theme_option['analytics']?></textarea>
              <p>Put any HTML, CSS or JS Code like Google Analytics tracking code here.<br />
                This will be added into the footer template of your theme.</p>
            </li>
          </ul>
        </div>
        <!-- Footer Settings End --> 
        <!-- Maintenance Page Settings start -->
        <div id="tab-under-consturction" style="display:none;">
          <div class="theme-header">
            <h1>Maintenance Page Settings</h1>
          </div>
          <div class="theme-help">
            <h4>Maintenance Page Settings</h4>
            <p>Add maintenance page setting detail.</p>
          </div>
          <ul class="form-elements">
            <li class="to-label">
              <label>Maintenance Page</label>
            </li>
            <li class="to-field">
              <input type="hidden" name="under-construction" value="" />
              <input type="checkbox" class="myClass" name="under-construction" <?php if($cs_theme_option['under-construction']=="on") echo "checked" ?> />
              <p>Set the maintenance page On/Off</p>
            </li>
          </ul>
          <ul class="form-elements">
            <li class="to-label">
              <label>Show Logo</label>
            </li>
            <li class="to-field">
              <input type="hidden" name="showlogo" value="" />
              <input type="checkbox" class="myClass" name="showlogo" <?php if($cs_theme_option['showlogo']=="on") echo "checked" ?> />
              <p>Set show logo On/Off</p>
            </li>
          </ul>
          <ul class="form-elements">
            <li class="to-label">
              <label>Maintenance Text</label>
            </li>
            <li class="to-field">
              <textarea rows="2" cols="4" name="under_construction_text"><?php echo $cs_theme_option['under_construction_text']?></textarea>
              <p>Write Maintenance.</p>
            </li>
          </ul>
          <ul class="form-elements">
            <li class="to-label">
              <label>Launch Date</label>
            </li>
            <li class="to-field">
              <input type="text" id="launch_date" name="launch_date" value="<?php if($cs_theme_option['launch_date'] == ''){ echo gmdate("Y-m-d"); }else{ echo $cs_theme_option['launch_date']; } ?>" />
              <p> Put event start date</p>
            </li>
          </ul>
        </div>
        <!-- Maintenance Page Settings end --> 
        <!-- Other Settings Start -->
        <div id="tab-other" style="display:none;">
          <div class="theme-header">
            <h1>Other Setting</h1>
          </div>
          <div class="theme-help">
            <h4>Other Setting</h4>
            <p>Other Setting</p>
          </div>
          <ul class="form-elements">
            <li class="to-label">
              <label>Responsive</label>
            </li>
            <li class="to-field">
              <input type="hidden" name="responsive" value="" />
              <input type="checkbox" class="myClass" name="responsive" <?php if($cs_theme_option['responsive']=="on") echo "checked" ?> />
              <p>Set the responsive On/Off</p>
            </li>
          </ul>
          <ul class="form-elements">
            <li class="to-label">
              <label>Right to Left (RTL)</label>
            </li>
            <li class="to-field">
              <input type="hidden" name="style_rtl" value="" />
              <input type="checkbox" class="myClass" name="style_rtl" <?php if($cs_theme_option['style_rtl']=="on") echo "checked" ?> />
              <p>Set the theme style "Right to Left (RTL)" </p>
            </li>
          </ul>
          <ul class="form-elements">
            <li class="to-label">
              <label>Color Switcher</label>
            </li>
            <li class="to-field">
              <input type="hidden" name="color_switcher" value="" />
              <input type="checkbox" class="myClass" name="color_switcher" <?php if($cs_theme_option['color_switcher']=="on") echo "checked" ?> />
              <p>Set the color switcher for user demo</p>
            </li>
          </ul>
          <ul class="form-elements">
            <li class="to-label">
              <label>Translation Switcher</label>
            </li>
            <li class="to-field">
              <input type="hidden" name="trans_switcher" value="" />
              <input type="checkbox" class="myClass" name="trans_switcher" <?php if($cs_theme_option['trans_switcher']=="on") echo "checked" ?> />
              <p>Set the translation switcher for user demo</p>
            </li>
          </ul>
          
        </div>
        <!-- Other Settings End -->
        <div id="tab-mailchimp-key" style="display:none;">
            <div class="theme-header">
              <h1>MailChimp Setting</h1>
            </div>
            <div class="theme-help">
              <h4>MailChimp Setting</h4>
              <p>MailChimp Setting</p>
            </div>
            <div class="opt-head">
              <h4>MailChimp Setting</h4>
              <div class="clear"></div>
            </div>
            <ul class="form-elements">
              <li class="to-label">
                <label>MailChimp Key</label>
              </li>
              <li class="to-field">
              <?php if(!isset($cs_theme_option['mailchimp_key'])){$cs_theme_option['mailchimp_key']='';}?>
                <input type="text" id="mailchimp_key" name="mailchimp_key" value="<?php  echo $cs_theme_option['mailchimp_key'];  ?>" />
                <p><?php echo __('Enter a valid MailChimp API key here to get started. Once you\'ve done that, you can use the MailChimp Widget from the Widgets menu. You will need to have at least MailChimp list set up before the using the widget.', 'mailchimp-widget'). __(' You can get your mailchimp activation key', 'Soundblast') . ' <u><a href="' . get_admin_url() . 'https://login.mailchimp.com/">' . __('here', 'Soundblast') . '</a></u>' ?> 				
			</p>
              </li>
            </ul>
          </div> 
        <!-- API Settings Start -->
        <div id="tab-api-key" style="display:none;">
          <div class="theme-header">
            <h1>API Setting</h1>
          </div>
          <div class="theme-help">
            <h4>Twitter API Setting</h4>
            <p>Twitter API Setting</p>
          </div>
          <div class="opt-head">
            <h4>Twitter API Setting</h4>
            <div class="clear"></div>
          </div>
           <ul class="form-elements">
            <li class="to-label">
              <label>Consumer Key</label>
            </li>
            <li class="to-field">
              <input type="hidden" name="consumer_key" value="" />
              <input type="text" id="consumer_key" name="consumer_key" value="<?php  echo $cs_theme_option['consumer_key'];  ?>"  class="{validate:{required:true}}"/>
            </li>
          </ul>
          <ul class="form-elements">
            <li class="to-label">
              <label>Consumer Secret</label>
            </li>
            <li class="to-field">
              <input type="hidden" name="consumer_secret" value="" />
              <input type="text" id="consumer_secret" name="consumer_secret" value="<?php echo $cs_theme_option['consumer_secret']; ?>" class="{validate:{required:true}}"/>
            </li>
          </ul>
          <ul class="form-elements">
            <li class="to-label">
              <label>Access Token</label>
            </li>
            <li class="to-field">
              <input type="hidden" name="access_token" value="" />
              <input type="text" id="access_token" name="access_token" value="<?php echo $cs_theme_option['access_token']; ?>" class="{validate:{required:true}}"/>
            </li>
          </ul>
          <ul class="form-elements">
            <li class="to-label">
              <label>Access Token Secret</label>
            </li>
            <li class="to-field">
              <input type="hidden" name="access_token_secret" value="" />
              <input type="text" id="access_token_secret" name="access_token_secret" value="<?php echo $cs_theme_option['access_token_secret']; ?>" class="{validate:{required:true}}"/>
            </li>
          </ul>
           <input type="hidden" id="submit_btn" name="twitter_setting" class="botbtn" value="Generate Bearer Token"  />
        </div>
        <!-- API Settings end -->
        <div id="tab-slider" style="display:none;">
          <div class="theme-header">
            <h1>Home Page Slider</h1>
          </div>
          <div class="theme-help">
            <h4>Home Page Slider</h4>
            <p>Edit home page slider settings</p>
          </div>
          <ul class="form-elements">
            <li class="to-label">
              <label>Show Slider</label>
            </li>
            <li class="to-field">
              <input type="hidden" name="show_slider" value="" />
              <input type="checkbox" class="myClass" name="show_slider" <?php if($cs_theme_option['show_slider']=="on") echo "checked" ?> />
              <p>Switch it on if you want to show slider at home page. If you switch it off it will not show slider at home page</p>
            </li>
          </ul>
          <input type="hidden" value="Flex Slider" name="slider_type" />
          
          <ul class="form-elements" id="other_sliders">
            <li class="to-label">
              <label>Select Slider</label>
            </li>
            <li class="to-field">
              <select name="slider_name" class="dropdown">
                <option value="">-- Select Slider --</option>
                <?php
                                                    query_posts("posts_per_page=-1&post_type=cs_slider");
                                                    while ( have_posts()) : the_post();
                                                ?>
                <option <?php if($post->post_name==$cs_theme_option['slider_name'])echo "selected";?> value="<?php echo $post->post_name; ?>">
                <?php the_title()?>
                </option>
                <?php
                                                    endwhile;
                                                ?>
              </select>
              <p>Slider images resolution should be (1080 x 468). Create new Slider from <a style="color:#06F; text-decoration:underline;" href="<?php echo get_site_url(); ?>/wp-admin/post-new.php?post_type=cs_slider">here</a></p>
            </li>
          </ul>
          <ul class="form-elements">
              <li class="to-label">
                <label>Select View</label>
              </li>
              <li class="to-field">
                <select name="cs_slider_view" class="dropdown">
                  <option value="cs-background-view" <?php if($cs_theme_option['cs_slider_view'] == "cs-background-view"){echo "selected='selected'"; } ?>>Background</option>
                  <option value="cs-header-view" <?php if($cs_theme_option['cs_slider_view'] == "cs-header-view"){echo "selected='selected'"; } ?>>Header</option>
                </select>
              </li>
            </ul>
          
        </div>
        <div id="tab-player" style="display:none;">
          <div class="theme-header">
            <h1>Home Page Player</h1>
          </div>
          <div class="theme-help">
            <h4>Home Page Player</h4>
            <p>Edit home page Player settings</p>
          </div>
          <ul class="form-elements">
            <li class="to-label">
              <label>Show Player</label>
            </li>
            <li class="to-field">
              <input type="hidden" name="show_player" value="" />
              <input type="checkbox" class="myClass" name="show_player" <?php if($cs_theme_option['show_player']=="on") echo "checked" ?> />
              <p>Switch it on if you want to show Player at home page. If you switch it off it will not show Player at home page</p>
            </li>
          </ul>
          
          <ul class="form-elements" id="other_sliders">
            <li class="to-label">
              <label>Select Album</label>
            </li>
            <li class="to-field">
              <select name="album_name" class="dropdown">
                <option value="">-- Select Album --</option>
                <?php
                                                    query_posts("posts_per_page=-1&post_type=albums");
                                                    while ( have_posts()) : the_post();
                                                ?>
                <option <?php if($post->post_name==$cs_theme_option['album_name'])echo "selected";?> value="<?php echo $post->post_name; ?>">
                <?php the_title()?>
                </option>
                <?php
                                                    endwhile;
                                                ?>
              </select>
            </li>
          </ul>
        </div>
        <div id="tab-partner" style="display:none;">
          <div class="theme-header">
            <h1>Home Page Patners</h1>
          </div>
          <div class="theme-help">
            <h4>Home Page Patners</h4>
            <p>Edit home page Patners settings</p>
          </div>
          <ul class="form-elements">
            <li class="to-label">
              <label>Show Patners</label>
            </li>
            <li class="to-field">
              <input type="hidden" name="show_partners" value="" />
              <input type="checkbox" class="myClass" name="show_partners" <?php if($cs_theme_option['show_partners']=="on") echo "checked" ?> />
              <p>Switch it on if you want to show partner at home page. If you switch it off it will not show partner at home page</p>
            </li>
          </ul>
          <ul class="form-elements">
            <li class="to-label">
              <label>Partner Title:</label>
            </li>
            <li class="to-field">
              <input type="text"  name="partner_gallery_title" value="<?php echo $cs_theme_option['partner_gallery_title']; ?>">
            </li>
          </ul>
          <ul class="form-elements" id="other_sliders">
            <li class="to-label">
              <label>Select Slider</label>
            </li>
            <li class="to-field">
              <select name="partner_gallery_name" class="dropdown">
                <option value="">-- Select Partner Gallery --</option>
                <?php
                                                    query_posts("posts_per_page=-1&post_type=cs_gallery");
                                                    while ( have_posts()) : the_post();
                                                ?>
                <option <?php if($post->post_name==$cs_theme_option['partner_gallery_name'])echo "selected";?> value="<?php echo $post->post_name; ?>">
                <?php the_title()?>
                </option>
                <?php
                                                    endwhile;
                                                ?>
              </select>
            </li>
          </ul>
        </div>
        <div id="tab-manage-sidebars" style="display:none;">
          <div class="theme-header">
            <h1>Manage Sidebars</h1>
          </div>
          <div class="theme-help">
            <h4>Manage Sidebars</h4>
            <p>Manage Sidebars</p>
          </div>
          <ul class="form-elements">
            <li class="to-label">
              <label>Sidebar Name</label>
            </li>
            <li class="to-field">
              <input class="small" type="text" name="sidebar_input" id="sidebar_input" style="width:420px;" />
              <input type="button" value="Add Sidebar" onclick="javascript:add_sidebar()" />
              <p>Please enter the desired title of sidebar.</p>
            </li>
          </ul>
          <div class="opt-head">
            <h4>Already Added Sidebars</h4>
            <div class="clear"></div>
          </div>
          <div class="boxes">
            <table class="to-table" border="0" cellspacing="0">
              <thead>
                <tr>
                  <th>Sider Bar Name</th>
                  <th class="centr">Actions</th>
                </tr>
              </thead>
              <tbody id="sidebar_area">
                <?php
													if ( isset($cs_theme_option['sidebar']) and count($cs_theme_option['sidebar']) > 0 ) {
														$counter_sidebar = rand(10000,20000);
														foreach ( $cs_theme_option['sidebar'] as $sidebar ){
															$counter_sidebar++;
															echo '<tr id="'.$counter_sidebar.'">';
																echo '<td><input type="hidden" name="sidebar[]" value="'.$sidebar.'" />'.$sidebar.'</td>';
																echo '<td class="centr"> <a onclick="javascript:return confirm(\'Are you sure! You want to delete this\')" href="javascript:cs_div_remove('.$counter_sidebar.')">Del</a> </td>';
															echo '</tr>';
														}
													}
													?>
              </tbody>
            </table>
          </div>
        </div>
        
        <div id="tab-flex-slider" style="display:none;">
          <div class="theme-header">
            <h1>Flex Slider</h1>
          </div>
          <div class="theme-help">
            <h4>Flex Slider Options</h4>
            <p>Configure Flex Slider setting</p>
          </div>
          <ul class="form-elements">
            <li class="to-label">
              <label>Effects</label>
            </li>
            <li class="to-field">
              <select class="dropdown" name="flex_effect">
                <option <?php if($cs_theme_option['flex_effect']=="fade"){echo "selected";}?> value="fade" >Fade</option>
                <option <?php if($cs_theme_option['flex_effect']=="slide"){echo "selected";}?> value="slide" >Slide</option>
              </select>
              <p>Please select Effect for flex Slider.</p>
            </li>
          </ul>
          <ul class="form-elements">
            <li class="to-label">
              <label>Auto Play</label>
            </li>
            <li class="to-field">
              <input type="hidden" name="flex_auto_play" value="" />
              <input type="checkbox" name="flex_auto_play" <?php if ( $cs_theme_option['flex_auto_play'] == "on" ){ echo "checked";}?> class="myClass" />
              <p>If true, the slideshow will start running on page load</p>
            </li>
          </ul>
          <ul class="form-elements">
            <li class="to-label">
              <label>Animation Speed</label>
            </li>
            <li class="to-field">
              <input type="text" name="flex_animation_speed" size="5" class="{validate:{required:true}} bar" value="<?php echo $cs_theme_option['flex_animation_speed']?>" />
              <p>How long the slideshow transition takes (in milliseconds)</p>
            </li>
          </ul>
          <ul class="form-elements">
            <li class="to-label">
              <label>Pause Time</label>
            </li>
            <li class="to-field">
              <input type="text" name="flex_pause_time" size="5" class="{validate:{required:true}} bar" value="<?php echo $cs_theme_option['flex_pause_time']?>" />
              <p>Resume slideshow after user interaction (in milliseconds)</p>
            </li>
          </ul>
        </div>
        
        <div id="tab-social-network" style="display:none;">
          <div class="theme-header">
            <h1>Social Settings</h1>
          </div>
          <div class="theme-help">
            <h4>Social Network</h4>
            <p>Edit Social Network</p>
          </div>
          <ul class="form-elements">
            <li class="to-label">
              <label>Section Title</label>
            </li>
            <li class="to-field">
              <input type="text" name="social_net_title" value="<?php echo $cs_theme_option['social_net_title']?>" />
            </li>
          </ul>
          <ul class="form-elements">
            <li class="to-label">
              <label>Icon Path</label>
            </li>
            <li class="to-field">
		      <input id="social_net_icon_path_input" type="text" class="small" onblur="javascript:update_image('social_net_icon_path_input_img_div')" />
              <input id="social_net_icon_path_input" name="social_net_icon_path_input" type="button" class="uploadfile left" value="Browse"/>
            </li>
            <li class="full">&nbsp;</li>
            <li class="to-label">
              <label>Awesome Font</label>
            </li>
            <li class="to-field">
              <input class="small" type="text" id="social_net_awesome_input" style="width:420px;" />
              <p>Put Awesome Font Code like "fa-flag".</p>
            </li>
            <li class="full">&nbsp;</li>
            <li class="to-label">
              <label>URL</label>
            </li>
            <li class="to-field">
              <input class="small" type="text" id="social_net_url_input" style="width:420px;" />
              <p>Please enter full URL.</p>
            </li>
            <li class="full">&nbsp;</li>
            <li class="to-label">
              <label>Title</label>
            </li>
            <li class="to-field">
              <input class="small" type="text" id="social_net_tooltip_input" style="width:420px;" />
              <p>Please enter text for icon tooltip.</p>
            </li>
            <li class="full">&nbsp;</li>
            <li class="to-label"></li>
            <li class="to-field"><input type="button" value="Add" onclick="javascript:cs_add_social_icon('<?php echo home_url()?>')" /></li>
          </ul>
          <div class="opt-head">
            <h4>Already Added Items</h4>
            <div class="clear"></div>
          </div>
          <div class="boxes">
            <table class="to-table" border="0" cellspacing="0">
              <thead>
                <tr>
                  <th>Icon Path</th>
                  <th>URL</th>
                  <th class="centr">Actions</th>
                </tr>
              </thead>
              <tbody id="social_network_area">
                <?php
					if ( isset($cs_theme_option['social_net_url']) and count($cs_theme_option['social_net_url']) > 0 ) {
						wp_enqueue_style('font-awesome_css', get_template_directory_uri() . '/css/font-awesome.css');
						// Register stylesheet
						wp_register_style( 'font-awesome-ie7_css', get_template_directory_uri() . '/css/font-awesome-ie7.css' );
						// Apply IE conditionals
						$GLOBALS['wp_styles']->add_data( 'font-awesome-ie7_css', 'conditional', 'lte IE 9' );
						// Enqueue stylesheet
						wp_enqueue_style( 'font-awesome-ie7_css' );
						$counter_social_network = rand(10000,20000);
						$i = 0;
						foreach ($cs_theme_option['social_net_url'] as $val ){
							$counter_social_network++;
							echo '<tr id="del_'.$counter_social_network.'">';
								if(isset($cs_theme_option['social_net_awesome'][$i]) && $cs_theme_option['social_net_awesome'][$i] <> ''){
									echo '<td width="30%"><i style="color: black;" class="fa '.$cs_theme_option['social_net_awesome'][$i].' fa-2x"></td>';
								} else {
									echo '<td><img width="50" src="'.$cs_theme_option['social_net_icon_path'][$i].'"></td>';
								}
								echo '<td>'.$val.'</td>';
								echo '<td class="centr"> 
											<a onclick="javascript:return confirm(\'Are you sure! You want to delete this\')" href="javascript:social_icon_del('.$counter_social_network.')">Del</a>
											| <a href="javascript:cs_toggle('.$counter_social_network.')">Edit</a>
										</td>';
							echo '</tr>';
							?>
                            	<tr id="<?php echo $counter_social_network;?>" style="display:none">
                                <td colspan="3">
                                    <ul class="form-elements">
                                        <li class="to-label"><label>Icon Path</label></li>
                                        <li class="to-field">
                                          <input id="social_net_icon_path<?php echo $counter_social_network?>" name="social_net_icon_path[]" value="<?php echo $cs_theme_option['social_net_icon_path'][$i]?>" type="text" class="small" />
                                        </li>
                                        <li><a onclick="cs_toggle('<?php echo $counter_social_network?>')"><img src="<?php echo get_template_directory_uri()?>/images/admin/close-red.png" /></a></li>
                                        <li class="full">&nbsp;</li>
                                        <li class="to-label"><label>Awesome Font</label></li>	
                                        <li class="to-field">
                                          <input class="small" type="text" id="social_net_awesome" name="social_net_awesome[]" value="<?php echo $cs_theme_option['social_net_awesome'][$i]?>" style="width:420px;" />
                                          <p>Put Awesome Font Code like "fa-flag".</p>
                                        </li>
                                        <li class="full">&nbsp;</li>
                                        <li class="to-label"><label>URL</label></li>	
                                        <li class="to-field">
                                          <input class="small" type="text" id="social_net_url" name="social_net_url[]" value="<?php echo $val?>" style="width:420px;" />
                                          <p>Please enter full URL.</p>
                                        </li>
                                        <li class="full">&nbsp;</li>
                                        <li class="to-label"><label>Title</label></li>
                                        <li class="to-field">
                                          <input class="small" type="text" id="social_net_tooltip" name="social_net_tooltip[]" value="<?php echo $cs_theme_option['social_net_tooltip'][$i]?>" style="width:420px;" />
                                          <p>Please enter text for icon tooltip.</p>
                                        </li>
                                    </ul>
                                </td>
                                </tr>
							<?php
							$i++;
						}
					}
				?>
              </tbody>
            </table>
          </div>
        </div>
        
        <div id="tab-social-sharing" style="display:none;">
          <div class="theme-header">
            <h1>Social Settings</h1>
          </div>
          <div class="theme-help">
            <h4>Social Network / Sharing</h4>
            <p>Edit Social Network / Sharing</p>
          </div>
          <div class="social-head">
            <ul>
              <li>Social Sharing</li>
            </ul>
          </div>
          <ul class="form-elements">
            <li class="to-label">
              <label>Facebook</label>
            </li>
            <li class="to-field social-share">
              <input type="hidden" name="facebook_share" value="" />
              <input type="checkbox" class="myClass" name="facebook_share" <?php if($cs_theme_option['facebook_share']=="on") echo "checked" ?> />
            </li>
          </ul>
          <ul class="form-elements">
            <li class="to-label">
              <label>Twitter</label>
            </li>
            <li class="to-field social-share">
              <input type="hidden" name="twitter_share" value="" />
              <input type="checkbox" class="myClass" name="twitter_share" <?php if($cs_theme_option['twitter_share']=="on") echo "checked" ?> />
            </li>
          </ul>
          <ul class="form-elements">
            <li class="to-label">
              <label>Linkedin</label>
            </li>
            <li class="to-field social-share">
              <input type="hidden" name="linkedin_share" value="" />
              <input type="checkbox" class="myClass" name="linkedin_share" <?php if($cs_theme_option['linkedin_share']=="on") echo "checked" ?> />
            </li>
          </ul>
          <ul class="form-elements">
            <li class="to-label">
              <label>Pinterest</label>
            </li>
            <li class="to-field social-share">
              <input type="hidden" name="pinterest_share" value="" />
              <input type="checkbox" class="myClass" name="pinterest_share" <?php if($cs_theme_option['pinterest_share']=="on") echo "checked" ?> />
            </li>
          </ul>
          <ul class="form-elements">
            <li class="to-label">
              <label>Tumblr</label>
            </li>
            <li class="to-field social-share">
              <input type="hidden" name="tumblr_share" value="" />
              <input type="checkbox" class="myClass" name="tumblr_share" <?php if($cs_theme_option['tumblr_share']=="on") echo "checked" ?> />
            </li>
          </ul>
          <ul class="form-elements">
            <li class="to-label">
              <label>Google+</label>
            </li>
            <li class="to-field social-share">
              <input type="hidden" name="google_plus_share" value="" />
              <input type="checkbox" class="myClass" name="google_plus_share" <?php if($cs_theme_option['google_plus_share']=="on") echo "checked" ?> />
            </li>
          </ul>
          <ul class="form-elements">
          <li class="to-label">
            <label>Others</label>
          </li>
          <li class="to-field social-share">
            <input type="hidden" name="cs_other_share" value="" />
            <input type="checkbox" class="myClass" name="cs_other_share" <?php if($cs_theme_option['cs_other_share']=="on") echo "checked" ?> />
          </li>
        </ul>
        </div>
        <div id="tab-default-pages" style="display:none;">
          <div class="theme-header">
            <h1>Default Pages</h1>
          </div>
          <div class="theme-help">
            <h4>Default Pages Settings</h4>
            <p>Manage Default Pages (Archive, Search, Categories, Tags and Author Pages)</p>
          </div>
          <ul class="form-elements">
            <li class="to-label">
              <label>Pagination</label>
            </li>
            <li class="to-field">
              <select name="pagination" class="dropdown" onchange="cs_toggle('record_per_page')">
                <option <?php if($cs_theme_option['pagination']=="Show Pagination")echo "selected";?> >Show Pagination</option>
                <option <?php if($cs_theme_option['pagination']=="Single Page")echo "selected";?> >Single Page</option>
              </select>
            </li>
          </ul>
          <?php
			global $cs_xmlObject;
			$cs_xmlObject = new stdClass();
			$cs_xmlObject->sidebar_layout = new stdClass();
			$cs_xmlObject->sidebar_layout->cs_layout = $cs_theme_option['cs_layout'];
			$cs_xmlObject->sidebar_layout->cs_sidebar_left = $cs_theme_option['cs_sidebar_left'];
			$cs_xmlObject->sidebar_layout->cs_sidebar_right = $cs_theme_option['cs_sidebar_right'];
			if ( $cs_theme_option['cs_layout'] == "none" ) {
				$cs_xmlObject->sidebar_layout->cs_sidebar_left = '';
				$cs_xmlObject->sidebar_layout->cs_sidebar_right = '';
			}
			else if ( $cs_theme_option['cs_layout'] == "left" ) {
				$cs_xmlObject->sidebar_layout->cs_sidebar_right = '';
			}
			else if ( $cs_theme_option['cs_layout'] == "right" ) {
				$cs_xmlObject->sidebar_layout->cs_sidebar_left = '';
			}
			cs_meta_layout();
		 ?>
        </div>
        <div id="tab-upload-languages" style="display:none;">
          <div class="theme-header">
            <h1>Upload New Language</h1>
          </div>
          <div class="theme-help">
            <h4>Upload New Language</h4>
            <p>Upload New Language</p>
          </div>
          <ul class="form-elements">
            <li class="to-label">
              <label>Upload Language (MO File)</label>
            </li>
            <li class="to-field">
              <div class="fileinputs">
                <input type="file" class="file" size="78" name="mofile" id="mofile" />
                <div class="fakefile">
                  <input type="text" />
                  <button>Browse</button>
                </div>
              </div>
              <p>Please upload new language file (MO format only). It will be uploaded in your theme's languages folder. </p>
              <p>Download MO files from <a target="_blank" href="http://translate.wordpress.org/projects/wp/">http://translate.wordpress.org/projects/wp/</a> </p>
              <p>
                <button type="button" id="upload_btn">Upload Files!</button>
              </p>
            </li>
          </ul>
          <ul id="image-list">
          </ul>
          <ul class="form-elements">
            <li class="to-label">
              <label>Already Uploaded Languages</label>
            </li>
            <li class="to-field"> <strong>
              <?php
													$counter = 0;
                                                    foreach (glob(get_template_directory()."/languages/*.mo") as $filename) {
														$counter++;
														$val = str_replace(get_template_directory()."/languages/","",$filename);
                                                        echo "<p>".$counter . ". " . str_replace(".mo","",$val)."</p>";
                                                    }
                                                ?>
              </strong>
              <p>Please copy the language name, open config.php file, find WPLANG constant and set its value by replacing the language name. </p>
            </li>
          </ul>
        </div>
        <div id="tab-upload-languages" style="display:none;">
          <div class="theme-header">
            <h1>Manage Languages</h1>
          </div>
          <div class="theme-help">
            <h4>Upload Languages</h4>
            <p>Upload new language.</p>
          </div>
        </div>
				
        <div id="tab-album-translation" style="display:none;">
          <div class="theme-header">
            <h1>Album Translation</h1>
          </div>
          <div class="theme-help">
            <h4>Album Translation</h4>
            <p>Album Translation</p>
          </div>
          <ul class="form-elements">
            <li class="to-label"><label>Tracks</label></li>
            <li class="to-field"><input type="text" name="trans_album_tracks" value="<?php echo $cs_theme_option['trans_album_tracks']?>" /></li>
          </ul>
          <ul class="form-elements">
            <li class="to-label"><label>Buy Now</label></li>
            <li class="to-field"><input type="text" name="trans_album_buynow" value="<?php echo $cs_theme_option['trans_album_buynow']?>" /></li>
          </ul>
		  <ul class="form-elements">
            <li class="to-label"><label>Release Date</label></li>
            <li class="to-field"><input type="text" name="trans_album_release_date" value="<?php echo $cs_theme_option['trans_album_release_date']?>" /></li>
          </ul>
          <ul class="form-elements">
            <li class="to-label"><label>Album Label</label></li>
            <li class="to-field"><input type="text" name="trans_album_label" value="<?php echo $cs_theme_option['trans_album_label']?>" /></li>
          </ul>
          <ul class="form-elements">
            <li class="to-label"><label>Avaialable on</label></li>
            <li class="to-field"><input type="text" name="trans_album_available" value="<?php echo $cs_theme_option['trans_album_available']?>" /></li>
          </ul>
          <ul class="form-elements">
            <li class="to-label"><label>Likes</label></li>
            <li class="to-field"><input type="text" name="trans_album_likes" value="<?php echo $cs_theme_option['trans_album_likes']?>" /></li>
          </ul>
          <ul class="form-elements">
            <li class="to-label"><label>Amazon</label></li>
            <li class="to-field"><input type="text" name="trans_album_amazon" value="<?php echo $cs_theme_option['trans_album_amazon']?>" /></li>
          </ul>
          <ul class="form-elements">
            <li class="to-label"><label>Itunes</label></li>
            <li class="to-field"><input type="text" name="trans_album_itunes" value="<?php echo $cs_theme_option['trans_album_itunes']?>" /></li>
          </ul>
          <ul class="form-elements">
            <li class="to-label"><label>Grooveshark</label></li>
            <li class="to-field"><input type="text" name="trans_album_groove" value="<?php echo $cs_theme_option['trans_album_groove']?>" /></li>
          </ul>
          <ul class="form-elements">
            <li class="to-label"><label>Soundcloud</label></li>
            <li class="to-field"><input type="text" name="trans_album_soundc" value="<?php echo $cs_theme_option['trans_album_soundc']?>" /></li>
          </ul>
        </div>
        
        <div id="tab-event-translation" style="display:none;">
          <div class="theme-header">
            <h1>Events Translation</h1>
          </div>
          <div class="theme-help">
            <h4>Events Translation</h4>
            <p>Events Translation</p>
          </div>
          
          <ul class="form-elements">
            <li class="to-label">
              <label>Event Location</label>
            </li>
            <li class="to-field">
              <input type="text" name="trans_event_location" value="<?php echo $cs_theme_option['trans_event_location']?>" />
            </li>
          </ul>
          
          <ul class="form-elements">
            <li class="to-label">
              <label>Buy Ticket</label>
            </li>
            <li class="to-field">
              <input type="text" name="trans_event_buy_ticket" value="<?php echo $cs_theme_option['trans_event_buy_ticket']?>" />
            </li>
          </ul>
          
          <ul class="form-elements">
            <li class="to-label">
              <label>Free Entry</label>
            </li>
            <li class="to-field">
              <input type="text" name="trans_event_free_entry" value="<?php echo $cs_theme_option['trans_event_free_entry']?>" />
            </li>
          </ul>
          <ul class="form-elements">
            <li class="to-label">
              <label>Sold Out</label>
            </li>
            <li class="to-field">
              <input type="text" name="trans_event_sold_out" value="<?php echo $cs_theme_option['trans_event_sold_out']?>" />
            </li>
          </ul>
          <ul class="form-elements">
            <li class="to-label">
              <label>Cancelled</label>
            </li>
            <li class="to-field">
              <input type="text" name="trans_event_cancelled" value="<?php echo $cs_theme_option['trans_event_cancelled']?>" />
            </li>
          </ul>
		  
		  <ul class="form-elements">
            <li class="to-label">
              <label>Days to go</label>
            </li>
            <li class="to-field">
              <input type="text" name="trans_event_days_to_go" value="<?php echo $cs_theme_option['trans_event_days_to_go']?>" />
            </li>
          </ul>
          
        </div>
        <div id="tab-contact-translation" style="display:none;">
          <div class="theme-header">
            <h1>Contact Translation</h1>
          </div>
          <div class="theme-help">
            <h4>Contact Translation</h4>
            <p>Contact Translation</p>
          </div>
          <ul class="form-elements">
            <li class="to-label">
              <label>Form Title</label>
            </li>
            <li class="to-field">
              <input type="text" name="trans_form_title" value="<?php echo $cs_theme_option['trans_form_title']?>" />
            </li>
          </ul>
          <ul class="form-elements">
            <li class="to-label">
              <label>Subject</label>
            </li>
            <li class="to-field">
              <input type="text" name="trans_subject" value="<?php echo $cs_theme_option['trans_subject']?>" />
            </li>
          </ul>
          
          <ul class="form-elements">
            <li class="to-label">
              <label>Message</label>
            </li>
            <li class="to-field">
              <input type="text" name="trans_message" value="<?php echo $cs_theme_option['trans_message']?>" />
            </li>
          </ul>
          <ul class="form-elements">
            <li class="to-label">
              <label>Email Publish</label>
            </li>
            <li class="to-field">
              <input type="text" name="trans_form_email_published" value="<?php echo $cs_theme_option['trans_form_email_published']?>" />
            </li>
          </ul>
          
        </div>
        
        <div id="tab-other-translation" style="display:none;">
          <div class="theme-header">
            <h1>Other Translation</h1>
          </div>
          <div class="theme-help">
            <h4>Other Translation</h4>
            <p>Other Translation</p>
          </div>
          <ul class="form-elements">
            <li class="to-label">
              <label>404 Content</label>
            </li>
            <li class="to-field">
              <textarea name="trans_content_404"><?php echo $cs_theme_option['trans_content_404']?></textarea>
            </li>
          </ul>
          <ul class="form-elements">
            <li class="to-label">
              <label>Share Now</label>
            </li>
            <li class="to-field">
              <input type="text" name="trans_share_this_post" value="<?php echo $cs_theme_option['trans_share_this_post']?>" />
            </li>
          </ul>
          <ul class="form-elements">
              <li class="to-label">
                <label>Current Page</label>
              </li>
              <li class="to-field">
                <input type="text" name="trans_current_page" value="<?php echo $cs_theme_option['trans_current_page']?>" />
              </li>
            </ul>
		  
		  <ul class="form-elements">
            <li class="to-label">
              <label>Previous</label>
            </li>
            <li class="to-field">
              <input type="text" name="trans_other_prev" value="<?php echo $cs_theme_option['trans_other_prev']?>" />
            </li>
          </ul>
		  
		  <ul class="form-elements">
            <li class="to-label">
              <label>Read More</label>
            </li>
            <li class="to-field">
              <input type="text" name="trans_read_more" value="<?php echo $cs_theme_option['trans_read_more']?>" />
            </li>
          </ul>
          
          <ul class="form-elements">
            <li class="to-label">
              <label>View All</label>
            </li>
            <li class="to-field">
              <input type="text" name="trans_view_all" value="<?php echo $cs_theme_option['trans_view_all']?>" />
            </li>
          </ul>
          
          <ul class="form-elements">
            <li class="to-label">
              <label>Subscribe Weekly Newsletter</label>
            </li>
            <li class="to-field">
              <input type="text" name="trans_other_weekly_newsletter" value="<?php echo $cs_theme_option['trans_other_weekly_newsletter']?>" />
            </li>
          </ul>
		            
        </div>
         <!-- import export Start -->
        <div id="tab-import-export" style="display:none;">
          <div class="theme-header">
            <h1>Theme Options Backup and restore settings</h1>
          </div>
          <div class="theme-help">
            <h4>Theme Options Backup and restore settings</h4>
            <p>Theme Options backup, restore backup, restore default and import / export current settings</p>
          </div>
          
          <ul class="form-elements">
            <li class="to-label">
              <label>Last Backup Taken on</label>
            </li>
            <li class="to-field">
            	<strong><span id="last_backup_taken">
					<?php 
						if ( get_option('cs_theme_option_backup_time') ) {
							echo get_option('cs_theme_option_backup_time');
						}
						else { echo "Not Taken Yet"; }
					?>
                </span></strong>
            </li>
            <li class="full">&nbsp;</li>
            <li class="to-label">
              <label>Take Backup</label>
            </li>
            <li class="to-field">
              <input type="button" value="Take Backup" onclick="cs_to_backup('<?php echo home_url()?>', '<?php echo get_template_directory_uri()?>')" />
              <p>Take the Backup of your current theme options, it will replace the old backup if you have already taken.</p>
            </li>
            <li class="full">&nbsp;</li>
            <li class="to-label">
              <label>Restore Backup</label>
            </li>
            <li class="to-field">
              <input type="button" value="Restore Backup" onclick="cs_to_backup_restore('<?php echo home_url()?>', '<?php echo get_template_directory_uri()?>')" />
              <p>Restore your last backup taken (It will be replaced on your curernt theme options).</p>
            </li>
          </ul>
        </div>
        <!-- import / export end -->
      </div>
      <div class="clear"></div>
      <!-- Right Column End --> 
    </div>
    <div class="footer">
    	<input type="button" value="Reset Option" class="bottom_btn_reset" onclick="cs_to_restore_default('<?php echo home_url()?>', '<?php echo get_template_directory_uri()?>')" />			    	
      	<input type="submit" id="submit_btn" name="submit_btn" class="botbtn" value="Save All Settings" />
      	<input type="hidden" name="action" value="cs_theme_option_save" />
    </div>
  </div>
  </div>
</form>
<script type="text/javascript" src="<?php echo get_template_directory_uri()?>/scripts/admin/select.js"></script> 
<script type="text/javascript" src="<?php echo get_template_directory_uri()?>/scripts/admin/functions.js"></script> 
<script type="text/javascript" src="<?php echo get_template_directory_uri()?>/scripts/admin/jquery.validate.metadata.js"></script> 
<script type="text/javascript" src="<?php echo get_template_directory_uri()?>/scripts/admin/jquery.validate.js"></script> 
<script type="text/javascript" src="<?php echo get_template_directory_uri()?>/scripts/admin/ddaccordion.js"></script> 
<script type="text/javascript" src="<?php echo get_template_directory_uri()?>/scripts/admin/prettyCheckable.js"></script> 
<script type="text/javascript" src="<?php echo get_template_directory_uri()?>/scripts/admin/jquery.timepicker.js"></script>
<link rel="stylesheet" href="<?php echo get_template_directory_uri()?>/css/admin/jquery.ui.datepicker.css">
<link rel="stylesheet" href="<?php echo get_template_directory_uri()?>/css/admin/jquery.ui.datepicker.theme.css">
<script type="text/javascript">
        jQuery(document).ready(function($){
            $('.bg_color').wpColorPicker(); 
        });
    </script> 
<script type="text/javascript">
		jQuery(function($) {
			$( "#launch_date" ).datepicker({
            	defaultDate: "+1w",
				dateFormat: "yy-mm-dd",
                changeMonth: true,
                numberOfMonths: 1,
                onSelect: function( selectedDate ) {
                	$( "#launch_date" ).datepicker( "option", "minDate", selectedDate );
                }
            });
		});
		  function toggleDiv(id)
  {
   jQuery('.col2').children().hide();
   jQuery(id).show();
            location.hash = id+"-show";
            var link = id.replace('#', '');
            jQuery('.categoryitems li').removeClass('active');
            jQuery(".menuheader.expandable") .removeClass('openheader');
            jQuery(".categoryitems").hide();
            jQuery("."+link).addClass('active');
            jQuery("."+link) .parent("ul").show().prev().addClass("openheader");
      
  }
        jQuery(document).ready(function() {
                jQuery(".categoryitems").hide();
                jQuery(".categoryitems:first").show();
                jQuery(".menuheader:first").addClass("openheader");
                jQuery(".menuheader").live('click', function(event) {
                    if (jQuery(this).hasClass('openheader')){
                        jQuery(".menuheader").removeClass("openheader");
                        jQuery(this).next().slideUp(200);
                        return false;
                    }
                    jQuery(".menuheader").removeClass("openheader");
                    jQuery(this).addClass("openheader");
                    jQuery(".categoryitems").slideUp(200);
                    jQuery(this).next().slideDown(200); 
                    return false;
             });
            var hash = window.location.hash.substring(1);
            var id = hash.split("-show")[0];
            if (id){
                jQuery('.col2').children().hide();
                jQuery("#"+id).show();
                jQuery('.categoryitems li').removeClass('active');
                jQuery(".menuheader.expandable") .removeClass('openheader');
                jQuery(".categoryitems").hide();
                jQuery("."+id).addClass('active');
                jQuery("."+id) .parent("ul").slideDown(300).prev().addClass("openheader");

           } 
        });

        var counter_sidebar = 0;
        function add_sidebar(){
            counter_sidebar++;
            var sidebar_input = jQuery("#sidebar_input").val();
            if ( sidebar_input != "" ) {
                jQuery("#sidebar_area").append('<tr id="'+counter_sidebar+'"> \
                            <td><input type="hidden" name="sidebar[]" value="'+sidebar_input+'" />'+sidebar_input+'</td> \
                            <td class="centr"> <a onclick="javascript:return confirm(\'Are you sure! You want to delete this\')" href="javascript:cs_div_remove('+counter_sidebar+')">Del</a> </td> \
                        </tr>');
                jQuery("#sidebar_input").val("");
            }
        }
		jQuery().ready(function($) {
			var container = $('div.container');
			// validate the form when it is submitted
			var validator = $("#frm").validate({
				errorContainer: container,
				errorLabelContainer: $(container),
				errorElement:'span',
				errorClass:'ele-error',				
				meta: "validate"
			});
		});
        jQuery(document).ready( function($) {
            var consoleTimeout;
            $('.minicolors').each( function() {
                $(this).minicolors({
                    change: function(hex, opacity) {
                        // Generate text to show in console
                        text = hex ? hex : 'transparent';
                        if( opacity ) text += ', ' + opacity;
                        text += ' / ' + $(this).minicolors('rgbaString');
                    }
                });
            });
        });
		(function () {
			var input = document.getElementById("mofile")
			var upload_btn = document.getElementById("upload_btn"), 
			formdata = false;
			if (window.FormData) {
				formdata = new FormData();
			}
			upload_btn.addEventListener("click", function (evt) {
				var i = 0, len = input.files.length, txt, reader, file;
			
				for ( ; i < len; i++ ) {
					file = input.files[i];
						if (formdata) {
							formdata.append("mofile[]", file);
						}
				}
				if (formdata) {
					jQuery.ajax({
						url: '<?php echo get_template_directory_uri()?>/include/lang_upload.php',
						type: "POST",
						data: formdata,
						processData: false,
						contentType: false,
						success: function (res) {
							jQuery("#mofile").val("");
		                    jQuery(".form-msg").show();
							jQuery(".form-msg").html(res);
							window.location.reload();
							slideout();
						}
					});
				}
			}, false);
		}());
    </script>
<?php }?>
