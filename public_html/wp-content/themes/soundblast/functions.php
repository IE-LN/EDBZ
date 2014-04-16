<?php
add_action( 'after_setup_theme', 'cs_theme_setup' );
function cs_theme_setup() {

	/* Add theme-supported features. */
	// This theme styles the visual editor with editor-style.css to match the theme style.
	add_editor_style();
	// Make theme available for translation
	// Translations can be filed in the /languages/ directory
 	load_theme_textdomain('Soundblast', get_template_directory() . '/languages');
	
	if (!isset($content_width)){
		$content_width = 1170;
	}
	$args = array(
		'default-color' => '',
		'default-image' => '',
	);
	add_theme_support('custom-background', $args);
	add_theme_support('custom-header', $args);
	// This theme uses post thumbnails
	add_theme_support('post-thumbnails');

	// Add default posts and comments RSS feed links to head
	add_theme_support('automatic-feed-links');
	/* Add custom actions. */
	global $pagenow;

	if (is_admin() && isset($_GET['activated']) && $pagenow == 'themes.php'){
		if(!get_option('cs_theme_option')){
			add_action('admin_head', 'cs_activate_widget');
			add_action('init', 'cs_activation_data');
		}
	}
	if (!session_id()){ 
		add_action('init', 'session_start');
	}
 	add_action( 'init', 'cs_register_my_menus' );
	add_action('admin_enqueue_scripts', 'cs_admin_scripts_enqueue');
	add_action('wp_enqueue_scripts', 'cs_front_scripts_enqueue');
	add_action('pre_get_posts', 'cs_get_search_results');
	/* Add custom filters. */
	add_filter('widget_text', 'do_shortcode');
	add_filter('user_contactmethods','cs_contact_options',10,1);
	add_filter('the_password_form', 'cs_password_form' );
	add_filter('add_to_cart_fragments', 'woocommerce_header_add_to_cart_fragment');
	add_filter('wp_page_menu','cs_add_menuid');
	add_filter('wp_page_menu', 'cs_remove_div' );
	add_filter('nav_menu_css_class', 'cs_add_parent_css', 10, 2);
	add_filter('pre_get_posts', 'cs_change_query_vars');
}
/* adding custom images while uploading media */
	add_image_size('cs_media_1', 1060, 470, true);
 	add_image_size('cs_media_2', 330, 330, true);
	add_image_size('cs_media_3', 230, 172, true);


if (!function_exists('cs_comment')) {
     /**
     * Template for comments and pingbacks.
     *
     * To override this walker in a child theme without modifying the comments template
     * simply create your own PixFill_comment(), and that function will be used instead.
     *
     * Used as a callback by wp_list_comments() for displaying the comments.
     *
     */
	function cs_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	$args['reply_text'] = '<i class="fa fa-mail-reply-all"></i>'.__('Reply', 'Soundblasts');
 	switch ( $comment->comment_type ) :
		case '' :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
        <div class="thumblist" id="comment-<?php comment_ID(); ?>">
            <ul>
                <li>
                    <figure>
                        <a><?php echo get_avatar( $comment, 50 ); ?></a>
                    </figure>
                    <div class="text">
                    	<div class="comment-data">
                            <header>
                                <?php $adm_says =  __( "%s", "Soundblast" ); echo sprintf( '<h6><a class="colrhover">'.$adm_says.'</h6></a>', get_comment_author_link() ) ; ?>
                                <?php
                                    /* translators: 1: date, 2: time */
                                    printf( __( '<time>%1$s,%2$s</time>', 'Soundblast' ), get_comment_date('l, d, m, Y'),get_comment_time('H:i A')); ?>
                           </header>
							<?php if ( $comment->comment_approved == '0' ) : ?>
                                    <div class="comment-awaiting-moderation colr"><?php _e( 'Your comment is awaiting moderation.', 'Soundblast' ); ?></div>
                                
                                <?php else: 
                          		comment_text();
						  		comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) );
						 		edit_comment_link( __( '<i class="fa fa-pencil-square-o"></i>', 'Soundblast' ), ' ' );
                          endif; ?>
                       </div>
                    </div>
                </li>
            </ul>
        </div>
	<?php
		break;
		case 'pingback'  :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php comment_author_link(); ?><?php edit_comment_link( __( '(Edit)', 'Soundblast' ), ' ' ); ?></p>
	<?php
		break;
		endswitch;
	}
}
	
// Get date differance
function cs_dateDiff($start, $end) {
	  $start_ts = strtotime($start);
	  $end_ts = strtotime($end);
	  $diff = $end_ts - $start_ts;
	  return round($diff / 86400);
}

// Generate Random string
function cs_generate_random_string($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}	

// Add Social icons	
function cs_add_social_icon(){
    $template_path = get_template_directory_uri() . '/scripts/admin/media_upload.js';
    wp_enqueue_script('my-upload2', $template_path, array('jquery', 'media-upload', 'thickbox', 'jquery-ui-droppable', 'jquery-ui-datepicker', 'jquery-ui-slider', 'wp-color-picker'));

	//echo '<tr id="del_' .$_POST['counter_social_network'].'"> 
		echo '<tr id="del_' .$_POST['counter_social_network'].'"> ';
								if(isset($_POST['social_net_awesome']) && $_POST['social_net_awesome'] <> ''){
									echo '<td><i style="color: green;" class="fa '.$_POST['social_net_awesome'].' fa-2x"></td>';
								} else {
									echo '<td><img width="50" src="'.$_POST['social_net_icon_path'].'"></td>';
								}
		//echo '<td><img width="50" src="' .$_POST['social_net_icon_path']. '"></td> 
		echo '<td>' .$_POST['social_net_url']. '</td> 
		<td class="centr"> 
			<a onclick="javascript:return confirm(\'Are you sure! You want to delete this\')" href="javascript:social_icon_del('.$_POST['counter_social_network'].')">Del</a> 
			| <a href="javascript:cs_toggle('.$_POST['counter_social_network'].')">Edit</a>
		</td> 
	</tr> 
	<tr id="'.$_POST['counter_social_network'].'" style="display:none"> 
		<td colspan="3"> 
			<ul class="form-elements">
				<li class="to-label"><label>Icon Path</label></li>
				<li class="to-field">
				  <input id="social_net_icon_path'.$_POST['counter_social_network'].'" name="social_net_icon_path[]" value="'.$_POST['social_net_icon_path'].'" type="text" class="small" /> 
				</li>
				<li><a onclick="cs_toggle('. $_POST['counter_social_network'] .')"><img src="'.get_template_directory_uri().'/images/admin/close-red.png"></a></li>
				<li class="full">&nbsp;</li>
				<li class="to-label"><label>Awesome Font</label></li>
				<li class="to-field">
				  <input class="small" type="text" id="social_net_awesome" name="social_net_awesome[]" value="'.$_POST['social_net_awesome'].'" style="width:420px;" />
				  <p>Put Awesome Font Code like "fa-flag".</p>
				</li>
				<li class="full">&nbsp;</li>
				<li class="to-label"><label>URL</label></li>
				<li class="to-field">
				  <input class="small" type="text" id="social_net_url" name="social_net_url[]" value="'.$_POST['social_net_url'].'" style="width:420px;" />
				  <p>Please enter full URL.</p>
				</li>
				<li class="full">&nbsp;</li>
				<li class="to-label"><label>Title</label></li>
				<li class="to-field">
				  <input class="small" type="text" id="social_net_tooltip" name="social_net_tooltip[]" value="'.$_POST['social_net_tooltip'].'" style="width:420px;" />
				  <p>Please enter text for icon tooltip..</p>
				</li>
			</ul>
		</td> 
	</tr>';
	die;
}	

add_action('wp_ajax_cs_add_social_icon', 'cs_add_social_icon');

