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
        action="./7-4-1.php" 
        method="POST" 
        enctype="application/x-www-form-urlencoded">
    <h3>上課所需要用到的白板筆顏色</h3>
    <label>黑色: </label>
    <input type="checkbox" name="myColor[]" value="黑色" /> <br />
    <label>藍色: </label>
    <input type="checkbox" name="myColor[]" value="藍色" /> <br />
    <label>紅色: </label>
    <input type="checkbox" name="myColor[]" value="紅色" /> <br />
    <label>綠色: </label>
    <input type="checkbox" name="myColor[]" value="綠色" /> <br />
    <input type="submit" name="smb" value="送出" />
</form>

</body>
</html>