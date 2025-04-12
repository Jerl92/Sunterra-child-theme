<?php 

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$child_template_directory = get_stylesheet_directory();

function add_scripts() {
    // wp_enqueue_script('webccam', get_stylesheet_directory_uri() . '/js/webcam.js' , array('jquery'));
    wp_enqueue_style('dashicons');
    wp_enqueue_script('ftscroller', get_stylesheet_directory_uri() . '/js/ftscroller.js' , array('jquery'));
    wp_enqueue_script('google-jsapi', get_stylesheet_directory_uri() . '/js/gmap.js', array('jquery'));
    wp_enqueue_script('jquery.resize', get_stylesheet_directory_uri() . '/js/jquery.resize.js' , array('jquery'));
    wp_enqueue_script('sunterra', get_stylesheet_directory_uri() . '/js/sunterra.js' , array('jquery'));
}
add_action('get_footer', 'add_scripts'); 

function my_pre_get_posts($query) {
    $current_user = wp_get_current_user();

    if( is_admin() ) 
        return;

    if( is_search() && $query->is_main_query() ) {
		$query->set('post_type', 'nanosupport');
        $query->set('post_status', 'any');
        if( current_user_can('administrator') || current_user_can('ticket-agent') ) {
        } else {
            $query->set('author', $current_user->ID);
        }
    } 
}
add_action( 'pre_get_posts', 'my_pre_get_posts' );

/**
 * KB Pagination
 */ 
function change_posttype_child() {
  if( ( is_search() || !is_admin() ) && is_tax( 'st_kb_category' ) ) {
    set_query_var( 'post_type', array('nanosupport' , 'st_kb'));
  }
  return;
}
add_action( 'parse_query', 'change_posttype_child' );

/* ========================================
 * SEARCH CUSTOM POST TYPES
 * ======================================== */

function cf_search_join( $join ) {
    global $wpdb;

        if ( is_search() && !is_admin() ) {    
            $join .=' LEFT JOIN '.$wpdb->postmeta. ' ON '. $wpdb->posts . '.ID = ' . $wpdb->postmeta . '.post_id ';
        }

    return $join;
}
add_filter('posts_join', 'cf_search_join' );

/**
 * Modify the search query with posts_where
 *
 * http://codex.wordpress.org/Plugin_API/Filter_Reference/posts_where
 */
function cf_search_where( $where ) {
    global $wpdb;

        if ( is_search() ) {
            $where = preg_replace(
                "/\(\s*".$wpdb->posts.".post_title\s+LIKE\s*(\'[^\']+\')\s*\)/",
                "(".$wpdb->posts.".post_title LIKE $1) OR (".$wpdb->postmeta.".meta_value LIKE $1)", $where );
        }

    return $where;
}
add_filter( 'posts_where', 'cf_search_where' );


function cf_search_distinct( $where ) {
    global $wpdb;

    if ( is_search() ) {
        return "DISTINCT";
    }

    return $where;
}
add_filter( 'posts_distinct', 'cf_search_distinct' );

/**
 * Include posts from authors in the search results where
 * either their display name or user login matches the query string
 *
 * @author danielbachhuber
 */
add_filter( 'posts_search', 'db_filter_authors_search' );
function db_filter_authors_search( $posts_search ) {
	// Don't modify the query at all if we're not on the search template
	// or if the LIKE is empty
	if ( !is_search() || empty( $posts_search ) )
		return $posts_search;
	global $wpdb;
	// Get all of the users of the blog and see if the search query matches either
	// the display name or the user login
	add_filter( 'pre_user_query', 'db_filter_user_query' );
	$search = sanitize_text_field( get_query_var( 's' ) );
	$args = array(
		'count_total' => false,
		'search' => sprintf( '*%s*', $search ),
		'search_fields' => array(
			'display_name',
			'user_login',
		),
		'fields' => 'ID',
	);
	$matching_users = get_users( $args );
	remove_filter( 'pre_user_query', 'db_filter_user_query' );
	// Don't modify the query if there aren't any matching users
	if ( empty( $matching_users ) )
		return $posts_search;
	// Take a slightly different approach than core where we want all of the posts from these authors
	$posts_search = str_replace( ')))', ")) OR ( {$wpdb->posts}.post_author IN (" . implode( ',', array_map( 'absint', $matching_users ) ) . ")))", $posts_search );
	return $posts_search;
}
/**
 * Modify get_users() to search display_name instead of user_nicename
 */
