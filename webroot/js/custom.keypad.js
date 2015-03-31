/** NUMBER PAD SETTINGS START **/
function number_write(x)
{
  var text_box = document.getElementsByClassName("numpad_text")[0];
  if(x>=0 && x<=9)
  {
	if(isNaN(text_box.value))
		text_box.value = 0;
	
	if(x>0 && x<=9 && text_box.value == '0'){
	
		text_box.value = "";
		text_box.value += x;
		
	}else if(x==0 && text_box.value == '0'){
		text_box.value = "0";
	}else if(x == '00' && text_box.value == '0'){
		x = "";
		text_box.value = "0";
	}else{
		text_box.value += x;
	}
  }
  if(x=='.')
  {
  	if(text_box.value.indexOf(".") >= 0){
  	} else {
	  	text_box.value += '.';
	}
  }
}
function number_clear()
{
  document.getElementsByClassName("numpad_text")[0].value = '';
}
function number_c()
{
  var text_box = document.getElementsByClassName("numpad_text")[0];
  var num = text_box.value;
  var num1 = num%10;
  num -= num1;
  num /= 10;
  text_box.value = num;
}
function number_negative()
{
  var text_box = document.getElementsByClassName("numpad_text")[0];
  var num = text_box.value;
  text_box.value = -num;
}
/** NUMBER PAD SETTINGS END **/

$("#show_numpad").click(function(){
	$("#numpad").toggle();
	$(".price_block").toggleClass('numpad_active');
	$(".price_block").position({
		my: "left+60 bottom+90",
		using: function( position ) {
	        $( this ).animate( position );
	    }
	});
	return false;
});

$(document).on("click","#set-discount",function(){
	$(".numpad_text").val("");
	$(".numpad_text").attr({'id':'item-discount'});
	$(".numpad_text").attr({'placeholder':'E.g. 20% or 20'});
	$("#percentage-symbol").show();
});

$(document).on("click","#set-unit-price",function(){
	$(".numpad_text").val("");
	$(".numpad_text").attr({'id':'item-unit-price'});
	$(".numpad_text").attr({'placeholder':'E.g. 2.50'});
	$("#percentage-symbol").hide();
});
$(document).on("click",".price-control",function(event){
	$(".price-form").attr({"data-id":$(this).attr("data-id")});
	if(($(this).position().top - 13) == $(".price_block").position().top){
		$(".price_block").hide();
		$(".price_block").removeClass("price_block_active");
	} else {
		$(".price_block").show();
		$(".numpad_text").focus();
		$(".price_block").addClass("price_block_active");
		if($(".price_block").hasClass("numpad_active")){
			$(".price_block").position({
				my: "left+70 bottom+29",
				of: $(this),
				using: function( position ) {
			        $( this ).animate( position );
			    }
			});
		} else {
			$(".price_block").position({
				my: "left+70 bottom+77",
				of: $(this),
				using: function( position ) {
			        $( this ).animate( position );
			    }
			});
		}
	}
});
$(".price-form").submit(function(){
	
	$("input[data-id="+$(this).attr("data-id")+"]").val($(".numpad_text").val());
	
	return false;
});




$(document).on("click",".qty-control",function(event){
	console.log("OK");
	$(".qty-form").attr({"data-id":$(this).attr("data-id")});
	if(($(this).position().top - 13) == $(".qty_block").position().top){
		$(".qty_block").hide();
		$(".qty_block").removeClass("qty_block_active");
	} else {
		$(".qty_block").show();
		$(".numpad_text").focus();
		$(".qty_block").addClass("qty_block_active");
		if($(".qty_block").hasClass("numpad_active")){
			$(".qty_block").position({
				my: "left+70 bottom+29",
				of: $(this),
				using: function( position ) {
			        $( this ).animate( position );
			    }
			});
		} else {
			$(".qty_block").position({
				my: "left+70 bottom+77",
				of: $(this),
				using: function( position ) {
			        $( this ).animate( position );
			    }
			});
		}
	}
});
$(".qty-form").submit(function(){
	
	$("input[data-id="+$(this).attr("data-id")+"]").val($(".numpad_text").val());
	
	return false;
});