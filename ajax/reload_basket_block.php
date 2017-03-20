<?php 
        require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
        CModule::IncludeModule("sale");
        CModule::IncludeModule("catalog"); 
        $arFields = array(
            "QUANTITY"=>$_POST["quantity"]
        );
        CSaleBasket::Update($_POST["id"], $arFields); 
        $APPLICATION->IncludeComponent("bitrix:sale.basket.basket", "hiding_basket", Array(
            "ACTION_VARIABLE" => "basketAction",    // �������� ���������� ��������
                "AUTO_CALCULATION" => "Y",    // ������������ �������
                "COLUMNS_LIST" => array(    // ��������� �������
                    0 => "NAME",
                    1 => "DISCOUNT",
                    2 => "DELETE",
                    3 => "DELAY",
                    4 => "TYPE",
                    5 => "PRICE",
                    6 => "QUANTITY",
                ),
                "CORRECT_RATIO" => "N",    // ������������� ������������ ���������� ������ ������� ������������
                "GIFTS_BLOCK_TITLE" => "�������� ���� �� ��������",    // ����� ��������� "�������"
                "GIFTS_CONVERT_CURRENCY" => "N",    // ���������� ���� � ����� ������
                "GIFTS_HIDE_BLOCK_TITLE" => "N",    // ������ ��������� "�������"
                "GIFTS_HIDE_NOT_AVAILABLE" => "N",    // �� ���������� ������, ������� ��� �� �������
                "GIFTS_MESS_BTN_BUY" => "�������",    // ����� ������ "�������"
                "GIFTS_MESS_BTN_DETAIL" => "���������",    // ����� ������ "���������"
                "GIFTS_PAGE_ELEMENT_COUNT" => "4",    // ���������� ��������� � ������
                "GIFTS_PLACE" => "BOTTOM",    // ����� ����� "�������"
                "GIFTS_PRODUCT_PROPS_VARIABLE" => "prop",    // �������� ����������, � ������� ���������� �������������� ������
                "GIFTS_PRODUCT_QUANTITY_VARIABLE" => "quantity",    // �������� ����������, � ������� ���������� ���������� ������
                "GIFTS_SHOW_DISCOUNT_PERCENT" => "Y",    // ���������� ������� ������
                "GIFTS_SHOW_IMAGE" => "Y",    // ���������� �����������
                "GIFTS_SHOW_NAME" => "Y",    // ���������� ��������
                "GIFTS_SHOW_OLD_PRICE" => "N",    // ���������� ������ ����
                "GIFTS_TEXT_LABEL_GIFT" => "�������",    // ����� ����� "�������"
                "HIDE_COUPON" => "N",    // �������� ���� ����� ������
                "PATH_TO_ORDER" => "/personal/cart/",    // �������� ���������� ������
                "PRICE_VAT_SHOW_VALUE" => "N",    // ���������� �������� ���
                "QUANTITY_FLOAT" => "N",    // ������������ ������� �������� ����������
                "SET_TITLE" => "Y",    // ������������� ��������� ��������
                "TEMPLATE_THEME" => "blue",    // �������� ����
                "USE_ENHANCED_ECOMMERCE" => "N",    // ���������� ������ ����������� �������� � Google � ������
                "USE_GIFTS" => "Y",    // ���������� ���� "�������"
                "USE_PREPAYMENT" => "N",    // ������������ ��������������� ��� ���������� ������ (PayPal Express Checkout)
                "COMPONENT_TEMPLATE" => ".default"
            ),
            false
        );
?>