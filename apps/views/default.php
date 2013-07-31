<?php
	// Load library
	$this->load->helper('url');
	$this->load->helper('html');

	// Page title
	$title = 'FunEat';

	/**
	 * Blocks data
	 *
	 * @var stdClass
	 */
	$blocks;

	/**
	 * @var Head
	 */
	$head;
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<base href="<?php echo base_url(); ?>" />
		<?php echo ENVIRONMENT == 'development' ? meta('cache-control', 'no-cache', 'equiv') : '' ?>
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
		<title><?php echo $title; ?></title>
		<link href="css/layout.css" rel="stylesheet" />
		<link href="css/default.css" rel="stylesheet" />
		<script src="js/jquery-2.0.3.min.js" type="text/javascript"></script>
		<script src="js/jquery.color.js" type="text/javascript"></script>
		<script src="js/funeat.core.js" type="text/javascript"></script>
		<script src="js/layout.js" type="text/javascript"></script>
		<script src="http://map.google.com/maps/api/js?sensor=true" type="text/javascript"></script>
		<script src="js/gmaps.js" type="text/javascript"></script>
		<?php echo ltrim($head->fetch()); ?>
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
					<div class="positionBtn">
						
					</div>
					
					<div class="localInfoBox">
						目前位置<br>
						<input id="localAddress" type="text" disabled onchange="Listener.TopBox.onLocalAddressChange(map)" />
						<input id="localLatitude" type="hidden" />
						<input id="localLongitude" type="hidden" /><br>
						<label>
							<input id="localManual" type="checkbox" onclick="Listener.TopBox.onLocalManualClick()"/>自行輸入位置
						</label>
						<script>
							jQuery(document).ready(function()
							{
								jQuery("#localLatitude").val(Funeat.Storage.localLat);
								jQuery("#localLongitude").val(Funeat.Storage.localLng);
		
		
								if (Funeat.Storage.localManual == 1) {
									jQuery("#localAddress").removeAttr("disabled");
									jQuery("#localManual").prop("checked", true);
								}
		
								GMaps.geocode(
								{
									lat : Funeat.Storage.localLat,
									lng : Funeat.Storage.localLng,
									callback : function(results, status)
									{
										if (results && results.length > 0)
										{
											jQuery("#localAddress").val(results[0].formatted_address);
										}
									}
								});
							});
						</script>
					</div>
				</div>
				<div class="quickBox">
					<div class="quickItem">
						<div class="registerBtn" onclick="Listener.TopBox.registerBtn()"></div>
					</div>
					<div class="quickItem">
						<div class="loginBtn" onclick="Listener.TopBox.loginBtn()"></div>
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
			
			<?php echo $this->view($blocks->body) ?>
			<div class="footer">
				2013 Powered by DreamOn.
			</div>
		</div>
	</body>
</html>