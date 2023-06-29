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
			<?foreach($arResult['ITEMS'] as $item):?>
				<?
					$this->AddEditAction($item['ID'], $item['EDIT_LINK'], CIBlock::GetArrayByID($item["IBLOCK_ID"], "ELEMENT_EDIT"));
					$this->AddDeleteAction($item['ID'], $item['DELETE_LINK'], CIBlock::GetArrayByID($item["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
				?>
				<a class="article-item article-list__item" href="<?=isset($item['PROPERTIES']['LINK']['VALUE']) ? $item['PROPERTIES']['LINK']['VALUE'] : '#'?>"
				data-anim="anim-3" id="<?=$this->GetEditAreaId($item['ID']);?>">
					<div class="article-item__background">
						<?if(!empty($item['PREVIEW_PICTURE']['SRC'])):?>
							<img src="<?=$item['PREVIEW_PICTURE']['SRC']?>"
							data-src="xxxHTMLLINKxxx0.39186223192351520.41491856731872767xxx"
							alt=""/>
						<?endif;?>
					</div>
					<div class="article-item__wrapper">
							<div class="article-item__title"><?=isset($item['NAME']) ? $item['NAME'] : '' ?></div>
							<div class="article-item__content"><?=isset($item['PREVIEW_TEXT']) ? $item['PREVIEW_TEXT'] : ''?>
							</div>
					</div>
				</a>
			<?endforeach;?>				
		</div>
	</div>
<?endif;?>
