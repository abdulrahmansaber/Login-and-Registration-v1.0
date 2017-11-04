<?php
  session_start();

  require('import/import.php');

  $app_files = new import('import/');

  $app_files->get_app_files();

  $theme = new Themes();

  $redirect = new Redirect();

  $request = new Request_M();
