<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
    if(count($arResult["PERSON_TYPE"]) > 1)
    {
    ?>
    <div class="section">
        <p class="blockTitle">Тип плательщика</p>
        <?foreach($arResult["PERSON_TYPE"] as $v):?>
            <input class="radioInp" type="radio" id="PERSON_TYPE_<?=$v["ID"]?>" name="PERSON_TYPE" value="<?=$v["ID"]?>"<?if ($v["CHECKED"]=="Y") echo " checked=\"checked\"";?> onClick="submitForm()">
            <?if($v["ID"] == 2){ ?>  
                <label class="faceText" for="PERSON_TYPE_<?=$v["ID"]?>"><?=$v["NAME"]?> (ООО, ИП и т.д.)</label>
            <?} else {?>
                <label class="faceText" for="PERSON_TYPE_<?=$v["ID"]?>"><?=$v["NAME"]?></label>
            <?}?>
            <?endforeach;?>
        <input type="hidden" name="PERSON_TYPE_OLD" value="<?=$arResult["USER_VALS"]["PERSON_TYPE_ID"]?>" />
    </div>
    <?
    }
    else
    {
        if(IntVal($arResult["USER_VALS"]["PERSON_TYPE_ID"]) > 0)
        {
            //for IE 8, problems with input hidden after ajax
        ?>
        <span style="display:none;">
            <input type="text" name="PERSON_TYPE" value="<?=IntVal($arResult["USER_VALS"]["PERSON_TYPE_ID"])?>" />
            <input type="text" name="PERSON_TYPE_OLD" value="<?=IntVal($arResult["USER_VALS"]["PERSON_TYPE_ID"])?>" />
        </span>
        <?
        }
        else
        {
            foreach($arResult["PERSON_TYPE"] as $v)
            {
            ?>
            <input type="hidden" id="PERSON_TYPE" name="PERSON_TYPE" value="<?=$v["ID"]?>" />
            <input type="hidden" name="PERSON_TYPE_OLD" value="<?=$v["ID"]?>" />
            <?
            }
        }
    }
?>
<div class="grayLine"></div>