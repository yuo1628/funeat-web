<?php if ( ! defined('BASEPATH') || ENVIRONMENT != 'development') exit('No direct script access allowed');
?>
<!DOCTYPE HTML>
<html lang="en-EN">
<head>
	<meta charset="UTF-8">
	<title>Install Database</title>

	<style type="text/css">
		body {
			background-color: #fff;
			margin: 40px;
			font-family: Lucida Grande, Verdana, Sans-serif;
			font-size: 14px;
			color: #4F5155;
		}

		a {
			color: #003399;
			background-color: transparent;
			font-weight: normal;
		}

		h1 {
			color: #444;
			background-color: transparent;
			border-bottom: 1px solid #D0D0D0;
			font-size: 16px;
			font-weight: bold;
			margin: 24px 0 2px 0;
			padding: 5px 0 6px 0;
		}
	</style>
</head>
<body>
	<h1>Functions</h1>
	<ol>
		<li><?php echo anchor('install/database/install', 'Install all schema'); ?></li>
		<li><?php echo anchor('install/database/update', 'Update all schema'); ?></li>
		<li><?php echo anchor('install/database/drop', 'Drop all schema'); ?></li>
	</ol>

	<h1>Schemas</h1>
	<?php foreach ($entity as $data): ?>
		<ul>
			<li><?php echo $data ?></li>
		</ul>
	<?php endforeach; ?>
</body>
</html>