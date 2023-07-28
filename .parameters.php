<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

if (!\Bitrix\Main\Loader::includeModule("iblock")) {
    return;
}


$iblockTypes = ['-' => ' '];
$res = CIBlockType::GetList();

while ($type = $res->Fetch()) {
  if ($ar = CIBlockType::GetByIDLang($type["ID"], LANGUAGE_ID)) {
      $iblockTypes[$type["ID"]] = $ar["NAME"];
  }
}

$iblocks=['-'=>' '];
$iblockList = CIBlock::GetList([], ["TYPE" => ($arCurrentValues["IBLOCK_TYPE"]!="-"?$arCurrentValues["IBLOCK_TYPE"]:"")]);

while($arRes = $iblockList->Fetch()){
  $iblocks[$arRes["ID"]] = "[".$arRes["ID"]."] ".$arRes["NAME"];
}
  

$arComponentParameters = array(
    "PARAMETERS" => array(
        "IBLOCK_TYPE" => array(
            "PARENT" => "BASE",
            "NAME" => "IBlock Type",
            "TYPE" => "LIST",
            "VALUES" => $iblockTypes,
            "DEFAULT" => "news",
            "REFRESH" => "Y",
        ),
        "IBLOCK_ID" => array(
            "PARENT" => "BASE",
            "NAME" => "IBlock",
            "TYPE" => "LIST",
            "VALUES" => $iblocks,
            "DEFAULT" => "",
        ),
    ),
);
