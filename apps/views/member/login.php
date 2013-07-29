<?php defined('BASEPATH') or die('No direct script access allowed');

// Import class
?>
<!-- @formatter:off -->

<div style="padding-top: 111px">
	<?php echo validation_errors(); ?>

	<?php echo form_open('login'); ?>
		Identity: <input type="text" name="identity" value="<?php echo set_value('identity'); ?>" /><br/>
		Password: <input type="password" name="password" value="<?php echo set_value('password'); ?>" /><br/>
		<input type="submit" />
	<?php echo form_close(); ?>
</div>