<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);?>

<?php if (!empty($arResult["IBLOCK_TYPES"])): ?>
    <h2>IBlock Types</h2>
    <ul>
        <?php foreach ($arResult["IBLOCK_TYPES"] as $iblockTypeId => $iblockTypeName): ?>
            <li><?= $iblockTypeName ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<?php if (!empty($arResult["IBLOCKS"])): ?>
    <h2>IBlocks</h2>
    <ul>
        <?php foreach ($arResult["IBLOCKS"] as $iblockId => $iblockName): ?>
            <li><?= $iblockName ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<?php if (!empty($arResult["ITEMS"])): ?>
    <h2>Elements</h2>
    <?php foreach ($arResult["ITEMS"] as $iblockId => $elements): ?>
        <h3><?= $arResult["IBLOCKS"][$iblockId] ?></h3>
        <ul>
            <?php foreach ($elements as $element): ?>
                <li><?= $element["NAME"] ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endforeach; ?>
<?php endif; ?>