function db_filter_user_query( &$user_query ) {
	if ( is_object( $user_query ) )
		$user_query->query_where = str_replace( "user_nicename LIKE", "display_name LIKE", $user_query->query_where );
	return $user_query;
}

function my_custom_fonts() {
  echo '<style>
    @media (min-width: 1194px) {    
        #poststuff #post-body.columns-2 #side-sortables {
            width: 530px;
        }
        #poststuff #post-body.columns-2 {
            margin-right: 550px;
        }
    }
    #adminmenu .wp-menu-image-admin img {
        padding: 5px 5px 0;
        background-size: contain;
    }
    .alternate, .striped>tbody>:nth-child(odd), ul.striped>:nth-child(odd) {
        background-color: #dedede;
    }
	#updraft-dashnotice {
		display: none;
    }
  </style>';
}
add_action('admin_head', 'my_custom_fonts');

function remove_um_profile_navbar() {
    remove_action('um_profile_navbar', 'um_profile_navbar', 9 );
}
add_action('init','remove_um_profile_navbar');

function nanosupport_before_support_desk_post_filters() { 
     ?>
    <form class='post-filters rma-filters'>
        <select name="orderby">
            <?php
                if (qtranxf_getLanguage() == 'fr') {
                    $orderby_options = array(
                        'date' => 'Ranger Par Date',
                        'modified' => 'Ranger Par Dernière Modification',
                        'last_comment' => 'Ranger Par Dernière Réponse',
                        'post_title' => 'Ranger Par Nom de Model',
                    );
                }
                if (qtranxf_getLanguage() == 'en') {
                    $orderby_options = array(
                        'date' => 'Order By Date',
                        'modified' => 'Order By last Modification',
                        'last_comment' => 'Order By last response',
                        'post_title' => 'Order By Model',
                    );
                }
                foreach( $orderby_options as $value => $label ) {
                    echo "<option ".selected( $_GET['orderby'], $value )." value='$value'>$label</option>";
                }
            ?>
        </select>
        <?php
            $status_terms = get_terms( array(
            'taxonomy' => 'nanosupport_status',
            'hide_empty' => true,
        ) );
        global $current_user;
        if( current_user_can('administrator') || current_user_can('ticket-agent') ) {
            $query = array(
                'post_type' 	=> 'nanosupport',
                'posts_per_page' => -1,
                'order'     	=> 'DESC',
                'orderby'       => 'modified',
                'post_status'   => 'any'
            );
        } else {
            $query = array(
                'post_type' 	=> 'nanosupport',
                'posts_per_page' => -1,
                'order'     	=> 'DESC',
                'orderby'       => 'modified',
                'author'        =>  $current_user->ID,
                'post_status'   => 'any'
            );
        }
        $loop = get_posts($query);
        $count_status_values['all'] .= count($loop);
        if($_GET['status'] && $_GET['status'] != 'all'){
            if ( $status_terms ) { 
                foreach ( $status_terms as $status_term ) {
                    if($status_term->slug == $_GET['status']){
                        $get_term_color = get_term_meta($status_term->term_id, 'meta_color', true); 
                        ?><select id="status_selecte_filters" style="background-color: <?php echo $get_term_color ?>" name="status"><?php
                    }
                }
            }
        } else {
            ?><select id="status_selecte_filters" name="status"><?php
        }

                if (qtranxf_getLanguage() == 'en') {
                    $ticket_status_values['all'] .= 'All Status';
                }
                if (qtranxf_getLanguage() == 'fr') {
                    $ticket_status_values['all'] .= 'Touts les Status';
                }
                $color_status_values['all'] .= '#c8c7c7';

                if ( $status_terms ) { 
                    foreach ( $status_terms as $status_term ) { 
                        $lang_text_term = qtranxf_use(qtranxf_getLanguage(), $status_term->name);		
                        if( current_user_can('administrator') || current_user_can('ticket-agent') ) {			
                            $query_ = array( 
                                'post_type' 	=> 'nanosupport',
                                'posts_per_page' => -1,
                                'order'     	=> 'DESC',
                                'orderby'       => 'modified',
                                'post_status'   => 'any',
                                'tax_query' => array(
                                    array(
                                    'taxonomy' => 'nanosupport_status',
                                    'field' => 'slug',
                                    'terms' => array($status_term->slug)
                                    )
                                )
                            );
                        } else {
                            $query_ = array( 
                                'post_type' 	=> 'nanosupport',
                                'posts_per_page' => -1,
                                'order'     	=> 'DESC',
                                'orderby'       => 'modified',
                                'author'        =>  $current_user->ID,
                                'post_status'   => 'any',
                                'tax_query' => array(
                                    array(
                                    'taxonomy' => 'nanosupport_status',
                                    'field' => 'slug',
                                    'terms' => array($status_term->slug)
                                    )
                                )
                            );
                        }
						$posts = get_posts($query_);
						if (count($posts) >= 1 ) {
                            echo count($posts).'</br>';
                            $count_status_values[$status_term->slug] = count($posts);
                            $get_term_color = get_term_meta($status_term->term_id, 'meta_color', true); 
                            $color_status_values[$status_term->slug] = $get_term_color;
                            $ticket_status_values[$status_term->slug] = $lang_text_term;
                        }
                    }
                }

                foreach( $ticket_status_values as $value => $label ) {
                    echo "<option class='ticket_status' style='background-color:".$color_status_values[$value]."'".selected( $_GET['status'], $value )." value='".$value."'>".$label." ".$count_status_values[$value]."</option>";
                }
            ?>
        </select>
        <select name="perpage">
            <?php
                if (qtranxf_getLanguage() == 'en') {
                    $perpage_options = array(
                        '10' => '10 Per Page',
                        '25' => '25 Per Page',
                        '50' => '50 Per Page',
                        '75' => '75 Per Page',
                        '100' => '100 Per Page',
                    );
                }
                if (qtranxf_getLanguage() == 'fr') {
                    $perpage_options = array(
                        '10' => '10 Par Page',
                        '25' => '25 Par Page',
                        '50' => '50 Par Page',
                        '75' => '75 Par Page',
                        '100' => '100 Par Page',
                    );
                }
                foreach( $perpage_options as $value => $label ) {
                    echo "<option ".selected( $_GET['perpage'], $value )." value='$value'>$label</option>";
                }
            ?>
        </select>
        <?php if (qtranxf_getLanguage() == 'en') { ?>
            <input type='submit' value='<?php _e('Filter', 'framework') ?>'>
        <?php } ?>
        <?php if (qtranxf_getLanguage() == 'fr') { ?>
            <input type='submit' value='<?php _e('Ranger', 'framework') ?>'>
        <?php } ?>
    </form>
<?php }

