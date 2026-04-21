<?php
/**
 * The template for displaying search forms
 *
 * @package UnderStrapClue
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;
?>

<form method="get" id="searchform" action="<?php echo esc_url(home_url('/')); ?>" role="search">
	<label class="visually-hidden" for="s"><?php esc_html_e('Search for:', 'understrap'); ?></label>
	<div class="input-group">
		<input class="field form-control" id="s" name="s" type="text"
			placeholder="<?php esc_attr_e('Search', 'understrap'); ?>" value="<?php the_search_query(); ?>" aria-label="<?php esc_attr_e('Search', 'understrap'); ?>">
		<span class="input-group-append">
			<button class="submit" id="searchsubmit" type="submit">
				<?php esc_html_e('Search', 'understrap'); ?>
			</button>
		</span>
	</div>
</form>
