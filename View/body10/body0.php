<?php

switch($action['action'])
{
    case 10 : include "./body10/body" . $action['action'] . ".php";
        break;
    case 13 : include "./body10/body" . $action['action'] . ".php";
        break;
    case 15 : include "./body10/body" . $action['action'] . ".php";
        break;
    case 16 : include "./body10/body" . $action['action'] . ".php";
        break;
    case 17 : include "./body10/body" . $action['action'] . ".php";
        break;
    case 18 : include "./body10/body" . $action['action'] . ".php";
        break;
    default : echo "Body Page Number {$action['action']}";
        break;
}
?>
