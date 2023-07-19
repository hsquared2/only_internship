<?php

namespace Dev\Site\Agents;

use CIBlockElement;

class Iblock
{
    public static function clearOldLogs() {
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

    public static function example()
    {
        global $DB;
        if (\Bitrix\Main\Loader::includeModule('iblock')) {
            $iblockId = \Only\Site\Helpers\IBlock::getIblockID('QUARRIES_SEARCH', 'SYSTEM');
            $format = $DB->DateFormatToPHP(\CLang::GetDateFormat('SHORT'));
            $rsLogs = \CIBlockElement::GetList(['TIMESTAMP_X' => 'ASC'], [
                'IBLOCK_ID' => $iblockId,
                '<TIMESTAMP_X' => date($format, strtotime('-1 months')),
            ], false, false, ['ID', 'IBLOCK_ID']);
            while ($arLog = $rsLogs->Fetch()) {
                \CIBlockElement::Delete($arLog['ID']);
            }
        }
        return '\\' . __CLASS__ . '::' . __FUNCTION__ . '();';
    }
}
