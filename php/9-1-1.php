<?php
//刪除 cookie (透過指定過去時間，例如 3600 秒前)
setcookie('username', '', time() - 3600);