add_action('nanosupport_before_support_desk', 'nanosupport_before_support_desk_post_filters'); 


function ns_support_desk_page_search($post) {
	
	echo '<div id="nanosupport-desk" class="ns-no-js">';

    global $current_user; 
    //Get the NanoSupport Settings from Database
    $ns_general_settings = get_option( 'nanosupport_settings' );
    $highlight_choice	 = 'status';

        //Get ticket information
        $ticket_meta 	 = ns_get_ticket_meta( $post );
        $meta_data_additional_status = get_post_meta( $post, '_ns_internal_additional_status', true );
        $highlight_class = 'priority' === $highlight_choice ? $ticket_meta['priority']['class'] : $ticket_meta['status']['class'];

        $term_list = wp_get_post_terms($post, 'nanosupport_status', array("fields" => "all"));
        $get_term_color = get_term_meta($term_list[0]->term_id, 'meta_color', true);
        ?>

        <div class="ticket-cards ns-cards <?php echo esc_attr($highlight_class); ?>" style="border-color: <?php echo $get_term_color ?>">
            <div class="ns-row">
                <div class="ns-col-sm-4 ns-col-xs-12">
                    <h3 class="ticket-head ticket-title-shadow">

                        <?php if( 'pending' === $ticket_meta['status']['value'] ) : ?>
                            <?php if( ns_is_user('agent_and_manager') ) : ?>
                                <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" style="color: <?php echo $get_term_color; ?>">
                                    <?php the_title(); ?>
                                </a>
                            <?php else : ?>
                                <?php the_title(); ?>
                            <?php endif; ?>
                        <?php else : ?>
                            <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" style="color: <?php echo $get_term_color; ?>">
                                <?php the_title(); ?>
                            </a>
                        <?php endif; ?>

                        <?php if( ns_is_user('agent_and_manager') ) : ?>
                            <span class="ticket-tools">
                                <?php edit_post_link( 'Edit', '', '', get_the_ID() ); ?>
                                <a class="ticket-view-link" href="<?php echo esc_url(get_the_permalink()); ?>" title="<?php esc_attr_e( 'Permanent link to the Ticket', 'nanosupport' ); ?>">
                                    <?php _e( 'View', 'nanosupport' ); ?>
                                </a>
                            </span> <!-- /.ticket-tools -->
                        <?php endif; ?>
                    </h3>

                    <div class="text-blocks">
                        <strong><?php _e( 'Form Factor', 'nanosupport' ); ?>: </strong><?php echo $lang_text_term; ?>
                    </div>
                    
                    <div class="text-blocks">
                        <strong><?php _e( 'S/N', 'nanosupport' ); ?>: </strong><?php echo esc_attr( get_post_meta( get_the_ID(), '_ns_ticket_serial_number', true )); ?>
                    </div>
                    
                    <?php $get_rma_number = get_post_meta( get_the_ID(), 'ns_internal_rma_number', true );

                    if ( $get_rma_number ) { ?>
                        <div class="text-blocks">
                                <strong><?php _e( 'RMA Number', 'nanosupport' ); ?>:</strong>
                                <?php echo esc_attr( $get_rma_number ); ?>
                        </div>
                    <?php } //endif ?>

                    <div class="text-blocks">
                            <strong><?php _e( 'Inovice Number', 'nanosupport' ); ?>:</strong>
                            <?php echo esc_attr( get_post_meta( get_the_ID(), '_ns_ticket_inovice_number', true )); ?>
                    </div>
                    
                    <div class="text-blocks">
                        <strong><?php _e( 'Issuse/Defective Part', 'nanosupport' ); ?>: </strong><?php echo esc_attr( get_post_meta( get_the_ID(), '_ns_ticket_issuse', true )); ?>
                    </div>

                </div>

                <div class="ns-col-sm-8 ns-col-xs-12 ticket-meta">
                    <div class="text-blocks">
                        <strong><?php _e( 'Ticket Status:', 'nanosupport' ); ?></strong></br>
                        <?php echo $ticket_meta['status']['label']; ?>
                        <?php if ($meta_data_additional_status != '') { ?>
                            <span class="ns-label ns-label-status-additional">
                                <?php echo $meta_data_additional_status; ?>
                            </span>
                        <?php } //endif ?>
                    </div>
                </div>

                <div class="ns-col-sm-4 ns-col-xs-12 ticket-meta">

                    <?php $get_term_shipping = get_term_meta($term_list[0]->term_id, 'meta_shipping', true);
                    if ( $get_term_shipping == 1 ) { ?>		

                        <div class="text-blocks">
                            <?php if ( get_post_meta( get_the_ID(), '_ns_ticket_traking_number', true ) != '' ) : ?>
                                <strong><p><?php _e( 'Traking Number', 'nanosupport' ); ?>:</p></strong><br>
                                <?php echo esc_attr( get_post_meta( get_the_ID(), '_ns_ticket_traking_number', true )); ?>
                            <?php endif; ?>										
                        </div>

                    <?php } elseif ( $get_term_shipping == 2 ) { ?>

                        <div class="text-blocks">	
                            <strong><?php _e( 'Need a pickup', 'nanosupport' ); ?>?</strong><br>
                        </div>

                    <?php } ?>

                    <?php $get_internal_reference_number = get_post_meta( get_the_ID(), '_ns_ticket_internal_reference_number', true ); 
                    $get_internal_reference_establishment = get_post_meta( get_the_ID(), '_ns_ticket_internal_reference_establishment', true ); 
                    $get_internal_reference_name = get_post_meta( get_the_ID(), '_ns_ticket_internal_reference_name', true ); ?>

                    <?php if ( $get_internal_reference_number ) { ?>
                        <div class="text-blocks">
                                <strong><?php _e( 'Your Internal Reference Number', 'nanosupport' ); ?>:</strong>
                                <?php echo esc_attr( $get_internal_reference_number ); ?>
                        </div>
                    <?php } //endif ?>

                    <?php if ( $get_internal_reference_name ) { ?>
                        <div class="text-blocks">
                                <strong><?php _e( 'The name of assigned technician', 'nanosupport' ); ?>:</strong>
                                <?php echo esc_attr( $get_internal_reference_name ); ?>
                        </div>
                    <?php } //endif ?>

                    <?php if ( $get_internal_reference_establishment ) { ?>
                        <div class="text-blocks">
                                <strong><?php _e( 'The establishment name', 'nanosupport' ); ?>:</strong>
                                <?php echo esc_attr( $get_internal_reference_establishment ); ?>
                        </div>
                    <?php } //endif ?>

                </div>

                <div class="toggle-ticket-additional">
                    <i class="ns-toggle-icon ns-icon-chevron-circle-down" title="<?php esc_attr_e( 'Load more', 'nanosupport' ); ?>"></i>
                </div>
                <div class="ticket-additional">
                    <ticket-cards ns-cards priority-lowdiv class="ns-col-sm-3 ns-col-xs-4 ticket-meta">
                        <div class="text-blocks">
                            <strong><?php _e( 'Created &amp; Updated:', 'nanosupport' ); ?></strong><br>
                            <?php echo date( 'd M Y h:i A', strtotime( $post->post_date ) ); ?><br>
                            <?php echo date( 'd M Y h:i A', strtotime( ns_get_ticket_modified_date($post->ID) ) ); ?>
                        </div>
                        <div class="text-blocks">
                            <strong><?php _e( 'Responses:', 'nanosupport' ); ?></strong><br>
                            <?php
                            $response_count = wp_count_comments( get_the_ID() );
                            echo '<span class="responses-count">'. $response_count->approved .'</span>';
                            ?>
                        </div>
                            <div class="text-blocks">
                            <strong><?php _e( 'Last Replied by:', 'nanosupport' ); ?></strong><br>
                            <?php
                            $last_response  = ns_get_last_response();
                            $last_responder = get_userdata( $last_response['user_id'] );
                            if ( $last_responder ) {
                                echo $last_responder->display_name, '<br>';
                                echo '<small>';
                                    /* translators: time difference from current time. eg. 12 minutes ago */
                                    printf( __( '%s ago', 'nanosupport' ), human_time_diff( strtotime($last_response['comment_date']), current_time('timestamp') ) );
                                echo '</small>';
                            } else {
                                echo '-';
                            }
                            ?>
                    </div>
                    <!--	<div class="text-blocks">
                            <strong><?php _e( 'Responses:', 'nanosupport' ); ?></strong><br>
                            <?php
                            $response_count = wp_count_comments( get_the_ID() );
                            echo '<span class="responses-count">'. $response_count->approved .'</span>';
                            ?>
                        </div>  -->
                    </div> <!-- /.ticket-additional -->
            </div> <!-- /.ns-row -->
        </div> <!-- /.ticket-cards -->
    <?php } 

