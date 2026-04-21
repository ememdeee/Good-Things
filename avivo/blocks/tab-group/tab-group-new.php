<?php
/**
 * Tab Group Block Template.
 *
 * @param array $block The block settings and attributes.
 * @param string $content The block inner HTML (contains rendered child blocks).
 * @param boolean $is_preview True during AJAX preview.
 * @param int $post_id The post ID this block is saved to.
 * @param array $wp_block The raw WP_Block object.
 */

// Generate a unique ID for the block if not already set.
$block_id = 'tab-group-' . $block['id'];
if( !empty($block['anchor']) ) {
    $block_id = $block['anchor'];
}

// Create class attribute allowing for custom classes
$class_name = 'my-tab-group';
if( !empty($block['className']) ) {
    $class_name .= ' ' . $block['className'];
}

?>

<div <?php echo wp_kses_data( get_block_wrapper_attributes( array( 'id' => $block_id, 'class' => $class_name ) ) ); ?>>
    <?php echo $content; ?>
</div>
