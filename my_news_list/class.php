<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Loader;
use Bitrix\Iblock;

class MyNewsListComponent extends CBitrixComponent
{
    protected function getIblockTypes()
    {
        $iblockTypes = [];
        $res = CIBlockType::GetList();
        while ($type = $res->Fetch()) {
            if ($ar = CIBlockType::GetByIDLang($type["ID"], LANGUAGE_ID)) {
                $iblockTypes[$type["ID"]] = $ar["NAME"];
            }
        }
        return $iblockTypes;
    }

    protected function getIblocks($iblockType = null)
    {
        $iblocks = [];
        $filter = [
            "ACTIVE" => "Y",
        ];
        if ($iblockType) {
            $filter["TYPE"] = $iblockType;
        }

        $res = CIBlock::GetList([], $filter);
        while ($iblock = $res->Fetch()) {
            $iblocks[$iblock["ID"]] = $iblock["NAME"];
        }

        return $iblocks;
    }

    protected function getElements($iblockId = null)
    {
        $elements = [];

        if ($iblockId) {
          $filter["IBLOCK_ID"] = $iblockId;
        }

        if($filter['IBLOCK_ID'] == '-') {
          unset($filter['IBLOCK_ID']);
          $filter['IBLOCK_TYPE'] = $this->arParams['IBLOCK_TYPE'];
        }
        
        $res = CIBlockElement::GetList([], $filter);
        
        while ($element = $res->GetNextElement()) {
          $fields = $element->GetFields();
          $properties = $element->GetProperties();

          $elementData = [
              "ID" => $fields["ID"],
              "NAME" => $fields["NAME"],
          ];

          $elements[$fields["IBLOCK_ID"]][] = $elementData;
        }

        return $elements;
    }

    public function executeComponent()
    {
        try {
            if (!\Bitrix\Main\Loader::includeModule("iblock")) {
                throw new \Exception("The 'iblock' module is not installed.");
            }
 
            $iblockType = $this->arParams["IBLOCK_TYPE"] ?? null;
            $this->arResult["IBLOCKS"] = $this->getIblocks($iblockType);

            $iblockId = $this->arParams["IBLOCK_ID"] ?? null;
            $this->arResult["ITEMS"] = $this->getElements($iblockId);

            $this->includeComponentTemplate();
        } catch (\Exception $e) {
            $this->arResult["ERROR"] = $e->getMessage();
            $this->includeComponentTemplate("error_template");
        }
    }
}