// Get Google Fonts
function cs_get_google_fonts() {
    $fonts = array("Abel", "Aclonica", "Acme", "Actor", "Advent Pro", "Aldrich", "Allerta", "Allerta Stencil", "Amaranth", "Andika", "Anonymous Pro", "Antic", "Anton", "Arimo", "Armata", "Asap", "Asul",
        "Basic", "Belleza", "Cabin", "Cabin Condensed", "Cagliostro", "Candal", "Cantarell", "Carme", "Chau Philomene One", "Chivo", "Coda Caption", "Comfortaa", "Convergence", "Cousine", "Cuprum", "Days One",
        "Didact Gothic", "Doppio One", "Dorsa", "Dosis", "Droid Sans", "Droid Sans Mono", "Duru Sans", "Economica", "Electrolize", "Exo", "Federo", "Francois One", "Fresca", "Galdeano", "Geo", "Gudea",
        "Hammersmith One", "Homenaje", "Imprima", "Inconsolata", "Inder", "Istok Web", "Jockey One", "Josefin Sans", "Jura", "Karla", "Krona One", "Lato", "Lekton", "Magra", "Mako", "Marmelad", "Marvel",
        "Maven Pro", "Metrophobic", "Michroma", "Molengo", "Montserrat", "Muli", "News Cycle", "Nobile", "Numans", "Nunito", "Open Sans", "Open Sans Condensed", "Orbitron", "Oswald", "Oxygen", "PT Mono",
        "PT Sans", "PT Sans Caption", "PT Sans Narrow", "Paytone One", "Philosopher", "Play", "Pontano Sans", "Port Lligat Sans", "Puritan", "Quantico", "Quattrocento Sans", "Questrial", "Quicksand", "Rationale",
        "Ropa Sans", "Rosario", "Ruda", "Ruluko", "Russo One", "Shanti", "Sigmar One", "Signika", "Signika Negative", "Six Caps", "Snippet", "Spinnaker", "Syncopate", "Telex", "Tenor Sans", "Ubuntu",
        "Ubuntu Condensed", "Ubuntu Mono", "Varela", "Varela Round", "Viga", "Voltaire", "Wire One", "Yanone Kaffeesatz", "Adamina", "Alegreya", "Alegreya SC", "Alice", "Alike", "Alike Angular", "Almendra",
        "Almendra SC", "Amethysta", "Andada", "Antic Didone", "Antic Slab", "Arapey", "Artifika", "Arvo", "Average", "Balthazar", "Belgrano", "Bentham", "Bevan", "Bitter", "Brawler", "Bree Serif", "Buenard",
        "Cambo", "Cantata One", "Cardo", "Caudex", "Copse", "Coustard", "Crete Round", "Crimson Text", "Cutive", "Della Respira", "Droid Serif", "EB Garamond", "Enriqueta", "Esteban", "Fanwood Text", "Fjord One",
        "Gentium Basic", "Gentium Book Basic", "Glegoo", "Goudy Bookletter 1911", "Habibi", "Holtwood One SC", "IM Fell DW Pica", "IM Fell DW Pica SC", "IM Fell Double Pica", "IM Fell Double Pica SC",
        "IM Fell English", "IM Fell English SC", "IM Fell French Canon", "IM Fell French Canon SC", "IM Fell Great Primer", "IM Fell Great Primer SC", "Inika", "Italiana", "Josefin Slab", "Judson", "Junge",
        "Kameron", "Kotta One", "Kreon", "Ledger", "Linden Hill", "Lora", "Lusitana", "Lustria", "Marko One", "Mate", "Mate SC", "Merriweather", "Montaga", "Neuton", "Noticia Text", "Old Standard TT", "Ovo",
        "PT Serif", "PT Serif Caption", "Petrona", "Playfair Display", "Podkova", "Poly", "Port Lligat Slab", "Prata", "Prociono", "Quattrocento", "Radley", "Rokkitt", "Rosarivo", "Simonetta", "Sorts Mill Goudy",
        "Stoke", "Tienne", "Tinos", "Trocchi", "Trykker", "Ultra", "Unna", "Vidaloka", "Volkhov", "Vollkorn", "Abril Fatface", "Aguafina Script", "Aladin", "Alex Brush", "Alfa Slab One", "Allan", "Allura",
        "Amatic SC", "Annie Use Your Telescope", "Arbutus", "Architects Daughter", "Arizonia", "Asset", "Astloch", "Atomic Age", "Aubrey", "Audiowide", "Averia Gruesa Libre", "Averia Libre", "Averia Sans Libre",
        "Averia Serif Libre", "Bad Script", "Bangers", "Baumans", "Berkshire Swash", "Bigshot One", "Bilbo", "Bilbo Swash Caps", "Black Ops One", "Bonbon", "Boogaloo", "Bowlby One", "Bowlby One SC",
        "Bubblegum Sans", "Buda", "Butcherman", "Butterfly Kids", "Cabin Sketch", "Caesar Dressing", "Calligraffitti", "Carter One", "Cedarville Cursive", "Ceviche One", "Changa One", "Chango", "Chelsea Market",
        "Cherry Cream Soda", "Chewy", "Chicle", "Coda", "Codystar", "Coming Soon", "Concert One", "Condiment", "Contrail One", "Cookie", "Corben", "Covered By Your Grace", "Crafty Girls", "Creepster", "Crushed",
        "Damion", "Dancing Script", "Dawning of a New Day", "Delius", "Delius Swash Caps", "Delius Unicase", "Devonshire", "Diplomata", "Diplomata SC", "Dr Sugiyama", "Dynalight", "Eater", "Emblema One",
        "Emilys Candy", "Engagement", "Erica One", "Euphoria Script", "Ewert", "Expletus Sans", "Fascinate", "Fascinate Inline", "Federant", "Felipa", "Flamenco", "Flavors", "Fondamento", "Fontdiner Swanky",
        "Forum", "Fredericka the Great", "Fredoka One", "Frijole", "Fugaz One", "Geostar", "Geostar Fill", "Germania One", "Give You Glory", "Glass Antiqua", "Gloria Hallelujah", "Goblin One", "Gochi Hand",
        "Gorditas", "Graduate", "Gravitas One", "Great Vibes", "Gruppo", "Handlee", "Happy Monkey", "Henny Penny", "Herr Von Muellerhoff", "Homemade Apple", "Iceberg", "Iceland", "Indie Flower", "Irish Grover",
        "Italianno", "Jim Nightshade", "Jolly Lodger", "Julee", "Just Another Hand", "Just Me Again Down Here", "Kaushan Script", "Kelly Slab", "Kenia", "Knewave", "Kranky", "Kristi", "La Belle Aurore",
        "Lancelot", "League Script", "Leckerli One", "Lemon", "Lilita One", "Limelight", "Lobster", "Lobster Two", "Londrina Outline", "Londrina Shadow", "Londrina Sketch", "Londrina Solid",
        "Love Ya Like A Sister", "Loved by the King", "Lovers Quarrel", "Luckiest Guy", "Macondo", "Macondo Swash Caps", "Maiden Orange", "Marck Script", "Meddon", "MedievalSharp", "Medula One", "Megrim",
        "Merienda One", "Metamorphous", "Miltonian", "Miltonian Tattoo", "Miniver", "Miss Fajardose", "Modern Antiqua", "Monofett", "Monoton", "Monsieur La Doulaise", "Montez", "Mountains of Christmas",
        "Mr Bedfort", "Mr Dafoe", "Mr De Haviland", "Mrs Saint Delafield", "Mrs Sheppards", "Mystery Quest", "Neucha", "Niconne", "Nixie One", "Norican", "Nosifer", "Nothing You Could Do", "Nova Cut",
        "Nova Flat", "Nova Mono", "Nova Oval", "Nova Round", "Nova Script", "Nova Slim", "Nova Square", "Oldenburg", "Oleo Script", "Original Surfer", "Over the Rainbow", "Overlock", "Overlock SC", "Pacifico",
        "Parisienne", "Passero One", "Passion One", "Patrick Hand", "Patua One", "Permanent Marker", "Piedra", "Pinyon Script", "Plaster", "Playball", "Poiret One", "Poller One", "Pompiere", "Press Start 2P",
        "Princess Sofia", "Prosto One", "Qwigley", "Raleway", "Rammetto One", "Rancho", "Redressed", "Reenie Beanie", "Revalia", "Ribeye", "Ribeye Marrow", "Righteous", "Rochester", "Rock Salt", "Rouge Script",
        "Ruge Boogie", "Ruslan Display", "Ruthie", "Sail", "Salsa", "Sancreek", "Sansita One", "Sarina", "Satisfy", "Schoolbell", "Seaweed Script", "Sevillana", "Shadows Into Light", "Shadows Into Light Two",
        "Share", "Shojumaru", "Short Stack", "Sirin Stencil", "Slackey", "Smokum", "Smythe", "Sniglet", "Sofia", "Sonsie One", "Special Elite", "Spicy Rice", "Spirax", "Squada One", "Stardos Stencil",
        "Stint Ultra Condensed", "Stint Ultra Expanded", "Sue Ellen Francisco", "Sunshiney", "Supermercado One", "Swanky and Moo Moo", "Tangerine", "The Girl Next Door", "Titan One", "Trade Winds", "Trochut",
        "Tulpen One", "Uncial Antiqua", "UnifrakturCook", "UnifrakturMaguntia", "Unkempt", "Unlock", "VT323", "Vast Shadow", "Vibur", "Voces", "Waiting for the Sunrise", "Wallpoet", "Walter Turncoat",
        "Wellfleet", "Yellowtail", "Yeseva One", "Yesteryear", "Zeyada");
    return $fonts;
}

