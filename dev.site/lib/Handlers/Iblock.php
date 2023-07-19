<?php

namespace Dev\Site\Handlers;

use CIBlock;
use CIBlockSection;
use CIBlockElement;

class Iblock
{
    public static function addLog(&$arFields)
    {
        // Переменные с данными инфоблока LOG
        $IBLOCK_CODE = "LOG";
        $IBLOCK_ID = CIBlock::GetList([], ['CODE' => $IBLOCK_CODE])->Fetch()['ID'];
        $IBLOCK_SECTION_ID = null;

        $sectionCodes = [];

        // Получаем данные про инфоблок измененного элемента
        $fieldIblock = CIBlock::GetByID($arFields['IBLOCK_ID'])->Fetch();
        $fieldSection = null;

        if(!empty($arFields['IBLOCK_SECTION'])) {
            $fieldSection = CIBlockSection::GetByID($arFields['IBLOCK_SECTION'][0])->Fetch();
        }

        
        if($fieldIblock['CODE'] !== $IBLOCK_CODE) {
            $logSections = CIBlockSection::GetList([], ['IBLOCK_CODE' => $IBLOCK_CODE]);
            
            // Проверяем разделы инфоблока LOG. 
            while($ob = $logSections->GetNextElement()) {
                $section = $ob->GetFields();
                $sectionCodes[] = $section['CODE'];

                if($fieldIblock['CODE'] == $section['CODE']) {
                    $IBLOCK_SECTION_ID = $section['ID'];
                }
            }


            // Если раздел не существует, создаем новый и добавляем в инфоблок
            if(!in_array($fieldIblock['CODE'], $sectionCodes)){
                $newLogSection = new CIBlockSection;

                $fields = [
                    'ACTIVE' => 'Y',
                    'IBLOCK_ID' => $IBLOCK_ID,
                    'CODE' => $fieldIblock['CODE'],
                    'NAME' => $fieldIblock['NAME'],
                ];
            
                $sectionID = $newLogSection->Add($fields);

                if($newLogSection->LAST_ERROR) {
                    echo $newLogSection->LAST_ERROR;
                    exit();
                } 

                $IBLOCK_SECTION_ID = $sectionID;
            };

            $newLogElement = new CIBlockElement;
            
            $arLoadProductArray = Array(
                "IBLOCK_SECTION_ID" => $IBLOCK_SECTION_ID,
                "IBLOCK_ID" => $IBLOCK_ID,
                "NAME" => $arFields['ID'],
                "ACTIVE_FROM" => date('d.m.Y'),
            );
            
            if(!is_null($fieldSection)) {
                $arLoadProductArray['PREVIEW_TEXT'] = $fieldIblock['NAME'].' -> '.$fieldSection['NAME'].' -> '.$arFields['NAME'];
            } else {
                $arLoadProductArray['PREVIEW_TEXT'] = $fieldIblock['NAME'].' -> '.$arFields['NAME'];
            }
            
            // Проверяем на наличие измененного элемента, если нет, создаем новый
            $elCount = CIBlockElement::GetList([], ['NAME' => $arFields['ID'], 'IBLOCK_CODE' => $IBLOCK_CODE], []);
            
            if($elCount == 0) {
                $newLogElement->Add($arLoadProductArray);
            } else {
                $logElement = CIBlockElement::GetList([], ['NAME' => $arFields['ID']])->Fetch();

                if(!$newLogElement->Update($logElement['ID'], $arLoadProductArray)) {
                    echo $newLogElement->LAST_ERROR;
                    exit();
                };
            }    
        }
    }

