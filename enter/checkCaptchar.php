<?php
  session_start();
  header('Content-type: text/html; charset=utf-8');
  if (isset($_REQUEST['usercode']) && !empty($_REQUEST['usercode'])) {
    $input_code = strtolower($_REQUEST['usercode']);
    if ($input_code === $_SESSION['usercode']) {
      echo 1;
    } else {
      echo 0;
    }
  }
  session_write_close();
?>
