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
    </style>
</head>
<body>

這裡是後端管理頁面 | <a href="./category.php">編輯類別</a> | <a href="./new.php">新增商品</a> | <a href="./admin.php">商品列表</a> | <a href="./orders.php">訂單一覽</a> | <a href="./logout.php">登出</a>

<hr />

<h3>編輯類別</h3>
<form name="myForm" method="POST" action="./insertCategory.php">

<?php
$sql = "SELECT `categoryId`, `categoryName` FROM `categories` ";
$stmt = $pdo->query($sql);
if($stmt->rowCount() > 0) {
    $arr = $stmt->fetchAll();
?>

<ul>

    <?php for($i = 0; $i < count($arr); $i++) { ?>
        <li><?php echo $arr[$i]['categoryName'] ?> 
        | <a href="./editCategory.php?editCategoryId=<?php echo $arr[$i]['categoryId'] ?>">編輯</a> 
        | <a href="./deleteCategory.php?deleteCategoryId=<?php echo $arr[$i]['categoryId'] ?>">刪除</a>
        </li>
    <?php } ?>
    
<?php } ?>

</ul>

<table class="border">
    <thead>
        <tr>
            <th class="border">類別名稱</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td class="border">
                <input type="text" name="categoryName" value="" maxlength="100" />
            </td>
        </tr>
    </tbody>
    <tfoot>
        <tr>
            <td class="border"><input type="submit" name="smb" value="新增"></td>
        </tr>
    </tfoot>
</table>

</form>
</body>
</html>