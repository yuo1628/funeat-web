<?php
// Pretreatment

/**
 * 店家服務特色標籤陣列
 *
 * @var models\entity\restaurant\Features[]
 */
$features;

/**
 * 店家資料
 *
 * @var models\entity\restaurant\Restaurants
 */
$restaurant;

// 資料目標連結
$target = ($restaurant->getId() === null) ? 'restaurant/save' : 'restaurant/save/' . $restaurant->uuid;

$name = set_value('name');
$address = set_value('address');
$website = set_value('website');

?>
<?php echo validation_errors(); ?>

<?php echo form_open_multipart($target); ?>
	店名: <input type="text" name="name" value="<?php echo empty($name) ? $restaurant->name : $name ; ?>" required /><br/>
	住址: <input type="text" name="address" value="<?php echo empty($address) ? $restaurant->address : $address ; ?>" required /><br/>
	電話: <input type="text" name="tel" value="<?php echo set_value('tel'); ?>" /><br/>
	時間: <input type="text" name="hours" value="<?php echo set_value('hours'); ?>" /><br/>
	網站: <input type="text" name="website" value="<?php echo empty($website) ? $restaurant->website : $website ; ?>" /><br/>
	圖片: <input type="file" name="images[]" /><br/>
	服務特色:<br/>
	<?php foreach ($features as $v): ?>
		<input type="checkbox" name="features[]" value="<?php echo $v->getId(); ?>" /><?php echo $v->getTitle(); ?><br/>
	<?php endforeach; ?>
	<input type="submit" />
<?php echo form_close(); ?>
