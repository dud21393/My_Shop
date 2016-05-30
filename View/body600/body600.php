<?php

switch($action['action']) {
    case 610 :
        include "./body600/body" . $action['action'] . ".php";
        break;
    case 611:
        include "./body600/body" . $action['action'] . ".php";
        break;
    case 613:
        include "./body600/body" . $action['action'] . ".php";
        break;
    case 614 :
        include "./body600/body" . $action['action'] . ".php";
        break;
    default:
        echo $action['action'];
        break;
}
?>