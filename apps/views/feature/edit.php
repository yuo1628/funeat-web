<?php defined('BASEPATH') or die('No direct script access allowed');

// Import class
use models\entity\Entity as Entity;

/**
 * @var models\entity\restaurant\Features
 */
$feature;

$title = Entity::preset(set_value('title'), $feature->getTitle());
$icon = $feature->getIcon();
?>
<!-- @formatter:off -->

<div style="padding-top: 111px">
	<?php echo validation_errors(); ?>

	<?php echo form_open_multipart('feature/save'); ?>

		File: <input type="file" name="icon" /><?php if ($icon) echo "<img src=\"data:image/png;base64, {$icon}\" />"; ?><br/>
		Title: <input type="text" name="title" value="<?php echo $title; ?>" /><br/>
		<input type="submit" />
	<?php echo form_close(); ?>
</div>