//Countries Array
function cs_get_countries() {
    $get_countries = array("Afghanistan", "Albania", "Algeria", "American Samoa", "Andorra", "Angola", "Antarctica", "Antigua and Barbuda", "Argentina", "Armenia", "Aruba", "Australia", "Austria", "Azerbaijan",
        "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bhutan", "Bolivia", "Bosnia and Herzegovina", "Botswana", "Brazil", "British Virgin Islands",
        "Brunei", "Bulgaria", "Burkina Faso", "Burundi", "Cambodia", "Cameroon", "Canada", "Cape Verde", "Cayman Islands", "Central African Republic", "Chad", "Chile", "China",
        "Colombia", "Comoros", "Costa Rica", "Croatia", "Cuba", "Cyprus", "Czech Republic", "Democratic People's Republic of Korea", "Democratic Republic of the Congo", "Denmark", "Djibouti",
        "Dominica", "Dominican Republic", "Ecuador", "Egypt", "El Salvador", "England", "Equatorial Guinea", "Eritrea", "Estonia", "Ethiopia", "Fiji", "Finland", "France", "French Polynesia",
        "Gabon", "Gambia", "Georgia", "Germany", "Ghana", "Greece", "Greenland", "Grenada", "Guadeloupe", "Guam", "Guatemala", "Guinea", "Guinea Bissau", "Guyana", "Haiti", "Honduras", "Hong Kong",
        "Hungary", "Iceland", "India", "Indonesia", "Iran", "Iraq", "Ireland", "Israel", "Italy", "Jamaica", "Japan", "Jordan", "Kazakhstan", "Kenya", "Kiribati", "Kosovo", "Kuwait", "Kyrgyzstan",
        "Laos", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libyan Arab Jamahiriya", "Liechtenstein", "Lithuania", "Luxembourg", "Macao", "Macedonia", "Madagascar", "Malawi", "Malaysia",
        "Maldives", "Mali", "Malta", "Marshall Islands", "Mauritania", "Mauritius", "Mauritius", "Mexico", "Micronesia", "Moldova", "Monaco", "Mongolia", "Montenegro", "Morocco", "Mozambique",
        "Myanmar(Burma)", "Namibia", "Nauru", "Nepal", "Netherlands", "Netherlands Antilles", "New Caledonia", "New Zealand", "Nicaragua", "Niger", "Nigeria", "Northern Ireland",
        "Northern Mariana Islands", "Norway", "Oman", "Pakistan", "Palau", "Palestine", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Poland", "Portugal", "Puerto Rico",
        "Qatar", "Republic of the Congo", "Romania", "Russia", "Rwanda", "Saint Kitts and Nevis", "Saint Lucia", "Saint Vincent and the Grenadines", "Samoa",
        "San Marino", "Saudi Arabia", "Scotland", "Senegal", "Serbia", "Seychelles", "Sierra Leone", "Singapore", "Slovakia", "Slovenia", "Solomon Islands", "Somalia", "South Africa",
        "South Korea", "Spain", "Sri Lanka", "Sudan", "Suriname", "Swaziland", "Sweden", "Switzerland", "Syria", "Taiwan", "Tajikistan", "Tanzania", "Thailand", "Timor-Leste", "Togo", "Tonga",
        "Trinidad and Tobago", "Tunisia", "Turkey", "Turkmenistan", "Tuvalu", "US Virgin Islands", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "United States", "Uruguay",
        "Uzbekistan", "Vanuatu", "Vatican", "Venezuela", "Vietnam", "Wales", "Yemen", "Zambia", "Zimbabwe");
    return $get_countries;
}

	// Theme default widgets activation
    function cs_activate_widget(){
		$sidebars_widgets = get_option('sidebars_widgets');  //collect widget informations
		// ---- calendar widget setting---
		$calendar = array();
		$calendar[1] = array(
		"title"		=>	'Calendar'
		);
						
		$calendar['_multiwidget'] = '1';
		update_option('widget_calendar',$calendar);
		$calendar = get_option('widget_calendar');
		krsort($calendar);
		foreach($calendar as $key1=>$val1)
		{
			$calendar_key = $key1;
			if(is_int($calendar_key))
			{
				break;
			}
		}
		//---Blog Categories
		$categories = array();
		$categories[1] = array(
		"title"		=>	'Blog Categories',
		"count" => ''
		);
						
		$calendar['_multiwidget'] = '1';
		update_option('widget_categories',$categories);
		$categories = get_option('widget_categories');
		krsort($categories);
		foreach($categories as $key1=>$val1)
		{
			$categories_key = $key1;
			if(is_int($categories_key))
			{
				break;
			}
		}
		// ----   recent post with thumbnail widget setting---
		$recent_post_widget = array();
		$recent_post_widget[1] = array(
		"title"		=>	'Recent Blogs',
		"select_category" 	=> 'blog',
		"showcount" => '3',
		"thumb" => 'true'
		 );						
		$recent_post_widget['_multiwidget'] = '1';
		update_option('widget_cs_recentposts',$recent_post_widget);
		$recent_post_widget = get_option('widget_cs_recentposts');
		krsort($recent_post_widget);
		foreach($recent_post_widget as $key1=>$val1)
		{
			$recent_post_widget_key = $key1;
			if(is_int($recent_post_widget_key))
			{
				break;
			}
		}
		// ----   recent post without thumbnail widget setting---
		$recent_post_widget2 = array();
		$recent_post_widget2 = get_option('widget_cs_recentposts');
		$recent_post_widget2[2] = array(
		"title"		=>	'Latest Posts',
		"select_category" 	=> 'blog',
		"showcount" => '2',
		"thumb" => 'false'
		 );						
		$recent_post_widget2['_multiwidget'] = '1';
		update_option('widget_cs_recentposts',$recent_post_widget2);
		$recent_post_widget2 = get_option('widget_cs_recentposts');
		krsort($recent_post_widget2);
		foreach($recent_post_widget2 as $key1=>$val1)
		{
			$recent_post_widget_key2 = $key1;
			if(is_int($recent_post_widget_key2))
			{
				break;
			}
		}
 		// ----   recent event widget setting---
		$upcoming_events_widget = array();
		$upcoming_events_widget[1] = array(
		"title"		=>	'Events',
		"get_post_slug" 	=> 'gigs',
		"showcount" => '3',
 		 );						
		$upcoming_events_widget['_multiwidget'] = '1';
		update_option('widget_cs_upcoming_events',$upcoming_events_widget);
		$upcoming_events_widget = get_option('widget_cs_upcoming_events');
		krsort($upcoming_events_widget);
		foreach($upcoming_events_widget as $key1=>$val1)
		{
			$upcoming_events_widget_key = $key1;
			if(is_int($upcoming_events_widget_key))
			{
				break;
			}
		}
		// ---- tags widget setting---
		$tag_cloud = array();
		$tag_cloud[1] = array(
			"title" => 'Tags',
			"taxonomy" => 'album-category',
		);						
		$tag_cloud['_multiwidget'] = '1';
		update_option('widget_tag_cloud',$tag_cloud);
		$tag_cloud = get_option('widget_tag_cloud');
		krsort($tag_cloud);
		foreach($tag_cloud as $key1=>$val1)
		{
			$tag_cloud_key = $key1;
			if(is_int($tag_cloud_key))
			{
				break;
			}
		}
		// --- text widget setting ---
		$text = array();
		$text[1] = array(
			'title' => 'Soundcloud',
			'text' => '<iframe width="100%" height="470" scrolling="no" frameborder="no" src="https://w.soundcloud.com/player/?url=http%3A%2F%2Fapi.soundcloud.com%2Fplaylists%2F1785700&amp;color=262626&amp;auto_play=false&amp;show_artwork=true"></iframe>',
		);						
		$text['_multiwidget'] = '1';
		update_option('widget_text',$text);
		$text = get_option('widget_text');
		krsort($text);
		foreach($text as $key1=>$val1)
		{
			$text_key = $key1;
			if(is_int($text_key))
			{
				break;
			}
		}
		// --- text widget About Our Team setting ---
		// --- text widget setting ---
		$text2 = array();
		$text2 = get_option('widget_text');
		$text2[2] = array(
			'title' => '',
			'text' => ' <figure><a href="'.site_url().'"><img src="'.get_template_directory_uri() . '/images/add1.jpg" alt=""></a></figure>',
		);						
		$text2['_multiwidget'] = '2';
		update_option('widget_text',$text2);
		$text = get_option('widget_text');
		krsort($text2);
		foreach($text2 as $key1=>$val1)
		{
			$text_key2 = $key1;
			if(is_int($text_key2))
			{
				break;
			}
		}
		//----text widget for contact info----------
		$text4 = array();
		$text4 = get_option('widget_text');
		$text4[4] = array(
			'title' => 'Contact Info',
			'text' => '<div class="text-info">
                        <div class="postel-text">
                        	<p>Practical Components, Inc. 10762 Noel Street,
                            City of Newyork,
                            United States of Amarica
                            </p>
                        </div>
                        <ul>
                        	<li>
                                <span>Phone</span>
                                <p>123.456.78910</p>
                            </li>
                            <li>
                            	<span>Mobile</span>
                                <p>(800) 123 4567 89</p>
                             </li>
                             <li>
                                <span>Email</span>
                                <p>resturant@resturant.com</p>
                             </li>
                             <li>   
                                <span>Timming</span>
                                <p class="small">Mon-Thu (09:00 to 17:30)</p>
                            </li>
                        </ul>
                    </div>',

		);						
		$text4['_multiwidget'] = '1';
		update_option('widget_text',$text4);
		$text4 = get_option('widget_text');
		krsort($text4);
		foreach($text4 as $key1=>$val1)
		{
			$text_key4 = $key1;
			if(is_int($text_key4))
			{
				break;
			}
		}
		// --- gallery widget setting ---
		$cs_gallery = array();
		$cs_gallery[1] = array(
			'title' => 'Featured Gallery',
			'get_names_gallery' => 'our-photos',
			'showcount' => '12'
		);						
		$cs_gallery['_multiwidget'] = '1';
		update_option('widget_cs_gallery',$cs_gallery);
		$cs_gallery = get_option('widget_cs_gallery');
		krsort($cs_gallery);
		foreach($cs_gallery as $key1=>$val1)
		{
			$cs_gallery_key = $key1;
			if(is_int($cs_gallery_key))
			{
				break;
			}
		}
		// ---- archive widget setting---
		$archives = array();
		$archives[1] = array(
		"title" => 'Archives',
		"count" => 'checked'
		);						
		$archives['_multiwidget'] = '1';
		update_option('widget_archives',$archives);
		$archives = get_option('widget_archives');
		krsort($archives);
		foreach($archives as $key1=>$val1)
		{
			$archives_key = $key1;
			if(is_int($archives_key))
			{
				break;
			}
		}
		
		// ---- Tabs widget setting---
		$tab_widget = array();
		$tab_widget[1] = array(
		"title" => 'Blogs',
		"title_widget_two" => 'Tags',
		"title_widget_three" => 'Comments',
		"get_default_widget_one" => 'WP_Widget_Recent_Posts',
		"get_default_widget_two" => 'WP_Widget_Tag_Cloud',
		"get_default_widget_three" => 'WP_Widget_Recent_Comments'
		);						
		$tab_widget['_multiwidget'] = '1';
		update_option('widget_cs_tabs_widget_show',$tab_widget);
		$tab_widget = get_option('widget_cs_tabs_widget_show');
		krsort($tab_widget);
		foreach($tab_widget as $key1=>$val1)
		{
			$tab_widget_key = $key1;
			if(is_int($tab_widget_key))
			{
				break;
			}
		}
		
		// ---- search widget setting---		
		$search = array();
		$search[1] = array(
			"title"		=>	'',
		);	
		$search['_multiwidget'] = '1';
		update_option('widget_search',$search);
		$search = get_option('widget_search');
		krsort($search);
		foreach($search as $key1=>$val1)
		{
			$search_key = $key1;
			if(is_int($search_key))
			{
				break;
			}
		}
		// ---- twitter widget setting---
		$cs_twitter_widget = array();
		$cs_twitter_widget[1] = array(
		"title"		=>	'Twitter',
		"username" 	=>	"edmbiz",
		"numoftweets" => "2",
		 );						
		$cs_twitter_widget['_multiwidget'] = '1';
		update_option('widget_cs_twitter_widget',$cs_twitter_widget);
		$cs_twitter_widget = get_option('widget_cs_twitter_widget');
		krsort($cs_twitter_widget);
		foreach($cs_twitter_widget as $key1=>$val1)
		{
			$cs_twitter_widget_key = $key1;
			if(is_int($cs_twitter_widget_key))
			{
				break;
			}
		}
		// --- facebook widget setting-----
		$facebook_module = array();
		$facebook_module[1] = array(
		"title"		=>	'Facebook',
		"pageurl" 	=>	"https://www.facebook.com/EDMbiz",
		"showfaces" => "on",
		"likebox_height" => "285",
		"fb_bg_color" =>"#000",
		);						
		$facebook_module['_multiwidget'] = '1';
		update_option('widget_cs_facebook_module',$facebook_module);
		$facebook_module = get_option('widget_cs_facebook_module');
		krsort($facebook_module);
		foreach($facebook_module as $key1=>$val1)
		{
			$facebook_module_key = $key1;
			if(is_int($facebook_module_key))
			{
				break;
			}
		}
 		//----text widget for contact info----------
		$text5 = array();
		$text5 = get_option('widget_text');
		$text5[5] = array(
			'title' => 'Accordion',
			'text' => '[accordion]
			[accordion_item active="yes" icon="" title="Qualified Full-time Professional" accordion="accordion"]Qualified Full-time Professional Master Photographer Andrew Gransden photographs weddings, portraits, wildlife and nature, commercial and businesses across Scotland from Aberdeen to Inverness..[/accordion_item]
			[accordion_item title="Commercial and businesses across" accordion="accordion"]Qualified Full-time Professional Master Photographer Andrew Gransden photographs weddings, portraits, wildlife and nature, commercial and businesses across Scotland from Aberdeen to Inverness..[/accordion_item]
			[accordion_item title="Businesses across Scotland from" accordion="accordion"]Qualified Full-time Professional Master Photographer Andrew Gransden photographs weddings, portraits, wildlife and nature, commercial and businesses across Scotland from Aberdeen to Inverness..[/accordion_item]
			[/accordion]',

		);	
							
		$text5['_multiwidget'] = '1';
		update_option('widget_text',$text5);
		$text5 = get_option('widget_text');
		krsort($text5);
		foreach($text5 as $key1=>$val1)
		{
			$text_key5 = $key1;
			if(is_int($text_key5))
			{
				break;
			}
		}
		//----text widget for contact info----------
		$text6 = array();
		$text6 = get_option('widget_text');
		$text6[6] = array(
			'title' => 'Toggle',
			'text' => '[toggle active="yes" title="Toggle Title 1"]Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque ac arcu aliquet sem varius interdum vel quis odio. Nulla adipiscing ipsum sit amet neque egestas sagittis.[/toggle]',

		);						
		$text6['_multiwidget'] = '1';
		update_option('widget_text',$text6);
		$text6 = get_option('widget_text');
		krsort($text6);
		foreach($text6 as $key1=>$val1)
		{
			$text_key6 = $key1;
			if(is_int($text_key6))
			{
				break;
			}
		}
		
		// ---- tags widget setting---
		$our_menu = array();
		$our_menu[1] = array(
			"title" => 'Our Menu',
			"nav_menu" => '2',
		);						
		$our_menu['_multiwidget'] = '1';
		update_option('widget_nav_menu',$our_menu);
		$our_menu = get_option('widget_nav_menu');
		krsort($our_menu);
		foreach($our_menu as $key1=>$val1)
		{
			$our_menu_key = $key1;
			if(is_int($our_menu_key))
			{
				break;
			}
		}
		
		
		// Add widgets in sidebars
		$sidebars_widgets['Sidebar'] = array("cs_upcoming_events-$upcoming_events_widget_key", "cs_recentposts-$recent_post_widget_key","cs_gallery-$cs_gallery_key","cs_facebook_module-$facebook_module_key");
		$sidebars_widgets['events'] = array("cs_gallery-$cs_gallery_key","cs_facebook_module-$facebook_module_key","tag_cloud-$tag_cloud_key","calendar-$calendar_key");
		$sidebars_widgets['Home'] = array("cs_upcoming_events-$upcoming_events_widget_key", "text-$text_key", "text-$text_key2");
		$sidebars_widgets['Blog Detail'] = array("categories-$categories_key", "cs_recentposts-$recent_post_widget_key", "text-$text_key", "text-$text_key2");
		$sidebars_widgets['footer-widget'] = array("cs_recentposts-$recent_post_widget_key","cs_gallery-$cs_gallery_key","cs_twitter_widget-$cs_twitter_widget_key");
		$sidebars_widgets['shopdetail'] = array();
		update_option('sidebars_widgets',$sidebars_widgets);  //save widget informations
	}
 	// Install data on theme activation
   	function cs_activation_data() {
		global $wpdb;
		$args = array(
			'style_sheet' => 'custom',
			'custom_color_scheme' => '#cfbd25',
			'heading_color_scheme' => '#FFFFFF',
			'color_option' => 'black',
			// footer Color Settigs
			'layout_option' => 'wrapper',
			'header_styles' => 'header1',
			'default_header' => 'header1',
			'bg_img' => '9',
			'bg_img_custom' => '',
			'bg_position' => 'center',
			'bg_repeat' => 'no-repeat',
			'bg_attach' => 'fixed',
			'pattern_img' => '0',
			'custome_pattern' => '',
			'bg_color' => '#000',

			'logo' => get_template_directory_uri().'/images/logo.png',
			'logo_width' => '164',
			'logo_height' => '21',
			//'logo_sticky' => get_template_directory_uri().'/images/logo.png',
			'fav_icon' => get_template_directory_uri() . '/images/favicon.ico',
			'header_code' => '',
			'header_languages' => '',
			'header_cart' => '',
			'footer_widget' => 'on',
			'footer_newsletter' => 'on',
			'copyright' =>  '&copy;'.gmdate("Y")." ".get_option("blogname")." WordPress All rights reserved.", 
			'powered_by' => 'Design by <a href="#">ChimpStudio</a>',
			'powered_icon' => '',
			'analytics' => '',
			'responsive' => 'on',
			'style_rtl' => '',
			// switchers
			'color_switcher' => '',
			'trans_switcher' => '',
			'search_switcher' => 'on',
			'login_switcher' => 'on',
			'show_slider' => '',
			'slider_name' => 'slider',
			'slider_type' => 'Flex Slider',
			'cs_slider_view' => 'background-view',
			'post_title' => '',
			'show_player' => '',
			'album_name' => 'music',
			'show_partners' => 'on',
			'partner_gallery_title' => 'Partner',
			'partner_gallery_name' => 'partners-gallery',
			'sidebar' => array( 'Sidebar', 'Home', 'Blog Detail', 'events', 'shopdetail'),
			
			// slider setting
			'flex_effect' => 'fade',
			'flex_auto_play' => 'on',
			'flex_animation_speed' => '7000',
			'flex_pause_time' => '600',
			'slider_id' => '[rev_slider rocky]',
			'slider_view' => '',
			'social_net_title' => '',
			'social_net_icon_path' => array('', '', '', '', '', '', '', '', '', ''),
			'social_net_awesome' => array( 'fa-facebook', 'fa-twitter', 'fa-google-plus', 'fa-dribbble', 'fa-linkedin', 'fa-youtube', 'fa-instagram', 'fa-pinterest', 'fa-tumblr', 'fa-flickr' ),
			'social_net_url' => array( 'YOUR_PROFILE_LINK', 'YOUR_PROFILE_LINK', 'YOUR_PROFILE_LINK', 'YOUR_PROFILE_LINK', 
								'YOUR_PROFILE_LINK', 'YOUR_PROFILE_LINK', 'YOUR_PROFILE_LINK', 'YOUR_PROFILE_LINK', 
								'YOUR_PROFILE_LINK'
								),
			'social_net_tooltip' => array( 'Facebook', 'Twitter', 'Google Plus', 'Dribble', 'LInked In', 'Youtube', 'Instagram', 'Pinterest', 'Tumblr', 'Flickr' ),
			'facebook_share' => 'on',
			'twitter_share' => 'on',
			'linkedin_share' => 'on',
			'myspace_share' => 'on',
			'digg_share' => 'on',
			'stumbleupon_share' => 'on',
			'reddit_share' => 'on',
			'pinterest_share' => 'on',
			'tumblr_share' => 'on',
			'google_plus_share' => 'on',
			'blogger_share' => 'on',
			'amazon_share' => 'on',
			'cs_other_share' => 'on',
			'mailchimp_key' => '',
			// tranlations
			
			'trans_album_tracks' => 'Tracks',
			'trans_album_buynow' => 'Buy Now',
			'trans_album_release_date' => 'Release Date',
			'trans_album_label' => 'Label',
			'trans_album_available' => 'Avaialable on',
			'trans_album_likes' => 'Likes',
			'trans_album_amazon' => 'Amazon',
			'trans_album_itunes' => 'Itunes',
			'trans_album_groove' => 'Grooveshark',
			'trans_album_soundc' => 'Soundcloud',
			
			'trans_event_free_entry' => 'Free Entry',
			'trans_event_sold_out' => 'Sold Out',
			'trans_event_cancelled' => 'Cancelled',
            'trans_event_buy_ticket' => 'Buy Ticket',
			'trans_event_location' => 'Event Location',
			'trans_event_days_to_go' => 'Days to go!',
			
            'trans_subject' => 'Subject',
            'trans_message' => 'Message',
            'trans_form_title' => 'Send us a Quick Message',
			'trans_form_email_published' => 'Your Email will never published.',
			
            'trans_share_this_post' => 'Share Now',
            'trans_content_404' => "It seems we can not find what you are looking for.",
			'trans_other_prev' => 'Previous',
			'trans_read_more' => 'read more',
			'trans_current_page' => 'Current Page',
			'trans_view_all' => 'View all Posts',
			'trans_other_weekly_newsletter' => 'Subscribe Weekly Newsletter',
			// translation end
			
           	'pagination' => 'Show Pagination',
			'record_per_page' => '5',
			'cs_layout' => 'right',
			'cs_sidebar_left' => '',
			'cs_sidebar_right' => 'Sidebar',
			'under-construction' => '',
			'showlogo' => 'on',
			'under_construction_text' => '<h4>OUR WEBSITE IS UNDERCONSTRUCTION</h1><h4>We\'ll be here soon with a new website, Estimated Time Remaining</h4>',
			'launch_date' => '2014-12-01',
 			'consumer_key' => '',
			'consumer_secret' => '',
			'access_token' => '',
			'access_token_secret' => '',
		);
		/* Merge Heaser styles
		*/
		update_option("cs_theme_option", $args );
		update_option("cs_theme_option_restore", $args );
  }
