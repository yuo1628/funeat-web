<?php defined('BASEPATH') or die('No direct script access allowed');

// Import class
$types;

?>
<!-- @formatter:off -->
<div style="padding-top: 111px">
	<div class="typeList">
		<?php foreach ($types as $i => $item) :
			/**
			 * @var models\entity\notification\Notifications
			 */
			$item;

			?>
			<?php echo $item->getId(); ?>
		<?php endforeach; ?>
	</div>
	<div class="typeAdd">
		<form method="post" action="<?php echo site_url('notification/typeSave'); ?>">
			Action: <input name="action" /><br/>
			Template: <input name="template" /><br/>
			<input type="submit" /><br/>
		</form>
	</div>
</div>