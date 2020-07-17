<html>
    <head>
	
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="csrf-token" content="{{ csrf_token() }}" />
        <title>GPTS - @yield('title')</title>
		<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
		<link href="{{ asset('/public/css/bootstrap.min.css') }}" rel="stylesheet">
		<link href="{{ asset('/public/css/AdminLTE.min.css') }}" rel="stylesheet">
		<link href="{{ asset('/public/css/_all-skins.min.css') }}" rel="stylesheet">
		<link href="{{ asset('/public/css/custome.css') }}" rel="stylesheet">
        <link href="{{ asset('/public/css/chosen.min.css') }}" rel="stylesheet">
		<link href="{{ asset('/public/css/bootstrap3-wysihtml5.min.css') }}" rel="stylesheet">
        <link href="{{ asset('/public/css/bootstrap-select.css') }}" rel="stylesheet">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.15/css/bootstrap-multiselect.css">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    	<script> var base_url = "{{asset('/')}}"; </script>
    
	</head>
        @yield('content')
		<script src="{{ asset('/public/js/jquery.min.js') }}"></script> 
		<script src="{{ asset('/public/js/bootstrap.min.js') }}"></script>
		
		<script src="{{ asset('/public/js/jquery.slimscroll.min.js') }}"></script>
		<script src="{{ asset('/public/js/fastclick.js') }}"></script>
                <script src="https://cdn.ckeditor.com/4.11.3/standard/ckeditor.js"></script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/4.5.1/tinymce.min.js"></script>
		<script src="{{ asset('/public/js/adminlte.min.js') }}"></script>
		<script src="{{ asset('/public/js/demo.js') }}"></script>
		<script src="{{ asset('/public/js/chosen.jquery.min.js') }}"></script> 
		<script src="{{ asset('/public/js/custom.js') }}"></script> 
        <script src="{{ asset('/public/js/bootstrap-select.js') }}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.15/js/bootstrap-multiselect.js"></script>
     		
		<!--<script src="{{ asset('/public/js/plugin.js') }}"></script>--> 
		<!-- /.content-wrapper -->
<script>    
var objectUrl;    
    

	
    $("#fl").change(function(e){    
        var file = e.currentTarget.files[0];
        objectUrl = URL.createObjectURL(file);
		var fileName, fileExtension;
		fileName = file.name;
		fileExtension = fileName.split('.').pop();

		// Check Video Type
		//if( fileExtension != 'webm' || fileExtension != 'mp4'){
		if( fileExtension != 'mp4'){
			alert("Invalid video type.");
			$("#fl").val('');
			return false;
		}
                console.log(file.size);
		// Check Video Size
		if( parseInt(file.size) > parseInt(353680551)){
			alert("Video's size can't be greater than 350 MB.");
			$("#fl").val('');
			return false;
		}

    });

	$(".imagefl").change(function(e){ 

        var file = e.currentTarget.files[0];
        objectUrl = URL.createObjectURL(file);
		var fileName, fileExtension;
		fileName = file.name;
		fileExtension = fileName.split('.').pop();

		// Check Image Type
		if( fileExtension != 'png' && fileExtension != 'jpg'){
			alert("Invalid image type.");
			$(this).val('');
			return false;
		}
//                if( parseInt(file.size) > parseInt(50368055)){
//			alert("Image size can't be greater than 50kb.");
//			$(this).val('');
//			return false;
//		}

    });
    $(".doctype").change(function(e){ 
console.log('dsd');
        var file = e.currentTarget.files[0];
        objectUrl = URL.createObjectURL(file);
		var fileName, fileExtension;
		fileName = file.name;
		fileExtension = fileName.split('.').pop();

		// Check Image Type
		if( fileExtension != 'pdf' && fileExtension != 'doc' && fileExtension != 'docx'){
			alert("Invalid document type.");
			$(this).val('');
			return false;
		}
//                if( parseInt(file.size) > parseInt(50368055)){
//			alert("Image size can't be greater than 50kb.");
//			$(this).val('');
//			return false;
//		}

    });



$(document).ready(function() {
	var showChar = 200;
	var ellipsestext = "...";
	var moretext = "more";
	var lesstext = "less";
	$('.more').each(function() {
		var content = $(this).html();

		if(content.length > showChar) {

			var c = content.substr(0, showChar);
			var h = content.substr(showChar-1, content.length - showChar);

			///alert(c);

			var html = c + '<span class="moreellipses">' + ellipsestext+ '&nbsp;</span><span class="morecontent"><span>' + h + '</span>&nbsp;&nbsp;<a href="" class="morelink">' + moretext + '</a></span>';

			$(this).html(html);
		}

	});

	$(".morelink").click(function(){
		if($(this).hasClass("less")) {
			$(this).removeClass("less");
			$(this).html(moretext);
		} else {
			$(this).addClass("less");
			$(this).html(lesstext);
		}
		$(this).parent().prev().toggle();
		$(this).prev().toggle();
		return false;
	});
      getbtncolor(); 

   

});

function changeVideoPriority(val){
   	
   	$.ajax({
	    url: base_url + "admin/changeVideoPriority/"+val,
	    method: "get",
	    data: {
	        
	    },
	    headers: {
	        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	    },
	    success: function (result) {
	        alert('Priority has been changed!');
	    }
	});
 
 }
 function changeEdieoVideoPriority(val){
   	
   	$.ajax({
	    url: base_url + "admin/change-video-priority/"+val,
	    method: "get",
	    data: {
	        
	    },
	    headers: {
	        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	    },
	    success: function (result) {
	        alert('Priority has been changed!');
	    }
	});
 
 }
function getbtncolor(){
    $.ajax({
    url: base_url + "admin/getbtncolor",
    method: "get",
    data: {
        
    },
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    success: function (result) {
        $(".btn-warning").css({"background-color": result.btncolor, "border-color": result.btncolor});
        
    }
});
}
</script>
</body>
</html>