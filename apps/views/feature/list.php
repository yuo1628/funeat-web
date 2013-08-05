<?php defined('BASEPATH') or die('No direct script access allowed');

// Import class
use models\entity\restaurant\Features as Feature;

// Load library
$this->load->helper('url');

/**
 * @var models\entity\restaurant\Features
 */
$features;


?>


	<div class="featureListBox">

		<div class="featureEditTitle">
			標籤列表
		</div>
		<div class="featureTagMenu">
			<?php foreach ($features as $i => $item): 
				?>
			<div class="featureTagItem">
				<img src="data:image/jpeg;base64, <?php echo $item->getIcon() ?>" title="<?php echo $item->getTitle() ?>" />
			</div>
			<?php endforeach; ?>
			
			<div class="clearfix"></div>
		</div>
		
		<div class="left" style="width:100%;height: 1px;"></div>
		<a href="index.php/feature/add">
			<div class="addBtn">
				新增
			</div>
		</a>
		<div class="clearfix"></div>
		
		
		
	</div>

