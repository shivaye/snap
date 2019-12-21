<?php

function tokoo_ocdi_import_files() {
    return apply_filters( 'tokoo_ocdi_files_args', array(
        array(
            'import_file_name'             => 'Tokoo',
            'categories'                   => array( 'Electronics' ),
            'local_import_file'            => trailingslashit( get_template_directory() ) . 'assets/dummy-data/lite/dummy-data.xml',
            'local_import_widget_file'     => trailingslashit( get_template_directory() ) . 'assets/dummy-data/widgets.wie',
            'local_import_redux'           => array(
                array(
                    'file_path'   => trailingslashit( get_template_directory() ) . 'assets/dummy-data/redux-options.json',
                    'option_name' => 'tokoo_options',
                ),
            ),
            'import_preview_image_url'     => trailingslashit( get_template_directory_uri() ) . 'assets/images/tokoo-preview-lite.jpg',
            'import_notice'                => esc_html__( 'Import process may take 3-5 minutes. If you facing any issues please contact our support.', 'tokoo' ),
            'preview_url'                  => 'https://demo.madrasthemes.com/tokoo-lite/',
        )
    ) );
}

function tokoo_ocdi_after_import_setup( $selected_import ) {
    
    // Assign menus to their locations.
    $top_bar_left       = get_term_by( 'name', 'Top Bar Left', 'nav_menu' );
    $top_bar_right      = get_term_by( 'name', 'Top Bar Right', 'nav_menu' );
    $departments_menu   = get_term_by( 'name', 'Vertical Menu', 'nav_menu' );
    $primary_nav        = get_term_by( 'name', 'Primary Menu', 'nav_menu' );
    $secondary_nav      = get_term_by( 'name', 'Top Bar Left', 'nav_menu' );
    $hand_held_nav      = get_term_by( 'name', 'Primary Menu', 'nav_menu' );

    set_theme_mod( 'nav_menu_locations', array(
            'top-bar-left'      => $top_bar_left->term_id,
            'top-bar-right'     => $top_bar_right->term_id,
            'departments-menu'  => $departments_menu->term_id,
            'primary-nav'       => $primary_nav->term_id,
            'secondary-nav'     => $secondary_nav->term_id,
            'hand-held-nav'     => $hand_held_nav->term_id,
        )
    );

    // Assign front page and posts page (blog page) and other WooCommerce pages
    $front_page_id      = get_page_by_title( 'Home v3' );
    $blog_page_id       = get_page_by_title( 'Blog' );
    $shop_page_id       = get_page_by_title( 'Shop' );
    $cart_page_id       = get_page_by_title( 'Cart' );
    $checkout_page_id   = get_page_by_title( 'Checkout' );
    $myaccount_page_id  = get_page_by_title( 'My Account' );
    $terms_page_id      = get_page_by_title( 'Terms and Conditions' );
    $wishlist_page      = get_page_by_title( 'Wishlist' );

    update_option( 'show_on_front', 'page' );
    update_option( 'page_on_front', $front_page_id->ID );
    update_option( 'page_for_posts', $blog_page_id->ID );
    update_option( 'woocommerce_shop_page_id', $shop_page_id->ID );
    update_option( 'woocommerce_cart_page_id', $cart_page_id->ID );
    update_option( 'woocommerce_checkout_page_id', $checkout_page_id->ID );
    update_option( 'woocommerce_myaccount_page_id', $myaccount_page_id->ID );
    update_option( 'woocommerce_terms_page_id', $terms_page_id->ID );
    update_option( 'yith_wcwl_wishlist_page_id', $wishlist_page->ID );

    // Update Wishlist Position
    update_option( 'yith_wcwl_button_position', 'shortcode' );
    
    // Enable Registration on "My Account" page
    update_option( 'woocommerce_enable_myaccount_registration', 'yes' );

    // Assign MAS Brand Attribute
    update_option( 'mas_wc_brands_brand_taxonomy', 'pa_brand' );

    // Set Kingcomposer Builder for Static Blocks
    if ( function_exists( 'vc_set_default_editor_post_types' ) ) {
        vc_set_default_editor_post_types( array( 'page', 'static_block' ) );
    }

    if( class_exists( 'RevSlider' ) ) {
        require_once( ABSPATH . 'wp-load.php' );
        require_once( ABSPATH . 'wp-includes/functions.php' );
        require_once( ABSPATH . 'wp-admin/includes/file.php' );

        if ( 'Tokoo' === $selected_import['import_file_name'] ) {
            $slider_array = array(
                trailingslashit( get_template_directory() ) . 'assets/dummy-data/lite/home-v1-slider.zip',
                trailingslashit( get_template_directory() ) . 'assets/dummy-data/lite/home-v2-slider.zip',
                trailingslashit( get_template_directory() ) . 'assets/dummy-data/lite/home-v3-slider.zip',
                trailingslashit( get_template_directory() ) . 'assets/dummy-data/lite/home-v4-slider.zip',
                trailingslashit( get_template_directory() ) . 'assets/dummy-data/lite/home-v5-slider.zip',
            );
        } else {
            $slider_array = array(
                trailingslashit( get_template_directory() ) . 'assets/dummy-data/demo/home-v1-slider.zip',
                trailingslashit( get_template_directory() ) . 'assets/dummy-data/demo/home-v2-slider.zip',
                trailingslashit( get_template_directory() ) . 'assets/dummy-data/demo/home-v3-slider.zip',
                trailingslashit( get_template_directory() ) . 'assets/dummy-data/demo/home-v4-slider.zip',
                trailingslashit( get_template_directory() ) . 'assets/dummy-data/demo/home-v5-slider.zip',
            );
        }
        $slider = new RevSlider();

        foreach( $slider_array as $filepath ) {
            $slider->importSliderFromPost( true, true, $filepath );
        }
    }

    if ( function_exists( 'wc_delete_product_transients' ) ) {
        wc_delete_product_transients();
    }
    if ( function_exists( 'wc_delete_shop_order_transients' ) ) {
        wc_delete_shop_order_transients();
    }
    if ( function_exists( 'wc_delete_expired_transients' ) ) {
        wc_delete_expired_transients();
    }
}

function tokoo_ocdi_before_widgets_import() {

    $sidebars_widgets = get_option('sidebars_widgets');
    $all_widgets = array();

    array_walk_recursive( $sidebars_widgets, function ($item, $key) use ( &$all_widgets ) {
        if( ! isset( $all_widgets[$key] ) ) {
            $all_widgets[$key] = $item;
        } else {
            $all_widgets[] = $item;
        }
    } );

    if( isset( $all_widgets['array_version'] ) ) {
        $array_version = $all_widgets['array_version'];
        unset( $all_widgets['array_version'] );
    }

    $new_sidebars_widgets = array_fill_keys( array_keys( $sidebars_widgets ), array() );

    $new_sidebars_widgets['wp_inactive_widgets'] = $all_widgets;
    if( isset( $array_version ) ) {
        $new_sidebars_widgets['array_version'] = $array_version;
    }

    update_option( 'sidebars_widgets', $new_sidebars_widgets );
}

function tokoo_kc_force_enable_static_block() {
    if( class_exists( 'KingComposer' ) && apply_filters( 'tokoo_kc_force_enable_static_block', true ) ) {
        global $kc;
        $kc->add_content_type( 'static_block' );
    }
}