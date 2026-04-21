<?php
//===================================================================
//	Section Tab Panel
//	Custom Section Block using ACF
//===================================================================

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;


$section_config = array();
$section_config['section_id']				= get_field('section_id') ?? '';				// string
$section_config['section_class']			= get_field('section_class') ?? '';				// string
$section_config['section_custom_css']		= get_field('section_custom_css') ?? '';		// string
$section_title = get_field('section_title') ?? '';				

$section_config['section_classname']			= 'cdb-tab_panel';				// 
$inner_blocks_template = array();

// if no section_id, generate random ID
if (empty($section_config['section_id'])) {
  $section_config['section_id'] = 'tab-panel-' . uniqid();
}

?>
<div class="<?php echo cd_get_simple_section_config_class($section_config); ?>" <?php echo cd_get_section_id($section_config); ?> data-tab-title="<?php echo esc_html($section_title); ?>">
  <?php 
	echo cd_section_user_custom_css($section_config);  
  ?>
  <InnerBlocks
      class="tab-panel__content"
      template="<?php echo esc_attr( wp_json_encode( $inner_blocks_template ) ); ?>"
  />    
</div>





