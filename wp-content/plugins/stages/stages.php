<?php
/**
 * @package Stages
 * @version 1.0
 */
/*
 * Plugin Name: Stages
 * Plugin URI: http://www.deveteam.com
 * Description: 100% Web based solution for real time and efficient online sales, customer service, field service and training.
 * Version: 1.0
 * Author: Deveteam
 * Author URI: http://www.deveteam.com
 */

add_action('add_meta_boxes', 'stages_add_metabox');
add_action('admin_init', 'stages_admin_init');
add_action('admin_menu', 'stages_plugin_menu');
add_action('save_post', 'stages_save_metabox');
add_action('widgets_init', 'stages_widget_init');
add_action('wp', 'stages_init');

function stages_add_metabox() {
    add_meta_box('stages_youtube', 'YouTube Video Link', 'stages_youtube_handler', 'post');
}

function stages_admin_init() {
    register_setting('stages-group', stages_dashboard_title);
    register_setting('stages-group', stages_number_of_items);
}

function stages_init() {
    wp_register_script('stageswishlist-js', plugins_url('/stageswishlist.js', __FILE__),
        array('jquery'));

    wp_enqueue_script('jquery');
    wp_enqueue_script('stageswishlist-js');
}

function stages_plugin_menu() {
    add_options_page(
        'Stages Wishlist Options',
        'Stages Wishlist',
        'manage_options',
        'stages',
        'stages_plugin_options');
}

function stages_plugin_options() {
    ?>
    <div class="wrap">
        <h2>Stages Wishlist</h2>
        <form action="options.php" method="post">
            <?php settings_fields('stages-group'); ?>
            <?php @do_settings_fields('stages-group'); ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row"><label for="stages_dashboard_title">Dashboard widget title</label></th>
                    <td>
                        <input type="text"
                               name="stages_dashboard_title"
                               id="stages_dashboard_title"
                               value="<?php echo get_option('stages_dashboard_title'); ?>" />
                        <br /><small>help text for this field</small>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row"><label for="stages_number_of_items">Number of items to show</label></th>
                    <td>
                        <input type="text"
                               name="stages_number_of_items"
                               id="stages_number_of_items"
                               value="<?php echo get_option('stages_number_of_items'); ?>" />
                        <br/><small>help text for this field</small>
                    </td>
                </tr>
            </table> <?php @submit_button(); ?>
        </form>
    </div>
    <?php
}

function stages_save_metabox($post_id) {
    if (defined( 'DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post')) {
        return;
    }

    if (isset($_POST['stages_youtube'])) {
        update_post_meta($post_id, 'stages_youtube', esc_url($_POST['stages_youtube']));
    }
}

function stages_widget_init() {
    register_widget(Stages_Widget);
}

function stages_youtube_handler() {
    $value = get_post_custom($post->ID);
    $youtube_link = $value['stages_youtube'][0];
    $youtube_link = esc_attr( $value['stages_youtube'][0] );
    echo '<label for="stages_youtube">YouTube Video Link</label><input type="text" id="stages_youtube" name="stages_youtube" value="'.$youtube_link.'" />';
}

class Stages_Widget extends WP_Widget {
    function Stages_Widget() {
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

            /*
            $stages_youtube = get_post_meta(get_the_ID(), 'stages_youtube', true);
            */
            echo '<iframe width="200" height="200" frameborder="0" allowfullscreen src="http://www.youtube.com/embed/'
                .get_yt_videoid($stages_youtube)
                .'"></iframe>';


            echo '<span id="stages_add_wishlist_div"><a id="stages_add_wishlist" href="">Add to wishlist</a></span>';
            echo $after_widget;
        }

    }
}

function get_yt_videoid($url) {
    parse_str(parse_url($url, PHP_URL_QUERY), $my_array_of_vars);
    return $my_array_of_vars['v'];
}