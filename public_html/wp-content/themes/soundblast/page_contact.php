<?php global $cs_node,$counter_node,$cs_theme_option ; 
cs_enqueue_validation_script();
?>
	<script type="text/javascript">
        jQuery().ready(function($) {
            var container = $('');
            var validator = jQuery("#frm<?php echo $counter_node?>").validate({
                messages:{
                	contact_name: '',
                	contact_email:{
                		required: '',
                    	email:'',
                	},
                    subject: {
                        required:'',
                    },
                	contact_msg: '',
       	        },
                errorContainer: container,
                errorLabelContainer: jQuery(container),
                errorElement:'div',
                errorClass:'frm_error',
                meta: "validate"
            });
        });
        function frm_submit<?php echo $counter_node?>(){
            var $ = jQuery;
            $("#submit_btn<?php echo $counter_node?>").hide();
            $("#loading_div<?php echo $counter_node?>").html('<i class="fa fa-spinner fa-spin"></i>');
            $.ajax({
                type:'POST', 
                url: '<?php echo get_template_directory_uri()?>/page_contact_submit.php',
                data:$('#frm<?php echo $counter_node?>').serialize(), 
                success: function(response) {
                    //$('#frm').get(0).reset();
                    $("#loading_div<?php echo $counter_node?>").html('');
                    $("#form_hide<?php echo $counter_node?>").hide();
                    $("#succ_mess<?php echo $counter_node?>").show('');
                    $("#succ_mess<?php echo $counter_node?>").html(response);
                    //$('#frm_slide').find('.form_result').html(response);
                }
            });
        }
    </script>
    <div class="element_size_<?php echo $cs_node->contact_element_size; ?>">
        <div id="respond">
        	<div class="comment-respond">
                <div class="textsection">
                   <div class="succ_mess" id="succ_mess<?php echo $counter_node?>" style="display:none;"></div>
                </div>
                <div id="form_hide<?php echo $counter_node;?>">
                    <header class="cs-heading-title"><h2 class="comment-reply-title cs-section-title cs-heading-color uppercase"><?php if($cs_theme_option['trans_switcher']== "on"){ _e('Send us a Quick Message','Soundblast');}else{ echo $cs_theme_option['trans_form_title'];}?></h2></header>
                    
                    <form id="frm<?php echo $counter_node ?>" name="frm<?php echo $counter_node ?>" method="post" action="javascript:<?php echo "frm_submit".$counter_node. "()";
                ?>" novalidate>  
                                   
                    <p class="comment-form-author">
                        <label class="fa fa-user"></label>

                        <input type="text" name="contact_name" id="contact_name" class="nameinput {validate:{required:true}}" placeholder="<?php _e('Name', 'Soundblast'); ?>"  value="" /><strong><?php _e('(Required)', 'Soundblast'); ?></strong>
                    </p>
                    <p class="comment-form-email">
                        <label class="fa fa-envelope"></label>
                        <input type="text" name="contact_email" id="contact_email" placeholder="<?php _e('Email', 'Soundblast'); ?>" class="emailinput {validate:{required:true ,email:true}}" value="" /><strong><?php _e('(Required)', 'Soundblast'); ?></strong>
                         
                    </p>
                    <p class="comment-form-subject">
                       <label class="fa fa-align-left"></label>
                       <input type="text" name="subject" id="subject" placeholder="<?php if($cs_theme_option['trans_switcher']== "on"){ _e('Subject','Soundblast');}else{ echo $cs_theme_option['trans_subject']; } ?>" class="subjectinput {validate:{required:true}}"   value="" /><strong><?php _e('(Required)', 'Soundblast'); ?></strong>
                    </p>
                    <p class="comment-form-comment">
                        <label></label>
                        <textarea name="contact_msg" id="contact_msg" class="{validate:{required:true}}" /><?php if($cs_theme_option['trans_switcher']== "on"){ _e('Message','Soundblast');}else{echo $cs_theme_option['trans_message']; } ?></textarea>
                        
                    </p>
                        
                        <p class="form-submit">
                            <input type="hidden" value="<?php echo $cs_node->cs_contact_email ?>" name="cs_contact_email">
                            <input type="hidden" value="<?php echo $cs_node->cs_contact_succ_msg ?>" name="cs_contact_succ_msg">
                            <input type="hidden" name="bloginfo" value="<?php echo get_bloginfo() ?>" />
                            <input type="hidden" name="counter_node" value="<?php echo $counter_node ?>" />
                            <input  id="submit_btn<?php echo $counter_node ?>" type="submit" value="<?php _e('Submit', 'Soundblast'); ?>" name="<?php echo $counter_node ?>"><span>*<?php if($cs_theme_option['trans_switcher']== "on"){ _e('Your Email will never published.','Soundblast');}else{echo $cs_theme_option['trans_form_email_published']; } ?></span>
                            <div id="loading_div<?php echo $counter_node ?>"></div>
                        </p>
                    </form>
                </div>
            </div>
         </div>
    </div>