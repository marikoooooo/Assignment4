<?php
/**
 * Add upgrade section.
 * 
 * @package WP Diary
 */

add_action( 'customize_register', 'wp_diary_register_upgrade_fields' );

if ( ! function_exists( 'wp_diary_register_upgrade_fields' ) ) :

    /**
     * Register upgrader fields.
     */
    function wp_diary_register_upgrade_fields ( $wp_customize ) {

        /**
         * Upgrade field for color section
         *
         * @since 1.2.2
         */ 
        $wp_customize->add_setting( 'wp_diary_upgrade_color',
            array(
                'sanitize_callback' => 'sanitize_text_field'
            )
        );
        $wp_customize->add_control( new WP_Diary_Control_Upgrade(
            $wp_customize, 'wp_diary_upgrade_color',
                array(
                    'priority'      => 200,
                    'section'       => 'colors',
                    'settings'      => 'wp_diary_upgrade_color',
                    'label'         => __( 'More features with WP Diary Pro', 'wp-diary' ),
                    'choices'       => array( __( 'Custom primary menu color option', 'wp-diary' ) )
                )
            )
        ); 

         /**
         * Upgrade field for preloader section
         *
         * @since 1.2.2
         */ 
        $wp_customize->add_setting( 'wp_diary_upgrade_preloader',
            array(
                'sanitize_callback' => 'sanitize_text_field'
            )
        );
        $wp_customize->add_control( new WP_Diary_Control_Upgrade(
            $wp_customize, 'wp_diary_upgrade_preloader',
                array(
                    'priority'      => 200,
                    'section'       => 'wp_diary_section_site',
                    'settings'      => 'wp_diary_upgrade_preloader',
                    'label'         => __( 'More features with WP Diary Pro', 'wp-diary' ),
                    'choices'       => array( __( 'Preloader Options', 'wp-diary' ), __( 'Typography with 600+ google fonts', 'wp-diary' ), __( '4 More widget styles ', 'wp-diary' ), __( 'Customizable scroll top' , 'wp-diary' ) )
                )
            )
        ); 

        /**
         * Upgrade field for header section
         *
         * @since 1.2.2
         */ 
        $wp_customize->add_setting( 'wp_diary_upgrade_header',
            array(
                'sanitize_callback' => 'sanitize_text_field'
            )
        );
        $wp_customize->add_control( new WP_Diary_Control_Upgrade(
            $wp_customize, 'wp_diary_upgrade_header',
                array(
                    'priority'      => 200,
                    'section'       => 'wp_diary_section_header_extra',
                    'settings'      => 'wp_diary_upgrade_header',
                    'label'         => __( 'More features with WP Diary Pro', 'wp-diary' ),
                    'choices'       => array( __( 'Top header with custom fields', 'wp-diary' ), __( '3 More header layout', 'wp-diary' ), __( 'Sidebar Menu Icons with more customizable option' , 'wp-diary') )
                )
            )
        ); 

        /**
         * Upgrade field for slider section
         *
         * @since 1.2.2
         */ 
        $wp_customize->add_setting( 'wp_diary_upgrade_slider',
            array(
                'sanitize_callback' => 'sanitize_text_field'
            )
        );
        $wp_customize->add_control( new WP_Diary_Control_Upgrade(
            $wp_customize, 'wp_diary_upgrade_slider',
                array(
                    'priority'      => 200,
                    'section'       => 'wp_diary_section_slider',
                    'settings'      => 'wp_diary_upgrade_slider',
                    'label'         => __( 'More features with WP Diary Pro', 'wp-diary' ),
                    'choices'       => array( __( 'Repeater Slider', 'wp-diary' ), __( 'More custom slider option', 'wp-diary' ), __( 'Featured Section', 'wp-diary' ), __( 'Front page Settings' , 'wp-diary'), )
                )
            )
        ); 

         /**
         * Upgrade field for archive section
         *
         * @since 1.2.2
         */ 
        $wp_customize->add_setting( 'wp_diary_upgrade_archive_settings',
            array(
                'sanitize_callback' => 'sanitize_text_field'
            )
        );
        $wp_customize->add_control( new WP_Diary_Control_Upgrade(
            $wp_customize, 'wp_diary_upgrade_archive_settings',
                array(
                    'priority'      => 200,
                    'section'       => 'wp_diary_section_archive_settings',
                    'settings'      => 'wp_diary_upgrade_archive_settings',
                    'label'         => __( 'More features with WP Diary Pro', 'wp-diary' ),
                    'choices'       => array( __( '5 Archive Styles', 'wp-diary' ), __( '2 Page post style', 'wp-diary' ), __( 'Archive posts content order', 'wp-diary' ) )
                )
            )
        ); 

         /**
         * Upgrade field for post section
         *
         * @since 1.2.2
         */ 
        $wp_customize->add_setting( 'wp_diary_upgrade_post_settings',
            array(
                'sanitize_callback' => 'sanitize_text_field'
            )
        );
        $wp_customize->add_control( new WP_Diary_Control_Upgrade(
            $wp_customize, 'wp_diary_upgrade_post_settings',
                array(
                    'priority'      => 200,
                    'section'       => 'wp_diary_section_post_settings',
                    'settings'      => 'wp_diary_upgrade_post_settings',
                    'label'         => __( 'More features with WP Diary Pro', 'wp-diary' ),
                    'choices'       => array( __( '3 Post style', 'wp-diary' ), __( 'Posts content order', 'wp-diary' ), __( '5 More post settings', 'wp-diary' ), )
                )
            )
        ); 

         /**
         * Upgrade field for page section
         *
         * @since 1.2.2
         */ 
        $wp_customize->add_setting( 'wp_diary_upgrade_page_settings',
            array(
                'sanitize_callback' => 'sanitize_text_field'
            )
        );
        $wp_customize->add_control( new WP_Diary_Control_Upgrade(
            $wp_customize, 'wp_diary_upgrade_page_settings',
                array(
                    'priority'      => 200,
                    'section'       => 'wp_diary_section_page_settings',
                    'settings'      => 'wp_diary_upgrade_page_settings',
                    'label'         => __( 'More features with WP Diary Pro', 'wp-diary' ),
                    'choices'       => array( __( 'Custom 404 Page', 'wp-diary' ), )
                )
            )
        ); 

        /**
         * Upgrade field for social icons
         *
         * @since 1.2.2
         */ 
        $wp_customize->add_setting( 'wp_diary_upgrade_social_icons',
            array(
                'sanitize_callback' => 'sanitize_text_field'
            )
        );
        $wp_customize->add_control( new WP_Diary_Control_Upgrade(
            $wp_customize, 'wp_diary_upgrade_social_icons',
                array(
                    'priority'      => 200,
                    'section'       => 'wp_diary_section_social_icons',
                    'settings'      => 'wp_diary_upgrade_social_icons',
                    'label'         => __( 'More features with WP Diary Pro', 'wp-diary' ),
                    'choices'       => array( __( 'Unlimited Social Icons', 'wp-diary' ), __( 'Social icons color option', 'wp-diary' ) )
                )
            )
        ); 

        /**
         * Upgrade field for footer 
         *
         * @since 1.2.2
         */ 
        $wp_customize->add_setting( 'wp_diary_upgrade_footer',
            array(
                'sanitize_callback' => 'sanitize_text_field'
            )
        );
        $wp_customize->add_control( new WP_Diary_Control_Upgrade(
            $wp_customize, 'wp_diary_upgrade_footer',
                array(
                    'priority'      => 200,
                    'section'       => 'wp_diary_section_footer_widget_area',
                    'settings'      => 'wp_diary_upgrade_footer',
                    'label'         => __( 'More features with WP Diary Pro', 'wp-diary' ),
                    'choices'       => array( __( 'Footer background option', 'wp-diary' ) )
                )
            )
        ); 
    }

endif;