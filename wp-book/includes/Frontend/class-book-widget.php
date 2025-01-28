<?php

namespace WPBook\Includes\Frontend;

class BookWidget extends \WP_Widget {
    public function __construct() {
        parent::__construct(
            'book_widget',
            __( 'Book Category Widget', 'wp-book-plugin' ),
            [ 'description' => __( 'Displays books from a selected category.', 'wp-book-plugin' ) ]
        );
    }

    public function widget( $args, $instance ) {
        echo $args['before_widget'];
        if ( ! empty( $instance['title'] ) ) {
            echo $args['before_title'] . apply_filters( 'widget_title', $instance['title'] ) . $args['after_title'];
        }

        $category = ! empty( $instance['category'] ) ? $instance['category'] : '';
        $query    = new \WP_Query( [
            'post_type'      => 'book',
            'posts_per_page' => 5,
            'tax_query'      => [
                [
                    'taxonomy' => 'book_category',
                    'field'    => 'term_id',
                    'terms'    => $category,
                ],
            ],
        ] );

        if ( $query->have_posts() ) {
            echo '<ul class="book-widget-list">';
            while ( $query->have_posts() ) {
                $query->the_post();
                echo '<li><a href="' . get_permalink() . '">' . get_the_title() . '</a></li>';
            }
            echo '</ul>';
        } else {
            echo '<p>' . __( 'No books found in this category.', 'wp-book-plugin' ) . '</p>';
        }
        wp_reset_postdata();
        echo $args['after_widget'];
    }

    public function form( $instance ) {
        $title    = ! empty( $instance['title'] ) ? $instance['title'] : __( 'Books', 'wp-book-plugin' );
        $category = ! empty( $instance['category'] ) ? $instance['category'] : '';
        ?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'wp-book-plugin' ); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
        </p>
        <p>
            <label for="<?php echo $this->get_field_id( 'category' ); ?>"><?php _e( 'Category:', 'wp-book-plugin' ); ?></label>
            <select class="widefat" id="<?php echo $this->get_field_id( 'category' ); ?>" name="<?php echo $this->get_field_name( 'category' ); ?>">
                <?php
                $categories = get_terms( [ 'taxonomy' => 'book_category', 'hide_empty' => false ] );
                foreach ( $categories as $cat ) {
                    echo '<option value="' . esc_attr( $cat->term_id ) . '"' . selected( $category, $cat->term_id, false ) . '>' . esc_html( $cat->name ) . '</option>';
                }
                ?>
            </select>
        </p>
        <?php
    }

    public function update( $new_instance, $old_instance ) {
        $instance             = [];
        $instance['title']    = sanitize_text_field( $new_instance['title'] );
        $instance['category'] = sanitize_text_field( $new_instance['category'] );
        return $instance;
    }
}
