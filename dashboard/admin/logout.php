<?php
session_start();
unset($_SESSION['admin_id']);
session_destroy();
header("Location: /calbeans/dashboard/index.php");
exit;
