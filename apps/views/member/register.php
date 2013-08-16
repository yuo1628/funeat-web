<?php defined('BASEPATH') or die('No direct script access allowed');

// Import class
?>
<!-- @formatter:off -->

<div style="padding-top: 111px">
	

	<form action="<?php echo site_url('member/register'); ?>" method="post" accept-charset="utf-8" class="cmxform" id="registerForm">
		<div class="regBox">
			<div class="colorbox"></div>
			<div class="regTitle">
				註冊
			</div>
			<div class="regMenu">
				<div class="regItem">
					<div class="regdiv">
						電子信箱 Email
					</div>
					<input type="text" id="email" name="email" value="<?php echo set_value('email'); ?>" class="regText" required />
					<?php echo form_error('email', '<label class="error">', '</label>'); ?>
					
				</div>
				<div class="regItem">
					<div class="regdiv">
						暱稱 Name
					</div>
					<input id="username" type="text" name="name" class="regText" required />
					<?php echo form_error('name', '<label class="error">', '</label>'); ?>
					
				</div>
				<div class="regItem">
					<div class="regdiv">
						密碼 Password
					</div>
					<input id="password" type="password" name="password" class="regText" required />
					<?php echo form_error('password', '<label class="error">', '</label>'); ?>	
				</div>
				<div class="regItem">
					<div class="regdiv">
						確認密碼 Confirm Password
					</div>
					<input type="password" id="repassword" name="confirmPassword" class="regText" required />
					<?php echo form_error('confirmPassword', '<label class="error">', '</label>'); ?>
					
				</div>
				<div class="regItem">					
					<input type="checkbox" name="privacy" value="1" />我同意遵守<a href="#">使用者條款</a>
					<?php echo form_error('privacy', '<label class="error" style="display:block;">', '</label>'); ?>					
				</div>				
				<div class="regItem">
					<input type="submit" class="regCheckSub" value="登入" />
				</div>
			</div>
		</div>
	</form>	
</div>
