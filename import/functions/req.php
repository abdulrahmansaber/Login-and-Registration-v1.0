<?php

  Class Request_M {


    public function request($request)
    {
      if ($_SERVER['REQUEST_METHOD'] == $request) {
        return true;
      }
    }

    public function find_get($get)
    {
      if (isset($_GET[$get])) {
        return true;
      }
    }

    public function is_submitted($button_name)
    {
      if (isset($_POST[$button_name])) {
        return true;
      }
    }

  }
