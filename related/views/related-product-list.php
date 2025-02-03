<?php
/**
 * @var CMain $APPLICATION
 */
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

$APPLICATION->SetTitle("Related");

$APPLICATION->IncludeComponent('bitrix:related.related_product_list', '', []);

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>