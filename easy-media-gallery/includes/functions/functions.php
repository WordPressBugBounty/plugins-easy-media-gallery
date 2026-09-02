<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Easy Media Gallery Lite Version
 * Get a Easy Media Gallery specific option
 *
 * @param string $name The option name
 * @return object|bool Option value on success, false if no value exists
 */

/*-------------------------------------------------------------------------------*/
/*   ADMIN Register JS & CSS
/*-------------------------------------------------------------------------------*/
function easymedia_reg_script()
{

    $is_rtl = ( is_rtl() ? '-rtl' : '' );

    // CSS ( emg-settings.php, tinymce-dlg.php, metaboxes.php )
    wp_register_style( 'easymedia-cpstyles', plugins_url( 'css/funcstyle'.$is_rtl.'.css', dirname( __FILE__ ) ), false, EASYMEDIA_VERSION . '.1', 'all' );
    wp_register_style( 'easymedia-colorpickercss', plugins_url( 'css/colorpicker.css', dirname( __FILE__ ) ), false, EASYMEDIA_VERSION );
    wp_register_style( 'easymedia-sldr', plugins_url( 'css/slider.css', dirname( __FILE__ ) ), false, EASYMEDIA_VERSION );
    wp_register_style( 'easymedia-ibutton', plugins_url( 'css/ibutton.css', dirname( __FILE__ ) ), false, EASYMEDIA_VERSION );
    wp_register_style( 'emg-bootstrap-css', plugins_url( 'css/bootstrap/css/bootstrap.min.css', dirname( __FILE__ ) ), false, EASYMEDIA_VERSION );
    wp_register_style( 'easymedia-tinymce', plugins_url( 'css/tinymce.css', dirname( __FILE__ ) ), false, EASYMEDIA_VERSION );
    wp_register_style( 'jquery-ui-themes-redmond', plugins_url( 'css/jquery/jquery-ui/themes/smoothness/jquery-ui-1.10.0.custom.min'.$is_rtl.'.css', dirname( __FILE__ ) ), false, EASYMEDIA_VERSION );
    wp_register_style( 'emg-tabs-css', plugins_url( 'css/jquery/responsivetabs/responsive-tabs.css', dirname( __FILE__ ) ), false, EASYMEDIA_VERSION );
    wp_register_style( 'emg-tabs-style', plugins_url( 'css/jquery/responsivetabs/style.css', dirname( __FILE__ ) ), false, EASYMEDIA_VERSION );
    wp_register_style( 'easymedia-tinymce', plugins_url( 'css/tinymce.css', dirname( __FILE__ ) ), false, EASYMEDIA_VERSION );
    wp_register_style( 'jquery-multiselect-css', plugins_url( 'css/jquery/multiselect/jquery.multiselect'.$is_rtl.'.css', dirname( __FILE__ ) ), false, EASYMEDIA_VERSION );
    wp_register_style( 'easymedia-comparison-css', plugins_url( 'css/compare.css', dirname( __FILE__ ) ), false, EASYMEDIA_VERSION );
    wp_register_style( 'jquery-messi-css', plugins_url( 'css/messi.css', dirname( __FILE__ ) ), false, EASYMEDIA_VERSION );

    // JS ( emg-settings.php )
    wp_register_script( 'easymedia-jquery-easing', plugins_url( 'js/jquery/jquery.easing.js', dirname( __FILE__ ) ) );
    wp_register_script( 'easymedia-colorpicker', plugins_url( 'js/colorpicker/colorpicker.js', dirname( __FILE__ ) ) );
    wp_register_script( 'colorpicker-eye', plugins_url( 'js/colorpicker/eye.js', dirname( __FILE__ ) ) );
    wp_register_script( 'colorpicker-utils', plugins_url( 'js/colorpicker/utils.js', dirname( __FILE__ ) ) );

    // JS ( tinymce-dlg.php, emg-settings.php )
    wp_register_script( 'jquery-multi-sel', plugins_url( 'js/jquery/multiselect/jquery.multiselect.js', dirname( __FILE__ ) ), array( 'jquery', 'jquery-ui-core', 'jquery-ui-widget' ), EASYMEDIA_VERSION );

    // JS ( metaboxes.php, )
    wp_register_script( 'jquery-messi-js', plugins_url( 'js/jquery/jquery.messi.min.js', dirname( __FILE__ ) ), array( 'jquery' ), EASYMEDIA_VERSION );
    wp_register_script( 'emg-bootstrap-js', plugins_url( 'js/bootstrap/bootstrap.min.js', dirname( __FILE__ ) ), array( 'jquery' ), EASYMEDIA_VERSION );
    wp_register_script( 'cpscript', plugins_url( 'functions/funcscript.js', dirname( __FILE__ ) ), array( 'jquery' ), EASYMEDIA_VERSION . '.5' );
    wp_register_script( 'emg-tabs', plugins_url( 'js/jquery/responsivetabs/jquery.responsiveTabs.min.js', dirname( __FILE__ ) ), array( 'jquery' ), EASYMEDIA_VERSION );
    wp_register_script( 'emg-wnew', plugins_url( 'js/func/emg-affiliate.js', dirname( __FILE__ ) ) );
    wp_register_script( 'emg-youtube-subscribe', 'https://apis.google.com/js/platform.js', array(), false, false );

}

add_action( 'admin_init', 'easymedia_reg_script' );

function easymedia_frontend_js()
{
    // JS ( frontend.php )
    wp_register_script( 'fittext', plugins_url( 'js/jquery/jquery.fittext.js', dirname( __FILE__ ) ) );
    wp_register_script( 'mootools-core', plugins_url( 'js/mootools/mootools-'.easy_get_option( 'easymedia_plugin_core' ).'.js', dirname( __FILE__ ) ) );
    wp_register_script( 'easymedia-core', plugins_url( 'js/mootools/easymedia.js', dirname( __FILE__ ) ) );
    wp_register_script( 'easymedia-frontend', plugins_url( 'js/func/frontend.js', dirname( __FILE__ ) ) );
    wp_register_script( 'easymedia-ajaxfrontend', plugins_url( 'js/func/ajax-frontend.js', dirname( __FILE__ ) ) );
}

add_action( 'wp_enqueue_scripts', 'easymedia_frontend_js' );

/*
|--------------------------------------------------------------------------
| Defines
|--------------------------------------------------------------------------
 */
define( 'EMG_IS_AJAX', easy_get_option( 'easymedia_disen_ajax' ) );
$emgmemory = (int) ini_get( 'memory_limit' );
$emgmemory = empty( $emgmemory ) ? __( 'N/A', 'easy-media-gallery' ) : $emgmemory . __( ' MB', 'easy-media-gallery' );

/*-------------------------------------------------------------------------------*/
/*   AJAX For EMG Lightbox @since 1.2.9.5
/*-------------------------------------------------------------------------------*/
function emg_get_data_slider_ajax()
{

    check_ajax_referer( 'medialoader', 'security' );

    if ( ! isset( $_POST['id'] ) ) {
        echo 'Error!';
        wp_die();
    } else {

        $raw_id = sanitize_text_field( wp_unslash( $_POST['id'] ) );
        if ( strpos( $raw_id, '-' ) !== false ) {
            $devmedia     = explode( '-', $raw_id );
            $id           = absint( $devmedia[0] );
            $isdinamccntn = isset( $devmedia[1] ) ? absint( $devmedia[1] ) : 0;
        } else {
            $id           = absint( $raw_id );
            $isdinamccntn = 0;
        }

        global $post;
        $usegalleryinfo = get_post_meta( $id, 'easmedia_metabox_media_gallery_opt2', true );

        if ( ! empty( $isdinamccntn ) ) {

            if ( $usegalleryinfo == 'on' ) {
                $img_info      = get_post( $isdinamccntn );
                $boxmediattl   = ( $img_info && ! empty( $img_info->post_title ) ) ? $img_info->post_title : get_post_meta( $id, 'easmedia_metabox_title', true );
                $boxmediasbttl = ( $img_info && ! empty( $img_info->post_excerpt ) ) ? $img_info->post_excerpt : get_post_meta( $id, 'easmedia_metabox_sub_title', true );
            } else {
                $boxmediattl   = get_post_meta( $id, 'easmedia_metabox_title', true );
                $boxmediasbttl = get_post_meta( $id, 'easmedia_metabox_sub_title', true );
            }

        } else {
            $boxmediattl   = get_post_meta( $id, 'easmedia_metabox_title', true );
            $boxmediasbttl = get_post_meta( $id, 'easmedia_metabox_sub_title', true );
        }

        if ( $boxmediasbttl == '' ) {$boxmediasbttl = 'none';}

        if ( $boxmediattl == '' ) {$boxmediattl = 'none';}

        $therest = array( $boxmediattl, $boxmediasbttl );
        echo json_encode( $therest );
//------------------------------------------------------------------------------
        wp_die();
    }

}

add_action( 'wp_ajax_nopriv_emg_get_data_slider_ajax', 'emg_get_data_slider_ajax' );
add_action( 'wp_ajax_emg_get_data_slider_ajax', 'emg_get_data_slider_ajax' );

/*
|--------------------------------------------------------------------------
| AJAX RESET SETTINGS
|--------------------------------------------------------------------------
 */
