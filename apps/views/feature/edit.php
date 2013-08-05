<?php defined('BASEPATH') or die('No direct script access allowed');

// Import class
use models\entity\Entity as Entity;
use models\ModelFactory;

/**
 * @var models\entity\restaurant\Features
 */
$feature = isset($feature) ? $feature : ModelFactory::getInstance('models\\entity\\restaurant\\Features');

// Form action
$target = ($feature->getId() === null) ? 'feature/save' : 'feature/save/' . $feature->getId();

$title = Entity::preset(set_value('title'), $feature->getTitle());
$icon = $feature->getIcon();
?>
<!-- @formatter:off -->
<?php echo validation_errors(); ?>

<?php echo form_open_multipart($target); ?>
	<div class="featureListBox">
		<div class="featureEditTitle">
			標籤資訊
		</div>
		<div class="featureEditMenu">
			<div class="featureEditItem">
				<div class="featureEditContainer">
					<div class="featureEditLabel">
						*標籤名
					</div>
					<div class="featureEditInput">
						<input type="text" name="title" value="<?php echo $title; ?>" required />
					</div>
					<div class="clearfix"></div>
				</div>
				<div class="featureEditHelp">
					請輸標籤名
				</div>
				<div class="clearfix"></div>
			</div>

			<div class="featureEditContainer">
				<div class="featureEditLabel">
					圖示
				</div>
				<div class="featureEditInput">
					<?php if ($icon) echo "<img src=\"data:image/png;base64, {$icon}\" />"; ?><input type="file" name="icon" />
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="featureEditHelp">
				最佳大小為：30 X 30 像素
				<br>
			</div>

			<div class="clearfix"></div>
		</div>

		<input type="submit" class="postBtn" value="發佈" />

		<div class="left" style="width:100%;height: 1px;"></div>

		<div class="clearfix"></div>
	</div>
</form>