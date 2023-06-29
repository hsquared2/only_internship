<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?if(!empty($arResult)):?>
	<ul style="display:flex; column-gap: 10px;">
		<?foreach($arResult as $item):?>
			<?if($item['SELECTED']):?>
				<li style="list-style: none;">
					<a href="<?=$item['LINK']?>" style="color:aqua;"><?=$item['TEXT']?></a>
				</li>
			<?else:?>
				<li style="list-style: none;">
					<a href="<?=$item['LINK']?>"><?=$item['TEXT']?></a>
				</li>
			<?endif;?>
		<?endforeach;?>
	</ul>
<?endif;?>