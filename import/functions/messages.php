<?php

  Class Messages {

   /** setHTML() Method
    * Used for adding class, tag, and content
    */
    public static function setHTML($tag, $classes, $content) {
      echo "<$tag class='$classes'>$content</$tag>";
    }

    # Error Message
    public static function error($msg)
    {
      self::setHTML("div", "alert error", $msg);
    }

    # Success Message
    public static function success($msg)
    {
      self::setHTML("div", "alert success", $msg);
    }

    # Warning Message
    public static function warning($msg)
    {
      self::setHTML("div", "alert warning", $msg);
    }

    # Info Message
    public static function info($msg)
    {
      self::setHTML("div", "alert info", $msg);
    }

  }
