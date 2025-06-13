<?php
/*********************************************************************
    secure.inc.php

    File included on every client's "secure" pages

    Peter Rotich <peter@osticket.com>
    Copyright (c)  2006-2013 osTicket
    http://www.osticket.com

    Released under the GNU General Public License WITHOUT ANY WARRANTY.
    See LICENSE.TXT for details.

    vim: expandtab sw=4 ts=4 sts=4:
**********************************************************************/
if(!strcasecmp(basename($_SERVER['SCRIPT_NAME']),basename(__FILE__))) die('Kwaheri!');
if(!file_exists('client.inc.php')) die('Fatal Error.');
require_once('client.inc.php');

//Client Login page: Ajax interface can pre-declare the function to trap logins.
if(!function_exists('clientLoginPage')) {
    function clientLoginPage($msg ='') {
        global $ost, $cfg, $nav;
        $_SESSION['_client']['auth']['dest'] =
            '/' . ltrim($_SERVER['REQUEST_URI'], '/');
            
        // Find OAuth2 plugin instance dynamically
        $login_url = ROOT_PATH . "login.php";
        
        // Only try to find OAuth2 plugin if the class exists
        if (class_exists('OAuth2Plugin')) {
            foreach (PluginManager::allInstalled() as $path => $plugin) {
                if ($plugin instanceof OAuth2Plugin && $plugin->isActive()) {
                    // Get the first active instance of the plugin
                    $instances = $plugin->getActiveInstances();
                    if ($instances && $instances->count() > 0) {
                        $instance = $instances->first();
                        $login_url = ROOT_PATH . "login.php?do=ext&bk=oauth2.user.p" . $plugin->getId() . "i" . $instance->getId();
                    }
                    break;
                }
            }
        }
        
        Http::redirect($login_url);
        exit;
    }
}

//User must be logged in!
if(!$thisclient || !$thisclient->getId() || !$thisclient->isValid()){
    clientLoginPage();
    exit;
}
$thisclient->refreshSession();
?>
