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









    <!-- tpl-order.php -->
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

                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col" class="border-0 bg-light">
                                <div class="p-2 px-3 text-uppercase">訂單編號</div>
                            </th>
                            <th scope="col" class="border-0 bg-light">
                                <div class="p-2 px-3 text-uppercase">成立時間</div>
                            </th>
                            <th scope="col" class="border-0 bg-light">
                                <div class="py-2 text-uppercase">詳細資訊</div>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    $sqlOrder = "SELECT `orderId`,`created_at`
                                FROM `orders` 
                                WHERE `username` = ? 
                                ORDER BY `orderId` DESC";
                    $stmtOrder = $pdo->prepare($sqlOrder);
                    $stmtOrder->execute([$_SESSION["username"]]);
                    if($stmtOrder->rowCount() > 0){
                        $arrOrders = $stmtOrder->fetchAll();
                        for($i = 0; $i < count($arrOrders); $i++) {
                    ?>
                        <tr>
                            <td class="border-0">
                                <h1><span class="badge badge-secondary"><?php echo $arrOrders[$i]["orderId"] ?></span></h1>
                            </td>
                            <td class="border-0">
                               <?php echo $arrOrders[$i]["created_at"] ?>
                            </td>
                            <td class="border-0 align-middle">
                                <?php
                                $sqlItemList = "SELECT `item_lists`.`checkPrice`,`item_lists`.`checkQty`,`item_lists`.`checkSubtotal`,
                                                        `items`.`itemName`,`categories`.`categoryName`
                                                FROM `item_lists` 
                                                INNER JOIN `items`
                                                ON `item_lists`.`itemId` = `items`.`itemId`
                                                INNER JOIN `categories` 
                                                ON `items`.`itemCategoryId` = `categories`.`categoryId`
                                                WHERE `item_lists`.`orderId` = ? 
                                                ORDER BY `item_lists`.`itemListId` ASC";
                                $stmtItemList = $pdo->prepare($sqlItemList);
                                $arrParamItemList = [
                                    $arrOrders[$i]["orderId"]
                                ];
                                $stmtItemList->execute($arrParamItemList);
                                if($stmtItemList->rowCount() > 0) {
                                    $arrItemList = $stmtItemList->fetchAll(PDO::FETCH_ASSOC);
                                    for($j = 0; $j < count($arrItemList); $j++) {
                                ?>
                                    <div class="jumbotron">
                                        <p>商品名稱: <?php echo $arrItemList[$j]["itemName"] ?></p>
                                        <p>商品種類: <?php echo $arrItemList[$j]["categoryName"] ?></p>
                                        <p>單價: <?php echo $arrItemList[$j]["checkPrice"] ?></p>
                                        <p>數量: <?php echo $arrItemList[$j]["checkQty"] ?></p>
                                        <p>小計: <?php echo $arrItemList[$j]["checkSubtotal"] ?></p>
                                    </div>
                                <?php
                                    }
                                }
                                ?>
                            </td>
                        </tr>
                    <?php
                        }
                    }
                    ?>
                    </tbody>
                </table>

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