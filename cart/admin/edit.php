<?php
require_once('./checkAdmin.php'); //引入登入判斷
require_once('../db.inc.php'); //引用資料庫連線
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

<h3>商品列表</h3>

<form name="myForm" enctype="multipart/form-data" method="POST" action="update.php">
    <table class="border">
        <thead>
            <tr>
                <th class="border">商品名稱</th>
                <th class="border">商品照片路徑</th>
                <th class="border">商品價格</th>
                <th class="border">商品數量</th>
                <th class="border">商品種類</th>
                <th class="border">新增時間</th>
                <th class="border">更新時間</th>
            </tr>
        </thead>
        <tbody>
        <?php
        //SQL 敘述
        $sql = "SELECT `items`.`itemId`, `items`.`itemName`, `items`.`itemImg`, `items`.`itemPrice`, 
                        `items`.`itemQty`, `items`.`itemCategoryId`, `items`.`created_at`, `items`.`updated_at`,
                        `categories`.`categoryId`, `categories`.`categoryName`
                FROM `items` INNER JOIN `categories`
                ON `items`.`itemCategoryId` = `categories`.`categoryId`
                WHERE `itemId` = ? ";

        $arrParam = [
            (int)$_GET['itemId']
        ];

        //查詢
        $stmt = $pdo->prepare($sql);
        $stmt->execute($arrParam);

        //資料數量大於 0，則列出相關資料
        if($stmt->rowCount() > 0) {
            $arr = $stmt->fetchAll()[0];
        ?>
            <tr>
                <td class="border">
                    <input type="text" name="itemName" value="<?php echo $arr['itemName'] ?>" maxlength="100" />
                </td>
                <td class="border">
                    <img class="itemImg" src="../images/items/<?php echo $arr['itemImg'] ?>" /><br />
                    <input type="file" name="itemImg" value="" />
                </td>
                <td class="border">
                    <input type="text" name="itemPrice" value="<?php echo $arr['itemPrice'] ?>" maxlength="11" />
                </td>
                <td class="border">
                    <input type="text" name="itemQty" value="<?php echo $arr['itemQty'] ?>" maxlength="3" />
                </td>
                <td class="border">
                    <select name="itemCategoryId">
                    <option value="<?php echo $arr['categoryId']; ?>"><?php echo $arr['categoryName'] ?></option>
                    <?php
                    //顯示所有商品種類
                    $sqlCategory = "SELECT `categoryId`, `categoryName` FROM `categories`";
                    $stmtCategory = $pdo->query($sqlCategory);
                    if($stmtCategory->rowCount() > 0) {
                        $arrCategory = $stmtCategory->fetchAll();
                        for($j = 0; $j < count($arrCategory); $j++) { 
                    ?>
                        <option value="<?php echo $arrCategory[$j]['categoryId'] ?>"><?php echo $arrCategory[$j]['categoryName'] ?></option>
                    <?php 
                        } 
                    } 
                    ?>
                    </select>
                </td>
                <td class="border"><?php echo $arr['created_at'] ?></td>
                <td class="border"><?php echo $arr['updated_at'] ?></td>
            </tr>
        <?php
        } else {
        ?>
            <tr>
                <td colspan="7">沒有資料</td>
            </tr>
        <?php
        }
        ?>
        </tbody>
        <tfoot>
            <tr>
                <td class="border" colspan="7"><input type="submit" name="smb" value="更新"></td>
            </tr>
        </tfoot>
    </table>
    <input type="hidden" name="itemId" value="<?php echo (int)$_GET['itemId']; ?>">
</form>
</body>
</html>