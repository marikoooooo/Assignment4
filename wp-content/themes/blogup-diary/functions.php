<?php
/**
 * Blogup Diary functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WP Diary
 * @subpackage Blogup Diary
 * @since 1.0.0
 */

/*------------------------- Theme Version -------------------------------------*/

    if ( ! defined( 'BLOGUP_DIARY_VERSION' ) ) {
        // Replace the version number of the theme on each release.
        $blogup_diary_theme_info = wp_get_theme();
        define( 'BLOGUP_DIARY_VERSION', $blogup_diary_theme_info->get( 'Version' ) );
    }

/*------------------------- Customizer ----------------------------------------*/

    add_action( 'customize_register', 'blogup_diary_customize_register', 20 );

    if ( ! function_exists( 'blogup_diary_customize_register' ) ) :

        /**
         * Customizer settings for blogger diary
         */
        function blogup_diary_customize_register( $wp_customize ) {

            $wp_customize->get_setting( 'wp_diary_primary_color' )->default = '#c95656';

        }

    endif;

    add_action( 'after_setup_theme', 'blogup_diary_custom_fields' );

    if ( ! function_exists( 'blogup_diary_custom_fields' ) ) :

        function blogup_diary_custom_fields() {

            // Toggle field for Background Animation
            Kirki::add_field(
                'wp_diary_config', array(
                    'type'          => 'toggle',
                    'settings'      => 'wp_diary_enable_site_mode',
                    'label'         => esc_html__( 'Enable Site Mode', 'blogup-diary' ),
                    'section'       => 'wp_diary_section_site',
                    'default'       => '1',
                    'priority'      => 5,
                )
            );

            // Toggle field for Background Animation
            Kirki::add_field(
                'wp_diary_config', array(
                    'type'          => 'toggle',
                    'settings'      => 'wp_diary_enable_background_animation',
                    'label'         => esc_html__( 'Enable Background Animation', 'blogup-diary' ),
                    'section'       => 'wp_diary_section_site',
                    'default'       => '1',
                    'priority'      => 5,
                )
            );

            /**
             * You may like setting
             */
            Kirki::add_section( 'blogup_diary_you_may_like_section', array(
                'title'    => esc_html__( 'You May Like Section', 'blogup-diary' ),
                'panel'    => 'wp_diary_footer_panel',
                'priority' => 1,
            ) );

            Kirki::add_field(
            'wp_diary_config', array(
                'type'     => 'toggle',
                'settings' => 'blogup_diary_enable_you_may_like_section',
                'label'    => esc_html__( 'Enable You May Like Section', 'blogup-diary' ),
                'section'  => 'blogup_diary_you_may_like_section',
                'default'  => '1',
                'priority' => 5,
            ) );

            Kirki::add_field(
            'wp_diary_config', array(
                'type'     => 'text',
                'settings' => 'blogup_diary_you_may_like_text',
                'label'    => esc_html__( 'Section Title', 'blogup-diary' ),
                'section'  => 'blogup_diary_you_may_like_section',
                'default'  => esc_html__( 'You May Like', 'blogup-diary' ),
                'priority' => 10,
            ) );

        }

    endif;

/*------------------------- Font url ------------------------------------------*/

    if ( ! function_exists( 'blogup_diary_fonts_url' ) ) :

    	/**
    	 * Register Google fonts for Blogup Diary.
    	 *
    	 * @return string Google fonts URL for the theme.
    	 * @since 1.0.0
    	 */
        function blogup_diary_fonts_url() {
            $fonts_url = '';
            $font_families = array();
            /*
             * Translators: If there are characters in your language that are not supported
             * by Great Vibes translate this to 'off'. Do not translate into your own language.
             */
            if ( 'off' !== _x( 'on', 'Great Vibes: on or off', 'blogup-diary' ) ) {
                $font_families[] = 'Great Vibes:400';
            }
            if ( $font_families ) {
                $query_args = array(
                    'family' => urlencode( implode( '|', $font_families ) ),
                    'subset' => urlencode( 'latin,latin-ext' ),
                );
                $fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
            }

            /*
             * Translators: If there are characters in your language that are not supported
             * by Be Vietnam Pro translate this to 'off'. Do not translate into your own language.
             */
            if ( 'off' !== _x( 'on', 'Be Vietnam Pro: on or off', 'blogup-diary' ) ) {
                $font_families[] = 'Be Vietnam Pro:400,700';
            }
            if ( $font_families ) {
                $query_args = array(
                    'family' => urlencode( implode( '|', $font_families ) ),
                    'subset' => urlencode( 'latin,latin-ext' ),
                );
                $fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css' );
            }

            return $fonts_url;
        }

    endif;

