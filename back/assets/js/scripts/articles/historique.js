$(document).ready(function(){
    $(function(){ 
        var article_id = $('#dataTable').attr('data-article_id') ;


        $('#dataTable').dataTable({
            "bJQueryUI"  : true,
            "bAutoWidth" : false,
            "bProcessing": false,
            "bServerSide": true,
            "sAjaxSource": root+"/articles/getHistorique/article_id/"+article_id+"/format/html",
            "sPaginationType": "full_numbers",
            // "sDom": '<"datatable-header"fril>t<"datatable-footer"p>',
            "aLengthMenu": [[10, 25, 50, 100, 200, -1], [10, 25, 50, 100, 200, "All"]],
            "iDisplayLength" : 100,
            "oLanguage": {
             "sSearch": "_INPUT_",
             "sLengthMenu": "<span>Entrées : </span> _MENU_",
             "oPaginate": { "sFirst": "Première page", "sLast": "Dernière page", "sNext": ">", "sPrevious": "<" }
            },
            "aoColumns": [
                { "bSortable": true },
                { "bSortable": true },
                { "bSortable": true },
                { "bSortable": true },
                { "bSortable": true }
            ],
            "fnDrawCallback": function (oSettings) {
                $('.dataTables_filter input').attr("placeholder", "Votre recherche ici ...");
            }
        });          
    });
})