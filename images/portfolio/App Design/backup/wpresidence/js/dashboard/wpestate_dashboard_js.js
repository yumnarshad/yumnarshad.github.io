jQuery(document).ready(function ($) {
    "use strict";

    jQuery('.per_listing_payment').click(function(event){
      event.preventDefault();
      var post_id=jQuery(this).attr('data-listingid');
      jQuery('#paymodal_'+post_id).show();
    });

    jQuery('.paymentmodal_close').click(function(event){
      jQuery(this).parents('.paymentmodal').hide();
    });




    $('#open_packages').on( 'click', function(event) {
        $('.pack_description_row').slideToggle();
        jQuery(this).toggleClass('open_pack_on');
        $('.pack-listing:first').find('.buypackage').trigger('click');
    });

    $('.buy_package_sh a').on( 'click', function(event) {
        if (parseInt(ajaxcalls_vars.userid, 10) === 0 ) {
            event.preventDefault();
            jQuery('#modal_login_wrapper').show();
            jQuery('#modal_login_wrapper').find('[autofocus]').focus();
            jQuery('#loginpop').val('1');
        }
    });


    $('#invoice_start_date, #invoice_end_date, #invoice_type ,#invoice_status ').on('change', function(){
      wpestate_filter_invoices();
    });

    // print invoice
    wpestate_print_invoice_page();



    // disable listing dashboard
    $('.disable_listing').on( 'click', function(event) {
      event.preventDefault();
      event.stopPropagation();

      var prop_id     =   $(this).attr('data-postid');
      var ajaxurl     =   wpestate_dashboard_js_vars.ajaxurl ;
      var is_disabled =   0;

      $(this).text(wpestate_dashboard_js_vars.processing);

      if ( $(this).hasClass('disabledx') ){
          is_disabled=1;
          $(this).removeClass('disabledx');
      }else{
          $(this).addClass('disabledx');
      }

      var element     = $(this);
      //6
      var container   = $(this).parents().eq(4)
      var is_agent    =   0;




      if(jQuery(this).hasClass('disable_agent')){
          var nonce       = jQuery('#wpestate_agent_actions').val();
          is_agent=1;
      }else{
          var nonce       = jQuery('#wpestate_property_actions').val();
      }

      $.ajax({
          type: 'POST',
          url: ajaxurl,
          data: {
              'action'       :   'wpestate_disable_listing',
              'security'     :   nonce,
              'prop_id'      :   prop_id,
              'is_agent'     :   is_agent

          },
          success: function (data) {
              var label_text='';
              if (is_disabled===1){
                  element.empty().append('<i class="fas fa-play"></i>');
                  container.find('.property_dashboard_status').html(wpestate_dashboard_js_vars.disabled);
                  element.html(wpestate_dashboard_js_vars.disablelisting);

                  if( jQuery('.page-template-user_dashboard_agent_list').length > 0){
                      label_text= wpestate_dashboard_js_vars.enableagent;
                  }else{
                      label_text= wpestate_dashboard_js_vars.enablelisting;
                  }




              }else{
                  if( jQuery('.page-template-user_dashboard_agent_list').length > 0){
                      label_text= wpestate_dashboard_js_vars.disableagent;
                  }else{
                      label_text= wpestate_dashboard_js_vars.disablelisting;
                  }


                  container.find('.property_dashboard_status').empty().html(wpestate_dashboard_js_vars.published);
                //  element.html(wpestate_dashboard_js_vars.enablelisting);
              }
                location.reload();

          },
          error: function (errorThrown) {
          }
      });
    });



  /*
  * Upload image for floor plan - plpuplaoder
  */
  wpestate_dash_set_upload_plans();
  wpestate_dash_add_new_plan();

  /*
  * crm add comment
  */
  wpestate_crm_add_comment_dashboard();

});




function wpestate_process_inaction(label){
    var loading_modal;
    window.scrollTo(0, 0);
    loading_modal='<div class="modal fade" id="loadingmodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-body listing-submit"><span>'+label+'</div></div></div></div></div>';

    jQuery('body').append(loading_modal);
    jQuery('#loadingmodal').modal();
}






