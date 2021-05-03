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









    <!-- tpl-cart.php -->
    <div class="container-fluid">

        <div class="row">
            <!-- 樹狀商品種類連結 -->
            <div class="col-md-3 col-sm-4">
                <?php
                $sql = "SELECT `categoryId`, `categoryName` FROM `categories`";
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
                <form name="myForm" method="POST" action="./addOrder.php">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col" class="border-0 bg-light">
                                    <div class="p-2 px-3 text-uppercase">商品名稱</div>
                                </th>
                                <th scope="col" class="border-0 bg-light">
                                    <div class="py-2 text-uppercase">價格</div>
                                </th>
                                <th scope="col" class="border-0 bg-light">
                                    <div class="py-2 text-uppercase">數量</div>
                                </th>
                                <th scope="col" class="border-0 bg-light">
                                    <div class="py-2 text-uppercase">小計</div>
                                </th>
                                <th scope="col" class="border-0 bg-light">
                                    <div class="py-2 text-uppercase">功能</div>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        //放置結合當前資料庫資料的購物車資訊
                        $arr = [];

                        $total = 0;

                        if( isset($_SESSION["cart"]) && count($_SESSION["cart"]) > 0 ){
                            //SQL 敘述
                            $sql = "SELECT `items`.`itemId`, `items`.`itemName`, `items`.`itemImg`, `items`.`itemPrice`,
                                            `categories`.`categoryId`, `categories`.`categoryName`
                                    FROM `items` INNER JOIN `categories`
                                    ON `items`.`itemCategoryId` = `categories`.`categoryId`
                                    WHERE `itemId` = ? ";

                            //比對購物車裡面所有項目的 itemId，然後透過 SQL 查詢來取得完整的資料
                            for($i = 0; $i < count($_SESSION["cart"]); $i++){
                                $arrParam = [
                                    (int)$_SESSION["cart"][$i]["itemId"]
                                ];
                                
                                //查詢
                                $stmt = $pdo->prepare($sql);
                                $stmt->execute($arrParam);
                                
                                //若商品項目個數大於 0，則把買家購買的數量加到查詢結果當中
                                if($stmt->rowCount() > 0) {
                                    $arrItem = $stmt->fetchAll()[0];
                                    $arrItem['cartQty'] = $_SESSION["cart"][$i]["cartQty"];
                                    $arr[] = $arrItem;
                                } 
                            } 

                            for($i = 0; $i < count($arr); $i++) { 
                                //計算總額
                                $total += $arr[$i]["itemPrice"] * $arr[$i]["cartQty"];
                        ?>
                            <tr>
                                <th scope="row" class="border-0">
                                    <div class="p-2">
                                        <img src="./images/items/<?php echo $arr[$i]["itemImg"] ?>" alt="" width="70" class="img-fluid rounded shadow-sm">
                                        <div class="ml-3 d-inline-block align-middle">
                                            <h5 class="mb-0"><a href="#"class="text-dark d-inline-block align-middle"><?php echo $arr[$i]["itemName"] ?></a></h5>
                                            <span class="text-muted font-weight-normal font-italic d-block">Category: <?php echo $arr[$i]["categoryName"] ?></span>
                                        </div>
                                    </div>
                                </th>
                                <td class="border-0 align-middle"><strong>$<?php echo $arr[$i]["itemPrice"] ?></strong></td>
                                <td class="border-0 align-middle">
                                    <input type="text" class="form-control" name="cartQty[]" value="<?php echo $arr[$i]["cartQty"] ?>" maxlength="3">
                                </td>
                                <td class="border-0 align-middle">
                                    <input type="text" class="form-control" name="subtotal[]" value="<?php echo ($arr[$i]["itemPrice"] * $arr[$i]["cartQty"]) ?>" maxlength="10">
                                </td>
                                <td class="border-0 align-middle"><a href="./deleteCart.php?idx=<?php echo $i ?>" class="text-dark">刪除</a></td>
                            </tr>
                            <input type="hidden" name="itemId[]" value="<?php echo $arr[$i]["itemId"] ?>">
                            <input type="hidden" name="itemPrice[]" value="<?php echo $arr[$i]["itemPrice"] ?>">
                        <?php 
                            }
                        }
                        ?>
                        </tbody>
                    </table>
                

                <?php if( isset($_SESSION["cart"]) && count($_SESSION["cart"]) > 0 ){ ?>
                    <div class="row d-flex justify-content-end pl-3 pr-3 pb-3">
                        <h3>目前總額: <mark id="total"><?php echo $total ?></mark></h3>
                    </div>
                    <div class="row d-flex justify-content-end pl-3 pr-3 pb-3">
                        <input class="btn btn-primary btn-lg" type="submit" name="smb" value="送出">
                    </div>
                <?php } ?>

                </form>

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