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

<form name="myForm" method="POST" action="updateCategory.php">
    <table class="border">
        <thead>
            <tr>
                <th class="border">種類名稱</th>
                <th class="border">新增時間</th>
                <th class="border">更新時間</th>
            </tr>
        </thead>
        <tbody>
        <?php
        //SQL 敘述
        $sql = "SELECT `categoryId`, `categoryName`, `created_at`, `updated_at`
                FROM  `categories`
                WHERE `categoryId` = ? ";

        $arrParam = [
            (int)$_GET['editCategoryId']
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
                    <input type="text" name="categoryName" value="<?php echo $arr['categoryName']; ?>" maxlength="100" />
                </td>
                <td class="border"><?php echo $arr['created_at']; ?></td>
                <td class="border"><?php echo $arr['updated_at']; ?></td>
            </tr>
        <?php
        } else {
        ?>
            <tr>
                <td colspan="3">沒有資料</td>
            </tr>
        <?php
        }
        ?>
        </tbody>
        <tfoot>
            <tr>
            <?php if($stmt->rowCount() > 0){ ?>
                <td class="border" colspan="3"><input type="submit" name="smb" value="更新"></td>
            <?php } ?>
            </tr>
        </tfoot>
    </table>
    <input type="hidden" name="editCategoryId" value="<?php echo (int)$_GET['editCategoryId']; ?>">
</form>
</body>
</html>