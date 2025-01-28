<?php

namespace WPBook\Includes\Database;

class CustomMetaTable {

    private $table_name;

    public function __construct() {
        global $wpdb;
        $this->table_name = $wpdb->prefix . 'book_meta';
    }
    public function init() {
        register_activation_hook( WP_BOOK_PATH . 'wp-book.php', [ $this, 'create_table' ] );
        add_action( 'save_post_book', [ $this, 'save_to_custom_table' ], 10, 3 );
    }

    public function create_table() {
        global $wpdb;
        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE {$this->table_name} (
            id BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            book_id BIGINT(20) UNSIGNED NOT NULL,
            meta_key VARCHAR(255) NOT NULL,
            meta_value LONGTEXT NOT NULL,
            PRIMARY KEY (id),
            UNIQUE KEY book_meta (book_id, meta_key)
        ) $charset_collate;";

        require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        dbDelta( $sql );
    }

    public function save_to_custom_table( $post_id, $post, $update ) {
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
            return;
        }

        global $wpdb;
        $fields = [ 'author_name', 'price', 'publisher', 'year', 'edition', 'url' ];

        foreach ( $fields as $field ) {
            if ( isset( $_POST[ $field ] ) ) {
                $meta_value = sanitize_text_field( $_POST[ $field ] );
                $wpdb->replace(
                    $this->table_name,
                    [
                        'book_id'    => $post_id,
                        'meta_key'   => $field,
                        'meta_value' => $meta_value,
                    ],
                    [ '%d', '%s', '%s' ]
                );
            }
        }
    }
}