<?php
//private 範例
class GrandPa {
    private $name = 'Mark Henry';
}

class Daddy extends GrandPa {
    function displayGrandPaName() {
        return $this->name;
    }
}

$daddy = new Daddy;
echo $daddy->displayGrandPaName(); // Results in a Notice 

echo "<hr />";

$outsiderWantstoKnowGrandpasName = new GrandPa;
echo $outsiderWantstoKnowGrandpasName->name; //  Fatal Error