<?php
//===================================================================
//	Rich Text with Chapter
//	Custom Section Block using ACF
//===================================================================
	

	// Get ACF fields for setting
	$section_config		= get_field('section_config') ?? false;		// array
	$section_config['section_colour']	= get_field('section_colour') ?? '';		// string

  	// Define section element class names
	$section_config['section_classname']			= 'cdb-case_study_info';		// section block class name

	$case_study_client = get_field('case_study_client', get_the_ID()) ?? '';
	$case_study_year = get_field('case_study_year', get_the_ID()) ?? '';
	$case_study_industry = get_field('case_study_industry', get_the_ID()) ?? '';
	$case_study_logo = get_field('case_study_logo', get_the_ID()) ?? false;
	$case_study_url = get_field('case_study_url', get_the_ID()) ?? '';

  // Output user-defined custom CSS
  echo cd_section_user_custom_css($section_config);

?>
<section class="<?php echo cd_get_section_config_class($section_config); ?>"<?php echo cd_get_section_id($section_config); ?> >
	<?php if (get_post_type() === 'case-study') : ?>
		<div class="container section-container">
			<div class="content-container case-study-info">
				<?php 
					// var_dump($section_posts_selection);
					// var_dump($section_posts);
					// var_dump($selection_posts_ids);
				?>

				<div class="chapter-cols">
					<div class="case-study-info__chapter chapter-cols__chapter">

					</div>
					<div class="case-study-info__content chapter-cols__content">
						<hr><br />

						<?php 
							if (is_admin()) {
								if (empty($case_study_client)) {
									echo 'Please fill in case study info fields (Client, Year of Completion, etc), and categories (Expertise) in the right sidebar. And then save & refresh the page.';
								}
							}						
						?>

						<div class="case-study-info__cols">
							<div>
								<?php if (!empty($case_study_client)) { ?>
									<div class="case-study-info__client">
										<strong class="case-study-info__label">Client</strong>
										<?php echo cd_print_wrap_tags($case_study_client,'<span class="case-study-info__value">','</span>'); ?>
									</div>
								<?php } ?>


								<?php if (!empty($case_study_industry)) { ?>
									<div class="case-study-info__industry">
										<strong class="case-study-info__label">Industry</strong>
										<?php echo cd_print_wrap_tags($case_study_industry,'<span class="case-study-info__value">','</span>'); ?>
									</div>
								<?php } ?>

							</div>
							<div>
									<?php 
										// display taxonomy list named case-study-category
										$terms = get_the_terms( get_the_ID(), 'case-study-category' );
										if ( !empty($terms) ) {
											echo '<div class="case-study-info__categories">';
											echo '<strong class="case-study-info__label">Expertise</strong>';
											echo '<ul>';
											foreach ( $terms as $term ) {
												echo '<li>' . $term->name . '</li>';
											}
											echo '</ul>';
											echo '</div>';
										}
									?>

								<?php if (!empty($case_study_year)) { ?>
									<div class="case-study-info__year">
										<strong class="case-study-info__label">Year of Completion</strong>
										<?php echo cd_print_wrap_tags($case_study_year,'<span class="case-study-info__value">','</span>'); ?>
									</div>
								<?php } ?>

							</div>
							<div>
								<?php if (!empty($case_study_logo)) { ?>
									<div class="case-study-info__logo">
										<?php echo wp_get_attachment_image($case_study_logo, 'full'); ?>
									</div>
								<?php } ?>
								<?php if (!empty($case_study_url)) { ?>
									<div class="case-study-info__url">
										<strong class="case-study-info__label">Website</strong>
										<span class="case-study-info__value">
											<a href="<?php echo $case_study_url; ?>" target="_blank">												
												<?php /* echo preg_replace('/^(https?:\/\/)?(www\.)?/', '', $case_study_url); */ ?>
											</a>

											<?php 
												// echo cd_button(array(
												// 	'text'		=> preg_replace('/^(https?:\/\/)?(www\.)?/', '', $case_study_url),
												// 	'href'		=> $case_study_url,
												// 	'style'		=> 't-dark',
												// 	'size'		=> '',
												// 	'icon'		=> 'r-arrow',
												// ));
											?>
											<a href="<?php echo $case_study_url; ?>" class="t-dark cdb-icon" target="_blank"><span class="link-text"><?php echo preg_replace('/^(https?:\/\/)?(www\.)?/', '', $case_study_url); ?></span><i class="ic-arrow-right"></i></a>

										</span>
									</div>
								<?php } ?>

							</div>
						</div>

						<br>

					</div>
				</div>

			</div>
		</div>
	<?php else: ?>
		This block is only for case study post type
	<?php endif; ?>
</section>
