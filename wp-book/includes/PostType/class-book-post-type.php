<?php

namespace WPBook\Includes\PostType;

class BookPostType {
    public function init() {
        add_action("init", array($this, "register_post_type"));
        add_action("init", array($this,"register_taxonomies"));
    }

    public function register_post_type($post_type) {
        register_post_type( 'book', [
            'label'         => __( 'Books', 'wp-book' ),
            'public'        => true,
            'menu_icon'     => 'dashicons-book',
            'supports'      => [ 'title', 'editor', 'thumbnail' ],
            'rewrite'       => [ 'slug' => 'books' ],
            'show_in_rest'  => true,
        ] );
    }

    public function register_taxonomies() {
        // Book Category (hierarchical).
        register_taxonomy( 'book_category', 'book', [
            'hierarchical' => true,
            'label'        => __( 'Book Category', 'wp-book' ),
            'rewrite'      => [ 'slug' => 'book-category' ],
        ] );

        // Book Tag (non-hierarchical).
        register_taxonomy( 'book_tag', 'book', [
            'hierarchical' => false,
            'label'        => __( 'Book Tag', 'wp-book' ),
            'rewrite'      => [ 'slug' => 'book-tag' ],
        ] );
    }
}