/*
* Chart for total listings widget
*/
function wpestate_chart_total_listings_widget(values,labels,detail_label ){

    if(  !document.getElementById('myChart_widget_total') ){
        return;
    }

    var ctx = jQuery("#myChart_widget_total").get(0).getContext("2d");
    var myNewChart  =    new Chart(ctx);

    var traffic_data='  ';


    traffic_data    =  values;

    var data = {
    labels:labels ,
    datasets: [
         {
            label: detail_label,
            fillColor: "rgba(220,220,220,0.5)",
            strokeColor: "rgba(220,220,220,0.8)",
            highlightFill: "rgba(220,220,220,0.75)",
            highlightStroke: "rgba(220,220,220,1)",
            data: traffic_data
        },
    ]
    };






    var options = {
            title:'page views',
           //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
           scaleBeginAtZero : true,

           //Boolean - Whether grid lines are shown across the chart
           scaleShowGridLines : true,

           //String - Colour of the grid lines
           scaleGridLineColor : "rgba(0,0,0,.05)",

           //Number - Width of the grid lines
           scaleGridLineWidth : 1,

           //Boolean - Whether to show horizontal lines (except X axis)
           scaleShowHorizontalLines: true,

           //Boolean - Whether to show vertical lines (except Y axis)
           scaleShowVerticalLines: true,

           //Boolean - If there is a stroke on each bar
           barShowStroke : true,

           //Number - Pixel width of the bar stroke
           barStrokeWidth : 2,

           //Number - Spacing between each of the X value sets
           barValueSpacing : 5,

           //Number - Spacing between data sets within X values
           barDatasetSpacing : 1,

           //String - A legend template
           legendTemplate : "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].fillColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>"

        };

       // var myBarChart = new Chart(ctx).Bar(data, options);
        var myBarChart = new Chart(ctx,{
            type: 'bar',
            data: data,
            options: options
        });

}

function wpestate_chart_total_listings_widget2(values,labels,detail_label ){
    if(  !document.getElementById('myChart_widget_total') ){
        return;
    }

    var ctx =  document.getElementById('myChart_widget_total').get(0).getContext("2d");
    var myNewChart  =   new Chart(ctx);
    var data = {
    labels:labels ,
    datasets: [
         {
            label: detail_label,
            fillColor: "rgba(108, 93, 211, 0.85)",
            strokeColor: "rgba(108, 93, 211, 0.85)",
            highlightFill: "rgba(108, 93, 211, 0.85)",
            highlightStroke: "rgba(220,220,220,1)",
            data: values
        },
    ]
    };

    var options = {
        scaleBeginAtZero : true,
        scaleShowGridLines : true,
        scaleGridLineColor : "rgba(0,0,0,.05)",
        scaleGridLineWidth : 1,
        scaleShowHorizontalLines: true,
        scaleShowVerticalLines: true,
        barShowStroke : true,
        barStrokeWidth : 2,
        barValueSpacing : 5,
        barDatasetSpacing : 1,
        legendTemplate : "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].fillColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>"
    };

   // var myBarChart = new Chart(ctx).Bar(data, options);
    var myBarChart = new Chart(ctx,{
        type: 'bar',
        data: data,
        options: options
    });

}



/*
* Upload new floorplan
*/

function wpestate_dash_set_upload_plans(){

  var plans = jQuery('.aaiu-uploader-floor-plans').each(function(event){
      var upload_button_id = jQuery(this).attr('id');
      wpestate_floorPlanImage(upload_button_id);
  });

  jQuery('.wpestate_dash_delete_plan').click(function(event){
    jQuery(this).parents('.floor_plan_unit_wrapper').remove();
  });
}



