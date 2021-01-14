$(document).ready(function(){
    $(function(){ 
        $('#dataTable').dataTable({
            "bJQueryUI"  : true,
            "bAutoWidth" : false,
            "bProcessing": false,
            "bServerSide": true,
            "sAjaxSource": root+"/users/getAllUsers/format/html",
            "sPaginationType": "full_numbers",
            // "sDom": '<"datatable-header"fril>t<"datatable-footer"p>',
            "aLengthMenu": [[5, 10, 25, 50, 100, -1], [5, 10, 25, 50, 100, "All"]],
            "iDisplayLength" : 10,
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
                { "bSortable": false },
                { "bSortable": false }
            ],
            "fnDrawCallback": function (oSettings) {
                $('.dataTables_filter input').attr("placeholder", "Votre recherche ici ...");
            }
        });          
    });

    $('form#modify').submit(function(e){
        e.preventDefault();

        var data = $('form#modify').serialize() ;

        $.ajax({
            type: "POST",
            url:root+"/users/modify/format/html" ,
            data: data ,
            dataType:"json" ,
            beforeSend: function (){
              $('form#modify').block({ 
                message: '<i class="fa fa-spinner fa fa-2x fa-spin" style="color:#000;"></i>',
                overlayCSS: {
                    backgroundColor: '#fff',
                    opacity: 0.8,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
              });
            },
            success: function (d) {
                $('form#modify').unblock() ;

                if (d.state == 'empty_name') {
                    $.growl.warning({ title:"", message: d.msg });
                }
                else if(d.state == 'success') {
                    $.growl.notice({ title:"", message: d.msg });
                    $('#showModal').modal('hide');
                    $('#dataTable').dataTable().fnDraw();
                }
            }
        });
    }) ;
})

function textareaAutosize(){
    autosize(document.querySelectorAll('textarea'));
}

function showModal(item){
    var resource_id = $(item).attr('data-resource_id') ,
    resource_type = $(item).attr('data-resource_type') ;

    $.post(root+'/users/showmodal', 
    {
        "resource_id":resource_id   
        ,"resource_type":resource_type
    },
    function(d){
       $('#showModal h4.modal_title').html(d.modal_title);
       $('#showModal .htmlWrapper').html(d.htmlWrapper);
       textareaAutosize() ;
       $('#showModal').modal('show');
    }, 'json');
}

function deleteUser(item)
{
    var resource_id = $(item).attr('data-resource_id') ;

    swal({
        title: "Supprimer cet utilisateur ?" ,
        showCancelButton: true,
        confirmButtonColor: "#EF5350",
        confirmButtonText: "Oui",
        cancelButtonText: "Non",
        closeOnConfirm: false,
    },
    function(isConfirm){
        if (isConfirm) {
            $.ajax({
                type: "POST",
                url:root+"/users/delete/format/html",
                data: {"resource_id":resource_id},
                dataType: "json",
                success: function (data) {
                    swal({
                        title: data.msg,
                        confirmButtonColor: "#66BB6A",
                        type: "success"
                    });
                    $('#dataTable').dataTable().fnDraw();
                }
            });
        }
    });
}

function showPassword(item){
    var user_id = $(item).data('user_id') ;

    $.post(root+'/users/showPassword', 
    {
        "user_id":user_id   
    },
    function(d){
        $('span#hiddenPassword_'+user_id).text(d) ;
    }, 'json');
}