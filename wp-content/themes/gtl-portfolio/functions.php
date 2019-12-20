<?php
/**
 * gtl-portfolio functions and definitions.
 *
 * @package gtl-portfolio
 * @since 1.0.0
 */

define( 'gtl_portfolio_VERSION', '1.0.0' );

/**
 * Load assets.
 *
 * @since 1.0.0
 */
function gtl_portfolio_enqueue() {
    $parent = 'gtl-portfolio-style';
    $style  = '/style.css';

    // Parent style
    wp_enqueue_style( 
        $parent, 
        get_template_directory_uri() . $style,
        array(),
        gtl_portfolio_VERSION
    );

    // Child style
    wp_enqueue_style( 
        'gtl-portfolio-style', 
        get_stylesheet_directory_uri() . $style, 
        array( $parent ), 
        gtl_portfolio_VERSION 
    );
}
add_action( 'wp_enqueue_scripts', 'gtl_portfolio_enqueue' );

/**
 * Dequeue default Google Fonts
 *
 * @since  1.0.0
 * @return void
 */
function gtl_portfolio_dequeue_fonts() {
    wp_dequeue_style( 'gtl-portfolio-font' );
}
add_action( 'wp_enqueue_scripts', 'gtl_portfolio_dequeue_fonts', 15 );

/**
 * Enqueue Google Fonts
 *
 * @since  1.0.0
 * @return void
 */
function gtl_portfolio_enqueue_fonts() {
    wp_enqueue_style( 
        'gtl-portfolio-fonts', 
        gtl_portfolio_fonts_setup(), 
        array(), 
        gtl_portfolio_VERSION 
    );
}
add_action( 'wp_enqueue_scripts', 'gtl_portfolio_enqueue_fonts', 5 );




/**
 * Google Fonts setup
 *
 * @since  1.0.0
 * @return string Google Fonts URL
 */
function gtl_portfolio_fonts_setup() {
    $fonts_url = '';
    $fonts     = array();
    $subsets   = 'latin,latin-ext';

    $fonts[] = 'Muli:400,700,300';
    $fonts[] = 'Lato:400,300,700,900,300italic,400italic,700italic';

    $fonts_args = apply_filters( 'gtl_portfolio_fonts_setup', array(
        'family' => urlencode( implode( '|', $fonts ) ),
        'subset' => urlencode( $subsets ),
    ), compact( 'fonts', 'subsets' ) );

    return add_query_arg( $fonts_args, 'https://fonts.googleapis.com/css' );
}








        function gtl_portfolio_customizer_options( $wp_customize ) {

            /**
             * Panel
             */
            $panel = 'general_panel-section';
            $wp_customize->add_panel( $panel , array(
                'title'             => __( 'General Options', 'gtl-portfolio' ),
                'priority'          => 18
            ) );


    
    
    /**
             * Section
             */
            $wp_customize->add_section( 'gtl_general_scroll_top' , array(
                'title'             => __( 'Scroll To Top', 'gtl-portfolio' ),
                'priority'          => 10,
                'panel'             => 'general_panel-section',
            ) );

            /**
             * 
             * 
             * Scroll To Top
             */
             
             
            
            /**
             * Scroll Top Position
             */
             
             
             $wp_customize->add_setting('gtl_scroll_top_position', array(
            'default' => 'right',
            'sanitize_callback' => 'gtl_sanitize_error_page_blank',
            ));

            $wp_customize->add_control( new WP_Customize_Control($wp_customize, 'gtl_scroll_top_position-radio-control', array(
            'description' => __('Additional features in GTL Multipurpose PRO theme','gtl-portfolio' ),
            'label' => __('Position','gtl-portfolio' ),
            'section' => 'gtl_general_scroll_top',
            'settings' => 'gtl_scroll_top_position',
             'type'        => 'radio',
             'choices' => array(

                    'left'              => __( 'Left', 'gtl-portfolio' ),
                    'right'             => __( 'Right', 'gtl-portfolio' ),
             )
            )));
         
            $wp_customize->add_setting('gtl_scroll_top_display', array(
            'default' => 'block',
            'sanitize_callback' => 'gtl_sanitize_error_page_blank',
            ));

            $wp_customize->add_control( new WP_Customize_Control($wp_customize, 'gtl_scroll_top_display-radio-control', array(
            'label' => __( 'Display or Hide ', 'gtl-portfolio' ),
            'section' => 'gtl_general_scroll_top',
            'settings' => 'gtl_scroll_top_display',
             'type'        => 'radio',
             'choices' => array(

                    'block'             => __( 'Display', 'gtl-portfolio' ),
                    'none'          => __( 'Hide', 'gtl-portfolio' ),
             )
            )));
           
            
           
        
            
            /**
             * 404 Section
             */
            
            $wp_customize->add_section('gtl_general_error_page' , array(
                'title'             => __('404 Error Page', 'gtl-portfolio'),
                
                'panel'             => 'general_panel-section'
                
            ) );
            
             
             $wp_customize->add_setting('gtl_error_page_blank', array(
            'default' => 'off',
            'sanitize_callback' => 'gtl_sanitize_error_page_blank',
            ));

            $wp_customize->add_control( new WP_Customize_Control($wp_customize, 'gtl_error_page_blank-radio-control', array(
            'label' => __('Blank Page','gtl-portfolio' ),
            'description' => __('Enable this option to remove all the elements and have full control of the 404 error page.','gtl-portfolio' ),
            'section' => 'gtl_general_error_page',
            'settings' => 'gtl_error_page_blank',
             'type'        => 'radio',
             'choices' => array(

                               'on'             => __( 'On', 'gtl-portfolio' ),
                               'off'            => __( 'Off', 'gtl-portfolio' ),

            ),
            )));
            
           
           
            
            
            

}




add_action('customize_register', 'gtl_portfolio_customizer_options');




     function gtl_sanitize_error_page_blank( $input ) {

    $valid = array(

        'on'    => __('On', 'gtl-portfolio'),

        'off'     => __('Off', 'gtl-portfolio'),

        'block'   => __( 'Display', 'gtl-portfolio' ),

        'none'    => __( 'Hide', 'gtl-portfolio' ),

        'left'              => __( 'Left', 'gtl-portfolio' ),
        
        'right'             => __( 'Right', 'gtl-portfolio' ),
               

    );

    if ( array_key_exists( $input, $valid ) ) {

        return $input;

    } else {

        return '';

    }

}



// Add portfolio callout section to admin appearance customize screen
if( ! function_exists('gtl_portfolio_portfolio_callout') ):

