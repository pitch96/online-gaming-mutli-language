<?php
$list_string = [];
	$data_array = null;
	$file_name = '';
	$target = 'theme';
	if(isset($_POST['action'])){
		if($_POST['action'] === 'edit'){
			if(isset($_POST['translation'])){
				$data_array = json_decode(file_get_contents(ABSPATH.$_POST['translation']), true);
				$file_name = substr(basename($_POST['translation']), 0, -5);
				if(substr($_POST['translation'], 0, 7) === 'content'){
					$target = 'theme';
					if(true){
						// Combine from scanned
						// Purpose: Continue translation if not complete or if there are a new translation string
						scan_translation_string_from_theme();
						$_array = [];
						foreach ($list_string as $string) {
							$_array[$string] = '';
							if(isset($data_array[$string])){
								$_array[$string] = $data_array[$string];
							}
						}
						foreach ($data_array as $string => $value) {
							if(!isset($_array[$string])){
								$_array[$string] = $value;
							}
						}
						$data_array = $_array;
					}
				} else {
					$target = 'admin';
				}
			}
		}
	}
	if(isset($_GET['action'])){
		if($_GET['action'] === 'template-theme'){
			$data_array = json_decode(file_get_contents($plugin['path'].'/template-theme.json'), true);
			$target = 'theme';
		} else if($_GET['action'] === 'template-admin'){
			$data_array = json_decode(file_get_contents($plugin['path'].'/template-admin.json'), true);
			$target = 'admin';
		} else if($_GET['action'] === 'scan_from_theme'){
			scan_translation_string_from_theme();
			$data_array = [];
			foreach ($list_string as $string) {
				$data_array[$string] = '';
			}
			$target = 'theme';
		}
	}
	if(isset($_GET['status'])){
		$class = 'alert-success';
		$message = '';
		if($_GET['status'] == 'deleted'){
			$message = 'Backup file removed!';
		} elseif($_GET['status'] == 'restored'){
			$message = 'CMS restored!';
		}
		echo '<div class="alert '.$class.' alert-dismissible fade show" role="alert">'.$message.'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
	}
