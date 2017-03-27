<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div id="rfi_wrapper">
<? if ($arResult['PAYED'] == "Y") { ?>
	<p><?= GetMessage("PAYED") ?></p>
<? } else { ?>
	<a  class="rfi_button submit_rfi" 
		data-open="widget"
		data-key="<?= $arResult['KEY'] ?>"
		data-cost="<?= $arResult['PRICE'] ?>"
		data-name="<?= $arResult['COMMENT'] ?>"
		data-email="<?= $arResult['EMAIL'] ?>"
		data-phone="<?= $arResult['PHONE'] ?>"
		data-comment="<?= $arResult['ORDER_ID'] ?>"
		<? if ($arResult['ORDER_ID']) { ?>
			data-orderid="<?= $arResult['ORDER_ID'] ?>"
		<? } ?>
		href="#">
		<?= GetMessage("PAY") ?>
	</a>
<? } ?>
</div>