// Admin scripts enqueue
function cs_admin_scripts_enqueue() {
    $template_path = get_template_directory_uri() . '/scripts/admin/media_upload.js';
    wp_enqueue_script('my-upload', $template_path, array('jquery', 'media-upload', 'thickbox', 'jquery-ui-droppable', 'jquery-ui-datepicker', 'jquery-ui-slider', 'wp-color-picker'));
    wp_enqueue_script('custom_wp_admin_script', get_template_directory_uri() . '/scripts/admin/cs_functions.js');
    wp_enqueue_style('custom_wp_admin_style', get_template_directory_uri() . '/css/admin/admin-style.css', array('thickbox'));
	wp_enqueue_style('wp-color-picker');
}

// Inclue Template files
require_once (TEMPLATEPATH . '/include/album.php');
require_once (TEMPLATEPATH . '/include/event.php');
require_once (TEMPLATEPATH . '/include/team.php');
require_once (TEMPLATEPATH . '/include/slider.php');
require_once (TEMPLATEPATH . '/include/gallery.php');
require_once (TEMPLATEPATH . '/include/page_builder.php');
require_once (TEMPLATEPATH . '/include/post_meta.php');
require_once (TEMPLATEPATH . '/include/short_code.php');
require_once (TEMPLATEPATH . '/functions-theme.php');
require_once (TEMPLATEPATH . '/include/mailchimpapi/mailchimpapi.class.php');
require_once (TEMPLATEPATH . '/include/page_element_functions.php');
/////// Require Woocommerce///////
require_once (TEMPLATEPATH . '/include/config_woocommerce/config.php');
require_once (TEMPLATEPATH . '/include/config_woocommerce/product_meta.php');
/////////////////////////////////
if (current_user_can('administrator')) {
	// Addmin Menu CS Theme Option
	require_once (TEMPLATEPATH . '/include/theme_option.php');
	add_action('admin_menu', 'cs_theme');
	function cs_theme() {
		add_theme_page('CS Theme Option', 'CS Theme Option', 'read', 'cs_theme_options', 'theme_option');
	}
}
 
