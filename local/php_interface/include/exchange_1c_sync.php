<?
//Синхронизация остатков при выгрузке в инфоблок 1С
AddEventHandler("catalog", "OnProductUpdate", Array("Exchange1C", "SyncProductQuantity"));
AddEventHandler("catalog", "OnProductAdd", Array("Exchange1C", "SyncProductQuantity"));

//Уведомление и смена статуса с 0 остатках на сайте
AddEventHandler("catalog", "OnBeforeProductUpdate", Array("QuantityChanges", "QuantityOnZero"));
AddEventHandler("catalog", "OnBeforeProductUpdate", Array("QuantityChanges", "QuantityOnMoreThanZero"));

//Логирование изменений элементов
AddEventHandler("iblock", "OnAfterIBlockElementAdd", Array("Exchange1C", "SyncProductQuantityIblock"));
AddEventHandler("iblock", "OnAfterIBlockElementUpdate", Array("Exchange1C", "SyncProductQuantityIblock"));

class QuantityChanges {
    function QuantityOnZero($ID, $arFields) {
        if($arFields['QUANTITY'] <= 0 && CModule::IncludeModule('iblock')) {
            $arSelect = Array("CATALOG_QUANTITY", "PROPERTY_STATE", "NAME");
            $arFilter = Array("ID" => $ID, "IBLOCK_ID" => CATALOG_IBLOCK_ID, "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y");
            $res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
            if ($ob = $res->GetNextElement()) {
                $ar_product = $ob->GetFields();
                //Проверим не является ли предзаказом и не был ли ранее отстаток меньше 0, после чего отправим сообщение и поменяем статус
                if(($ar_product['PROPERTY_STATE_ENUM_ID'] != getXMLIDByCode(CATALOG_IBLOCK_ID, "STATE", "soon")) && ($ar_product['CATALOG_QUANTITY'] <= 0)) {
                    //Установим новое значение для данного свойства данного элемента
                    CIBlockElement::SetPropertyValuesEx($ID, false, array('STATE' => getXMLIDByCode(CATALOG_IBLOCK_ID, "STATE", "net_v_nal")));
                    $view_link = sprintf("https://www.alpinabook.ru/bitrix/admin/iblock_element_edit.php?IBLOCK_ID=%d&type=catalog&ID=%d", CATALOG_IBLOCK_ID, $ID);
                    $ar_template = array(
                        "NAME" => $ar_product['NAME'],
                        "URL"  => $view_link
                    );
                    CEvent::Send("CATALOG_PRODUCT_NOT_AVAILABLE", array("ru"), $ar_template);
                }
            }
        }
    }

    function QuantityOnMoreThanZero($ID, $arFields) {
        if($arFields['QUANTITY'] > 0 && CModule::IncludeModule('iblock')) {
            $arSelect = Array("CATALOG_QUANTITY", "PROPERTY_STATE", "NAME");
            $arFilter = Array("ID" => $ID, "IBLOCK_ID" => CATALOG_IBLOCK_ID, "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y");
            $res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
            if ($ob = $res->GetNextElement()) {
                $ar_product = $ob->GetFields();
                //Проверим не является ли предзаказом и не был ли ранее отстаток меньше 0, после чего отправим сообщение и поменяем статус
                if(($ar_product['PROPERTY_STATE_ENUM_ID'] == getXMLIDByCode(CATALOG_IBLOCK_ID, "STATE", "net_v_nal"))) {
                    //Установим новое значение для данного свойства данного элемента
                    CIBlockElement::SetPropertyValuesEx($ID, false, array('STATE' => getXMLIDByCode(CATALOG_IBLOCK_ID, "STATE", "")));
                    $view_link = sprintf("https://www.alpinabook.ru/bitrix/admin/iblock_element_edit.php?IBLOCK_ID=%d&type=catalog&ID=%d", CATALOG_IBLOCK_ID, $ID);
                    $ar_template = array(
                        "NAME" => $ar_product['NAME'],
                        "URL"  => $view_link
                    );
                    CEvent::Send("CATALOG_PRODUCT_AVAILABLE", array("ru"), $ar_template);
                }
            }
        }
    }
}

