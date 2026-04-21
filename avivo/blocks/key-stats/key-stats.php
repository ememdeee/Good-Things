<?php
//===================================================================
//	Key Stats
//	Custom Section Block using ACF
//===================================================================

	$section_stats		= get_field('section_stats') ?? false;		// array

	if (is_admin()) {
		// Set the default value on admin area only
		// $section_title = (!empty($section_title) && !empty($section_title['title_text'])) ? $section_title : $default_title;
	}

	// Get ACF fields for setting
	$section_config		= get_field('section_config') ?? false;		// array
	$section_config['section_colour']	= get_field('section_colour') ?? '';		// string

  	// Define section element class names
	$section_config['section_classname']			= 'cdb-key_stats';		// section block class name

  // Output user-defined custom CSS
  echo cd_section_user_custom_css($section_config);

?>
<section class="<?php echo cd_get_section_config_class($section_config); ?>"<?php echo cd_get_section_id($section_config); ?> >
	<div class="container section-container">
		<div class="content-container key-stats">
			<?php 
				if (is_admin() && !(isset($section_stats) && is_array($section_stats) && count($section_stats)>0 )) {
					?>
					Please enter stats
				<?php
				} else { ?>
				<div class="key-stats__content">
					<ul class="key-stats__stats">
						<?php
							foreach( $section_stats as $stat ) {
								$stat_value = $stat['stat_value'] ?? '';
								$stat_description = $stat['stat_description'] ?? '';
								$stat_icon = $stat['stat_icon'] ?? '';

								echo '<li class="key-stat key-stat--icon-'. $stat_icon .'">';
								echo '<strong>' . $stat_value .  '</strong>';
								echo '<span>' . $stat_description . '</span>';
								echo '</li>';
							} ?>
					</ul>
				</div>
				<?php 
				}
			?>
		</div>
	</div>
</section>
