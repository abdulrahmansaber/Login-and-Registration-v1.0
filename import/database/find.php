<?php

  Class Find {

    /** find()
     * @return true
     * Return data of searched recorder on database
     * return data if found only!
     */
    public function find_rec($table, $recorder, $equal)
    {
      global $conn;
      $find_rec = new Query();
      $rowCount = $find_rec->query_rowCount("SELECT * FROM `$table` WHERE `$recorder` = '$equal'");
      $fetchData = $find_rec->query_fetch("SELECT * FROM `$table` WHERE `$recorder` = '$equal'", 'fetch');
      if ($rowCount == 1) {
        return $fetchData;
      }
    }

    /** return_rowcount()
     * @return true
     * Return row count of recorder
     * Method means: recorder found or doesn't
     */
    public function find_rec_row($table, $recorder, $equal)
    {
      global $conn;
      $find_rec = new Query();
      $rowCount = $find_rec->query_rowCount("SELECT * FROM `$table` WHERE `$recorder` = '$equal'");
      $fetchData = $find_rec->query_fetch("SELECT * FROM `$table` WHERE `$recorder` = '$equal'", 'fetch');
      if ($rowCount == 1) {
        return $rowCount;
      }
    }

  }
