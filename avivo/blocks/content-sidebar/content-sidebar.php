<?php
//===================================================================
//	Section Tab Panel
//	Custom Section Block using ACF
//===================================================================

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;


// $section_config = array();
// $section_config['section_id']				= get_field('section_id') ?? '';				// string
// $section_config['section_class']			= get_field('section_class') ?? '';				// string
// $section_config['section_custom_css']		= get_field('section_custom_css') ?? '';		// string
$section_hide_sidebar  = get_field('section_hide_sidebar') ?? false;	// boolean
$section_config	= get_field('section_config') ?? false;				// array

$section_config['section_classname']			= 'cdb-content_sidebar';				// 
$inner_blocks_template = array();

?>
<div class="<?php echo cd_get_section_config_class($section_config); ?> <?php if ($section_hide_sidebar) { echo 'cdb-content_sidebar--hide-sidebar'; } ?>" <?php echo cd_get_section_id($section_config); ?>>
  <?php 
	echo cd_section_user_custom_css($section_config);  
  ?>
  <div class="container section-container">
    <div class="content-container content-sidebar">
      <InnerBlocks
          class="content-sidebar__content inner-wrapper"
          template="<?php echo esc_attr( wp_json_encode( $inner_blocks_template ) ); ?>"
      />    
      <div class="content-sidebar__sidebar inner-sidebar">
        <div class="sidebar-box sidebar-box--dropdown">
          <?php echo cd_display_aside_childpages() ?>
        </div>
      </div>

    </div>
  </div>
</div>





