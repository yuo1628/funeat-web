<?php defined('BASEPATH') or die('No direct script access allowed');

// Import class
use models\entity\restaurant\Restaurants as Restaurants;
use models\entity\image\Images as Images;

// Load library
$this->load->helper('url');

/**
 * @var models\entity\restaurant\Restaurants[]
 */
$restaurants;

/**
 * @var models\entity\restaurant\Restaurants
 */
$rest;
?>
<div class="resListBox">
	<div class="myLocationBox">
		<div class="myLocationItem">
			我的位置
		</div>
		<div class="myLocationItem">
			<input type="text" />
		</div>
		<div class="myLocationItem">
			<input type="button" value="確定" />
		</div>
	</div>
	<div class="resListMenu">
		<?php foreach ($restaurants as $k => $rest):
		?>
		<div class="resListItem">
			<div class="resListTitle">
				<?php echo $rest->getName(); ?>
			</div>
			<div class="resListImg">
				<img src="<?php echo Images::UPLOAD_PATH, $rest->getLogo()->getFilename(); ?>" />
			</div>
			<div class="resListDesc">
				<?php echo $rest->getIntro(); ?>
			</div>
			<div class="resListInfo">
				<div class="resListInfoPriceBox">
					<?php echo "\$. {$rest->getPriceLow()} ~ {$rest->getPriceHigh()}"; ?>
				</div>
				<div class="arrowRight priceArrowRight"></div>
				<div class="resListInfoItem">
					<div class="resListInfoIcon">
						<img src="img/icon/res_view.png" title="瀏覽次數" />
					</div>
					<div class="resListInfoCount">
						1000
					</div>
					<div class="clearfix" ></div>
				</div>
				<div class="resListInfoItem">
					<div class="resListInfoIcon">
						<img src="img/icon/res_like.png" title="喜歡" />
					</div>
					<div class="resListInfoCount">
						<?php echo $rest->getLike()->count(); ?>
					</div>
					<div class="clearfix" ></div>
				</div>
				<div class="resListInfoItem">
					<div class="resListInfoIcon">
						<img src="img/icon/res_bomb.png" title="不喜歡" />
					</div>
					<div class="resListInfoCount">
						<?php echo $rest->getDislike()->count(); ?>
					</div>
					<div class="clearfix" ></div>
				</div>
				<div class="resListInfoItem">
					<div class="resListInfoIcon">
						<img src="img/icon/res_fav.png" title="收藏次數" />
					</div>
					<div class="resListInfoCount">
						5
					</div>
					<div class="clearfix" ></div>
				</div>
			</div>
			<div class="resListBar">
				<div class="resListBarItem">
					<img  src="img/icon/like.png" />
					<div class="resListBarItemDesc">
						喜歡
					</div>
					<div class="clearfix" ></div>
				</div>
				<div class="resListBarItemVerLine"></div>
				<div class="resListBarItem">
					<img  src="img/icon/more.png" />
					<div class="resListBarItemDesc">
						詳細
					</div>
					<div class="clearfix" ></div>
				</div>
				<div class="clearfix" ></div>
			</div>
		</div>
		<?php endforeach; ?>
		<div class="clearfix" ></div>
	</div>
</div>
