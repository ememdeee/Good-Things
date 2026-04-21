<?php
//===================================================================
//	Section Availability Finder
//	Custom Section Block using ACF
//===================================================================

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

// Placeholder info
$placeholder_title	= 'Availability Finder Label';

// Get the ACF fields
$section_label = get_field('section_label') ?? '';       
$section_description_supported = get_field('section_description_supported') ?? '';		// string
$section_button_row_supported = get_field('section_button_row_supported') ?? false;		// array
$section_description_notsupported = get_field('section_description_notsupported') ?? '';	// string
$section_button_row_notsupported = get_field('section_button_row_notsupported') ?? false;	// array
$section_description_notfound = get_field('section_description_notfound') ?? '';		// string

// Get ACF fields for setting
$section_config	= get_field('section_config') ?? false;				// array

// Section color
$section_config['section_colour']			= get_field('section_colour') ?? '';				// string
$section_config['section_content_width']	= get_field('section_content_width') ?? '';			// string
$section_config['section_content_position']	= get_field('section_content_position') ?? '';		// string

// Define section element class names
$section_config['section_classname']			= 'cdb-availability_finder';				// section block class name
$section_title['title_class']					= 'availability_finder__title';			// section title wrapper class name
$section_button_row['section_buttons_class']	= 'availability_finder__cta';			// section CTA wrapper class name

	// Output user-defined custom CSS
	echo cd_section_user_custom_css($section_config);
	?>
	<section class="<?php echo cd_get_section_config_class($section_config); ?>"<?php echo cd_get_section_id($section_config); ?>>
		<div class="container section-container" data-aos="fade-up">
			<div class="content-container">
				<div class="availability-finder__content">
          <?php echo cd_print_wrap_tags( $section_label,'<h3 class="availability-finder__label">','</h3>' ); ?>
					<div class="availability-finder__finder">
						<div class="availability-finder__search">
								<div class="availability-finder__input-group">
										<label for="availability-finder__location-input" class="visually-hidden">Enter your postcode or suburb</label>
										<input 
												type="search" 
												id="availability-finder__location-input" 
												placeholder="Enter your postcode or suburb" 
												aria-label="Enter your postcode or suburb"
										>
										<button id="availability-finder__search-button" aria-label="Search">
												<svg class="availability-finder__search-icon" viewBox="0 0 24 24" fill="currentColor">
														<path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/>
												</svg>
										</button>
								</div>
						</div>        

						<div class="availability-finder__results">
							<div class="availability-finder__result availability-finder__result--supported sc-softlime" role="status" aria-live="polite" style="display: none;">
								<span class="availability-finder__result-title h3" style="margin-bottom: 20px;"></span>
								<?php 
									echo cd_print_richtext( $section_description_supported,'<div class="availability-finder__result-description">','</div>' );
									if (isset($section_button_row_supported) && is_array($section_button_row_supported)) {
										echo cd_button_row($section_button_row_supported);
									}
								?>
							</div>

							<div class="availability-finder__result availability-finder__result--notsupported sc-softlime" role="status" aria-live="polite" style="display: none;">
								<span class="availability-finder__result-title h3" style="margin-bottom: 20px;"></span>
								<?php 
									echo cd_print_richtext( $section_description_notsupported,'<div class="availability-finder__result-description">','</div>' );
									if (isset($section_button_row_notsupported) && is_array($section_button_row_notsupported)) {
										echo cd_button_row($section_button_row_notsupported);
									}
								?>
							</div>

							<div class="availability-finder__result availability-finder__result--notfound sc-softlime" role="status" aria-live="polite" style="display: none;">
								<span class="availability-finder__result-title h3" style="margin-bottom: 20px;"></span>
								<?php 
									echo cd_print_richtext( $section_description_notfound,'<div class="availability-finder__result-description">','</div>' );
								?>
							</div>
						</div>

						


					</div>          
				</div>
			</div>
		</div>
	</section>
