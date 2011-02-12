<?php
namespace Functions\Character;
/**
 * Character list logic
 */
$AnAccount = new \Entities\Account();
$AnAccount->AccountId = $_SESSION['AccountId'];
$Response->Set('Data', $Database->Characters->LoadListByAccountId($AnAccount));
$Response->Set('Result', \Protocol\Response::ER_SUCCESS);
?>