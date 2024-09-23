<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// ADD STYLE & SCRIPT
add_action( 'admin_head', 'emg_editor_add_init', 20 );
add_action( 'admin_footer', 'emg_popup_content' );

function emg_editor_add_init()
{

    if ( emg_is_gutenberg_in_widget() || strstr( $_SERVER['REQUEST_URI'], 'wp-admin/post-new.php' ) || strstr( $_SERVER['REQUEST_URI'], 'wp-admin/post.php' ) ) {

        if ( get_post_type( get_the_ID() ) != 'easymediagallery' ) {

            wp_enqueue_style( 'thickbox' );
            wp_enqueue_script( 'thickbox' );

            wp_enqueue_style( 'easymedia-tinymce' );
            wp_enqueue_style( 'jquery-multiselect-css' );
            wp_enqueue_style( 'jquery-ui-themes-redmond' );
            wp_enqueue_style( 'emg-tabs-css' );
            wp_enqueue_style( 'emg-tabs-style' );
            wp_enqueue_script( 'emg-tabs' );
            wp_enqueue_script( 'jquery-multi-sel' );
            wp_enqueue_script( 'easymedia-cpscript', plugins_url( 'functions/tinymce-dlg.js', __FILE__ ) );
            wp_enqueue_script( 'jquery-i-button', plugins_url( 'js/jquery/jquery.ibutton.js', __FILE__ ) );
            wp_enqueue_style( 'metabox-ibuttoneditor', plugins_url( 'css/ibutton.css', __FILE__ ), false, EASYMEDIA_VERSION );

            add_action( 'media_buttons', 'add_emg_shortcode_button' );

            $tinymcedata = array(
                'sc_icon'    => plugins_url( 'images/emg-scmanager-icon.png', __FILE__ ),
                'sc_version' => EASYMEDIA_VERSION,
            );

            wp_localize_script( 'easymedia-cpscript', 'emg_tinymce_vars', $tinymcedata );

        }

    }

}

function add_emg_shortcode_button()
{

    $img = plugins_url( 'images/emg-scmanager-icon.png', __FILE__ );
    printf( '<a class="thickbox button" id="emg_gut_shorcode-button" title="Easy Media Shortcode" style="outline: medium none !important; cursor: pointer;" ><img src="'.$img.'" alt="Easy Media Gallery" width="20" height="20" style="position:relative; top:-2px"/>Easy Media Gallery</a>'.''.'</a>', '#' );

}

