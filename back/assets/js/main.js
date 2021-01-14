$(document).ready(function(){
    autosize(document.querySelectorAll('textarea'));
})

function maskInput(id,int = false){
    if (int) {
        $('#'+id).mask('###', {reverse: true});
    }
    else{
        $('#'+id).mask('###.###.###.###', {reverse: true});
    }
}

function showModalFacture(item){
    var resource_id = $(item).attr('data-resource_id') ,
    resource_type = $(item).attr('data-resource_type') ;
    
    $.post(root+'/ajax/showModalFacture', 
    {
        "resource_id":resource_id   
        ,"resource_type":resource_type
    },
    function(d){
        if (resource_type == 'article' || resource_type == 'historique') {
            $("#modalContent").removeClass('modal-md').addClass('modal-sm') ;
            $("div.modal-footer").html(d.modalFooter) ;
        }

        $('#showModal h4.modal_title').html(d.modal_title);
        $('#showModal .htmlWrapper').html(d.htmlWrapper);
        $('#showModal').modal('show');
    }, 'json');
}

function printFacture(item){
    var resource_id = $(item).attr('data-resource_id') ,
    resource_type = $(item).attr('data-resource_type') ;

    $.ajax({
        type: "POST",
        url:root+"/ajax/Createpdf/format/html" ,
        data: {"resource_id":resource_id,"resource_type":resource_type} ,
        dataType:"json" ,
        beforeSend: function (){
            $('.modal-content').block({ 
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
            $('.modal-content').unblock() ;

            $('#showModal').modal('hide');
            $.growl.notice({ title:"", message: "Facture imprimée avec succès"});
        }
    });
}

function generateCodeBarre(item){
    var resource_type = $(item).data('resource_type') ;

    $.post(root+'/ajax/generateCodeBarre',
    {
        "resource_type" : resource_type
    },
    function(d){
        $('input#'+d.attribute).val(d.string) ;
    }, 'json');
}

