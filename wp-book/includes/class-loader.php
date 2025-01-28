<?php

namespace WPBook\Includes;
use WPBook\Includes\Frontend\BookWidget;

class Loader {
    public function run() {
        
        // Load core functionality
        require_once WP_BOOK_PATH . 'includes/Admin/class-admin-settings.php';
        require_once WP_BOOK_PATH . 'includes/Admin/class-dashboard-widget.php';
        require_once WP_BOOK_PATH . 'includes/Database/class-custom-meta-table.php';
        require_once WP_BOOK_PATH . 'includes/Frontend/class-book-shortcode.php';
        require_once WP_BOOK_PATH . 'includes/Frontend/class-book-widget.php';
        require_once WP_BOOK_PATH . 'includes/Meta/class-book-meta-box.php';
        require_once WP_BOOK_PATH . 'includes/PostType/class-book-post-type.php';
        require_once WP_BOOK_PATH . 'includes/class-activator.php';
        require_once WP_BOOK_PATH . 'includes/class-deactivator.php';
        

        // Initialize components.
        ( new Admin\AdminSettings() )->init();
        ( new Admin\DashboardWidget() )->init();
        ( new Database\CustomMetaTable() )->init();
        ( new Frontend\BookShortcode() )->init();
        ( new Meta\BookMetaBox() )->init();
        ( new PostType\BookPostType() )->init();

        add_action( 'widgets_init', function () {
            register_widget( BookWidget::class );
        } );
        
    }
}
