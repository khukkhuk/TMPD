<?php
session_start();
session_destroy();
          echo "<script type=\"text/javascript\">";
          echo "alert(\"กำลังออกจากระบบ \");"; 
          echo "</script>"; 
		  echo "<META HTTP-EQUIV='Refresh' CONTENT='0;URL= ../index.php'>";
?>