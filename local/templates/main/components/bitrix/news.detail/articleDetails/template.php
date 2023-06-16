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
<?if(isset($arResult['ID'])):?>
	<div class="article-card">
    <div class="article-card__title"><?=isset($arResult['NAME']) ? $arResult['NAME'] : ''?></div>
    <div class="article-card__date"><?=isset($arResult['DATE_CREATE']) ? $arResult['DATE_CREATE'] : ''?></div>
    <div class="article-card__content">
        <div class="article-card__image sticky">
					<?if(!empty($arResult['DETAIL_PICTURE'])):?>
						<img 
						src="<?=$arResult['DETAIL_PICTURE']['SRC']?>" alt="" data-object-fit="cover"/>
					<?endif;?>
        </div>
        <div class="article-card__text">
            <div class="block-content" data-anim="anim-3"><?=isset($arResult['DETAIL_TEXT']) ? $arResult['DETAIL_TEXT'] : ''?></div>
            <a class="article-card__button" href="<?=$arResult['LIST_PAGE_URL']?>">Назад к новостям</a></div>
    </div>
	</div>
<?endif;?>



<?echo "<pre>";
print_r($arResult);
echo "</pre>";
?>