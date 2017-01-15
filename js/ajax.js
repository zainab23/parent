$(document).ready(function(){



	$(".add_comment").keyup(function(e){
		var _this = $(this);
		var p_id = _this.attr('pid');
		var text = _this.val();
		if (e.keyCode == 13){
			$.ajax({
            url : 'ajax_add_comment.php',
            type : 'POST',
            data : { text : text, p_id : p_id},
            success : function(rt){
            	_this.val('');
                $(_this).parent().before(rt);             
            }
          });
		}
	});



	
	$(".like_btn").click(function(e){
		e.preventDefault();
		var _this = $(this);
		var p_id = _this.attr('pid');
		
			$.ajax({
	            url : 'ajax_like_post.php',
	            type : 'POST',
	            data : {p_id : p_id},
	            success : function(rt){
	            	var json = $.parseJSON(rt);
	            	if (json.result == 'ok'){
	            		var likes = $(_this).parent().find(".first").html();
	            		likes = parseInt(likes) + 1;
	            		$(_this).parent().find(".first").html(likes);
	            	}

	            }                    
			});
	});

	$(".dellete_stuff").click(function(e){
		var u_id = $(this).attr("u_id");
		var id = $(this).attr("id");
		location = "dellete_stuff.php?u_id="+u_id+"&id="+id;
	});



	$(".add").click(function(){
		var _this  = $(this);
		var u_id   = $(this).attr("uid");
		var action = $(this).attr("action");
		if (action == 'add'){
			$.ajax({
	            url : 'ajax_add_friend.php',
	            type : 'POST',
	            data : {u_id : u_id},
	            success : function(rt){
	            	$(_this).attr("action","cencel");
	            	$(_this).html("Cencel");
	            }                    
			});
		}

		if (action == 'cencel'){
			$.ajax({
	            url : 'ajax_cancel_req.php',
	            type : 'POST',
	            data : {u_id : u_id},
	            success : function(rt){
	            	$(_this).attr("action","add");
	            	$(_this).html("Add Friend");
	            }                    
			});
		}

		if (action == 'accept'){
			$.ajax({
	            url : 'ajax_accept_req.php',
	            type : 'POST',
	            data : {u_id : u_id},
	            success : function(rt){
	            	$(_this).attr("action","unfriend");
	            	$(_this).html("Unfriend");
	            }                    
			});
		}

		if (action == 'unfriend'){
			$.ajax({
	            url : 'ajax_unfriend.php',
	            type : 'POST',
	            data : {u_id : u_id},
	            success : function(rt){
	            	$(_this).attr("action","add");
	            	$(_this).html("Add Friend");
	            }                    
			});
		}

	});


	$(".show_post").click(function(){
		location = "show_user_post.php?id="+$(this).attr("uid");
	});

	
	$(".want_this").click(function(){
		var _this  = $(this);
		var u_id   = $(this).attr("uid");
		var id     = $(this).attr("id");
		var action = $(this).attr("action");

		if (action == 'want'){
			$.ajax({
	            url : 'ajax_add_wanted_stuff.php',
	            type : 'POST',
	            data : {u_id : u_id, id : id},
	            success : function(rt){
	            	$(_this).attr("action","unwant");
	            	$(_this).html("I don't want it");
	            }                    
			});
		}

		if (action == 'unwant'){
			$.ajax({
	            url : 'ajax_remove_wanted_stuff.php',
	            type : 'POST',
	            data : {u_id : u_id, id : id},
	            success : function(rt){
	            	$(_this).attr("action","want");
	            	$(_this).html("I want it");
	            }                    
			});
		}


	});
	

	
	$(".remove_notification").click(function(){
		var _this = $(this);
		var s_id = $(this).attr("s_id");

		$.ajax({
	            url : 'ajax_remove_notification.php',
	            type : 'POST',
	            data : {s_id : s_id},
	            success : function(rt){
	            	$(_this).parent().fadeOut('slow');
	            }                    
		});

	});

	$(".look_for").change(function(){
		var value = $(this).val();

		if (value == "1"){
			$(".part").fadeOut("slow");
			$(".user_part").fadeIn("slow");
		}

		if (value == "2"){
			$(".part").fadeOut("slow");
			$(".post_part").fadeIn("slow");
		}

		if (value == "3"){
			$(".part").fadeOut("slow");
			$(".stuff_part").fadeIn("slow");
		}
		
	});



	



});