<?php 
        require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
        CModule::IncludeModule("sale");
        CModule::IncludeModule("catalog"); 
        $arFields = array(
            "QUANTITY"=>$_POST["quantity"]
        );
        CSaleBasket::Update($_POST["id"], $arFields); 
        $APPLICATION->IncludeComponent("bitrix:sale.basket.basket.small", "hiding_basket", Array(
        "PATH_TO_BASKET" => "/personal/basket.php",    // �������� �������
        "PATH_TO_ORDER" => "/personal/order.php",    // �������� ���������� ������
        "SHOW_DELAY" => "Y",    // ���������� ���������� ������
        "SHOW_NOTAVAIL" => "Y",    // ���������� ������, ����������� ��� �������
        "SHOW_SUBSCRIBE" => "Y",    // ���������� ������, �� ������� �������� ����������
    ),
    false
);

?>