function scan_translation_string_from_theme(){
	$file_list = scan_files(TEMPLATE_PATH);
	$php_file_list = [];
	foreach ($file_list as $file_path) {
		if(pathinfo($file_path, PATHINFO_EXTENSION) == 'php'){
			$php_file_list[] = $file_path;
		}
	}
	if(count($php_file_list)){
		foreach ($php_file_list as $php_path) {
			$str = file_get_contents(ABSPATH.$php_path);
			get_translation_string1($str);
			get_translation_string2($str);
			get_translation_string3($str);
			get_translation_string4($str);
		}
	}
}
function get_translation_string1($str){
	global $list_string;
	$index = strpos($str,"_e('");
	$max = strlen($str);
	$string = '';
	if($index > 0){
		$index += strlen("_e('");
		for ($i=$index; $i < $max; $i++) { 
			$char = $str[$i];
			if($char != "'"){
				$string .= $char;
			} else {
				if(!string_already_exist($list_string, $string)){
					$list_string[] = $string;
				}
				$str = str_replace("_e('".$string, '', $str);
				get_translation_string1($str);
				break;
			}
		}
	}
}
function get_translation_string2($str){
	global $list_string;
	$index = strpos($str,'_e("');
	$max = strlen($str);
	$string = '';
	if($index > 0){
		$index += strlen('_e("');
		for ($i=$index; $i < $max; $i++) { 
			$char = $str[$i];
			if($char != '"'){
				$string .= $char;
			} else {
				if(!string_already_exist($list_string, $string)){
					$list_string[] = $string;
				}
				$str = str_replace('_e("'.$string, '', $str);
				get_translation_string2($str);
				break;
			}
		}
	}
}
function get_translation_string3($str){
	global $list_string;
	$index = strpos($str,"_t('");
	$max = strlen($str);
	$string = '';
	if($index > 0){
		$index += strlen("_t('");
		for ($i=$index; $i < $max; $i++) { 
			$char = $str[$i];
			if($char != "'"){
				$string .= $char;
			} else {
				if(!string_already_exist($list_string, $string)){
					$list_string[] = $string;
				}
				$str = str_replace("_t('".$string, '', $str);
				get_translation_string1($str);
				break;
			}
		}
	}
}
function get_translation_string4($str){
	global $list_string;
	$index = strpos($str,'_t("');
	$max = strlen($str);
	$string = '';
	if($index > 0){
		$index += strlen('_t("');
		for ($i=$index; $i < $max; $i++) { 
			$char = $str[$i];
			if($char != '"'){
				$string .= $char;
			} else {
				if(!string_already_exist($list_string, $string)){
					$list_string[] = $string;
				}
				$str = str_replace('_t("'.$string, '', $str);
				get_translation_string2($str);
				break;
			}
		}
	}
}
function string_already_exist($arr, $string){
	foreach ($arr as $val) {
		if($val == $string){
			return true;
		}
	}
	return false;
}
?>
<div class="section">
	<?php
	if(!file_exists(ABSPATH.'locales') && !file_exists(ABSPATH.TEMPLATE_PATH.'/locales')){
		echo('<p>No translation file found! create one to get started.</p>');
	} else {
		$admin_list = [];
		$theme_list = [];
		if(file_exists(ABSPATH.'locales')){
			$arr = scan_files('locales');
			foreach ($arr as $item) {
				if(substr($item, -4) === 'json'){
					$admin_list[] = $item;
				}
			}
		}
		if(file_exists(ABSPATH.'content/themes/'.THEME_NAME.'/locales')){
			$arr = scan_files('content/themes/'.THEME_NAME.'/locales');
			foreach ($arr as $item) {
				if(substr($item, -4) === 'json'){
					$theme_list[] = $item;
				}
			}
		}
		if(count($admin_list) || count($theme_list)){
			?>
			<form action="<?php echo DOMAIN ?>admin/dashboard.php?viewpage=plugin&name=localization" enctype="multipart/form-data" method="post">
				<input type="hidden" name="action" value="edit"/>
				<label>Edit translation file:</label>
				<div class="row">
					<div class="col">
						<select name="translation" class="form-control" id="translation-options" required>
							<option value="" disabled selected hidden>Select file...</option>
							<?php

							foreach ($admin_list as $item) {
								echo '<option value="'.$item.'">(Admin) '.substr($item, 0, -5).'</option>';
							}
							foreach ($theme_list as $item) {
								echo '<option value="'.$item.'">(Theme) '.substr($item, 0, -5).'</option>';
							}

							?>
						</select>
					</div>
				</div>
				<br>
				<button type="submit" class="btn btn-primary btn-md">Edit</button>
			</form>
			<br>
			<?php
		}
	}

	?>
	<?php if(is_null($data_array)){ ?>
	<div class="create-btn">
		<button onclick="scan_from_theme()" class="btn btn-primary btn-md">Scan from Theme (Visitor page)</button>
		<button onclick="create_template('admin')" class="btn btn-primary btn-md">Create from template (Admin panel)</button>
		<button onclick="create_blank()" class="btn btn-primary btn-md">Create from blank</button>
	</div>
	<?php } ?>
	<div class="localization-section" style="<?php if(is_null($data_array)) echo 'display: none'; ?>">
		<form id="form-localization" action="#" method="post">
			<div class="form-group row">
				<div class="col-sm-6">
					<label>Target:</label>
					<div class="form-check">
			          <input class="form-check-input" type="radio" name="target" id="gridRadios1" value="admin" <?php if($target === 'admin') echo 'checked'; ?>>
			          <label class="form-check-label" for="gridRadios1">
			            Admin
			          </label>
			        </div>
			        <div class="form-check">
			          <input class="form-check-input" type="radio" name="target" id="gridRadios2" value="theme" <?php if($target === 'theme') echo 'checked'; ?>>
			          <label class="form-check-label" for="gridRadios2">
			            Theme
			          </label>
			        </div>
				</div>
			</div>
			<div class="form-group row">
				<div class="col-sm-6">
					<label for="lang-id">Language id (en, de, id, ru, jp, cn):</label>
					<input type="text" class="form-control" id="lang-id" name="lang-id" minlength="2" maxlength="3" placeholder="id" value="<?php echo $file_name ?>" required>
				</div>
			</div>
			<div class="form-group row">
				<div class="col">
					<label>Original string</label>
				</div>
				<div class="col">
					<label>Translation</label>
				</div>
			</div>
				
			<?php

			if(!is_null($data_array)){
				foreach ($data_array as $item => $value) {
					?>
						<div class="form-group row">
							<div class="col">
								<input type="text" class="form-control t-original" name="val" value="<?php echo $item ?>">
							</div>
							<div class="col">
								<input type="text" class="form-control t-translation" name="val" value="<?php echo $value ?>">
							</div>
						</div>
					<?php
				}
			} else { ?>
				<div class="form-group row">
					<div class="col">
						<input type="text" class="form-control t-original" name="val" value="">
					</div>
					<div class="col">
						<input type="text" class="form-control t-translation" name="val" value="">
					</div>
				</div>
				<div class="form-group row">
					<div class="col">
						<input type="text" class="form-control t-original" name="val" value="">
					</div>
					<div class="col">
						<input type="text" class="form-control t-translation" name="val" value="">
					</div>
				</div>
			<?php } ?>
			<div id="inner-row"></div>
		</form>
		<button id="add-row" class="btn btn-success btn-md">Add more row</button>
		<br>
		<button id="save-lang" class="btn btn-primary btn-md">Save</button>
	</div>

	<div class="bs-callout bs-callout-info">Note: Case sensitive.</div>
