<?php
//public 範例
class GrandPa {
    public $name = 'Mark Henry';
}

class Daddy extends GrandPa {
    function displayGrandPaName()
    {
        return $this->name; 
    }
}

$daddy = new Daddy;
echo $daddy->displayGrandPaName();  // Prints 'Mark Henry'

echo "<hr />";

$outsiderWantstoKnowGrandpasName = new GrandPa;
echo $outsiderWantstoKnowGrandpasName->name; // Prints 'Mark Henry'