// GENERATE POPUP CONTENT
function emg_popup_content()
{

    if ( emg_is_gutenberg_in_widget() || strstr( $_SERVER['REQUEST_URI'], 'wp-admin/post-new.php' ) || strstr( $_SERVER['REQUEST_URI'], 'wp-admin/post.php' ) ) {

        if ( get_post_type( get_the_ID() ) != 'easymediagallery' ) {
            // START GENERATE POPUP CONTENT
            $shortname = 'emgtinymce';

            $optn = array(
                array( 'name' => 'Order media by',
                    'id'         => $shortname.'_select_method',
                    'type'       => 'select',
                    'options'    => array( 'Category', 'Media' ),
                    'std'        => 'Choose a category' ),

                array( 'name' => 'Choose a category',
                    'id'         => $shortname.'_select_cat',
                    'type'       => 'selectcat',
                    'options'    => '',
                    'std'        => '' ),

                array( 'name' => 'Choose media',
                    'id'         => $shortname.'_select_sing_media',
                    'type'       => 'selectmedia',
                    'options'    => '',
                    'std'        => '' ),

                array( 'name' => 'Choose Gallery',
                    'id'         => $shortname.'_select_gallery',
                    'type'       => 'selectgallery',
                    'options'    => '',
                    'std'        => '' ),

            );

            ?>
<div class="emg-sc-manager" id="emgmodal" style="display:none;">
    <div id="tinyemg">
        <div class="emghorizontalTab" id="horizontalTab">
            <ul>
                <li id="emgfirsttab"><a data-formid="emg-shortcode-advanced" href="#tab-1">Gallery, Album & Slider</a>
                </li>
                <li><a data-formid="emg-shortcode-basic" href="#tab-2">Basic Album, Media & Categories</a></li>
            </ul>

            <div id="tab-1">
                <form id="emg-shortcode-advanced" method="post">
                    <label class="label_optionglry" for="listgallery">Select Gallery</label>
                    <select class="tinymce_select" name="listgallery" id="listcustomgallery">
                        <?php

            global $post;
            $args = array(
                'post_type'      => 'easymediagallery',
                'order'          => 'ASC',
                'post_status'    => 'publish',
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

            foreach ( $myposts as $post ): setup_postdata( $post );?>
				                        <option id="<?php echo $post->ID; ?>" type="text" value="<?php echo $post->ID; ?>" />
				                        <?php echo esc_html( esc_js( the_title( null, null, false ) ) ); ?></option>
				                        <?php endforeach;

            ?>
                    </select>

                    <div id="markas_div" style="margin-left:25px; margin-top: 20px;">
                        <div class="emgspacer">
                            <input id="defgallery" class="emgradiogalltype" type="radio" name="emgtinymce_mark_as"
                                value="easymedia-gallery" checked="checked" />Set as Simple Gallery
                        </div>
                        <div class="emgspacer">
                            <input id="emgspacer" class="emgradiogalltype setaspro" type="radio"
                                name="emgtinymce_mark_as" value="easymedia-gallery" checked="checked" />Set as
                            Filterable Gallery --- <span class="promarker">(PRO Version)</span> - <a
                                href="https://ghozy.link/s89w3" target="_blank">see demo</a>
                        </div>
                        <div class="emgspacer">
                            <input class="emgradiogalltype setaspro" type="radio" name="emgtinymce_mark_as"
                                value="easy-media-album" />Set as Photo Albums --- <span class="promarker">(PRO
                                Version)</span> - <a href="https://ghozy.link/l76cz" target="_blank">see demo</a>
                        </div>
                        <div class="emgspacer">
                            <input class="emgradiogalltype setaspro" type="radio" name="emgtinymce_mark_as"
                                value="easymedia-slider-one" />Set as Slider --- <span class="promarker">(PRO
                                Version)</span> - <a href="https://ghozy.link/u6c9p" target="_blank">see demo</a>
                        </div>
                        <div class="emgspacer">
                            <input class="emgradiogalltype setaspro" type="radio" name="emgtinymce_mark_as"
                                value="easymedia-fotorama" />Set as Fotorama Slider --- <span class="promarker">(PRO
                                Version)</span> - <a href="https://ghozy.link/y2lov" target="_blank">see demo</a>
                        </div>
                        <div class="emgspacer">
                            <input class="emgradiogalltype setaspro" type="radio" name="emgtinymce_mark_as"
                                value="easymedia-carousel" />Set as Carousel --- <span class="promarker">(PRO
                                Version)</span> - <a href="https://ghozy.link/y2nlk" target="_blank">see demo</a>
                        </div>
                    </div>

                    <div class="sc_button1">
                        <input type="button" value="Insert Shortcode" id="emg_insert_gallery"
                            class="button-secondary" />
                        <div class="clearfix"></div>
                    </div>
                    <input style="display:none;" name="gallery_value" data-select="listcustomgallery" type="text"
                        value="" />
                </form>
            </div><!-- #TAB-1 END  -->

            <div id="tab-2">
                <form id="emg-shortcode-basic" method="post">
                    <?php

            foreach ( $optn as $value ) {

                switch ( $value['type'] ) {

                    case 'text':
                        ?>

                    <div class="sc_input sc_text">
                        <label for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label> <br />
                        <input name="<?php echo $value['id']; ?>" id="<?php echo $value['id']; ?>" type="text"
                            value="<?php $value['std'];?>" />
                        <div class="clearfix"></div>
                    </div>
                    <?php break;

                    case 'select':
                        ?>

                    <div class="sc_input sc_select" id="<?php echo $value['id']; ?>_div">
                        <label class="label_optionttl"
                            for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
                        <select class="tinymce_select" name="<?php echo $value['id']; ?>"
                            id="<?php echo $value['id']; ?>">
                            <option value="0">Select</option>
                            <?php

                        foreach ( $value['options'] as $state ) {?>
                            <option id="<?php echo $state; ?>" value="<?php echo $state; ?>"><?php echo $state; ?>
                            </option>
                            <?php }

                        ?>
                        </select>

                        <div class="clearfix"></div>
                    </div>
                    <?php
break;

                    case 'selectcat':
                        ?>

                    <div class="sc_input sc_select" id="<?php echo $value['id']; ?>_div">
                        <label class="label_optionttl"
                            for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
                        <?php $states = get_terms( 'emediagallery', array( 'hide_empty' => true ) );?>
                        <select class="tinymce_select" name="<?php echo $value['id']; ?>"
                            id="<?php echo $value['id']; ?>">
                            <option value="0">Select</option>
                            <?php

                        foreach ( $states as $state ) {?>
                            <option id="<?php echo $state->term_id; ?>" value="<?php echo $state->term_id; ?>">
                                <?php echo $state->name; ?></option>
                            <?php }

                        ?>
                        </select>
                        <div class="clearfix"></div>
                    </div>
                    <?php

                        break;

                    case 'selectmedia':
                        ?>

                    <div class="sc_input sc_select" id="<?php echo $value['id']; ?>_div">
                        <label class="label_optionttl"
                            for="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></label>
                        <select class="tinymce_select" name="<?php echo $value['id']; ?>"
                            id="<?php echo $value['id']; ?>">
                            <?php

                        global $post;
                        $args = array(
                            'post_type'      => 'easymediagallery',
                            'order'          => 'ASC',
                            'post_status'    => 'publish',
                            'posts_per_page' => -1,
                        );

                        /*
                        Thanks to Kevin Falcoz (aka 0pc0deFR) for this discovery and this patch.
                        ::: esc_html(esc_js(the_title(NULL, NULL, FALSE))); :::
                         */

                        $myposts = get_posts( $args );

                        foreach ( $myposts as $post ): setup_postdata( $post );?>
				                            <option id="<?php echo $post->ID; ?>" type="text" value="<?php echo $post->ID; ?>" />
				                            <?php echo esc_html( esc_js( the_title( null, null, false ) ) ); ?></option>
				                            <?php endforeach;
                        ?>
                        </select>
                        <div class="clearfix"></div>
                    </div>
                    <?php
break;
                }

            }

            ?>


                    <div class="sc_input sc_select" id="custom_col_div">
                        <label class="label_optionttl" for="emgtinymce_custom_columns">Custom columns</label>
                        <div>
                            <input class="switch emgtinyswitch" type="checkbox" name="emgtinymce_custom_columns"
                                id="emgtinymce_custom_columns" value="false" />
                        </div>
                        <div id="customcolumns" style="margin-top: 10px;">
                            <label class="label_suboption">Columns :</label>
                            <div>

                                <select class="tinymce_select" name="select_custom_col" id="select_custom_col">
                                    <option value="0">Select</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                </select>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <div class="sc_input sc_select" id="custom_align_div">
                        <label class="label_optionttl" for="emgtinymce_custom_align">Custom alignment</label>
                        <div>
                            <input class="switch emgtinyswitch" type="checkbox" name="emgtinymce_custom_align"
                                id="emgtinymce_custom_align" value="false" />
                        </div>
                        <div id="customalign" style="margin-top: 10px;">
                            <label class="label_suboption">Align :</label>
                            <div>
                                <select class="tinymce_select" name="select_cus_align" id="select_cus_align">
                                    <option value="0">Select</option>
                                    <option value="Center">Center</option>
                                    <option value="None">None</option>
                                </select>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <?php

            if ( easy_get_option( 'easymedia_disen_admnotify' ) == '1' ) {?>
                    <div class="sc_input sc_select" id="upd_topro">
                        <p class="emg_blink" style="color:#F00;">UPGRADE to PRO Version and get Advanced Shortcode, <a
                                target="_blank"
                                href="<?php echo plugins_url( 'includes/images/pro-version-shortcode-manager.png', dirname( __FILE__ ) ) ?>"
                                style="text-decoration:underline !important;">Click for Screenshot</a></p>
                        <div class="clearfix"></div>
                    </div> <?php }

            ?>

                    <div class="sc_button1">
                        <input type="button" value="Insert Shortcode" id="emg_insert_media" class="button-secondary" />
                        <div class="clearfix"></div>
                    </div>
                    <input style="display:none;" name="singlemedia_value" data-select="emgtinymce_select_sing_media"
                        type="text" value="" />
                </form>
            </div> <!-- #TAB END  -->

            <input style="display:none;" type="text" value="" id="thisresult">
            <input style="display:none;" type="text" value="" id="thisgallresult">
        </div>
    </div>
</div>
<?php
}

    }

}