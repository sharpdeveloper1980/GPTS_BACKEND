$(document).ready(function () {
    /* Rich text editor on all textarea. */
    if ($('#editor1').length) {
        CKEDITOR.replace('editor1', {
            //filebrowserBrowseUrl : '/browser/browse/type/all',
            filebrowserUploadUrl: '/media/upload/type/all',
            //filebrowserImageBrowseUrl : '/public/media',
            filebrowserImageUploadUrl: '/admin/media/upload',
            filebrowserWindowWidth: 800,
            filebrowserWindowHeight: 500
        });
    }
    /* Auto populate slug On Page Title change */
    $("#pagetitle").on("change", function () {
        var pageTtl = $(this).val();
        pageTtl = pageTtl.replace(" & ", "-");
        $("#slug").val(pageTtl.replace(/ /g, "-").toLowerCase());
    });

    /* On Status change */
    $(".status").on("change", function () {
        var status = ($(this).filter(':checked').val() == 1) ? 1 : 0;
        var id = $(this).attr("data-id");
        var type = $(this).attr("data-type");
        if (id) {
            $.ajax({
                url: base_url + "admin/change" + type + "Status",
                method: "post",
                data: {
                    'id': id,
                    'status': status
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (result) {}
            });
        }
    });

    /* Other language selector */
    $("#language-other").focus(function () {
        $("#language-2").prop('checked', true);
    });


    /* $(".list").click(function(){
     var id = $(this).attr("data-id");
     var urlbrow = $(this).attr("data-url");
     var image_url = base_url+'uploadcause/';
     $.ajax({
     url : urlbrow,
     type: "POST",
     data: "id=" + id,
     headers: {
     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
     },
     success : function(result){
     var object = JSON.parse(result);
     var htmlval = '<table>';
     for(var i=0; i<object.length; i++){
     var checked = (object[i].active_on_page == true)?'checked':'';
     htmlval +='<tr id="row'+object[i].id+'"><td><input type="checkbox" onclick="checkVal(this.value)" '+checked+' class="showImage" value="'+object[i].id+'"/></td><td><img src="'+image_url+object[i].image_url+'" width="200" height="200"/></td><td><a href="#" onclick="deletePic('+object[i].id+')"><i class="fa fa-remove" style="color:#dd4b39;"></i></a></td></tr>';
     }
     htmlval +='</table>';
     $("#myModal").modal();
     $("#causePhoto").html(htmlval);
     }
     });
     }); */
});

function checkVal(val) {
    var con = confirm("Are you sure want to update visibility?");
    if (con) {
        $.ajax({
            url: base_url + 'visibility',
            type: "POST",
            data: "id=" + val,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (result) {
                alert("Change visibility successfully");
            }
        })
    }
}

function deletePic(val) {
    var con = confirm("Are you sure want to delete?");
    if (con) {
        $.ajax({
            url: base_url + 'deletepic',
            type: "POST",
            data: "id=" + val,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (result) {
                alert("Delete successfully");
                $("#row" + val).hide();
            }
        })
    }
}

function changeStatus(url, id) {
    var status = $('#status').val();
    if (confirm('Are you sure, want to update selected item status?')) {
        $.ajax({
            url: url + "/changeStatus",
            method: "post",
            data: {
                'id': id,
                'status': status
            },
            success: function (result) {
                alert(result);
            }
        });
    }
}

$(document).on('click', '.add-more', function (e) {

    e.preventDefault();
    //var closestEle = $(this).closest('.add-one-more');
    var closestEle = $(".promotion-product").find(".add-one-more").clone();
    alert(closestEle);
    console.log(closestEle);
    // var clonedEle = $(closestEle).clone();
    //$(".add-more").hide();
    //$(clonedEle).appendTo('.promotion-product');
});

$(document).on('click', '.delete-one', function (e) {
    e.preventDefault();
    if ($(".delete-one").length > 1) {
        $(this).parent().hide();
        alert($(".add-more").length);
        if ($(".add-more").length <= 0) {
            $(".add-more").show();
        }
    } else {
        alert("selecte atleast one row");
    }

});


$("#statelist").on('change', function () {

    var State_id = $("#statelist").val();

    $.ajax({
        type: "POST",
        url: base_url + 'admin/getcity',
        data: "state=" + State_id,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (result) {
            var obj = JSON.parse(result);

            if (obj.succ == true) {
                $('#citylist').html('');
                $('#citylist').append('<option value="0">Select City</option>');
                $.each(obj.data, function (key, value) {

                    $('#citylist').append('<option value="' + value.id + '">' + value.cityname + '</option>');
                });
            }
        }
    });

});


$('.title').on('blur', function () {

    var str = $(".title").val();
  str = str.replace(/[`~!@#$%^&*()_\-+=\[\]{};:'"\\|\/,.<>?\s]/g, ' ').toLowerCase();

    // trim spaces at start and end of string
    str = str.replace(/^\s+|\s+$/gm, '');

    // replace space with dash/hyphen
    str = str.replace(/\s+/g, '-');
    document.getElementById("slug").value = str;



});

function convertToSlug(str) {

    //replace all special characters | symbols with a space
    str = str.replace(/[`~!@#$%^&*()_\-+=\[\]{};:'"\\|\/,.<>?\s]/g, ' ').toLowerCase();

    // trim spaces at start and end of string
    str = str.replace(/^\s+|\s+$/gm, '');

    // replace space with dash/hyphen
    str = str.replace(/\s+/g, '-');
    document.getElementById("slug-text").value = str;
    //return str;
}

$("#userdata").on('blur', function () {
    var name = $("#userdata").val();

    $.ajax({
        type: "POST",
        url: base_url + 'admin/getuser',
        data: "name=" + name,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (result) {
            var obj = JSON.parse(result);
            if (obj.succ == true) {

                $.each(obj.data, function (key, value) {
                    $('#userdata').append('<option value="' + value.id + '">' + value.fullname + '</option>');

                });
                $("#userdata").trigger("chosen:updated");


            }
        }
    });

});

$(".chosenselect").chosen({
    no_results_text: "Oops, nothing found!"
});

$(document).ready(function () {
    $('#chosenselect').multiselect({
        includeSelectAllOption: false,
        maxHeight: 400,
        buttonWidth: 300,
        dropUp: false,
    });

    $('#category-multiple').multiselect({
        includeSelectAllOption: true,
        maxHeight: 400,
        buttonWidth: 300,
        dropUp: false,
        onChange: function (element, checked) {
            getSubCat();
        },
        onSelectAll: function (element, checked) {
            getSubCat();
        }
    });

    $('#subcat-multiple').multiselect({
        includeSelectAllOption: true,
        maxHeight: 400,
        buttonWidth: 300,
        dropUp: false
    });

    $('#product-multiple').multiselect({
        includeSelectAllOption: true,
        maxHeight: 400,
        buttonWidth: 300,
        dropUp: false
    });



});
function getsubcategory(that) {

    var cat_id = $(that).val();

    $.ajax({
        type: "POST",
        url: base_url + 'admin/getsubcat',
        data: "cat_id=" + cat_id,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (result) {
            var obj = JSON.parse(result);
            $(that).closest('.add-one-more').find('.subcategory').html('');
            $(that).closest('.add-one-more').find('.product').html('');
            if (obj.succ == true) {

                $(that).closest('.add-one-more').find('.chosen-results').html('');
                $(that).closest('.add-one-more').find('.subcategory').append('<option value="0">Select Sub category</option>');
                $.each(obj.data, function (key, value) {

                    $(that).closest('.add-one-more').find('.subcategory').append('<option value="' + value.id + '">' + value.name + '</option>');
                });


                // $(that).closest('.add-one-more').find('.product').trigger("chosen:updated");				
            }
        }
    });

}

function getProduct() {
    $("#product-multiple").html("");
    var cat_id = $("#category-multiple").val();
    var sub_cat_id = $("#subcat-multiple").val();
    $.ajax({
        type: "POST",
        url: base_url + 'admin/getproductlist',
        data: "cat_id=" + cat_id + "&sub_cat_id=" + sub_cat_id,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (result) {
            var obj = JSON.parse(result);
            if (obj.succ == true) {

                $.each(obj.data, function (key, value) {

                    $("#product-multiple").append('<option value="' + value.product_id + '">' + value.product_name + '</option>');
                });

            }
            $('#product-multiple').multiselect('destroy');
            // alert(type);
            // if(type =='all'){
            // $('#product-multiple').multiselect({
            // includeSelectAllOption: true,
            // allSelectedText: 'All selected',
            // maxHeight: 400,
            // buttonWidth: 300,
            // dropUp: false
            // });
            // $("#product-multiple").multiselect('selectAll', false);
            // $("#product-multiple").multiselect('updateButtonText');

            // }else{
            $('#product-multiple').multiselect({
                includeSelectAllOption: true,
                maxHeight: 400,
                buttonWidth: 300,
                dropUp: false
            });
            //$("#product-multiple").multiselect("clearSelection", false);;
            //}

        }
    });

}

function getSubCat() {

    $("#subcat-multiple").html('');
    var cat_id = $("#category-multiple").val();
    $.ajax({
        type: "POST",
        url: base_url + 'admin/getsubcat',
        data: "cat_id=" + cat_id,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (result) {
            var obj = JSON.parse(result);
            if (obj.succ == true) {

                $.each(obj.data, function (key, value) {

                    $("#subcat-multiple").append('<option value="' + value.id + '">' + value.name + '</option>');
                });

            }
            $('#subcat-multiple').multiselect('destroy');
            $('#subcat-multiple').multiselect({
                includeSelectAllOption: true,
                maxHeight: 400,
                buttonWidth: 300,
                dropUp: false,
                onChange: function () {
                    getProduct();
                },
                onSelectAll: function () {
                    getProduct();
                },
                // onDeselectAll:function(){
                // getProduct('not all');
                // }

            });
        }
    });
}

function addmore() {
    var page = $(".page").val();
    var count = parseInt(page) + 1;
    $(".gallery_img").find(".gall").addClass("gall_" + count);
     $(".gallery_img").find(".ck").attr("id","editor_" + count);
    $(".page").val(count);
//    CKEDITOR.replace( 'editor_'+count);
    $("#gallery").append($(".gallery_img").html());
    $(".gallery_img").find(".gall").removeClass("gall_" + count);
//    $(".gallery_img").find(".ck").removeClass("editor_" + count);
}
function remove() {
    var page = $(".page").val();
    if (page > 1) {
        var count = parseInt(page) - 1;
        $(".page").val(count);
        $("#gallery").find('.gall_' + page).html('');
        $('.gall_' + page).css('display', 'none');
    } else {
        alert('Atleast one field required');
    }
}
function getCourseName() {
    var page = $(".page").val();
    var college_id = $("#college_id").val();
    var coursename = $(".gall_" + page).val();
    console.log($(".gall_" + page).val());
    $.ajax({
        type: "POST",
        url: base_url + 'admin/getCourseName',
        data: "college_id=" + college_id + "&coursename=" + coursename,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (result) {
//                $('#container').html(data);
            if (result.code == '200') {
                alert(result.msg);
                $(".gall_" + page).val('');
            }
        }
    });
}
$(".chosen-select").chosen({no_results_text: "Oops, nothing found!"});
$(document).ready(function () {
//  CKEDITOR.replace( 'editor_1');
});
$(".title").keyup(function(){
        var Text = $(this).val();
        Text = Text.toLowerCase();
        Text = Text.replace(/[^a-zA-Z0-9]+/g,'-');
        $(".slug").val(Text);        
})


var ids = new Array();
function add_element(arr, el) {
// console.log("add eleelemt called");
arr.push(el);
}
function init_ck(id) {

CKEDITOR.replace(id);
}
// Replace the <textarea id="editor1"> with a CKEditor
// instance, using default configuration.

$(".ck_editor").each(function () {
add_element(ids, $(this).attr("id"));
init_ck($(this).attr("id"));
});

function activeCkeditor(that){
    add_element(ids, $(that).attr("id"));
    init_ck($(that).attr("id"));
}
 CKEDITOR.replaceClass = 'ckeditor';


  $( document ).ready(function() {
    getform()
});
function getform(){
    var cartype = $("#cartype").val();
   
    if(cartype==1){
        $(".sub_cat").addClass('hidden');
        $('.cat').removeClass('hidden');
         $('.text_Career').text('Career');
    }else if(cartype==''){
         $(".sub_cat").addClass('hidden');
         $('.cat').addClass('hidden');
         $('.text_Career').text('Career');
    }
    else{
      $(".sub_cat").removeClass('hidden'); 
      $('.cat').addClass('hidden');
       $('.text_Career').text('Sub Career');
    }
}
function changepoststatus(post_id,that){
	var status_id = $(that).val();
	 $.ajax({
            type: "GET",
            url: base_url+'admin/changesposttatus/'+post_id+'/'+status_id,
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
            dataType: 'JSON',
            
            success: function( data ) {
               // $("#ajaxResponse").append(data.msg);
               alert(data.succ);
                location.reload();
            }
        });
}
function changeVideoStatus(post_id,that){
	var status_id = $(that).val();
	 $.ajax({
            type: "GET",
            url: base_url+'admin/changesvideostatus/'+post_id+'/'+status_id,
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
            dataType: 'JSON',
            
            success: function( data ) {
               // $("#ajaxResponse").append(data.msg);
               alert(data.succ);
                location.reload();
            }
        });
}
 function preloader_on()
{
   $("body").prepend('<div id="preloader"><img src="../public/image/preloadernew.gif" alt=""/>  </div>');
}
function preloader_off()
{
 $("#preloader").remove();
}
// preloader_on();
  $( document ).ready(function() {
setTimeout(function(){
//    preloader_off();
}, 1000);
  });