$(document).ready(function(){
    $(function(){ 
        $('#dataTable').dataTable({
            "bJQueryUI"  : true,
            "bAutoWidth" : false,
            "bProcessing": false,
            "bServerSide": true,
            "sAjaxSource": root+"/articles/getAllArticles/format/html",
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
                { "bSortable": true },
                { "bSortable": true },
                { "bSortable": true },
                { "bSortable": true },
                { "bSortable": true },
                { "bSortable": true },
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
            url:root+"/articles/modify/format/html" ,
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

                if(d.state == 'success') {
                    $.growl.notice({ title:"", message: d.msg });
                    $('#showModal').modal('hide');
                    $('#dataTable').dataTable().fnDraw();
                }
                else if($.inArray(d.state,['empty_name','empty_quantite','empty_condition','short_code_barre','exist_codebarre']) ){
                    $.growl.warning({ title:"", message: d.msg });
                }
            }
        });
    });
})

function prixVente(){
    $("input#pourcentage").keyup(function(event) {
        var pourcentage = $('input#pourcentage').val(),
        prix_achat = $('input#prix_achat').val() ;

        $.post(root+'/articles/vente', 
        {
            "pourcentage":pourcentage   
            ,"prix_achat":prix_achat
        },
        function(d){
            if (d.state == 'empty_prix_achat') {
                $.growl.error({ title:"", message: d.msg });
                $('input#pourcentage').val("");
                $('input#prix_article').val("");
            }
            else{
                $('input#prix_article').val(d.prix_article) ;
            }
        }, 'json');
    });
}

function pourcentage(){
    $("input#prix_article").keyup(function(event) {
        var prix_article = $('input#prix_article').val(),
        prix_achat = $('input#prix_achat').val() ;

        $.post(root+'/articles/pourcentage', 
        {
            "prix_article":prix_article   
            ,"prix_achat":prix_achat
        },
        function(d){
            if (d.state == 'empty_prix_achat') {
                $.growl.error({ title:"", message: d.msg });
                $('input#pourcentage').val("");
                $('input#prix_article').val("");
            }
            else{
                if(d.state === 'error_pourcentage'){
                    $('span.alert_pourcentage').removeClass('hide') ;
                    $('input#pourcentage').val("") ;
                }
                else{
                    $('span.alert_pourcentage').addClass('hide') ;
                    $('input#pourcentage').val(d.pourcentage) ;
                }
            }
        }, 'json');
    });
}


function textareaAutosize(){
    autosize(document.querySelectorAll('textarea'));
}

function showModal(item){
    var resource_id = $(item).attr('data-resource_id') ,
    resource_type = $(item).attr('data-resource_type') ;

    $.post(root+'/articles/showmodal', 
    {
        "resource_id":resource_id   
        ,"resource_type":resource_type
    },
    function(d){
       $('#showModal h4.modal_title').html(d.modal_title);
       $('#showModal .htmlWrapper').html(d.htmlWrapper);
       textareaAutosize() ;
       maskInput('prix_achat',true) ;
       maskInput('prix_article',true) ;
       maskInput('pourcentage',true) ;
       maskInput('codebarre_article',true) ;
       maskInput('nbre_stock_article',true) ;
       onKeyUpCodeBarre() ;
       pourcentage() ;
       prixVente() ;
       $('#showModal').modal('show');
    }, 'json');
}

function deleteArticle(item)
{
    var resource_id = $(item).attr('data-resource_id') ;

    swal({
        title: "Supprimer cette Article ?" ,
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
                url:root+"/articles/delete/format/html",
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

/*CODE BARRE*/
function onKeyUpCodeBarre()
{
    maskInput('codebarre_article',true) ;
    $("input#codebarre_article").keyup(function(event) {
        var value = $('input#codebarre_article').val() ;

        if (value.length > 13) {
            $.growl.error({ title:"", message: "07 chiffres maximum" });
            $("input#codebarre_article").val("") ;
        }
        
    });
}

function ShowCB (item) {   
    var code = $(item).data('barcode') ,
    nom_article = $(item).data('nom_article') ,
    uniqid = $(item).data('uniqid') ,
    taille = $(item).data('taille') ,
    prix = $(item).data('prix') ,
    bool ;

    $('input[type=hidden]#CB_cache').val(code);
    $('input[type=hidden]#nom_article').val(nom_article);
    $('input[type=hidden]#aritcle_uniqid').val(uniqid);
    $('input[type=hidden]#article_taille').val(taille);
    $('input[type=hidden]#article_prix').val(prix);

    JsBarcode("#img_CB_modal")
    .options({
        font: "OCR-B"
        ,valid:function(res){
            bool = res ;
        }
    }) 
    .EAN13(code, {fontSize: 20, textMargin: 1, height:75, fontOptions: "bold"})    
    .render();

    if (bool) {
        $('#CB_Modal').modal();
    }
    else{
        $.growl.error({ title:"", message: "Code barre erronné. Veuillez en génerer un autre" });
    }
}

// function print_CB_modal(item) {
//     var code_barre = $('#CB_cache').val() ,
//     imgData;

//     html2canvas($("#img_result"), {
//         useCORS: true,
//         onrendered: function (canvas) {
//             imgData = canvas.toDataURL(
//             'image/png');
//             var doc = new jsPDF("l","mm",[30,40]);
//             doc.addImage(imgData, 'PNG', 0, 3, 46, 15); 
//             // doc.setFontType("bold");
//             doc.setFontSize(8);  
//             doc.save(code_barre+'.pdf');
//         }
//     });
// }

function print_CB_modal(item) {
    var code_barre = $('input[type=hidden]#CB_cache').val() ,
    nom_article = $('input[type=hidden]#nom_article').val() ,
    uniqid = $('input[type=hidden]#aritcle_uniqid').val() ,
    taille = $('input[type=hidden]#article_taille').val() ,
    prix = $('input[type=hidden]#article_prix').val() ,
    imgData;

    html2canvas($("#img_result"), {
        useCORS: true,
        onrendered: function (canvas) {
            imgData = canvas.toDataURL(
            'image/png');
            var doc = new jsPDF("l","mm",[30,40]); 
            doc.setFontType("bold");
            doc.setFontSize(5);
            if (nom_article.length>=34){
                var C1 = nom_article.substring(0,33);
                var C2 = nom_article.substring(33,nom_article.length);
                doc.text(5, 3,'Nom : '+C1+'-');
                doc.text(5, 6,C2);
                doc.text(5, 9,'Ref :'+uniqid);
                doc.text(25, 9,'Prix : Ar '+prix);
            } 
            else
            {
                doc.text(5, 3,'Nom : '+nom_article);
                doc.text(5, 6, 'Ref : '+uniqid);
                doc.text(5, 9,'Prix : Ar '+prix);
            }             
            // X Y
            doc.addImage(imgData, 'PNG', 0, 10, 46, 15);
            doc.setFontSize(13);
            doc.text(18, 28,taille);


            // X Y largeur hauteur
            doc.save(code_barre+'.pdf');
            doc.print(code_barre+'.pdf');
            //window.print(doc);
        }
    });
}