function emg_cp_reset()
{

    check_ajax_referer( 'easymedia-lite-nonce', 'security' );

    if ( ! current_user_can('manage_options') ) {
        wp_send_json_error( 'Unauthorized: admin only', 403 );
        wp_die();
    }

    if ( ! isset( $_POST['cmd'] ) ) {
        echo '0';
        wp_die();
    } else {

        if ( $_POST['cmd'] == 'reset' ) {
            echo '1';
            easymedia_restore_to_default( $_POST['cmd'] );
            wp_die();
        }

    }

}

add_action( 'wp_ajax_emg_cp_reset', 'emg_cp_reset' );

/*
|--------------------------------------------------------------------------
| AJAX DELETE MEDIA IMAGE
|--------------------------------------------------------------------------
 */
function easmedia_img_media_remv()
{

    check_ajax_referer( 'easymedia-remove', 'security' );

    if ( ! isset( $_POST['pstid'] ) || ! isset( $_POST['type'] ) ) {
        echo '0';
        wp_die();
    } else {

        if ( ! current_user_can( 'edit_theme_options' ) ) {
            wp_die( '-1' );
        }

        if ( $_POST['type'] == 'image' ) {
            $data = $_POST['pstid'];
            update_post_meta( $data, 'easmedia_metabox_img', '' );
            wp_die( '1' );
        } elseif ( $_POST['type'] == 'audio' ) {
            $data = $_POST['pstid'];
            update_post_meta( $data, 'easmedia_metabox_media_audio', '' );
            echo '1';
            wp_die();
        }

    }

}

add_action( 'wp_ajax_easmedia_img_media_remv', 'easmedia_img_media_remv' );

/*-------------------------------------------------------------------------------*/
/*   CSS Compressor @since 1.5.1.7
/*-------------------------------------------------------------------------------*/
function emg_css_compress( $minify )
{
    if ( empty( $minify ) ) {
        return '';
    }

    /* remove comments */
    $result = preg_replace( '!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', (string) $minify );
    $minify = ( null !== $result ) ? $result : (string) $minify;

    /* remove tabs, spaces, newlines, etc. */
    $minify = str_replace( array( "\r\n", "\r", "\n", "\t", '  ', '    ', '    ' ), '', $minify );

    return $minify;
}

/*
|--------------------------------------------------------------------------
| Generate Gallery Query
|--------------------------------------------------------------------------
 */
function emg_gallery_gen( $id, $paged )
{

    $emargs = array(
        'post__in'       => $id,
        'post_type'      => 'easymediagallery',
        'posts_per_page' => 2,
        'order'          => 'ASC',
        'orderby'        => 'menu_order',
        'paged'          => $paged,
    );

    return $emargs;
}

/*
|--------------------------------------------------------------------------
| Generate Gallery Markup
|--------------------------------------------------------------------------
 */
function emg_gallery_markup( $iw, $ih, $aclass, $ahref, $thumb, $alt, $ttl )
{

    echo '<div style="width:' . esc_attr( $iw ) . 'px; height:' . esc_attr( $ih ) . 'px;" class="view da-thumbs"><div class="iehand"><a class="' . esc_attr( $aclass ) . '" rel="easymedia[grid]" href="' . esc_url( $ahref ) . '"><img src="' . esc_url( $thumb ) . '" alt="' . esc_attr( $alt ) . '" /><article class="da-animate da-slideFromRight"><p ' . ( $ttl ? '' : 'style="display: none;"' ) . ' class="emgfittext">' . esc_html( $ttl ) . '</p><div class="forspan"><span class="zoom"></span></div></article></a></div></div>';

    return;
}

/*
|--------------------------------------------------------------------------
| Easymedia Custom Category Box (Metabox)
|--------------------------------------------------------------------------
 */
function easymediagallery_categories_meta_box( $post, $box )
{
    $defaults = array( 'taxonomy' => 'emediagallery' );

    if ( ! isset( $box['args'] ) || ! is_array( $box['args'] ) ) {
        $args = array();
    } else {
        $args = $box['args'];
    }

    extract( wp_parse_args( $args, $defaults ), EXTR_SKIP );
    $tax = get_taxonomy( $taxonomy );

    ?>
<div id="taxonomy-<?php echo esc_attr( $taxonomy ); ?>" class="categorydiv">
    <ul id="<?php echo esc_attr( $taxonomy ); ?>-tabs" class="category-tabs">
        <li class="tabs"><a href="#<?php echo esc_attr( $taxonomy ); ?>-all"><?php echo esc_html( $tax->labels->all_items ); ?></a></li>
        <li class="hide-if-no-js"><a href="#<?php echo esc_attr( $taxonomy ); ?>-pop"><?php esc_html_e( 'Most Used', 'easy-media-gallery' ); ?></a></li>
    </ul>

    <div id="<?php echo esc_attr( $taxonomy ); ?>-pop" class="tabs-panel" style="display: none;">
        <ul id="<?php echo esc_attr( $taxonomy ); ?>checklist-pop" class="categorychecklist form-no-clear">
            <?php $popular_ids = wp_popular_terms_checklist( $taxonomy );?>
        </ul>
    </div>

    <div id="<?php echo esc_attr( $taxonomy ); ?>-all" class="tabs-panel">
        <?php
$name = ( $taxonomy == 'emediagallery' ) ? 'post_category' : 'tax_input[' . $taxonomy . ']';
    echo "<input type='hidden' name='" . esc_attr( $name ) . "[]' value='0' />"; // Allows for an empty term set to be sent. 0 is an invalid Term ID and will be ignored by empty() checks.
    ?>
        <ul id="<?php echo esc_attr( $taxonomy ); ?>checklist" data-wp-lists="list:<?php echo esc_attr( $taxonomy ); ?>"
            class="categorychecklist form-no-clear">
            <?php wp_terms_checklist( $post->ID, array( 'taxonomy' => $taxonomy, 'popular_cats' => $popular_ids ) )?>
        </ul>
    </div>
    <?php

    if ( current_user_can( $tax->cap->edit_terms ) ): ?>
    <div id="<?php echo esc_attr( $taxonomy ); ?>-adder" class="wp-hidden-children">
        <h4>
            <a id="<?php echo esc_attr( $taxonomy ); ?>-add-toggle" href="#<?php echo esc_attr( $taxonomy ); ?>-add" class="hide-if-no-js">
                <?php
/* translators: %s: add new taxonomy label */
    printf( esc_html__( '+ %s', 'easy-media-gallery' ), esc_html( $tax->labels->add_new_item ) );
    ?>
            </a>
        </h4>
        <p id="<?php echo esc_attr( $taxonomy ); ?>-add" class="category-add wp-hidden-child">
            <label class="screen-reader-text"
                for="new<?php echo esc_attr( $taxonomy ); ?>"><?php echo esc_html( $tax->labels->add_new_item ); ?></label>
            <input type="text" name="new<?php echo esc_attr( $taxonomy ); ?>" id="new<?php echo esc_attr( $taxonomy ); ?>"
                class="form-required form-input-tip" value="<?php echo esc_attr( $tax->labels->new_item_name ); ?>"
                aria-required="true" />
            <label class="screen-reader-text" for="new<?php echo esc_attr( $taxonomy ); ?>_parent">
                <?php echo esc_html( $tax->labels->parent_item_colon ); ?>
            </label>
            <?php wp_dropdown_categories( array( 'taxonomy' => $taxonomy, 'hide_empty' => 0, 'name' => 'new' . $taxonomy . '_parent', 'orderby' => 'name', 'hierarchical' => 1, 'show_option_none' => '&mdash; ' . $tax->labels->parent_item . ' &mdash;' ) );?>
            <input type="button" id="<?php echo esc_attr( $taxonomy ); ?>-add-submit"
                data-wp-lists="add:<?php echo esc_attr( $taxonomy ); ?>checklist:<?php echo esc_attr( $taxonomy ); ?>-add"
                class="button category-add-submit" value="<?php echo esc_attr( $tax->labels->add_new_item ); ?>" />
            <?php wp_nonce_field( 'add-' . $taxonomy, '_ajax_nonce-add-' . $taxonomy, false );?>
            <span id="<?php echo esc_attr( $taxonomy ); ?>-ajax-response"></span>
        </p>
    </div>
    <?php endif;?>
</div>
<?php
}

/*-------------------------------------------------------------------------------*/
/* Add Post Thumbnails and Custom Thumbnails size
/*-------------------------------------------------------------------------------*/
function easmedia_add_thumbnail_support()
{

    if ( ! current_theme_supports( 'post-thumbnails' ) ) {
        add_theme_support( 'post-thumbnails', array( 'easymediagallery' ) );
        add_image_size( 'emg-admin-thumb', 70, 70, true ); // Used in the easymedia edit page
    }

}

add_action( 'init', 'easmedia_add_thumbnail_support' );

/*-------------------------------------------------------------------------------*/
/* Add credits in admin page
/*-------------------------------------------------------------------------------*/
function easymedia_add_footer_credits( $text )
{
    $t = '';

    if ( get_post_type() === 'easymediagallery' ) {
        $t .= '<div id="credits" style="line-height: 22px;">';
        $t .= '<p>Easy Media Gallery plugin Lite is created by <a href="https://ghozylab.com/plugins/" target="_blank">GHOZY LAB LLC</a>.</p>';
        $t .= '<p>If you have some support issue, do not hesitate to <a href="https://ghozy.link/bctnd" target="_blank">contact us here</a>. The GhozyLab Teams will be happy to support you on any issue.</p>';
        $t .= '</div>';
    } else {
        $t = $text;
    }

    return $t;
}

