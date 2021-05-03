<?php
require_once('./checkAdmin.php'); //引入登入判斷
require_once('../db.inc.php'); //引用資料庫連線

//商品種類 SQL 敘述，取得商品種類總筆數
$totalCatogories = $pdo->query("SELECT count(1) AS `count` FROM `categories`")->fetchAll()[0]['count'];
?>
<!DOCTYPYE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>我的 PHP 程式</title>
    <style>
    .border {
        border: 1px solid;
    }
    img.itemImg {
        width: 250px;
    }
    </style>
</head>
<body>

這裡是後端管理頁面 | <a href="./category.php">編輯類別</a> | <a href="./new.php">新增商品</a> | <a href="./admin.php">商品列表</a> | <a href="./orders.php">訂單一覽</a> | <a href="./logout.php">登出</a>

<hr />

<h3>新增商品</h3>

<?php 
//若有建立商品種類，則顯示商品清單
if($totalCatogories > 0) {
?>

<form name="myForm" enctype="multipart/form-data" method="POST" action="add.php">
    <table class="border">
        <thead>
            <tr>
                <th class="border">商品名稱</th>
                <th class="border">商品照片路徑</th>
                <th class="border">商品價格</th>
                <th class="border">商品數量</th>
                <th class="border">商品種類</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="border">
                    <input type="text" name="itemName" value="" maxlength="100" />
                </td>
                <td class="border">
                    <input type="file" name="itemImg" value="" />
                </td>
                <td class="border">
                    <input type="text" name="itemPrice" value="" maxlength="11" />
                </td>
                <td class="border">
                    <input type="text" name="itemQty" value="" maxlength="3" />
                </td>
                <td class="border">
                    <select name="itemCategoryId">
                    <?php
                    //顯示所有商品種類
                    $sql = "SELECT `categoryId`, `categoryName` FROM `categories` ";
                    $stmt = $pdo->query($sql);
                    if($stmt->rowCount() > 0) {
                        $arr = $stmt->fetchAll();
                        for($i = 0; $i < count($arr); $i++) { 
                    ?>
                        <option value="<?php echo $arr[$i]['categoryId'] ?>"><?php echo $arr[$i]['categoryName'] ?></option>
                    <?php 
                        } 
                    } 
                    ?>
                    </select>
                </td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td class="border" colspan="5"><input type="submit" name="smb" value="新增"></td>
            </tr>
        </tfoot>
    </table>
</form>

<?php 
} else {
    echo "請先建立商品類別";
} 
?>

</body>
</html>