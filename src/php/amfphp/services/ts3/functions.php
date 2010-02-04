<?php
  function debug($message) {
    $fd = fopen("debug.txt","a+");
    if ($fd) {
      fwrite($fd,date("d/m/Y H:i:s",time())." : ".$message."\n");
      fclose($fd);
    }
  }

?>