add_filter( 'admin_footer_text', 'easymedia_add_footer_credits' );

/*-------------------------------------------------------------------------------*/
/*  Get the patterns list
/*-------------------------------------------------------------------------------*/
function easmedia_patterns_ls()
{
    $patterns      = array();
    $patterns_list = scandir( EMG_DIR.'css/images/patterns' );

    foreach ( $patterns_list as $pattern_name ) {

        if ( $pattern_name != '.' && $pattern_name != '..' ) {
            $patterns[] = $pattern_name;
        }

    }

    return $patterns;
}

/*-------------------------------------------------------------------------------*/
/*  HEX to RGB
/*-------------------------------------------------------------------------------*/
function easymedia_hex2rgb( $hex )
{
    $hex = str_replace( '#', '', $hex );

    if ( strlen( $hex ) == 3 ) {
        $r = hexdec( substr( $hex, 0, 1 ).substr( $hex, 0, 1 ) );
        $g = hexdec( substr( $hex, 1, 1 ).substr( $hex, 1, 1 ) );
        $b = hexdec( substr( $hex, 2, 1 ).substr( $hex, 2, 1 ) );
    } else {
        $r = hexdec( substr( $hex, 0, 2 ) );
        $g = hexdec( substr( $hex, 2, 2 ) );
        $b = hexdec( substr( $hex, 4, 2 ) );
    }

    $rgb = array( $r, $g, $b );

    return implode( ',', $rgb ); // returns an array with the rgb values
}

/*-------------------------------------------------------------------------------*/
/*  Random String
/*-------------------------------------------------------------------------------*/
function emgRandomString( $length )
{
    $original_string = array_merge( range( 0, 9 ), range( 'a', 'z' ), range( 'A', 'Z' ) );
    $original_string = implode( '', $original_string );

    return substr( str_shuffle( $original_string ), 0, $length );
}

/*-------------------------------------------------------------------------------*/
/*  Shortcode Handler
/*-------------------------------------------------------------------------------*/
function easymedia_sc_handler( $scdata, $scl )
{

    switch ( $scl ) {

        case '0':

            if ( $scdata != '' && $scdata <= 3 ) {
                $finaldata = $scdata;
            } else {
                $finaldata = easy_get_option( 'easymedia_columns' );
            }

            break;

        case '1':

            if (  ( $scdata != '' && $scdata == 'center' ) || ( $scdata != '' && $scdata == 'none' ) ) {
                $finaldata = $scdata;
            } else {
                $finaldata = strtolower( easy_get_option( 'easymedia_alignstyle' ) );
            }

            break;

        default:
            break;
    }

    return $finaldata;

}

/*-------------------------------------------------------------------------------*/
/*  Get attachment image id
/*-------------------------------------------------------------------------------*/
function emg_get_attachment_id_from_src( $url ) {
    $id = attachment_url_to_postid( $url );
    if ( $id ) {
        return $id;
    }

    // fallback manual
    global $wpdb;

    $path = wp_parse_url( $url, PHP_URL_PATH );
    if ( empty( $path ) ) {
        return null;
    }
    $path = (string) preg_replace( '/-\d+x\d+(?=\.(jpg|jpeg|png|gif)$)/i', '', (string) $path );

    return $wpdb->get_var(
        $wpdb->prepare(
            "SELECT post_id FROM {$wpdb->postmeta}
             WHERE meta_key = '_wp_attached_file'
             AND %s LIKE CONCAT(%s, meta_value)
             LIMIT 1",
            $path,
            '%'
        )
    );
}

/*-------------------------------------------------------------------------------*/
/*  Image Resize ( Aspect Ratio )
/*-------------------------------------------------------------------------------*/
function easymedia_imgresize( $img, $limit, $isres, $imw, $imh )
{

    if ( $img == '' ) {
        $img = plugins_url( 'images/no-image-available.jpg', dirname( __FILE__ ) );
    } else {
        $img = $img;
    }

    if ( $isres == 'on' ) {

        if ( $imw > $limit ) {
            $tempimgratio = $imh / $imw;
            $fih          = (int) ( $tempimgratio * $limit ); // final image height
            $fiw          = $limit; // fixed image width
            $allimgdata   = array( easymedia_resizer( $img, $imw, $imh, $fiw, $fih, true ), $fiw, $fih );
        } else {
            $allimgdata = array( $img, $imw, $imh );
        }

    } else {
        $allimgdata = array( $img, $imw, $imh );
    }

    return implode( ',', $allimgdata );
}

/*-------------------------------------------------------------------------------*/
/*  Image Resize ( Aspect Ratio ) AJAX
/*-------------------------------------------------------------------------------*/
function easymedia_imgresize_ajax()
{

    check_ajax_referer( 'easymedia-thumb', 'security' );

    if ( ! isset( $_POST['imgurl'] ) || ! isset( $_POST['limiter'] ) || $_POST['imgurl'] == '' || $_POST['limiter'] == '' ) {
        echo '<p>Ajax request failed, please refresh your browser window and try again.</p>';
        wp_die();
    } else {

        $imgurl  = $_POST['imgurl'];
        $limiter = $_POST['limiter'];
        $attid   = wp_get_attachment_image_src( emg_get_attachment_id_from_src( $imgurl ), 'full' );

        $tmpimgratio = $attid[2] / $attid[1];

//get image aspec ratio

        if ( $attid[1] > $limiter ) {
            $tmph       = (int) ( $tmpimgratio * $limiter ); // final image height
            $tmpw       = $limiter; // fixed image width
            $finimgurl  = easymedia_resizer( $imgurl, $attid[1], $attid[2], $tmpw, $tmph, true );
            $allimgdata = array( $finimgurl, $tmpw, $tmph );
            echo esc_html( implode( ',', $allimgdata ) );
            wp_die();
        } else {
            $finimgurl  = $imgurl;
            $allimgdata = array( $finimgurl, $attid[1], $attid[2] );
            echo esc_html( implode( ',', $allimgdata ) );
            wp_die();
        }

    }

}

add_action( 'wp_ajax_easymedia_imgresize_ajax', 'easymedia_imgresize_ajax' );

/*
|--------------------------------------------------------------------------
| REMOVE PERMALINK
|--------------------------------------------------------------------------
 */
function emg_hide_permalink()
{
    global $post_type;

    if ( $post_type == 'easymediagallery' ) {
        echo '<style type="text/css">#edit-slug-box{display: none;}</style>';
    }

}

add_action( 'admin_head', 'emg_hide_permalink' );

/*--------------------------------------------------------------------------------*/
/*  REMOVE THE PARENT FIELD FOR THE CUSTOM TEXONOMY
/*--------------------------------------------------------------------------------*/
function emg_remove_cat_parent()
{
    global $current_screen;

    switch ( $current_screen->id ) {
        case 'edit-emediagallery':

            ?>
<script type="text/javascript">
jQuery(document).ready(function($) {
    jQuery('#parent').parents('.form-field').remove();
    jQuery('#tag-slug, #tag-description').parents('.form-field').hide();
});
</script>
<?php

            break;
    }

}

add_action( 'admin_footer-edit-tags.php', 'emg_remove_cat_parent' );

/*-------------------------------------------------------------------------------*/
/*  Get WP Info
/*-------------------------------------------------------------------------------*/
function easmedia_get_wpinfo()
{
    $output = '';

    // Get Site URL
    $site_url = get_site_url();

    // Get Multisite status
    $multisite = is_multisite() ? '- WP Multisite : YES' : '- WP Multisite : NO';

    global $emgmemory;
    $mem = ! empty( $emgmemory ) ? $emgmemory : ( defined( 'WP_MEMORY_LIMIT' ) ? WP_MEMORY_LIMIT : '' );

    $output .= '- WP Version : ' . ( defined( 'EMG_WPVER' ) ? EMG_WPVER : get_bloginfo( 'version' ) ) . "\n";
    $output .= '- EMG-Lite Version : ' . ( defined( 'EASYMEDIA_VERSION' ) ? EASYMEDIA_VERSION : '' ) . "\n";
    $output .= '- Site URL : ' . $site_url . "\n";
    $output .= $multisite . "\n";
    $output .= '- Memory Limit : ' . $mem . "\n";
    $output .= '- PHP Curl : ' . ( function_exists( 'curl_version' ) ? 'Enabled' : 'Disabled' ) . "\n";
    $theme_name = wp_get_theme();
    $output .= '- Active Theme : ' . ( is_object( $theme_name ) ? $theme_name->get( 'Name' ) : '' ) . "\n";
    $output .= "- Active Plugins : \n";

    // Get Active Plugin
    if ( is_multisite() ) {
        $the_plugs = get_site_option( 'active_sitewide_plugins' );
        if ( is_array( $the_plugs ) ) {
            foreach ( $the_plugs as $key => $value ) {
                $string    = explode( '/', $key );
                $string[0] = str_replace( '-', ' ', $string[0] );
                $output .= '     ' . ucwords( $string[0] ) . "\n";
            }
        }
    } else {
        $the_plugs = get_option( 'active_plugins' );
        if ( is_array( $the_plugs ) ) {
            foreach ( $the_plugs as $key => $value ) {
                $string    = explode( '/', $value );
                $string[0] = str_replace( '-', ' ', $string[0] );
                $output .= '     ' . ucwords( $string[0] ) . "\n";
            }
        }
    }

    return $output;
}