    function OnBeforeIBlockElementAddHandler(&$arFields)
    {
        $iQuality = 95;
        $iWidth = 1000;
        $iHeight = 1000;
        /*
         * Получаем пользовательские свойства
         */
        $dbIblockProps = \Bitrix\Iblock\PropertyTable::getList(array(
            'select' => array('*'),
            'filter' => array('IBLOCK_ID' => $arFields['IBLOCK_ID'])
        ));
        /*
         * Выбираем только свойства типа ФАЙЛ (F)
         */
        $arUserFields = [];
        while ($arIblockProps = $dbIblockProps->Fetch()) {
            if ($arIblockProps['PROPERTY_TYPE'] == 'F') {
                $arUserFields[] = $arIblockProps['ID'];
            }
        }
        /*
         * Перебираем и масштабируем изображения
         */
        foreach ($arUserFields as $iFieldId) {
            foreach ($arFields['PROPERTY_VALUES'][$iFieldId] as &$file) {
                if (!empty($file['VALUE']['tmp_name'])) {
                    $sTempName = $file['VALUE']['tmp_name'] . '_temp';
                    $res = \CAllFile::ResizeImageFile(
                        $file['VALUE']['tmp_name'],
                        $sTempName,
                        array("width" => $iWidth, "height" => $iHeight),
                        BX_RESIZE_IMAGE_PROPORTIONAL_ALT,
                        false,
                        $iQuality);
                    if ($res) {
                        rename($sTempName, $file['VALUE']['tmp_name']);
                    }
                }
            }
        }

        if ($arFields['CODE'] == 'brochures') {
            $RU_IBLOCK_ID = \Only\Site\Helpers\IBlock::getIblockID('DOCUMENTS', 'CONTENT_RU');
            $EN_IBLOCK_ID = \Only\Site\Helpers\IBlock::getIblockID('DOCUMENTS', 'CONTENT_EN');
            if ($arFields['IBLOCK_ID'] == $RU_IBLOCK_ID || $arFields['IBLOCK_ID'] == $EN_IBLOCK_ID) {
                \CModule::IncludeModule('iblock');
                $arFiles = [];
                foreach ($arFields['PROPERTY_VALUES'] as $id => &$arValues) {
                    $arProp = \CIBlockProperty::GetByID($id, $arFields['IBLOCK_ID'])->Fetch();
                    if ($arProp['PROPERTY_TYPE'] == 'F' && $arProp['CODE'] == 'FILE') {
                        $key_index = 0;
                        while (isset($arValues['n' . $key_index])) {
                            $arFiles[] = $arValues['n' . $key_index++];
                        }
                    } elseif ($arProp['PROPERTY_TYPE'] == 'L' && $arProp['CODE'] == 'OTHER_LANG' && $arValues[0]['VALUE']) {
                        $arValues[0]['VALUE'] = null;
                        if (!empty($arFiles)) {
                            $OTHER_IBLOCK_ID = $RU_IBLOCK_ID == $arFields['IBLOCK_ID'] ? $EN_IBLOCK_ID : $RU_IBLOCK_ID;
                            $arOtherElement = \CIBlockElement::GetList([],
                                [
                                    'IBLOCK_ID' => $OTHER_IBLOCK_ID,
                                    'CODE' => $arFields['CODE']
                                ], false, false, ['ID'])
                                ->Fetch();
                            if ($arOtherElement) {
                                /** @noinspection PhpDynamicAsStaticMethodCallInspection */
                                \CIBlockElement::SetPropertyValues($arOtherElement['ID'], $OTHER_IBLOCK_ID, $arFiles, 'FILE');
                            }
                        }
                    } elseif ($arProp['PROPERTY_TYPE'] == 'E') {
                        $elementIds = [];
                        foreach ($arValues as &$arValue) {
                            if ($arValue['VALUE']) {
                                $elementIds[] = $arValue['VALUE'];
                                $arValue['VALUE'] = null;
                            }
                        }
                        if (!empty($arFiles && !empty($elementIds))) {
                            $rsElement = \CIBlockElement::GetList([],
                                [
                                    'IBLOCK_ID' => CModule::IncludeModule('iblock')::getIblockID('PRODUCTS', 'CATALOG_' . $RU_IBLOCK_ID == $arFields['IBLOCK_ID'] ? '_RU' : '_EN'),
                                    'ID' => $elementIds
                                ], false, false, ['ID', 'IBLOCK_ID', 'NAME']);
                            while ($arElement = $rsElement->Fetch()) {
                                /** @noinspection PhpDynamicAsStaticMethodCallInspection */
                                \CIBlockElement::SetPropertyValues($arElement['ID'], $arElement['IBLOCK_ID'], $arFiles, 'FILE');
                            }
                        }
                    }
                }
            }
        }
    }

}
