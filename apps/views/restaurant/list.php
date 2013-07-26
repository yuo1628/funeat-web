<?php
// Load library
$this->load->helper('url');
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
		<link href="css/gallery.css" rel="stylesheet" />
		<link href="css/restaurant_list.css" rel="stylesheet" />
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
					<div class="resListItem">
						<div class="resListTitle">
							title
						</div>
						<div class="resListImg">
							<img src="http://lorempixel.com/320/200/food/" />
						</div>
						<div class="resListDesc">
							自從20年前研發出包心粉圓並設攤於羅東夜市1078號攤位以來深受大眾喜愛，今年夫妻分家後正式使用”雙愛心”為商標推出一系列的甜品並造成熱潮，除了讓消費者能品嚐傳統包心粉圓的滋味，更期待能再研發創新口味。
						</div>
						<div class="resListInfo">
							<div class="resListInfoPriceBox">
								$ 30~120
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
									251
								</div>
								<div class="clearfix" ></div>
							</div>
							<div class="resListInfoItem">
								<div class="resListInfoIcon">
									<img src="img/icon/res_bomb.png" title="不喜歡" />
								</div>
								<div class="resListInfoCount">
									9
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
					<div class="resListItem">
						<div class="resListTitle">
							title
						</div>
						<div class="resListImg">
							<img src="http://lorempixel.com/320/230/food/" />
						</div>
						<div class="resListDesc">
							自從20年前研發出包心粉圓並設攤於羅東夜市1078號攤位以來深受大眾喜愛，今年夫妻分家後正式使用”雙愛心”為商標推出一系列的甜品並造成熱潮，除了讓消費者能品嚐傳統包心粉圓的滋味，更期待能再研發創新口味。
						</div>
						<div class="resListInfo">
							<div class="resListInfoPriceBox">
								$ 30~120
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
									251
								</div>
								<div class="clearfix" ></div>
							</div>
							<div class="resListInfoItem">
								<div class="resListInfoIcon">
									<img src="img/icon/res_bomb.png" title="不喜歡" />
								</div>
								<div class="resListInfoCount">
									9
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
					<div class="resListItem">
						<div class="resListTitle">
							title
						</div>
						<div class="resListImg">
							<img src="http://lorempixel.com/320/160/food/" />
						</div>
						<div class="resListDesc">
							自從20年前研發出包心粉圓並設攤於羅東夜市1078號攤位以來深受大眾喜愛，今年夫妻分家後正式使用”雙愛心”為商標推出一系列的甜品並造成熱潮，除了讓消費者能品嚐傳統包心粉圓的滋味，更期待能再研發創新口味。
						</div>
						<div class="resListInfo">
							<div class="resListInfoPriceBox">
								$ 30~120
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
									251
								</div>
								<div class="clearfix" ></div>
							</div>
							<div class="resListInfoItem">
								<div class="resListInfoIcon">
									<img src="img/icon/res_bomb.png" title="不喜歡" />
								</div>
								<div class="resListInfoCount">
									9
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
					<div class="clearfix" ></div>
				</div>
			</div>
			<div class="footer">
				2013 Powered by DreamOn.
			</div>
		</div>
	</body>
</html>
