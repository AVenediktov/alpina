<?
    require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("");
?><!--<script src="https://paybox-global.platbox.com/widget/v1/index.js"></script>
После того, как скрипт загрузится, на странице появится глобальный объект PBWidget. Создайте экземпляр объекта, передав в качестве аргументов merchantId, projectName, account, container.
<br>
<a href='#' class='js-buy'>Купить</a>
<script>
var payWidget = new PBWidget(
    'merchantId',
    'projectName',
    'account',
    document.getElementById('payment-form')
);

$('.js-buy').on('click', function () {
    alert(1);
    payWidget.renderPayForm('order', 1000);
});
</script> -->


<?
$json = '{"action":"check","platbox_tx_id":"41151","platbox_tx_created_at":"2018-02-02T16:29:52Z","product":"alpinabook \u0418\u042d","payment":{"amount":49900,"currency":"RUB","exponent":2},"account":{"id":"test@test.ru","location":"","additional":null},"order":{"type":"order_id","order_id":"114497"},"merchant_extra":{},"payer":null,"payment_extra":[]}';
$ch = curl_init();    
curl_setopt($ch, CURLOPT_URL, "http://dev-alpinabook.webgk.ru/personal/order/payment/result.php");
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST"); 
curl_setopt($ch, CURLOPT_POSTFIELDS, $json);   
curl_setopt($ch, CURLOPT_HEADER, true); 
//curl_setopt($ch, CURLOPT_NOBODY, true); 
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
 'Content-Type: application/json',
 'Content-Length: ' . strlen($json))
);    
$result = curl_exec($ch);                 
//logger($result, $_SERVER["DOCUMENT_ROOT"].'/logs/log_platbox.txt');