class Exchange1C {
    function SyncProductQuantity($ID, $arFields) {

        //Первый запрос для получения значения Bitrix ID
        $arSelect = Array("PROPERTY_ID_BITRIKS");
        $arFilter = Array("ID"=>$ID, "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y");
        $res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
        $bitrix_id = '';
        while($arResult = $res->Fetch()) {
            $bitrix_id = $arResult['PROPERTY_ID_BITRIKS_VALUE'];
        }
        $total_quantity = 0;
        if(!empty($bitrix_id)) {

            //Запрос для получения остатков у элементов, которые привязаны к тому же товару в каталоге
            $arSelect = Array("CATALOG_QUANTITY", "NAME");
            $arFilter_1 = Array("IBLOCK_ID"=>IBLOCK_1C_EXCHANGE, "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y", "PROPERTY_ID_BITRIKS_VALUE" => $bitrix_id);
            $cat = CIBlockElement::GetList(Array(), $arFilter_1, false, false, $arSelect);
            
            while($arCatalog = $cat->Fetch()) {
                $total_quantity = $total_quantity + intval($arCatalog['CATALOG_QUANTITY']);
                logger($arCatalog, $_SERVER["DOCUMENT_ROOT"].'/logs/log_1_catalog.log');
               // $name = $arCatalog['NAME'];
            }

             $bitrix_id_elem_info = CIBlockElement::GetList (array(), array("IBLOCK_ID" => CATALOG_IBLOCK_ID, "ID" => $bitrix_id), false, false, array("CATALOG_QUANTITY", "CANONICAL_PAGE_URL", "PROPERTY_STATE", "PROPERTY_reissue", "NAME"));
             if ($bitrix_id_elem = $bitrix_id_elem_info -> GetNext()) {
                  $quantity = $bitrix_id_elem["CATALOG_QUANTITY"];
                  $href = $bitrix_id_elem['CANONICAL_PAGE_URL'];
                  $state = $bitrix_id_elem['PROPERTY_STATE_ENUM_ID'];
                  $reissue = $bitrix_id_elem['PROPERTY_REISSUE_VALUE'];
                  $name = $bitrix_id_elem['NAME'];
                  
             }
            
            //Запросе на обновление остатков у товара
            $arField = array('QUANTITY' => $total_quantity);// зарезервированное количество
            CCatalogProduct::Update($bitrix_id, $arField);
            if($total_quantity > 0 && $quantity <= 0){
                if($state == STATE_SOON && $reissue == ""){
                    CIBlockElement::SetPropertyValuesEx($bitrix_id, false, array("STATE" => STATE_NEWS));
                } else if($state == STATE_SOON && $reissue == "Y"){
                    CIBlockElement::SetPropertyValuesEx($bitrix_id, false, array("STATE" => ""));
                } else if($state == STATE_NULL){
                    CIBlockElement::SetPropertyValuesEx($bitrix_id, false, array("STATE" => ""));
                }
                $mailFields = array(   // В наличии
                    "QUANTITY"=> 'В НАЛИЧИИ',
                    "PAGE_URL" => $href,
                    "NAME" => $name,
                );
                
                CEvent::Send("BOOK_AVAILABILITY", "s1", $mailFields, "N");
                logger('$total_quantity:'.$total_quantity, $_SERVER["DOCUMENT_ROOT"].'/logs/log_catalog_1.log');
                logger('$quantity:'.$quantity, $_SERVER["DOCUMENT_ROOT"].'/logs/log_catalog_1.log');
            } else if($total_quantity <= 0 && $quantity > 0 && $state != STATE_SOON){
             //   if($state == "NULL" || $state == STATE_NEWS){
                    CIBlockElement::SetPropertyValuesEx($bitrix_id, false, array("STATE" => STATE_NULL));
             //   }
                $mailFields = array(   // В наличии
                    "QUANTITY"=> 'НЕТ В НАЛИЧИИ',
                    "PAGE_URL" => $href,
                    "NAME" => $name,
                );
                
                CEvent::Send("BOOK_AVAILABILITY", "s1", $mailFields, "N");
                logger('$total_quantity:'.$total_quantity, $_SERVER["DOCUMENT_ROOT"].'/logs/log_catalog.log');
                logger('$quantity:'.$quantity, $_SERVER["DOCUMENT_ROOT"].'/logs/log_catalog.log');
            }

          //  if ($state_prop_enum_id != getXMLIDByCode (CATALOG_IBLOCK_ID, "STATE", "soon")) {
         //   }
        }
    }

    function SyncProductQuantityIblock($arFields) {

      //  logger('Iblock:', $_SERVER["DOCUMENT_ROOT"].'/logs/log_1c.log');
       // logger($arFields, $_SERVER["DOCUMENT_ROOT"].'/logs/log_1c.log');


    }
}