// Front End Functions Start
// add twitter option in user profile
function cs_contact_options( $contactoptions ) {
	$contactoptions['twitter'] = 'Twitter';
	return $contactoptions;
}

// Template redirect in single Gallery and Slider page
function cs_slider_gallery_template_redirect(){
    if ( get_post_type() == "cs_gallery" or get_post_type() == "cs_slider" ) {
		global $wp_query;
		$wp_query->set_404();
		status_header( 404 );
		get_template_part( 404 ); exit();
    }
}
// Get header dropdown options
function cs_header_options(){
    global $cs_theme_option;
       for($i=1; $i<=3; $i++){?>
    		<option value="<?php echo 'header'.$i;?>" <?php if( $cs_theme_option['header_styles']=='header'.$i){ echo 'selected="selected"';}?>><?php echo 'Header '.$i;?></option>
		<?php }
}
// enqueue style and scripts for frontend
function cs_front_scripts_enqueue() {
	global $cs_theme_option;
     if (!is_admin()) {
		wp_enqueue_style('black_css', get_template_directory_uri() . '/css/black.css');
		wp_enqueue_style('style_css', get_template_directory_uri() . '/style.css');
		wp_enqueue_style('widget_css', get_template_directory_uri() . '/css/widget.css');
		wp_enqueue_style('shortcode_css', get_template_directory_uri() . '/css/shortcode.css');
   		wp_enqueue_style('prettyPhoto_css', get_template_directory_uri() . '/css/prettyphoto.css');
		if ( $cs_theme_option['color_switcher'] == "on" ) {
			wp_enqueue_style('color-switcher_css', get_template_directory_uri() . '/css/color-switcher.css');
		}
  		wp_enqueue_style('bootstrap_css', get_template_directory_uri() . '/css/bootstrap.css');
 		wp_enqueue_style('font-awesome_css', get_template_directory_uri() . '/css/font-awesome.css');
	 
    		wp_enqueue_style( 'wp-mediaelement' );
 		    wp_enqueue_script('jquery');
			wp_enqueue_script( 'wp-mediaelement' );
			wp_enqueue_script('bootstrap_js', get_template_directory_uri() . '/scripts/frontend/bootstrap.js', '', '', true);
   			wp_enqueue_script('jquery.nicescroll_js', get_template_directory_uri() . '/scripts/frontend/jquery.nicescroll.js', '0', '', true);
			wp_enqueue_script('jquery.nicescrollpjus_js', get_template_directory_uri() . '/scripts/frontend/modernizr.js', '0', '', true);
			wp_enqueue_script('text-rotation_js', get_template_directory_uri() . '/scripts/frontend/jquery.simple-text-rotator.js', '', '', true);
			wp_enqueue_script('prettyPhoto_js', get_template_directory_uri() . '/scripts/frontend/jquery.prettyphoto.js', '', '', true);
			wp_enqueue_script('functions_js', get_template_directory_uri() . '/scripts/frontend/functions.js', '0', '', true);
			
			
 			if ( $cs_theme_option['style_rtl'] == "on"){
				wp_enqueue_style('rtl_css', get_template_directory_uri() . '/css/rtl.css');
 			}
			
			if 	($cs_theme_option['responsive'] == "on") {
				echo '<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">';
				wp_enqueue_style('responsive_css', get_template_directory_uri() . '/css/responsive.css');
			}
     }
}

// enqueue masonry style and script for frontend
function cs_enqueue_masonry_style_script(){
 	wp_enqueue_script('jquery.masonry_js', get_template_directory_uri() . '/scripts/frontend/jquery.masonry.min.js', '', '', true);
	wp_enqueue_style('masonry_css', get_template_directory_uri() . '/css/masonry.css');
}