</div>
<script type="text/javascript">
	$(document).ready(()=>{
		$('#save-lang').click(()=>{
			let target = $('input[name="target"]:checked').val();
			let lang = $('#lang-id').val();
			if(lang){
				let arr = $( '#form-localization' ).serializeArray();
				let res = '{';
				let error;
				let t1 = $('.t-original').serializeArray();
				let t2 = $('.t-translation').serializeArray();
				let total = t1.length;
				for(let i=0; i<total; i++){
					if(t1[i].value && t2[i].value){
						res += '"'+t1[i].value+'"'+': "'+t2[i].value+'",';
					}
				}
				if(res.slice(-1) === ','){
					res = res.slice(0, -1);
				}
				res += '}';
				let x = JSON.parse(res);
				if(res !=  '{}'){
					$.ajax({
						url: "<?php echo DOMAIN ?>content/plugins/localization/action.php",
						type: 'POST',
						dataType: 'json',
						data: {action: 'submit', target: target, lang: lang, data: JSON.stringify(JSON.parse(res))},
						success: function (data) {
							//console.log(data.responseText);
						},
						error: function (data) {
							//console.log(data.responseText);
						},
						complete: function (data) {
							console.log(data.responseText);
							if(data.responseText === 'ok'){
								$('.section').before('<div class="alert alert-success alert-dismissible fade show" role="alert">Translation updated<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
								window.scrollTo(0, 0);
							} else {
								alert('Error! Check console log for more info!');
							}
						}
					});
				}
			} else {
				alert('Language ID is required!');
			}
		});
		$('#add-row').click(()=>{
			$('#inner-row').before('<div class="form-group row"><div class="col"><input type="text" class="form-control t-original" name="val" value=""></div><div class="col"><input type="text" class="form-control t-translation" name="val" value=""></div></div>');
		});
	});
	function create_blank() {
		$('.create-btn').hide();
		$('.localization-section').show();
	}
	function create_template(type) {
		$('.create-btn').hide();
		window.location.replace("<?php echo DOMAIN ?>admin/dashboard.php?viewpage=plugin&name=localization&action=template-"+type);
	}
	function scan_from_theme() {
		$('.create-btn').hide();
		window.location.replace("<?php echo DOMAIN ?>admin/dashboard.php?viewpage=plugin&name=localization&action=scan_from_theme");
	}
</script>