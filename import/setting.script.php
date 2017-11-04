<?php

  Class Themes {

   /** Proprties of Class
    * $theme => It means the css file and JS File and CSS File Must Be Equal Than JavaScript File
    * So if you created a css file and named it mytheme.css javascript file must be = mytheme.js
    * For Example :
    * $theme = 'mytheme';
    * ----------------------------
    * $theme_path => The Themes Path You Can Change it By Default Path is /themes/
    */
    public $theme;
    public $themes_path = 'themes/';

   /** setting_theme() Method
    * Return the JS & CSS Files
    * 0 index is css file
    * 1 index is js file
    */
    public function setting_theme()
    {
      return [
        $this->themes_path . 'css-theme/' . $this->theme . '.css',
        $this->themes_path . 'js-theme/' . $this->theme . '.js',
      ];
    }

   /** require_theme_files() Method
    * $type arg taking the type of files that 'll be required
    * if $type = 'design' that means the css file ($this->theme) will be required
    * beside if $type = 'javascript' that means the javascript file ($this->theme) will be required
    */
    public function require_theme_files($type)
    {
      $theme_name = $this->setting_theme();
      if ($type == 'design') {
        echo "<link rel='stylesheet' href='$theme_name[0]'>";
      }
      elseif ($type == 'javascript') {
        echo "<script src='$theme_name[1]'></script>\n";
      }
    }

  }
