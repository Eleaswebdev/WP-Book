<?php

namespace WPBook\Includes\Meta;

class BookMetaBox {
    public function init() {
        add_action("add_meta_boxes", array( $this,"add_meta_box") );
        add_action("save_post", array( $this,"save_meta_data") );
    }

    public function add_meta_box() {
        add_meta_box(
            'book_meta_box',
            __( 'Book Details', 'wp-book' ),
            [ $this, 'render_meta_box' ],
            'book',
            'normal',
            'high'
        );
    }

    public function render_meta_box( $post ) {
        wp_nonce_field( 'book_meta_box_action', 'book_meta_box_nonce' );

        $fields = [
            'author_name' => __( 'Author Name', 'wp-book' ),
            'price'       => __( 'Price', 'wp-book' ),
            'publisher'   => __( 'Publisher', 'wp-book' ),
            'year'        => __( 'Year', 'wp-book' ),
            'edition'     => __( 'Edition', 'wp-book' ),
            'url'         => __( 'URL', 'wp-book' ),
        ];

        foreach ( $fields as $field => $label ) {
            $value = get_post_meta( $post->ID, $field, true );
            echo "<p><label for='{$field}'>{$label}</label><br>";
            echo "<input type='text' id='{$field}' name='{$field}' value='" . esc_attr( $value ) . "' style='width: 100%;'></p>";
        }
    }

    public function save_meta_data( $post_id ) {
        if ( ! isset( $_POST['book_meta_box_nonce'] ) || ! wp_verify_nonce( $_POST['book_meta_box_nonce'], 'book_meta_box_action' ) ) {
            return;
        }

        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return;
        }

        $fields = [ 'author_name', 'price', 'publisher', 'year', 'edition', 'url' ];

        foreach ( $fields as $field ) {
            if ( isset( $_POST[ $field ] ) ) {
                update_post_meta( $post_id, $field, sanitize_text_field( $_POST[ $field ] ) );
            }
        }
    }
}