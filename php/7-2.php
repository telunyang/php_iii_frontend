<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<form name="myForm" 
        action="./7-2-1.php" 
        method="POST" 
        enctype="application/x-www-form-urlencoded">
    <label>我的姓名: </label>
    <input type="text" name="myName" /> <br />
    <label>我的年紀: </label>
    <input type="text" name="myAge" /> <br />
    <label>我的身高: </label>
    <input type="text" name="myHeight" /> <br />
    <label>我的體重: </label>
    <input type="text" name="myWeight" /> <br />
    <input type="submit" name="smb" value="送出" />
</form>

</body>
</html>