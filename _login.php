<?php
/**
 * GaiaEHR
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

if(!defined('_GaiaEXEC')) die('No direct access allowed.');
$lang = (isset($_SESSION['site']['localization']) ? $_SESSION['site']['localization'] : 'en_US');
$site = (isset($_SESSION['site']['dir']) ? $_SESSION['site']['dir'] : false);


$site = (isset($_GET['site']) ? $_GET['site'] : 'default');

$mDebug = false;
//if($mobile->isMobile() || $mDebug){
//	header('Location: _aire/?site='.$site);
//}else{
/**
 * Startup the registry
 * This contains SESSION Variables to use in the application
 * and mobile_detect class is used to detect mobile browsers.
 */
include_once('registry.php');
/**
 * set the site using the url parameter site, or default if not given
 */
if(file_exists('sites/' . $site . '/conf.php')){
    include_once('sites/' . $site . '/conf.php');
} else {
    $_SESSION['site'] = array('error' => 'Site configuration file not found, Please contact Support Desk. Thanks!');
};

?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <title>Phone-A-Doctor Logon Screen</title>
    <script type="text/javascript" src="lib/extjs-4.1.1a/ext-all.js"></script>
    <link rel="stylesheet" type="text/css" href="resources/css/ext-all-gray.css">
    <link rel="stylesheet" type="text/css" href="resources/css/style_newui.css">
    <link rel="stylesheet" type="text/css" href="resources/css/custom_app.css">

    <link rel="shortcut icon" href="favicon.ico">
    <script src="JSrouter.php"></script>
    <script src="data/api.php"></script>
    <script type="text/javascript">
        var app, site = '<?php print $site ?>',
	        localization = '<?php print $lang ?>';
        function i18n(key){ return lang[key] || key; }
        function say(a){ console.log(a); }
        Ext.Loader.setConfig({
            enabled: true,
            disableCaching: true,
            paths: {
                'App': 'app'
            }
        });
        for(var x = 0; x < App.data.length; x++){
            Ext.direct.Manager.addProvider(App.data[x]);
        }
        Ext.onReady(function(){
            app = Ext.create('App.view.login.Login');
        });
    </script>
</head>
<body id="login">
<div id="msg-div"></div>
<div id="copyright">
    <!--
    [Update] : Change Copyright Info
	<div>Copyright (C) 2011 GaiaEHR (Electronic Health Records) |:|  Open Source Software operating under <a href="javascript:void(0)" onClick="Ext.getCmp('winCopyright').show();">GPLv3</a> |:| v<?php print $_SESSION['version'] ?></div>
	-->
    <div><a href="javascript:void(0)" onClick="Ext.getCmp('winCopyright').show();">Copyright</a> (C) 2015 PAD (Phone A Doctor) |:| v<?php print $_SESSION['version'] ?></div>
</body>
</html>