/*------------------------- Enqueue scripts and styles ------------------------*/

    function blogup_diary_scripts() {

        wp_enqueue_style( 'blogup-diary-fonts', blogup_diary_fonts_url(), array(), null );

        wp_dequeue_style( 'wp-diary-style' );

        wp_dequeue_style( 'wp-diary-responsive-style' );

        wp_enqueue_style( 'blogup-diary-parent-style', get_template_directory_uri() . '/style.css', array(), BLOGUP_DIARY_VERSION );

        wp_enqueue_style( 'blogup-diary-parent-responsive-style', get_template_directory_uri() . '/assets/css/mt-responsive.css', array(), BLOGUP_DIARY_VERSION );

        wp_enqueue_style( 'blogup-diary-style', get_stylesheet_uri(), array(), BLOGUP_DIARY_VERSION );

        wp_enqueue_style( 'blogup-diary-responsive-style', get_stylesheet_directory_uri() . '/assets/css/bd-responsive.css', array(), BLOGUP_DIARY_VERSION );

        $blogup_diary_enable_site_mode = get_theme_mod( 'wp_diary_enable_site_mode', true );

        if ( $blogup_diary_enable_site_mode == true ) {
             wp_enqueue_style( 'blogup-diary-dark-mode-style', get_stylesheet_directory_uri() . '/assets/css/bd-dark-mode.css', array(), BLOGUP_DIARY_VERSION );
        }

    	$blogup_diary_primary_color    = get_theme_mod( 'wp_diary_primary_color', '#c95656' );

    	$output_css = '';

        $output_css .= ".edit-link .post-edit-link,.reply .comment-reply-link,.widget_search .search-submit,.widget_search .search-submit,.widget_search .search-submit:hover,.mt-menu-search .mt-form-wrap .search-form .search-submit:hover,.menu-toggle:hover,.slider-btn,.entry-footer .mt-readmore-btn,article.sticky::before,.post-format-media--quote,.mt-gallery-slider .slick-prev.slick-arrow:hover,.mt-gallery-slider .slick-arrow.slick-next:hover,.wp_diary_social_media a:hover,.mt-header-extra-icons .sidebar-header.mt-form-close:hover,#site-navigation .mt-form-close, #site-navigation ul li:hover>a,#site-navigation ul li.focus > a, #site-navigation ul li:hover>a, #site-navigation ul li.current-menu-item>a, #site-navigation ul li.current_page_ancestor>a, #site-navigation ul li.current_page_item>a, #site-navigation ul li.current-menu-ancestor>a,.cv-read-more a,.mt-yml-wrapper .post-category a,.blogup-diary-circles li{ background: ". esc_attr( $blogup_diary_primary_color ) ."}\n";


        $output_css .= "a,a:hover,a:focus,a:active,.entry-footer a:hover ,.comment-author .fn .url:hover,.commentmetadata .comment-edit-link,#cancel-comment-reply-link,#cancel-comment-reply-link:before,.logged-in-as a,.widget a:hover,.widget a:hover::before,.widget li:hover::before,.mt-social-icon-wrap li a:hover,.site-title a:hover,.mt-sidebar-menu-toggle:hover,.mt-menu-search:hover,.sticky-header-sidebar-menu li a:hover,.slide-title a:hover,.entry-title a:hover,.cat-links a,.entry-title a:hover,.cat-links a:hover,.navigation.pagination .nav-links .page-numbers.current,.navigation.pagination .nav-links a.page-numbers:hover,#top-footer .widget-title ,#footer-menu li a:hover,.wp_diary_latest_posts .mt-post-title a:hover,#mt-scrollup:hover, #secondary .widget .widget-title, .mt-related-post-title, #mt-masonry article .entry-footer .mt-readmore-btn:hover,.cv-read-more a:hover,.archive-classic-post-wrapper article .entry-footer .mt-readmore-btn:hover, .archive-grid-post-wrapper article .entry-footer .mt-readmore-btn:hover,.site-mode--dark .entry-title a:hover,article.hentry .entry-footer .mt-readmore-btn:hover,.site-mode--dark .widget_archive a:hover,.site-mode--dark .widget_categories a:hover,.site-mode--dark .widget_recent_entries a:hover,.site-mode--dark .widget_meta a:hover,.site-mode--dark .widget_recent_comments li:hover,.site-mode--dark .widget_rss li:hover,.site-mode--dark .widget_pages li a:hover,.site-mode--dark .widget_nav_menu li a:hover,.site-mode--dark .wp-block-latest-posts li a:hover,.site-mode--dark .wp-block-archives li a:hover,.site-mode--dark .wp-block-categories li a:hover,.site-mode--dark .wp-block-page-list li a:hover,.site-mode--dark .wp-block-latest-comments l:hover, .entry-meta a:hover, .mt-yml-section-title{ color: ". esc_attr( $blogup_diary_primary_color ) ."}\n";

        $output_css .= ".widget_search .search-submit,.widget_search .search-submit:hover,.no-thumbnail,.navigation.pagination .nav-links .page-numbers.current,.navigation.pagination .nav-links a.page-numbers:hover ,#secondary .widget .widget-title,.mt-related-post-title,.error-404.not-found,.wp_diary_social_media a:hover, #mt-masonry article .entry-footer .mt-readmore-btn, .cv-read-more a,.archive-classic-post-wrapper article .entry-footer .mt-readmore-btn:hover,.archive-grid-post-wrapper article .entry-footer .mt-readmore-btn:,article.hentry .entry-footer .mt-readmore-btn{ border-color: ". esc_attr( $blogup_diary_primary_color ) ."}\n";

        $refine_output_css = wp_diary_css_strip_whitespace( $output_css );

        wp_add_inline_style( 'blogup-diary-style', $refine_output_css );

        wp_enqueue_script( 'blogup-diary-sticky-sidebar', get_stylesheet_directory_uri() . '/assets/library/sticky-sidebar/theia-sticky-sidebar.min.js', array(), BLOGUP_DIARY_VERSION, true );

        wp_enqueue_script( 'blogup-diary-custom-scripts', get_stylesheet_directory_uri() . '/assets/js/bd-custom-scripts.js', array( 'jquery'), BLOGUP_DIARY_VERSION, true );

    }

    add_action( 'wp_enqueue_scripts', 'blogup_diary_scripts', 99 );

