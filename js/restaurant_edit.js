/**
 * @author FunEat
 */


$(function() {
	
	//var uuid = $("#restaurant_uuid").val();
	
	//alert(uuid);
	
	$(".addNewPeriodBtn").click(function() {
		
		//priodBoo = !priodBoo;
		
		var objBoo = $(this).parents(".resPriodItem").find(".boo");
		var priodBoo = $(objBoo).val();
		
		if(priodBoo == 1) {
			$(this).css({
				'background-color' : '#5a9ee9',
				'color' : '#fff'
			})
			
			$(this).parents(".resPriodItem").find(".proidTagItem").each(function() {
			
				var _cb = $(this).find("input[type=checkbox]");		
				
				//alert($(_cb).is(":checked"))	;
				//alert($(this).find("input[type=hidden]").val() + " " + $(_cb).is(":checked"));
				
				var _o = $(this).parents(".dateTime").find(".daliyItem").find(".daliyValue[value=" + $(this).find("input[type=hidden]").val() + "]");
				
				
				var _oDaliyItem = $(_o).parent(".daliyItem");
				
				//alert($(_oDaliyItem).find("input[type=hidden][value=" + $(this).find("input[type=hidden]").val() + "]").val());
				
				refresh($(_cb).is(":checked"), _oDaliyItem);
				
				//alert($(_o).val());
				
			})
			
			$(objBoo).val(0);
		}
		else {
			$(this).css({
				'background-color' : '#fff',
				'color' : '#666'
			})
			$(this).parents(".resPriodItem").find(".daliyItem").hide();
			
			$(objBoo).val(1);
		}
		
	})
	
	$(".proidCheckBox").change(function() {
		
		
		
		var _o = $(this).parents(".dateTime").find(".daliyItem").find("input[type=hidden][value=" + $(this).prevAll("input[type=hidden]").val() + "]");
		
		//alert($(_o).val());
		
		var _oDaiyItem = $(_o).parent(".daliyItem");
		
		//alert($(_o).attr("class"));
		
		var objBoo = $(this).parents(".resPriodItem").find(".boo");
		var priodBoo = $(objBoo).val();
		
		if(priodBoo == 0)
		{
			refresh(this.checked, _oDaiyItem);
		}
		
	})
	
	//$(".start")
	
	
})

function refresh(boo, obj) {
	if(boo)
	{
		$(obj).show();
		//alert("123");
	}
	else
	{
		$(obj).hide();
	}
}

