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
        action="./7-5-1.php"  
        method="POST" 
        enctype="multipart/form-data">
    <h3>請選擇所要上傳的檔案</h3>
    <input type="file" name="fileUpload" /><br />
    <input type="submit" value="送出資料" />
</form>
    
</body>
</html>