function fontawesome_dashboard() {
   wp_enqueue_style('fontawesome', 'http:////netdna.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.css', '', '4.5.0', 'all');
}

add_action('admin_init', 'fontawesome_dashboard');

function my_custom_login() {
    echo '<link rel="stylesheet" type="text/css" href="' . get_stylesheet_directory_uri() . '/css/login.css" />';
    }
    add_action('login_head', 'my_custom_login');

function register_header_top_menu() {
    register_nav_menu('header-top-menu',__( 'Header top menu' ));
}
add_action( 'init', 'register_header_top_menu' );

function your_custom_menu_item ( $items, $args ) {
    if ( $args->theme_location == 'header-top-menu' ) {
        if (qtranxf_getLanguage() == 'fr') {
            $items .= "<li id='btn_toggle_lang'><a href=" . add_query_arg( 'lang', 'en') . ">English</a></li>";
        } elseif (qtranxf_getLanguage() == 'en') {
            $items .= "<li id='btn_toggle_lang'><a href=" . add_query_arg( 'lang', 'fr') . ">Français</a></li>";
        }
    }
    return $items;
}
add_filter( 'wp_nav_menu_items', 'your_custom_menu_item', 10, 2 );

function homepage_func( $atts ) {

    $html[] = '<div class="homepage">';

        $html[] .= '<span class="homepage-block">';
            if (qtranxf_getLanguage() == 'fr') {
                $html[] .= '<a href="' . site_url() . '/demande-rma/" class="button">Demande de RMA</a>';
            } elseif (qtranxf_getLanguage() == 'en') {
                $html[] .= '<a href="' . site_url() . '/demande-rma/" class="button">RMA request</a>';
            }
        $html[] .= '</span>';

        $html[] .= '<span class="homepage-block homepage-block-midle">';
            if (qtranxf_getLanguage() == 'fr') {
                $html[] .= '<a href="' . site_url() . '/knowledgebase/" class="button button2">Base de connaissance</a>';
            } elseif (qtranxf_getLanguage() == 'en') {
                $html[] .= '<a href="' . site_url() . '/knowledgebase/" class="button button2">Knowledge base</a>';
            }
        $html[] .= '</span>';

        $html[] .= '<span class="homepage-block">';
            if (qtranxf_getLanguage() == 'fr') {
                $html[] .= '<a href="' . site_url() . '/centre-assistance/" class="button button3">Centre d’assistance</a>';
            } elseif (qtranxf_getLanguage() == 'en') {
                $html[] .= '<a href="' . site_url() . '/centre-assistance/" class="button button3">Support desk</a>';
            }
        $html[] .= '</span>';

    $html[] .= '</div>';

    $html[] .= '<div class="homepage-wrapper">';

    if (is_user_logged_in()) {
        global $current_user;

        $html[] = '<div class="homepage-wrapper-flex ns-label-dashboard">';
            if (qtranxf_getLanguage() == 'fr') {
                $html[] .= 'Nombre total de RMA';
            } elseif (qtranxf_getLanguage() == 'en') {
                $html[] .= 'Total number of RMA';
            }
            $html[] .= ' ';
            $query = array(
                'post_type' 	=> 'nanosupport',
                'posts_per_page' => -1,
                'order'     	=> 'DESC',
                'orderby'       => 'modified',
                'author'        =>  $current_user->ID,
                'post_status'   => 'any'
            );
            $loop = get_posts($query);
            $html[] .= count($loop);
        $html[] .= '</div>';

        foreach ( ns_ticket_get_all_status() as $ticket_status ) { 
            $query_ = array( 
                'post_type' 	=> 'nanosupport',
                'posts_per_page' => -1,
                'order'     	=> 'DESC',
                'orderby'       => 'modified',
                'author'        =>  $current_user->ID,
                'post_status'   => 'any',
                'tax_query' => array(
                    array(
                    'taxonomy' => 'nanosupport_status',
                    'field' => 'slug',
                    'terms' => array($ticket_status['slug'])
                    )
                )
            );
            $posts = get_posts($query_);
            if (count($posts) >= 1 ) {
                $nanosupport_settings = get_option('nanosupport_settings');
                $html[] .= '<div class="homepage-wrapper-flex ns-label-dashboard" style="background-color:' . $ticket_status['color'] . '">';
                    $html[] .= '<a href="'.get_page_link($nanosupport_settings['support_desk']).'?status='.$ticket_status['slug'].'" style="background-color:' . $ticket_status['color'] . '">'.$ticket_status['name'].'</a>';
                    $html[] .= ' ';
                    $html[] .= count($posts);
                $html[] .= '</div>';
            }
        }

    }

    $html[] .= '</div>';

    $html[] .= '<iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d10927.831159379948!2d-71.3204668!3d46.7854361!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0xc467a85f0de4d52!2sEquipments%20Sunterra%20Inc!5e0!3m2!1sfr!2sca!4v1581985925861!5m2!1sfr!2sca" width="100%" height="350" frameborder="0" style="border:0;max-width: none;left: 0;" allowfullscreen=""></iframe>';
	return implode( $html );
}
add_shortcode( 'homepage', 'homepage_func' );

function custom_login_message() {
                $message = "<span style='color: rgb(0, 0, 0);text-align: center;font-size: 25px;font-weight: 300;width: 100%;display: table;'>Centre d’assistance <span style='font-weight: 600;color: #a5d549;'>RMA</span></span>";
                return $message;
}
add_filter('login_message', 'custom_login_message');

?>