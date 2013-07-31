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
 * 店家資料
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
							if($i == 0)
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
		<div class="arrowLeft galleryArrowLeft" ></div>
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
							if($restaurant->getLike()->contains($member)){
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
			<iframe width="100%" height="100%" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?f=q&amp;source=s_q&amp;hl=zh-TW&amp;geocode=&amp;q=%E5%8F%B0%E4%B8%AD%E5%B8%82%E5%8C%97%E5%B1%AF%E5%8D%80+%E5%A4%A7%E9%80%A3%E8%B7%AF%E4%B8%89%E6%AE%B5%E5%8D%81%E8%99%9F&amp;aq=&amp;sll=37.0625,-95.677068&amp;sspn=55.849851,135.263672&amp;ie=UTF8&amp;hq=%E5%A4%A7%E9%80%A3%E8%B7%AF%E4%B8%89%E6%AE%B5%E5%8D%81%E8%99%9F&amp;hnear=%E5%8F%B0%E7%81%A3%E5%8F%B0%E4%B8%AD%E5%B8%82%E5%8C%97%E5%B1%AF%E5%8D%80&amp;ll=24.178009,120.718443&amp;spn=0.006454,0.067311&amp;t=m&amp;output=embed"></iframe>
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
			<?php foreach ($restaurant->getMenu() as $menu):
			?>
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
					/**
					 * 店家資料
					 *
					 * @var  models\entity\restaurant\Comments
					 */
					$item;
					
				?>
				<?php 
					foreach ($restaurant->getComments() as $i => $item): 
						
						
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
					/**
					 * 店家資料
					 *
					 * @var  models\entity\restaurant\Comments
					 */
					$reply_item;
					foreach($item->getReplies() as $reply_item): 
					//$reply_item->
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
