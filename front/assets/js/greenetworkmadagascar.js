function autosizeTextarea()
{
  autosize(document.querySelectorAll('textarea'));
}

function notie_notification(type,message){
    // notie.alert({ type: type, text: message }) ;
    notie.alert({ type: type, text: message, time: "" ,position :"bottom"}) ;
}


/*pagination*/
$(document).on( 'click', '#btn-previous', previous);
$(document).on( 'click', '#btn-next', next);
$(document).on( 'click', '#go-to', gotopage);

function next(){
  var page = $(this).data('page'),
  resource_type = $('nav.pagination').attr('data-resource_type') ,
  resource_id = $('nav.pagination').attr('data-resource_id') ;

  var data = {
    "resource_type":resource_type
    ,"resource_id":resource_id
  };

  $.ajax({
      type: "POST",
      url:baseUrl+"/ajax/get/format/html?page="+page,
      data: data,
      dataType : "json",
      // beforeSend: function (){
      //   $('.bloc__result').block({ 
      //     message: '<i class="fa fa-spinner fa fa-2x fa-spin" style="color:#000;"></i>',
      //     overlayCSS: {
      //         backgroundColor: '#fff',
      //         opacity: 0.8,
      //         cursor: 'wait'
      //     },
      //     css: {
      //       border: 0,
      //       padding: 0,
      //       backgroundColor: 'transparent'
      //     }
      //   });
      // },
      success: function (d) {
        // $('.bloc__result').unblock();
        $('.bloc__result').html(d.result);
        initOwlCarousel() ;
        window.history.pushState( {} , '', d.url );
      }
  });
}

function previous(){
  var page = $(this).data('page'),
  resource_type = $('nav.pagination').attr('data-resource_type') ,
  resource_id = $('nav.pagination').attr('data-resource_id') ;

  var data = {
    "resource_type":resource_type
    ,"resource_id":resource_id
  };

  $.ajax({
    type: "POST",
    url:baseUrl+"/ajax/get/format/html?page="+page,
    data: data,
  	dataType : "json",
    // beforeSend: function (){
    //   $('.bloc__result').block({ 
    //     message: '<i class="fa fa-spinner fa fa-2x fa-spin" style="color:#000;"></i>',
    //     overlayCSS: {
    //         backgroundColor: '#fff',
    //         opacity: 0.8,
    //         cursor: 'wait'
    //     },
    //     css: {
    //       border: 0,
    //       padding: 0,
    //       backgroundColor: 'transparent'
    //     }
    //   });
    // },
    success: function (d) {
      // $('.bloc__result').unblock();
      $('.bloc__result').html(d.result);
      initOwlCarousel() ;
      window.history.pushState( {} , '', d.url );
    }
  });
}

function gotopage()
{
  var page = $(this).data('page'),
  resource_type = $('nav.pagination').attr('data-resource_type') ,
  resource_id = $('nav.pagination').attr('data-resource_id') ;

  var data = {
    "resource_type":resource_type
    ,"resource_id":resource_id
  };

  $.ajax({
    type: "POST",
    url:baseUrl+"/ajax/get/format/html?page="+page,
    data:data,
  	dataType : "json",
    // beforeSend: function (){
    //   $('.bloc__result').block({ 
    //     message: '<i class="fa fa-spinner fa fa-2x fa-spin" style="color:#000;"></i>',
    //     overlayCSS: {
    //         backgroundColor: '#fff',
    //         opacity: 0.8,
    //         cursor: 'wait'
    //     },
    //     css: {
    //         border: 0,
    //         padding: 0,
    //         backgroundColor: 'transparent'
    //     }
    //   });
    // },
    success: function (d) {
      // $('.bloc__result').unblock();
      $('.bloc__result').html(d.result);
      initOwlCarousel() ;
      window.history.pushState( {} , '', d.url );
    }
  });
}

function numberWithCommas(x) {
  return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

/*search*/
$('form#search').submit(function(e){
  e.preventDefault();

  var q = $('input#q').val() ;

  if ( !q.length ) {
    $("input#search").focus();
  }
  else{
    $.ajax({
      type: "POST",
      url:baseUrl+"/ajax/search",
      data: {
        "q":q
      },
      dataType: "json",
      success: function (d) {
        // setTimeout(function(){document.location.href = d},1000);
        setTimeout(window.location.href = d,1000);
      }
    });
  }
});

/*search by filter*/
$('#searchByFilter').submit(function(e){
  e.preventDefault();
  
  var data = $('#searchByFilter').serialize() ;

  $.post(baseUrl+'/index/get', data, function(d){
    setTimeout(window.location.href = d,1000);
  }, 'json');
});

$("a.quick-view").on("click",function(e){
  e.preventDefault() ;

  var id_car = $(this).data("id_car") ;

  $.ajax({
    type: "POST",
    url:baseUrl+"/ajax/quickview",
    data: {
      "id_car" : id_car
    },
    dataType: "json",
    success: function (d) {
      $('#quick-view-content').html(d);
      initOwlCarousel() ;
      $('#quick-view').modal('show');
    }
  });

}) ;

function getAllCountries()
{ 
    var result = new Array ;

    $.ajax({
        url: baseUrl+"/ajax/getallcountries",
        async: false, 
        success:function(data) {
            var d = $.parseJSON(data);
            var res = d.results;

            var tab = new Array ;

            for (var i = 0; i < res.length; i++) {
            var k = [] ;

            k[0] = res[i][0] ;
            k[1] = res[i][1] ;
            k[2] = res[i][2] ;

            tab.push(k);
            };

            result = tab ;
        }
    });

    return result;
}

function getCountryCode(item){
    var country_code = $(item).attr("data-country-code") ;
    $('input[type=hidden]#country_code').val(country_code);
}

$(document).ready(function(){
  autosizeTextarea() ;
}) ;