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









    <!-- tpl-user-register.php -->
    <div class="container">
        <form name="myForm" method="POST" action="./addUser.php">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="inputUsername">帳號</label>
                    <input type="text" class="form-control" id="inputUsername" name="username" placeholder="請輸入帳號" value="">
                </div>
                <div class="form-group col-md-6">
                    <label for="inputPassword">密碼</label>
                    <input type="password" class="form-control" id="inputPassword" name="pwd" placeholder="請輸入密碼" value="">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="inputName">姓名</label>
                    <input type="text" class="form-control" id="inputName" name="name" placeholder="請輸入您的姓名" value="">
                </div>
                <div class="form-group col-md-6">
                    <label for="inputGender">性別</label>
                    <select id="inputGender" name="gender" class="form-control">
                        <option value="男" selected>男</option>
                        <option value="女">女</option>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="inputPhoneNumber">手機號碼</label>
                    <input type="text" class="form-control" id="inputPhoneNumber" name="phoneNumber" placeholder="請輸入手機電話號碼" value="">
                </div>
                <div class="form-group col-md-6">
                    <label for="inputBirthday">生日</label>
                    <input type="text"" class="form-control" id="inputBirthday" name="birthday" placeholder="請輸入出生年月日" value="">
                </div>
            </div>
            <div class="form-group">
                <div class="form-group">
                    <label for="inputAddress">住址</label>
                    <input type="text" class="form-control" id="inputAddress" name="address" placeholder="請輸入住址">
                </div>
            </div>
            <button type="submit" class="btn btn-primary">註冊</button>
        </form>
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