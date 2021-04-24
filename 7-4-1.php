<?php
for($i = 0; $i < count($_POST['myColor']); $i++) {
    echo "您所選擇的顏色為: " . $_POST['myColor'][$i] . "<br />";
};