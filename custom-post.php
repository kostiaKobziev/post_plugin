<?php
/*
Plugin Name: Custom post widget
Description: Adding custom shortcode for posts
Version: 1.0
Author: Kostia
*/

function load_custom_styles()
{
    wp_enqueue_style('custom-styles', plugin_dir_url(__FILE__) . 'dist/css/main.min.css', array(), '1.0.0', 'all');
}
add_action('wp_enqueue_scripts', 'load_custom_styles');

function load_custom_scripts()
{
    wp_enqueue_script('custom-scripts', plugin_dir_url(__FILE__) . 'dist/js/main.min.js', array('jquery'), '1.0.0', true);
}
add_action('wp_enqueue_scripts', 'load_custom_scripts');

function custom_articles_shortcode($atts)
{
    $atts = shortcode_atts(array(
        'from' => '',
        'to' => '',
    ), $atts);

    $args = array(
        'post_type' => 'post',
        'posts_per_page' => -1,
        'date_query' => array(
            'after' => $atts['from'],
            'before' => $atts['to'],
        ),
    );

    $articles_query = new WP_Query($args);

    if ($articles_query->have_posts()) {
        $output = '<div class="posts_wrapper">';
        $i = 1;
        while ($articles_query->have_posts()) {
            $articles_query->the_post();
            $output .= '<div class="post" data-i="' . $i . '">';
            if (has_post_thumbnail()) {
                $output .= '<div class="post-thumbnail">' . get_the_post_thumbnail() . '</div>';
            }
            $output .= '<h2>' . get_the_title() . '</h2>';
            $output .= '<p class="post-date">' . get_the_date() . '</p>';
            $output .= '</div>';
            $excerpt = wp_trim_words(get_the_excerpt(), 50);
            $output .= '<div class="popup-overlay"  data-i="' . $i . '">
                            <div class="popup-content">
                                <span class="close-popup">&times;</span>
                                <div class="post-thumbnail">' . get_the_post_thumbnail() . '</div>
                                <h2>' . get_the_title() . '</h2>
                                <p class="post-excerpt">' . $excerpt . '</p>
                                <a href="' . get_permalink() . '" class="read-more">Read more</a>
                            </div>
                        </div>';
            $i++;
        }
        $output .= '</div>';
        wp_reset_postdata();
        return $output;
    } else {
        return 'Nothing to show';
    }
}
add_shortcode('custom_articles', 'custom_articles_shortcode');