/*
* Add new floorplan
*/
function wpestate_dash_add_new_plan(){
  jQuery('#add_new_floor_plan').click(function(event){

    event.preventDefault();
    var no_of_plans= jQuery('.floor_plan_unit_wrapper').length;
    no_of_plans= parseInt(no_of_plans)+1;
    var to_add_form='<div class="floor_plan_unit_wrapper">'+
      '<div id="#aaiu-upload-imagelist-floor-plant"></div>'+
      '<div class="col-md-12">'+
         '<label for="plan_title">'+wpestate_dashboard_js_vars.plan_title+'</label>'+
         '<a class="wpestate_dash_delete_plan" onclick="return confirm('+wpestate_dashboard_js_vars.are_you_sure+');">'+wpestate_dashboard_js_vars.delete_plan+'</a>'+
         '<input id="plan_title" type="text" size="36" name="plan_title[]" value="" >'+
       '</div>'+
       '<div class="col-md-12">'+
         '<label for="plan_description">'+wpestate_dashboard_js_vars.plan_description+'</label>'+
         '<textarea class="plan_description" type="text" size="36" name="plan_description[]" ></textarea>'+
       '</div>'+
       '<div class="col-md-6">'+
         '<label for="plan_size">'+wpestate_dashboard_js_vars.plan_size+'</label>'+
         '<input id="plan_size" type="text" size="36" name="plan_size[]" value="">'+
       '</div>'+
       '<div class="col-md-6">'+
         '<label for="plan_rooms">'+wpestate_dashboard_js_vars.plan_rooms+'</label>'+
         '<input id="plan_rooms" type="text" size="36" name="plan_rooms[]" value="">'+
       '</div>'+
       '<div class="col-md-6">'+
         '<label for="plan_bath">'+wpestate_dashboard_js_vars.plan_bath+'</label>'+
         '<input id="plan_bath" type="text" size="36"name="plan_bath[]" value="">'+
       '</div>'+
       '<div class="col-md-6">'+
         '<label for="plan_price">'+wpestate_dashboard_js_vars.plan_price+'</label>'+
         '<input id="plan_price" type="text" size="36" name="plan_price[]" value="">'+
       '</div>'+
       '<div class="col-md-6">'+
         '<div id="upload-container">'+
           '<div id="aaiu-upload-container">'+
              '<div class="aaiu-upload-imagelist-floor-plan">'+
              '</div>'+
              '<div id="imagelist">'+
                  '<img src="" class="floor_plan_image_thumb">'+
                  '<input class="floor_plan_image" type="hidden" size="36" name="floor_plan_image[]" value="">'+
                  '<input type="hidden" class="plan_image_attach" name="plan_image_attach[]" value="">'+
               '</div>'+
               '<div id="aaiu-uploader-floor-plans-'+no_of_plans+'"  class=" aaiu-uploader-floor-plans wpresidence_button wpresidence_success">'+wpestate_dashboard_js_vars.uploadnew+'</div>'+
             '</div>'+
        '</div>'+
     '</div>'+
 '</div>';


  jQuery('.section_floor_plan_unit_wrapper').append(to_add_form);
  var upload_button_id = 'aaiu-uploader-floor-plans-'+no_of_plans;
  wpestate_floorPlanImage(upload_button_id);

  jQuery('.wpestate_dash_delete_plan').click(function(event){
    jQuery(this).parents('.floor_plan_unit_wrapper').remove();
  });

  });
}


/*
* Upload image for floor plan - plpuplaoder
*/

function wpestate_floorPlanImage(uploadbutton){
  var  parent=jQuery('#'+uploadbutton).parents('.floor_plan_unit_wrapper')


  var floorPlanUploader = new plupload.Uploader({
           runtimes:      "html5,flash,html4",
           browse_button: uploadbutton,
           file_data_name: 'aaiu_upload_file',
           url: wpestate_dashboard_js_vars.ajaxurl + "?action=wpestate_me_upload",
           multi_selection: false,
           filters: {
               mime_types : [
                   { title : wpestate_dashboard_js_vars.allow_file_type,
                     extensions : "jpg,jpeg,gif,pdf,png"
                   }
               ],
             max_file_size: '12000kb',
             prevent_duplicates: true
           }
  });

  floorPlanUploader.init();

  jQuery('#'+uploadbutton).on( 'click', function(e) {
        e.preventDefault();
       floorPlanUploader.splice();
       floorPlanUploader.refresh();
     });


  /*
  *Files added
  */
  floorPlanUploader.bind('FilesAdded', function(up, files) {
      if(up.files.length > 1 ) {
          up.splice(1);
          return;
      }

      plupload.each(files, function(file) {
      });

      jQuery.each(files, function (i, file) {
           parent.find(".aaiu-upload-imagelist-floor-plan").append(
               '<div id="' + file.id + '" class="floorplan_upload_notification">Uploading ' +
               file.name + ' (' + plupload.formatSize(file.size) + ') <b></b>' +
               '</div>');
       });

      up.refresh();
      floorPlanUploader.start();
  });



  /*
  *track upload
  */
   floorPlanUploader.bind('UploadProgress', function (up, file) {
       jQuery('#' + file.id + " b").html(file.percent + "%");
   });


   /*
   *track error
   */
   floorPlanUploader.bind('Error', function( up, err ) {
       jQuery('#aaiu-upload-imagelist-floor-plant').append("<div>Error: " + err.code +
           ", Message: " + err.message +
           (err.file ? ", File: " + err.file.name : "") +
           "</div>"
       );
       up.refresh(); // Reposition Flash/Silverlight
   });


   /*
   * Upload complete
   */

   floorPlanUploader.bind('FileUploaded', function ( up, file, response ) {
        var response = jQuery.parseJSON( response.response );

        if ( response.success ) {
            parent.find(".floor_plan_image").val(response.html);
            parent.find(".floor_plan_image_thumb").attr('src',response.html);
            parent.find(".plan_image_attach").val(response.attach);
            parent.find(".floorplan_upload_notification").remove();
        } else {
            parent.find(".floor_plan_image_thumb").attr('src','');
            parent.find(".plan_image_attach").val('');


        }
    });

}


