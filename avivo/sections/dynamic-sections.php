<?php

// Check if $dynamic_sections is set and contains 'sections'
if (!isset($dynamic_sections) || empty($dynamic_sections['sections'])) {
    return false;
}

// Retrieve the 'sections' from $dynamic_sections
$sections = $dynamic_sections['sections'];

// sections
foreach ($sections as $key => $section) {
	$type = $section['acf_fc_layout'];

	// Add an index starting at 1; keys start from 0
	$section['section_index'] = $key + 1;

	switch ($type) {
		case 'hero_slider':
			cd_render('sections/hero-slider.php', $section);
			break;
		case 'simple_content':
			cd_render('sections/simple-content.php', $section);
			break;
		case 'hero_banner':
			cd_render('sections/hero-banner.php', $section);
			break;
	}
}
