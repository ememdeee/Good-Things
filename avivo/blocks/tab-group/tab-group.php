<?php
//===================================================================
//	Section Tab Group
//	Custom Section Block using ACF
//===================================================================

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;


// $section_config = array();
// $section_config['section_id']				= get_field('section_id') ?? '';				// string
// $section_config['section_class']			= get_field('section_class') ?? '';				// string
// $section_config['section_custom_css']		= get_field('section_custom_css') ?? '';		// string

$section_config	= get_field('section_config') ?? false;				// array

$section_config['section_classname']			= 'cdb-tab_group';				// 
	echo cd_section_user_custom_css($section_config);

  $inner_blocks_template = array();

?>
<div class="<?php echo cd_get_section_config_class($section_config); ?>" <?php echo cd_get_section_id($section_config); ?>>
  <div class="section-container">
    <div class="content-container">
    <div class="tab-group__tabs">
    </div>
    <InnerBlocks
        class="tab-group__content"
        template="<?php echo esc_attr( wp_json_encode( $inner_blocks_template ) ); ?>"
    />    
    </div>
  </div>
</div>

<?php if ( ! $is_preview ) { ?>
<?php } ?>

<?php if ( ! $is_preview ) { ?>
<?php } ?>






