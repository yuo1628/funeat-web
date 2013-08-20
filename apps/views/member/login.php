<?php defined('BASEPATH') or die('No direct script access allowed');

// Import class
?>
<!-- @formatter:off -->

<div style="padding-top: 111px">
	<form action="<?php echo site_url('login'); ?>" method="post" accept-charset="utf-8" class="cmxform" id="loginForm">
		<div class="loginBox">
			<div class="colorbox"></div>
			<div class="loginTitle">
				登入
			</div>
			<div class="loginMenu">
				<div class="loginItem">
					<div class="logindiv">
						電子信箱 Email
					</div>
					<input type="text" id="email" name="identity" value="<?php echo set_value('identity'); ?>" class="loginText"/>
					<?php echo form_error('identity', '<label class="error">', '</label>'); ?>
					
				</div>
				<div class="loginItem">
					<div class="logindiv">
						密碼 Password
					</div>
					<input type="password" id="password" name="password" value="<?php echo set_value('password'); ?>" class="loginText" />
					<?php echo form_error('password', '<label class="error">', '</label>').'</label>'; ?>
					
				</div>
				<div class="loginItem">
					<div class="loginKeepcheck" >
						<input type="checkbox">
						<label>保持登入</label>
					</div>
					<div class="logreglink" >
						<div style="margin: 0 0 5px 0;">
							<a href="">忘記密碼</a>
						</div>
						<div style="margin: 0 0 5px 0;">
							<a href="">尚未註冊</a>
						</div>
					</div>
					<div class="clearfix"></div>
				</div>
				<div class="loginItem">
					<input class="loginCheckSub" type="submit" value="登入">
				</div>
			</div>
		</div>
	</form>
</div>