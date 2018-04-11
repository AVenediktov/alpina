<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Мероприятия");
?><?$APPLICATION->IncludeComponent(
    "bitrix:news",
    "events",
    Array(
        "ADD_ELEMENT_CHAIN" => "Y",
        "ADD_SECTIONS_CHAIN" => "N",
        "AJAX_MODE" => "N",
        "AJAX_OPTION_ADDITIONAL" => "",
        "AJAX_OPTION_HISTORY" => "N",
        "AJAX_OPTION_JUMP" => "N",
        "AJAX_OPTION_SHADOW" => "Y",
        "AJAX_OPTION_STYLE" => "Y",
        "BROWSER_TITLE" => "-",
        "CACHE_FILTER" => "N",
        "CACHE_GROUPS" => "N",
        "CACHE_TIME" => "36000000",
        "CACHE_TYPE" => "A",
        "CHECK_DATES" => "N",
        "COMPONENT_TEMPLATE" => "events",
        "DETAIL_ACTIVE_DATE_FORMAT" => "j F Y",
        "DETAIL_DISPLAY_BOTTOM_PAGER" => "Y",
        "DETAIL_DISPLAY_TOP_PAGER" => "N",
        "DETAIL_FIELD_CODE" => array(0=>"DETAIL_PICTURE",1=>"",),
        "DETAIL_PAGER_SHOW_ALL" => "Y",
        "DETAIL_PAGER_TEMPLATE" => "arrows",
        "DETAIL_PAGER_TITLE" => "Страница",
        "DETAIL_PROPERTY_CODE" => array(0=>"",1=>"DESCRIPTION",2=>"SOURCE",3=>"KEYWORDS",4=>"",),
        "DETAIL_SET_CANONICAL_URL" => "N",
        "DETAIL_STRICT_SECTION_CHECK" => "N",
        "DISPLAY_BOTTOM_PAGER" => "Y",
        "DISPLAY_DATE" => "Y",
        "DISPLAY_NAME" => "Y",
        "DISPLAY_PANEL" => "Y",
        "DISPLAY_PICTURE" => "Y",
        "DISPLAY_PREVIEW_TEXT" => "Y",
        "DISPLAY_TOP_PAGER" => "N",
        "HIDE_LINK_WHEN_NO_DETAIL" => "N",
        "IBLOCK_ID" => "40",
        "IBLOCK_TYPE" => "events",
        "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
        "LIST_ACTIVE_DATE_FORMAT" => "j F Y",
        "LIST_FIELD_CODE" => array(0=>"ID",1=>"NAME",2=>"PREVIEW_TEXT",3=>"PREVIEW_PICTURE",4=>"DETAIL_TEXT",5=>"DETAIL_PICTURE",6=>"DATE_ACTIVE_FROM",7=>"ACTIVE_FROM",8=>"DATE_ACTIVE_TO",9=>"ACTIVE_TO",10=>"",),
        "LIST_PROPERTY_CODE" => array(0=>"EVENT_LOCATION",1=>"",),
        "MEDIA_PROPERTY" => "",
        "MESSAGE_404" => "",
        "META_DESCRIPTION" => "-",
        "META_KEYWORDS" => "-",
        "NEWS_COUNT" => "10000",
        "NUM_DAYS" => "180",
        "NUM_NEWS" => "24",
        "PAGER_BASE_LINK_ENABLE" => "N",
        "PAGER_DESC_NUMBERING" => "N",
        "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000000",
        "PAGER_SHOW_ALL" => "N",
        "PAGER_SHOW_ALWAYS" => "N",
        "PAGER_TEMPLATE" => "arrows",
        "PAGER_TITLE" => "Новости",
        "PREVIEW_TRUNCATE_LEN" => "300",
        "SEF_FOLDER" => "/events/",
        "SEF_MODE" => "Y",
        "SEF_URL_TEMPLATES" => array("news"=>"","section"=>"","detail"=>"#ELEMENT_ID#/",),
        "SET_LAST_MODIFIED" => "N",
        "SET_STATUS_404" => "Y",
        "SET_TITLE" => "Y",
        "SHOW_404" => "N",
        "SLIDER_PROPERTY" => "",
        "SORT_BY1" => "ACTIVE_FROM",
        "SORT_BY2" => "SORT",
        "SORT_ORDER1" => "DESC",
        "SORT_ORDER2" => "DESC",
        "TEMPLATE_THEME" => "site",
        "USE_CATEGORIES" => "N",
        "USE_FILTER" => "N",
        "USE_PERMISSIONS" => "N",
        "USE_RATING" => "N",
        "USE_REVIEW" => "N",
        "USE_RSS" => "N",
        "USE_SEARCH" => "N",
        "USE_SHARE" => "N",
        "YANDEX" => "N"
    )
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>