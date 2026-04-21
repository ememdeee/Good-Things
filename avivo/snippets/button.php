<?php 
    $button_text = $button_text ?? false;
    $button_link = $button_link ?? [];
    $button_style = $button_style ?? false;

    $button_additional_classes = $button_additional_classes ?? '';

    $button_class = 'btn';
    $button_class .= ' '.$button_additional_classes;
    $button_title = cd_get_array_item($button_link,'title');

    if (!empty($button_style)) {
        $button_class .= ' '.$button_style;
    }



?>

<?php if ($button_text) ?>
    <a href="<?= cd_get_array_item($button_link,'url') ?>" class="<?php echo $button_class; ?>" <?php echo (($button_title)?' title="'. $button_title .'"':''); ?>><span class="link-text"><?= $button_text ?></span></a>
<?php ?>