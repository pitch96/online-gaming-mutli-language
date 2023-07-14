<?php
	$warning_list = get_admin_warning();
	if(!empty($warning_list)){
		echo('<div class="site-warning">');
		foreach ($warning_list as $val) {
			echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">'.$val.'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
		}
		echo('</div>');
	}
	if(isset($_GET['status'])){
		$class = 'alert-success';
		$message = '';
		if($_GET['status'] == 'saved'){
			$message = 'Settings saved!';
		} elseif($_GET['status'] == 'error'){
			$class = 'alert-danger';
			$message = 'Error!';
			if(isset($_GET['info'])){
				$message = $_GET['info'];
			}
		}
		echo '<div class="alert '.$class.' alert-dismissible fade show" role="alert">'._t($message).'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
	}
?>
<div class="section">
	<ul class="nav nav-tabs">
		<li class="nav-item">
			<a class="nav-link active" data-toggle="tab" href="#general"><?php _e('General') ?></a>
		</li>
		<li class="nav-item">
			<a class="nav-link" data-toggle="tab" href="#advanced"><?php _e('Advanced') ?></a>
		</li>
		<li class="nav-item">
			<a class="nav-link" data-toggle="tab" href="#user"><?php _e('User') ?></a>
		</li>
		<li class="nav-item">
			<a class="nav-link" data-toggle="tab" href="#custom-path"><?php _e('Custom path') ?></a>
		</li>
		<li class="nav-item">
			<a class="nav-link" data-toggle="tab" href="#other"><?php _e('Other') ?></a>
		</li>
	</ul>
	<div class="tab-content">
		<div class="tab-pane tab-container active" id="general">
			<form id="form-settings" action="request.php" method="post">
				<input type="hidden" name="action" value="siteSettings">
				<input type="hidden" name="redirect" value="<?php echo DOMAIN ?>admin/dashboard.php?viewpage=settings">
				<div class="form-group row">
					<label for="title" class="col-sm-2 col-form-label"><?php _e('Site title') ?>:</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="title" minlength="4" value="<?php echo esc_string(SITE_TITLE) ?>" required>
					</div>
				</div>
				<div class="form-group row">
					<label for="description" class="col-sm-2 col-form-label"><?php _e('Site description') ?>:</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="description" minlength="4" value="<?php echo esc_string(SITE_DESCRIPTION) ?>" required>
					</div>
				</div>
				<div class="form-group row">
					<label for="meta_description" class="col-sm-2 col-form-label"><?php _e('Meta description') ?>:</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="meta_description" minlength="4" value="<?php echo esc_string(META_DESCRIPTION) ?>" required>
					</div>
				</div>
				<button type="submit" class="btn btn-primary btn-md"><?php _e('Save changes') ?></button>
			</form>
			<br>
			<form id="form-updatelogo" action="request.php" method="post" enctype="multipart/form-data">
				<div class="form-group">
					<input type="hidden" name="action" value="updateLogo">
					<input type="hidden" name="redirect" value="<?php echo DOMAIN ?>admin/dashboard.php?viewpage=settings">
					<label for="logo"><?php _e('Site logo') ?>:</label><br>
					<img src="<?php echo DOMAIN . SITE_LOGO ?>" style="background-color: #aebfbc; padding: 10px"><br><br>
					<input type="file" class="form-control-file" name="logofile" accept=".png, .jpg, .jpeg"/><br>
					<button type="submit" class="btn btn-primary btn-md"><?php _e('Upload') ?></button>
					<br><br>
				</div>
			</form>
			<form id="form-updateloginlogo" action="request.php" method="post" enctype="multipart/form-data">
				<div class="form-group">
					<input type="hidden" name="action" value="updateLoginLogo">
					<input type="hidden" name="redirect" value="<?php echo DOMAIN ?>admin/dashboard.php?viewpage=settings">
					<label for="logo"><?php _e('Login logo') ?>:</label><br>
					<img src="<?php echo DOMAIN . 'images/login-logo.png' ?>" style="background-color: #aebfbc; padding: 10px"><br><br>
					<input type="file" class="form-control-file" name="logofile" accept=".png"/><br>
					<button type="submit" class="btn btn-primary btn-md"><?php _e('Upload') ?></button>
					<br><br>
				</div>
			</form>
			<form id="form-updateicon" action="request.php" method="post" enctype="multipart/form-data">
				<div class="form-group">
					<input type="hidden" name="action" value="updateIcon">
					<input type="hidden" name="redirect" value="<?php echo DOMAIN ?>admin/dashboard.php?viewpage=settings">
					<label for="icon"><?php _e('Site icon') ?> (.ico file format):</label><br>
					<img src="<?php echo DOMAIN  ?>favicon.ico" style="background-color: #aebfbc; padding: 10px; width: 50px;"><br><br>
					<input type="file" class="form-control-file" name="iconfile" accept=".ico"/><br>
					<button type="submit" class="btn btn-primary btn-md"><?php _e('Upload') ?></button>
					<br><br>
				</div>
			</form>
			<form id="form-settings" action="request.php" method="post">
				<input type="hidden" name="action" value="updateLanguage">
				<input type="hidden" name="redirect" value="<?php echo DOMAIN ?>admin/dashboard.php?viewpage=settings">
				<div class="form-group row">
					<label for="code" class="col-sm-2 col-form-label"><?php _e('Site language') ?>:</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="language" minlength="2" maxlength="3" placeholder="en" value="<?php echo $options['language'] ?>" required>
					</div>
				</div>
				<button type="submit" class="btn btn-primary btn-md"><?php _e('Save') ?></button>
			</form>
			<form id="form-settings" action="request.php" method="post">
				<input type="hidden" name="action" value="updatePurchaseCode">
				<input type="hidden" name="redirect" value="<?php echo DOMAIN ?>admin/dashboard.php?viewpage=settings">
				<div class="form-group row">
					<label for="code" class="col-sm-2 col-form-label"><span class="text-danger">*</span> <?php _e('Item purchase code') ?>:</label>
					<div class="col-sm-10">
						<input type="text" class="form-control" name="code" minlength="5" placeholder="101010-10aa-0101-01010-a1b010a01b10" required>
					</div>
				</div>
				<button type="submit" class="btn btn-primary btn-md"><?php _e('Update') ?></button>
			</form>
		</div>

		<div class="tab-pane tab-container fade" id="advanced">
			<form id="form-advanced" action="request.php" method="post">
				<div class="form-group">
					<input type="hidden" name="action" value="set_save_thumbs">
					<input type="hidden" name="redirect" value="<?php echo DOMAIN ?>admin/dashboard.php?viewpage=settings">
					<input type="checkbox" name="value" value="1" <?php if( IMPORT_THUMB ){ echo 'checked'; } ?>>
					<label><?php _e('Save/import thumbnails') ?>:</label><br>
					<p>Save game thumbnails from fetch and remote games to local server. images also compressed and can reduce file size up to 80%.
					<br>Page will be loaded more quickly.</p>
					<button type="submit" class="btn btn-primary btn-md">Save</button>
				</div>
			</form>
			<form id="form-advanced" action="request.php" method="post" class="<?php if( !IMPORT_THUMB ) echo('disabled-list') ?>">
				<div class="form-group">
					<input type="hidden" name="action" value="set_small_thumb">
					<input type="hidden" name="redirect" value="<?php echo DOMAIN ?>admin/dashboard.php?viewpage=settings">
					<input type="checkbox" name="value" value="1" <?php if( SMALL_THUMB ){ echo 'checked'; } ?>>
					<label><?php _e('Small thumbnails') ?>:</label><br>
					<p>Generate small thumbnail (160x160 px) from "thumb_2".<br>
					Can be used to replace "thumb_2" for faster page load, since "thumb_2" have 512px size.<br>
					*Require active import thumbnails.</p>
					<button type="submit" class="btn btn-primary btn-md">Save</button>
				</div>
			</form>
			<form id="form-advanced" action="request.php" method="post" class="<?php if( !IMPORT_THUMB ) echo('disabled-list') ?>">
				<div class="form-group">
					<input type="hidden" name="action" value="set_option">
					<input type="hidden" name="key" value="webp-thumbnail">
					<input type="hidden" name="redirect" value="<?php echo DOMAIN ?>admin/dashboard.php?viewpage=settings">
					<input type="checkbox" name="value" value="1" <?php if( get_option('webp-thumbnail') ){ echo 'checked'; } ?>>
					<label><?php _e('Webp Thumbnails') ?>:</label><br>
					<p>Webp is a next gen image format for web.<br>
					Reduce file size up to 80% compared to regular PNG or JPG and also SEO friendly.<br>
					*Require active import thumbnails.</p>
					<button type="submit" class="btn btn-primary btn-md">Save</button>
				</div>
			</form>
			<form id="form-advanced" action="request.php" method="post">
				<div class="form-group">
					<input type="hidden" name="action" value="set_protocol">
					<input type="hidden" name="redirect" value="<?php echo DOMAIN ?>admin/dashboard.php?viewpage=settings">
					<input type="checkbox" name="value" value="1" <?php if( URL_PROTOCOL == 'https://' ){ echo 'checked'; } ?>>
					<label><?php _e('Use HTTPS') ?>:</label><br>
					<p>If your site running over https, active this.</p>
					<button type="submit" class="btn btn-primary btn-md">Save</button>
				</div>
			</form>
			<form id="form-advanced" action="request.php" method="post">
				<div class="form-group">
					<input type="hidden" name="action" value="set_prettyurl">
					<input type="hidden" name="redirect" value="<?php echo DOMAIN ?>admin/dashboard.php?viewpage=settings">
					<input type="checkbox" name="value" value="1" <?php if( PRETTY_URL ){ echo 'checked'; } ?>>
					<label><?php _e('Pretty URL') ?>:</label><br>
					<p>(Recommended) SEO Friendly URL.<br>If you're using Nginx, you need to update "Rewrite Rules" before activating Pretty URL.</p>
					<button type="submit" class="btn btn-primary btn-md">Save</button>
				</div>
			</form>
			<form id="form-advanced" action="request.php" method="post" class="<?php if( UNICODE_SLUG ) echo('disabled-list') ?>">
				<div class="form-group">
					<input type="hidden" name="action" value="set_custom_slug">
					<input type="hidden" name="redirect" value="<?php echo DOMAIN ?>admin/dashboard.php?viewpage=settings">
					<input type="checkbox" name="value" value="1" <?php if( CUSTOM_SLUG ){ echo 'checked'; } ?>>
					<label><?php _e('Custom slug') ?>:</label><br>
					<p>If you use unicode (Arabic, Russian, Chinese.etc) characters on your game, page and category title, activate this.<br>
					Basically slug are generated automatically with it's title, but it's won't work with non Latin caharacters.</p>
					<button type="submit" class="btn btn-primary btn-md">Save</button>
				</div>
			</form>
			<form id="form-advanced" action="request.php" method="post" class="<?php if( CUSTOM_SLUG ) echo('disabled-list') ?>">
				<div class="form-group">
					<input type="hidden" name="action" value="set_unicode_slug">
					<input type="hidden" name="redirect" value="<?php echo DOMAIN ?>admin/dashboard.php?viewpage=settings">
					<input type="checkbox" name="value" value="1" <?php if( UNICODE_SLUG ){ echo 'checked'; } ?>>
					<label><?php _e('Unicode slug') ?>:</label><br>
					<p>Use non-latin characters (Arabic, Russian, Chinese.etc) for slug or url.<br>
					There's no guarantee it will work flawlessly without any compatibility issues.</p>
					<button type="submit" class="btn btn-primary btn-md">Save</button>
				</div>
			</form>
			<form id="form-advanced" action="request.php" method="post" class="<?php if( !PRETTY_URL ) echo('disabled-list') ?>">
				<div class="form-group">
					<input type="hidden" name="action" value="set_option">
					<input type="hidden" name="key" value="auto-sitemap">
					<input type="hidden" name="redirect" value="<?php echo DOMAIN ?>admin/dashboard.php?viewpage=settings">
					<input type="checkbox" name="value" value="1" <?php if( get_option('auto-sitemap') ){ echo 'checked'; } ?>>
					<label><?php _e('Auto sitemap') ?>:</label><br>
					<p>Automatically update sitemap after add or remove content.</p>
					<button type="submit" class="btn btn-primary btn-md">Save</button>
				</div>
			</form>
			<form id="form-advanced" action="../sitemap.php" method="post" class="<?php if( !PRETTY_URL ) echo('disabled-list') ?>">
				<div class="form-group">
					<label><?php _e('Generate sitemap') ?>:</label><br>
					<p>Exclude all page url. only work if Pretty URL enabled.</p>
					<button type="submit" class="btn btn-primary btn-md"><?php _e('Generate sitemap') ?></button>
				</div>
			</form>
		</div>

		<div class="tab-pane tab-container fade" id="user">
			<form id="form-advanced" action="request.php" method="post">
				<input type="hidden" name="action" value="userSettings">
				<input type="hidden" name="redirect" value="<?php echo DOMAIN ?>admin/dashboard.php?viewpage=settings">
				<div class="form-group">
					<input id="user_register" type="checkbox" name="user_register" value="1" <?php if( filter_var($options['user_register'], FILTER_VALIDATE_BOOLEAN) ){ echo 'checked'; } ?>>
					<label for="user_register"><?php _e('User/player registration') ?></label><br>
				</div>
				<div class="form-group">
					<input id="upload_avatar" type="checkbox" name="upload_avatar" value="1" <?php if( filter_var($options['upload_avatar'], FILTER_VALIDATE_BOOLEAN) ){ echo 'checked'; } ?>>
					<label for="upload_avatar"><?php _e('Upload Avatar (User)') ?></label><br>
				</div>
				<div class="form-group">
					<input id="comments_1" type="checkbox" name="comments" value="1" <?php if( filter_var($options['comments'], FILTER_VALIDATE_BOOLEAN) ){ echo 'checked'; } ?>>
					<label for="comments_1"><?php _e('Comments') ?></label><br>
				</div>
				<div class="form-group">
					<input id="moderate_comment" type="checkbox" name="moderate_comment" value="1" <?php if( filter_var($options['moderate_comment'], FILTER_VALIDATE_BOOLEAN) ){ echo 'checked'; } ?>>
					<label for="moderate_comment"><?php _e('Moderate Comment') ?></label><br>
				</div>
				<div class="form-group">
					<input id="show_login" type="checkbox" name="show_login" value="1" <?php if( filter_var($options['show_login'], FILTER_VALIDATE_BOOLEAN) ){ echo 'checked'; } ?>>
					<label for="show_login"><?php _e('Show login') ?></label><br>
				</div>
				<button type="submit" class="btn btn-primary btn-md"><?php _e('Save') ?></button>
			</form>
			<div class="mb-4"></div>
			<form action="request.php" method="post" enctype="multipart">
				<div class="form-group">
					<input type="hidden" name="action" value="set_option">
					<input type="hidden" name="key" value="captcha">
					<input type="hidden" name="redirect" value="<?php echo DOMAIN ?>admin/dashboard.php?viewpage=settings">
					<input type="checkbox" name="value" value="1" <?php if( get_option('captcha') ){ echo 'checked'; } ?>>
					<label><?php _e('CAPTCHA') ?>:</label><br>
					<p>Show CAPTCHA on registration page.</p>
					<button type="submit" class="btn btn-primary btn-md">Save</button>
				</div>
			</form>
		</div>

		<div class="tab-pane tab-container fade" id="custom-path">
			<p>Custom URL base for page or category name.</p>
			<form id="form-advanced" action="request.php" method="post">
				<input type="hidden" name="action" value="set_custom_path">
				<input type="hidden" name="redirect" value="<?php echo DOMAIN ?>admin/dashboard.php?viewpage=settings">
				<?php

				$list = ['game','category','page','search','login','register','user','post','full','splash'];
				foreach ($list as $name) {
					?>
					<div class="form-group row">
						<label for="<?php echo $name ?>" class="col-sm-2 col-form-label"><?php echo $name ?></label>
						<div class="col-sm-6 col-md-4">
							<input type="text" class="form-control" name="list[]" value="<?php echo (convert_to_custom_path($name) != $name) ? convert_to_custom_path($name) : '' ?>">
						</div>
					</div>
					<?php
				}

				?>
				<button type="submit" class="btn btn-primary btn-md"><?php _e('Save') ?></button>
			</form>
		</div>

		<div class="tab-pane tab-container fade" id="other">
			<form id="form-advanced" action="request.php" method="post">
				<input type="hidden" name="action" value="otherSettings">
				<input type="hidden" name="redirect" value="<?php echo DOMAIN ?>admin/dashboard.php?viewpage=settings">
				<div class="form-group">
					<input id="splash" type="checkbox" name="splash" value="1" <?php if( filter_var($options['splash'], FILTER_VALIDATE_BOOLEAN) ){ echo 'checked'; } ?>>
					<label for="splash"><?php _e('Splash Screen (Self uploaded)') ?></label><br>
				</div>
				<div class="form-group">
					<input id="show_ad_on_splash" type="checkbox" name="show_ad_on_splash" value="1" <?php if( filter_var($options['show_ad_on_splash'], FILTER_VALIDATE_BOOLEAN) ){ echo 'checked'; } ?>>
					<label for="show_ad_on_splash"><?php _e('Show Ad On Splash') ?></label><br>
				</div>
				<button type="submit" class="btn btn-primary btn-md"><?php _e('Save') ?></button>
			</form>
		</div>
	</div>
</div>