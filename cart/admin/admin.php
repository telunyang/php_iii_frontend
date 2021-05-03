<?php
require_once('./checkAdmin.php'); //引入登入判斷
require_once('../db.inc.php'); //引用資料庫連線

/**
 * 執行 SQL 語法，取得 items 資料表總筆數，並回傳、建立 PDOstatment 物件
 * 查詢結果，取得第一筆資料(索引為 0)，資料表總筆數
 */
$total =  $pdo->query("SELECT count(1) AS `count` FROM `items`")->fetchAll()[0]['count'];

//每頁幾筆
$numPerPage = 5;

// 總頁數，ceil()為無條件進位
$totalPages = ceil($total/$numPerPage); 

//目前第幾頁
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

//若 page 小於 1，則回傳 1
$page = $page < 1 ? 1 : $page;

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

<h3>商品列表</h3>

<?php 
//若有建立商品種類，則顯示商品清單
if($totalCatogories > 0) {
?>
    <form name="myForm" entype= "multipart/form-data" method="POST" action="deleteIds.php">
        <table class="border">
            <thead>
                <tr>
                    <th class="border">勾選</th>
                    <th class="border">商品名稱</th>
                    <th class="border">商品照片路徑</th>
                    <th class="border">商品價格</th>
                    <th class="border">商品數量</th>
                    <th class="border">商品種類</th>
                    <th class="border">新增時間</th>
                    <th class="border">更新時間</th>
                    <th class="border">功能</th>
                </tr>
            </thead>
            <tbody>
            <?php
            //SQL 敘述
            $sql = "SELECT `items`.`itemId`, `items`.`itemName`, `items`.`itemImg`, `items`.`itemPrice`, 
                            `items`.`itemQty`, `items`.`itemCategoryId`, `items`.`created_at`, `items`.`updated_at`,
                            `categories`.`categoryName`
                    FROM `items` INNER JOIN `categories`
                    ON `items`.`itemCategoryId` = `categories`.`categoryId`
                    ORDER BY `items`.`itemId` ASC 
                    LIMIT ?, ? ";

            //設定繫結值
            $arrParam = [($page - 1) * $numPerPage, $numPerPage];

            //查詢分頁後的商品資料
            $stmt = $pdo->prepare($sql);
            $stmt->execute($arrParam);

            //若數量大於 0，則列出商品
            if($stmt->rowCount() > 0) {
                $arr = $stmt->fetchAll();
                for($i = 0; $i < count($arr); $i++) {
            ?>
                <tr>
                    <td class="border">
                        <input type="checkbox" name="chk[]" value="<?php echo $arr[$i]['itemId']; ?>" />
                    </td>
                    <td class="border"><?php echo $arr[$i]['itemName']; ?></td>
                    <td class="border"><img class="itemImg" src="../images/items/<?php echo $arr[$i]['itemImg']; ?>" /></td>
                    <td class="border"><?php echo $arr[$i]['itemPrice']; ?></td>
                    <td class="border"><?php echo $arr[$i]['itemQty']; ?></td>
                    <td class="border"><?php echo $arr[$i]['categoryName']; ?></td>
                    <td class="border"><?php echo $arr[$i]['created_at']; ?></td>
                    <td class="border"><?php echo $arr[$i]['updated_at']; ?></td>
                    <td class="border">
                        <a href="./edit.php?itemId=<?php echo $arr[$i]['itemId']; ?>">商品編輯</a>
                    </td>
                </tr>
            <?php
                }
            } else {
            ?>
                <tr>
                    <td class="border" colspan="9">沒有資料</td>
                </tr>
            <?php
            }
            ?>
            </tbody>
            <tfoot>
                <tr>
                    <td class="border" colspan="9">
                    <?php for($i = 1; $i <= $totalPages; $i++){ ?>
                        <a href="?page=<?php echo $i ?>"><?php echo $i ?></a>
                    <?php } ?>
                    </td>
                </tr>
                
                <?php if($total > 0) { ?>
                <tr>
                    <td class="border" colspan="9"><input type="submit" name="smb" value="刪除"></td>
                </tr>
                <?php } ?>
                
            </tfoo>
        </table>
    </form>
<?php 
} else {
    echo "請先建立商品類別";
}
?>

</body>
</html>