<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");?>
<?require($_SERVER["DOCUMENT_ROOT"]."/tools/grotem_test/function.php");?>  
<?  
//��������� Timestamp (���� �� ��), ��������� ��� ���������� ������
$ticks = tick_time();                            
                                              
//������ ��������� ���� �������
$arSelect = Array("ID", "NAME", "PROPERTY_GUID");
$arFilter = Array("IBLOCK_ID"=> CATALOG_IBLOCK_ID, "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y");
$res = CIBlockElement::GetList(Array(), $arFilter, false, Array(), $arSelect);
while($arFields = $res->fetch()) {
        //���������� ������������� ������, ������� ����
        $GUID = generateGUID();    
        
        //������� GUID � ���� ��������� GUID - ���������� ������������� � ������� ������   
        $PROPERTY_CODE = "GUID";  // ��� ��������
        $PROPERTY_VALUE = $GUID;  // �������� ��������

        // ��������� ����� �������� ��� ������� �������� ������� ��������
        //CIBlockElement::SetPropertyValuesEx($arFields['ID'], false, array($PROPERTY_CODE => $PROPERTY_VALUE));    
}                                     
?>
<?echo 'end';?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>