function gtl_portfolio_portfolio_callout($wp_customize) {
    
    
   
            /**
             * Panel
             */
            $panel = 'general_panel-section1';
            $wp_customize->add_panel( $panel , array(
                'title'             => __( 'Portfolio Template Options', 'gtl-portfolio' ),
                'priority'          => 15
            ) );


    
    
    /**
             * Section
             */
            $wp_customize->add_section( 'lwp-portfolio-callout-section' , array(
                'title'             => __( 'Skills', 'gtl-portfolio' ),
                'priority'          => 10,
                'panel'             => 'general_panel-section1',
            ) );

            /**
             * 
             * 
             * Scroll To Top
             */

    

    

    $wp_customize->add_setting('lwp-portfolio-callout-headline', array(
        'default' => __('Your Heading','gtl-portfolio'),
        'sanitize_callback' => 'sanitize_text_field'
    ));

    $wp_customize->add_control( new WP_Customize_Control($wp_customize, 'lwp-portfolio-callout-headline-control', array(
            'label' => __('About Us Section Heading','gtl-portfolio'),
            'section' => 'lwp-portfolio-callout-section',
            'settings' => 'lwp-portfolio-callout-headline',
            'priority'       => 1,
        )));
        
    $wp_customize->add_setting('lwp-portfolio-callout-desc', array(
        'default' => __('Your Descrition','gtl-portfolio'),
        'sanitize_callback' => 'sanitize_text_field'
    ));

    $wp_customize->add_control( new WP_Customize_Control($wp_customize, 'lwp-portfolio-callout-desc-control', array(
            'label' => __('About Us Section Description','gtl-portfolio'),
            'section' => 'lwp-portfolio-callout-section',
            'settings' => 'lwp-portfolio-callout-desc',
            'priority'       => 2,
        )));
    
    $wp_customize->add_setting('lwp-portfolio-callout-text', array(
        'default' => __('Enter your own text here.','gtl-portfolio'),
        'sanitize_callback' => 'sanitize_textarea_field'
    ));
    

    $wp_customize->add_control( new WP_Customize_Control($wp_customize, 'lwp-portfolio-callout-text-control', array(
            'label' => __('About us Paragraph Text','gtl-portfolio'),
            'section' => 'lwp-portfolio-callout-section',
            'settings' => 'lwp-portfolio-callout-text',
            'type' => 'textarea',
            'priority'       => 3,
        )));
        
    
    $wp_customize->add_setting(
        'sec_image_1',
        array(
            'default' => esc_url(get_stylesheet_directory_uri().'/assets/images/sfd-promo.png'),
            'sanitize_callback' => 'esc_url_raw',
            'transport' => 'postMessage'
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'sec_image_1',
            array(
               'label'          => __( 'About Us Section Image', 'gtl-portfolio' ),
               'description'   => __('For best results please use an image with resolution  380px x 450px or more', 'gtl-portfolio'),
               'type'           => 'image',
               'section'        => 'lwp-portfolio-callout-section',
               'settings'       => 'sec_image_1',
               'priority'       => 4,
            )
        )
    );
    
        
    // skill percentage 1
    
    $wp_customize->add_setting('lwp-portfolio-callout-skill1', array(
        'default' => __('Your Title','gtl-portfolio'),
        'sanitize_callback' => 'sanitize_text_field'
    ));

    $wp_customize->add_control( new WP_Customize_Control($wp_customize, 'lwp-portfolio-callout-skill1-control', array(
            'label' => __('Skill 1 Title','gtl-portfolio'),
            'section' => 'lwp-portfolio-callout-section',
            'settings' => 'lwp-portfolio-callout-skill1',
            'priority'       => 5,
        )));
        
    
    
    $wp_customize->add_setting(
        'lwp-portfolio-callout-skill-p1',
        array(
            'sanitize_callback' => 'absint',
            'default'           => '75',
        )       
    );

    $wp_customize->add_control( 'lwp-portfolio-callout-skill-p1', array(
        'type'        => 'number',
        'priority'    => 6,
        'section'     => 'lwp-portfolio-callout-section',
        'label'       => __('Skill 1 value', 'gtl-portfolio'),
        'input_attrs' => array(
            'min'   => 0,
            'max'   => 100,
            'step'  => 1,
        ),
    ) ); 
    
    // skill percentage 2
    
    $wp_customize->add_setting('lwp-portfolio-callout-skill2', array(
        'default' => __('Your Title','gtl-portfolio'),
        'sanitize_callback' => 'sanitize_text_field'
    ));

    $wp_customize->add_control( new WP_Customize_Control($wp_customize, 'lwp-portfolio-callout-skill1-contro2', array(
            'label' => __('Skill 2 Title','gtl-portfolio'),
            'section' => 'lwp-portfolio-callout-section',
            'settings' => 'lwp-portfolio-callout-skill2',
            'priority'       => 7,
        )));
        
    
        
    $wp_customize->add_setting(
        'lwp-portfolio-callout-skill-p2',
        array(
            'sanitize_callback' => 'absint',
            'default'           => '75',
        )       
    );

    $wp_customize->add_control( 'lwp-portfolio-callout-skill-p2', array(
        'type'        => 'number',
        'priority'    => 8,
        'section'     => 'lwp-portfolio-callout-section',
        'label'       => __('Skill 2 value', 'gtl-portfolio'),
        'input_attrs' => array(
            'min'   => 0,
            'max'   => 100,
            'step'  => 1,
        ),
    ) ); 
    
    // skill percentage 3
    
    $wp_customize->add_setting('lwp-portfolio-callout-skill3', array(
        'default' => __('Your Title','gtl-portfolio'),
        'sanitize_callback' => 'sanitize_text_field'
    ));

    $wp_customize->add_control( new WP_Customize_Control($wp_customize, 'lwp-portfolio-callout-skill3-control', array(
            'label' => __('Skill 3 Title','gtl-portfolio'),
            'section' => 'lwp-portfolio-callout-section',
            'settings' => 'lwp-portfolio-callout-skill3',
            'priority'       => 9,
        )));
        
    
        
    $wp_customize->add_setting(
        'lwp-portfolio-callout-skill-p3',
        array(
            'sanitize_callback' => 'absint',
            'default'           => '75',
        )       
    );

    $wp_customize->add_control( 'lwp-portfolio-callout-skill-p3', array(
        'type'        => 'number',
        'priority'    => 10,
        'section'     => 'lwp-portfolio-callout-section',
        'label'       => __('Skill 3 value', 'gtl-portfolio'),
        'input_attrs' => array(
            'min'   => 0,
            'max'   => 100,
            'step'  => 1,
        ),
    ) ); 
    
    
    // skill percentage 4
    
    $wp_customize->add_setting('lwp-portfolio-callout-skill4', array(
        'default' => __('Your Title','gtl-portfolio'),
        'sanitize_callback' => 'sanitize_text_field'
    ));

    $wp_customize->add_control( new WP_Customize_Control($wp_customize, 'lwp-portfolio-callout-skill4-control', array(
            'label' => __('Skill 4 Title','gtl-portfolio'),
            'section' => 'lwp-portfolio-callout-section',
            'settings' => 'lwp-portfolio-callout-skill4',
            'priority'       => 11,
        )));
        
    
        
    $wp_customize->add_setting(
        'lwp-portfolio-callout-skill-p4',
        array(
            'sanitize_callback' => 'absint',
            'default'           => '75',
        )       
    );

    $wp_customize->add_control( 'lwp-portfolio-callout-skill-p4', array(
        'type'        => 'number',
        'priority'    => 12,
        'section'     => 'lwp-portfolio-callout-section',
        'label'       => __('Skill 4 value', 'gtl-portfolio'),
        'input_attrs' => array(
            'min'   => 0,
            'max'   => 100,
            'step'  => 1,
        ),
    ) ); 
    
    // skill percentage 5
    
    $wp_customize->add_setting('lwp-portfolio-callout-skill5', array(
        'default' => __('Your Title','gtl-portfolio'),
        'sanitize_callback' => 'sanitize_text_field'
    ));

    $wp_customize->add_control( new WP_Customize_Control($wp_customize, 'lwp-portfolio-callout-skill5-control', array(
            'label' => __('Skill 5 Title','gtl-portfolio'),
            'section' => 'lwp-portfolio-callout-section',
            'settings' => 'lwp-portfolio-callout-skill5',
            'priority'       => 13,
        )));
        
    
        
    $wp_customize->add_setting(
        'lwp-portfolio-callout-skill-p5',
        array(
            'sanitize_callback' => 'absint',
            'default'           => '75',
        )       
    );

    $wp_customize->add_control( 'lwp-portfolio-callout-skill-p5', array(
        'type'        => 'number',
        'priority'    => 14,
        'section'     => 'lwp-portfolio-callout-section',
        'label'       => __('Skill 5 value', 'gtl-portfolio'),
        'input_attrs' => array(
            'min'   => 0,
            'max'   => 100,
            'step'  => 1,
        ),
    ) ); 
    
    // skill percentage 6
    
    $wp_customize->add_setting('lwp-portfolio-callout-skill6', array(
        'default' => __('Your Title','gtl-portfolio'),
        'sanitize_callback' => 'sanitize_text_field'
    ));

    $wp_customize->add_control( new WP_Customize_Control($wp_customize, 'lwp-portfolio-callout-skill6-control', array(
            'label' => __('Skill 6 Title','gtl-portfolio'),
            'section' => 'lwp-portfolio-callout-section',
            'settings' => 'lwp-portfolio-callout-skill6',
            'priority'       => 15,
        )));
        
    
        
    $wp_customize->add_setting(
        'lwp-portfolio-callout-skill-p6',
        array(
            'sanitize_callback' => 'absint',
            'default'           => '75',
        )       
    );

    $wp_customize->add_control( 'lwp-portfolio-callout-skill-p6', array(
        'type'        => 'number',
        'priority'    => 16,
        'section'     => 'lwp-portfolio-callout-section',
        'label'       => __('Skill 6 value', 'gtl-portfolio'),
        'input_attrs' => array(
            'min'   => 0,
            'max'   => 100,
            'step'  => 1,
        ),
    ) );
    
    
    /**
             * Tiles & Cards
             */
            
            $wp_customize->add_section('lwp-portfolio-callout-section1' , array(
                'title'             => __('Tiles & Cards', 'gtl-portfolio'),
                
                'panel'             => 'general_panel-section1'
                
            ) );
    
    $wp_customize->add_setting('lwp-portfolio-callout-ser-head', array(
        'default' => __('Your Title','gtl-portfolio'),
        'sanitize_callback' => 'sanitize_text_field'
    ));

    $wp_customize->add_control( new WP_Customize_Control($wp_customize, 'lwp-portfolio-callout-ser-head-control', array(
            'label' => __('Service Heading','gtl-portfolio'),
            'section' => 'lwp-portfolio-callout-section1',
            'settings' => 'lwp-portfolio-callout-ser-head',
            'priority'       => 17,
        )));
        
    $wp_customize->add_setting('lwp-portfolio-callout-ser-desc', array(
        'default' => __('Your Title','gtl-portfolio'),
        'sanitize_callback' => 'sanitize_text_field'
    ));

    $wp_customize->add_control( new WP_Customize_Control($wp_customize, 'lwp-portfolio-callout-ser-desc-control', array(
            'label' => __('Service Description','gtl-portfolio'),
            'section' => 'lwp-portfolio-callout-section1',
            'settings' => 'lwp-portfolio-callout-ser-desc',
            'priority'       => 18,
        )));
    
    
    $wp_customize->add_setting('lwp-portfolio-callout-ser-icon1', array(
        'default' => __('fa fa-cogs','gtl-portfolio'),
        'sanitize_callback' => 'sanitize_text_field'
    ));

    $wp_customize->add_control( new WP_Customize_Control($wp_customize, 'lwp-portfolio-callout-ser-icon1-control', array(
            'label' => __('Service Icon 1','gtl-portfolio'),
            'section' => 'lwp-portfolio-callout-section1',
            'settings' => 'lwp-portfolio-callout-ser-icon1',
            'priority'       => 19,
        )));
        
    $wp_customize->add_setting('lwp-portfolio-callout-ser-text1', array(
        'default' => __('Your Title','gtl-portfolio'),
        'sanitize_callback' => 'sanitize_text_field'
    ));

    $wp_customize->add_control( new WP_Customize_Control($wp_customize, 'lwp-portfolio-callout-ser-text1-control', array(
            'label' => __('Service Title 1','gtl-portfolio'),
            'section' => 'lwp-portfolio-callout-section1',
            'settings' => 'lwp-portfolio-callout-ser-text1',
            'priority'       => 19,
        )));
        
    $wp_customize->add_setting('lwp-portfolio-callout-ser-des1', array(
        'default' => __('Enter your own text here.','gtl-portfolio'),
        'sanitize_callback' => 'sanitize_textarea_field'
    ));
    

    $wp_customize->add_control( new WP_Customize_Control($wp_customize, 'lwp-portfolio-callout-ser-des1-control', array(
            'label' => __('Service Paragraph Text','gtl-portfolio'),
            'section' => 'lwp-portfolio-callout-section1',
            'settings' => 'lwp-portfolio-callout-ser-des1',
            'type' => 'textarea',
            'priority'       => 19,
        )));
       
    
    $wp_customize->add_setting('lwp-portfolio-callout-ser-icon2', array(
        'default' => __('fa fa-cogs','gtl-portfolio'),
        'sanitize_callback' => 'sanitize_text_field'
    ));

    $wp_customize->add_control( new WP_Customize_Control($wp_customize, 'lwp-portfolio-callout-ser-icon2-control', array(
            'label' => __('Service Icon 2','gtl-portfolio'),
            'section' => 'lwp-portfolio-callout-section1',
            'settings' => 'lwp-portfolio-callout-ser-icon2',
            'priority'       => 19,
        )));
        
    $wp_customize->add_setting('lwp-portfolio-callout-ser-text2', array(
        'default' => __('Your Title','gtl-portfolio'),
        'sanitize_callback' => 'sanitize_text_field'
    ));

    $wp_customize->add_control( new WP_Customize_Control($wp_customize, 'lwp-portfolio-callout-ser-text2-control', array(
            'label' => __('Service Title 2','gtl-portfolio'),
            'section' => 'lwp-portfolio-callout-section1',
            'settings' => 'lwp-portfolio-callout-ser-text2',
            'priority'       => 19,
        )));
    
    $wp_customize->add_setting('lwp-portfolio-callout-ser-des2', array(
        'default' => __('Enter your own text here.','gtl-portfolio'),
        'sanitize_callback' => 'sanitize_textarea_field'
    ));
    

    $wp_customize->add_control( new WP_Customize_Control($wp_customize, 'lwp-portfolio-callout-ser-des2-control', array(
            'label' => __('Service Paragraph Text','gtl-portfolio'),
            'section' => 'lwp-portfolio-callout-section1',
            'settings' => 'lwp-portfolio-callout-ser-des2',
            'type' => 'textarea',
            'priority'       => 19,
        )));
       
    
    $wp_customize->add_setting('lwp-portfolio-callout-ser-icon3', array(
        'default' => __('fa fa-cogs','gtl-portfolio'),
        'sanitize_callback' => 'sanitize_text_field'
    ));

    $wp_customize->add_control( new WP_Customize_Control($wp_customize, 'lwp-portfolio-callout-ser-icon3-control', array(
            'label' => __('Service Icon 3','gtl-portfolio'),
            'section' => 'lwp-portfolio-callout-section1',
            'settings' => 'lwp-portfolio-callout-ser-icon3',
            'priority'       => 19,
        )));
        
    $wp_customize->add_setting('lwp-portfolio-callout-ser-text3', array(
        'default' => __('Your Title','gtl-portfolio'),
        'sanitize_callback' => 'sanitize_text_field'
    ));

    $wp_customize->add_control( new WP_Customize_Control($wp_customize, 'lwp-portfolio-callout-ser-text3-control', array(
            'label' => __('Service Title 3','gtl-portfolio'),
            'section' => 'lwp-portfolio-callout-section1',
            'settings' => 'lwp-portfolio-callout-ser-text3',
            'priority'       => 19,
        )));
        
    $wp_customize->add_setting('lwp-portfolio-callout-ser-des3', array(
        'default' => __('Enter your own text here.','gtl-portfolio'),
        'sanitize_callback' => 'sanitize_textarea_field'
    ));
    

    $wp_customize->add_control( new WP_Customize_Control($wp_customize, 'lwp-portfolio-callout-ser-des3-control', array(
            'label' => __('Service Paragraph Text 3','gtl-portfolio'),
            'section' => 'lwp-portfolio-callout-section1',
            'settings' => 'lwp-portfolio-callout-ser-des3',
            'type' => 'textarea',
            'priority'       => 19,
        )));
    
        
    $wp_customize->add_setting('lwp-portfolio-callout-ser-icon4', array(
        'default' => __('fa fa-cogs','gtl-portfolio'),
        'sanitize_callback' => 'sanitize_text_field'
    ));

    $wp_customize->add_control( new WP_Customize_Control($wp_customize, 'lwp-portfolio-callout-ser-icon4-control', array(
            'label' => __('Service Icon 4','gtl-portfolio'),
            'section' => 'lwp-portfolio-callout-section1',
            'settings' => 'lwp-portfolio-callout-ser-icon4',
            'priority'       => 19,
        )));
        
    $wp_customize->add_setting('lwp-portfolio-callout-ser-text4', array(
        'default' => __('Your Title','gtl-portfolio'),
        'sanitize_callback' => 'sanitize_text_field'
    ));

    $wp_customize->add_control( new WP_Customize_Control($wp_customize, 'lwp-portfolio-callout-ser-text4-control', array(
            'label' => __('Service Title 4','gtl-portfolio'),
            'section' => 'lwp-portfolio-callout-section1',
            'settings' => 'lwp-portfolio-callout-ser-text4',
            'priority'       => 19,
        )));
    
    
    $wp_customize->add_setting('lwp-portfolio-callout-ser-des4', array(
        'default' => __('Enter your own text here.','gtl-portfolio'),
        'sanitize_callback' => 'sanitize_textarea_field'
    ));
    

    $wp_customize->add_control( new WP_Customize_Control($wp_customize, 'lwp-portfolio-callout-ser-des4-control', array(
            'label' => __('Service Paragraph Text 4','gtl-portfolio'),
            'section' => 'lwp-portfolio-callout-section1',
            'settings' => 'lwp-portfolio-callout-ser-des4',
            'type' => 'textarea',
            'priority'       => 19,
        )));
    
    $wp_customize->add_setting('lwp-portfolio-callout-ser-icon5', array(
        'default' => __('fa fa-cogs','gtl-portfolio'),
        'sanitize_callback' => 'sanitize_text_field'
    ));

    $wp_customize->add_control( new WP_Customize_Control($wp_customize, 'lwp-portfolio-callout-ser-icon5-control', array(
            'label' => __('Service Icon 5','gtl-portfolio'),
            'section' => 'lwp-portfolio-callout-section1',
            'settings' => 'lwp-portfolio-callout-ser-icon5',
            'priority'       => 19,
        )));
        
    $wp_customize->add_setting('lwp-portfolio-callout-ser-text5', array(
        'default' => __('Your Title','gtl-portfolio'),
        'sanitize_callback' => 'sanitize_text_field'
    ));

    $wp_customize->add_control( new WP_Customize_Control($wp_customize, 'lwp-portfolio-callout-ser-text5-control', array(
            'label' => __('Service Title 5','gtl-portfolio'),
            'section' => 'lwp-portfolio-callout-section1',
            'settings' => 'lwp-portfolio-callout-ser-text5',
            'priority'       => 19,
        )));
    
    $wp_customize->add_setting('lwp-portfolio-callout-ser-des5', array(
        'default' => __('Enter your own text here.','gtl-portfolio'),
        'sanitize_callback' => 'sanitize_textarea_field'
    ));
    

    $wp_customize->add_control( new WP_Customize_Control($wp_customize, 'lwp-portfolio-callout-ser-des5-control', array(
            'label' => __('Service Paragraph Text 5','gtl-portfolio'),
            'section' => 'lwp-portfolio-callout-section1',
            'settings' => 'lwp-portfolio-callout-ser-des5',
            'type' => 'textarea',
            'priority'       => 19,
        )));
    
       
     $wp_customize->add_setting('lwp-portfolio-callout-ser-icon6', array(
        'default' => __('fa fa-cogs','gtl-portfolio'),
        'sanitize_callback' => 'sanitize_text_field'
    ));

    $wp_customize->add_control( new WP_Customize_Control($wp_customize, 'lwp-portfolio-callout-ser-icon6-control', array(
            'label' => __('Service Icon 6','gtl-portfolio'),
            'section' => 'lwp-portfolio-callout-section1',
            'settings' => 'lwp-portfolio-callout-ser-icon6',
            'priority'       => 19,
        )));
        
    $wp_customize->add_setting('lwp-portfolio-callout-ser-text6', array(
        'default' => __('Your Title','gtl-portfolio'),
        'sanitize_callback' => 'sanitize_text_field'
    ));

    $wp_customize->add_control( new WP_Customize_Control($wp_customize, 'lwp-portfolio-callout-ser-text6-control', array(
            'label' => __('Service Title 6','gtl-portfolio'),
            'section' => 'lwp-portfolio-callout-section1',
            'settings' => 'lwp-portfolio-callout-ser-text6',
            'priority'       => 19,
        )));
        
    $wp_customize->add_setting('lwp-portfolio-callout-ser-des6', array(
        'default' => __('Enter your own text here.','gtl-portfolio'),
        'sanitize_callback' => 'sanitize_textarea_field'
    ));
    

    $wp_customize->add_control( new WP_Customize_Control($wp_customize, 'lwp-portfolio-callout-ser-des6-control', array(
            'label' => __('Service Paragraph Text 6','gtl-portfolio'),
            'section' => 'lwp-portfolio-callout-section1',
            'settings' => 'lwp-portfolio-callout-ser-des6',
            'type' => 'textarea',
            'priority'       => 19,
        )));
    
    /**
             * Gallery
             */
            
            $wp_customize->add_section('lwp-portfolio-callout-section2' , array(
                'title'             => __('Gallery', 'gtl-portfolio'),
                
                'panel'             => 'general_panel-section1'
                
            ) );
            
    $wp_customize->add_setting(
        'work_image_1',
        array(
            'default' => esc_url( get_stylesheet_directory_uri().'/assets/images/sfd-promo.png' ),
            'sanitize_callback' => 'esc_url_raw',
            'transport' => 'postMessage'
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'work_image_1',
            array(
               'label'          => __( 'Work Section Image 1', 'gtl-portfolio' ),
               'description'   => __('For best results please use an image with resolution  380px x 380px or more', 'gtl-portfolio'),
               'type'           => 'image',
               'section'        => 'lwp-portfolio-callout-section2',
               'settings'       => 'work_image_1',
               'priority'       => 22,
            )
        )
    );
    
    
    $wp_customize->add_setting(
        'work_image_2',
        array(
            'default' => esc_url( get_stylesheet_directory_uri().'/assets/images/sfd-promo.png'),
            'sanitize_callback' => 'esc_url_raw',
            'transport' => 'postMessage'
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'work_image_2',
            array(
               'label'          => __( 'Work Section Image 2', 'gtl-portfolio' ),
               'description'   => __('For best results please use an image with resolution  380px x 380px or more', 'gtl-portfolio'),
               'type'           => 'image',
               'section'        => 'lwp-portfolio-callout-section2',
               'settings'       => 'work_image_2',
               'priority'       => 22,
            )
        )
    );
    
    
    $wp_customize->add_setting(
        'work_image_3',
        array(
            'default' => esc_url( get_stylesheet_directory_uri().'/assets/images/sfd-promo.png' ),
            'sanitize_callback' => 'esc_url_raw',
            'transport' => 'postMessage'
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'work_image_3',
            array(
               'label'          => __( 'Work Section Image 3', 'gtl-portfolio' ),
               'description'   => __('For best results please use an image with resolution  380px x 380px or more', 'gtl-portfolio'),
               'type'           => 'image',
               'section'        => 'lwp-portfolio-callout-section2',
               'settings'       => 'work_image_3',
               'priority'       => 22,
            )
        )
    );
    
    
    $wp_customize->add_setting(
        'work_image_3',
        array(
            'default' => esc_url( get_stylesheet_directory_uri().'/assets/images/sfd-promo.png'),
            'sanitize_callback' => 'esc_url_raw',
            'transport' => 'postMessage'
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'work_image_3',
            array(
               'label'          => __( 'Work Section Image 3', 'gtl-portfolio' ),
               'description'   => __('For best results please use an image with resolution  380px x 380px or more', 'gtl-portfolio'),
               'type'           => 'image',
               'section'        => 'lwp-portfolio-callout-section2',
               'settings'       => 'work_image_3',
               'priority'       => 22,
            )
        )
    );
    
    
    $wp_customize->add_setting(
        'work_image_4',
        array(
            'default' => esc_url(get_stylesheet_directory_uri().'/assets/images/sfd-promo.png'),
            'sanitize_callback' => 'esc_url_raw',
            'transport' => 'postMessage'
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'work_image_4',
            array(
               'label'          => __( 'Work Section Image 4', 'gtl-portfolio' ),
               'description'   => __('For best results please use an image with resolution  380px x 380px or more', 'gtl-portfolio'),
               'type'           => 'image',
               'section'        => 'lwp-portfolio-callout-section2',
               'settings'       => 'work_image_4',
               'priority'       => 22,
            )
        )
    );
    
    
    $wp_customize->add_setting(
        'work_image_5',
        array(
            'default' => esc_url(get_stylesheet_directory_uri().'/assets/images/sfd-promo.png'),
            'sanitize_callback' => 'esc_url_raw',
            'transport' => 'postMessage'
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'work_image_5',
            array(
               'label'          => __( 'Work Section Image 5', 'gtl-portfolio' ),
               'description'   => __('For best results please use an image with resolution  380px x 380px or more', 'gtl-portfolio'),
               'type'           => 'image',
               'section'        => 'lwp-portfolio-callout-section2',
               'settings'       => 'work_image_5',
               'priority'       => 22,
            )
        )
    );
    
    
    $wp_customize->add_setting(
        'work_image_6',
        array(
            'default' => esc_url(get_stylesheet_directory_uri().'/assets/images/sfd-promo.png'),
            'sanitize_callback' => 'esc_url_raw',
            'transport' => 'postMessage'
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'work_image_6',
            array(
               'label'          => __( 'Work Section Image 6', 'gtl-portfolio' ),
               'description'   => __('For best results please use an image with resolution  380px x 380px or more', 'gtl-portfolio'),
               'type'           => 'image',
               'section'        => 'lwp-portfolio-callout-section2',
               'settings'       => 'work_image_6',
               'priority'       => 22,
            )
        )
    );
    
    
    $wp_customize->add_setting(
        'work_image_7',
        array(
            'default' => esc_url(get_stylesheet_directory_uri().'/assets/images/sfd-promo.png'),
            'sanitize_callback' => 'esc_url_raw',
            'transport' => 'postMessage'
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'work_image_7',
            array(
               'label'          => __( 'Work Section Image 7', 'gtl-portfolio' ),
               'description'   => __('For best results please use an image with resolution  380px x 380px or more', 'gtl-portfolio'),
               'type'           => 'image',
               'section'        => 'lwp-portfolio-callout-section2',
               'settings'       => 'work_image_7',
               'priority'       => 22,
            )
        )
    );
    
    
    $wp_customize->add_setting(
        'work_image_8',
        array(
            'default' => esc_url(get_stylesheet_directory_uri().'/assets/images/sfd-promo.png'),
            'sanitize_callback' => 'esc_url_raw',
            'transport' => 'postMessage'
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'work_image_8',
            array(
               'label'          => __( 'Work Section Image 8', 'gtl-portfolio' ),
               'description'   => __('For best results please use an image with resolution  380px x 380px or more', 'gtl-portfolio'),
               'type'           => 'image',
               'section'        => 'lwp-portfolio-callout-section2',
               'settings'       => 'work_image_8',
               'priority'       => 22,
            )
        )
    );
    
    
    $wp_customize->add_setting(
        'work_image_9',
        array(
            'default' => esc_url(get_stylesheet_directory_uri().'/assets/images/sfd-promo.png'),
            'sanitize_callback' => 'esc_url_raw',
            'transport' => 'postMessage'
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'work_image_9',
            array(
               'label'          => __( 'Work Section Image 9', 'gtl-portfolio' ),
               'description'   => __('For best results please use an image with resolution  380px x 380px or more', 'gtl-portfolio'),
               'type'           => 'image',
               'section'        => 'lwp-portfolio-callout-section2',
               'settings'       => 'work_image_9',
               'priority'       => 22,
            )
        )
    );
    
    
    $wp_customize->add_setting('lwp-portfolio-callout-gal-head', array(
        'default' => __('Your Title','gtl-portfolio'),
        'sanitize_callback' => 'sanitize_text_field'
    ));

    $wp_customize->add_control( new WP_Customize_Control($wp_customize, 'lwp-portfolio-callout-gal-head-control', array(
            'label' => __('Gallery Heading','gtl-portfolio'),
            'section' => 'lwp-portfolio-callout-section2',
            'settings' => 'lwp-portfolio-callout-gal-head',
            'priority'       => 20,
        )));
        
    $wp_customize->add_setting('lwp-portfolio-callout-gal-desc', array(
        'default' => __('Your Title','gtl-portfolio'),
        'sanitize_callback' => 'sanitize_text_field'
    ));

    $wp_customize->add_control( new WP_Customize_Control($wp_customize, 'lwp-portfolio-callout-gal-desc-control', array(
            'label' => __('Gallery Description','gtl-portfolio'),
            'section' => 'lwp-portfolio-callout-section2',
            'settings' => 'lwp-portfolio-callout-gal-desc',
            'priority'       => 21,
        )));

     /**
             * Counter
             */
            
            $wp_customize->add_section('lwp-portfolio-callout-section3' , array(
                'title'             => __('Counters', 'gtl-portfolio'),
                
                'panel'             => 'general_panel-section1'
                
            ) );
     
     $wp_customize->add_setting('lwp-portfolio-callout-val-head1', array(
        'default' => __('Your Title','gtl-portfolio'),
        'sanitize_callback' => 'sanitize_text_field'
    ));

    $wp_customize->add_control( new WP_Customize_Control($wp_customize, 'lwp-portfolio-callout-val-head1-control', array(
            'label' => __('Counter 1 Title','gtl-portfolio'),
            'section' => 'lwp-portfolio-callout-section3',
            'settings' => 'lwp-portfolio-callout-val-head1',
            'priority'       => 23,
        )));
        
    
    
    $wp_customize->add_setting(
        'lwp-portfolio-callout-val-desc1',
        array(
            'sanitize_callback' => 'absint',
            'default'           => '75',
        )       
    );

    $wp_customize->add_control( 'lwp-portfolio-callout-val-desc1', array(
        'type'        => 'number',
        'priority'    => 23,
        'section'     => 'lwp-portfolio-callout-section3',
        'label'       => __(' Value 1', 'gtl-portfolio'),
        'input_attrs' => array(
            'min'   => 0,
            'max'   => 1000,
            'step'  => 1,
        ),
    ) );
    
    $wp_customize->add_setting('lwp-portfolio-callout-val-head2', array(
        'default' => __('Your Title','gtl-portfolio'),
        'sanitize_callback' => 'sanitize_text_field'
    ));

    $wp_customize->add_control( new WP_Customize_Control($wp_customize, 'lwp-portfolio-callout-val-head2-control', array(
            'label' => __('Counter 2 Title','gtl-portfolio'),
            'section' => 'lwp-portfolio-callout-section3',
            'settings' => 'lwp-portfolio-callout-val-head2',
            'priority'       => 23,
        )));
        
    $wp_customize->add_setting(
        'lwp-portfolio-callout-val-desc2',
        array(
            'sanitize_callback' => 'absint',
            'default'           => '75',
        )       
    );

    $wp_customize->add_control( 'lwp-portfolio-callout-val-desc2', array(
        'type'        => 'number',
        'priority'    => 23,
        'section'     => 'lwp-portfolio-callout-section3',
        'label'       => __(' Value 2', 'gtl-portfolio'),
        'input_attrs' => array(
            'min'   => 0,
            'max'   => 1000,
            'step'  => 1,
        ),
    ) );
    
    $wp_customize->add_setting('lwp-portfolio-callout-val-head3', array(
        'default' => __('Your Title','gtl-portfolio'),
        'sanitize_callback' => 'sanitize_text_field'
    ));

    $wp_customize->add_control( new WP_Customize_Control($wp_customize, 'lwp-portfolio-callout-val-head3-control', array(
            'label' => __('Counter 3 Title','gtl-portfolio'),
            'section' => 'lwp-portfolio-callout-section3',
            'settings' => 'lwp-portfolio-callout-val-head3',
            'priority'       => 23,
        )));
        
    $wp_customize->add_setting(
        'lwp-portfolio-callout-val-desc3',
        array(
            'sanitize_callback' => 'absint',
            'default'           => '75',
        )       
    );

    $wp_customize->add_control( 'lwp-portfolio-callout-val-desc3', array(
        'type'        => 'number',
        'priority'    => 23,
        'section'     => 'lwp-portfolio-callout-section3',
        'label'       => __(' Value 3', 'gtl-portfolio'),
        'input_attrs' => array(
            'min'   => 0,
            'max'   => 1000,
            'step'  => 1,
        ),
    ) );
    
    $wp_customize->add_setting('lwp-portfolio-callout-val-head4', array(
        'default' => __('Your Title','gtl-portfolio'),
        'sanitize_callback' => 'sanitize_text_field'
    ));

    $wp_customize->add_control( new WP_Customize_Control($wp_customize, 'lwp-portfolio-callout-val-head4-control', array(
            'label' => __('Counter 4 Title','gtl-portfolio'),
            'section' => 'lwp-portfolio-callout-section3',
            'settings' => 'lwp-portfolio-callout-val-head4',
            'priority'       => 23,
        )));
        
    $wp_customize->add_setting(
        'lwp-portfolio-callout-val-desc4',
        array(
            'sanitize_callback' => 'absint',
            'default'           => '75',
        )       
    );

    $wp_customize->add_control( 'lwp-portfolio-callout-val-desc4', array(
        'type'        => 'number',
        'priority'    => 23,
        'section'     => 'lwp-portfolio-callout-section3',
        'label'       => __(' Value 4', 'gtl-portfolio'),
        'input_attrs' => array(
            'min'   => 0,
            'max'   => 1000,
            'step'  => 1,
        ),
    ) );
    
     /**
             * Promotions
             */
            
            $wp_customize->add_section('lwp-portfolio-callout-section4' , array(
                'title'             => __('Promotions', 'gtl-portfolio'),
                
                'panel'             => 'general_panel-section1'
                
            ) );

    $wp_customize->add_setting('lwp-portfolio-callout-ot-head', array(
        'default' => __('Your Title','gtl-portfolio'),
        'sanitize_callback' => 'sanitize_text_field'
    ));

    $wp_customize->add_control( new WP_Customize_Control($wp_customize, 'lwp-portfolio-callout-ot-head-control', array(
            'label' => __('Team Section Heading','gtl-portfolio'),
            'section' => 'lwp-portfolio-callout-section4',
            'settings' => 'lwp-portfolio-callout-ot-head',
            'priority'       => 24,
        )));
        
    $wp_customize->add_setting('lwp-portfolio-callout-ot-desc', array(
        'default' => __('Enter Your Description','gtl-portfolio'),
        'sanitize_callback' => 'sanitize_text_field'
    ));

    $wp_customize->add_control( new WP_Customize_Control($wp_customize, 'lwp-portfolio-callout-ot-desc-control', array(
            'label' => __('Team Description','gtl-portfolio'),
            'section' => 'lwp-portfolio-callout-section4',
            'settings' => 'lwp-portfolio-callout-ot-desc',
            'priority'       => 25,
        )));

     $wp_customize->add_setting(
        'team_image_1',
        array(
            'default' => esc_url(get_stylesheet_directory_uri().'/assets/images/sfd-promo.png'),
            'sanitize_callback' => 'esc_url_raw',
            'transport' => 'postMessage'
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'team_image_1',
            array(
               'label'          => __( 'Team Section Image 1', 'gtl-portfolio' ),
               'description'   => __('For best results please use an image with resolution  380px x 530px or more', 'gtl-portfolio'),
               'type'           => 'image',
               'section'        => 'lwp-portfolio-callout-section4',
               'settings'       => 'team_image_1',
               'priority'       => 26,
            )
        )
    );
    
    $wp_customize->add_setting('lwp-portfolio-callout-p-head1', array(
        'default' => __('Your Title','gtl-portfolio'),
        'sanitize_callback' => 'sanitize_text_field'
    ));

    $wp_customize->add_control( new WP_Customize_Control($wp_customize, 'lwp-portfolio-callout-p-head1-control', array(
            'label' => __('Position Name 1','gtl-portfolio'),
            'section' => 'lwp-portfolio-callout-section4',
            'settings' => 'lwp-portfolio-callout-p-head1',
            'priority'       => 26,
        )));
    
    $wp_customize->add_setting('lwp-portfolio-callout-p-desc1', array(
        'default' => __('Enter Your Description','gtl-portfolio'),
        'sanitize_callback' => 'sanitize_text_field'
    ));

    $wp_customize->add_control( new WP_Customize_Control($wp_customize, 'lwp-portfolio-callout-p-desc1-control', array(
            'label' => __('Position Description 1','gtl-portfolio'),
            'section' => 'lwp-portfolio-callout-section4',
            'settings' => 'lwp-portfolio-callout-p-desc1',
            'priority'       => 26,
        )));
        
    
    $wp_customize->add_setting(
        'team_image_2',
        array(
            'default' => esc_url(get_stylesheet_directory_uri().'/assets/images/sfd-promo.png'),
            'sanitize_callback' => 'esc_url_raw',
            'transport' => 'postMessage'
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'team_image_2',
            array(
               'label'          => __( 'Team Section Image 2', 'gtl-portfolio' ),
               'description'   => __('For best results please use an image with resolution  380px x 530px or more', 'gtl-portfolio'),
               'type'           => 'image',
               'section'        => 'lwp-portfolio-callout-section4',
               'settings'       => 'team_image_2',
               'priority'       => 27,
            )
        )
    );
    
    $wp_customize->add_setting('lwp-portfolio-callout-p-head2', array(
        'default' => __('Your Title','gtl-portfolio'),
        'sanitize_callback' => 'sanitize_text_field'
    ));

    $wp_customize->add_control( new WP_Customize_Control($wp_customize, 'lwp-portfolio-callout-p-head2-control', array(
            'label' => __('Position Name 2','gtl-portfolio'),
            'section' => 'lwp-portfolio-callout-section4',
            'settings' => 'lwp-portfolio-callout-p-head2',
            'priority'       => 27,
        )));
    
    $wp_customize->add_setting('lwp-portfolio-callout-p-desc2', array(
        'default' => __('Enter Your Description','gtl-portfolio'),
        'sanitize_callback' => 'sanitize_text_field'
    ));

    $wp_customize->add_control( new WP_Customize_Control($wp_customize, 'lwp-portfolio-callout-p-desc2-control', array(
            'label' => __('Position Description 2','gtl-portfolio'),
            'section' => 'lwp-portfolio-callout-section4',
            'settings' => 'lwp-portfolio-callout-p-desc2',
            'priority'       => 27,
        )));

    $wp_customize->add_setting(
        'team_image_3',
        array(
            'default' => esc_url(get_stylesheet_directory_uri().'/assets/images/sfd-promo.png'),
            'sanitize_callback' => 'esc_url_raw',
            'transport' => 'postMessage'
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Image_Control(
            $wp_customize,
            'team_image_3',
            array(
               'label'          => __( 'Team Section Image 3', 'gtl-portfolio' ),
               'description'   => __('For best results please use an image with resolution  380px x 530px or more', 'gtl-portfolio'),
               'type'           => 'image',
               'section'        => 'lwp-portfolio-callout-section4',
               'settings'       => 'team_image_3',
               'priority'       => 28,
            )
        )
    );
    
     
    $wp_customize->add_setting('lwp-portfolio-callout-p-head3', array(
        'default' => __('Your Title','gtl-portfolio'),
        'sanitize_callback' => 'sanitize_text_field'
    ));

    $wp_customize->add_control( new WP_Customize_Control($wp_customize, 'lwp-portfolio-callout-p-head3-control', array(
            'label' => __('Position Name 3','gtl-portfolio'),
            'section' => 'lwp-portfolio-callout-section4',
            'settings' => 'lwp-portfolio-callout-p-head3',
            'priority'       => 28,
        )));
    
    $wp_customize->add_setting('lwp-portfolio-callout-p-desc3', array(
        'default' => __('Enter Your Description','gtl-portfolio'),
        'sanitize_callback' => 'sanitize_text_field'
    ));

    $wp_customize->add_control( new WP_Customize_Control($wp_customize, 'lwp-portfolio-callout-p-desc3-control', array(
            'label' => __('Position Description 3','gtl-portfolio'),
            'section' => 'lwp-portfolio-callout-section4',
            'settings' => 'lwp-portfolio-callout-p-desc3',
            'priority'       => 28,
        )));
    
    // Progress bar color
    $wp_customize->add_setting(
        'lwp-portfolio-callout-progress-bar-color',
        array(
            'default'           => '#df3d8c',
            'sanitize_callback' => 'sanitize_hex_color',
           
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'lwp-portfolio-callout-progress-bar-color-control',
            array(
                'label' => __('Progress Bar Color', 'gtl-portfolio'),
                'section' => 'lwp-portfolio-callout-section',
                'settings'      => 'lwp-portfolio-callout-progress-bar-color',
                'priority' => 30,
            )
        )
    );  

    $wp_customize->add_setting(
        'lwp-portfolio-callout-progress-heading-color',
        array(
            'default'           => '#df3d8c',
            'sanitize_callback' => 'sanitize_hex_color',
           
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'lwp-portfolio-callout-progress-heading-color-control',
            array(
                'label' => __('Skill Heading Color', 'gtl-portfolio'),
                'section' => 'lwp-portfolio-callout-section',
                'settings'      => 'lwp-portfolio-callout-progress-heading-color',
                'priority' => 31,
            )
        )
    );  

    $wp_customize->add_setting(
        'lwp-portfolio-callout-ser-icon-color',
        array(
            'default'           => '#3f66d2',
            'sanitize_callback' => 'sanitize_hex_color',
           
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'lwp-portfolio-callout-ser-icon-color-control',
            array(
                'label' => __('Service Icon Color', 'gtl-portfolio'),
                'section' => 'lwp-portfolio-callout-section1',
                'settings'      => 'lwp-portfolio-callout-ser-icon-color',
                'priority' => 32,
            )
        )
    );  

    
    
     
    $wp_customize->add_setting(
        'lwp-portfolio-callout-ser-head-color',
        array(
            'default'           => '#606060',
            'sanitize_callback' => 'sanitize_hex_color',
           
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'lwp-portfolio-callout-ser-head-color-control',
            array(
                'label' => __('Service Heading Color', 'gtl-portfolio'),
                'section' => 'lwp-portfolio-callout-section1',
                'settings'      => 'lwp-portfolio-callout-ser-head-color',
                'priority' => 33,
            )
        )
    );  
    
    $wp_customize->add_setting(
        'lwp-portfolio-callout-ser-box-color',
        array(
            'default'           => '#ffffff',
            'sanitize_callback' => 'sanitize_hex_color',
           
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'lwp-portfolio-callout-ser-box-color-control',
            array(
                'label' => __('Service Box Color', 'gtl-portfolio'),
                'section' => 'lwp-portfolio-callout-section1',
                'settings'      => 'lwp-portfolio-callout-ser-box-color',
                'priority' => 34,
            )
        )
    );  
    
    
    
    $wp_customize->add_setting(
        'lwp-portfolio-callout-ct-tt-color',
        array(
            'default'           => '#dcedfc',
            'sanitize_callback' => 'sanitize_hex_color',
           
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'lwp-portfolio-callout-ct-tt-color-control',
            array(
                'label' => __('Counter Heading Color', 'gtl-portfolio'),
                'section' => 'lwp-portfolio-callout-section3',
                'settings'      => 'lwp-portfolio-callout-ct-tt-color',
                'priority' => 35,
            )
        )
    );  
    
    $wp_customize->add_setting(
        'lwp-portfolio-callout-ct-val-color',
        array(
            'default'           => '#efefef',
            'sanitize_callback' => 'sanitize_hex_color',
           
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'lwp-portfolio-callout-ct-val-color-control',
            array(
                'label' => __('Counter Value Color', 'gtl-portfolio'),
                'section' => 'lwp-portfolio-callout-section3',
                'settings'      => 'lwp-portfolio-callout-ct-val-color',
                'priority' => 36,
            )
        )
    );  
    
    $wp_customize->add_setting(
        'lwp-portfolio-callout-team-head-color',
        array(
            'default'           => '#dcedfc',
            'sanitize_callback' => 'sanitize_hex_color',
           
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'lwp-portfolio-callout-team-head-color-control',
            array(
                'label' => __('Position Heading Color', 'gtl-portfolio'),
                'section' => 'lwp-portfolio-callout-section4',
                'settings'      => 'lwp-portfolio-callout-team-head-color',
                'priority' => 37,
            )
        )
    );  
    
    $wp_customize->add_setting(
        'lwp-portfolio-callout-team-desc-color',
        array(
            'default'           => '#efefef',
            'sanitize_callback' => 'sanitize_hex_color',
           
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'lwp-portfolio-callout-team-desc-color-control',
            array(
                'label' => __('Position Description Color', 'gtl-portfolio'),
                'section' => 'lwp-portfolio-callout-section4',
                'settings'      => 'lwp-portfolio-callout-team-desc-color',
                'priority' => 37,
            )
        )
    );  
    
    $wp_customize->add_setting(
        'lwp-portfolio-callout-sec-head-color',
        array(
            'default'           => '#444444',
            'sanitize_callback' => 'sanitize_hex_color',
           
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'lwp-portfolio-callout-sec-head-color-control',
            array(
                'label' => __('Section Heading Color', 'gtl-portfolio'),
                'section' => 'lwp-portfolio-callout-section',
                'settings'      => 'lwp-portfolio-callout-sec-head-color',
                'priority' => 38,
            )
        )
    );  
    
    $wp_customize->add_setting(
        'lwp-portfolio-callout-sec-desc-color',
        array(
            'default'           => '#353535',
            'sanitize_callback' => 'sanitize_hex_color',
           
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'lwp-portfolio-callout-sec-desc-color-control',
            array(
                'label' => __('Section Description Color', 'gtl-portfolio'),
                'section' => 'lwp-portfolio-callout-section',
                'settings'      => 'lwp-portfolio-callout-sec-desc-color',
                'priority' => 38,
            )
        )
    );  
    
    $wp_customize->add_setting(
        'lwp-portfolio-callout-sec-line-color',
        array(
            'default'           => '#666666',
            'sanitize_callback' => 'sanitize_hex_color',
           
        )
    );

    $wp_customize->add_control(
        new WP_Customize_Color_Control(
            $wp_customize,
            'lwp-portfolio-callout-sec-line-color-control',
            array(
                'label' => __('Section Line Color', 'gtl-portfolio'),
                'section' => 'lwp-portfolio-callout-section',
                'settings'      => 'lwp-portfolio-callout-sec-line-color',
                'priority' => 38,
            )
        )
    );  
    
    
       
}

add_action('customize_register', 'gtl_portfolio_portfolio_callout');

endif;


if( ! function_exists('gtl_portfolio_dynamic_css') ):

function gtl_portfolio_dynamic_css(){

    

    ?>

    <style>

        #scroll-top {
            background: #df3d8c !important;

            padding: 15px;

            margin: 50px;
            
            float:<?php echo get_theme_mod('gtl_scroll_top_position') ?> !important;
            
            display:<?php echo get_theme_mod('gtl_scroll_top_display') ?> !important;
            
           
           
        }  
        
        #scroll-top span {
             color: #fff ;
             font-size: 20px;
             font-weight: 700;
        }
        
        .progress-bar > span, .progress-bar {
                background:<?php echo get_theme_mod('lwp-portfolio-callout-progress-bar-color')?> !important;
        }
        
        .progress-bar > span::before {
              border-top-color:<?php echo get_theme_mod('lwp-portfolio-callout-progress-bar-color')?> !important;
        }
        
        .lead {
            color:<?php echo get_theme_mod('lwp-portfolio-callout-progress-heading-color')?> !important;
        }
        
        .single-service .fa {
            color:<?php echo get_theme_mod('lwp-portfolio-callout-ser-icon-color')?> !important;
        }
        
        .single-service h3 {
            color:<?php echo get_theme_mod('lwp-portfolio-callout-ser-head-color')?> !important;
        }
        
        .white-bg {
        background:<?php echo get_theme_mod('lwp-portfolio-callout-ser-box-color')?> !important;
        }
        
        .count-title h2 {
            color: <?php echo get_theme_mod('lwp-portfolio-callout-ct-val-color')?> !important;
        }
        
        .count-title span {
            color: <?php echo get_theme_mod('lwp-portfolio-callout-ct-tt-color')?> !important;
        }
        
        .team-info h3 {
            color: <?php echo get_theme_mod('lwp-portfolio-callout-team-head-color')?> !important;
        }
        
        .team-info span {
            color: <?php echo get_theme_mod('lwp-portfolio-callout-team-desc-color')?> !important;
        }
        
        .section-title h2 {
            color: <?php echo get_theme_mod('lwp-portfolio-callout-sec-head-color')?> !important;
        }
        
        .section-title p {
            color: <?php echo get_theme_mod('lwp-portfolio-callout-sec-desc-color')?> !important;
        }
        
        .about-rightsidebar h2 {
            color: <?php echo get_theme_mod('lwp-portfolio-callout-sec-head-color')?> !important;
        }
        
        .about-rightsidebar p {
            color: <?php echo get_theme_mod('lwp-portfolio-callout-sec-desc-color')?> !important;
        }
        
        .section-title > h2::before {
            background:<?php echo get_theme_mod('lwp-portfolio-callout-sec-line-color')?> !important; 
        
    </style>

    <?php 

    echo ob_get_clean();

}



endif;

add_action( 'wp_head' , 'gtl_portfolio_dynamic_css' , 55 );

add_editor_style('editor-style.css');

require 'inc/activation.php';


