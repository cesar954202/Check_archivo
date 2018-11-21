<?php

$out = shell_exec("schtasks /run /TN \"Copia archivo sincroni. Opera\"");
header('Location: index.php');
sleep(3);

?>
