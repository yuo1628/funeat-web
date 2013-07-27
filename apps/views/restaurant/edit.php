<?php
// Import class
use models\entity\Entity as Entity;

// Load library
$this->load->helper('url');

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

// Form action
$target = ($restaurant->getId() === null) ? 'restaurant/save' : 'restaurant/save/' . $restaurant->uuid;

// Preset data
$name = Entity::preset(set_value('name'), $restaurant->getName());
$address = Entity::preset(set_value('address'), $restaurant->getAddress());
$website = Entity::preset(set_value('website'), $restaurant->getWebsite());
?>
<?php echo form_open_multipart($target); ?>
<div class="resEditBox">
	<div class="resEditTitle">
		店家資訊
	</div>
	<div class="resEditMenu">
		<div class="resEditItem">
			<div class="resEditContainer">
				<div class="resEditLabel">
					*店名
				</div>
				<div class="resEditInput">
					<input type="text" name="name" value="<?php echo $name; ?>" required />
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="resEditHelp">
				請輸入店名，如有分店建議輸入 EX：FunEat 台中分店
			</div>
			<div class="clearfix"></div>
		</div>
		<div class="resEditItem">
			<div class="resEditContainer">
				<div class="resEditLabel">
					*地址
				</div>
				<div class="resEditInput">
					<input type="text" name="address" value="<?php echo $address; ?>" required />
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="resEditHelp">
				地址越詳越好 EX：台中市北屯區大連路三段10號
			</div>
			<div class="clearfix"></div>
			<div class="resEditMap">
				<div class="resMapTopShadow"></div>
				<div class="resMapBottomShadow"></div>
				<iframe width="100%" height="100%" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?f=q&amp;source=s_q&amp;hl=zh-TW&amp;geocode=&amp;q=%E5%8F%B0%E4%B8%AD%E5%B8%82%E5%8C%97%E5%B1%AF%E5%8D%80+%E5%A4%A7%E9%80%A3%E8%B7%AF%E4%B8%89%E6%AE%B5%E5%8D%81%E8%99%9F&amp;aq=&amp;sll=37.0625,-95.677068&amp;sspn=55.849851,135.263672&amp;ie=UTF8&amp;hq=%E5%A4%A7%E9%80%A3%E8%B7%AF%E4%B8%89%E6%AE%B5%E5%8D%81%E8%99%9F&amp;hnear=%E5%8F%B0%E7%81%A3%E5%8F%B0%E4%B8%AD%E5%B8%82%E5%8C%97%E5%B1%AF%E5%8D%80&amp;ll=24.178009,120.718443&amp;spn=0.006454,0.067311&amp;t=m&amp;output=embed"></iframe>
			</div>
		</div>
		<div class="resEditItem">
			<div class="resEditContainer">
				<div class="resEditLabel">
					*電話
				</div>
				<div class="resEditInput">
					<input type="text" name="tel" value="<?php echo set_value('tel'); ?>" />
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="resEditHelp">
				請輸入帶區碼電話 EX：<span style="color:#f00">02</span>11113333
			</div>
			<div class="clearfix"></div>
		</div>
		<div class="resEditItem">
			<div class="resEditContainer">
				<div class="resEditLabel">
					傳真
				</div>
				<div class="resEditInput">
					<input type="text" />
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="resEditHelp">
				請輸入帶區碼號碼 EX：<span style="color:#f00">02</span>11113333
			</div>
			<div class="clearfix"></div>
		</div>
		<div class="resEditItem">
			<div class="resEditContainer">
				<div class="resEditLabel">
					網站
				</div>
				<div class="resEditInput">
					<input type="text" name="website" value="<?php echo $website; ?>" />
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="resEditHelp">
				請輸入網址
			</div>
			<div class="clearfix"></div>
		</div>
	</div>
	<div class="resEditItem">
		<div class="resEditContainer">
			<div class="resEditLabel">
				*價格區間
			</div>
			<div class="resEditInput">
				<input class="textItem" style="width:275px" type="text" />
				~
				<input class="textItem" style="width:275px" type="text" />
				元
			</div>
			<div class="clearfix"></div>
		</div>
		<div class="resEditHelp">
			請輸入價格區間，可直接輸入 最低 與 最高 的價格 EX：10~60
		</div>
		<div class="clearfix"></div>
	</div>
	<div class="resEditItem">
		<div class="resEditContainer">
			<div class="resEditLabel">
				營業時間
			</div>
			<div class="resEditInput">
				<div class="resEditDateItem">
					<div class="dateBox">
						<div class="dateTitle">
							星期一
						</div>
						<div class="dateOtherBar">
							<div class="dateSetAllBtn">
								套用至全部設定
							</div>
						</div>
						<div class="dateTime">
							<div class="dateTimeItem">
								<div class="dateTimeTag">
									<label>
										<input type="checkbox" />
										公休</label>
								</div>
								<div class="clearfix"></div>
							</div>
							<div class="dateTimeItem">
								<div class="dateTimeTag">
									<label>
										<input type="checkbox" />
										全天</label>
								</div>
								<div class="dateTimeStep">
									<div class="resEditInput">
										<input class="" style="width:100px" type="text" />
										~
										<input class="" style="width:100px" type="text" />
									</div>
								</div>
								<div class="clearfix"></div>
							</div>
							<div class="dateTimeItem">
								<div class="dateTimeTag">
									<label>
										<input type="checkbox" />
										早餐</label>
								</div>
								<div class="dateTimeStep">
									<div class="resEditInput">
										<input class="" style="width:100px" type="text" />
										~
										<input class="" style="width:100px" type="text" />
									</div>
								</div>
								<div class="clearfix"></div>
							</div>
							<div class="dateTimeItem">
								<div class="dateTimeTag">
									<label>
										<input type="checkbox" />
										午餐</label>
								</div>
								<div class="dateTimeStep">
									<div class="resEditInput">
										<input class="" style="width:100px" type="text" />
										~
										<input class="" style="width:100px" type="text" />
									</div>
								</div>
								<div class="clearfix"></div>
							</div>
							<div class="dateTimeItem">
								<div class="dateTimeTag">
									<label>
										<input type="checkbox" />
										下午茶</label>
								</div>
								<div class="dateTimeStep">
									<div class="resEditInput">
										<input class="" style="width:100px" type="text" />
										~
										<input class="" style="width:100px" type="text" />
									</div>
								</div>
								<div class="clearfix"></div>
							</div>
							<div class="dateTimeItem">
								<div class="dateTimeTag">
									<label>
										<input type="checkbox" />
										晚餐</label>
								</div>
								<div class="dateTimeStep">
									<div class="resEditInput">
										<input class="" style="width:100px" type="text" />
										~
										<input class="" style="width:100px" type="text" />
									</div>
								</div>
								<div class="clearfix"></div>
							</div>
							<div class="dateTimeItem">
								<div class="dateTimeTag">
									<label>
										<input type="checkbox" />
										宵夜</label>
								</div>
								<div class="dateTimeStep">
									<div class="resEditInput">
										<input class="" style="width:100px" type="text" />
										~
										<input class="" style="width:100px" type="text" />
									</div>
								</div>
								<div class="clearfix"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="clearfix"></div>
		</div>
		<div class="resEditHelp">
			請對該店有營業的時間勾選該時段，並且在時段裡輸入該時段營業時間 EX:
			<div class="dateTimeItem">
				<div class="dateTimeTag">
					<label>
						<input type="checkbox" checked="checked" disabled="disabled" />
						早餐</label>
				</div>
				<div class="dateTimeStep">
					<div class="resEditInput">
						<input class="" style="width:100px;background-color:transparent" value="0700" type="text" disabled="disabled"/>
						~
						<input class="" style="width:100px;background-color:transparent" value="1200" type="text" disabled="disabled"/>
					</div>
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
		<div class="clearfix"></div>
	</div>
	<div class="resEditItem">
		<div class="resEditContainer">
			<div class="resEditLabel">
				特色
			</div>
			<div class="resEditInput">
				<?php foreach ($features as $v):
				?>
				<input type="checkbox" name="features[]" value="<?php echo $v->getId(); ?>" />
				<?php echo $v->getTitle(); ?><
				br/>
				<?php endforeach; ?>
				<div class="resServiceItem">
					<img src="img/icon/wifi.png" title="wifi 無線網路" />
				</div>
				<div class="resServiceItem">
					<img src="img/icon/ac.png" title="冷氣" />
				</div>
				<div class="resServiceItem">
					<img src="img/icon/accessible.png" title="無障礙空間" />
				</div>
				<div class="resServiceItem">
					<img src="img/icon/payment.png" title="信用卡付款" />
				</div>
				<div class="resServiceItem">
					<img src="img/icon/parking.png" title="停車場" />
				</div>
				<div class="resServiceItem">
					<img src="img/icon/delivery.png" title="外送" />
				</div>
				<div class="clearfix"></div>
			</div>
			<div class="clearfix"></div>
		</div>
		<div class="resEditHelp">
			請對有提供的服務打勾
		</div>
		<div class="clearfix"></div>
	</div>
	<div class="resEditItem">
		<div class="resEditContainer">
			<div class="resEditLabel">
				店家大頭照
			</div>
			<div class="resEditInput">
				<input type="file" />
			</div>
			<div class="clearfix"></div>
		</div>
		<div class="resEditHelp">
			最佳大小為：150 X 150 像素
			<br>
			超過會以高度 150px 為主，並且將圖片水平置中
		</div>
		<div class="clearfix"></div>
	</div>
	<div class="resEditItem">
		<div class="resEditContainer">
			<div class="resEditLabel">
				圖片展示
			</div>
			<div class="resEditInput">
				<div class="resEditGalleryInputItem">
					<input type="file" />
				</div>
				<div class="resEditGalleryInputItem">
					<input type="file" />
				</div>
				<div class="resEditGalleryInputItem">
					<input type="file" />
				</div>
				<div class="resEditGalleryInputItem">
					<input type="file" />
				</div>
			</div>
			<div class="clearfix"></div>
		</div>
		<div class="resEditHelp">
			最佳大小為：850 X 400像素
			<br>
			超過會以高度 400px 為主，並且將圖片水平置中
		</div>
		<div class="clearfix"></div>
	</div>
	<div class="resEditItem">
		<div class="resEditContainer">
			<div class="resEditLabel">
				菜單照片
			</div>
			<div class="resEditInput">
				<input type="file" />
			</div>
			<div class="clearfix"></div>
		</div>
		<div class="resEditHelp">
			<span style="color:#f00;font-size: 21px;" >上傳菜單會獲得更多的積分點數</span>
			<br>
			<br>
			最佳寬度為：800 像素
			<br>
			超過會以寬度  150px 為主
		</div>
		<div class="clearfix"></div>
	</div>
	<div class="previewBtn">
		預覽
	</div>
	<div class="postBtn">
		發佈
	</div>
	<div class="clearfix"></div>
	<br>
	<br>
</div>
<?php echo form_close(); ?>