<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");?>
<?require($_SERVER["DOCUMENT_ROOT"]."/tools/grotem_test/function.php");?>  
<?                   

//��������� Timestamp (���� �� ��), ��������� ��� ���������� ������
$ticks = tick_time();                            
                       
//������ ��������� ���� �������
$arSelect = Array("ID", "NAME", "PROPERTY_GUID");

$old_i = 5479;
$requestCount = 0;
for ($i = 5479; $i <= 5700; $i = $i + 10) {      
    $requestCount++;   
    $arFilter = Array("<ID" => $i, ">=ID" => $old_i, "IBLOCK_ID"=> CATALOG_IBLOCK_ID, "ACTIVE_DATE"=>"Y", "ACTIVE"=>"Y");                          
    $old_i = $i; 
    $res = CIBlockElement::GetList(Array(), $arFilter, false, Array(), $arSelect);
    $ChangedEntities = array();
    while($arFields = $res->fetch()) {   
        $db_res = CPrice::GetList(array(), array("PRODUCT_ID" => $arFields['ID'], "CATALOG_GROUP_ID" => PRICE_TYPE_ID));
        if ($ar_res = $db_res->Fetch()) {
            //���������� ������������� ������, ������� ����
            $GUID = $arFields['PROPERTY_GUID_VALUE'];        
              
            //����
            $price = $ar_res['PRICE']; 
             
            //������� ������� �� ����� ��������, ��� ��� ��� ���� ����� ������ � ������
            $arFields['NAME'] = str_replace("�",' ', $arFields['NAME']); 
            $arFields['NAME'] = str_replace('"','', $arFields['NAME']); 
            $arFields['NAME'] = str_replace("'",'', $arFields['NAME']);
            $name = $arFields['NAME']; 
            
            //������ ������ �� � ������ ���������� ������� ���������
            $unit = '���.';      
            
            //��� ����� ��������� ��� 000012345, ������������� � ������� ������� � ����, ����� 9 �������� 
            $code = str_pad($arFields['ID'], 9, "0", STR_PAD_LEFT);     
            
            //�������� ������ � �����������, ����� ������ � ���� �������
            $ChangedEntities[] = array(
                "Id"         => $GUID,
                "IsDeleted"  => false,    
                "Tablename"  => "Catalog.RIM", //�������� ������� � ������� ��� �������
                "SyncFilter" => null,
                "Fields"     => array(
                    "Id"           => $GUID,    //���������� ������������� � ������� ������
                    "Predefined"   => false,    //������� ����������������� ��������, �� �� ���
                    "DeletionMark" => false,    //������� ������� �� ��������, ����� ������� ������ � ��, �� �� �������, ����� ������ �� �����, ��
                    "Description"  => $name,    //������������                       
                    "Price"        => $price,    //����
                    "Service"      => false,    //������ ��� �����, ���� false �� �����         
                    "IsFolder"     => false,   
                    "Code"         => $code, //��� ������ � �������         
                    "Unit"         => $unit, //�����������                                           
                    "VAT"          => ALPINA_VAT10_GUID   //������������� ������������ ������� ��є (Enum.VATS)
                )
            );                            
        }             
    }         
            
    //���� �������
    $requestID = generateGUID();  
    $arBody = array (
        "Id" => $requestID, //������������� ������� 
        "TimestampFrom" => 0, //��������� �������� ���������� �������                                         
        "TimestampTo" => $ticks, //����� ���������� �������                         
        "DeletedEntities" => array(), //���� �� ��������, � ���� �� ���������� ����� ���� ������ �������                                    
        "ChangedEntities" => $ChangedEntities //���� �� ���������
    );                        
    //arshow($arBody['ChangedEntities']);                  
    //��������     
    $http_header = array(
        'Host: express.grotem.com', 
        'content-type: application/json',       
        'configname: GrotemExpress',           
        'configversion: 1.1.0.0',                      
        'deviceId: '.GROTEM_DEVICE_ID_GUID.'',  
        'Authorization: '.GROTEM_AUTHORIZATION_NEW.'',
        'Cache-Control: no-cache'
    );         
    $curlBody = json_encode($arBody);   
                         
    $curl = curl_init(); 
    curl_setopt($curl, CURLOPT_URL, GROTEM_REQUEST_FULLURL);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $http_header);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);                                    
    curl_setopt($curl, CURLOPT_POST, true);      
    curl_setopt($curl, CURLOPT_POSTFIELDS, $curlBody);                          
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);  
                                 
    echo "��������:".$i."<br>";                             
    $iteracia = json_decode(gzdecode($out));                                   
    //������ � ��������� ������
    if($out = curl_exec($curl)){          
        echo '��� ������'."<br>";                    
        //arshow($iteracia[0]);               
    } else {
        echo '������ �����������';            
    }                    
    curl_close($curl); 
    sleep(2); 
} 

//�������� ������ � �������� � ��
$el = new CIBlockElement;

$PROP = array();
$PROP[REQUEST_GUID_PROPERTY_ID] = $requestID;  // ������������� ��������
$PROP[TICKS_PROPERTY_ID] = $ticks;        // ���� �������� � �����

$arLoadProductArray = Array(                                                      
  "IBLOCK_ID"        => REQUEST_IBLOCK_ID,                                                   
  "DATE_ACTIVE_FROM" => new \Bitrix\Main\Type\DateTime(),
  "PROPERTY_VALUES"  => $PROP,
  "NAME"             => "�������� ".date('Y-m-d H:i:s'),                            
);          

if($PRODUCT_ID = $el->Add($arLoadProductArray))
  echo "New ID: ".$PRODUCT_ID;
else
  echo "Error: ".$el->LAST_ERROR;
?>                               
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>