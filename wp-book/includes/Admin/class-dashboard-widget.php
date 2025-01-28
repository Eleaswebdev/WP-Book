<?php

namespace WPBook\Includes\Admin;

class DashboardWidget {
    public function init() {
        add_action( 'wp_dashboard_setup', [ $this, 'add_dashboard_widget' ] );
    }

    public function add_dashboard_widget() {
        wp_add_dashboard_widget(
            'book_category_widget',
            __( 'Top 5 Book Categories', 'wp-book-plugin' ),
            [ $this, 'render_widget' ]
        );
    }

    public function render_widget() {
        $categories = get_terms( [
            'taxonomy'   => 'book_category',
            'orderby'    => 'count',
            'order'      => 'DESC',
            'number'     => 5,
            'hide_empty' => true,
        ] );

        if ( ! empty( $categories ) ) {
            echo '<ul>';
            foreach ( $categories as $category ) {
                echo '<li>' . esc_html( $category->name ) . ' (' . esc_html( $category->count ) . ' books)</li>';
            }
            echo '</ul>';
        } else {
            echo '<p>' . __( 'No categories found.', 'wp-book-plugin' ) . '</p>';
        }
    }
}
