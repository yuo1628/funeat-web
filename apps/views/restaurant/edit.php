<?php defined('BASEPATH') or die('No direct script access allowed');

// Import class
use models\entity\Entity as Entity;
use models\restaurant\Hours;

// Load library
$this->load->helper('url');

// Form action
$target = ($restaurant->getId() === null) ? 'restaurant/save' : 'restaurant/save/' . $restaurant->uuid;

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

// Preset data
$name = Entity::preset(set_value('name'), $restaurant->getName());
$address = Entity::preset(set_value('address'), $restaurant->getAddress());
$website = Entity::preset(set_value('website'), $restaurant->getWebsite());
$tel = Entity::preset(set_value('tel'), $restaurant->getTel());
$intro = Entity::preset(set_value('intro'), $restaurant->getIntro());
$fax = Entity::preset(set_value('fax'), $restaurant->getFax());
$priceLow = Entity::preset(set_value('fax'), $restaurant->getPriceLow());
$priceHigh = Entity::preset(set_value('fax'), $restaurant->getPriceHigh());
$hour24 = Hours::getDayTime();
?>
<!-- @formatter:off -->
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
					<input id="address" type="text" name="address" value="<?php echo $address; ?>" required />
					<input type="hidden" name="latitude" />
					<input type="hidden" name="longitude" />
					<script>
						jQuery('#address').change(function(e)
						{
							GMaps.geocode(
							{
								address : $('#address').val().trim(),
								callback : function(results, status)
								{
									if (status == 'OK')
									{
										var latlng = results[0].geometry.location;
										map.removeMarkers()
										map.setCenter(latlng.lat(), latlng.lng());
										map.addMarker(
										{
											lat : latlng.lat(),
											lng : latlng.lng(),
											draggable : true,
											dragend : function()
											{
												var pos = this.getPosition();
												localStorage.localLatitude = pos.lat();
												localStorage.localLongitude = pos.lng();
												GMaps.geocode(
												{
													lat : pos.lat(),
													lng : pos.lng(),
													callback : function(results, status)
													{
														if (results && results.length > 0)
														{
															jQuery("input[name=address]").val(results[0].formatted_address);
															jQuery("input[name=latitude]").val(pos.lat());
															jQuery("input[name=longitude]").val(pos.lng());
														}
													}
												});
											}
										});
										jQuery("input[name=latitude]").val(latlng.lat());
										jQuery("input[name=longitude]").val(latlng.lng());
									}
								}
							});
						});
					</script>
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
				<div id="mapBox" class="mapBox"></div>
				<script type="text/javascript">
					$(document).ready(function()
					{
						map = new GMaps(
						{
							div : '#mapBox',
							lat : Funeat.Storage.localLat,
							lng : Funeat.Storage.localLng,
							mapTypeId : google.maps.MapTypeId.ROADMAP,
							scaleControl : false,
							mapTypeControl : false,
							mapTypeControlOptions :
							{
								style : google.maps.MapTypeControlStyle.DROPDOWN_MENU
							}
						});

					});
			</script>
			</div>
		</div>
		<div class="resEditItem">
			<div class="resEditContainer">
				<div class="resEditLabel">
					*電話
				</div>
				<div class="resEditInput">
					<input type="text" name="tel" value="<?php echo $tel; ?>" />
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
					*價格區間
				</div>
				<div class="resEditInput">
					<input class="textItem" style="width:275px" type="text" name="priceLow" value="<?php echo $priceLow; ?>" />
					~
					<input class="textItem" style="width:275px" type="text" name="priceHigh" value="<?php echo $priceHigh; ?>" />
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
					介紹
				</div>
				<div class="resEditInput">
					<textarea class="intro" name="intro"><?php echo $intro ?></textarea>
					
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
					傳真
				</div>
				<div class="resEditInput">
					<input type="text" name="fax" value="<?php echo $fax; ?>" />
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
			<input type="hidden" class="allOrMulti" value="0" />
			
			<div class="resEditLabel">
				營業時間
			</div>
			<?php 
				$week = array("一", "二", "三", "四", "五", "六", "日");
				
				foreach($week as $w => $w_item): 
					$style = 'display:none';
					if($w == 0)
					{
						$style = 'display:block';
					}
			?>
			<div class="resEditInput resPriodItem" style="<?php echo $style ?>">
				
				<input type="hidden" class="boo" value="1" />
				
				<div class="resEditDateItem">
					<div class="dateBox">
						<div class="dateTitle">
							<?php if($w != 0): ?>
								星期<?php echo $w_item; ?>
							<?php else: ?>
								全天
							<?php endif; ?>
							
						</div>
						<div class="dateOtherBar">
							
							<?php if($w == 0): ?>
							<div class="dateSetAllBtn">
								套用至全部設定
							</div>
							<div class="addNewPeriodBtn">
								個別設定時段
							</div>
							<div class="detailSetWeekBtn">
								<input type="hidden" value="0" />
								<span>詳細設定日期</span>
							</div>
							<?php else: ?>
							<div class="addNewPeriodBtn">
								個別設定時段
							</div>
							
							<?php endif; ?>
							
							
						</div>
						<div class="dateTime">
							
							<div class="dateTimeItem vacationChecItem">
								<div class="dateTimeTag">
									<label>
										<input type="checkbox" class="vacationCheckBox" value="公休"/>
										公休</label>
								</div>
								<div class="clearfix"></div>
							</div>
							
							<div class="dateTimeItem ">
								
								<?php 
								foreach($features as $i => $item) :
									if($item->getHoursMapping() > 0) :
										
								?>
								<div class="resServiceItem proidTagItem">
									
									<input type="hidden" value="<?php echo $item->getHoursMapping() ?>" />
									<input class="proidCheckBox" id="<?php echo $w . $item->getId(); ?>" type="checkbox" name="features[]" value="<?php echo $item->getId(); ?>" />
									<label for="<?php echo $w . $item->getId(); ?>" class="checkboxLabel" title="<?php echo $item->getTitle(); ?>" >
										<img class="left" src="data:image/jpeg;base64,<?php echo $item->getIcon(); ?>" />
										<div class="left" style="padding: 5px;"><?php echo $item->getTitle(); ?></div>
									</label>
									
								</div>
								
									<?php endif; ?>
								<?php endforeach; ?>
								
								<div class="clearfix"></div>
							</div>
							
							<div class="dateTimeItem priodTimeItem" style="display:block">
								<input class="daliyValue" type="hidden" value="0" />
								<div class="dateTimeTag">
									<label>
										
										營業時間
									</label>
								</div>
								<div class="dateTimeStep">
									<div class="left priodInputBox">
										<input class="week" type="hidden" value="<?php echo $w; ?>" />
										
										<select class="start_select" name="hours[<?php echo $w; ?>][0][0]">
											<?php foreach($hour24 as $i => $item): ?>
											<?php 
													$s = '';
													if($i == 10 * 2)  
														$s = 'selected';
												?>
												
											<option value="<?php echo $i ?>" <?php echo $s ?> >
												<?php echo $item ?>
											</option>
											<?php endforeach; ?>
										</select>
										~
										<select class="end_select" name="hours[<?php echo $w; ?>][0][0]">
											<?php foreach($hour24 as $i => $item): ?>
												<?php 
													$s = '';
													if($i == 20 * 2)  
														$s = 'selected';
												?>
												
											<option value="<?php echo $i ?>" <?php echo $s ?> >
												<?php echo $item ?>
											</option>
											<?php endforeach; ?>
										</select>
										<!--
										<input class="" style="width:100px" type="text" />
										~
										<input class="" style="width:100px" type="text" />
										-->
									</div>
								</div>
								<div class="clearfix"></div>
							</div>
							<div class="dateTimeItem daliyItem">
								<input class="daliyValue" type="hidden" value="1" />
								<div class="dateTimeTag">
									<label>
										早餐</label>
								</div>
								<div class="dateTimeStep">
									<div class="left priodInputBox">
										
										<input class="week" type="hidden" value="<?php echo $w; ?>" />
										<input class="priodStartTime" type="hidden" name="hours[][][]" />
										<input class="priodEndtTime" type="hidden" name="hours[][][]" />
										
										<select class="start_select" name="hours[<?php echo $w; ?>][1][0]">
											<?php foreach($hour24 as $i => $item): ?>
											<?php 
													$s = '';
													if($i == 05 * 2)  
														$s = 'selected';
												?>
												
											<option value="<?php echo $i ?>" <?php echo $s ?> >
												<?php echo $item ?>
											</option>
											<?php endforeach; ?>
										</select>
										~
										<select class="end_select" name="hours[<?php echo $w; ?>][1][1]">
											<?php foreach($hour24 as $i => $item): ?>
												<?php 
													$s = '';
													if($i == 13 * 2)  
														$s = 'selected';
												?>
												
											<option value="<?php echo $i ?>" <?php echo $s ?> >
												<?php echo $item ?>
											</option>
											<?php endforeach; ?>
										</select>
									</div>
								</div>
								<div class="clearfix"></div>
							</div>
							<div class="dateTimeItem daliyItem">
								<input class="daliyValue" type="hidden" value="3" />
								<div class="dateTimeTag">
									<label>
										午餐</label>
								</div>
								<div class="dateTimeStep">
									<div class="left priodInputBox">
										<input class="week" type="hidden" value="<?php echo $w; ?>" />
										<input class="priodStartTime" type="hidden" name="hours[][][]" />
										<input class="priodEndtTime" type="hidden" name="hours[][][]" />
										
										<select class="start_select" name="hours[<?php echo $w; ?>][3][0]">
											<?php foreach($hour24 as $i => $item): ?>
											<?php 
													$s = '';
													if($i == 11 * 2)  
														$s = 'selected';
												?>
												
											<option value="<?php echo $i ?>" <?php echo $s ?> >
												<?php echo $item ?>
											</option>
											<?php endforeach; ?>
										</select>
										~
										<select class="end_select" name="hours[<?php echo $w; ?>][3][1]">
											<?php foreach($hour24 as $i => $item): ?>
												<?php 
													$s = '';
													if($i == 14 * 2)  
														$s = 'selected';
												?>
												
											<option value="<?php echo $i ?>" <?php echo $s ?> >
												<?php echo $item ?>
											</option>
											<?php endforeach; ?>
										</select>
									</div>
								</div>
								<div class="clearfix"></div>
							</div>
							<div class="dateTimeItem daliyItem">
								<input class="daliyValue" type="hidden" value="4" />
								<div class="dateTimeTag">
									<label>
										下午茶</label>
								</div>
								<div class="dateTimeStep">
									<div class="left priodInputBox">
										<input class="week" type="hidden" value="<?php echo $w; ?>" />
										<input class="priodStartTime" type="hidden" name="hours[][][]" />
										<input class="priodEndtTime" type="hidden" name="hours[][][]" />
										
										<select class="start_select" name="hours[<?php echo $w; ?>][4][0]">
											<?php foreach($hour24 as $i => $item): ?>
											<?php 
													$s = '';
													if($i == 14 * 2)  
														$s = 'selected';
												?>
												
											<option value="<?php echo $i ?>" <?php echo $s ?> >
												<?php echo $item ?>
											</option>
											<?php endforeach; ?>
										</select>
										~
										<select class="end_select" name="hours[<?php echo $w; ?>][4][1]">
											<?php foreach($hour24 as $i => $item): ?>
												<?php 
													$s = '';
													if($i == 17 * 2)  
														$s = 'selected';
												?>
												
											<option value="<?php echo $i ?>" <?php echo $s ?> >
												<?php echo $item ?>
											</option>
											<?php endforeach; ?>
										</select>
									</div>
								</div>
								<div class="clearfix"></div>
							</div>
							<div class="dateTimeItem daliyItem">
								<input class="daliyValue" type="hidden" value="5" />
								<div class="dateTimeTag">
									<label>
										晚餐</label>
								</div>
								<div class="dateTimeStep">
									<div class="left priodInputBox">
										<input class="week" type="hidden" value="<?php echo $w; ?>" />
										<input class="priodStartTime" type="hidden" name="hours[][][]" />
										<input class="priodEndtTime" type="hidden" name="hours[][][]" />
										
										<select class="start_select" name="hours[<?php echo $w; ?>][5][0]">
											<?php foreach($hour24 as $i => $item): ?>
											<?php 
													$s = '';
													if($i == 17 * 2)  
														$s = 'selected';
												?>
												
											<option value="<?php echo $i ?>" <?php echo $s ?> >
												<?php echo $item ?>
											</option>
											<?php endforeach; ?>
										</select>
										~
										<select class="end_select" name="hours[<?php echo $w; ?>][5][1]">
											<?php foreach($hour24 as $i => $item): ?>
												<?php 
													$s = '';
													if($i == 22 * 2)  
														$s = 'selected';
												?>
												
											<option value="<?php echo $i ?>" <?php echo $s ?> >
												<?php echo $item ?>
											</option>
											<?php endforeach; ?>
										</select>
									</div>
								</div>
								<div class="clearfix"></div>
							</div>
							<div class="dateTimeItem daliyItem">
								<input class="daliyValue" type="hidden" value="6" />
								<div class="dateTimeTag">
									<label>
										宵夜</label>
								</div>
								<div class="dateTimeStep">
									<div class="left priodInputBox">
										<input class="week" type="hidden" value="<?php echo $w; ?>" />
										<input class="priodStartTime" type="hidden" name="hours[][][]" />
										<input class="priodEndtTime" type="hidden" name="hours[][][]" />
										
										<select class="start_select" name="hours[<?php echo $w; ?>][6][0]">
											<?php foreach($hour24 as $i => $item): ?>
											<?php 
													$s = '';
													if($i == 22 * 2)  
														$s = 'selected';
												?>
												
											<option value="<?php echo $i ?>" <?php echo $s ?> >
												<?php echo $item ?>
											</option>
											<?php endforeach; ?>
										</select>
										~
										<select class="end_select" name="hours[<?php echo $w; ?>][6][1]">
											<?php foreach($hour24 as $i => $item): ?>
												<?php 
													$s = '';
													if($i == 02 * 2)  
														$s = 'selected';
												?>
												
											<option value="<?php echo $i ?>" <?php echo $s ?> >
												<?php echo $item ?>
											</option>
											<?php endforeach; ?>
										</select>
									</div>
								</div>
								<div class="clearfix"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php endforeach; ?>
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
						<select name="hours">
							
							<option></option>
						</select>
						
						<!--
						<input class="" style="width:100px;background-color:transparent" value="0700" type="text" disabled="disabled"/>
						
						~
						<input class="" style="width:100px;background-color:transparent" value="1200" type="text" disabled="disabled"/>
						-->
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
				<div class="resServiceBox">
				<?php foreach ($features as $v):
					if($v->getHoursMapping() == 0):
				?>
				<div class="resServiceItem">
					<input id="<?php echo $v->getId(); ?>" type="checkbox" name="features[]" value="<?php echo $v->getId(); ?>" />
					<label for="<?php echo $v->getId(); ?>" class="checkboxLabel" title="<?php echo $v->getTitle(); ?>" >
						<img class="left" src="data:image/jpeg;base64,<?php echo $v->getIcon(); ?>" />
						<div class="left" style="padding: 5px;"><?php echo $v->getTitle(); ?></div>
					</label>
					
				</div>
				<?php endif; ?>
				<?php endforeach; ?>
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
				<input type="file" name="logo" />
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
					<input type="file" name="gallery[]" multiple />
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
				<input type="file" name="menu[]" multiple />
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
	<input class="postBtn" type="submit" value="發佈" />
	<div class="clearfix"></div>
	<br>
	<br>
	
</div>
<?php echo form_close(); ?>