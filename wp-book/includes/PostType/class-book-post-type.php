<?php

namespace WPBook\Includes\PostType;

class BookPostType {
    public function init() {
        add_action("init", array($this, "register_post_type"));
        add_action("init", array($this,"register_taxonomies"));
    }

    public function register_post_type($post_type) {
        $labels = [
            'name'                  => __( 'Books', 'wp-book' ),
            'singular_name'         => __( 'Book', 'wp-book' ),
            'add_new'               => __( 'Add New Book', 'wp-book' ),
            'add_new_item'          => __( 'Add New Book', 'wp-book' ),
            'edit_item'             => __( 'Edit Book', 'wp-book' ),
            'new_item'              => __( 'New Book', 'wp-book' ),
            'view_item'             => __( 'View Book', 'wp-book' ),
            'search_items'          => __( 'Search Books', 'wp-book' ),
            'not_found'             => __( 'No books found', 'wp-book' ),
            'not_found_in_trash'    => __( 'No books found in Trash', 'wp-book' ),
            'all_items'             => __( 'All Books', 'wp-book' ),
            'archives'              => __( 'Book Archives', 'wp-book' ),
            'insert_into_item'      => __( 'Insert into book', 'wp-book' ),
            'uploaded_to_this_item' => __( 'Uploaded to this book', 'wp-book' ),
            'menu_name'             => __( 'Books', 'wp-book' ),
            'name_admin_bar'        => __( 'Book', 'wp-book' ),
        ];
    
        register_post_type( 'book', [
            'labels'        => $labels,
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
            'show_in_rest' => true,
        ] );

        // Book Tag (non-hierarchical).
        register_taxonomy( 'book_tag', 'book', [
            'hierarchical' => false,
            'label'        => __( 'Book Tag', 'wp-book' ),
            'rewrite'      => [ 'slug' => 'book-tag' ],
            'show_in_rest' => true,
        ] );
    }
}