/*------------------------- You MAy Like Section --------------------------------------------*/

    if ( ! function_exists( 'blogup_diary_may_like_section' ) ) :

        /**
         * function to manage the you may like section
         */
        function blogup_diary_may_like_section() {
            
            if ( ! is_front_page() ) {
                return;
            }

            $blogup_diary_yml_enable = get_theme_mod( 'blogup_diary_enable_you_may_like_section' , true );

            if ( $blogup_diary_yml_enable == false ) {
                return;
            } 

            $blogup_diary_yml_title = get_theme_mod( 'blogup_diary_you_may_like_text' , 'You May Like' );
        ?>

            <div class="mt-yml-section-wrapper">
                <div class="mt-container">
                <h2 class="mt-yml-section-title"><?php echo esc_html( $blogup_diary_yml_title ); ?></h2>
                <div class="mt-yml-wrapper">
                <?php
                $yml_args = array(
                    'orderby' => 'comment_count',
                    'posts_per_page' => 4, 
                    'ignore_sticky_posts' => 1,
                    'post__not_in' => get_option('sticky_posts')
                );
                $yml_query = new WP_Query($yml_args);
                if ($yml_query->have_posts()) : ?>
                    <ul class="mt-yml-posts">
                        <?php while ($yml_query->have_posts()) : $yml_query->the_post(); ?>
                            <li class="yml-post">
                                <a href="<?php the_permalink(); ?>">
                                <?php if (has_post_thumbnail()) : ?>
                                    <div class="post-thumbnail">
                                        <?php the_post_thumbnail('full'); ?>
                                    </div>
                                    <?php else : ?>
                                    <div class="post-thumbnail no-thumbnail">
                                    </div>
                                    <?php endif; ?>
                                    </a>
                                    <div class ="post-content">
                                    <span class="post-category"> <?php $categories = get_the_category(); if (!empty($categories)) { echo '<a href="' . esc_url(get_category_link($categories[0]->term_id)) . '">' . esc_html($categories[0]->name) . '</a>'; } ?> </span>
                                    <h3 class="post-title"><?php the_title(); ?></h3>
                                    </div> <!-- post-content -->
                            </li>
                        <?php endwhile; ?>
                    </ul>
                    <?php wp_reset_postdata(); ?>
                <?php endif; ?>
                </div><!-- mt-yml-wrapper -->
                </div><!-- mt-container -->
            </div><!-- mt-content-wrapper -->
    <?php
        }

    endif;

    add_action( 'wp_diary_before_colophon', 'blogup_diary_may_like_section', 10 );

/*------------------------- Footer --------------------------------------------*/

    if ( !function_exists ( 'wp_diary_footer_background_animation' ) ):

        /**
         * Footer Hook Handling
         *
         */
        function wp_diary_footer_background_animation() {

            $background_animation = get_theme_mod( 'wp_diary_enable_background_animation' , true );

            if ( $background_animation == false ) {
                return;
            }

            echo '<div class="blogup-diary-background-animation" ><ul class="blogup-diary-circles"> <li></li> <li></li> <li></li> <li></li> <li></li> <li></li> <li></li> <li></li> </ul> </div > <!-- area -->';
        }

    endif;

    add_action ( 'wp_diary_scroll_top', 'wp_diary_footer_background_animation', 5 );