// enqueue masonry style and script for frontend
function cs_enqueue_jplayer(){
	wp_enqueue_script('jplayer_js', get_template_directory_uri() . '/scripts/frontend/jquery.jplayer.min.js', '', '', true);
	wp_enqueue_script('jplayer.playlist.min_js', get_template_directory_uri() . '/scripts/frontend/jplayer.playlist.min.js', '0', '', true);
}
// enqueue validation for frontend
function cs_enqueue_validation_script(){
	wp_enqueue_script('jquery.validate.metadata_js', get_template_directory_uri() . '/scripts/frontend/jquery.validate.metadata.js', '', '', true);
	wp_enqueue_script('jquery.validate_js', get_template_directory_uri() . '/scripts/frontend/jquery.validate.js', '', '', true);
}
// enqueue flexslider styel and script for frontend
function cs_enqueue_flexslider_script(){
   	wp_enqueue_script('jquery.flexslider-min_js', get_template_directory_uri() . '/scripts/frontend/jquery.flexslider-min.js', '', '', true);
    wp_enqueue_style('flexslider_css', get_template_directory_uri() . '/css/flexslider.css');
}
// enqueue countdown script for frontend
function cs_event_countdown_scripts() {
     wp_enqueue_script('event_countdown_js', get_template_directory_uri() . '/scripts/frontend/jquery.countdown.js', '', '', true);
}
// enqueue cycleslide  script for frontend
function cs_cycleslider_script(){
	wp_enqueue_script('jquerycycle2_js', get_template_directory_uri() . '/scripts/frontend/jquerycycle2.js', '', '', true);
	wp_enqueue_script('cycleslider_js', get_template_directory_uri() . '/scripts/frontend/cycle2carousel.js', '', '', true);
}
// enqueue addthis script for frontend 
function cs_addthis_script_init_method(){
	if( is_single()){
		wp_enqueue_script( 'cs_addthis', 'http://s7.addthis.com/js/250/addthis_widget.js#pubid=xa-4e4412d954dccc64', ",",true);
	}
}
/*------Header Functions------*/

// Favicon and header code in head tag//
function cs_header_settings() {
    global $cs_theme_option;
    ?>
     <link rel="shortcut icon" href="<?php echo $cs_theme_option['fav_icon'] ?>" />
     <!--[if lt IE 9]><script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
     <?php  
}

// Favicon and header code in head tag//
function cs_footer_settings() {
    global $cs_theme_option;
     echo htmlspecialchars_decode($cs_theme_option['analytics']);
}
// Get Header Name
function cs_get_header_name(){
	global $post, $cs_theme_option;
	if ( isset($_POST['header_styles']) ) {
			$_SESSION['Soundblast_sess_header_styles'] = $_POST['header_styles'];
			$header_styles = $_SESSION['Soundblast_sess_header_styles'];
	}
	else if ( !empty($_SESSION['Soundblast_sess_header_styles']) ) {
			$header_styles = $_SESSION['Soundblast_sess_header_styles'];
	}
	else if(is_page()){
		$cs_page_builder = get_post_meta($post->ID, "cs_page_builder", true);
		if($cs_page_builder <> ''){
			$cs_xmlObject = new SimpleXMLElement($cs_page_builder);
			$header_styles = $cs_xmlObject->header_styles;
			if($header_styles == '' or $header_styles == 'default-header'){
				$header_styles = $cs_theme_option['default_header'];	
			}
		}else{
			$header_styles = $cs_theme_option['default_header'];
		}
	}else {
			$header_styles = $cs_theme_option['default_header'];
	}	
	return $header_styles;
}

// Home page Slider //
function cs_get_home_slider(){
    global $cs_theme_option;
	if($cs_theme_option['show_slider'] =="on"){
		if($cs_theme_option['slider_type'] <> ""){
				$width = 1080;
				$height = 468;
				  $slider_slug = $cs_theme_option['slider_name'];
				  if($slider_slug <> ''){
					  $args=array(
						'name' => $slider_slug,
						'post_type' => 'cs_slider',
						'post_status' => 'publish',
						'showposts' => 1,
					  );
					  $get_posts = get_posts($args);
					  if($get_posts){
						  $slider_id = $get_posts[0]->ID;
						  if($cs_theme_option['slider_type'] == 'Flex Slider'){
							cs_flex_slider($width,$height,$slider_id);
						  }
					  } else {
						  $slider_id = '';
						  echo '<div class="box-small no-results-found heading-color"> <h5>';
								  _e("No results found.",'Soundblast');
						  echo ' </h5></div>';
					  }
				  }
		}
	}
}
// Home page album
function cs_get_home_player(){
	global $cs_theme_option;
	if($cs_theme_option['album_name'] <> ''){
	$album_id='';
	$args=array(
		'name' => $cs_theme_option['album_name'],
		'post_type' => 'albums',
		'post_status' => 'publish',
		'showposts' => 1,
	  );
	  $get_posts = get_posts($args);
	  if($get_posts){
		  $album_id = $get_posts[0]->ID;
	  }
	$cs_album = get_post_meta($album_id, "cs_album", true);
	if ( $cs_album <> "" ) {
	?>
    <script type="text/javascript">
	   jQuery(document).ready(function() {
			cs_playlist_toggle();
		 });
    </script>
    <!-- Audio Plyer Strat -->
     <div class="audio-plyer webkit">
            <div class="container">
                <div id="player">
                    <div id="jquery_jplayer_n" class="jp-jplayer"></div>
                    <div id="jp_container_n" class="jp-audio">
                        <div class="jp-type-playlist">
                            <div class="jp-gui">
                            	<div class="jp-playlist " id="playheader">
                                <div class="wrapper-payerlsit">
                                <ul>
                                    <!-- The method Playlist.displayPlaylist() uses this unordered list -->                    
                                    <li></li>
                                </ul>
                                </div>
                            </div>
                                <div class="jp-interface">
                                    <div class="jp-controls-holder">
                                        <ul class="jp-controls audio-control">
                                            <li>
                                                <a href="javascript:;" class="jp-previous" tabindex="1"> <em class="fa fa-backward"></em>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="javascript:;" class="jp-play" tabindex="1"> <em class="fa fa-play"></em>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="javascript:;" class="jp-pause" tabindex="1">
                                                    <em class="fa fa-pause"></em>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="javascript:;" class="jp-next" tabindex="1">
                                                    <em class="fa fa-forward"></em>
                                                </a>
                                            </li>
                                        </ul>

                                        <div class="main-progress">
                                            
                                            <div class="jp-current-time"></div>
                                            <div class="jp-progress">
                                                <div class="jp-seek-bar">
                                                    <div class="jp-play-bar bgcolr"></div>
                                                </div>
                                            </div>
                                            <div class="jp-duration"></div>
                                            <div class="volume-wrap">
                                                <a title="mute" tabindex="1" class="jp-mute" href="javascript:;"><em class="fa fa-volume-down"></em></a>
                                                <a title="unmute" tabindex="1" class="jp-unmute" href="javascript:;" style="display: none;"><em class="fa fa-volume-off"></em></a>
                                                <div class="jp-volume-bar">
                                                    <div class="jp-volume-bar-value bgcolr" style="width: 80%;"></div>
                                                </div>
                                                <a title="max volume" tabindex="1" class="jp-volume-max" href="javascript:;"><em class="fa fa-volume-up"></em></a>
                                            </div>
                                            <ul class="jp-toggles">
                                            	<li>
                                            		<a href="javascript:;" class="jp-shuffle" tabindex="1" title="shuffle"><i class="fa fa-random"></i></a>
                                            	</li>
                                            	<li>
                                            		<a href="javascript:;" class="jp-shuffle-off" tabindex="1" title="shuffle off"><i class="fa fa-random"></i></a>
                                            	</li>
                                            	<li>
                                            		<a href="javascript:;" class="jp-repeat" tabindex="1" title="repeat"><i class="fa fa-repeat"></i></a>
                                            	</li>
                                            	<li>
                                            		<a href="javascript:;" class="jp-repeat-off" tabindex="1" title="repeat off"><i class="fa fa-rotate-left"></i></a>
                                            	</li>
                                            	<li><a href="#playheader" class="jp-playlist-icon btntoggle webkit"><em class="fa fa-align-justify"></em></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="clear"></div>
   <!-- Audio Plyer End -->
    <?php
		
		 
		$cs_xmlObject = new SimpleXMLElement($cs_album);
			 $counter_load_tracks = count($cs_xmlObject->track);
			 if($counter_load_tracks >0){
			 $playtracks = '';
			 cs_enqueue_jplayer();
			 	 foreach ( $cs_xmlObject->track as $track ){
							$filetype = wp_check_filetype($track->album_track_mp3_url);
							if(isset($track->album_track_playable) && $track->album_track_playable == 'Yes' && $filetype['ext'] == 'mp3'){
								$counter_load_tracks++;
								$playtracks .= '{
											title:"'.$track->album_track_title.'",
											mp3:"'.$track->album_track_mp3_url.'",
											downloadurl:"'.$track->album_track_mp3_url.'",
											soundcloud:"'.$track->album_track_mp3_url.'"
										},';
							}
			 	}
			}
		
			?>
	<script>
        jQuery(document).ready(function($) {
            var myPlaylist = new jPlayerPlaylist({
            jPlayer: "#jquery_jplayer_n",
            cssSelectorAncestor: "#jp_container_n"
        }, [
            <?php echo $playtracks;?>

        ], {
            swfPath: "js",
            supplied: "mp3",
            wmode: "window",
            smoothPlayBar: true,
            keyEnabled: true
        });
          
        });
    </script>
   <?php
	}}
}
// Pages Subheader Section at front end //
function cs_get_subheader(){
	if(function_exists("is_woocommerce")){
		if(is_shop()){
		$cs_shop_id = woocommerce_get_page_id( 'shop' );
	?>
    	<div class="breadcrumb">
         <div class="container">
         	<h1 class="cs-page-title"><?php echo get_the_title($cs_shop_id); ?></h1><div class="devider-1"></div>
			<?php
			$cs_meta_page = cs_meta_shop_page('cs_page_builder', $cs_shop_id);
			if(isset($cs_meta_page)){
				if ( $cs_meta_page->page_headline_text <> "" ) {
					echo "<p>".$cs_meta_page->page_headline_text."</p>";
				}
			}
            ?>
         </div>
        </div>
    <?php
		}
	}
 	?>	
 		<div class="breadcrumb">
         <div class="container">
			<?php
			if(function_exists("is_shop")){
				if(!is_shop()){
					cs_get_subheader_title();
				}
			}else{
				cs_get_subheader_title();
			}
            
			$cs_meta_page = cs_meta_page('cs_page_builder');
			if(isset($cs_meta_page)){
				if ( $cs_meta_page->page_headline_text <> "" ) {
					echo "<p>".$cs_meta_page->page_headline_text."</p>";
				}
			}
            ?>
         </div>
        </div>
        
    <?php

}
// Page Sub header title and subtitle //
function cs_get_subheader_title(){
	global $post;
  	?>
		<?php 
			if (is_page() || is_single()) {
					if (is_page()){
						echo '<h1 class="cs-page-title">' . get_the_title() . '</h1><div class="devider-1"></div>';
					}
		  } else { ?>
             <h1 class="cs-page-title"><?php cs_post_page_title(); ?></h1>
             <div class="devider-1"></div>
		 <?php }?> 
    <?php
}

