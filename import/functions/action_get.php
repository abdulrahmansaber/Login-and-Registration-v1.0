<?php


  /** return_exit()
   * This function exit from our script if get in url not found
   * For EX:
   * Our URL ->> /Team/admin/profile?section=personal-info&adminid=5
   * First param is adminid if not found the second param took a error message
   */
  function return_exit($get_notfound, $message_error) {
    $request = new Request_M();
    $msg     = new Messages();
    if (!$request->find_get($get_notfound)) {
      $msg->error($message_error);
      exit;
    }
  }
