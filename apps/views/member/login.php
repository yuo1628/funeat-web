<?php echo validation_errors(); ?>

<?php echo form_open('login'); ?>
	Identity: <input type="text" name="identity" value="<?php echo set_value('identity'); ?>" /><br/>
	Password: <input type="password" name="password" value="<?php echo set_value('password'); ?>" /><br/>
	<input type="submit" />
<?php echo form_close(); ?>
