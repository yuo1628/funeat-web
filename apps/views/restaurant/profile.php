<?php defined('BASEPATH') or die('No direct script access allowed');

// Import class
use models\entity\image\Images as Images;

// Load library
$this->load->helper('url');

/**
 * 店家資料
 *
 * @var models\entity\restaurant\Restaurants
 */
$restaurant;

/**
 * 登入使用者資料
 *
 * @var models\entity\member\members
 */
$member;
?>
<!-- @formatter:off -->
<input id="restaurant_uuid" type="hidden" value="<?php echo $restaurant->getUuid() ?>" />

<div class="resBox">
	<div class="resContent">
		<!-- logo -->
		<div class="resImg">
			<?php if (is_null($restaurant->getLogo())): ?>
				<img src="" />
			<?php else: ?>
				<img src="<?php echo Images::UPLOAD_PATH, $restaurant->getLogo()->getFilename(); ?>" />
			<?php endif; ?>
		</div>
		<!-- title -->
		<div class="resTitle">
			<?php echo $restaurant->getName(); ?>
		</div>
		<div class="arrowLeft localTitleArrowLeft"></div>
		<div class="arrowRight localTitleArrowRight"></div>
		<div style="padding-top: 220px;"></div>
		<!-- gallery -->
		<div class="resGalleryBox">
			<div class="galleryLeftBtn">

			</div>
			<div class="galleryRightBtn">

			</div>
			<div class="galleryBox">
				<div class="gallery">

					<div class="galleryMenu">
						<?php foreach ($restaurant->getGallery() as $gallery):
						?>
						<div class="galleryItem">
							<img src="<?php echo Images::UPLOAD_PATH, $gallery->getFilename(); ?>" />
						</div>
						<?php endforeach; ?>
					</div>
					<div class="clearfix"></div>
				</div>
			</div>
			<div class="galleryPreviewBox">
				<div class="galleryPreviewLeftBtn">

				</div>
				<div class="galleryPreviewRightBtn">

				</div>
				<div class="galleryPreviewMenuBox">
					<div class="galleryPreviewMenu">
						<?php
							foreach ($restaurant->getGallery() as $i => $gallery):
								$class = '';
								if ($i == 0)
								{
									$class = 'thisPreview';
								}
						?>

						<div class="galleryPreviewItem <?php echo $class ?>">
							<img src="<?php echo Images::UPLOAD_PATH, $gallery->getFilename(); ?>" />
						</div>
						<?php endforeach; ?>
					</div>

					<div class="clearfix"></div>
				</div>

			</div>

		</div>
		<div class="arrowLeft galleryArrowLeft"></div>
		<div class="arrowRight galleryArrowRight"></div>
		<div style="padding-top: 500px;"></div>
		<!-- info -->
		<div class="resDescBox">
			<div class="resInfoBox">
				<div class="resInfoMenu">
					<div class="resInfoItem">
						<img src="img/icon/res_address.png" />
						<div class="resInfoItemDesc">
							<?php echo $restaurant->getAddress(); ?>
						</div>
						<div class="clearfix"></div>
					</div>
					<div class="resInfoItem">
						<img src="img/icon/res_phone.png" />
						<div class="resInfoItemDesc">
							<?php echo $restaurant->getTel(); ?>
						</div>
						<div class="clearfix"></div>
					</div>
					<div class="resInfoItem">
						<img src="img/icon/res_time.png" />
						<div class="resInfoItemDesc">
							<!-- TODO: Hours design -->
							0900 - 1800
						</div>
						<div class="clearfix"></div>
					</div>
					<div class="resInfoItem">
						<img src="img/icon/res_time.png" />
						<div class="resInfoItemDesc">
							<?php echo "NT. {$restaurant->getPriceLow()} ~ NT. {$restaurant->getPriceHigh()}"; ?>
						</div>
						<div class="clearfix"></div>
					</div>
					<br>
					<br>
					<div class="resInfoItem">
						<?php
							$like_class = 'resLikeBtn';
							$path = 'like.png';
							if ($restaurant->getLike()->contains($member))
							{
								$like_class = 'hasLike';
								$path = 'has_like.png';
							}
						?>
						<div class="resLikeBtnBox" >
							<div class="<?php echo $like_class ?>">
								<img src="img/icon/<?php echo $path ?>" />
							</div>
						</div>
						<div class="resLikeCount">
							<?php echo $restaurant->getLike()->count(); ?>
						</div>
						<div class="clearfix"></div>
					</div>
				</div>
			</div>
			<div class="resServiceBox">
				123
			</div>
			<div class="clearfix"></div>
		</div>
		<div class="arrowRight descArrowRight"></div>
		<!-- map -->
		<div class="resMapBox">
			<div class="resMapTopShadow"></div>
			<div class="resMapBottomShadow"></div>
			<div id="mapBox" class="mapBox"></div>
			<script type="text/javascript">
				$(document).ready(function()
				{
					if (localStorage.localLatitude == undefined || localStorage.localLongitude == undefined)
					{
						localPosition = new google.maps.LatLng(24.175097051954552, 120.69067758941651);
					}
					else
					{
						localPosition = new google.maps.LatLng(localStorage.localLatitude, localStorage.localLongitude);
					}
					markerPosition = new google.maps.LatLng(<?php echo $restaurant->getLatitude(); ?>, <?php echo $restaurant->getLongitude(); ?>);
					map = new GMaps(
					{
						div : '#mapBox',
						lat : markerPosition.lat(),
						lng : markerPosition.lng(),
						mapTypeId : google.maps.MapTypeId.ROADMAP,
						scaleControl : false,
						mapTypeControl : false,
						mapTypeControlOptions :
						{
							style : google.maps.MapTypeControlStyle.DROPDOWN_MENU
						}
					});

					map.addMarker(
					{
						lat : markerPosition.lat(),
						lng : markerPosition.lng(),
						animation : google.maps.Animation.BOUNCE,
						infoWindow :
						{
							content : $("#markerTemplate").text()
						}
					});

					GMaps.geolocate(
					{
						success : function(position)
						{
							localPosition = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
							map.addMarker(
							{
								lat : localPosition.lat(),
								lng : localPosition.lng(),
								draggable : true,
								animation : google.maps.Animation.DROP,
								infoWindow :
								{
									content : $("#localTemplate").text(),
									pixelOffset : new google.maps.Size(0, 0)
								},
								dragend : function()
								{
									var pos = this.getPosition();
									GMaps.geocode(
									{
										lat : pos.lat(),
										lng : pos.lng(),
										callback : function(results, status)
										{
											if (results && results.length > 0)
											{
												alert(results[0].formatted_address);
											}
										}
									});
								}
							});
						},
						error : function(error)
						{
							alert('Geolocation failed: ' + error.message);
						},
						not_supported : function()
						{
							alert("Your browser does not support geolocation");
						},
						always : function()
						{
							//alert("Done!");
						}
					});


				});
			</script>
			<script type="text/html" id="localTemplate">

			</script>
			<script type="text/html" id="markerTemplate">
				<a href="javascript:void(0)" onclick="Listener.Map.onRoute(map, localPosition, markerPosition);">路線</a>
			</script>
		</div>
		<div class="otherStoreBox">
			<div class="otherStoreBtn">
				顯示其他分店
			</div>
			<div class="clearfix"></div>
		</div>
		<!-- menu -->
		<div class="resFoodMenuBox">
			<div class="resFoodMenuTitle">
				Menu
			</div>
			<?php foreach ($restaurant->getMenu() as $menu): ?>
				<div class="resFoodMenuImg">
					<img src="<?php echo Images::UPLOAD_PATH, $menu->getFilename(); ?>" />
				</div>
			<?php endforeach; ?>
		</div>


		<div class="resDiscussBox">
			<div class="resDiscussTitle">
				留言討論
			</div>

			<form method="post" action="index.php/restaurant/comment/<?php echo $restaurant->getUuid() ?>">
				<input type="hidden" value="<?php echo $restaurant->getUuid() ?>" name="identity" />
				<div class="discussMainPostBox">
					<input class="reply_to_uuid" type="hidden" value="" />
					<div class="discussReply">
						<div class="replyTagToLabel">
							留給：
						</div>
						<div class="replyTagMenu">
							<div class="replyTagItem">
								所有人
							</div>
						</div>

						<div class="clearfix"></div>
					</div>
					<div class="discussContent">
						<div class="contentLabel">
							留言
						</div>
						<div class="contentText">
							<textarea class="mainPostText" name="comment"></textarea>
						</div>

						<div class="clearfix"></div>
					</div>

					<div class="clearfix"></div>

					<input class="mainPostBtn" type="submit" value="留言" />
					<div class="clearfix"></div>
				</div>
			</form>
			<div class="clearfix"></div>


			<div class="resDiscussMenu">
				<?php
					foreach ($restaurant->getComments() as $i => $item):
					/**
					 * 店家評論
					 *
					 * @var models\entity\restaurant\Comments
					 */
					$item;
				?>

				<div class="resDiscussItem">
					<input class="user_uuid" type="hidden" value="<?php echo $item->getUuid() ?>" />
					<input class="user_name" type="hidden" value="<?php echo $item->getCreator() ?>" />
					<div class="resDiscussImg">
						<img src="" />
					</div>
					<div class="msgArrow"></div>
					<div class="resDiscussMsgBox">
						<div class="resDiscussMsgName">
							<?php echo $item->getCreator() ?>
						</div>
						<div class="resDiscussMsgDesc">
							<?php echo $item->getComment() ?>
						</div>
						<div class="resDiscussMsgBar">
							<div class="resDiscussMsgBarItem">
								<?php if($item->getLike()->contains($member)): ?>
								<div class="left likeBtn postHasLike" onclick="mainPostLike(this);">
									取消讚
								</div>
								<?php else: ?>
								<div class="left likeBtn " onclick="mainPostLike(this);">
									讚
								</div>
								<?php endif; ?>
								<div class="left postLikeCount">
								<?php echo $item->getLike()->count(); ?>
								</div>
								<div class="replyBtn">
									回覆
								</div>
								<div class="clearfix"></div>
							</div>
						</div>
						<div class="clearfix"></div>
					</div>
					<div class="clearfix"></div>
				</div>

				<div class="replyBox">
					<?php
						$reply_item;
						foreach($item->getReplies() as $reply_item):
						/**
						 * 評論回覆
						 *
						 * @var  models\entity\restaurant\Comments
						 */
						$reply_item;
					?>
					<div class="resDiscussItem replyDiscussItem">
						<input class="user_uuid" type="hidden" value="<?php echo $reply_item->getUuid() ?>" />
						<div class="resDiscussImg replyDiscussImg">
							<img src="" />
						</div>
						<div class="msgArrow replyArrow"></div>
						<div class="resDiscussMsgBox replyDiscussMsgBox">
							<div class="resDiscussMsgName">
								<?php echo $reply_item->getCreator() ?>
							</div>
							<div class="resDiscussMsgDesc">
								<?php echo $reply_item->getComment() ?>
							</div>
							<div class="resDiscussMsgBar">
								<div class="resDiscussMsgBarItem">
									<?php if($reply_item->getLike()->contains($member)): ?>
									<div class="left likeBtn postHasLike" onclick="mainReplyLike(this);">
										取消讚
									</div>
									<?php else: ?>
									<div class="left likeBtn " onclick="mainReplyLike(this);">
										讚
									</div>
									<?php endif; ?>
									<div class="left postLikeCount">
									<?php echo $reply_item->getLike()->count(); ?>
									</div>
									<div class="replyBtn">
										回覆
									</div>
									<div class="clearfix"></div>
								</div>
							</div>
							<div class="clearfix"></div>
						</div>
						<div class="clearfix"></div>
					</div>
					<?php endforeach; ?>
				</div>
				<?php endforeach; ?>
			</div>
		</div>
		<div style="height: 20px;"></div>
	</div>
</div>
