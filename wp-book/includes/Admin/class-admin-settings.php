<?php

namespace WPBook\Includes\Admin;

class AdminSettings {
    public function init() {
        add_action( 'admin_menu', [ $this, 'add_settings_page' ] );
        add_action( 'admin_init', [ $this, 'register_settings' ] );
    }

    public function add_settings_page() {
        add_submenu_page(
            'edit.php?post_type=book',
            __( 'Book Settings', 'wp-book' ),
            __( 'Settings', 'wp-book' ),
            'manage_options',
            'book-settings',
            [ $this, 'render_settings_page' ]
        );
    }

    public function register_settings() {
        register_setting( 'book_settings', 'book_currency' );
        register_setting( 'book_settings', 'books_per_page' );

        add_settings_section( 'general_settings', __( 'General Settings', 'wp-book' ), null, 'book-settings' );

        add_settings_field(
            'book_currency',
            __( 'Currency', 'wp-book' ),
            [ $this, 'render_currency_field' ],
            'book-settings',
            'general_settings'
        );

        add_settings_field(
            'books_per_page',
            __( 'Books Per Page', 'wp-book' ),
            [ $this, 'render_books_per_page_field' ],
            'book-settings',
            'general_settings'
        );
    }

    public function render_currency_field() {
        $value = get_option( 'book_currency', 'USD' );
        echo "<input type='text' name='book_currency' value='" . esc_attr( $value ) . "'>";
    }

    public function render_books_per_page_field() {
        $value = get_option( 'books_per_page', 10 );
        echo "<input type='number' name='books_per_page' value='" . esc_attr( $value ) . "'>";
    }

    public function render_settings_page() {
        ?>
        <div class="wrap">
            <h1><?php esc_html_e( 'Book Settings', 'wp-book' ); ?></h1>
            <form method="post" action="options.php">
                <?php
                settings_fields( 'book_settings' );
                do_settings_sections( 'book-settings' );
                submit_button();
                ?>
            </form>
        </div>
        <?php
    }
}
