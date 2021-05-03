<?php 
session_start();
require_once('./db.inc.php');
?>
<!-- tpl-header.php -->
<!DOCTYPYE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="DarrenYang">
    <title>我的購物車</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="./css/footer.css">
</head>
<body class="d-flex flex-column h-100">
    <div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom shadow-sm">
        <h5 class="my-0 mr-md-auto font-weight-normal">
            <a href=".">你的商場名稱</a>
        </h5>

        <nav class="my-2 my-md-0 mr-md-3">
            <a class="p-2 text-dark" href="./itemList.php">商品一覽</a>
            <a class="p-2 text-dark" href="./myCart.php">
                <span>我的購物車</span>
                (<span id="cartItemNum">
                <?php 
                    if(isset($_SESSION["cart"])) {
                        echo count($_SESSION["cart"]);
                    } else {
                        echo 0;
                    }
                ?>
                </span>)
            </a>

            <?php if(isset($_SESSION["username"])) { ?>
                <a class="p-2 text-dark" href="./order.php">我的訂單</a>
            <?php } ?>
        </nav>

        <?php if(!isset($_SESSION["username"])){ ?>
            <a class="btn btn-outline-primary" href="./register.php">註冊</a>
        <?php } else { ?>
            <span><?php echo $_SESSION["name"] ?> 您好</span>
        <?php } ?>

        <span class="ml-3 mr-3"> | </span>
        <?php if(!isset($_SESSION["username"])){ ?>
            <form class="form-inline my-2 my-md-0" name="myForm" method="post" action="./login.php">
                <label class="text-dark">帳號：</label>
                <input class="form-control" type="text" name="username" value="" maxlength="50" />
                <label class="text-dark">密碼：</label>
                <input class="form-control" type="password" name="pwd" value="" maxlength="50" />
                <label class="text-dark">買家</label>
                <input class="form-control" type="radio" name="identity" value="users" checked />
                <label class="text-dark">賣家</label>
                <input class="form-control" type="radio" name="identity" value="admin" />
                <input class="form-control" type="submit" value="登入" />
            </form>
        <?php } else { ?>
        <a href="./logout.php">登出</a>
        <?php } ?>
    </div>









    <!-- tpl-item-detail.php -->
    <div class="container-fluid">
        <div class="row">
            <!-- 樹狀商品種類連結 -->
            <div class="col-md-3 col-sm-4">
                <?php
                $sql = "SELECT `categoryId`, `categoryName` FROM `categories` ";
                $stmt = $pdo->query($sql);
                if($stmt->rowCount() > 0) {
                    $arr = $stmt->fetchAll();
                ?>
                    <ul>
                        <?php for($i = 0; $i < count($arr); $i++) { ?>
                        <li>
                            <a href="./itemList.php?categoryId=<?php echo $arr[$i]['categoryId'] ?>">
                                <?php echo $arr[$i]['categoryName'] ?>
                            </a>
                        </li>
                        <?php } ?>
                    </ul>
                <?php } ?>
            </div>

            <!-- 商品項目清單 -->
            <div class="col-md-9 col-sm-8">
            <?php
            if(isset($_GET['itemId'])) {
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

                //若商品項目個數大於 0，則列出商品
                if($stmt->rowCount() > 0) {
                    $arrItem = $stmt->fetchAll()[0];
            ?>

                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="row mb-3 d-flex justify-content-center">
                                <img class="item-view border" src="./images/items/<?php echo $arrItem["itemImg"]; ?>">
                            </div>
                        </div>
                        <div class="col-md-7">
                            <p>商品名稱：<?php echo $arrItem["itemName"] ?></p>
                            <p>商品價格：<?php echo $arrItem["itemPrice"] ?></p>
                            <p>商品數量：<?php echo $arrItem["itemQty"] ?></p>
                            <form name="cartForm" id="cartForm" method="POST" action="./addCart.php">
                                <label>數量：</label>

                                <!-- 設定數量 -->
                                <input type="number" name="cartQty" value="1" maxlength="5" min="1" max="<?php echo $arrItem["itemQty"] ?>">

                                <!-- 隱藏元素，配合加入購物車使用 -->
                                <input type="hidden" name="itemId" value="<?php echo (int)$_GET['itemId'] ?>">

                                <input type="submit" class="btn btn-primary btn-lg" name="smb" value="加入購物車">
                            </form>
                        </div>  
                    </div>
                </div>

            <?php
                }
            }
            ?>
            </div>
        </div>
    </div>








    <!-- tpl-footer.php -->
    <footer class="footer mt-auto py-3">
        <div class="footer-container">
            <span class="text-muted">Place sticky footer content here.</span>
        </div>
    </footer>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
</body>
</html>