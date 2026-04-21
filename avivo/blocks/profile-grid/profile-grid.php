<?php
//===================================================================
//	Profile Grid Block
//	Custom Section Block using ACF
//===================================================================

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

// Placeholder info
$placeholder_title	= 'Profile Grid';

// Social Media Icons
$arrSocMedIconClass = array(
	'in' => 'ic-linkedin',
	'ig' => 'ic-instagram',
	'fb' => 'ic-facebook',
	'tt' => 'ic-tiktok',
);

// Get the ACF fields for content slider
$section_items		= get_field('section_items') ?? false;		// array

// Get ACF fields for setting
$section_config		= get_field('section_config') ?? false;		// array

$section_config['section_colour']		= get_field('section_colour') ?? '';				// string
$section_config['section_column']		= get_field('section_column') ?? '3';				// string, default 3 columns
$section_config['section_grid_style']	= get_field('section_grid_style') ?? 'sgl-mno';		// string, set to minimalist no border grid
//	$section_config['section_grid_padding']	= get_field('section_grid_padding') ?? '';			// string
//	$section_config['section_grid_spacing']	= get_field('section_grid_spacing') ?? 'sgs-xl';	// string, set to xl spacing

// Define section element class names
$section_config['section_classname']			= 'cdb-profile_grid';		// section block class name

// Check if section_items has item
$has_items = isset($section_items) && is_array($section_items) && count($section_items)>0;

// check if the slider has any slide, if not show the placeholder
if (is_admin() && !$has_items) {
	echo cd_cdb_placeholder($placeholder_title, $section_config);
} else {
	// check if the slider has any slide
	if ($has_items) {
		// Output user-defined custom CSS
		echo cd_section_user_custom_css($section_config);
?>
		<section class="<?php echo cd_get_section_config_class($section_config); ?>"<?php echo cd_get_section_id($section_config); ?>>
			<div class="container section-container">
				<div class="grid-container content-container<?php echo cd_get_section_grid_class($section_config); ?>">
				<?php
					// Loop through all the profiles
					foreach( $section_items as $item ) {

						// Get the ACF fields
						// Front end, set to false or empty by default
						$item_profile_photo			= $item['item_profile_photo'] ?? 0;				// integer
						$item_profile_name			= $item['item_profile_name'] ?? '';				// string
						$item_profile_role			= $item['item_profile_role'] ?? '';				// string
						$item_profile_description	= $item['item_profile_description'] ?? '';		// string
						$item_social_media			= $item['item_social_media'] ?? false;			// array

						if (is_admin()) {
							// Set the default value on admin area only
							$item_profile_name       = !empty($item_profile_name) ? $item_profile_name : 'Add Profile Name';
						}

						echo '<div class="grid-item profile_grid__tile">';
							echo '<div class="grid-item-content profile_grid__tile_container">';

								// Profile Photo
								$image = wp_get_attachment_image($item_profile_photo, 'full');
								if (empty($image)) {
									$default_image_path = get_template_directory() . '/img/profile-pic.png'; // Absolute path
									if (file_exists($default_image_path)) {
										$default_image_url = get_template_directory_uri() . '/img/profile-pic.png';
										$image = '<img src="' . esc_url($default_image_url) . '" alt="Default profile picture">';
									}
								}

								echo '<div class="profile_grid__tile_photo">';
								echo	'<div class="image_wrapper">';
								echo		$image;
								echo	'</div>';
								echo '</div>';

								echo '<div class="profile_grid__tile_content">';
									
									echo '<div class="profile_grid__tile_title">';
										// Check if item_profile_name exists and is not empty
										if (!empty($item_profile_name)) {
											echo cd_title( array(
												'title_text'			=> $item_profile_name,
												'title_tag'				=> 'div',
												'title_size'			=> 'h3',
												'title_alignment'		=> '',
												'title_class'			=> '', // custom class name, e.g., entry_title
												'title_subheading'		=> 'below',
												'title_subheading_text'	=> $item_profile_role,
												'title_subheading_tag'	=> 'div',
												'title_subheading_size'	=> 'sm',
											));

											// check if there is any social media links
											if (isset($item_social_media) && is_array($item_social_media) && count($item_social_media)>0 ) {
												echo '<div class="profile_grid__tile_socmed_wrapper">';
												echo cd_generate_social_links($item_social_media, 'profile_grid__socmed', true);
												echo '</div>';
											}
										}
									echo '</div>';

									// Check if item_profile_description exists
									if (!empty($item_profile_description)) {								
										echo cd_print_richtext($item_profile_description, '<div class="profile_grid__tile_description">', '</div>');
									}

								echo '</div>';

							echo '</div>';
						echo '</div>';
					}

				?>
				</div>
			</div>
		</section>
<?php
		}
	}
?>