<?php 
// Include functions if not already included
require_once('functions.php');

// Upgrade environment
upgradeCheck();

// Lazyload settings
$databaseConfig = configLazy('config/config.php');

// Load USER
require_once("user.php");
$USER = new User("registration_callback");

// Create Database Connection
$file_db = new PDO('sqlite:'.DATABASE_LOCATION.'users.db');
$file_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Some PHP config stuff
ini_set("display_errors", 1);
ini_set("error_reporting", E_ALL | E_STRICT);

// Confirm Access
qualifyUser('admin', true);

// Load User List
$gotUsers = $file_db->query('SELECT * FROM users');

// Load Colours/Appearance
foreach(loadAppearance() as $key => $value) {
	$$key = $value;
}

// Slimbar
if(SLIMBAR == "true") {
	$slimBar = "30"; 
	$userSize = "25";
} else {
	$slimBar = "56"; 
	$userSize = "40"; 
}
?>

<!DOCTYPE html>

<html lang="en" class="no-js">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="msapplication-tap-highlight" content="no" />

        <title>Settings</title>

        <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
        <link rel="stylesheet" href="bower_components/mdi/css/materialdesignicons.min.css">
        <link rel="stylesheet" href="bower_components/metisMenu/dist/metisMenu.min.css">
        <link rel="stylesheet" href="bower_components/Waves/dist/waves.min.css"> 
        <link rel="stylesheet" href="bower_components/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.css"> 

        <link rel="stylesheet" href="js/selects/cs-select.css">
        <link rel="stylesheet" href="js/selects/cs-skin-elastic.css">
        <link href="bower_components/iconpick/dist/css/fontawesome-iconpicker.min.css" rel="stylesheet">
        <link rel="stylesheet" href="bower_components/google-material-color/dist/palette.css">
        <link rel="stylesheet" href="bower_components/sweetalert/dist/sweetalert.css">
        <link rel="stylesheet" href="bower_components/smoke/dist/css/smoke.min.css">

        <script src="js/menu/modernizr.custom.js"></script>
        <script type="text/javascript" src="js/sha1.js"></script>
        <script type="text/javascript" src="js/user.js"></script>
        <link rel="stylesheet" href="bower_components/animate.css/animate.min.css">
        <link rel="stylesheet" href="bower_components/DataTables/media/css/jquery.dataTables.css">
        <link rel="stylesheet" href="bower_components/datatables-tabletools/css/dataTables.tableTools.css">
        <link rel="stylesheet" href="bower_components/numbered/jquery.numberedtextarea.css">

        <link rel="stylesheet" href="css/style.css?v=<?php echo INSTALLEDVERSION; ?>">
        <link rel="stylesheet" href="css/settings.css?v=<?php echo INSTALLEDVERSION; ?>">
        <link href="css/jquery.filer.css" rel="stylesheet">
	    <link href="css/jquery.filer-dragdropbox-theme.css" rel="stylesheet">

        <!--[if lt IE 9]>
        <script src="bower_components/html5shiv/dist/html5shiv.min.js"></script>
        <script src="bower_components/respondJs/dest/respond.min.js"></script>
        <![endif]-->
		
        <!--Scripts-->
        <script src="bower_components/jquery/dist/jquery.min.js"></script>
        <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
        <script src="bower_components/metisMenu/dist/metisMenu.min.js"></script>
        <script src="bower_components/Waves/dist/waves.min.js"></script>
        <script src="bower_components/moment/min/moment.min.js"></script>
        <script src="bower_components/jquery.nicescroll/jquery.nicescroll.min.js"></script>
        <script src="bower_components/slimScroll/jquery.slimscroll.min.js"></script>
        <script src="bower_components/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.js"></script>
        <script src="bower_components/cta/dist/cta.min.js"></script>

        <!--Menu-->
        <script src="js/menu/classie.js"></script>
        <script src="bower_components/iconpick/dist/js/fontawesome-iconpicker.js"></script>


        <!--Selects-->
        <script src="js/selects/selectFx.js"></script>
        <script src="js/jscolor.js"></script>
        <script src="bower_components/sweetalert/dist/sweetalert.min.js"></script>

        <script src="bower_components/smoke/dist/js/smoke.min.js"></script>
        <script src="bower_components/numbered/jquery.numberedtextarea.js"></script>
		
		<!--Other-->
		<script src="js/ajax.js?v=<?php echo INSTALLEDVERSION; ?>"></script>

        <!--Notification-->
        <script src="js/notifications/notificationFx.js"></script>

        <script src="js/jqueri_ui_custom/jquery-ui.min.js"></script>
        <script src="js/jquery.filer.min.js" type="text/javascript"></script>
	    <script src="js/custom.js?v=<?php echo INSTALLEDVERSION; ?>" type="text/javascript"></script>
	    <script src="js/jquery.mousewheel.min.js" type="text/javascript"></script>
        <!--Data Tables-->
        <script src="bower_components/DataTables/media/js/jquery.dataTables.js"></script>
        <script src="bower_components/datatables.net-responsive/js/dataTables.responsive.js"></script>
        <script src="bower_components/datatables-tabletools/js/dataTables.tableTools.js"></script>
		
		<!--Other-->
		<script>
			function addTab() {
				var idNumber = Math.round(Math.random() * 999999999) + 1000000000;
				var $element = $('#tab-new').clone();
				$element.css('display','block');
				$element.attr('id', $element.attr('id').replace('new',idNumber));
				$element.find('[value=new]').attr('value', idNumber).val(idNumber);
				$element.find('[id][name]').each(function () {
					this.id = this.id.replace('new',idNumber);
					this.name = this.name.replace('new',idNumber);
				});
				$element.find('[for]').each(function () {
					$(this).attr('for',$(this).attr('for').replace('new',idNumber));
				});
				$element.appendTo('#submitTabs ul');
				$element.find('.icp-auto-pend').iconpicker({placement: 'left', hideOnSelect: false, collision: true}).hide();
    $('.tab-box').scrollTop($('.tab-box')[0].scrollHeight);
			}
			function submitTabs(form) {
				var formData = {};
				var ids = [];
				
				$.each($(form).serializeArray(), function(i,v) {
					var regmatch = /(\w+)\[((?:new-)?\d+)\]/i.exec(v.name);
					if (regmatch) {
						if (ids.indexOf(regmatch[2]) == -1) {
							ids.push(regmatch[2]);
							if (typeof formData['order'] !== 'object') { formData['order'] = {}; }
							formData['order'][regmatch[2]] = ids.length;
						}
						if (typeof formData[regmatch[1]] !== 'object') { formData[regmatch[1]] = {}; }
						formData[regmatch[1]][regmatch[2]] = v.value; 
					} else {
						console.log(regmatch);
					}
				});
				console.log(formData);
				ajax_request('POST', 'submit-tabs', formData);
				
				return false;
			}
		</script>
		
        <style>
            .loop-animation {
                animation-iteration-count: infinite;
                -webkit-animation-iteration-count: infinite;
                -moz-animation-iteration-count: infinite;
                -o-animation-iteration-count: infinite;
            }
            @media screen and (max-width:737px){
                .email-body{width: 100%; overflow: auto;}
                .email-content, .email-new {
                    -webkit-overflow-scrolling: touch;
                    -webkit-transform: translateZ(0);
                    overflow: scroll;
                    position: fixed;
                    height:100% !important;
                    margin-top:0;

                }.email-content .email-header, .email-new .email-header{
                    padding: 10px 30px;
                    z-index: 1000;
                }
            }@media screen and (min-width:737px){
                .email-body{width: 100%}
                .email-content .close-button, .email-content .email-actions, .email-new .close-button, .email-new .email-actions {
                    position: relative;
                    top: 15px;
                    right: 0px;
                    float: right;
                }.email-inner-section {
                    margin-top: 50px;
                }.email-content, .email-new {
                    overflow: auto;
                    margin-top: 0;
                    height: 100%;
                    position: fixed;
                    max-width: 100%;
                    width: 84%;
                    right: -84%;
                }.email-content .email-header, .email-new .email-header{
                    position: fixed;
                    padding: 10px 30px;
                    width: 84%;
                    z-index: 1000;
                }
            }ul.inbox-nav.nav {
                background: white;
                padding: 5px;
                border-radius: 5px;
            }.profile-usermenu ul li.active a {
                border-left: 3px solid <?=$activetabBG;?> !important;
                padding-left: 12px;
            }.profile-usermenu ul li a:hover {
                background: <?=$hoverbg;?> !important;
                color: <?=$hovertext;?> !important;
                cursor: pointer;
            }input.form-control.material.icp-auto.iconpicker-element.iconpicker-input {
                display: none;
            }input.form-control.iconpicker-search {
                color: black;
            }.key {
                font-family:Tahoma, sans-serif;
                border-style:solid;
                border-color:#D5D6AD #C1C1A8 #CDCBA5 #E7E5C5;
                border-width:2px 3px 8px 3px;
                background:#D6D4B4;
                display:inline-block;
                border-radius:5px;
                margin:3px;
                text-align:center;
            }.form-control.material {
                background-image: -webkit-gradient(linear, left top, left bottom, from(<?=$topbartext;?>), to(<?=$topbartext;?>)), -webkit-gradient(linear, left top, left bottom, from(#d2d2d2), to(#d2d2d2));
                background-image: -webkit-linear-gradient(<?=$topbartext;?>, <?=$topbartext;?>), -webkit-linear-gradient(#d2d2d2, #d2d2d2);
                background-image: linear-gradient(<?=$topbartext;?>, <?=$topbartext;?>), linear-gradient(#d2d2d2, #d2d2d2);
            }.key span {
                background:#ECEECA;
                color:#5D5E4F;
                display:block;
                font-size:12px;
                padding:0 2px;
                border-radius:3px;
                width:14px;
                height:18px;
                line-height:18px;
                text-align:center;
                font-weight:bold;
                letter-spacing:1px;
                text-transform:uppercase;
            }.key.wide span {
                width:auto;
                padding:0 12px;
            }.dragging{
                border: 2px solid;    
            }.todo .action-btns a span {
                color: #76828e !important;
            }.todo li:nth-child(even) {
                background: #FFFFFF !important;
            }.themeImage {
                position: fixed;
                left: 160px;
                top: 0px;
                height: 400px;
            }.chooseTheme a span { 
                position:absolute; display:none; z-index:99; 
            }.chooseTheme a:hover span { 
                display:block; 
            }ul.nav.nav-tabs.apps {
                border: solid;
                border-top: 0;
                border-left: 0;
                border-right: 0;
                border-radius: 0;
            }li.apps.active {
                border: solid;
                border-bottom: 0;
                border-radius: 5px;
                top: 3px;
}<?php if(CUSTOMCSS == "true") : 
$template_file = "custom.css";
$file_handle = fopen($template_file, "rb");
echo fread($file_handle, filesize($template_file));
fclose($file_handle);
echo "\n";
endif; ?>
        </style>
    </head>

    <body class="scroller-body" style="padding: 0; background: #273238; overflow: hidden">
        <div id="main-wrapper" class="main-wrapper">

            <!--Content-->
            <div id="content"  style="margin:0 10px; overflow:hidden">
                <div class="modal fade checkFrame" tabindex="-1" role="dialog">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">Check iFrame Compatability</h4>
                            </div>
                            <form id="urlTestForm" onsubmit="return false;">
                                <div class="modal-body">
                                    Let's Check this URL
                                    <input type="text" class="form-control material" name="url-test" placeholder="<?php echo translate("URL"); ?>" autocorrect="off" autocapitalize="off" value="">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default waves" data-dismiss="modal">Close</button>
                                    <button id="urlTestForm_submit" class="btn btn-primary waves" data-dismiss="modal">Check Frame URL</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <br/>
                <div id="versionCheck"></div>
                <div class="row">
                    <div class="col-lg-2">
						<button id="apply" style="width: 100%; display: none;" class="btn waves btn-success btn-sm text-uppercase waves-effect waves-float animated tada" type="submit">
							<?php echo $language->translate("APPLY_CHANGES");?>
						</button>
                        <div class="content-box profile-sidebar box-shadow">
                            <img src="images/organizr-logo-h-d.png" width="100%" style="margin-top: -10px;">
                            <div class="profile-usermenu">
                                <ul class="nav" id="settings-list">
                                    <li><a id="open-tabs" box="tab-box"><i class="fa fa-list red-orange pull-right"></i>Edit Tabs</a></li>
                                    <li><a id="open-colors" box="color-box"><i class="fa fa-paint-brush green pull-right"></i>Edit Colors</a></li>
                                    <li><a id="open-users" box="users-box"><i class="fa fa-user red pull-right"></i>Manage Users</a></li>
                                    <li><a id="open-logs" box="logs-box"><i class="fa fa-file-text-o blue pull-right"></i>View Logs</a></li>
                                    <li><a id="open-homepage" box="homepage-box"><i class=" fa fa-home yellow pull-right"></i>Edit Homepage</a></li>
                                    <li><a id="open-advanced" box="advanced-box"><i class=" fa fa-cog light-blue pull-right"></i>Advanced</a></li>
                                    <li><a id="open-info" box="info-box"><i class=" fa fa-info-circle orange pull-right"></i>About</a></li>
                                    <li><a id="open-donate" box="donate-box"><i class=" fa fa-money red pull-right"></i>Donate</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-10">
                        
                    </div>
                </div>
                <div class="email-content tab-box white-bg">
                    <div class="email-body">
                        <div class="email-header gray-bg">
                            <button type="button" class="btn btn-danger btn-sm waves close-button"><i class="fa fa-close"></i></button>
                            <h1>Edit Tabs</h1>
                        </div>
                        <div class="email-inner small-box">
                            <div class="email-inner-section">
                                <div class="small-box todo-list fade in" id="tab-tabs">
									<form id="submitTabs" onsubmit="submitTabs(this); return false;">
										<div class="sort-todo">
											<button id="newtab" type="button" class="btn waves btn-labeled btn-success btn-sm text-uppercase waves-effect waves-float" onclick="addTab()">
												<span class="btn-label"><i class="fa fa-plus"></i></span><?php echo translate("NEW_TAB");?>
											</button>
											<button id="iconHide" type="button" class="btn waves btn-labeled btn-warning btn-sm text-uppercase waves-effect waves-float">
												<span class="btn-label"><i class="fa fa-upload"></i></span><?php echo $language->translate("UPLOAD_ICONS");?>
											</button>
											<button id="iconAll" type="button" class="btn waves btn-labeled btn-info btn-sm text-uppercase waves-effect waves-float">
												<span class="btn-label"><i class="fa fa-picture-o"></i></span><?php echo $language->translate("VIEW_ICONS");?>
											</button>
           <button id="checkFrame" data-toggle="modal" data-target=".checkFrame" type="button" class="btn waves btn-labeled btn-gray btn-sm text-uppercase waves-effect waves-float">
												<span class="btn-label"><i class="fa fa-check"></i></span><?php echo $language->translate("CHECK_FRAME");?>
											</button>
											<button type="submit" class="btn waves btn-labeled btn-success btn btn-sm pull-right text-uppercase waves-effect waves-float">
												<span class="btn-label"><i class="fa fa-floppy-o"></i></span><?php echo translate('SAVE_TABS'); ?>
											</button>
										</div>
										<input type="file" name="files[]" id="uploadIcons" multiple="multiple">
										<div id="viewAllIcons" style="display: none;">
											<h4><strong><?php echo $language->translate("ALL_ICONS");?></strong> [<?php echo $language->translate("CLICK_ICON");?>]</h4>
											<div class="row">
												<textarea id="copyTarget" class="hideCopy" style="left: -9999px; top: 0; position: absolute;"></textarea>                                           
<?php
$dirname = "images/";
$images = scandir($dirname);
$ignore = Array(".", "..", "favicon", "cache", "platforms", "._.DS_Store", ".DS_Store", "confused.png", "sowwy.png", "sort-btns", "loading.png", "titlelogo.png", "default.svg", "login.png", "no-np.png", "themes", "nadaplaying.jpg", "organizr-logo-h-d.png", "organizr-logo-h.png");
foreach($images as $curimg){
	if(!in_array($curimg, $ignore)) { ?>
												<div class="col-xs-2" style="width: 75px; height: 75px; padding-right: 0px;">    
													<a data-toggle="tooltip" data-placement="bottom" title="<?=$dirname.$curimg;?>" class="thumbnail" style="box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);">
														<img style="width: 50px; height: 50px;" src="<?=$dirname.$curimg;?>" alt="thumbnail" class="allIcons">
													</a>
												</div>
<?php 
	}
}
?>
											</div>
										</div>
										<div class="panel">
                                            <div class="panel-body todo">
                                                <ul class="list-group ui-sortable">
<?php
foreach($file_db->query('SELECT * FROM tabs ORDER BY `order` asc') as $key => $row) {
	if (!isset($row['id'])) { $row['id'] = $key + 1; }
	echo printTabRow($row);
}
?>
                                                </ul>
                                            </div>
										</div>
									</form>
<?php echo printTabRow(false); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="email-content color-box white-bg">
<?php
// Build Colour Settings
echo buildSettings(
	array(
		'title' => 'Appearance Settings',
		'id' => 'appearance_settings',
		'submitAction' => 'update-appearance',
		'tabs' => array(
			array(
				'title' => 'Colours',
				'id' => 'theme_colours',
				'image' => 'images/paint.png',
				'fields' => array(
					array(
						array(
							'type' => 'button',
							'labelTranslate' => 'CHOOSE_THEME',
							'icon' => 'css3',
							'id' => 'themeSelector',
							'buttonType' => 'dark',
							'buttonDrop' => '
		<ul class="dropdown-menu gray-bg">
			<li class="chooseTheme" id="plexTheme" style="border: 1px #FFFFFF; border-style: groove; background: #000000; border-radius: 5px; margin: 5px;"><a style="color: #E49F0C !important;" href="#">Plex<span><img class="themeImage" src="images/themes/plex.png"></span></a></li>
			<li class="chooseTheme" id="newPlexTheme" style="border: 1px #E5A00D; border-style: groove; background: #282A2D; border-radius: 5px; margin: 5px;"><a style="color: #E5A00D !important;" href="#">New Plex<span><img class="themeImage" src="images/themes/newplex.png"></span></a></li>
			<li class="chooseTheme" id="embyTheme" style="border: 1px #FFFFFF; border-style: groove; background: #212121; border-radius: 5px; margin: 5px;"><a style="color: #52B54B !important;" href="#">Emby<span><img class="themeImage" src="images/themes/emby.png"></span></a></li>
			<li class="chooseTheme" id="bookTheme" style="border: 1px #FFFFFF; border-style: groove; background: #3B5998; border-radius: 5px; margin: 5px;"><a style="color: #FFFFFF !important;" href="#">Facebook<span><img class="themeImage" src="images/themes/facebook.png"></span></a></li>
			<li class="chooseTheme" id="spaTheme" style="border: 1px #66BBAE; border-style: groove; background: #66BBAE; border-radius: 5px; margin: 5px;"><a style="color: #5B391E !important;" href="#">Spa<span><img class="themeImage" src="images/themes/spa.png"></span></a></li>
			<li class="chooseTheme" id="darklyTheme" style="border: 1px #464545; border-style: groove; background: #375A7F; border-radius: 5px; margin: 5px;"><a style="color: #FFFFFF !important;" href="#">Darkly<span><img class="themeImage" src="images/themes/darkly.png"></span></a></li>
			<li class="chooseTheme" id="slateTheme" style="border: 1px #58C0DE; border-style: groove; background: #272B30; border-radius: 5px; margin: 5px;"><a style="color: #C8C8C8 !important;" href="#">Slate<span><img class="themeImage" src="images/themes/slate.png"></span></a></li>
			<li class="chooseTheme" id="monokaiTheme" style="border: 1px #AD80FD; border-style: groove; background: #333333; border-radius: 5px; margin: 5px;"><a style="color: #66D9EF !important;" href="#">Monokai<span><img class="themeImage" src="images/themes/monokai.png"></span></a></li>
			<li class="chooseTheme" id="thejokerTheme" style="border: 1px #CCC6CC; border-style: groove; background: #000000; border-radius: 5px; margin: 5px;"><a style="color: #CCCCCC !important;" href="#">The Joker<span><img class="themeImage" src="images/themes/joker.png"></span></a></li>
			<li class="chooseTheme" id="redTheme" style="border: 1px #eb6363; border-style: groove; background: #eb6363; border-radius: 5px; margin: 5px;"><a style="color: #FFFFFF !important;" href="#">Original Red<span><img class="themeImage" src="images/themes/original.png"></span></a></li>
		</ul>
							',
						),
					),
					array(
						'type' => 'header',
						'labelTranslate' => 'TITLE',
					),
					array(
						array(
							'type' => 'text',
							'format' => 'colour',
							'labelTranslate' => 'TITLE',
							'name' => 'title',
							'id' => 'title',
							'value' => $title,
						),
						array(
							'type' => 'text',
							'format' => 'colour',
							'class' => 'jscolor {hash:true}',
							'labelTranslate' => 'TITLE_TEXT',
							'name' => 'topbartext',
							'id' => 'topbartext',
							'value' => $topbartext,
						),
						array(
							'type' => 'text',
							'format' => 'colour',
							'class' => 'jscolor {hash:true}',
							'labelTranslate' => 'LOADING_COLOR',
							'name' => 'loading',
							'id' => 'loading',
							'value' => $loading,
						),
					),
					array(
						'type' => 'header',
						'labelTranslate' => 'NAVIGATION_BARS',
					),
					array(
						array(
							'type' => 'text',
							'format' => 'colour',
							'class' => 'jscolor {hash:true}',
							'labelTranslate' => 'TOP_BAR',
							'name' => 'topbar',
							'id' => 'topbar',
							'value' => $topbar,
						),
						array(
							'type' => 'text',
							'format' => 'colour',
							'class' => 'jscolor {hash:true}',
							'labelTranslate' => 'BOTTOM_BAR',
							'name' => 'bottombar',
							'id' => 'bottombar',
							'value' => $bottombar,
						),
						array(
							'type' => 'text',
							'format' => 'colour',
							'class' => 'jscolor {hash:true}',
							'labelTranslate' => 'SIDE_BAR',
							'name' => 'sidebar',
							'id' => 'sidebar',
							'value' => $sidebar,
						),
					),
					array(
						array(
							'type' => 'text',
							'format' => 'colour',
							'class' => 'jscolor {hash:true}',
							'labelTranslate' => 'HOVER_BG',
							'name' => 'hoverbg',
							'id' => 'hoverbg',
							'value' => $hoverbg,
						),
						array(
							'type' => 'text',
							'format' => 'colour',
							'class' => 'jscolor {hash:true}',
							'labelTranslate' => 'HOVER_TEXT',
							'name' => 'hovertext',
							'id' => 'hovertext',
							'value' => $hovertext,
						),
					),
					array(
						'type' => 'header',
						'labelTranslate' => 'ACTIVE_TAB',
					),
					array(
						array(
							'type' => 'text',
							'format' => 'colour',
							'class' => 'jscolor {hash:true}',
							'labelTranslate' => 'ACTIVE_TAB_BG',
							'name' => 'activetabBG',
							'id' => 'activetabBG',
							'value' => $activetabBG,
						),
						array(
							'type' => 'text',
							'format' => 'colour',
							'class' => 'jscolor {hash:true}',
							'labelTranslate' => 'ACTIVE_TAB_ICON',
							'name' => 'activetabicon',
							'id' => 'activetabicon',
							'value' => $activetabicon,
						),
						array(
							'type' => 'text',
							'format' => 'colour',
							'class' => 'jscolor {hash:true}',
							'labelTranslate' => 'ACTIVE_TAB_TEXT',
							'name' => 'activetabtext',
							'id' => 'activetabtext',
							'value' => $activetabtext,
						),
					),
					array(
						'type' => 'header',
						'labelTranslate' => 'INACTIVE_TAB',
					),
					array(
						array(
							'type' => 'text',
							'format' => 'colour',
							'class' => 'jscolor {hash:true}',
							'labelTranslate' => 'INACTIVE_ICON',
							'name' => 'inactiveicon',
							'id' => 'inactiveicon',
							'value' => $inactiveicon,
						),
						array(
							'type' => 'text',
							'format' => 'colour',
							'class' => 'jscolor {hash:true}',
							'labelTranslate' => 'INACTIVE_TEXT',
							'name' => 'inactivetext',
							'id' => 'inactivetext',
							'value' => $inactivetext,
						),
					),
				),
			),
			array(
				'title' => 'Custom CSS',
				'id' => 'theme_css',
				'image' => 'images/gear.png',
				'fields' => array(
					array(
						'type' => 'header',
						'label' => 'Custom CSS',
					),
					array(
						'type' => 'textarea',
						'name' => 'customCSS',
						'value' => (file_exists('./custom.css')?file_get_contents('./custom.css'):''),
						'rows' => 25,
						'style' => 'background: #000; color: #FFF;',
					),
				),
			),
		),
	)
);
?>
                </div>
                <div class="email-content homepage-box white-bg">
<?php
// Qualify most typical hostnames prior to form submission
$urlPattern = '([hH][tT][tT][pP][sS]?):\/\/([\w\.\-]{1,250})(?::(\d{1,5}))?((?:\/[^?.\s]+))?';

// Once configurable user groups is added change to select-multi to allow specific group selection
$userSelectType = 'select'; 
$userTypes = array(
	'None' => 'false',
	'User' => 'user|admin',
	'Admin' => 'admin',
);

// Build Homepage Settings
echo buildSettings(
	array(
		'title' => 'Homepage Settings',
		'id' => 'homepage_settings',
		'onready' => '',
		'tabs' => array(
			array(
				'title' => 'General',
				'id' => 'home_general',
				'image' => 'images/gear.png',
				'fields' => array(
					array(
						'type' => $userSelectType,
						'labelTranslate' => 'SHOW_HOMEPAGE',
						'name' => 'homePageAuthNeeded',
						'value' => HOMEPAGEAUTHNEEDED,
						'options' => $userTypes,
					),
    array(
        'type' => 'checkbox',
        'labelTranslate' => 'SPEED_TEST',
        'name' => 'speedTest',
        'value' => SPEEDTEST,
    ),
					/*
					array(
						'type' => 'custom',
						'labelTranslate' => 'SHOW_HOMEPAGE',
						'html' => 'homePageAuthNeeded',
						'name' => 'homePagelayout',
						'value' => '',
					),
					*/
				),
			),
			array(
				'title' => 'Plex',
				'id' => 'plex',
				'image' => 'images/plex.png',
				'fields' => array(
					array(
						'type' => $userSelectType,
						'labelTranslate' => 'SHOW_ON_HOMEPAGE',
						'name' => 'plexHomeAuth',
						'value' => PLEXHOMEAUTH,
						'options' => $userTypes,
					),
					array(
						'type' => 'text',
						'placeholder' => 'http://hostname:32400',
						'labelTranslate' => 'PLEX_URL',
						'assist' => 'http://hostname:32400',
						'name' => 'plexURL',
						'pattern' => $urlPattern,
						'value' => PLEXURL,
					),
					array(
						'type' => 'text',
						'placeholder' => randString(20),
						'labelTranslate' => 'PLEX_TOKEN',
						'name' => 'plexToken',
						'pattern' => '[a-zA-Z0-9]{20}',
						'value' => PLEXTOKEN,
					),
					array(
						'type' => 'custom',
						'html' => '<a href="https://support.plex.tv/hc/en-us/articles/204059436-Finding-an-authentication-token-X-Plex-Token">Plex Token Wiki Article</a>',
					),
					array(
						array(
							'type' => 'checkbox',
							'labelTranslate' => 'RECENT_MOVIES',
							'name' => 'plexRecentMovie',
							'value' => PLEXRECENTMOVIE,
						),
						array(
							'type' => 'checkbox',
							'labelTranslate' => 'RECENT_TV',
							'name' => 'plexRecentTV',
							'value' => PLEXRECENTTV,
						),
						array(
							'type' => 'checkbox',
							'labelTranslate' => 'RECENT_MUSIC',
							'name' => 'plexRecentMusic',
							'value' => PLEXRECENTMUSIC,
						),
						array(
							'type' => 'checkbox',
							'labelTranslate' => 'PLAYING_NOW',
							'name' => 'plexPlayingNow',
							'value' => PLEXPLAYINGNOW,
						),
      array(
							'type' => 'checkbox',
							'labelTranslate' => 'SHOW_NAMES',
							'name' => 'plexShowNames',
							'value' => PLEXSHOWNAMES,
						),
					),
				),
			),
			array(
				'title' => 'Emby',
				'id' => 'emby',
				'image' => 'images/emby.png',
				'fields' => array(
					array(
						'type' => $userSelectType,
						'labelTranslate' => 'SHOW_ON_HOMEPAGE',
						'name' => 'embyHomeAuth',
						'value' => EMBYHOMEAUTH,
						'options' => $userTypes,
					),
					array(
						'type' => 'text',
						'placeholder' => 'http://hostname:8096/emby',
						'labelTranslate' => 'EMBY_URL',
						'assist' => 'http://hostname:8096 | https://hostname/emby | http://hostname:8096/emby',
						'name' => 'embyURL',
						'pattern' => $urlPattern,
						'value' => EMBYURL,
					),
					array(
						'type' => 'text',
						'placeholder' => randString(32),
						'labelTranslate' => 'EMBY_TOKEN',
						'name' => 'embyToken',
						'pattern' => '[a-zA-Z0-9]{32}',
						'value' => EMBYTOKEN,
					),
					array(
						array(
							'type' => 'checkbox',
							'labelTranslate' => 'RECENT_MOVIES',
							'name' => 'embyRecentMovie',
							'value' => EMBYRECENTMOVIE,
						),
						array(
							'type' => 'checkbox',
							'labelTranslate' => 'RECENT_TV',
							'name' => 'embyRecentTV',
							'value' => EMBYRECENTTV,
						),
						array(
							'type' => 'checkbox',
							'labelTranslate' => 'RECENT_MUSIC',
							'name' => 'embyRecentMusic',
							'value' => EMBYRECENTMUSIC,
						),
						array(
							'type' => 'checkbox',
							'labelTranslate' => 'PLAYING_NOW',
							'name' => 'embyPlayingNow',
							'value' => EMBYPLAYINGNOW,
						),
					),
				),
			),
			array(
				'title' => 'Sonarr',
				'id' => 'sonarr',
				'image' => 'images/sonarr.png',
				'fields' => array(
					array(
						'type' => $userSelectType,
						'labelTranslate' => 'SHOW_ON_HOMEPAGE',
						'name' => 'sonarrHomeAuth',
						'value' => SONARRHOMEAUTH,
						'options' => $userTypes,
					),
					array(
						'type' => 'text',
						'placeholder' => 'http://hostname:8989',
						'labelTranslate' => 'SONARR_URL',
						'assist' => 'http://hostname:8989 | hostname/sonarr | http://hostname:8989/sonarr',
						'name' => 'sonarrURL',
						'pattern' => $urlPattern,
						'value' => SONARRURL,
					),
					array(
						'type' => 'text',
						'placeholder' => randString(32),
						'labelTranslate' => 'SONARR_KEY',
						'name' => 'sonarrKey',
						'pattern' => '[a-zA-Z0-9]{32}',
						'value' => SONARRKEY,
					),
				),
			),
			array(
				'title' => 'Radarr',
				'id' => 'radarr',
				'image' => 'images/radarr.png',
				'fields' => array(
					array(
						'type' => $userSelectType,
						'labelTranslate' => 'SHOW_ON_HOMEPAGE',
						'name' => 'radarrHomeAuth',
						'value' => RADARRHOMEAUTH,
						'options' => $userTypes,
					),
					array(
						'type' => 'text',
						'placeholder' => 'http://hostname:7878',
						'labelTranslate' => 'RADARR_URL',
						'assist' => 'http://hostname:7878 | hostname/radarr | http://hostname:7878/radarr',
						'name' => 'radarrURL',
						'pattern' => $urlPattern,
						'value' => RADARRURL,
					),
					array(
						'type' => 'text',
						'placeholder' => randString(32),
						'labelTranslate' => 'RADARR_KEY',
						'name' => 'radarrKey',
						'pattern' => '[a-zA-Z0-9]{32}',
						'value' => RADARRKEY,
					),
				),
			),
			array(
				'title' => 'Sickbeard/Sickrage',
				'id' => 'sick',
				'image' => 'images/sickrage.png',
				'fields' => array(
					array(
						'type' => $userSelectType,
						'labelTranslate' => 'SHOW_ON_HOMEPAGE',
						'name' => 'sickrageHomeAuth',
						'value' => SICKRAGEHOMEAUTH,
						'options' => $userTypes,
					),
					array(
						'type' => 'text',
						'placeholder' => 'http://hostname:8081/sick',
						'labelTranslate' => 'SICK_URL',
						'assist' => 'http://hostname:8081 | hostname/sick | http://hostname:8081/sick',
						'name' => 'sickrageURL',
						'pattern' => $urlPattern,
						'value' => SICKRAGEURL,
					),
					array(
						'type' => 'text',
						'placeholder' => randString(32),
						'labelTranslate' => 'SICK_KEY',
						'name' => 'sickrageKey',
						'value' => SICKRAGEKEY,
					),
				),
			),
			array(
				'title' => 'Headphones',
				'id' => 'headphones',
				'image' => 'images/headphones.png',
				'fields' => array(
					array(
						'type' => $userSelectType,
						'labelTranslate' => 'SHOW_ON_HOMEPAGE',
						'name' => 'headphonesHomeAuth',
						'value' => HEADPHONESHOMEAUTH,
						'options' => $userTypes,
					),
					array(
						'type' => 'text',
						'placeholder' => 'http://hostname:8181',
						'labelTranslate' => 'HEADPHONES_URL',
						'assist' => 'http://hostname:8181',
						'name' => 'headphonesURL',
						'pattern' => $urlPattern,
						'value' => HEADPHONESURL,
					),
					array(
						'type' => 'text',
						'placeholder' => randString(32),
						'labelTranslate' => 'HEADPHONES_KEY',
						'name' => 'headphonesKey',
						'value' => HEADPHONESKEY,
					),
				),
			),
			array(
				'title' => 'Sabnzbd',
				'id' => 'sabnzbd',
				'image' => 'images/sabnzbd.png',
				'fields' => array(
					array(
						'type' => $userSelectType,
						'labelTranslate' => 'SHOW_ON_HOMEPAGE',
						'name' => 'sabnzbdHomeAuth',
						'value' => SABNZBDHOMEAUTH,
						'options' => $userTypes,
					),
					array(
						'type' => 'text',
						'placeholder' => 'http://hostname:8080/sabnzbd',
						'labelTranslate' => 'SABNZBD_URL',
						'assist' => 'http://hostname:8080 | http://hostname/sabnzbd | http://hostname:8080/sabnzbd',
						'name' => 'sabnzbdURL',
						'pattern' => $urlPattern,
						'value' => SABNZBDURL,
					),
					array(
						'type' => 'text',
						'placeholder' => randString(32),
						'labelTranslate' => 'SABNZBD_KEY',
						'name' => 'sabnzbdKey',
						'value' => SABNZBDKEY,
					),
				),
			),
			array(
				'title' => 'nzbGET',
				'id' => 'nzbget',
				'image' => 'images/nzbget.png',
				'fields' => array(
					array(
						'type' => $userSelectType,
						'labelTranslate' => 'SHOW_ON_HOMEPAGE',
						'name' => 'nzbgetHomeAuth',
						'value' => NZBGETHOMEAUTH,
						'options' => $userTypes,
					),
					array(
						'type' => 'text',
						'placeholder' => 'http://hostname:6789',
						'labelTranslate' => 'NZBGET_URL',
						'assist' => 'http://hostname:6789',
						'name' => 'nzbgetURL',
						'pattern' => $urlPattern,
						'value' => NZBGETURL,
					),
					array(
						'type' => 'text',
						'labelTranslate' => 'USERNAME',
						'name' => 'nzbgetUsername',
						'value' => NZBGETUSERNAME,
					),
					array(
						'type' => 'password',
						'labelTranslate' => 'PASSWORD',
						'name' => 'nzbgetPassword',
						'value' => (empty(NZBGETPASSWORD)?'':randString(20)),
					),
				),
			),
			array(
				'title' => 'Calendar',
				'id' => 'calendar',
				'image' => 'images/calendar.png',
				'fields' => array(
					array(
						'type' => 'select',
						'labelTranslate' => 'CALENDAR_START_DAY',
						'name' => 'calendarStart',
						'value' => CALENDARSTART,
						'options' => array(
							explode('|', translate('DAYS'))[0] => '0',
							explode('|', translate('DAYS'))[1] => '1',
							explode('|', translate('DAYS'))[2] => '2',
							explode('|', translate('DAYS'))[3] => '3',
							explode('|', translate('DAYS'))[4] => '4',
							explode('|', translate('DAYS'))[5] => '5',
							explode('|', translate('DAYS'))[6] => '6',
						),
					),
					array(
						'type' => 'select',
						'labelTranslate' => 'DEFAULT',
						'name' => 'calendarView',
						'value' => CALENDARVIEW,
						'options' => array(
							translate('MONTH') => 'month',
							translate('DAY') => 'basicDay',
							translate('WEEK') => 'basicWeek',
						),
					),
					array(
						'type' => 'select',
						'labelTranslate' => 'CALTIMEFORMAT',
						'name' => 'calTimeFormat',
						'value' => CALTIMEFORMAT,
						'options' => array(
							'6p' => 'h(:mm)t',
							'6:00p' => 'h:mmt',
							'6:00' => 'h:mm',
							'18' => 'H(:mm)',
							'18:00' => 'H:mm',
						),
					),
					array(
						'type' => 'number',
						'placeholder' => '10',
						'labelTranslate' => 'CALENDAR_START_DATE',
						'name' => 'calendarStartDay',
						'pattern' => '[1-9][0-9]+',
						'value' => CALENDARSTARTDAY,
					),
					array(
						'type' => 'number',
						'placeholder' => '10',
						'labelTranslate' => 'CALENDAR_END_DATE',
						'name' => 'calendarEndDay',
						'pattern' => '[1-9][0-9]+',
						'value' => CALENDARENDDAY,
					),
				),
			),
   array(
				'title' => 'Notice',
				'id' => 'notice',
				'image' => 'images/pin.png',
				'fields' => array(
					array(
						'type' => $userSelectType,
						'labelTranslate' => 'SHOW_ON_HOMEPAGE',
						'name' => 'homepageNoticeAuth',
						'value' => HOMEPAGENOTICEAUTH,
						'options' => $userTypes,
					),
     array(
						'type' => $userSelectType,
						'labelTranslate' => 'NOTICE_LAYOUT',
						'name' => 'homepageNoticeLayout',
						'value' => HOMEPAGENOTICELAYOUT,
						'options' => array(
         'Elegant' => 'elegant',
         'Basic' => 'basic',
         'Jumbotron' => 'jumbotron',
        ),
					),
     array(
						'type' => $userSelectType,
						'labelTranslate' => 'NOTICE_COLOR',
						'name' => 'homepageNoticeType',
						'value' => HOMEPAGENOTICETYPE,
						'options' => array(
         'Green' => 'success',
         'Blue' => 'primary',
         'Gray' => 'gray',
         'Red' => 'danger',
         'Yellow' => 'warning',
         'Light Blue' => 'info',
        ),
					),
     array(
						'type' => 'text',
						'labelTranslate' => 'NOTICE_TITLE',
						'name' => 'homepageNoticeTitle',
						'value' => HOMEPAGENOTICETITLE,
					),
					array(
						'type' => 'textarea',
						'labelTranslate' => 'NOTICE_MESSAGE',
						'name' => 'homepageNoticeMessage',
						'value' => HOMEPAGENOTICEMESSAGE,
      'rows' => 5,
						'class' => 'material no-code',
					),
				),
			),
			array(
				'title' => 'Custom HTML 1',
				'id' => 'customhtml1',
				'image' => 'images/gear.png',
				'fields' => array(
					array(
						'type' => $userSelectType,
						'labelTranslate' => 'SHOW_ON_HOMEPAGE',
						'name' => 'homepageCustomHTML1Auth',
						'value' => HOMEPAGECUSTOMHTML1AUTH,
						'options' => $userTypes,
					),
					array(
						'type' => 'textarea',
						'labelTranslate' => 'CUSTOMHTML',
						'name' => 'homepageCustomHTML1',
						'value' => HOMEPAGECUSTOMHTML1,
						'rows' => 15,
						'style' => 'background: #000; color: #FFF;',
					),
				),
			),
		),
	)
);
?>
                </div>
                <div class="email-content advanced-box white-bg">
<?php
$backendOptions = array();
foreach (array_filter(get_defined_functions()['user'],function($v) { return strpos($v, 'plugin_auth_') === 0; }) as $value) {
	$name = str_replace('plugin_auth_','',$value);
	if (strpos($name, 'disabled') === false) {
		$backendOptions[ucwords(str_replace('_',' ',$name))] = $name;
	} else {
		$backendOptions[$value()] = array(
			'value' => randString(),
			'disabled' => true,
		);
	}
}
ksort($backendOptions);

echo buildSettings(
	array(
		'title' => 'Advanced Settings',
		'id' => 'advanced_settings',
		'onready' => '$(\'#authType_id\').trigger(\'change\')',
		'tabs' => array(
			array(
				'title' => 'Backend Authentication',
				'id' => 'be_auth',
				'image' => 'images/security.png',
				'fields' => array(
					array(
						'type' => 'select',
						'labelTranslate' => 'AUTHTYPE',
						'name' => 'authType',
						'value' => AUTHTYPE,
						'onchange' => 'if (this.value == \'internal\') { $(\'.be-auth, #authBackend_id, #authBackendCreate_id\').parent().hide(); } else { $(\'#authBackend_id, #authBackendCreate_id\').trigger(\'change\').parent().show(); }',
						'options' => array(
							'Organizr' => 'internal',
							'Organizr & Backend' => 'both',
							// 'Backend' => 'external',
						),
					),
					array(
						'type' => 'select',
						'labelTranslate' => 'AUTHBACKEND',
						'name' => 'authBackend',
						'onchange' => '$(\'.be-auth\').each(function() { $(this).parent().hide(); }); $(\'.be-auth-\'+this.value).each(function() { $(this).parent().show(); });',
						'value' => AUTHBACKEND,
						'options' => $backendOptions,
					),
					array(
						'type' => 'select',
						'labelTranslate' => 'AUTHBACKENDCREATE',
						'name' => 'authBackendCreate',
						'value' => AUTHBACKENDCREATE,
						'options' => array(
							translate('YES_CREATE') => 'true',
							translate('NO_CREATE') => 'false',
						),
					),
					array(
						'type' => 'text',
						'placeholder' => 'http://hostname:8181',
						'labelTranslate' => 'AUTHBACKENDHOST',
						'assist' => 'http(s)://hostname:8181 | Ldap(s)://localhost:389 | ftp(s)://localhost:21',
						'name' => 'authBackendHost',
						'class' => 'be-auth be-auth-ftp be-auth-ldap',
						'pattern' => '((?:[hH][tT][tT][pP]|[lL][dD][aA][pP]|[fF][tT][pP])[sS]?):\/\/([\w\.]{1,250})(?::(\d{1,5}))?((?:\/[^?.\s]+))?',
						'value' => AUTHBACKENDHOST,
					),
					array(
						'type' => 'text',
						'placeholder' => 'domain',
						'labelTranslate' => 'AUTHBACKENDDOMAIN',
						'name' => 'authBackendDomain',
						'class' => 'be-auth be-auth-ldap',
						'value' => AUTHBACKENDDOMAIN,
					),
					array(
						'type' => 'text',
						'placeholder' => 'http://hostname:8096/emby',
						'labelTranslate' => 'EMBY_URL',
						'assist' => 'http://hostname:8096 | https://hostname/emby | http://hostname:8096/emby',
						'class' => 'be-auth be-auth-emby_local be-auth-emby_all be-auth-emby_connect',
						'name' => 'embyURL',
						'pattern' => $urlPattern,
						'value' => EMBYURL,
					),
					array(
						'type' => 'text',
						'placeholder' => randString(32),
						'labelTranslate' => 'EMBY_TOKEN',
						'name' => 'plexToken',
						'class' => 'be-auth be-auth-emby_all be-auth-emby_connect',
						'pattern' => '[a-zA-Z0-9]{32}',
						'value' => EMBYTOKEN,
					),
					array(
						'type' => 'text',
						'labelTranslate' => 'PLEX_USERNAME',
						'name' => 'plexUsername',
						'class' => 'be-auth be-auth-plex',
						'value' => PLEXUSERNAME,
					),
					array(
						'type' => 'password',
						'labelTranslate' => 'PLEX_PASSWORD',
						'name' => 'plexPassword',
						'class' => 'be-auth be-auth-plex',
						'value' => (empty(PLEXPASSWORD)?'':randString(20)),
					),
				),
			),
			array(
				'title' => 'Super Advanced',
				'id' => 'super_advanced',
				'image' => 'images/gear.png',
				'fields' => array(
					array(
						'type' => 'text',
						'placeholder' => '/home/www-data/',
						'labelTranslate' => 'DATABASE_PATH',
						'name' => 'database_Location',
						'value' => DATABASE_LOCATION,
					),
					array(
						'type' => 'select',
						'labelTranslate' => 'SET_TIMEZONE',
						'name' => 'timezone',
						'value' => TIMEZONE,
						'options' => timezoneOptions(),
					),
					array(
						'type' => 'text',
						'labelTranslate' => 'REGISTER_PASSWORD',
						'name' => 'registerPassword',
						'value' => REGISTERPASSWORD,
					),
					array(
						'type' => 'text',
						'labelTranslate' => 'COOKIE_DOMAIN',
						'name' => 'domain',
						'value' => DOMAIN,
					),
					array(
						'type' => 'password',
						'labelTranslate' => 'COOKIE_PASSWORD',
						'name' => 'cookiePassword',
						'value' => (empty(COOKIEPASSWORD)?'':randString(20)),
					),
					array(
						'type' => 'text',
						'labelTranslate' => 'GIT_BRANCH',
						'placeholder' => 'Default: \'master\' - Development: \'develop\' OR \'cero-dev\'',
						'id' => 'git_branch_id',
						'name' => 'git_branch',
						'value' => GIT_BRANCH,
					),
					array(
						array(
							'type' => 'checkbox',
							'labelTranslate' => 'GIT_CHECK',
							'name' => 'git_check',
							'value' => GIT_CHECK,
						),
						array(
							'type' => 'button',
							'id' => 'gitForceInstall',
							'labelTranslate' => 'GIT_FORCE',
							'icon' => 'gear',
							'onclick' => 'if ($(\'#git_branch_id[data-changed]\').length) { alert(\'Branch was altered, save settings first!\') } else { if (confirm(\''.translate('GIT_FORCE_CONFIRM').'\')) { ajax_request(\'POST\', \'forceBranchInstall\'); } }',
						),
					),
					array(
						'type' => 'checkbox',
						'labelTranslate' => 'MULTIPLE_LOGINS',
						'name' => 'multipleLogin',
						'value' => MULTIPLELOGIN,
					),
				),
			),
			array(
				'title' => 'Mail Settings',
				'id' => 'mail_settings',
				'image' => 'images/mail.png',
				'fields' => array(
					array(
						'type' => 'text',
						'placeholder' => 'mail.provider.com',
						'labelTranslate' => 'SMTP_HOST',
						'name' => 'smtpHost',
						'pattern' => '([\w\.\-]{1,250})',
						'value' => SMTPHOST,
					),
					array(
						'type' => 'number',
						'placeholder' => '465',
						'labelTranslate' => 'SMTP_HOST_PORT',
						'name' => 'smtpHostPort',
						'value' => SMTPHOSTPORT,
					),
					array(
						'type' => 'text',
						'labelTranslate' => 'SMTP_HOST_USERNAME',
						'name' => 'smtpHostUsername',
						'value' => SMTPHOSTUSERNAME,
					),
					array(
						'type' => 'password',
						'labelTranslate' => 'SMTP_HOST_PASSWORD',
						'name' => 'smtpHostPassword',
						'value' => (empty(SMTPHOSTPASSWORD)?'':randString(20)),
					),
					array(
						'type' => 'text',
						'labelTranslate' => 'SMTP_HOST_SENDER_NAME',
						'name' => 'smtpHostSenderName',
						'value' => SMTPHOSTSENDERNAME,
					),
					array(
						'type' => 'text',
						'labelTranslate' => 'SMTP_HOST_SENDER_EMAIL',
						'name' => 'smtpHostSenderEmail',
						'value' => SMTPHOSTSENDEREMAIL,
					),
                    array(
						'type' => 'select',
						'labelTranslate' => 'SMTP_HOST_AUTH',
						'name' => 'smtpHostType',
						'value' => SMTPHOSTTYPE,
						'options' => array(
							'ssl' => 'ssl',
							'tls' => 'tls',
						),
					),
					array(
						array(
							'type' => 'checkbox',
							'labelTranslate' => 'SMTP_HOST_AUTH',
							'name' => 'smtpHostAuth',
							'value' => SMTPHOSTAUTH,
						),
						array(
							'type' => 'checkbox',
							'labelTranslate' => 'ENABLE_MAIL',
							'name' => 'enableMail',
							'value' => ENABLEMAIL,
						),
					),
				),
			),
			array(
				'title' => 'Advanced Visual',
				'id' => 'advanced_visual',
				'image' => 'images/paint.png',
				'fields' => array(
					array(
						'type' => 'text',
						'placeholder' => 'images/organizr.png',
						'labelTranslate' => 'LOADING_ICON_URL',
						'name' => 'loadingIcon',
						'value' => LOADINGICON,
					),
					array(
						'type' => 'text',
						'placeholder' => 'images/organizr.png',
						'labelTranslate' => 'LOGO_URL_TITLE',
						'name' => 'titleLogo',
						'value' => TITLELOGO,
					),
					array(
						'type' => 'select',
						'labelTranslate' => 'NOTIFICATION_TYPE',
						'name' => 'notifyEffect',
						'onchange' => 'parent.notify(\'This is an example popup!\', \'bullhorn\', \'success\', 4000, this.value.split(\'-\')[0], this.value.split(\'-\')[1]);',
						'value' => NOTIFYEFFECT,
						'options' => array(
							'Slide From Top' => 'bar-slidetop',
							'Exploader From Top' => 'bar-exploader',
							'Flip' => 'attached-flip',
							'Bouncy Flip' => 'attached-bouncyflip',
							'Growl Scale' => 'growl-scale',
							'Growl Genie' => 'growl-genie',
							'Growl Jelly' => 'growl-jelly',
							'Growl Slide' => 'growl-slide',
							'Spinning Box' => 'other-boxspinner',
							'Sliding' => 'other-thumbslider',
						),
					),
					array(
						array(
							'type' => 'checkbox',
							'labelTranslate' => 'ENABLE_LOADING_SCREEN',
							'name' => 'loadingScreen',
							'value' => LOADINGSCREEN,
						),
						array(
							'type' => 'checkbox',
							'labelTranslate' => 'ENABLE_SLIMBAR',
							'name' => 'slimBar',
							'value' => SLIMBAR,
						),
						array(
							'type' => 'checkbox',
							'labelTranslate' => 'GRAVATAR',
							'name' => 'gravatar',
							'value' => GRAVATAR,
						),
					),
				),
			),
		),
	)
);
?>
                </div>
                <div class="email-content donate-box white-bg">
                    <div class="email-body">
                        <div class="email-header gray-bg">
                            <button type="button" class="btn btn-danger btn-sm waves close-button"><i class="fa fa-close"></i></button>
                            <h1>Donate To Organizr</h1>
                        </div>
                        <div class="email-inner small-box">
                            <div class="email-inner-section">
                                <div class="small-box fade in" id="donate-org">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="big-box">
                                                <div class="jumbotron">
                                                    <div class="container">
                                                        <h2><strong>Hey There <em class="gray"><?php echo ucwords($USER->username);?></em>,</strong></h2>
                                                        <br/>
                                                        <small>I had always said that I wouldn't take any donations for my work but some situations have changed in my life.  By no means does anyone need to donate but if you choose to help out and show appreciation I would surely appreciate that very much.  I do all of this for everyone and because I'm happy when i do it :)</small>
                                                        <br/><br/>
                                                        <small>I just want to take this time to thank you for even visiting this section of Organizr.  Just by you clicking into this area makes me happy.  Even the fact that you are still reading this makes me happy.  I bet now you are wondering, why am I even still reading this...  LOL, don't worry, I'm kinda laughing as I am typing this.  Anywho, thank you for reading along and I hope you enjoy the rest of your day.</small>
                                                        <br/><br/>
                                                        <p class="pull-right"><i class="fa fa-heart fa-1x red loop-animation animated pulse" aria-hidden="true"></i> CauseFX</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6 col-lg-6">
                                            <div class="content-box ultra-widget blue-bg" style="cursor: pointer;" onclick="window.open('https://paypal.me/causefx', '_blank')">
                                                <div class="w-content big-box">
                                                    <div class="w-progress">
                                                        <span class="w-amount">PayPal</span>
                                                        <br>
                                                        <span class="text-uppercase w-name">Donate with PayPal</span>
                                                    </div>
                                                    <span class="w-refresh w-p-icon">
                                                        <span class="fa-stack fa-lg">
                                                            <i class="fa fa-square fa-stack-2x"></i>
                                                            <i class="fa fa-paypal blue fa-stack-1x fa-inverse"></i>
                                                        </span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-lg-6">
                                            <div class="content-box ultra-widget green-bg" style="cursor: pointer;" onclick="window.open('https://cash.me/$causefx', '_blank')">
                                                <div class="w-content big-box">
                                                    <div class="w-progress">
                                                        <span class="w-amount">Square</span>
                                                        <br>
                                                        <span class="text-uppercase w-name">Donate with Square Cash</span>
                                                    </div>
                                                    <span class="w-refresh w-p-icon">
                                                        <span class="fa-stack fa-lg">
                                                            <i class="fa fa-square fa-stack-2x"></i>
                                                            <i class="fa fa-dollar green fa-stack-1x fa-inverse"></i>
                                                        </span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="email-content info-box white-bg">
                    <div class="email-body">
                        <div class="email-header gray-bg">
                            <button type="button" class="btn btn-danger btn-sm waves close-button"><i class="fa fa-close"></i></button>
                            <h1>About Organizr</h1>
                        </div>
                        <div class="email-inner small-box">
                            <div class="email-inner-section">
                                <div class="small-box fade in" id="about">
                                    <h4><img src="images/organizr-logo-h-d.png" height="50px"></h4>
                                    <p id="version"></p>
                                    <p id="submitFeedback">
                                        <a href='https://reddit.com/r/organizr' target='_blank' type='button' style="background: #AD80FD" class='btn waves btn-labeled btn-success btn text-uppercase waves-effect waves-float'><span class='btn-label'><i class='fa fa-reddit'></i></span>SUBREDDIT</a> 
                                        <a href='https://github.com/causefx/Organizr/issues/new' target='_blank' type='button' class='btn waves btn-labeled btn-success btn text-uppercase waves-effect waves-float'><span class='btn-label'><i class='fa fa-github-alt'></i></span><?php echo $language->translate("SUBMIT_ISSUE");?></a> 
                                        <a href='https://github.com/causefx/Organizr' target='_blank' type='button' class='btn waves btn-labeled btn-primary btn text-uppercase waves-effect waves-float'><span class='btn-label'><i class='fa fa-github'></i></span><?php echo $language->translate("VIEW_ON_GITHUB");?></a>
                                        <a href='https://gitter.im/Organizrr/Lobby' target='_blank' type='button' class='btn waves btn-labeled btn-dark btn text-uppercase waves-effect waves-float'><span class='btn-label'><i class='fa fa-comments-o'></i></span><?php echo $language->translate("CHAT_WITH_US");?></a>
                                        <button type="button" class="class='btn waves btn-labeled btn-warning btn text-uppercase waves-effect waves-float" data-toggle="modal" data-target=".Help-Me-modal-lg"><span class='btn-label'><i class='fa fa-life-ring'></i></span><?php echo $language->translate("HELP");?></button>
                                        <button id="deleteToggle" type="button" class="class='btn waves btn-labeled btn-danger btn text-uppercase waves-effect waves-float" ><span class='btn-label'><i class='fa fa-trash'></i></span><?php echo $language->translate("DELETE_DATABASE");?></button>
                                    </p>

                                    <div class="modal fade Help-Me-modal-lg" tabindex="-1" role="dialog">

                                        <div class="modal-dialog modal-lg" role="document">

                                            <div class="modal-content" style="color: <?php echo $topbartext;?> !important; background: <?php echo $topbar;?> !important;">

                                                <div class="modal-header">

                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

                                                    <h4 class="modal-title"><?php echo $language->translate("HELP");?>!</h4>

                                                </div>

                                                <div class="modal-body" style="background: <?php echo $sidebar;?> !important;">

                                                    <div style="margin-bottom: 0px;" class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

                                                        <div style="color: <?php echo $topbartext;?> !important; background: <?php echo $topbar;?> !important;" class="panel panel-default">

                                                            <div class="panel-heading" role="tab" id="headingOne">

                                                                <h4 class="panel-title" style="text-decoration: none;" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">

                                                                    <?php echo $language->translate("ADDING_TABS");?>

                                                                </h4>

                                                            </div>

                                                            <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne" aria-expanded="true">

                                                                <div class="panel-body">

                                                                    <p><?php echo $language->translate("START_ADDING_TABS");?></p>

                                                                    <ul>

                                                                        <li><strong><?php echo $language->translate("TAB_URL");?></strong> <?php echo $language->translate("TAB_URL_ABOUT");?></li>
                                                                        <li><strong><?php echo $language->translate("ICON_URL");?></strong> <?php echo $language->translate("ICON_URL_ABOUT");?></li>
                                                                        <li><strong><?php echo $language->translate("DEFAULT");?></strong> <?php echo $language->translate("DEFAULT_ABOUT");?></li>
                                                                        <li><strong><?php echo $language->translate("ACTIVE");?></strong> <?php echo $language->translate("ACTIVE_ABOUT");?></li>
                                                                        <li><strong><?php echo $language->translate("USER");?></strong> <?php echo $language->translate("USER_ABOUT");?></li>
                                                                        <li><strong><?php echo $language->translate("GUEST");?></strong> <?php echo $language->translate("GUEST_ABOUT");?></li>
                                                                        <li><strong><?php echo $language->translate("NO_IFRAME");?></strong> <?php echo $language->translate("NO_IFRAME_ABOUT");?></li>        

                                                                    </ul>

                                                                </div>

                                                            </div>

                                                        </div>

                                                        <div style="color: <?php echo $topbartext;?> !important; background: <?php echo $topbar;?> !important;" class="panel panel-default">

                                                            <div class="panel-heading" role="tab" id="headingTwo">

                                                                <h4 class="panel-title" style="text-decoration: none;" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">

                                                                    <?php echo $language->translate("QUICK_ACCESS");?>

                                                                </h4>

                                                            </div>

                                                            <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo" aria-expanded="true">

                                                                <div class="panel-body">

                                                                    <p><?php echo $language->translate("QUICK_ACCESS_ABOUT");?> <mark><?php echo getServerPath(); ?>#Sonarr</mark></p>

                                                                </div>

                                                            </div>

                                                        </div>

                                                        <div style="color: <?php echo $topbartext;?> !important; background: <?php echo $topbar;?> !important;" class="panel panel-default">

                                                            <div class="panel-heading" role="tab" id="headingThree">

                                                                <h4 class="panel-title" style="text-decoration: none;" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="true" aria-controls="collapseThree">

                                                                    <?php echo $language->translate("SIDE_BY_SIDE");?>

                                                                </h4>

                                                            </div>

                                                            <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree" aria-expanded="true">

                                                                <div class="panel-body">

                                                                    <p><?php echo $language->translate("SIDE_BY_SIDE_ABOUT");?></p>

                                                                    <ul>

                                                                        <li><?php echo $language->translate("SIDE_BY_SIDE_INSTRUCTIONS1");?></li>
                                                                        <li><?php echo $language->translate("SIDE_BY_SIDE_INSTRUCTIONS2");?> [<i class='mdi mdi-refresh'></i>]</li>
                                                                        <li><?php echo $language->translate("SIDE_BY_SIDE_INSTRUCTIONS3");?></li>

                                                                    </ul>

                                                                </div>

                                                            </div>

                                                        </div>

                                                        <div style="color: <?php echo $topbartext;?> !important; background: <?php echo $topbar;?> !important;" class="panel panel-default">

                                                            <div class="panel-heading" role="tab" id="headingFour">

                                                                <h4 class="panel-title" style="text-decoration: none;" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="true" aria-controls="collapseFour">

                                                                    <?php echo $language->translate("KEYBOARD_SHORTCUTS");?>

                                                                </h4>

                                                            </div>

                                                            <div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFour" aria-expanded="true">

                                                                <div class="panel-body">

                                                                    <p><?php echo $language->translate("KEYBOARD_SHORTCUTS_ABOUT");?></p>

                                                                    <ul>

                                                                        <li><keyboard class="key"><span>S</span></keyboard> + <keyboard class="key"><span>S</span></keyboard> <?php echo $language->translate("KEYBOARD_INSTRUCTIONS1");?></li>
                                                                        <li><keyboard class="key"><span>F</span></keyboard> + <keyboard class="key"><span>F</span></keyboard> <?php echo $language->translate("KEYBOARD_INSTRUCTIONS6");?></li>
                                                                        <li><keyboard class="key"><span>P</span></keyboard> + <keyboard class="key"><span>P</span></keyboard> <?php echo $language->translate("KEYBOARD_INSTRUCTIONS7");?></li>
                                                                        <li><keyboard class="key"><span>M</span></keyboard> + <keyboard class="key"><span>M</span></keyboard> <?php echo $language->translate("KEYBOARD_INSTRUCTIONS8");?></li>
                                                                        <li><keyboard class="key wide"><span>Ctrl</span></keyboard> + <keyboard class="key wide"><span>Shift</span></keyboard> + <keyboard class="key"><span>&darr;</span></keyboard> <?php echo $language->translate("KEYBOARD_INSTRUCTIONS2");?></li>
                                                                        <li><keyboard class="key wide"><span>Ctrl</span></keyboard> + <keyboard class="key wide"><span>Shift</span></keyboard> + <keyboard class="key"><span>&uarr;</span></keyboard> <?php echo $language->translate("KEYBOARD_INSTRUCTIONS3");?></li>
                                                                        <li><keyboard class="key wide"><span>Ctrl</span></keyboard> + <keyboard class="key wide"><span>Shift</span></keyboard> + <keyboard class="key"><span>1</span></keyboard> - <keyboard class="key"><span>9</span></keyboard> <?php echo $language->translate("KEYBOARD_INSTRUCTIONS5");?></li>
                                                                        <li><keyboard class="key wide"><span>Esc</span></keyboard> + <keyboard class="key wide"><span>Esc</span></keyboard> <?php echo $language->translate("KEYBOARD_INSTRUCTIONS4");?></li>


                                                                    </ul>

                                                                </div>

                                                            </div>

                                                        </div>

                                                        <div style="color: <?php echo $topbartext;?> !important; background: <?php echo $topbar;?> !important;" class="panel panel-default">

                                                            <div class="panel-heading" role="tab" id="headingFive">

                                                                <h4 class="panel-title" style="text-decoration: none;" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseFive" aria-expanded="true" aria-controls="collapseFive">

                                                                    <?php echo $language->translate("TAB_NOT_LOADING");?>

                                                                </h4>

                                                            </div>

                                                            <div id="collapseFive" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingFive" aria-expanded="true">

                                                                <div class="panel-body">

                                                                    <p><?php echo $language->translate("TAB_NOT_LOADING_ABOUT");?></p>

                                                                    <?php 
                                                                    if(get_browser_name() == "Chrome") : echo get_browser_name() . ": <a href='https://chrome.google.com/webstore/detail/ignore-x-frame-headers/gleekbfjekiniecknbkamfmkohkpodhe' target='_blank'><strong>Ignore X-Frame headers</strong> by Guillaume Ryder</a>";
                                                                    elseif(get_browser_name() == "Firefox") : echo get_browser_name() . ": <a href='https://addons.mozilla.org/en-us/firefox/addon/ignore-x-frame-options/' target='_blank'><strong>Ignore X-Frame headers</strong> by rjhoukema</a>";
                                                                    else : echo "Sorry, currently there is no other alternative for " . get_browser_name(); endif;
                                                                    ?>

                                                                </div>

                                                            </div>

                                                        </div>

                                                        <div style="color: <?php echo $topbartext;?> !important; background: <?php echo $topbar;?> !important;" class="panel panel-default">

                                                            <div class="panel-heading" role="tab" id="headingSix">

                                                                <h4 class="panel-title" style="text-decoration: none;" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseSix" aria-expanded="true" aria-controls="collapseSix">

                                                                    <?php echo $language->translate("USER_ICONS");?>

                                                                </h4>

                                                            </div>

                                                            <div id="collapseSix" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingSix" aria-expanded="true">

                                                                <div class="panel-body">

                                                                    <p><?php echo $language->translate("USER_ICONS_ABOUT");?> <a href="http://gravatar.com" target="_blank">gravatar.com</a></p>

                                                                </div>

                                                            </div>

                                                        </div>

                                                        <div style="color: <?php echo $topbartext;?> !important; background: <?php echo $topbar;?> !important;" class="panel panel-default">

                                                            <div class="panel-heading" role="tab" id="headingSeven">

                                                                <h4 class="panel-title" style="text-decoration: none;" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseSeven" aria-expanded="true" aria-controls="collapseSeven">

                                                                    <?php echo $language->translate("TRANSLATIONS");?>

                                                                </h4>

                                                            </div>

                                                            <div id="collapseSeven" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingSeven" aria-expanded="true">

                                                                <div class="panel-body">

                                                                    <p><?php echo $language->translate("TRANSLATIONS_ABOUT");?> <a href="https://github.com/causefx/Organizr/tree/develop/lang" target="_blank">Github Develop Branch</a></p>

                                                                </div>

                                                            </div>

                                                        </div>

                                                    </div>

                                                </div>

                                                <div class="modal-footer">

                                                    <button type="button" class="btn btn-default waves" data-dismiss="modal"><?php echo $language->translate("CLOSE");?></button>

                                                </div>

                                            </div>

                                        </div>

                                    </div>
                                    <p id="whatsnew"></p>
                                    <p id="downloadnow"></p>
                                    <div id="deleteDiv" style="display: none;" class="panel panel-danger">
                                        <div class="panel-heading">
                                            <h3 class="panel-title"><?php echo $language->translate("DELETE_DATABASE");?></h3>
                                        </div>
                                        <div class="panel-body">
                                            <div class="">
                                                <p><?php echo $language->translate("DELETE_WARNING");?></p>
                                                <form id="deletedb" method="post" onsubmit="ajax_request('POST', 'deleteDB'); return false;">
                                                    <button class="btn waves btn-labeled btn-danger pull-right text-uppercase waves-effect waves-float" type="submit">
                                                        <span class="btn-label"><i class="fa fa-trash"></i></span><?php echo $language->translate("DELETE_DATABASE");?>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="timeline-container">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <ul class="cbp_tmtimeline" id="versionHistory">
                                                </ul>
                                                <div class="btn-group-sm btn-group btn-group-justified">
                                                    <div id="loadMore" class="btn-group" role="group">
                                                        <button type="button" class="btn waves btn-primary waves-effect waves-float text-uppercase"><?php echo $language->translate("SHOW_MORE");?></button>
                                                    </div>
                                                    <div id="showLess" class="btn-group" role="group">
                                                        <button type="button" class="btn waves btn-warning waves-effect waves-float text-uppercase"><?php echo $language->translate("SHOW_LESS");?></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="email-content users-box white-bg">
                    <div class="email-body">
                        <div class="email-header gray-bg">
                            <button type="button" class="btn btn-danger btn-sm waves close-button"><i class="fa fa-close"></i></button>
                            <h1>Users Management</h1>
                        </div>
                        <div class="email-inner small-box">
                            <div class="email-inner-section">
                                <div class="small-box fade in" id="useredit">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="small-box">
                                                <form class="content-form form-inline" name="new user registration" id="registration" action="" method="POST">
                                                    <input type="hidden" name="op" value="register"/>
                                                    <input type="hidden" name="sha1" value=""/>
                                                    <input type="hidden" name="settings" value="true"/>

                                                    <div class="form-group">

                                                        <input type="text" class="form-control material" name="username" placeholder="<?php echo $language->translate("USERNAME");?>" autocorrect="off" autocapitalize="off" value="">

                                                    </div>

                                                    <div class="form-group">

                                                        <input type="email" class="form-control material" name="email" placeholder="<?php echo $language->translate("EMAIL");?>">

                                                    </div>

                                                    <div class="form-group">

                                                        <input type="password" class="form-control material" name="password1" placeholder="<?php echo $language->translate("PASSWORD");?>">

                                                    </div>

                                                    <div class="form-group">

                                                        <input type="password" class="form-control material" name="password2" placeholder="<?php echo $language->translate("PASSWORD_AGAIN");?>">

                                                    </div>
                                                    <button type="submit" onclick="User.processRegistration()" class="btn waves btn-labeled btn-primary btn btn-sm text-uppercase waves-effect waves-float promoteUser">

                                                        <span class="btn-label"><i class="fa fa-user-plus"></i></span><?php echo $language->translate("CREATE_USER");?>

                                                    </button>

                                                </form>               
                                            </div>
                                        </div>
                                    </div>
                                    <div class="small-box">
                                        <form class="content-form form-inline" name="unregister" id="unregister" action="" method="POST">
                                            
                                            <p id="inputUsername"></p>

                                            <div class="table-responsive">

                                                <table class="table table-striped">

                                                    <thead>

                                                        <tr>

                                                            <th>#</th>

                                                            <th><?php echo $language->translate("USERNAME");?></th>
                                                            <th><?php echo $language->translate("EMAIL");?></th>

                                                            <th><?php echo $language->translate("LOGIN_STATUS");?></th>

                                                            <th><?php echo $language->translate("LAST_SEEN");?></th>

                                                            <th><?php echo $language->translate("USER_GROUP");?></th>

                                                            <th><?php echo $language->translate("USER_ACTIONS");?></th>

                                                        </tr>

                                                    </thead>

                                                    <tbody>

                                                        <?php $countUsers = 1; 
                                                        foreach($gotUsers as $row) : 
                                                        if($row['role'] == "admin" && $countUsers == 1) : 
                                                            $userColor = "red";
                                                            $disableAction = "disabled=\"disabled\"";
                                                        else : 
                                                            $userColor = "blue";
                                                            $disableAction = "";
                                                        endif;
                                                        if($row['active'] == "true") : 
                                                            $userActive = $language->translate("LOGGED_IN");
                                                            $userActiveColor = "primary";
                                                        else : 
                                                            $userActive = $language->translate("LOGGED_OUT");
                                                            $userActiveColor = "danger";
                                                        endif;
                                                        $userpic = md5( strtolower( trim( $row['email'] ) ) );
                                                        if(!empty($row["last"])) : 
                                                           $lastActive = date("Y-m-d H:i", intval($row["last"]));
                                                        else :
                                                            $lastActive = "";
                                                        endif;
                                                        ?>

                                                        <tr id="<?=$row['username'];?>">

                                                            <th scope="row"><?=$countUsers;?></th>

                                                            <td><?php if(GRAVATAR == "true") : ?><i class="userpic"><img src="https://www.gravatar.com/avatar/<?=$userpic;?>?s=25&d=mm" class="img-circle"></i> &nbsp; <?php endif; ?><?=$row['username'];?></td>
                                                            <td><?=$row['email'];?></td>

                                                            <td><span class="label label-<?=$userActiveColor;?>"><?=$userActive;?></span></td>

                                                            <td><?=$lastActive;?></td>

                                                            <td><span class="text-uppercase <?=$userColor;?>"><?=$row['role'];?></span></td>

                                                            <td id="<?=$row['username'];?>">

                                                                <button <?=$disableAction;?> class="btn waves btn-labeled btn-danger btn btn-sm text-uppercase waves-effect waves-float deleteUser">

                                                                    <span class="btn-label"><i class="fa fa-user-times"></i></span><?php echo $language->translate("DELETE");?>

                                                                </button>
                                                                <?php if ($row['role'] == "user") : ?>
                                                                <button class="btn waves btn-labeled btn-success btn btn-sm text-uppercase waves-effect waves-float promoteUser">

                                                                    <span class="btn-label"><i class="fa fa-arrow-up"></i></span><?php echo $language->translate("PROMOTE");?>

                                                                </button>
                                                                <?php endif; ?>
                                                                <?php if ($row['role'] == "admin") : ?>
                                                                <button <?=$disableAction;?> class="btn waves btn-labeled btn-warning btn btn-sm text-uppercase waves-effect waves-float demoteUser">

                                                                    <span class="btn-label"><i class="fa fa-arrow-down"></i></span><?php echo $language->translate("DEMOTE");?>

                                                                </button>
                                                                <?php endif; ?>

                                                            </td>

                                                        </tr>

                                                        <?php $countUsers++; endforeach; ?>

                                                    </tbody>

                                                </table>

                                            </div>
                                        </form>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="email-content logs-box white-bg">
                    <div class="email-body">
                        <div class="email-header gray-bg">
                            <button type="button" class="btn btn-danger btn-sm waves close-button"><i class="fa fa-close"></i></button>
                            <h1>Logs</h1>
                        </div>
                        <div class="email-inner small-box">
                            <div class="email-inner-section">
                                <div class="small-box" id="loginlog">
                                    <div>
                                        <?php if(file_exists("org.log")){ ?>
                                        <button id="viewOrgLogs" class="btn waves btn-labeled gray-bg text-uppercase waves-effect waves-float" type="button"><span class="btn-label"><i class="fa fa-terminal"></i></span>Organizr Log </button>
                                        <?php } if(file_exists(FAIL_LOG)){ ?>
                                        <button id="viewLoginLogs" class="btn waves btn-labeled grayish-blue-bg text-uppercase waves-effect waves-float" type="button" style="display: none"><span class="btn-label"><i class="fa fa-user"></i></span>Login Log </button>
                                        <?php } ?>
                                    </div>
                                    
                                    <?php if(file_exists("org.log")){ ?>
                                    <div id="orgLogTable" class="table-responsive" style="display: none">
                                        <table id="orgLogs" class="display">
                                            <thead>
                                                <tr>
                                                    <th><?php echo $language->translate("DATE");?></th>
                                                    <th><?php echo $language->translate("STATUS");?></th>
                                                    <th><?php echo $language->translate("TYPE");?></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                 <?php readLog(); ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <?php } ?>

                                    <div id="loginTable" class="table-responsive">

                                        <?php if(file_exists(FAIL_LOG)){ ?>

                                        <div id="loginStats">

                                            <div class="content-box ultra-widget">

                                                <div class="w-progress">

                                                    <span id="goodCount" class="w-amount green"></span>
                                                    <span id="badCount" class="w-amount red pull-right">3</span>

                                                    <br>

                                                    <span class="text-uppercase w-name"><?php echo $language->translate("GOOD_LOGINS");?></span>
                                                    <span class="text-uppercase w-name pull-right"><?php echo $language->translate("BAD_LOGINS");?></span>

                                                </div>

                                                <div class="progress progress-bar-sm zero-m">

                                                    <div id="goodPercent" class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 20%"></div>

                                                    <div id="badPercent" class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%"></div>

                                                </div>

                                                <div class="w-status clearfix">

                                                    <div id="goodTitle" class="w-status-title pull-left text-uppercase">20%</div>

                                                    <div id="badTitle" class="w-status-number pull-right text-uppercase">80%</div>

                                                </div>

                                            </div>

                                        </div>

                                        <table id="datatable" class="display">

                                            <thead>

                                                <tr>

                                                    <th><?php echo $language->translate("DATE");?></th>

                                                    <th><?php echo $language->translate("USERNAME");?></th>

                                                    <th><?php echo $language->translate("IP_ADDRESS");?></th>

                                                    <th><?php echo $language->translate("TYPE");?></th>

                                                </tr>

                                            </thead>

                                            <tbody>

                                                <?php

                                                    $getFailLog = str_replace("\r\ndate", "date", file_get_contents(FAIL_LOG));
                                                    $gotFailLog = json_decode($getFailLog, true);
                                                    $goodLogin = 0;
                                                    $badLogin = 0;

                                                    function getColor($colorTest){

                                                        if($colorTest == "bad_auth") :

                                                            $gotColorTest = "danger";

                                                        elseif($colorTest == "good_auth") :

                                                            $gotColorTest = "primary";

                                                        endif;

                                                        echo $gotColorTest;

                                                    }

                                                    foreach (array_reverse($gotFailLog["auth"]) as $key => $val) : 

                                                    if($val["auth_type"] == "bad_auth") : $badLogin++; elseif($val["auth_type"] == "good_auth") : $goodLogin++; endif;
                                                ?>

                                                <tr>

                                                    <td><?=$val["date"];?></td>

                                                    <td><?=$val["username"];?></td>

                                                    <td><?=$val["ip"];?></td>

                                                    <td><span class="label label-<?php getColor($val["auth_type"]);?>"><?=$val["auth_type"];?></span></td>

                                                </tr>

                                                <?php endforeach; ?> 

                                            </tbody>

                                        </table>

                                        <?php 
                                        $totalLogin = $goodLogin + $badLogin;     
                                        $goodPercent = round(($goodLogin / $totalLogin) * 100);
                                        $badPercent = round(($badLogin / $totalLogin) * 100);

                                        };

                                        if(!file_exists(FAIL_LOG)){

                                            echo $language->translate("NOTHING_LOG");

                                        }

                                        ?>

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--End Content-->

        </div>

          <script>
            $(function () {
                //Data Tables
                $('#datatable').DataTable({
                    displayLength: 10,
                    dom: 'T<"clear">lfrtip',
                    responsive: true,
                    "order": [[ 0, 'desc' ]],
                    "language": {
                        "info": "<?php echo explosion($language->translate('SHOW_ENTRY_CURRENT'), 0);?> _START_ <?php echo explosion($language->translate('SHOW_ENTRY_CURRENT'), 1);?> _END_ <?php echo explosion($language->translate('SHOW_ENTRY_CURRENT'), 2);?> _TOTAL_ <?php echo explosion($language->translate('SHOW_ENTRY_CURRENT'), 3);?>",
                        "infoEmpty": "<?php echo $language->translate('NO_ENTRIES');?>",
                        "infoFiltered": "<?php echo explosion($language->translate('FILTERED'), 0);?> _MAX_ <?php echo explosion($language->translate('FILTERED'), 1);?>",
                        "lengthMenu": "<?php echo $language->translate('SHOW');?> _MENU_ <?php echo $language->translate('ENTRIES');?>",
                        "search": "",
                        "searchPlaceholder": "<?php echo $language->translate('SEARCH');?>",
                        "searchClass": "<?php echo $language->translate('SEARCH');?>",
                        "zeroRecords": "<?php echo $language->translate('NO_MATCHING');?>",
                        "paginate": {
				            "next": "<?php echo $language->translate('NEXT');?>",
                            "previous": "<?php echo $language->translate('PREVIOUS');?>",
				           }
			         }
                });
            });
              
          $(function () {
            //Data Tables
            $('#orgLogs').DataTable({
                displayLength: 10,
                dom: 'T<"clear">lfrtip',
                responsive: true,
                "order": [[ 0, 'desc' ]],
                "language": {
                    "info": "<?php echo explosion($language->translate('SHOW_ENTRY_CURRENT'), 0);?> _START_ <?php echo explosion($language->translate('SHOW_ENTRY_CURRENT'), 1);?> _END_ <?php echo explosion($language->translate('SHOW_ENTRY_CURRENT'), 2);?> _TOTAL_ <?php echo explosion($language->translate('SHOW_ENTRY_CURRENT'), 3);?>",
                    "infoEmpty": "<?php echo $language->translate('NO_ENTRIES');?>",
                    "infoFiltered": "<?php echo explosion($language->translate('FILTERED'), 0);?> _MAX_ <?php echo explosion($language->translate('FILTERED'), 1);?>",
                    "lengthMenu": "<?php echo $language->translate('SHOW');?> _MENU_ <?php echo $language->translate('ENTRIES');?>",
                    "search": "",
                    "searchPlaceholder": "<?php echo $language->translate('SEARCH');?>",
                    "searchClass": "<?php echo $language->translate('SEARCH');?>",
                    "zeroRecords": "<?php echo $language->translate('NO_MATCHING');?>",
                    "paginate": {
            "next": "<?php echo $language->translate('NEXT');?>",
                        "previous": "<?php echo $language->translate('PREVIOUS');?>",
           }
        }
            });
        });
        </script>
        <script>
            (function($) {
                function startTrigger(e,data) {
                    var $elem = $(this);
                    $elem.data('mouseheld_timeout', setTimeout(function() {
                        $elem.trigger('mouseheld');
                    }, e.data));
                }

                function stopTrigger() {
                    var $elem = $(this);
                    clearTimeout($elem.data('mouseheld_timeout'));
                }

                var mouseheld = $.event.special.mouseheld = {
                    setup: function(data) {
                        var $this = $(this);
                        $this.bind('mousedown', +data || mouseheld.time, startTrigger);
                        $this.bind('mouseleave mouseup', stopTrigger);
                    },
                    teardown: function() {
                        var $this = $(this);
                        $this.unbind('mousedown', startTrigger);
                        $this.unbind('mouseleave mouseup', stopTrigger);
                    },
                    time: 200 // default to 750ms
                };
            })(jQuery);

            $(function () {

                //$(".todo ul").sortable();
                $(".todo ul").sortable({
                    'opacity': 0.9,
                });

                $("#submitTabs").on('submit', function (e) {
                 console.log('disabled this func')
                 return false;

                });

                $('#apply').on('click touchstart', function(){

                window.parent.location.reload();

                });

            });

        </script>

        <script>
            $("#iconHide").click(function(){

                $( "div[class^='jFiler jFiler-theme-dragdropbox']" ).toggle();
            });
            $("#iconAll").click(function(){

                $( "div[id^='viewAllIcons']" ).toggle();
            });
            $("#deleteToggle").click(function(){

                $( "#deleteDiv" ).toggle();
            });
            $(".deleteUser").click(function(){

                var parent_id = $(this).parent().attr('id');
                editUsername = $('#unregister').find('#inputUsername');
                $(editUsername).html('<input type="hidden" name="op" value="unregister"/><input type="hidden" name="username"value="' + parent_id + '" />');
            });
            $(".promoteUser").click(function(){

                var parent_ids = $(this).parent().attr('id');
                editUsername = $('#unregister').find('#inputUsername');
                $(editUsername).html('<input type="hidden" name="op" value="update"/><input type="hidden" name="role" value="admin"/><input type="hidden" name="username"value="' + parent_ids + '" />');
            });
            $(".demoteUser").click(function(){

                var parent_idz = $(this).parent().attr('id');
                editUsername = $('#unregister').find('#inputUsername');
                $(editUsername).html('<input type="hidden" name="op" value="update"/><input type="hidden" name="role" value="user"/><input type="hidden" name="username"value="' + parent_idz + '" />');
            });
            $("#viewOrgLogs, #viewLoginLogs").click(function(){
                $('#orgLogTable').toggle();
                $('#loginTable').toggle();
                $('#viewOrgLogs').toggle();
                $('#viewLoginLogs').toggle();
            });
            $('#showLess').hide();
            $('#loadMore').click(function () {
                x= (x+5 <= size_li) ? x+5 : size_li;

                $('#versionHistory li:lt('+x+')').show();
                $('#showLess').show();
                if(x == size_li){
                    $('#loadMore').hide();
                }

            });

            $('#showLess').click(function () {

                $('#versionHistory li').not(':lt(2)').hide();
                $('#loadMore').show();
                $('#showLess').hide();

            });
            $('.icp-auto').iconpicker({placement: 'left', hideOnSelect: false, collision: true});
            $("li[class^='list-group-item']").bind('mouseheld', function(e) {

                $(this).find("span[class^='fa fa-hand-paper-o']").attr("class", "fa fa-hand-grab-o");
                $(this).addClass("dragging");
                $(this).find("div[class^='action-btns tabIconView']").addClass("animated swing");
                $(this).mouseup(function() {
                    $(this).find("span[class^='fa fa-hand-grab-o']").attr("class", "fa fa-hand-paper-o");
                    $(this).removeClass("dragging");
                    $(this).find("div[class^='action-btns tabIconView']").removeClass("animated swing");
                });
            });
            function copyToClipboard(elem) {
                  // create hidden text element, if it doesn't already exist
                var targetId = "_hiddenCopyText_";
                var isInput = elem.tagName === "INPUT" || elem.tagName === "TEXTAREA";
                var origSelectionStart, origSelectionEnd;
                if (isInput) {
                    // can just use the original source element for the selection and copy
                    target = elem;
                    origSelectionStart = elem.selectionStart;
                    origSelectionEnd = elem.selectionEnd;
                } else {
                    // must use a temporary form element for the selection and copy
                    target = document.getElementById(targetId);
                    if (!target) {
                        var target = document.createElement("textarea");
                        target.style.position = "absolute";
                        target.style.left = "-9999px";
                        target.style.top = "0";
                        target.id = targetId;
                        document.body.appendChild(target);
                    }
                    target.textContent = elem.textContent;
                }
                // select the content
                var currentFocus = document.activeElement;
                target.focus();
                target.setSelectionRange(0, target.value.length);

                // copy the selection
                var succeed;
                try {
                      succeed = document.execCommand("copy");
                } catch(e) {
                    succeed = false;
                }
                // restore original focus
                if (currentFocus && typeof currentFocus.focus === "function") {
                    //currentFocus.focus();
                }

                if (isInput) {
                    // restore prior selection
                    elem.setSelectionRange(origSelectionStart, origSelectionEnd);
                } else {
                    // clear temporary content
                    target.textContent = "";
                }
                return succeed;
            }
            $("img[class^='allIcons']").click(function(){

                $("textarea[id^='copyTarget']").val($(this).attr("src"));

                copyToClipboard(document.getElementById("copyTarget"));
                parent.notify("<?php echo $language->translate('ICON_COPY');?>","clipboard","success","5000", "<?=$notifyExplode[0];?>", "<?=$notifyExplode[1];?>");
                $( "div[id^='viewAllIcons']" ).toggle();
            });
            $('body').on('click', 'b.allIcons', function() {

                $("textarea[id^='copyTarget2']").val($(this).attr("title"));

                copyToClipboard(document.getElementById("copyTarget2"));
                parent.notify("<?php echo $language->translate('ICON_COPY');?>","clipboard","success","5000", "<?=$notifyExplode[0];?>", "<?=$notifyExplode[1];?>");
                $( "div[class^='jFiler jFiler-theme-dragdropbox']" ).hide();
            });
        </script>
        <script>
            //Custom Themes            
            function changeColor(elementName, elementColor) {
                var definedElement = document.getElementById(elementName);
                definedElement.focus();
                definedElement.value = elementColor;
                definedElement.style.backgroundColor = elementColor;
				$(definedElement).trigger('change');
            }

            $('#plexTheme').on('click touchstart', function(){

                changeColor("topbartext", "#E49F0C");
                changeColor("topbar", "#000000");
                changeColor("bottombar", "#000000");
                changeColor("sidebar", "#121212");
                changeColor("hoverbg", "#FFFFFF");
                changeColor("activetabBG", "#E49F0C");
                changeColor("activetabicon", "#FFFFFF");
                changeColor("activetabtext", "#FFFFFF");
                changeColor("inactiveicon", "#949494");
                changeColor("inactivetext", "#B8B8B8");
                changeColor("loading", "#E49F0C");
                changeColor("hovertext", "#000000");
            });
            $('#embyTheme').on('click touchstart', function(){

                changeColor("topbartext", "#52B54B");
                changeColor("topbar", "#212121");
                changeColor("bottombar", "#212121");
                changeColor("sidebar", "#121212");
                changeColor("hoverbg", "#FFFFFF");
                changeColor("activetabBG", "#52B54B");
                changeColor("activetabicon", "#FFFFFF");
                changeColor("activetabtext", "#FFFFFF");
                changeColor("inactiveicon", "#949494");
                changeColor("inactivetext", "#B8B8B8");
                changeColor("loading", "#52B54B");
                changeColor("hovertext", "#000000");
            });
            $('#bookTheme').on('click touchstart', function(){

                changeColor("topbartext", "#FFFFFF");
                changeColor("topbar", "#3B5998");
                changeColor("bottombar", "#3B5998");
                changeColor("sidebar", "#8B9DC3");
                changeColor("hoverbg", "#FFFFFF");
                changeColor("activetabBG", "#3B5998");
                changeColor("activetabicon", "#FFFFFF");
                changeColor("activetabtext", "#FFFFFF");
                changeColor("inactiveicon", "#DFE3EE");
                changeColor("inactivetext", "#DFE3EE");
                changeColor("loading", "#FFFFFF");
                changeColor("hovertext", "#000000");
            });
            $('#spaTheme').on('click touchstart', function(){

                changeColor("topbartext", "#5B391E");
                changeColor("topbar", "#66BBAE");
                changeColor("bottombar", "#66BBAE");
                changeColor("sidebar", "#C3EEE7");
                changeColor("hoverbg", "#66BBAE");
                changeColor("activetabBG", "#C6C386");
                changeColor("activetabicon", "#FFFFFF");
                changeColor("activetabtext", "#FFFFFF");
                changeColor("inactiveicon", "#5B391E");
                changeColor("inactivetext", "#5B391E");
                changeColor("loading", "#5B391E");
                changeColor("hovertext", "#000000");
            });
            $('#darklyTheme').on('click touchstart', function(){

                changeColor("topbartext", "#FFFFFF");
                changeColor("topbar", "#375A7F");
                changeColor("bottombar", "#375A7F");
                changeColor("sidebar", "#222222");
                changeColor("hoverbg", "#464545");
                changeColor("activetabBG", "#FFFFFF");
                changeColor("activetabicon", "#464545");
                changeColor("activetabtext", "#464545");
                changeColor("inactiveicon", "#0CE3AC");
                changeColor("inactivetext", "#0CE3AC");
                changeColor("loading", "#FFFFFF");
                changeColor("hovertext", "#000000");
            });
            $('#slateTheme').on('click touchstart', function(){

                changeColor("topbartext", "#C8C8C8");
                changeColor("topbar", "#272B30");
                changeColor("bottombar", "#272B30");
                changeColor("sidebar", "#32383E");
                changeColor("hoverbg", "#58C0DE");
                changeColor("activetabBG", "#3E444C");
                changeColor("activetabicon", "#C8C8C8");
                changeColor("activetabtext", "#FFFFFF");
                changeColor("inactiveicon", "#C8C8C8");
                changeColor("inactivetext", "#C8C8C8");
                changeColor("loading", "#C8C8C8");
                changeColor("hovertext", "#000000");
            });
            $('#defaultTheme').on('click touchstart', function(){

                changeColor("topbartext", "#FFFFFF");
                changeColor("topbar", "#eb6363");
                changeColor("bottombar", "#eb6363");
                changeColor("sidebar", "#000000");
                changeColor("hoverbg", "#eb6363");
                changeColor("activetabBG", "#eb6363");
                changeColor("activetabicon", "#FFFFFF");
                changeColor("activetabtext", "#FFFFFF");
                changeColor("inactiveicon", "#FFFFFF");
                changeColor("inactivetext", "#FFFFFF");
                changeColor("loading", "#FFFFFF");
                changeColor("hovertext", "#000000");
            });
            $('#redTheme').on('click touchstart', function(){

                changeColor("topbartext", "#FFFFFF");
                changeColor("topbar", "#eb6363");
                changeColor("bottombar", "#eb6363");
                changeColor("sidebar", "#000000");
                changeColor("hoverbg", "#eb6363");
                changeColor("activetabBG", "#eb6363");
                changeColor("activetabicon", "#FFFFFF");
                changeColor("activetabtext", "#FFFFFF");
                changeColor("inactiveicon", "#FFFFFF");
                changeColor("inactivetext", "#FFFFFF");
                changeColor("loading", "#FFFFFF");
                changeColor("hovertext", "#000000");
            });
            $('#monokaiTheme').on('click touchstart', function(){

                changeColor("topbartext", "#66D9EF");
                changeColor("topbar", "#333333");
                changeColor("bottombar", "#333333");
                changeColor("sidebar", "#393939");
                changeColor("hoverbg", "#AD80FD");
                changeColor("activetabBG", "#F92671");
                changeColor("activetabicon", "#FFFFFF");
                changeColor("activetabtext", "#FFFFFF");
                changeColor("inactiveicon", "#66D9EF");
                changeColor("inactivetext", "#66D9EF");
                changeColor("loading", "#66D9EF");
                changeColor("hovertext", "#000000");
            });
            $('#thejokerTheme').on('click touchstart', function(){

                changeColor("topbartext", "#CCCCCC");
                changeColor("topbar", "#000000");
                changeColor("bottombar", "#000000");
                changeColor("sidebar", "#121212");
                changeColor("hoverbg", "#CCC6CC");
                changeColor("activetabBG", "#A50CB0");
                changeColor("activetabicon", "#FFFFFF");
                changeColor("activetabtext", "#FFFFFF");
                changeColor("inactiveicon", "#949494");
                changeColor("inactivetext", "#B8B8B8");
                changeColor("loading", "#CCCCCC");
                changeColor("hovertext", "#000000");

            });
            $('#newPlexTheme').on('click touchstart', function(){

                changeColor("topbartext", "#E5A00D");
                changeColor("topbar", "#282A2D");
                changeColor("bottombar", "#282A2D");
                changeColor("sidebar", "#3F4245");
                changeColor("hoverbg", "#E5A00D");
                changeColor("activetabBG", "#282A2D");
                changeColor("activetabicon", "#E5A00D");
                changeColor("activetabtext", "#E5A00D");
                changeColor("inactiveicon", "#F9F9F9");
                changeColor("inactivetext", "#F9F9F9");
                changeColor("loading", "#E5A00D");
                changeColor("hovertext", "#E0E3E6");

            });//$( "div" ).not( ".green, #blueone" )
            $('textarea').not( ".no-code" ).numberedtextarea({

              // font color for line numbers
              color: null,

              // border color
              borderColor: 'null',

              // CSS class to be added to the line numbers
              class: null, 

              // if true Tab key creates indentation
              allowTabChar: true,       

            });
            $(".email-header .close-button").click(function () {
                $(".email-content").removeClass("email-active");
                $('html').removeClass("overhid");
                $("#settings-list").find("li").removeClass("active");
            });
             $(document).mouseup(function (e)
{
                var container = $(".email-content, .checkFrame, #content");

                if (!container.is(e.target) && container.has(e.target).length === 0) {
                    $(".email-content").removeClass("email-active");
                    $('html').removeClass("overhid");
                    $("#settings-list").find("li").removeClass("active");
                }
            }); 
            $( document ).on( 'keydown', function ( e ) {
                if ( e.keyCode === 27 ) { // ESC
                    var container = $(".email-content");

                    if (!container.is(e.target) && container.has(e.target).length === 0) {
                        $(".email-content").removeClass("email-active");
                        $('html').removeClass("overhid");
                        $("#settings-list").find("li").removeClass("active");
                    }
                }
            });

        
     
            $("#open-info, #open-users, #open-logs, #open-advanced, #open-homepage, #open-colors, #open-tabs, #open-donate ").on("click",function (e) {
                $(".email-content").removeClass("email-active");
                $('html').removeClass("overhid");
                if($(window).width() < 768){
                    $('html').addClass("overhid");
                }

                var settingsBox = $('.'+$(this).attr("box"));
                console.log($(this).attr("box"))
                settingsBox.addClass("email-active");
                $("#settings-list").find("li").removeClass("active");
                $(this).parent().addClass("active");

                $("<div class='refresh-preloader'><div class='la-timer la-dark'><div></div></div></div>").appendTo(settingsBox).show();

                setTimeout(function(){
                    var refreshMailPreloader = settingsBox.find('.refresh-preloader'),
                    deletedMailBox = refreshMailPreloader.fadeOut(300, function(){
                    refreshMailPreloader.remove();
                });
                },600);
                e.preventDefault();
            });
          
         
			
            function checkGithub() {
                $.ajax({
                    type: "GET",
                    url: "https://api.github.com/repos/causefx/Organizr/releases",
                    dataType: "json",
                    success: function(github) {
                        var currentVersion = "<?php echo INSTALLEDVERSION;?>";
                        infoTabVersion = $('#about').find('#version');
                        infoTabVersionHistory = $('#about').find('#versionHistory');
                        infoTabNew = $('#about').find('#whatsnew');
                        infoTabDownload = $('#about').find('#downloadnow');
                        $.each(github, function(i,v) {
                            if(i === 0){ 
                                console.log(v.tag_name);
                                githubVersion = v.tag_name;
                                githubDescription = v.body;
                                githubName = v.name;
                            }
                            $(infoTabVersionHistory).append('<li style="display: none"><time class="cbp_tmtime" datetime="' + v.published_at + '"><span>' + v.published_at.substring(0,10) + '</span> <span>' + v.tag_name + '</span></time><div class="cbp_tmicon animated jello"><i class="fa fa-github-alt"></i></div><div class="cbp_tmlabel"><h2 class="text-uppercase">' + v.name + '</h2><p>' + v.body + '</p></div></li>');
                            size_li = $("#versionHistory li").size();
                            x=2;
                            $('#versionHistory li:lt('+x+')').show();
                        });
                        if(currentVersion < githubVersion){
                            console.log("You Need To Upgrade");
                            parent.notify("<strong><?php echo $language->translate("NEW_VERSION");?></strong> <?php echo $language->translate("CLICK_INFO");?>","arrow-circle-o-down","warning","50000", "<?=$notifyExplode[0];?>", "<?=$notifyExplode[1];?>");

                            $(infoTabNew).html("<br/><h4><strong><?php echo $language->translate("WHATS_NEW");?> " + githubVersion + "</strong></h4><strong><?php echo $language->translate("TITLE");?>: </strong>" + githubName + " <br/><strong><?php echo $language->translate("CHANGES");?>: </strong>" + githubDescription);
                            <?php if (extension_loaded("ZIP")){?>
                            $(infoTabDownload).html("<br/><form style=\"display:initial;\" id=\"upgradeOrg\" method=\"post\" onsubmit=\"ajax_request(\'POST\', \'upgradeInstall\'); return false;\"><input type=\"hidden\" name=\"action\" value=\"upgrade\" /><button class=\"btn waves btn-labeled btn-success text-uppercase waves-effect waves-float\" type=\"submit\"><span class=\"btn-label\"><i class=\"fa fa-refresh\"></i></span><?php echo $language->translate("AUTO_UPGRADE");?></button></form> <a href='https://github.com/causefx/Organizr/archive/master.zip' target='_blank' type='button' class='btn waves btn-labeled btn-success text-uppercase waves-effect waves-float'><span class='btn-label'><i class='fa fa-download'></i></span>Organizr v." + githubVersion + "</a>");
                            $( "p[id^='upgrade']" ).toggle();
                            <?php }else{ ?>
                            $(infoTabDownload).html("<br/><a href='https://github.com/causefx/Organizr/archive/master.zip' target='_blank' type='button' class='btn waves btn-labeled btn-success text-uppercase waves-effect waves-float'><span class='btn-label'><i class='fa fa-download'></i></span>Organizr v." + githubVersion + "</a>");
                            $( "p[id^='upgrade']" ).toggle();
                            <?php } ?>
                        }else if(currentVersion === githubVersion){
                            console.log("You Are on Current Version");
                        }else{
                            console.log("something went wrong");
                        }
                        $(infoTabVersion).html("<strong><?php echo $language->translate("INSTALLED_VERSION");?>: </strong>" + currentVersion + " <strong><?php echo $language->translate("CURRENT_VERSION");?>: </strong>" + githubVersion + " <strong><?php echo $language->translate("DATABASE_PATH");?>:  </strong> <?php echo htmlentities(DATABASE_LOCATION);?>");
                    }
                });
            }
        </script>
        <script>
        $( document ).ready(function() {
            //AJAX Submit for URL Check
            $('#urlTestForm_submit').on('click', function () {
                ajax_request('POST', 'check-url', {
                    checkurl: $('#urlTestForm [name=url-test]').val(),
                });
            });
            //Hide Icon box on load
            $( "div[class^='jFiler jFiler-theme-dragdropbox']" ).hide();
            //Set Some Scrollbars
            $(".scroller-body").niceScroll({
                railpadding: {top:0,right:0,left:0,bottom:0}
            });
            $(".email-content").niceScroll({
                railpadding: {top:0,right:0,left:0,bottom:0}
            });
            $("textarea").niceScroll({
                railpadding: {top:0,right:0,left:0,bottom:0}
            });
            //Stop Div behind From Scrolling
            $( '.email-content' ).on( 'mousewheel', function ( e ) {
                e.preventDefault();
            }, false);  
            //Set Hide Function
			         if (0) {
                var authTypeFunc = function() {
                    // Hide Everything
                    $('#host-selected, #host-other, #host-plex, #host-emby, #host-ldap').hide();
                    // Qualify Auth Type
                    if($('#authType').val() !== "internal"){
                        $( '#host-selected' ).show();

                        // Qualify aithBackend
                        if($('#authBackend').val() === "plex"){
                            $('#host-selected, #host-plex').show();
                        }else if($('#authBackend').val().indexOf("emby")>=0){
                            $('#host-selected, #host-other, #host-emby').show();
                        }else if($('#authBackend').val() === "ldap"){
                            $('#host-selected, #host-other, #host-ldap').show();
                        }else {
                            $('#host-selected, #host-other').show();
                        }
                    }
                }
                //Hide Settings on selection
                $('#authType, #authBackend').on('change', authTypeFunc);
                //Hide Settings on Load
                authTypeFunc();
			         } else { console.log() }
            //Simulate Edit Tabs Click 
            //$("#open-tabs").trigger("click");
            //Append Delete log to User Logs and Org Logs
            $("#datatable_wrapper > div[class^='DTTT_container']").append('<form style="display: inline; margin-left: 3px;" id="deletelog" method="post" onsubmit="ajax_request(\'POST\', \'deleteLog\'); return false;"><input type="hidden" name="action" value="deleteLog" /><button class="btn waves btn-labeled btn-danger text-uppercase waves-effect waves-float" type="submit"><span class="btn-label"><i class="fa fa-trash"></i></span><?php echo $language->translate("PURGE_LOG");?> </button></form>');
            $("#orgLogs_wrapper > div[class^='DTTT_container']").append('<form style="display: inline; margin-left: 3px;" id="deleteOrglog" method="post" onsubmit="ajax_request(\'POST\', \'deleteOrgLog\'); return false;"><input type="hidden" name="action" value="deleteOrgLog" /><button class="btn waves btn-labeled btn-danger text-uppercase waves-effect waves-float" type="submit"><span class="btn-label"><i class="fa fa-trash"></i></span><?php echo $language->translate("PURGE_LOG");?> </button></form>')
            $("a[id^='ToolTables_datatable_0'] span").html('<?php echo $language->translate("PRINT");?>')
            //Enable Tooltips
            $('[data-toggle="tooltip"]').tooltip(); 
        	   //AJAX call to github to get version info	
			         <?php if (GIT_CHECK) { echo 'checkGithub()'; } ?>

            //Edit Info tab with Github info
            <?php if(file_exists(FAIL_LOG)) : ?>
            goodCount = $('#loginStats').find('#goodCount');
            goodPercent = $('#loginStats').find('#goodPercent');
            goodTitle = $('#loginStats').find('#goodTitle');
            badCount = $('#loginStats').find('#badCount');
            badPercent = $('#loginStats').find('#badPercent');
            badTitle = $('#loginStats').find('#badTitle');
            $(goodCount).html("<?php echo $goodLogin;?>");            
            $(goodTitle).html("<?php echo $goodPercent;?>%");            
            $(goodPercent).attr('aria-valuenow', "<?php echo $goodPercent;?>");            
            $(goodPercent).attr('style', "width: <?php echo $goodPercent;?>%");            
            $(badCount).html("<?php echo $badLogin;?>");
            $(badTitle).html("<?php echo $badPercent;?>%");            
            $(badPercent).attr('aria-valuenow', "<?php echo $badPercent;?>");            
            $(badPercent).attr('style', "width: <?php echo $badPercent;?>%"); 
            <?php endif; ?>
        });
        </script>

    </body>

</html>
