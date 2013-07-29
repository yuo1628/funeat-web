<?php defined('BASEPATH') or die('No direct script access allowed');

// Import class
?>
<!-- @formatter:off -->

<div style="padding-top: 111px">
	<?php echo validation_errors(); ?>

	<?php echo form_open('member/register'); ?>
		Email: <input type="text" name="email" value="<?php echo set_value('email'); ?>" required /><br/>
		Password: <input type="password" name="password" value="" required /><br/>
		Confirm Password: <input type="password" name="confirmPassword" value="" required /><br/>
		<input type="checkbox" name="privacy" value="1" required />I accept terms of privacy statements<br/>
		<input type="submit" />
	<?php echo form_close(); ?>
</div>
