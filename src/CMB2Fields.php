<?php
namespace giorgiosaud\slickwp;

class CMB2Fields extends Singleton{
	public function __construct()
	{
		add_action( 'cmb2_admin_init', array($this,'paquetes_aditionals_fields' ));
	}	
	


	public function paquetes_aditionals_fields() {
		$cmb = new_cmb2_box( array(
			'id'            => SLICKWP_CMB2PREFIX . 'metabox',
			'title'         => esc_html__( 'Datos Para Carousel', 'slick_wp_plugin' ),
		'object_types'  => array( 'paquetes' ), // Post type
// 		// 'show_on_cb' => 'yourprefix_show_if_front_page', // function should return a bool value
		'context'    => 'after_title',
		'priority'   => 'high',
// 		// 'show_names' => true, // Show field names on the left
// 		// 'cmb_styles' => false, // false to disable the CMB stylesheet
// 		// 'closed'     => true, // true to keep the metabox closed by default
// 		// 'classes'    => 'extra-class', // Extra cmb2-wrap classes
// 		// 'classes_cb' => 'yourprefix_add_some_classes', // Add classes through a callback.
	) );	
		$cmb->add_field( array(
			'name'       => esc_html__( 'Big Carousel Title', 'slick_wp_plugin' ),
			'desc'       => esc_html__( 'Title to show in Carousel', 'slick_wp_plugin' ),
			'id'         => SLICKWP_CMB2PREFIX.'big_title',
			'type'       => 'wysiwyg',
			'options' => array(
		  	  'wpautop' => true, // use wpautop?
			  'textarea_name' => '¡¡¡', // set the textarea name to something different, square brackets [] can be used here
		      'textarea_rows' =>3, // rows="..."
		      'tabindex' => '',
		      'teeny' => false, // output the minimal editor config used in Press This
		      'tinymce' => true, // load TinyMCE, can be used to pass settings directly to TinyMCE using an array()
		      'quicktags' => true // load Quicktags, can be used to pass settings directly to Quicktags using an array()
			),
		) );
		$cmb->add_field( array(
			'name'       => esc_html__( 'Short Description', 'slick_wp_plugin' ),
			'desc'       => esc_html__( 'Short description to show in Carousel', 'slick_wp_plugin' ),
			'id'         => SLICKWP_CMB2PREFIX.'short_description',
			'type'       => 'wysiwyg',
			'options' => array(
		  	  'wpautop' => true, // use wpautop?
			  'textarea_name' => '¡ere¡', // set the textarea name to something different, square brackets [] can be used here
		      'textarea_rows' =>2, // rows="..."
		      'tabindex' => '',
		      'teeny' => false, // output the minimal editor config used in Press This
		      'tinymce' => true, // load TinyMCE, can be used to pass settings directly to TinyMCE using an array()
		      'quicktags' => true // load Quicktags, can be used to pass settings directly to Quicktags using an array()
			),
		) );
		
		$cmb->add_field(array(
			'name'=> esc_html__('Image For Carousel','slick_wp_plugin'),
			'desc'=> esc_html__('Image For Carousel in home or other pages','slick_wp_plugin'),
			'id'         => SLICKWP_CMB2PREFIX.'image_carousel',
			'type'       => 'file',
		// Optional:
			'options' => array(
				'url' => false, // Hide the text input for the url
			),
			'text'    => array(
				'add_upload_file_text' => 'Add File' // Change upload button text. Default: "Add or Upload File"
			),
			// query_args are passed to wp.media's library query.
			'query_args' => array(
			// 'type' => 'application/pdf', // Make library only display PDFs.
			// Or only allow gif, jpg, or png images
				'type' => array(
					'image/gif',
					'image/jpeg',
					'image/png',
				),
			),
			'preview_size' => 'slick_wp_carousel', // Image size to use when previewing in the admin.
		));
	}
}