/*-------------------------------------------------------------------------------*/
/*  Get Plugin Version (@return string Plugin version)
/*-------------------------------------------------------------------------------*/
function easymedia_get_plugin_version()
{
    $plugin_data    = get_plugin_data( EMG_DIR.'easy-media-gallery.php' );
    $plugin_version = $plugin_data['Version'];

    return $plugin_version;
}

/*-------------------------------------------------------------------------------*/
/*  Enable Sorting of the Media
/*-------------------------------------------------------------------------------*/
function easmedia_create_easymedia_sort_page()
{
    $easmedia_sort_page = add_submenu_page( 'edit.php?post_type=easymediagallery', 'Sorter', __( 'Sorter', 'easy-media-gallery' ), 'edit_posts', 'easymedia-order', 'easmedia_easymedia_sort' );

    add_action( 'admin_print_styles-'.$easmedia_sort_page, 'easmedia_print_sort_styles' );
    add_action( 'admin_print_scripts-'.$easmedia_sort_page, 'easmedia_print_sort_scripts' );
}

add_action( 'admin_menu', 'easmedia_create_easymedia_sort_page' );

function easmedia_easymedia_sort()
{

    wp_reset_postdata();

    global $post;

    $args = array(
        'post_type'      => 'easymediagallery',
        'order'          => 'ASC',
        'orderby'        => 'menu_order',
        'post_status'    => 'publish',
        'posts_per_page' => -1,
    );

    $posttitle = get_posts( $args );

    ?>
<div class="wrap">
    <div id="icon-edit" class="icon32 icon32-posts-easymedia"><br /></div>
    <h2><?php esc_html_e( 'Sorter', 'easy-media-gallery' ); ?></h2>
    <p><?php esc_html_e( 'Simply drag the Media up or down and they will be saved in that order. Media at the top will appear first.', 'easy-media-gallery' ); ?>
    </p>

    <div class="metabox-holder">
        <div class="postbox">
            <h3><?php esc_html_e( 'Sort Media', 'easy-media-gallery' ); ?>:</h3>
            <ul id="easymedia_list" style="padding-left:10px !important;">

                <?php

    if ( ! empty( $posttitle ) ) {

        foreach ( $posttitle as $post ): setup_postdata( $post );?>
                <li id="<?php esc_attr( the_id() );?>" class="menu-item">
                    <dl class="menu-item-bar">
                        <dt class="menu-item-handle">
                            <img style="float:left; vertical-align:middle;padding-top: 4px; margin-right:10px;"
                                src="<?php echo esc_url( plugins_url( 'images/sort.png', dirname( __FILE__ ) ) ); ?>"
                                height="28px;" width="28px;" /><span style="line-height: 32px;"
                                class="item-title"><?php echo esc_html( esc_js( the_title( null, null, false ) ) ); ?></span>
                        </dt>
                    </dl>
                    <ul class="menu-item-transport"></ul>
                </li>
                <?php endforeach;
        ?>
                <?php } else {?>
                <div class="wrap">
                    <div id="icon-edit" class="icon32 icon32-posts-easymedia"><br /></div>
                    <h2><?php esc_html_e( 'Sorter', 'easy-media-gallery' ); ?></h2>
                    <div class="metabox-holder">
                        <div class="postbox">
                            <h3><?php esc_html_e( 'Sort Media', 'easy-media-gallery' ); ?>:</h3>
                            <p style="padding:10px;">
                                <?php
                                /* translators: 1: opening <a> tag, 2: closing </a> tag */
                                echo wp_kses_post( sprintf( __( 'No items found, why not %1$screate one%2$s?', 'easy-media-gallery' ), '<a href="' . esc_url( admin_url( 'post-new.php?post_type=easymediagallery' ) ) . '">', '</a>' ) );
                                ?>
                            </p>
                        </div>
                    </div>
                </div>
                <?php }

    ?>
            </ul>
        </div>
        <div style="padding-left:33px; margin-bottom:30px"><img
                src="<?php echo esc_url( plugins_url( 'images/dragdrop.png', dirname( __FILE__ ) ) ) ?>" height="23px;"
                width="161px;" /></div>
    </div>
</div>
<?php
}

/*-------------------------------------------------------------------------------*/
/*  RENAME POST BUTTON
/*-------------------------------------------------------------------------------*/
add_filter( 'gettext', 'change_publish_button', 10, 2 );
function change_publish_button( $translation, $text )
{

    if ( 'easymediagallery' == get_post_type() ) {

        if ( $text == 'Publish' ) {
            return 'Save Media';} else

        if ( $text == 'Update' ) {
            return 'Update Media';}

    }

    return $translation;
}

add_filter( 'gettext', 'change_insert_media', 10, 2 );
function change_insert_media( $translation, $text )
{

    if ( 'easymediagallery' == get_post_type() ) {

        if ( $text == 'Insert into post' ) {
            return 'Insert into media';}

    }

    return $translation;
}

/*-------------------------------------------------------------------------------*/
/*   Load Dasboard News
/*-------------------------------------------------------------------------------*/

function emg_download_count()
{

    $args     = (object) array( 'slug' => 'easy-media-gallery' );
    $request  = array( 'action' => 'plugin_information', 'timeout' => 15, 'request' => serialize( $args ) );
    $url      = 'https://api.wordpress.org/plugins/info/1.0/';
    $response = wp_remote_post( $url, array( 'body' => $request ) );

    if ( ! is_wp_error( $response ) && 200 === wp_remote_retrieve_response_code( $response ) ) {
        $body        = wp_remote_retrieve_body( $response );
        $plugin_info = maybe_unserialize( $body );

        if ( is_object( $plugin_info ) && isset( $plugin_info->downloaded ) && is_numeric( $plugin_info->downloaded ) ) {
            /* translators: %s: formatted download count */
            return sprintf( esc_html__( 'Downloaded : %s times', 'easy-media-gallery' ), number_format_i18n( (float) $plugin_info->downloaded ) );
        }
    }

    return '';
}

