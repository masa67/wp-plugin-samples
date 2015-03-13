<?php
/**
 * @package Stages
 * @version 1.0
 */
/*
 * Plugin Name: Stagestut
 * Plugin URI: http://www.deveteam.com
 * Description: 100% Web based solution for real time and efficient online sales, customer service, field service and training.
 * Version: 1.0
 * Author: Deveteam
 * Author URI: http://www.deveteam.com
 */

add_action('add_meta_boxes', 'stagestut_add_metabox');
add_action('admin_init', 'stagestut_admin_init');
add_action('admin_menu', 'stagestut_plugin_menu');
add_action('save_post', 'stagestut_save_metabox');
add_action('widgets_init', 'stagestut_widget_init');
add_action('wp', 'stagestut_init');
add_action('wp_ajax_stagestut_add_wishlist', 'stagestut_add_wishlist_process');
// if not logged in, use this: add_action('wp_ajax_nopriv_myajax-submit', 'myajax_submit');

function stagestut_add_metabox() {
    add_meta_box('stagestut_youtube', 'YouTube Video Link', 'stagestut_youtube_handler', 'post');
}

function stagestut_add_wishlist_process() {
    echo 'hello back from post id:'.$_POST['postId'];
    exit();
}

function stagestut_admin_init() {
    register_setting('stages-group', stagestut_dashboard_title);
    register_setting('stages-group', stagestut_number_of_items);
}

function stagestut_init() {
    wp_register_script('stageswishlist-js', plugins_url('/stageswishlist.js', __FILE__),
        array('jquery'));

    wp_enqueue_script('jquery');
    wp_enqueue_script('stageswishlist-js');

    global $post;
    wp_localize_script('stageswishlist-js', 'MyAjax', array(
        'action' => 'stagestut_add_wishlist',
        'postId' => $post->ID
    ));
}

function stagestut_plugin_menu() {
    add_options_page(
        'Stagestut Wishlist Options',
        'Stagestut Wishlist',
        'manage_options',
        'stagestut',
        'stagestut_plugin_options');
}

function stagestut_plugin_options() {
    ?>
    <div class="wrap">
        <h2>Stages Wishlist</h2>
        <form action="options.php" method="post">
            <?php settings_fields('stages-group'); ?>
            <?php @do_settings_fields('stages-group'); ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row"><label for="stagestut_dashboard_title">Dashboard widget title</label></th>
                    <td>
                        <input type="text"
                               name="stagestut_dashboard_title"
                               id="stagestut_dashboard_title"
                               value="<?php echo get_option('stagestut_dashboard_title'); ?>" />
                        <br /><small>help text for this field</small>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><label for="stagestut_number_of_items">Number of items to show</label></th>
                    <td>
                        <input type="text"
                               name="stagestut_number_of_items"
                               id="stagestut_number_of_items"
                               value="<?php echo get_option('stagestut_number_of_items'); ?>" />
                        <br/><small>help text for this field</small>
                    </td>
                </tr>
            </table> <?php @submit_button(); ?>
        </form>
    </div>
    <?php
}

function stagestut_save_metabox($post_id) {
    if (defined( 'DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post')) {
        return;
    }

    if (isset($_POST['stagestut_youtube'])) {
        update_post_meta($post_id, 'stagestut_youtube', esc_url($_POST['stagestut_youtube']));
    }
}

function stagestut_widget_init() {
    register_widget(Stagestut_Widget);
}

function stagestut_youtube_handler() {
    $value = get_post_custom($post->ID);
    $youtube_link = $value['stagestut_youtube'][0];
    $youtube_link = esc_attr( $value['stagestut_youtube'][0] );
    echo '<label for="stagestut_youtube">YouTube Video Link</label><input type="text" id="stagestut_youtube" name="stagestut_youtube" value="'.$youtube_link.'" />';
}

class Stagestut_Widget extends WP_Widget {
    function stagestut_Widget() {
        $widget_options = array(
            'classname' => 'stages-class',
            'description' => 'Show a YouTube video from post metadata'
        );

        $this->WP_Widget('stages-id', 'YouTube Video', $widget_options);
    }

    function form($instance) {
        $defaults = array('title' => 'Video');
        $instance = wp_parse_args( (array) $instance, $defaults);

        $title = esc_attr($instance['title']);

        echo '<p>Title <input type="text" class="widefat" name="'
            .$this->get_field_name('title')
            .'" value="'
            .$title
            .'" /></p>';
    }

    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        return $instance;
    }

    function widget($args, $instance) {
        extract($args);
        $title = apply_filters('widget_title', $instance['title']);
        if (is_single()) {
            echo $before_widget;
            echo $before_title.$title.$after_title;

            if (!is_user_logged_in()) {
                echo 'Please sign in to use this widget';
            } else {
                /*
                $stagestut_youtube = get_post_meta(get_the_ID(), 'stagestut_youtube', true);
                */
                echo '<iframe width="200" height="200" frameborder="0" allowfullscreen src="http://www.youtube.com/embed/'
                    . get_yt_videoid($stagestut_youtube)
                    . '"></iframe>';


                echo '<span id="stagestut_add_wishlist_div"><a id="stagestut_add_wishlist" href="">Add to wishlist</a></span>';
            }

            echo $after_widget;
        }
    }
}

function get_yt_videoid($url) {
    parse_str(parse_url($url, PHP_URL_QUERY), $my_array_of_vars);
    return $my_array_of_vars['v'];
}