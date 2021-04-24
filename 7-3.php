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
        action="./7-3-1.php" 
        method="POST" 
        enctype="application/x-www-form-urlencoded">
    <label>男: </label>
    <input type="radio" name="myGender" checked="checked" value="男" /> <br />
    <label>女: </label>
    <input type="radio" name="myGender" value="女" /> <br />
    <input type="submit" name="smb" value="送出" />
</form>
</body>
</html>