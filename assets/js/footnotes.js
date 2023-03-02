jQuery(document).ready(function ($) {
    var dt;
    $('#scan').click(function(){
        if (!$.fn.DataTable.fnIsDataTable(dt)){
            $('#linksTable').show();
            dt = $('#linksTable').DataTable({
                retrive:true,
                processing: true,
                ajax: {
                    url: "/wp-admin/admin-ajax.php?action=links_endpoint",
                    cache: false,
                    
                },
                columns: [
                    { data: 'url' },
                    { data: 'status' },
                    { data: 'permalink'}
                ],
                pageLength: 10
            }); 
        }else{
            //prevent reinitilize
            $('#linksTable').DataTable().ajax.reload();
        }
    })
    
});