?>
&nbsp;<?/*$APPLICATION->IncludeComponent(
    "bitrix:socserv.auth.split",
    "",
    Array(
        "SHOW_PROFILES" => "Y",
        "ALLOW_DELETE" => "Y"
    ),
false
); */

 /*
$users = array();
$emails_arr = array();
$temp_users_arr = array();
$original_users_list = array();
$original_users_emails = array();
$emails_list = array();
$users_list = CUser::GetList ($by = "id", $order = "desc", array("LOGIN" => "newuser"), array("ID", "LOGIN", "EMAIL"));
$users_count = 0;*/
/*while ($users_fetch = $users_list -> Fetch()) {
    if (strlen($users_fetch["EMAIL"]) > 0) {
        $users[strtolower($users_fetch["EMAIL"])][] = array("ID" => $users_fetch["ID"], "LOGIN" => $users_fetch["LOGIN"]);
    }
}*/ /*
$i = 0;
while ($users_fetch = $users_list -> Fetch()) {
    //if ($i < 500) {
        if (strlen($users_fetch["EMAIL"]) > 0) {
            $emails_list[] = $users_fetch["EMAIL"];
        }
    //}
    //$i++;
}
$emails_list = array_unique($emails_list);
foreach ($emails_list as $curr_email) {
    $users_list_by_email = CUser::GetList ($by = "id", $order = "desc", array("EMAIL" => $curr_email), array("ID", "LOGIN", "EMAIL"));
    while ($users_by_email = $users_list_by_email -> Fetch()) {
            $users[strtolower($users_by_email["EMAIL"])][] = array("ID" => $users_by_email["ID"], "LOGIN" => $users_by_email["LOGIN"]);
    }
}

foreach ($users as $email => $val) {
    //if ($i < 500) {
        foreach ($val as $key => $arr) {
            $temp_users[$email][] = array("ID" => $arr["ID"], "LOGIN" => $arr["LOGIN"]);
    //    }

     //   $i++;
    }
}
$j = 0;
foreach ($temp_users as $email => $val) {
        foreach ($val as $key => $arr) {
            if ((($arr["LOGIN"] != $email && strstr($arr["LOGIN"], "newuser")) *//*&& $email == "newuser@alpinabook.ru")*/ /*&& isset($arr["ID"]) && $arr["ID"] != $original_users_list[$email])) {
                //if ($j < 50) {
                    $emails_arr[$email][] = $arr["ID"];
               // }
               // $j++;
            } else if ($arr["LOGIN"] == $email || ($arr["LOGIN"] != $email && !strstr($arr["LOGIN"], "newuser"))){
                $original_users_list[$email] = $arr["ID"];
                $original_users_emails[] = $email;
            }
        }
}
$original_users_list["newuser@alpinabook.ru"] = 2940;
$original_users_emails[] = "newuser@alpinabook.ru";
$orders_arr = array();
$users_copies = array();
foreach ($emails_arr as $email => $email_arr) { */
    /*$order_list = CSaleOrder::GetList (array(), array("USER_ID" => $email_arr));
    while ($order = $order_list -> Fetch()) {
        $orders[$email][] = $order["ID"];
    }*//*
    if (in_array($email, $original_users_emails) && !empty($email_arr)){
         //echo $i . "<br>";
         foreach ($email_arr as $curr_email) {
             $order_list = CSaleOrder::GetList (array(), array("USER_ID" => $curr_email));
             while ($order_id = $order_list -> Fetch()) {
                 $orders_arr[$email][] = $order_id["ID"];
             }
         }
         //arshow($emails_arr[$email]);
      }
}
*/
/*foreach ($users as $email => $val) {
    foreach ($val as $key => $arr) {
        if ($arr["LOGIN"] != $email && strstr($arr["LOGIN"], "newuser")) {
            $emails_arr[$email][] = $arr["ID"];
        }
    }
}
$orders = array();
arshow($orders);*/
//arshow($orders_arr);
/*foreach ($orders_arr as $email => $val) {
         $arFields = array("USER_ID" => $original_users_list[$email]);
         foreach ($val as $key => $order_id) {
             if (strlen($order_id) > 0) {
                 $this_order_info = CSaleOrder::GetByID($order_id);
                 $this_delivery_info = CSaleDelivery::GetList(array(), array("LID" => SITE_ID, "ID" => $this_order_info["DELIVERY_ID"]), false, false, array());
                 $delivery_info_rows = $this_delivery_info -> SelectedRowsCount();

                 if (strlen($this_order_info["PAY_SYSTEM_ID"]) <= 0 || $this_order_info["PAY_SYSTEM_ID"] == 0) {
                     $arFields["PAY_SYSTEM_ID"] = 11;
                 }
                 if (strlen($this_order_info["DELIVERY_ID"]) <= 0 || $this_order_info["DELIVERY_ID"] == 0 || $delivery_info_rows <= 0) {
                     $arFields["DELIVERY_ID"] = 2;
                 }
              // CSaleOrder::Update ($order_id, $arFields);
             }
    }

}
arshow($emails_arr);
//arshow($original_users_list);
foreach ($emails_arr as $email => $user_copies_arr) {
     if (!empty($user_copies_arr) && in_array($email, $original_users_emails)) {
             foreach ($user_copies_arr as $user_copy_id) {
                $user_info = CSaleUserAccount::GetByUserID($user_copy_id, "RUB");
                if($user_info["CURRENT_BUDGET"] > 0) {
                 //  CSaleUserAccount::Update($user_info["ID"], array("CURRENT_BUDGET" => 0));
                }
                // CUser::Delete($user_copy_id);
             }
     }
}*/?><?
  // обновление данных highload инфоблока
/*    use Bitrix\Highloadblock as HL;
    CModule::IncludeModule("iblock");
    $arSelect = Array("ID", "PROPERTY_page_views_ga", "PROPERTY_FOR_ADMIN");
    $arFilter = Array("IBLOCK_ID" => 4, "ACTIVE"=>"Y");
    $res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);

    $hlblock = HL\HighloadBlockTable::getById(3)->fetch();

    $entity = HL\HighloadBlockTable::compileEntity($hlblock);
    $entity_data_class = $entity->getDataClass();

    while($arFields = $res->GetNext())
    {

        $arHLData['UF_PAGE_VIEWS_GA'] = $arFields['PROPERTY_PAGE_VIEWS_GA_VALUE'];
        $arHLData['UF_FOR_ADMIN'] = $arFields['PROPERTY_FOR_ADMIN_VALUE'];
        $arHLData['UF_IBLOCK_ID'] = $arFields['ID'];

        if($arHLData){


            $rsElementID = $entity_data_class::getList(array(
               "select" => array("ID"),
               "order"  => array("ID" => "ASC"),
               "filter" => array('UF_IBLOCK_ID' => $arHLData['UF_IBLOCK_ID'])
            ));
            if($arElementID = $rsElementID->Fetch()){

                $result = $entity_data_class::update($arElementID['ID'], $arHLData);

            }
        }
    }
                */

?><br><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>