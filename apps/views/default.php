<?php
// Load library
$this->load->helper('url');
$this->load->helper('html');
?>
<!DOCTYPE html>
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
		<script src="js/jquery-1.9.1.js" type="text/javascript" ></script>
		<script src="js/jquery.color.js" type="text/javascript" ></script>
		<script src="js/layout.js" type="text/javascript" ></script>
	</head>
	<body>
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
							主頁
						</div>
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
			<div class="leftBox">
				<div class="leftBanner">
					<div class="leftCLose">
						X
					</div>
				</div>
				<div class="leftMenu">
					<div class="leftItem">
						<div class="leftItemImg">
							<img src="http://pic.pimg.tw/weisue/4959ed37a5873.jpg" />
						</div>
						<div class="leftItemDesc">
							<div class="leftItemDescTitle">
								台灣麥當勞
							</div>
							<div class="leftItemDescOther">
								good
							</div>
							<div class="clearfix"></div>
						</div>
					</div>
					<div class="leftItem">
						<div class="leftItemImg">
							<img src="http://visualrecipes.com/images/uploads/blog/kfc-grilled-chicken-leg.jpg" />
						</div>
						<div class="leftItemDesc">
							<div class="leftItemDescTitle">
								肯德基
							</div>
							<div class="leftItemDescOther">
								good
							</div>
							<div class="clearfix"></div>
						</div>
					</div>
					<div class="leftItem">
						<div class="leftItemImg">
							<img src="http://visualrecipes.com/images/uploads/blog/kfc-grilled-chicken-leg.jpg" />
						</div>
						<div class="leftItemDesc">
							<div class="leftItemDescTitle">
								肯德基
							</div>
							<div class="leftItemDescOther">
								good
							</div>
							<div class="clearfix"></div>
						</div>
					</div>
					<div class="leftItem">
						<div class="leftItemImg">
							<img src="http://visualrecipes.com/images/uploads/blog/kfc-grilled-chicken-leg.jpg" />
						</div>
						<div class="leftItemDesc">
							<div class="leftItemDescTitle">
								肯德基
							</div>
							<div class="leftItemDescOther">
								good
							</div>
							<div class="clearfix"></div>
						</div>
					</div>
					<div class="leftItem">
						<div class="leftItemImg">
							<img src="http://visualrecipes.com/images/uploads/blog/kfc-grilled-chicken-leg.jpg" />
						</div>
						<div class="leftItemDesc">
							<div class="leftItemDescTitle">
								肯德基
							</div>
							<div class="leftItemDescOther">
								good
							</div>
							<div class="clearfix"></div>
						</div>
					</div>
				</div>
			</div>
			<div class="contentBox">
				<div class="localBox">
					<div class="localImg">
						<img src="http://news.xinhuanet.com/jiaju/2011-10/13/122138270_111n.jpg"  />
					</div>
					<div class="localTitle">
						長泓資訊有限公司
					</div>
					<div class="localDescBox">
						<div class="localDescMenu">
							<div class="localDescItem">
								台中市北屯區大連路三段10號7F-2
							</div>
							<div class="localDescItem">
								營業時間 : 0900 - 1800
							</div>
						</div>
					</div>
					<div class="localDescBar">
						<div class="localDescBarItem">
							詳細資訊
						</div>
						<div class="clearfix"></div>
					</div>
					<div class="localPrice">
						NT. 30~120
					</div>
				</div>
				<div class="mapBox">
					<iframe width="100%" height="100%" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src=""></iframe>
				</div>
			</div>
		</div>
	</body>
</html>