/*
*  Filter invoices
*/

function wpestate_filter_invoices(){
    "use strict";
    var ajaxurl, start_date, end_date, type, status;
    start_date  = jQuery('#invoice_start_date').val();
    end_date    = jQuery('#invoice_end_date').val();
    type        = jQuery('#invoice_type').val();
    status      = jQuery('#invoice_status').val();
    var nonce = jQuery('#wpestate_invoices_actions').val();
    ajaxurl         =  wpestate_dashboard_js_vars.ajaxurl;
    jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        dataType: 'json',
        data: {
            'action'        :   'wpestate_ajax_filter_invoices',
            'start_date'    :   start_date,
            'end_date'      :   end_date,
            'type'          :   type,
            'status'        :   status,
            'security'      :   nonce
        },
        success: function (data) {

            jQuery('#container-invoices').empty().append(data.results);
            jQuery('#invoice_confirmed').empty().append(data.invoice_confirmed);
            //enable_invoice_actions();

        },

        error: function (errorThrown) {

        }
    });//end ajax
}

/*
*  print invoices
*/
function wpestate_print_invoice_page(){
    ////////////////////////////////////////////////////////////////////////////
    /// print property page
    ////////////////////////////////////////////////////////////////////////////

    jQuery('.print_invoice').on( 'click', function(event) {
        var invoice_id, myWindow, ajaxurl;
        ajaxurl      =   wpestate_dashboard_js_vars.ajaxurl;
        event.preventDefault();

        invoice_id=jQuery(this).attr('data-post-id');

        myWindow=window.open('','Print Invoice','width=700 ,height=842');
        var nonce = jQuery('#wpestate_invoices_actions').val();
        jQuery.ajax({
                type: 'POST',
                url: ajaxurl,
            data: {
                'action'        :   'wpestate_ajax_create_print_invoice',
                'propid'        :   invoice_id,
                'security'      :   nonce
            },
            success:function(data) {
                myWindow.document.write(data);
                myWindow.document.close();
                myWindow.focus();

                setTimeout(function(){
                    myWindow.print();
                }, 3000);



            },
            error: function(errorThrown){
            }

        });//end ajax  var ajaxurl      =   control_vars.admin_url+'admin-ajax.php';
    });

}


/*
* add coment for crm
*/


function wpestate_crm_add_comment_dashboard(){

  jQuery('#crm_insert_comment').on( 'click', function(event) {
      var item_id,ajaxurl;

      item_id     =   jQuery(this).attr('data-postid');
      ajaxurl      =   wpestate_dashboard_js_vars.ajaxurl;
      content     =   jQuery('#crm_new_commnet').val();
      var who     =   jQuery(this).attr('data-who');
      var date    =   jQuery(this).attr('data-date');
      if(content===''){
          return;
      }
      var nonce   =   jQuery('#wpestate_crm_insert_note').val();

      jQuery.ajax({
          type: 'POST',
          url: ajaxurl,
          data: {
              'action'        :   'wpestate_crm_add_comment_dashboard',
              'item_id'       :   item_id,
              'content'       :   content,
              'security'      :   nonce,

      },
      success: function (data) {
        if(data==='ok'){
          var to_insert='<div class="comment_item"><div class="comment_name">'+who+'</div><div class="comment_date">on '+date+'</div><div class="comment_content">'+content+'</div></div>';
        }else{
          var to_insert='<div class="comment_item">'+data+'</div>';
        }
        jQuery('#show_notes_wrapper').prepend(to_insert);
        jQuery('#crm_new_commnet').val('');

      },
      error: function (errorThrown) {

      }
  });//end ajax

  });
}
