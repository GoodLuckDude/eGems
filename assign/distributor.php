<?php 
require_once '../config/database.php';
require_once '../func/common.php';

session_start();
//goToLoginPage();

$unassignedGems = getUnassignedGems();
$assignCoeffs = getAssignCoeffs();
$elvesCoeffs = makeElvesCoeffs();
$condition = getCondition();
$initialState = $condition;

$elvesCoeffs = assignEqually($assignCoeffs['equally'], $elvesCoeffs, $condition);
$elvesCoeffs = assignAtLeastOne($assignCoeffs['least_one'], $elvesCoeffs, $condition, $initialState);
$elvesCoeffs = assignPreferred($assignCoeffs['preferred'], $elvesCoeffs, $condition, 3);
var_export($elvesCoeffs);
?>