/*------Header Functions End------*/
// password protect post/page
if ( ! function_exists( 'cs_password_form' ) ) {
	function cs_password_form() {
		global $post,$cs_theme_option;
		$label = 'pwbox-'.( empty( $post->ID ) ? rand() : $post->ID );
		$o = '<div class="password_protected">
				<div class="password-content">
                    <div class="protected-icon"><a href="#"><i class="fa fa-unlock-alt fa-4x"></i></a></div>
					<h3>' . __( "This post is password protected. To view it please enter your password below:",'Soundblast' ) . '</h3>';
		$o .= '<form action="' . esc_url( site_url( 'wp-login.php?action=postpass', 'login_post' ) ) . '" method="post">
					<label><input name="post_password" id="' . $label . '" type="text" value="' . __( "Password",'Soundblast' ) . '"/></label>
					<label class="before-icon"><input class="backcolr" type="submit" name="submit" value="" /></label>
				</form>
			  </div>
			</div>';
		return $o;
	}
}
//////////////// Header Cart ///////////////////
function woocommerce_header_add_to_cart_fragment( $fragments ) {
	if ( class_exists( 'woocommerce' ) ){
		global $woocommerce;
		ob_start();
		?>
		<div class="cart-secc">
			<span class="cart-qnt"><?php echo $woocommerce->cart->cart_contents_count; ?></span><a class="cs-amount" href="<?php echo $woocommerce->cart->get_cart_url(); ?>"><i class="fa fa-shopping-cart"></i><?php echo $woocommerce->cart->get_cart_total(); ?></a>
		</div>
		<?php
		$fragments['div.cart-secc'] = ob_get_clean();
		return $fragments;
	}
}


