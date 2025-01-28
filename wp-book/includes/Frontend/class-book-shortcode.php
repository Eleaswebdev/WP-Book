<?php

namespace WPBook\Includes\Frontend;

use WP_Query;

class BookShortcode {
    public function init() {
        add_shortcode( 'book', [ $this, 'render_books' ] );
    }

    public function render_books( $atts ) {
         // Retrieve settings from the options table
         $books_per_page = (int) get_option( 'books_per_page', 10 ); // Default to 10 books per page
         $currency = get_option( 'book_currency', 'USD' ); // Default to USD
        // Fallback to 'USD' if the currency is empty
        if ( empty( $currency ) ) {
            $currency = 'USD';
        }

        // Get the current page from the query string
        $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;

        // Set default shortcode attributes
        $atts = shortcode_atts( [
            'id'          => '',
            'author_name' => '',
            'year'        => '',
            'category'    => '',
            'tag'         => '',
            'publisher'   => '',
        ], $atts, 'book' );

        // WP_Query arguments
        $args = [
            'post_type'      => 'book',
            'posts_per_page' => $books_per_page,
            'paged'          => $paged, 
            'meta_query'     => [],
            'tax_query'      => [],
        ];

        // Filter by ID if provided
        if ( $atts['id'] ) {
            $args['p'] = $atts['id'];
        }

        // Add meta queries for specific fields
        foreach ( [ 'author_name', 'year', 'publisher' ] as $key ) {
            if ( ! empty( $atts[ $key ] ) ) {
                $args['meta_query'][] = [
                    'key'   => $key,
                    'value' => $atts[ $key ],
                    'compare' => 'LIKE',
                ];
            }
        }

        // Filter by taxonomy: Book Category
        if ( ! empty( $atts['category'] ) ) {
            $args['tax_query'][] = [
                'taxonomy' => 'book_category',
                'field'    => 'slug',
                'terms'    => $atts['category'],
            ];
        }

        // Filter by taxonomy: Book Tag
        if ( ! empty( $atts['tag'] ) ) {
            $args['tax_query'][] = [
                'taxonomy' => 'book_tag',
                'field'    => 'slug',
                'terms'    => $atts['tag'],
            ];
        }

        // Query the books
        $query = new WP_Query( $args );

        // Start output buffering
        ob_start();

        if ( $query->have_posts() ) {
            echo '<div class="book-list">';

            while ( $query->have_posts() ) {
                $query->the_post();

                // Get book meta information
                $meta = [
                    'author_name' => get_post_meta( get_the_ID(), 'author_name', true ),
                    'price'       => get_post_meta( get_the_ID(), 'price', true ),
                    'publisher'   => get_post_meta( get_the_ID(), 'publisher', true ),
                    'year'        => get_post_meta( get_the_ID(), 'year', true ),
                    'edition'     => get_post_meta( get_the_ID(), 'edition', true ),
                    'url'         => get_post_meta( get_the_ID(), 'url', true ),
                ];

                // Render book information
                echo '<div class="book-item">';
                echo '<h2>' . esc_html( get_the_title() ) . '</h2>';

                echo '<ul>';
                foreach ( $meta as $label => $value ) {
                    if ( ! empty( $value ) ) {
                        // Display price with currency
                        if ( $label === 'price' ) {
                            echo '<li><strong>' . __( 'Price', 'wp-book' ) . ':</strong> ' . esc_html( $currency . ' ' . $value ) . '</li>';
                        } else {
                            echo '<li><strong>' . ucfirst( str_replace( '_', ' ', $label ) ) . ':</strong> ' . esc_html( $value ) . '</li>';
                        }
                    }
                }
                echo '</ul>';

                echo '<div class="book-content">';
                echo wp_kses_post( wpautop( get_the_content() ) );
                echo '</div>';

                echo '</div>';

                // Pagination links
                $big = 999999999; // Need an unlikely integer
                echo '<div class="pagination">';
                echo paginate_links( [
                    'base'      => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                    'format'    => '?paged=%#%',
                    'current'   => max( 1, $paged ),
                    'total'     => $query->max_num_pages,
                    'prev_text' => __( '&laquo; Previous', 'wp-book' ),
                    'next_text' => __( 'Next &raquo;', 'wp-book' ),
                ] );
                echo '</div>';
            }

            echo '</div>';
        } else {
            echo '<p>' . __( 'No books found.', 'wp-book' ) . '</p>';
        }

        // Reset post data
        wp_reset_postdata();

        // Return the output
        return ob_get_clean();
    }
}
