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
$this->setFrameMode(true);
?>
<?if(!empty($arResult['ITEMS'])):?>
	<div id="barba-wrapper">
    <div class="article-list">
			<?foreach($arResult['ITEMS'] as $arItem):?>
				<?
					$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
					$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
				?>
				<a class="article-item article-list__item" 
				href="<?=!empty($arItem['PROPERTIES']['LINK']['VALUE']) ? $arItem['PROPERTIES']['LINK']['VALUE'] : '#'?>"
				-anim="anim-3" 
				id="<?=$this->GetEditAreaId($arItem['ID']);?>"
				>
				<?if(!empty($arItem['PREVIEW_PICTURE']['SRC'])):?>
					<div class="article-item__background">
						<img src="<?=$arItem['PREVIEW_PICTURE']['SRC']?>"
						data-src="xxxHTMLLINKxxx0.39186223192351520.41491856731872767xxx"
						alt=""/>
					</div>
				<?endif;?>
					<div class="article-item__wrapper">
							<div class="article-item__title"><?=isset($arItem['NAME']) ? $arItem['NAME'] : ''?></div>
							<div class="article-item__content"><?=isset($arItem['PREVIEW_TEXT']) ? $arItem['PREVIEW_TEXT'] : ''?></div>
					</div>
    		</a>
			<?endforeach;?>
		</div>
	</div>
<?endif;?>
