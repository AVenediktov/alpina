<script>
BX.ready(function(){
    // ������� ������� ��������
    $(".bookNameBask").each(function() {
        if($(this).length > 0) {
            $(this).html(truncate($(this).html(), 20));    
        }    
    });
});
</script>