<?php defined('BASEPATH') or die('No direct script access allowed');

// Import class
use models\notification\Action;

$types;

$actions = Action::getActions();
?>
<!-- @formatter:off -->
<div style="padding-top: 111px">
	<div class="typeList">
		<?php foreach ($types as $i => $item) :
			/**
			 * @var models\entity\notification\Notifications
			 */
			$item;
			if ($index = array_search($item->action, $actions)) {
				unset($actions[$index]);
			}
			?>
			Action: <?php echo $item->action; ?> Template: <?php echo $item->template; ?>
		<?php endforeach; ?>
	</div>
	<div class="typeAdd">
		<form method="post" action="<?php echo site_url('notification/typeSave'); ?>">
			Action: <select name="action">
				<?php foreach ($actions as $key => $value): ?>
					<?php echo "<option value=\"$value\">$value</option>"; ?>
				<?php endforeach; ?>
				</select>
			Template: <input name="template" /><br/>
			<input type="submit" /><br/>
		</form>
	</div>
</div>