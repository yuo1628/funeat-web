<?php
// Pretreatment
$features; // 店家服務特色標籤
?>
<?php echo validation_errors(); ?>

<?php echo form_open_multipart('restaurant/add'); ?>
	店名: <input type="text" name="name" value="<?php echo set_value('name'); ?>" required /><br/>
	住址: <input type="text" name="address" value="<?php echo set_value('address'); ?>" required /><br/>
	電話: <input type="text" name="tel" value="<?php echo set_value('tel'); ?>" /><br/>
	時間: <input type="text" name="hours" value="<?php echo set_value('hours'); ?>" /><br/>
	網站: <input type="text" name="website" value="<?php echo set_value('website'); ?>" /><br/>
	圖片: <input type="file" name="images[]" /><br/>
	服務特色:<br/>
	<?php foreach ($features as $v): ?>
		<input type="checkbox" name="features[]" value="<?php echo $v->getId(); ?>" /><?php echo $v->getTitle(); ?><br/>
	<?php endforeach; ?>
	<input type="submit" />
<?php echo form_close(); ?>
