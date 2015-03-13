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

add_action('widgets_init', 'stages_widget_init');

function stages_widget_init() {
    register_widget(Stages_Widget);
}

function stages_add_metabox() {
    add_meta_box('stages_youtube', 'YouTube Video Link', 'stages_youtube_handler', 'post');
}

function stages_youtube_handler() {
    $value = get_post_custom($post->ID);
    $youtube_link = $value['stages_youtube'][0];
    $youtube_link = esc_attr($value['stages_youtube'][0]);
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

    }

    function update($new_instance, $old_instance) {

    }

    function widget($args, $instance) {

    }
}