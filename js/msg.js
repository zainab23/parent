$(document).ready(function(){


	$(".contact").click(function(){
		var _this = $(this);
		$(this).css('background','#fff');
		var id = $(this).attr("u_id");

		$.ajax({
            url : 'ajax_get_msgs.php',
            type : 'GET',
            data : { id : id},
            success : function(rt){
            	$(".chat_box").html(rt);
            }
          });

	});



	$(".search_chat_list").keyup(function(){
		var text = $(this).val();

		
			$.ajax({
	            url : 'ajax_search_chat_list.php',
	            type : 'POST',
	            data : { text : text},
	            success : function(rt){
	            	$(".chat_list").html(rt);
	            }
        	});
		
		
	});
	
	
	
	
	
	
	





});