function cs_woocommerce_header_cart() {
	if ( class_exists( 'woocommerce' ) ){
		global $woocommerce;
		?>
		<div class="cart-secc">
			<span class="cart-qnt"><?php echo $woocommerce->cart->cart_contents_count; ?></span><a class="cs-amount" href="<?php echo $woocommerce->cart->get_cart_url(); ?>"><i class="fa fa-shopping-cart"></i><?php echo $woocommerce->cart->get_cart_total(); ?></a>
		</div>
		<?php
	}
}
//////////////// Header Cart Ends ///////////////////
/* Add specific id in Menu */
function cs_add_menuid($ulid) {
	return preg_replace('/<ul>/', '<ul id="menus">', $ulid, 1);
}
/* remove specific div in Menu */
function cs_remove_div ( $menu ){
    return preg_replace( array( '#^<div[^>]*>#', '#</div>$#' ), '', $menu );
}
function cs_register_my_menus() {
  register_nav_menus(
	array(
		'main-menu'  => __('Main Menu','Soundblast')
 	)
  );
}
/* add filter for parent css in Menu */
function cs_add_parent_css($classes, $item) {
    global $menu_children;
    if ($menu_children)
        $classes[] = 'parent';
    return $classes;
}
// search varibales start
function cs_get_search_results($query) {
	if ( !is_admin() and (is_search())) {
		$query->set( 'post_type', array('post', 'events' ) );
		remove_action( 'pre_get_posts', 'cs_get_search_results' );
	}
}
function cs_change_query_vars($query) {
    if (is_search()|| is_home()) {
        if (empty($_GET['page_id_all']))
            $_GET['page_id_all'] = 1;
       $query->query_vars['paged'] = $_GET['page_id_all'];
	   return $query;
	}
	 // Return modified query variables
}
// Filter shortcode in text areas
if ( ! function_exists( 'cs_textarea_filter' ) ) {
	function cs_textarea_filter($content=''){
		return do_shortcode($content);
	}
}
/* Display navigation to next/previous for single.php */
if ( ! function_exists( 'cs_next_prev_post' ) ) { 
	function cs_next_prev_post(){
	global $post;
	posts_nav_link();
	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( $post->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );
	if ( ! $next && ! $previous )
		return;
	?>
    	<div class="post-btn">
 			<?php 
				previous_post_link( '%link', '<i class="fa fa-angle-left fa-1x"></i>' ); 
				next_post_link( '%link','<i class="fa fa-angle-right fa-1x"></i>' );
			 ?>
		</div>
	<?php
	}
}
/*	Add Featured/sticky text/icon for sticky posts. */
if ( ! function_exists( 'cs_featured()' ) ) {
	function cs_featured(){
		if ( is_sticky() ){ ?>
			<ul><li class="featured"><i class="fa fa-thumb-tack"></i></li></ul>
		<?php
		}
	}
}
// Custom excerpt function 
function cs_get_the_excerpt($limit='255',$readmore = '') {
	global $cs_theme_option;
    $get_the_excerpt = trim(preg_replace('/<a[^>]*>(.*)<\/a>/iU', '', get_the_excerpt()));
    echo substr($get_the_excerpt, 0, "$limit");
    if (strlen($get_the_excerpt) > "$limit") {
		if($readmore == "true"){
        	echo '... <a href="' . get_permalink() . '" class="colr">' . $cs_theme_option['trans_read_more'] . '</a>';
		}
    }
}
/* register custom sidebar */
$cs_theme_option = get_option('cs_theme_option');
if ( isset($cs_theme_option['sidebar']) and !empty($cs_theme_option['sidebar'])) {
	foreach ( $cs_theme_option['sidebar'] as $sidebar ){
		register_sidebar(array(
			'name' => $sidebar,
			'id' => $sidebar,
			'description' => 'This widget will be displayed on side of the page.',
			'before_widget' => '<div class="widget %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<header class="cs-heading-title"><h2 class="cs-section-title cs-heading-color">',
			'after_title' => '</h2></header>'
		));
	}
}
/* register footer widget */
register_sidebar( array(
	'name' => 'Footer Widget',
	'id' => 'footer-widget',
	'description' => 'This Widget Show the Content in Footer Area.',
	'before_widget' => '<div class="widget %2$s">',
	'after_widget' => '</div>',
	'before_title' => '<header class="cs-heading-title"><h2 class="cs-section-title cs-heading-color">',
	'after_title' => '</h2></header>'
) );
/* flexslider function */
if ( ! function_exists( 'cs_flex_slider' ) ) {
	function cs_flex_slider($width,$height,$slider_id){
		global $cs_node,$cs_theme_option,$counter_node;
		$counter_node++;
		if($slider_id == ''){
			$slider_id = $cs_node->slider;
		}
		if($cs_theme_option['flex_auto_play'] == 'on'){$auto_play = 'true';}
			else if($cs_theme_option['flex_auto_play'] == ''){$auto_play = 'false';}
			$cs_meta_slider_options = get_post_meta($slider_id, "cs_meta_slider_options", true); 
		?>
		<!-- Flex Slider -->
		<div id="flexslider<?php echo $counter_node; ?>" class="<?php if(isset($cs_theme_option['cs_slider_view'])){ echo $cs_theme_option['cs_slider_view']; } ?>">
		  <div class="flexslider">
			  <ul class="slides">
				<?php 
					$counter = 1;
					$cs_xmlObject_flex = new SimpleXMLElement($cs_meta_slider_options);
					foreach ( $cs_xmlObject_flex->children() as $as_node ){
						
 						$image_url = cs_attachment_image_src($as_node->path,$width,$height); 
						?>
						<li>
                        	<span class="bg-pattren"></span>
							<img src="<?php echo $image_url ?>" alt="" />
							<!-- Caption Start -->
							<?php 
								if($as_node->title != '' && $as_node->description != '' || $as_node->title != '' || $as_node->description != ''){ 
								$as_node->cs_slider_link ="";
								if($as_node->link <> ''){}
								
							?>
                            <div class="caption">
								
                                   <h1><?php echo $as_node->title; ?></h1>
                                   <div class="devider-1"></div>
                                	<?php
									if($as_node->description <> ''){	
                                    ?>
                                    <p><?php echo $as_node->description;?></p>
                                <?php }?>
                                <div class="clear"></div>
                                <a href="#">View detail</a>
                        </div>
                        <!-- Caption End -->
                        <?php } ?>
						</li>
					<?php 
					$counter++;
					}
				?>
			  </ul>
		  </div>
		</div>
		<?php cs_enqueue_flexslider_script(); ?>
 		<!-- Flex Slider Javascript Files -->
		<script type="text/javascript">
			jQuery(window).load(function(){
				var speed = <?php echo $cs_theme_option['flex_animation_speed']; ?>; 
				var slidespeed = <?php echo $cs_theme_option['flex_pause_time']; ?>;
				jQuery('#flexslider<?php echo $counter_node; ?> .flexslider').flexslider({
					animation: "<?php echo $cs_theme_option['flex_effect']; ?>", // fade
					slideshow: <?php echo $auto_play;?>,
					slideshowSpeed:speed,
					animationSpeed:slidespeed
					
				});
			});
		</script>
	<?php
	}
}
/*  Social Share Function */
if ( ! function_exists( 'cs_social_share' ) ) {
	function cs_social_share($icon_type = '', $title='true') {
		global $cs_theme_option;
		$share = '';
		cs_addthis_script_init_method();
		if($icon_type=='small'){
			$icon = 'icon';
		} else {
			$icon = 'icon';
		}
		$html = '';
		$pageurl = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
		$path = get_template_directory_uri() . "/images/admin/";
		$html ='<div class="social-network backcolr">';
			if (isset($cs_theme_option['cs_other_share']) && $cs_theme_option['cs_other_share'] == 'on') {
				$html .= '<h6>';
					if($cs_theme_option["trans_switcher"] == "on") { $share .= __("Share this post",'Soundblast'); }else{  $share =  $cs_theme_option["trans_share_this_post"];}
					$html .='<a class="addthis_button_compact fa fa-share-square-o"><span>'.$share.'</span></a>';
				$html .= '</h6>';
			}
 			$html .='</div>';
			echo $html;
	}
}
/* Social network */
if ( ! function_exists( 'cs_social_network' ) ) {
	function cs_social_network($tooltip='', $icon=''){
		global $cs_theme_option;
		$tooltip_data='';
		echo '<div class="social-network">';
		if(isset($cs_theme_option['social_net_title']) && $cs_theme_option['social_net_title'] <> ''){
			echo '<h5>';
				echo $cs_theme_option['social_net_title'];
			echo '</h5>';
		}
				if(isset($tooltip) && $tooltip <> ''){
					$tooltip_data='data-placement-tooltip="tooltip"';
				}
				if ( isset($cs_theme_option['social_net_url']) and count($cs_theme_option['social_net_url']) > 0 ) {
						$i = 0;
						foreach ( $cs_theme_option['social_net_url'] as $val ){
							?>
					<?php if($val != ''){?><a title="" href="<?php echo $val;?>" data-original-title="<?php echo $cs_theme_option['social_net_tooltip'][$i];?>" data-placement="top" <?php echo $tooltip_data;?> class="colrhover"  target="_blank"><?php if($cs_theme_option['social_net_awesome'][$i] <> '' && isset($cs_theme_option['social_net_awesome'][$i])){?><i class="fa <?php echo $cs_theme_option['social_net_awesome'][$i];?> <?php echo $icon;?>"></i><?php } else {?><img src="<?php echo $cs_theme_option['social_net_icon_path'][$i];?>" alt="<?php echo $cs_theme_option['social_net_tooltip'][$i];?>" /><?php }?></a><?php }
							
						$i++;}
		}
		echo '</div>';
	}
}
/* breadcrumb function */
if ( ! function_exists( 'cs_breadcrumbs' ) ) { 
	function cs_breadcrumbs() {
		global $wp_query, $cs_theme_option;
		/* === OPTIONS === */
		$text['home']     = 'Home'; // text for the 'Home' link
		$text['category'] = '%s'; // text for a category page
		$text['search']   = '%s'; // text for a search results page
		$text['tag']      = '%s'; // text for a tag page
		$text['author']   = '%s'; // text for an author page
		$text['404']      = 'Error 404'; // text for the 404 page
	
		$showCurrent = 1; // 1 - show current post/page title in breadcrumbs, 0 - don't show
		$showOnHome  = 1; // 1 - show breadcrumbs on the homepage, 0 - don't show
		$delimiter   = ''; // delimiter between crumbs
		$before      = '<li class="cs-active">'; // tag before the current crumb
		$after       = '</li>'; // tag after the current crumb
		/* === END OF OPTIONS === */
	
		global $post;
		$homeLink = home_url() . '/';
		$linkBefore = '<li>';
		$linkAfter = '</li>';
		$linkAttr = '';
		$link = $linkBefore . '<a' . $linkAttr . ' href="%1$s">%2$s</a>' . $linkAfter;
		$linkhome = $linkBefore . '<a' . $linkAttr . ' href="%1$s"><i class="icon-home"></i>%2$s</a>' . $linkAfter;
		if($cs_theme_option['trans_switcher'] == "on"){ $current_page = __('Current Page','Soundblast');}else{ $current_page = $cs_theme_option['trans_current_page']; }
		if (is_home() || is_front_page()) {
	
			if ($showOnHome == "1") echo '<div class="breadcrumbs"><ul>'.$before.'<a href="' . $homeLink . '"><i class="icon-home"></i>' . $text['home'] . '</a>'.$after.'</ul></div>';
	
		} else {
			echo '<div class="breadcrumbs"><ul>' . sprintf($linkhome, $homeLink, $text['home']) . $delimiter;
			if ( is_category() ) {
				$thisCat = get_category(get_query_var('cat'), false);
				if ($thisCat->parent != 0) {
					$cats = get_category_parents($thisCat->parent, TRUE, $delimiter);
					$cats = str_replace('<a', $linkBefore . '<a' . $linkAttr, $cats);
					$cats = str_replace('</a>', '</a>' . $linkAfter, $cats);
					echo $cats;
				}
				echo $before . sprintf($text['category'], single_cat_title('', false)) . $after;
			} elseif ( is_search() ) {
				echo $before . sprintf($text['search'], get_search_query()) . $after;
			} elseif ( is_day() ) {
				echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter;
				echo sprintf($link, get_month_link(get_the_time('Y'),get_the_time('m')), get_the_time('F')) . $delimiter;
				echo $before . get_the_time('d') . $after;
			} elseif ( is_month() ) {
				echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter;
				echo $before . get_the_time('F') . $after;
			} elseif ( is_year() ) {
				echo $before . get_the_time('Y') . $after;
			} elseif ( is_single() && !is_attachment() ) {
				if ( get_post_type() != 'post' ) {
					$post_type = get_post_type_object(get_post_type());
					$slug = $post_type->rewrite;
					printf($link, $homeLink . '/' . $slug['slug'] . '/', $post_type->labels->singular_name);
					if ($showCurrent == 1) echo $delimiter . $before . $current_page . $after;
				} else {
					$cat = get_the_category(); $cat = $cat[0];
					$cats = get_category_parents($cat, TRUE, $delimiter);
					if ($showCurrent == 0) $cats = preg_replace("#^(.+)$delimiter$#", "$1", $cats);
					$cats = str_replace('<a', $linkBefore . '<a' . $linkAttr, $cats);
					$cats = str_replace('</a>', '</a>' . $linkAfter, $cats);
					echo $cats;
					if ($showCurrent == 1) echo $before .$current_page . $after;
				}
			} elseif ( !is_single() && !is_page() && get_post_type() <> '' && get_post_type() != 'post' && get_post_type() <> 'events' && get_post_type() <> 'cs_menu' && !is_404() ) {
					$post_type = get_post_type_object(get_post_type());
					echo $before . $post_type->labels->singular_name . $after;
			} elseif (isset($wp_query->query_vars['taxonomy']) && !empty($wp_query->query_vars['taxonomy'])){
				$taxonomy = $taxonomy_category = '';
				$taxonomy = $wp_query->query_vars['taxonomy'];
				echo $before . $wp_query->query_vars[$taxonomy] . $after;

			}elseif ( is_page() && !$post->post_parent ) {
				if ($showCurrent == 1) echo $before . get_the_title() . $after;
	
			} elseif ( is_page() && $post->post_parent ) {
				$parent_id  = $post->post_parent;
				$breadcrumbs = array();
				while ($parent_id) {
					$page = get_page($parent_id);
					$breadcrumbs[] = sprintf($link, get_permalink($page->ID), get_the_title($page->ID));
					$parent_id  = $page->post_parent;
				}
				$breadcrumbs = array_reverse($breadcrumbs);
				for ($i = 0; $i < count($breadcrumbs); $i++) {
					echo $breadcrumbs[$i];
					if ($i != count($breadcrumbs)-1) echo $delimiter;
				}
				if ($showCurrent == 1) echo $delimiter . $before . get_the_title() . $after;
	
			} elseif ( is_tag() ) {
				echo $before . sprintf($text['tag'], single_tag_title('', false)) . $after;
	
			} elseif ( is_author() ) {
				global $author;
				$userdata = get_userdata($author);
				echo $before . sprintf($text['author'], $userdata->display_name) . $after;
	
			} elseif ( is_404() ) {
				echo $before . $text['404'] . $after;
			}
			
			//echo "<pre>"; print_r($wp_query->query_vars); echo "</pre>";
			if ( get_query_var('paged') ) {
				// if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ' (';
				// echo __('Page') . ' ' . get_query_var('paged');
				// if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ')';
			}
			echo '</ul></div>';
	
		}
	}
}
// Front End Functions END