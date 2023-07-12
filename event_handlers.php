<?php

AddEventHandler('iblock', 'OnAfterIBlockElementUpdate', 'addLog');
AddEventHandler('iblock', 'OnAfterIBlockElementAdd', 'addLog');


function addLog(&$arFields)
{
  // Переменные с данными инфоблока LOG
  $IBLOCK_CODE = "LOG";
  $IBLOCK_ID = CIBlock::GetList([], ['CODE' => $IBLOCK_CODE])->Fetch()['ID'];
  $IBLOCK_SECTION_ID = null;

  $sectionCodes = [];
  $logElementNames = [];

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

    // Проверяем элементы инфоблока
    $result = CIBlockElement::GetList([], ['IBLOCK_CODE' => $IBLOCK_CODE]);
    
    while($ob = $result->GetNextElement()) {
      $logElementNames[] = $ob->GetFields()['NAME'];
    } 

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
    if(!in_array($arFields['ID'], $logElementNames)) {
      $newLogElement = new CIBlockElement;

      if(!$newLogElement->Add($arLoadProductArray)) {
        echo $newLogElement->LAST_ERROR;
        exit();
      }
    } else {
      $logElement = CIBlockElement::GetList([], ['NAME' => $arFields['ID']])->Fetch();
      $updatedLogElement = new CIBlockElement;

      if(!$updatedLogElement->Update($logElement['ID'], $arLoadProductArray)) {
        echo $updatedLogElement->LAST_ERROR;
        exit();
      };
    }    
  }
}