if ( easy_get_option( 'easymedia_disen_dasnews' ) == '1' ) {
    function emg_register_dashboard_widgets()
    {

        if ( current_user_can( apply_filters( 'emg_dashboard_stats_cap', 'edit_pages' ) ) ) {
            /* translators: %s: download count */
            wp_add_dashboard_widget( 'emg_dashboard_stat', sprintf( __( 'Easy Media Gallery (Lite) %s', 'easy-media-gallery' ), emg_download_count() ), 'emg_dashboard_widget' );
        }

    }

    add_action( 'wp_dashboard_setup', 'emg_register_dashboard_widgets' );

    function emg_dashboard_widget()
    {
        ?>
<style>
.ghozyaffjoin {
    margin: 10px 0px 10px 0px;
    background: -webkit-gradient(linear, left top, left bottom, color-stop(0.05, #446bb3), color-stop(1, #3874bd));
    background: -moz-linear-gradient(top, #446bb3 5%, #3874bd 100%);
    background: -webkit-linear-gradient(top, #446bb3 5%, #3874bd 100%);
    background: -o-linear-gradient(top, #446bb3 5%, #3874bd 100%);
    background: -ms-linear-gradient(top, #446bb3 5%, #3874bd 100%);
    background: linear-gradient(to bottom, #446bb3 5%, #3874bd 100%);
    filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#446bb3', endColorstr='#3874bd', GradientType=0);
    background-color: #446bb3;
    border: 1px solid #7b8cad;
    display: inline-block;
    cursor: pointer;
    color: #ffffff;
    font-family: Arial;
    font-size: 19px;
    padding: 5px 25px;
    text-decoration: none;
    text-shadow: 0px 1px 0px #283c66;
}

.ghozyaffjoin:hover {
    background: -webkit-gradient(linear, left top, left bottom, color-stop(0.05, #3874bd), color-stop(1, #446bb3));
    background: -moz-linear-gradient(top, #3874bd 5%, #446bb3 100%);
    background: -webkit-linear-gradient(top, #3874bd 5%, #446bb3 100%);
    background: -o-linear-gradient(top, #3874bd 5%, #446bb3 100%);
    background: -ms-linear-gradient(top, #3874bd 5%, #446bb3 100%);
    background: linear-gradient(to bottom, #3874bd 5%, #446bb3 100%);
    filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#3874bd', endColorstr='#446bb3', GradientType=0);
    background-color: #3874bd;
    color: #ffffff;
}

.ghozyaffjoin:active {
    position: relative;
    top: 1px;
}
</style>
<div class="emg_dashboard_widget">
    <p class="sub">GhozyLab partners with 8,000 affiliates and pays out over $200,000 per year!<br />Earn <span
            style="color: red;">EXTRA MONEY</span> and get 30% affiliate share from every sale you make!<br /><a
            target="_blank" class="ghozyaffjoin" href="https://ghozylab.com/plugins/affiliate-program/">JOIN NOW
            &#10095;</a></p>
    <div style="position:relative;">
        <ul class='easymedia-social' id='easymedia-cssanime'>
            <li class='easymedia-facebook'>
                <a onclick="window.open('https://www.facebook.com/sharer.php?s=100&amp;p[title]=Check out the Best Portfolio and Gallery Wordpress plugin&amp;p[summary]=Easy Media Gallery for WordPress that is powerful and so easy to create portfolio or media gallery&amp;p[url]=https://ghozylab.com/plugins/&amp;p[images][0]=<?php echo esc_url( plugins_url( 'images/easymediabox.png', dirname( __FILE__ ) ) ); ?>', 'sharer', 'toolbar=0,status=0,width=548,height=325');"
                    href="javascript: void(0)" title="Share"><strong>Facebook</strong></a>
            </li>
            <li class='easymedia-twitter'>
                <a onclick="window.open('https://twitter.com/share?text=Check out the Best Portfolio and Gallery Wordpress Plugin &url=https://ghozylab.com/plugins/', 'sharer', 'toolbar=0,status=0,width=548,height=325');"
                    title="Twitter" class="circle"><strong>Twitter</strong></a>
            </li>
            <li class='easymedia-googleplus'>
                <a
                    onclick="window.open('https://plus.google.com/share?url=https://ghozylab.com/plugins/','','width=415,height=450');"><strong>Google+</strong></a>
            </li>
            <li class='easymedia-pinterest'>
                <a
                    onclick="window.open('https://pinterest.com/pin/create/button/?url=https://ghozylab.com/plugins/;media=<?php echo esc_url( plugins_url( 'images/easymediabox.png', dirname( __FILE__ ) ) ); ?>;description=Best plugin for WordPress that is powerful and so easy to create portfolio or media gallery','','width=600,height=300');"><strong>Pinterest</strong></a>
            </li>
        </ul>
    </div>
</div>

<?php
}

}

function emg_share()
{
    ?>
<div style="position:relative; margin-top:6px;">
    <ul class='easymedia-social' id='easymedia-cssanime'>
        <li class='easymedia-facebook'>
            <a onclick="window.open('https://www.facebook.com/sharer.php?s=100&amp;p[title]=Check out the Best Wordpress Portfolio and Gallery plugin&amp;p[summary]=Easy Media Gallery for WordPress that is powerful and so easy to create portfolio or media gallery&amp;p[url]=https://ghozylab.com/plugins/easy-media-gallery-pro/demo/best-gallery-grid-galleries-plugin/&amp;p[images][0]=<?php echo esc_url( plugins_url( 'images/easymediabox.png', dirname( __FILE__ ) ) ); ?>', 'sharer', 'toolbar=0,status=0,width=548,height=325');"
                href="javascript: void(0)" title="Share"><strong>Facebook</strong></a>
        </li>
        <li class='easymedia-twitter'>
            <a onclick="window.open('https://twitter.com/share?text=Check out the Best Wordpress Portfolio and Gallery Plugin &url=https://ghozylab.com/plugins/', 'sharer', 'toolbar=0,status=0,width=548,height=325');"
                title="Twitter" class="circle"><strong>Twitter</strong></a>
        </li>
        <li class='easymedia-googleplus'>
            <a
                onclick="window.open('https://plus.google.com/share?url=https://ghozylab.com/plugins/','','width=415,height=450');"><strong>Google+</strong></a>
        </li>
        <li class='easymedia-pinterest'>
            <a
                onclick="window.open('https://pinterest.com/pin/create/button/?url=https://ghozylab.com/plugins/;media=<?php echo esc_url( plugins_url( 'images/easymediabox.png', dirname( __FILE__ ) ) ); ?>;description=Easy Media Gallery for WordPress that is powerful and so easy to create portfolio or media gallery','','width=600,height=300');"><strong>Pinterest</strong></a>
        </li>
    </ul>
</div>

<?php
}

/*
|--------------------------------------------------------------------------
| AJAX HIDE NOTIFY
|--------------------------------------------------------------------------
 */
function emg_hide_noty()
{

    check_ajax_referer( 'easymedia-lite-nonce-button', 'hidesecurity' );

    if ( ! isset( $_POST['clickcmd'] ) ) {
        echo '0';
        wp_die();
    } else {

        if ( $_POST['clickcmd'] == 'hide' ) {
            echo '1';
            $emg_upd_options                                    = get_option( 'easy_media_opt' );
            $emg_upd_options['easymedia_disen_admnotify']['id'] = '0';
            update_option( 'easy_media_opt', $emg_upd_options );
            wp_die();
        }

    }

}

add_action( 'wp_ajax_emg_hide_noty', 'emg_hide_noty' );

/*-------------------------------------------------------------------------------*/
/*  Create Pro Demo Metabox
/*-------------------------------------------------------------------------------*/
function emg_prodemo_metabox()
{
    $emgdm = '<div style="text-align:center;">';
    $emgdm .= '<a id="emgdemotableclr" style="outline: none !important;" target="_blank" href="https://ghozy.link/wfn46"><img class="emghvrbutton" style="cursor:pointer; margin-top: 7px;" src="' . esc_url( plugins_url( 'images/view-demo-button.jpg', dirname( __FILE__ ) ) ) . '" width="232" height="60" alt="Pro Version Demo" ></a>';
    $emgdm .= '</div>';
    echo wp_kses_post( $emgdm );
}

/*-------------------------------------------------------------------------------*/
/*  Create Upgrade Metabox @since 1.2.61
/*-------------------------------------------------------------------------------*/
function emg_upgrade_metabox()
{
    $emgbuy = '<div style="text-align:center;">';
    $emgbuy .= '<a id="promote_plugins" style="outline: none !important;" href="https://ghozy.link/emgwpcedtrr" target="_blank"><img style="cursor:pointer; margin-top: 7px;" src="' . esc_url( plugins_url( 'images/new-release.png', dirname( __FILE__ ) ) ) . '" width="241" height="231" alt="WordPress Page Builder Plugin" ></a>';
    $emgbuy .= '</div>';
    echo wp_kses_post( $emgbuy );
}

/*-------------------------------------------------------------------------------*/
/*  Create Upgrade Metabox @since 1.2.61
/*-------------------------------------------------------------------------------*/
function emg_new_info_metabox()
{
    $emgnew = '<div style="text-align:center;">';
    $emgnew .= '<a style="outline: none !important;" href="https://ghozy.link/qtnrb" target="_blank"><img style="cursor:pointer; margin-top: 7px;" src="' . esc_url( plugins_url( 'images/new-plugin.png', dirname( __FILE__ ) ) ) . '" width="241" height="151" alt="New Plugin" ></a>';
    $emgnew .= '</div>';
    echo wp_kses_post( $emgnew );
}

/*-------------------------------------------------------------------------------*/
/*  Post Counter
/*-------------------------------------------------------------------------------*/
function emg_pcnt()
{
    global $post;
    $args = array(
        'post_type'      => 'easymediagallery',
        'order'          => 'ASC',
        'post_status'    => 'all',
        'posts_per_page' => -1,
        'meta_query'     => array(
            array(
                'key'     => 'easmedia_metabox_media_type',
                'value'   => 'Multiple Images (Slider)',
                'compare' => '=',
            ),
        ),
    );

    $myposts = get_posts( $args );

    if ( $myposts ) {
        return ( count( $myposts ) );
    }

}

/*-------------------------------------------------------------------------------*/
/*   Admin Notifications
/*-------------------------------------------------------------------------------*/
function emg_admin_bar_menu()
{
    global $wp_admin_bar;

    /* Add the main siteadmin menu item */
    $wp_admin_bar->add_menu( array(
        'id'     => 'emg-upgrade-bar',
        'href'   => 'https://ghozylab.com/plugins/ordernow.php?order=proplus&utm_source=lite&utm_medium=topbar&utm_campaign=orderfromtopbar',
        'parent' => 'top-secondary',
        'title'  => '<img src="' . esc_url( plugins_url( 'images/emg-dash-icon.png', dirname( __FILE__ ) ) ) . '" style="vertical-align:middle;margin-right:5px" alt="' . esc_attr__( 'Upgrade Now!', 'easy-media-gallery' ) . '" title="' . esc_attr__( 'Upgrade Now!', 'easy-media-gallery' ) . '" />' . esc_html__( 'Upgrade Easy Media Gallery to PRO Version', 'easy-media-gallery' ),
        'meta'   => array( 'class' => 'emg-upgrade-to-pro', 'target' => '_blank' ),
    ) );
}

/* Since @1.2.61 ( Respect Wordpress Guidelines)*/
if ( easy_get_option( 'easymedia_disen_admnotify' ) == '1' ) {

    if ( isset( $_GET['post_type'] ) && $_GET['post_type'] == 'easymediagallery' ) {
        add_action( 'admin_bar_menu', 'emg_admin_bar_menu', 1000 );
    }

}

/*-------------------------------------------------------------------------------*/

/*   Admin Notifications ( Setting Area )
/*-------------------------------------------------------------------------------*/
/*
if ( easy_get_option( 'easymedia_disen_admnotify' ) == '1' ) {
add_action( 'admin_enqueue_scripts', 'easmedia_put_notify_script' );
add_action('admin_head', 'easmedia_put_notify_head');
} */

function easmedia_put_notify_script()
{

    if ( isset( $_GET['page'] ) && $_GET['page'] == 'emg_settings' || isset( $_GET['page'] ) && $_GET['page'] == 'docs' || isset( $_GET['page'] ) && $_GET['page'] == 'comparison' || isset( $_GET['page'] ) && $_GET['page'] == 'easymedia-order' || get_post_type() == 'easymediagallery' ) {
        wp_enqueue_script( 'easymedia-notify-js', plugins_url( 'js/jquery/noty/jquery.noty.packaged.min.js', dirname( __FILE__ ) ) );
    }

}

function easmedia_put_notify_head()
{

    if ( isset( $_GET['page'] ) && $_GET['page'] == 'emg_settings' ) {
        ?>
<script type="text/javascript">
/*<![CDATA[*/
/* Easy Media Gallery */
function generate(e) {
    var emgNews = new Array(); /* Random Heading temporary disabled */
    emgNews[0] =
        "#1 Best Selling Gallery Plugin for WordPress<br />27,000+ PRO users from around the World can not be wrong...";
    emgNews[1] = "Easy to use, looks nice and has a very good feel";
    emgNews[2] = "Powerfull control panel and Shortcode Manager make getting started super easy";
    emgNews[3] = "Easy Media Gallery PRO can be used to embed more than 12 video. Not only from Youtube and Vimeo";
    emgNews[4] = "Powerfull control panel and Shortcode Manager make getting started super easy";
    var showH = Math.floor(Math.random() * emgNews.length);

    var t = noty({
        text: 'Upgrade your <strong>EASY MEDIA GALLERY LITE</strong> to <strong>PRO VERSION</strong> and extend standard plugin functionality with a tons of awesome features!',
        type: "warning",
        animation: {
            open: {
                height: "toggle"
            },
            close: {
                height: "toggle"
            },
            easing: "swing",
            speed: 700
        },
        dismissQueue: true,
        modal: true,
        layout: "bottom",
        killer: true,
        theme: "defaultTheme",
        template: '<div class="noty_message"><div id="emg_noty_container"><div id="emg_noty_images"><img id="emg_hero" src="<?php echo esc_url( plugins_url( 'images/emg_hero.png', dirname( __FILE__ ) ) ); ?>" width="100%" height="auto"/></div><div id="emg_noty_content"><h2>' +
            emgNews[0] + '</h2><span class="noty_text"></span></div></div><div class="noty_close"></div></div>',
        buttons: [{
                addClass: "emgnotyclosepermanent",
                text: "Disable notifications",
                onClick: function(e) {
                    e.close()
                }
            },
            {
                addClass: "tsc_buttons2 green",
                text: "UPGRADE NOW",
                onClick: function(e) {
                    e.close();
                    noty({
                        layout: "top",
                        modal: true,
                        text: '<span style="display:none;" id="emgordernote">Please click order button below and you will be redirected to order page shortly.</span><br /><a id="emgordrnow" style="display:none; margin: 15px 0 15px 0; "class="tsc_buttons2 green" href="https://ghozylab.com/plugins/ordernow.php?order=proplus&utm_source=lite&utm_medium=popup&utm_campaign=orderfrompopup" target="_blank">ORDER NOW</a><img id="emgorderspin" src="<?php echo esc_url( plugins_url( 'images/ajax-loader.gif', dirname( __FILE__ ) ) ); ?>" width="32" height="32"/><br /><p>Great! Please wait a moment...</p>',
                        type: "success"
                    });
                    setTimeout(function() {
                        jQuery("#emgorderspin").hide();
                        jQuery("#emgordernote").fadeIn("slow");
                        jQuery("#emgordrnow").fadeIn("slow");
                        jQuery(".noty_text p").hide()
                    }, 5e3)
                }
            }, {
                addClass: "tsc_buttons2 blue",
                text: "DEMO",
                onClick: function(e) {
                    window.location.href = "https://ghozylab.com/plugins/easy-media-gallery-pro/demo/";
                    e.close()
                }
            }, {
                addClass: "tsc_buttons2 orange",
                text: "Learn More",
                onClick: function(e) {
                    window.location.href = "edit.php?post_type=easymediagallery&page=comparison";
                    e.close()
                }
            }, {
                addClass: "tsc_buttons2 red",
                text: "Close",
                onClick: function(e) {
                    e.close()
                }
            }
        ],
        callback: {
            onShow: function() {
                jQuery("#ux_buy_pro").hide();
                jQuery("#emgadminnotice").hide()
            }
        }
    })
}

function generateAll() {
    generate("alert")
}
jQuery(document).ready(function() {
    <?php

        if ( isset( $_GET['page'] ) && $_GET['page'] == 'comparison' ) {?>
    setTimeout(function() {
        jQuery.noty.closeAll();
    }, 100);
    <?php }

        ?> generateAll();
    jQuery('.emgnotyclosepermanent').click(function() {
        var clickcmd = 'hide';
        emg_hide_noty(clickcmd);
    });

    function emg_hide_noty(clickcmd) {
        var data = {
            action: 'emg_hide_noty',
            hidesecurity: '<?php echo esc_js( wp_create_nonce( 'easymedia-lite-nonce-button' ) ); ?>',
            clickcmd: clickcmd,
        };
        jQuery.post(ajaxurl, data, function(response) {
            if (response == 0) {
                alert('Ajax request failed, please refresh your browser window and try again.');
                return false;
            }
        });
    }
})
/*]]>*/
</script>

<?php
}

}

/*-------------------------------------------------------------------------------*/
/*  Update Notify
/*-------------------------------------------------------------------------------*/
function easmedia_update_notify()
{
    ?>
<div class="error emg-setupdate">
    <p><?php echo wp_kses_post( __( 'We recommend you to enable plugin Auto Update so you will get the latest features and other important updates of Easy Media Gallery.<br />Click <a href="#"><strong><span id="doautoupdate">here</span></strong></a> to enable Auto Update.', 'easy-media-gallery' ) ); ?>
    </p>
</div>

<script type="text/javascript">
/*<![CDATA[*/
/* Easy Media Gallery */
jQuery(document).ready(function() {
    jQuery('#doautoupdate').click(function() {
        var cmd = 'activate';
        emg_enable_auto_update(cmd);
    });

    function emg_enable_auto_update(act) {
        var data = {
            action: 'emg_enable_auto_update',
            security: '<?php echo esc_js( wp_create_nonce( 'easymedia-update-nonce' ) ); ?>',
            cmd: act,
        };

        jQuery.post(ajaxurl, data, function(response) {
            if (response == 1) {
                alert('Awesome! Auto Update successfully activated.');
                jQuery('.emg-setupdate').fadeOut('3000');
            } else {
                alert('Ajax request failed, please refresh your browser window and try again.');
            }

        });
    }

});

/*]]>*/
</script>

<?php
}

function emg_enable_auto_update()
{

    check_ajax_referer( 'easymedia-update-nonce', 'security' );

    if ( ! isset( $_POST['cmd'] ) ) {
        echo '0';
        wp_die();
    } else {

        if ( $_POST['cmd'] == 'activate' ) {
            $emg_upd_opt                             = get_option( 'easy_media_opt' );
            $emg_upd_opt['easymedia_disen_autoupdt'] = '1';
            update_option( 'easy_media_opt', $emg_upd_opt );
            echo '1';
            wp_die();
        }

    }

}

add_action( 'wp_ajax_emg_enable_auto_update', 'emg_enable_auto_update' );

/*-------------------------------------------------------------------------------*/
/*  Create News MetaBox
/*-------------------------------------------------------------------------------*/
function easmedia_news_metabox()
{
    $new = '<div style="text-align:center;">';
    $new .= '<a style="outline: none !important;" href="https://ghozy.link/73fkh" target="_blank"><img style="cursor:pointer; margin-top: 7px; margin-bottom: 7px;" src="' . esc_url( plugins_url( 'images/new-release.png', dirname( __FILE__ ) ) ) . '" width="241" height="231" alt="New Release!" ></a>';
    $new .= '</div>';
    echo wp_kses_post( $new );
}

/*-------------------------------------------------------------------------------*/

/*  Add WordPress Pointers
/*-------------------------------------------------------------------------------*/

//add_action( 'admin_enqueue_scripts', 'easmedia_pointer_pointer_header' );
function easmedia_pointer_pointer_header()
{
    $enqueue = false;

    $dismissed = explode( ',', (string) get_user_meta( get_current_user_id(), 'dismissed_wp_pointers', true ) );

    if ( ! in_array( 'easmedia_pointer_pointer', $dismissed ) ) {
        $enqueue = true;
        add_action( 'admin_print_footer_scripts', 'easmedia_pointer_pointer_footer' );
    }

    if ( $enqueue ) {
        // Enqueue pointers
        wp_enqueue_script( 'wp-pointer' );
        wp_enqueue_style( 'wp-pointer' );
    }

}

function easmedia_pointer_pointer_footer()
{
    $pointer_content = '<h3>Thank You!</h3>';
    $pointer_content .= '<p>You&#39;ve just installed ' . esc_html( EASYMEDIA_NAME ) . '. Click <a class="close" href="edit.php?post_type=easymediagallery&page=emg-demo">here</a> to watch video tutorials and user guide plugin.</p>';
    ?>

<script type="text/javascript">
// <![CDATA[
jQuery(document).ready(function($) {

    if (typeof(jQuery().pointer) != 'undefined') {
        $('#menu-posts-easymediagallery').pointer({
            content: <?php echo wp_json_encode( $pointer_content ); ?>,
            position: {
                edge: 'left',
                align: 'center'
            },
            close: function() {
                $.post(ajaxurl, {
                    pointer: 'easmedia_pointer_pointer',
                    action: 'dismiss-wp-pointer'
                });
            }
        }).pointer('open');

    }

});
// ]]>
</script>
<?php
}

/*-------------------------------------------------------------------------------*/
/*   Admin Bar Menu
/*-------------------------------------------------------------------------------*/
require_once ABSPATH.'wp-includes/pluggable.php';

if ( current_user_can( 'install_plugins' ) ) {
    add_action( 'admin_bar_menu', 'add_toolbar_items', 100 );
}

function add_toolbar_items( $admin_bar )
{
    $admin_bar->add_menu( array(
        'id'    => 'emg-item',
        'title' => '<img src="' . esc_url( plugins_url( 'images/emg-dash-icon.png', dirname( __FILE__ ) ) ) . '" style="vertical-align:middle;margin-right:5px" alt="Easy Media" title="Easy Media Gallery" />Easy Media Gallery',
        'href'  => '#',
        'meta'  => array(
            'title' => __( 'Easy Media Gallery', 'easy-media-gallery' ),
        ),
    ) );

    $admin_bar->add_menu( array(
        'id'     => 'emg-ovrview-item',
        'parent' => 'emg-item',
        'title'  => 'Overview',
        'href'   => admin_url( 'edit.php?post_type=easymediagallery' ),
        'meta'   => array(
            'title' => __( 'Overview', 'easy-media-gallery' ),
            'class' => 'emg_menu_item_class',
        ),
    ) );

    $admin_bar->add_menu( array(
        'id'     => 'emg-addnew-item',
        'parent' => 'emg-item',
        'title'  => 'Add New Media',
        'href'   => admin_url( 'post-new.php?post_type=easymediagallery' ),
        'meta'   => array(
            'title' => __( 'Add New Media', 'easy-media-gallery' ),
            'class' => 'emg_menu_item_class',
        ),
    ) );

    $admin_bar->add_menu( array(
        'id'     => 'emg-cat-item',
        'parent' => 'emg-item',
        'title'  => 'Categories',
        'href'   => admin_url( 'edit-tags.php?taxonomy=emediagallery&post_type=easymediagallery' ),
        'meta'   => array(
            'title' => __( 'Categories', 'easy-media-gallery' ),
            'class' => 'emg_menu_item_class',
        ),
    ) );

    $admin_bar->add_menu( array(
        'id'     => 'emg-sett-item',
        'parent' => 'emg-item',
        'title'  => 'Settings',
        'href'   => admin_url( 'edit.php?post_type=easymediagallery&page=emg_settings' ),
        'meta'   => array(
            'title' => __( 'Settings', 'easy-media-gallery' ),
            'class' => 'emg_menu_item_class',
        ),
    ) );

    $admin_bar->add_menu( array(
        'id'     => 'emg-sort-item',
        'parent' => 'emg-item',
        'title'  => 'Sorter',
        'href'   => admin_url( 'edit.php?post_type=easymediagallery&page=easymedia-order' ),
        'meta'   => array(
            'title' => __( 'Sorter', 'easy-media-gallery' ),
            'class' => 'emg_menu_item_class',
        ),
    ) );

    $admin_bar->add_menu( array(
        'id'     => 'emg-demo-item',
        'parent' => 'emg-item',
        'title'  => 'Demo',
        'href'   => admin_url( 'edit.php?post_type=easymediagallery&page=emg-demo' ),
        'meta'   => array(
            'title' => __( 'Demo', 'easy-media-gallery' ),
            'class' => 'emg_menu_item_class',
        ),
    ) );

    $admin_bar->add_menu( array(
        'id'     => 'emg-freeplug-item',
        'parent' => 'emg-item',
        'title'  => '<span style="color:rgba(61, 170, 222, 1);">Free Install Plugins</span>',
        'href'   => admin_url( 'edit.php?post_type=easymediagallery&page=emg-free-plugins' ),
        'meta'   => array(
            'title' => __( 'Free Install Plugins', 'easy-media-gallery' ),
            'class' => 'emg_menu_item_class',
        ),
    ) );

    $admin_bar->add_menu( array(
        'id'     => 'emg-preplug-item',
        'parent' => 'emg-item',
        'title'  => '<span>Premium Plugins</span>',
        'href'   => admin_url( 'edit.php?post_type=easymediagallery&page=emg-premium-plugins' ),
        'meta'   => array(
            'title' => __( 'Premium Plugin', 'easy-media-gallery' ),
            'class' => 'emg_menu_item_class',
        ),
    ) );
    /*
    $admin_bar->add_menu( array(
    'id'    => 'emg-pricing-item',
    'parent' => 'emg-item',
    'title' => 'UPGRADE PRO VERSION',
    'href'  => ''.admin_url( 'edit.php?post_type=easymediagallery&page=comparison' ).'',
    'meta'  => array(
    'title' => __('UPGRADE PRO VERSION'),
    'class' => 'emg_menu_item_class'
    ),
    ));

    $admin_bar->add_menu( array(
    'id'    => 'emg-extra-item',
    'parent' => 'emg-item',
    'title' => '<span>Earn EXTRA MONEY</span>',
    'href'  => ''.admin_url( 'edit.php?post_type=easymediagallery&page=emg-earn-xtra-money' ).'',
    'meta'  => array(
    'title' => __('Earn EXTRA MONEY'),
    'class' => 'emg_menu_item_class'
    ),
    ));     */

    $admin_bar->add_menu( array(
        'id'     => 'emg-whatsnew-item',
        'parent' => 'emg-item',
        'title'  => 'What\'s New<span style="padding:0px 6px 0px 6px;background-color: #E74C3C; border-radius:9px;-moz-border-radius: 9px;-webkit-border-radius: 9px;margin-left:7px;color:#fff;font-size:10px !important;">NEW</span>',
        'href'   => ''.admin_url( 'edit.php?post_type=easymediagallery&page=emg-whats-new' ).'',
        'meta'   => array(
            'title' => __( 'UPGRADE PRO VERSION', 'easy-media-gallery' ),
            'class' => 'emg_menu_item_class',
        ),
    ) );

}

/**
 * Safely render remote feed HTML that may contain style tags.
 *
 * @param string $content HTML content from remote feed.
 * @return void
 */
function emg_render_remote_feed( $content ) {
    if ( empty( $content ) || ! is_string( $content ) ) {
        return;
    }

    $styles = '';
    if ( preg_match_all( '#<style[^>]*>(.*?)</style>#is', $content, $matches ) ) {
        $styles  = implode( "\n", $matches[1] );
        $content = preg_replace( '#<style[^>]*>.*?</style>#is', '', $content );
    }

    if ( is_string( $content ) ) {
        echo wp_kses_post( $content );
    }

    if ( ! empty( $styles ) ) {
        echo '<style type="text/css">' . esc_html( wp_strip_all_tags( $styles ) ) . '</style>';
    }
}

/*-------------------------------------------------------------------------------*/
/* Get latest info on What's New page
/*-------------------------------------------------------------------------------*/
function emg_lite_get_news()
{

    if ( false === ( $cache = get_transient( 'emg_whats_new' ) ) ) {

        $addlist = get_option( 'ecf_active_addons_lite' );

        $url = array(
            'c' => 'news',
            'p' => 'emglite',
        );

        $feed = wp_remote_get( 'https://content.ghozylab.com/feed.php?'.http_build_query( $url ).'', array( 'sslverify' => false, 'timeout' => 10 ) );

        if ( ! is_wp_error( $feed ) && 200 === wp_remote_retrieve_response_code( $feed ) ) {

            $body = wp_remote_retrieve_body( $feed );
            if ( ! empty( $body ) ) {
                $cache = $body;
                set_transient( 'emg_whats_new', $cache, 60 );
            } else {
                $cache = '';
            }

        } else {
            $cache = '';
        }

    }

    if ( ! empty( $cache ) && is_string( $cache ) ) {
        emg_render_remote_feed( $cache );
    }
}

/*-------------------------------------------------------------------------------*/
/* Generate EXTRA Page
/*-------------------------------------------------------------------------------*/
function emg_earn_xtra_money()
{

    wp_enqueue_script( 'emg-wnew' );

    $aff_id    = emg_get_aff_option( 'emg_affiliate_info', 'emg_aff_id', '' );
    $aff_name  = emg_get_aff_option( 'emg_affiliate_info', 'emg_aff_name', '' );
    $aff_email = emg_get_aff_option( 'emg_affiliate_info', 'emg_aff_email', '' );

    if ( ! empty( $aff_id ) ) {

        $iscon  = 'display:none;';
        $isdis  = '';
        $ists   = 'Connected';
        $intext = 'Disconnect';
        $cmd    = 'emg_affiliate_dis';

    } else {

        $iscon  = '';
        $isdis  = 'display:none;';
        $ists   = '';
        $intext = 'Connect';
        $cmd    = 'emg_affiliate_con';

    }
    ?>

<div id="emg-not-yet" style="<?php echo esc_attr( $iscon ); ?>">
    <h3>If you don't have a GhozyLab Affiliate account, you can sign up today for free <a
            href="https://ghozy.link/lqydz" target="_blank">here</a></h3>
    <h4 style="font-style:italic; color: #666;">Hurry Up! Join with GhozyLab Affiliate with 8,000 affiliates and pays
        out over $200,000 per year! Earn EXTRA MONEY and get 30% affiliate share from every sale you make!</h4>
    <p class="emg-iscon"
        style="font-style:italic; color:#666; border-bottom: 1px dotted #CCC; margin-top: 35px; padding-bottom: 5px;">
        <?php esc_html_e( 'Fill your Affiliate Account Email or Payment Email and press Connect button to start earn extra Money with us!', 'easy-media-gallery' ); ?>
    </p>
</div>

<div id="emg-aff-registered" style="width: auto; <?php echo esc_attr( $isdis ); ?>">
    <h3 id="emg-aff-holder">Hi, <?php echo esc_html( $aff_name . ' ( ' . $aff_email . ' )' ); ?></h3>
    <hr />
</div>

<form method="post">

    <?php settings_fields( 'emg_aff_section' );?>

    <table class="form-table">
        <tbody>
            <tr valign="top">
                <th style="width:155px !important;" scope="row" valign="top">
                    <?php esc_html_e( 'Account Email or Payment Email', 'easy-media-gallery' ); ?>
                </th>
                <td>
                    <input id="emg_aff_email" name="emg_aff_email" type="text" class="regular-text"
                        value="<?php echo esc_attr( $aff_email ); ?>" />
                    <label id="is-status" style="color:green; font-style:italic;" class="description"
                        for="emg_aff_email"><?php echo esc_html( $ists ); ?></label>

                    <?php wp_nonce_field( 'emg_aff_section_nonce', 'emg_aff_section_nonce' ); ?>
                    <br /><input style="margin-top: 10px;" data-nonce="<?php echo esc_attr( wp_create_nonce( 'emgaffiliate' ) ); ?>" data-cmd="<?php echo esc_attr( $cmd ); ?>" type="submit"
                        class="button-secondary" id="emg-aff" name="emg-aff" value="<?php echo esc_attr( $intext ); ?>" /><span
                        id="loader"></span><br /><br />
                    <span class="emg-aff-note">NOTE: To respect <a
                            href="https://wordpress.org/plugins/about/guidelines/" target="_blank">Plugin Guidelines</a>
                        ( point 10 ) so by pressing the connect button that means you are agree to displaying
                        <strong>Powered by</strong> link in your gallery footer</span>

                </td>
            </tr>
        </tbody>
    </table>

</form>

<hr style="margin-bottom:20px;">

<div class="feature-section">

    <img src="<?php echo esc_url( EASYMEDG_PLUGIN_URL . 'includes/images/aff-sc.jpg' ); ?>" class="emg-affiliate-screenshots" />

    <h4><?php esc_html_e( 'How does it work?', 'easy-media-gallery' ); ?></h4>
    <ul style="margin-left: 30px;list-style-type: circle;">
        <p><?php esc_html_e( 'After successfully registered with our Affiliate program what you have to do just :', 'easy-media-gallery' ); ?>
        </p>
        <li><?php esc_html_e( 'Fill your Affiliate Account Email or Payment Email in field above and Hit Connect button', 'easy-media-gallery' ); ?>
        </li>
        <li><?php esc_html_e( 'After connected you will see green connected status', 'easy-media-gallery' ); ?></li>
        <li><?php esc_html_e( 'Check your gallery and you will find your affiliate link in the bottom of your gallery like in the right side screenshot', 'easy-media-gallery' ); ?>
        </li>
        <li><?php esc_html_e( 'Now when individuals follow that link and subsequently make a purchase, you will be credited for the transaction and you will receive a payout', 'easy-media-gallery' ); ?>
        </li>
        <li><?php esc_html_e( 'Congratulations! You are ready to start to earn extra money with us :)', 'easy-media-gallery' ); ?>
        </li>
    </ul>

</div>

<?php
}

/*-------------------------------------------------------------------------------*/
/* Get Affiliate data
/*-------------------------------------------------------------------------------*/
function emg_get_aff_option( $option_name, $key, $default = false )
{

    $options = get_option( $option_name );

    if ( $options ) {
        return ( array_key_exists( $key, $options ) ) ? $options[$key] : $default;
    }

    return $default;
}

/*-------------------------------------------------------------------------------*/
/* Update Affiliate data
/*-------------------------------------------------------------------------------*/
function emg_update_aff_info( $aff_data, $email )
{
    $aff = array(
        'emg_aff_id'    => trim( $aff_data->aff_id ),
        'emg_aff_name'  => trim( $aff_data->aff_name ),
        'emg_aff_email' => trim( $email ),

    );

    update_option( 'emg_affiliate_info', $aff );

}

/*-------------------------------------------------------------------------------*/
/* Get Affiliate data ( API )
/*-------------------------------------------------------------------------------*/
function emg_get_aff_data()
{

// run a quick security check
    if ( ! check_ajax_referer( 'emgaffiliate', 'security' ) ) {
        return;
    }

    switch ( $_POST['command'] ) {

        case 'emg_affiliate_con':

// listen for aff button to be clicked
            if ( isset( $_POST['eml'] ) ) {

                $affemail = $_POST['eml'];

                $api_params = array(
                    'ghozy_action' => 'get_aff_data',
                    'email'        => $affemail,
                );

                // Call the custom API.
                $response = _emgaffiliateFetchmode( $api_params );

                if ( isset( $response ) && $response->status == true ) {

                    emg_update_aff_info( $response, $affemail );
                    echo json_encode( $response );

                } else {

                    $response = array(
                        'status'   => false,
                        'aff_id'   => false,
                        'aff_name' => false,
                    );

                    echo json_encode( $response );

                }

            }

            break;

        case 'emg_affiliate_dis':

            delete_option( 'emg_affiliate_info' );

            $response = array(
                'status'   => 'disconnected',
                'aff_id'   => false,
                'aff_name' => false,
            );

            echo json_encode( $response );

            break;

        default:
            break;

    }

    wp_die();

}

add_action( 'wp_ajax_emg_get_aff_data', 'emg_get_aff_data' );

/*-------------------------------------------------------------------------------*/
/* Defined for using CURL or Not
/*-------------------------------------------------------------------------------*/
function _emgaffiliateFetchmode( $api_params )
{

    if ( function_exists( 'curl_version' ) ) {

        $response = wp_remote_get( add_query_arg( $api_params, EMG_API_URLCURL ), array( 'timeout' => 15, 'sslverify' => false ) );

        if ( is_wp_error( $response ) ) {
            return false;
        }

        $dat = json_decode( wp_remote_retrieve_body( $response ) );

    } else {

        $json_url = add_query_arg( $api_params, EMG_API_URL );
        $json     = file_get_contents( $json_url );

        if ( is_wp_error( $json_url ) ) {
            return false;
        }

        $dat = json_decode( $json );

    }

    return $dat;

}

function emg_posts_notify( $hook )
{

    if ( get_option( 'emg_block_notify' ) == '' ) {

        $current_user = wp_get_current_user();
        $user_name    = $current_user->user_firstname ? $current_user->user_firstname : $current_user->user_login;
        // translators: %s: User display name.
        $cnt          = '<span class="emg_pp_content"><span class="emg_pp_user">' . sprintf( esc_html__( 'Hello %s', 'easy-media-gallery' ), esc_html( $user_name ) ) . '</span>' . esc_html__( 'Now you can easily insert Easy Media Gallery from Block > Common Blocks > Media Gallery', 'easy-media-gallery' ) . '</span><span class="emg_pp_img"><img class="emg-block-gif" src="' . esc_url( plugins_url( 'images/emg-block.gif', dirname( __FILE__ ) ) ) . '"></span>';

        wp_enqueue_style( 'emg-post-css', plugins_url( 'css/post.css', dirname( __FILE__ ) ) );
        wp_enqueue_script( 'emg-post', plugins_url( 'js/jquery/post.js', dirname( __FILE__ ) ) );
        wp_localize_script( 'emg-post', 'emg_popup', array( 'content' => $cnt ) );

    }

}

add_action( 'enqueue_block_editor_assets', 'emg_posts_notify' );

function emg_hide_block_notify()
{

    update_option( 'emg_block_notify', 'done' );

    wp_die();

}

add_action( 'wp_ajax_emg_hide_block_notify', 'emg_hide_block_notify' );

function emg_is_gutenberg_in_widget()
{

    if ( function_exists( 'get_current_screen' ) ) {

        $currentScreen = get_current_screen();

        $in_widget_page = ( isset( $currentScreen->id ) && $currentScreen->id === 'widgets' ? true : false );

        if ( function_exists( 'wp_use_widgets_block_editor' ) && wp_use_widgets_block_editor() && $in_widget_page ) {
            return true;
        }

    }

    return false;

}