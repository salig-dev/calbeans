<?php
session_start();
unset($_SESSION['customer_id']);
session_destroy();
header("Location: /calbeans/index.html");
exit;
