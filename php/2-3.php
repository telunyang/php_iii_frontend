<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
    table { border: 1px solid; }
    table th {border: 1px dashed; }
    table td { border: 1px dotted; }
    </style>
</head>
<body>
    <table>
        <thead>
            <th>姓名</th>
        </thead>
        <tbody>
            <?php
            //學生姓名陣列初始化
            $arrStudent = ["Alex", "Bill", "Carl", "Darren"];

            //count() 函式幫助我們計算陣列的長度
            for($i = 0; $i < count($arrStudent); $i++){
                echo "<tr><td>".$arrStudent[$i]."</td></tr>";
            }
            ?>
        </tbody> 
    </table>
</body>
</html>