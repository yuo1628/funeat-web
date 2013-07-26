<?php
// Load library
$this->load->helper('url');

/**
 * 店家資料
 *
 * @var models\entity\restaurant\Restaurants
 */
$restaurant;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<base href="<?php echo base_url(); ?>" />
		<meta charset="utf-8">
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<meta name="author" content="eric" />
		<meta property="og:title" content="FunEat" />
		<meta property="og:url" content="http://www.funeat.com/" />
		<meta property="og:site_name" content="FunEat" />
		<meta property="og:image" content="http://www.funeat.com/" />
		<meta property="og:description" content="" />
		<meta property="og:type" content="website" />
		<meta property="fb:admins" content="tuan.zhang.90" />
		<meta property="fb:app_id" content="516696985050303" />
		<title>FunEat</title>
		<link href="css/layout.css" rel="stylesheet" />
		<link href="css/default.css" rel="stylesheet" />
		<link href="css/gallery.css" rel="stylesheet" />
		<link href="css/restaurant.css" rel="stylesheet" />
		<link href='http://fonts.googleapis.com/css?family=ABeeZee' rel='stylesheet' type='text/css'>
		<script src="js/jquery-1.9.1.js" type="text/javascript" ></script>
		<script src="js/jquery.color.js" type="text/javascript" ></script>
		<script src="js/layout.js" type="text/javascript" ></script>
	</head>
	<body >
		<div class="container">
			<div class="topBox">
				<div class="logo">
					<img src="img/layout/logo.png" height="60" />
				</div>
				<div class="searchBox">
					<input class="slideBtn" value="" type="button" />
					<input class="searchText" type="text" />
					<input class="searchBtn" value="" type="button" />
					<input class="randomBtn" value="" type="button" />
				</div>
				<div class="quickBox">
					<div class="quickItem">
						<div class="registerBtn"></div>
					</div>
					<div class="quickItem">
						<div class="loginBtn"></div>
					</div>
				</div>
				<div class="navBox">
					<div class="navMenu">
						<div class="navItem">
							熱門店家
						</div>
						<div class="navItem">
							推薦店家
						</div>
						<div class="navItem">
							新到店家
						</div>
						<div class="clearfix"></div>
					</div>
				</div>
				<div class="searchAdvBox">
					<div class="searchAdvItem">
						<div class="filterItem">
							價格 &nbsp;
							<input type="text" />
							~
							<input type="text" />
							元
						</div>
						<div class="filterItem">
							時段
							<select class="selectStyle">
								<option>無選擇</option>
								<option>早上</option>
								<option>中午</option>
								<option>晚上</option>
							</select>
						</div>
						<div class="clearfix"></div>
					</div>
				</div>
			</div>
			<div class="resBox">
				<div class="resContent">
					<!-- logo -->
					<div class="resImg">
						<img src="http://news.xinhuanet.com/jiaju/2011-10/13/122138270_111n.jpg"  />
					</div>
					<!-- title -->
					<div class="resTitle">
						標題測試
					</div>
					<div class="arrowLeft localTitleArrowLeft"></div>
					<div class="arrowRight localTitleArrowRight"></div>
					<div style="padding-top: 220px;"></div>
					<!-- gallery -->
					<div class="resGalleryBox">
						<div class="gallery">
							<div class="galleryMenu">
								<div class="galleryItem">
									<img src="http://lorempixel.com/850/400/food/" />
								</div>
							</div>
							<div class="clearfix"></div>
						</div>
					</div>
					<div class="arrowLeft galleryArrowLeft" ></div>
					<div class="arrowRight galleryArrowRight"></div>
					<div style="padding-top: 400px;"></div>
					<!-- info -->
					<div class="resDescBox">
						<div class="resInfoBox">
							<div class="resInfoMenu">
								<div class="resInfoItem">
									<img src="img/icon/res_address.png" />
									<div class="resInfoItemDesc">
										台中市大連路三段
									</div>
									<div class="clearfix"></div>
								</div>
								<div class="resInfoItem">
									<img src="img/icon/res_phone.png" />
									<div class="resInfoItemDesc">
										04-36063088
									</div>
									<div class="clearfix"></div>
								</div>
								<div class="resInfoItem">
									<img src="img/icon/res_time.png" />
									<div class="resInfoItemDesc">
										0900 - 1800
									</div>
									<div class="clearfix"></div>
								</div>
								<div class="resInfoItem">
									<img src="img/icon/res_time.png" />
									<div class="resInfoItemDesc">
										NT. 30~180
									</div>
									<div class="clearfix"></div>
								</div>
								<br>
								<br>
								<div class="resInfoItem">
									<div class="resLikeBtnBox">
										<div class="resLikeBtn">
											<img src="img/icon/like.png" />
										</div>
									</div>
									<div class="resLikeCount">
										251
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
						<div class="resFoodMenuImg">
							<img src="http://lorempixel.com/584/1024/food/" />
						</div>
					</div>
					<div class="resDiscussBox">
						<div class="resDiscussTitle">
							留言討論
						</div>
						<div class="resDiscussMenu">
							<div class="resDiscussItem">
								<div class="resDiscussImg">
									<img src="" />
								</div>
								<div class="msgArrow"></div>
								<div class="resDiscussMsgBox">
									<div class="resDiscussMsgName">
										name
									</div>
									<div class="resDiscussMsgDesc">
										descriptiondescriptiondescriptiondescriptiondescriptiondescriptiondescriptiondescriptiondescriptiondescriptiondescr12312321 iptiondescriptiondescriptiondescriptiondescription
									</div>
									<div class="resDiscussMsgBar">
										<div class="resDiscussMsgBarItem">
											<div class="left likeBtn">
												讚
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
							<!-- reply -->
							<div class="resDiscussItem replyDiscussItem">
								<div class="resDiscussImg replyDiscussImg">
									<img src="" />
								</div>
								<div class="msgArrow replyArrow"></div>
								<div class="resDiscussMsgBox replyDiscussMsgBox">
									<div class="resDiscussMsgName">
										name
									</div>
									<div class="resDiscussMsgDesc">
										teareafaksljf
									</div>
									<div class="resDiscussMsgBar">
										<div class="resDiscussMsgBarItem">
											<div class="left likeBtn">
												讚
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
							<div class="resDiscussItem">
								<div class="resDiscussImg">
									<img src="" />
								</div>
								<div class="msgArrow"></div>
								<div class="resDiscussMsgBox">
									<div class="resDiscussMsgName">
										name
									</div>
									<div class="resDiscussMsgDesc">
										description
									</div>
									<div class="resDiscussMsgBar">
										<div class="resDiscussMsgBarItem">
											<div class="left likeBtn">
												讚
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
						</div>
					</div>
					<div style="height: 20px;"></div>
				</div>
			</div>
			<div class="footer">
				2013 Powered by DreamOn.
			</div>
		</div>
	</body>
</html>
