<?php
/*
 * @version $Id: index.php 22774 2014-03-12 15:07:22Z moyo $
 -------------------------------------------------------------------------
 GLPI - Gestionnaire Libre de Parc Informatique
 Copyright (C) 2003-2014 by the INDEPNET Development Team.

 http://indepnet.net/   http://glpi-project.org
 -------------------------------------------------------------------------

 LICENSE

 This file is part of GLPI.

 GLPI is free software; you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation; either version 2 of the License, or
 (at your option) any later version.

 GLPI is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License
 along with GLPI. If not, see <http://www.gnu.org/licenses/>.
 --------------------------------------------------------------------------
 */


/** @file
* @brief
*/

// Check PHP version not to have trouble
if (version_compare(PHP_VERSION, "5.3.0") < 0) {
   die("PHP >= 5.3.0 required");
}

define('DO_NOT_CHECK_HTTP_REFERER', 1);
// If config_db doesn't exist -> start installation
define('GLPI_ROOT', dirname(__FILE__));
include (GLPI_ROOT . "/config/based_config.php");

if (!file_exists(GLPI_CONFIG_DIR . "/config_db.php")) {
   include_once (GLPI_ROOT . "/inc/autoload.function.php");
   Html::redirect("install/install.php");
   die();

} else {
   $TRY_OLD_CONFIG_FIRST = true;
   include (GLPI_ROOT . "/inc/includes.php");
   $_SESSION["glpicookietest"] = 'testcookie';

   // For compatibility reason
   if (isset($_GET["noCAS"])) {
      $_GET["noAUTO"] = $_GET["noCAS"];
   }

   Auth::checkAlternateAuthSystems(true, isset($_GET["redirect"])?$_GET["redirect"]:"");

   // Send UTF8 Headers
   header("Content-Type: text/html; charset=UTF-8");


   //alterações tiago - cabeçalho para html5
   // Start the page
  //  echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" '.
  //        '"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">'."\n";
   echo '<!DOCTYPE html>';
  //  echo '<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">';
   //echo '<head><title>'.__('GLPI - Authentication').'</title>'."\n";
   echo '<head><title>'.'Suporte Guarulhos'.'</title>'."\n";
   echo '<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>'."\n";
   echo '<meta http-equiv="Content-Script-Type" content="text/javascript"/>'."\n";

   //bootstrap
   echo '<link rel="stylesheet" href="'.$CFG_GLPI["root_doc"].'/css/css/bootstrap.css" />';
   echo '<link rel="stylesheet" href="'.$CFG_GLPI["root_doc"].'/css/css/min.css" />';

   echo '<link rel="shortcut icon" type="images/x-icon" href="'.$CFG_GLPI["root_doc"].
          '/pics/favicon.ico" />';

   // Appel CSS
   echo '<link rel="stylesheet" href="'.$CFG_GLPI["root_doc"].'/css/styles.css" type="text/css" '.
         'media="screen" />';
   // surcharge CSS hack for IE
   echo "<!--[if lte IE 6]>" ;
   echo "<link rel='stylesheet' href='".$CFG_GLPI["root_doc"]."/css/styles_ie.css' type='text/css' ".
         "media='screen' >\n";
   echo "<![endif]-->";
//    echo "<script type='text/javascript'><!--document.getElementById('var_login_name').focus();-->".
//          "</script>";
   echo "</head>";

   echo "<body>";
    echo "<div class='container'>";
     echo "<div class='row'>";
      echo "<div class='col-lg-8 col-lg-offset-2'>";
        echo "<div style='margin-top:10%;'>";
          echo "<div class='panel panel-info'>";
            echo "<div class='header'>";
              echo "<div class='panel-heading'>";
                echo "<div class='panel-title'>";
                  echo "<div class='row'>";
                    echo "<div class='col-md-3'><img  src='".$CFG_GLPI["root_doc"]."/pics/login_logo_glpi.png'></img></div>";
                    echo "<div class='col-md-9'><h1> Universidade Federal de São Paulo</h1><h4>Sistema de Suporte - DTI Guarulhos</h4></div>";
                  echo "</div>";
                echo "</div>";
              echo "</div>";
            echo "</div>";
          echo "</div>";
        echo "</div>";
      echo "</div>";
     echo "</div>";

   echo "<form action='".$CFG_GLPI["root_doc"]."/front/login.php' method='post' class='form-horizontal'>";
     // Other CAS
     if (isset($_GET["noAUTO"])) {
        echo "<input type='hidden' name='noAUTO' value='1'/>";
     }
     // redirect to ticket
     if (isset($_GET["redirect"])) {
        Toolbox::manageRedirect($_GET["redirect"]);
        echo '<input type="hidden" name="redirect" value="'.$_GET['redirect'].'"/>';
     }
     echo "<div class='form-group'>";
         echo "<label class='col-sm-4 control-label'>".__('Login')."</label>";
         echo "<div class='col-sm-4'>";
            echo "<input class='form-control' type='text' name='login_name' id='login_name' required='required' placeholder='Digite seu login da intranet...'/>";
         echo "</div>";
     echo "</div>";

     echo "<div class='form-group'>";
       echo "<label class='col-sm-4 control-label'>".__('Password')."</label>";
       echo "<div class='col-sm-4'>";
          echo "<input class='form-control' type='password' name='login_password' id='login_password' required='required' placeholder='senha'/>";
       echo "</div>";
     echo "</div>";

     echo "<div class='row'>";
          echo "<button class='btn btn-success col-md-2 col-md-offset-5' type='submit'>".'Entrar'."</button>";
     echo "</div>";
    // echo '</span></p>';
    //   if ($CFG_GLPI["use_mailing"]
    //      && countElementsInTable('glpi_notifications',
    //                              "`itemtype`='User'
    //                               AND `event`='passwordforget'
    //                               AND `is_active`=1")) {
    //     echo '<div id="forget"><a href="front/lostpassword.php?lostpassword=1">'.
    //            __('Forgotten password?').'</a></div>';
    //  }

   Html::closeForm();
   echo "</form>";

   echo "<script type='text/javascript' >\n";
   echo "document.getElementById('login_name').focus();";
   echo "</script>";

   //echo "</div>";
   //echo "</div>";// end login box


   echo "<div class='error'>";
   echo "<noscript><p>";
   _e('You must activate the JavaScript function of your browser');
   echo "</p></noscript>";

   if (isset($_GET['error'])) {
      switch ($_GET['error']) {
         case 1 : // cookie error
            _e('You must accept cookies to reach this application');
            break;

         case 2 : // GLPI_SESSION_DIR not writable
            _e('Checking write permissions for session files');
            echo "<br>".GLPI_SESSION_DIR;
            break;

         case 3 :
            _e('Invalid use of session ID');
            break;
      }
   }
   echo "</div>";


  // echo "</div>"; // end contenu login

      // Display FAQ is enable
   if ($CFG_GLPI["use_public_faq"]) {
      echo '<div id="box-faq">'.
            '<a href="front/helpdesk.faq.php">[ '.__('Access to the Frequently Asked Questions').' ]';
      echo '</a></div>';
   }

   if (GLPI_DEMO_MODE) {
      echo "<div class='center'>";
      Event::getCountLogin();
      echo "</div>";
   }
   echo "<div id='footer-login'>";
   echo "<a href='http://humanas.unifesp.br' title='DTI-Guarulhos' target='_blank'>";
   echo 'Sistema de Suporte Campus Guarulhos ';
   echo "</a></div>";

}
// call cron
if (!GLPI_DEMO_MODE) {
   CronTask::callCronForce();
}
echo "</div>";
echo "</body></html>";
?>
