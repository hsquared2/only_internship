<?php

function clearOldLogs() {
  $count = CIBlockElement::GetList([], ['IBLOCK_CODE' => "LOG"], []);
  
  while($count > 10) {
    $arResult = CIBlockElement::GetList(['timestamp_x' => 'asc'], ['IBLOCK_CODE' => "LOG"]);
    $el = $arResult->GetNextElement()->GetFields();
  
    if(!CIBlockElement::Delete($el['ID'])) {
      echo "Error while deleting element " . $el['NAME'];
    }

    $count = CIBlockElement::GetList([], ['IBLOCK_CODE' => "LOG"], []);
  }

  return "clearOldLogs();";
}