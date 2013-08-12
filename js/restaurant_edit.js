/**
 * @author FunEat
 */


$(function() {
	
	//var uuid = $("#restaurant_uuid").val();
	
	//alert(uuid);
	
	$(".detailSetWeekBtn").click(function() {
		var boo = $(this).find("input[type=hidden]").val();
		var one = $(".dateTitle").get(0);
		if(boo == 0)
		{
			
			$(".allOrMulti").val(1);
			$(this).find("span").text("取消設定日期");
			$(one).text("星期一");
			$(this).find("input[type=hidden]").val(1);
			$(this).css({
				'background-color' : '#688f16',
				'color' : '#fff'
			})
			
			$(".resPriodItem").show();
			
			//還原公休按鈕
			$(".vacationChecItem").show();
			$(".vacationCheckBox").each(function() {
				this.checked = false;
			})
			
		}
		else {
			$(".allOrMulti").val(0);
			$(this).find("span").text("詳細設定日期");
			$(one).text("全天");
			$(this).find("input[type=hidden]").val(0);
			$(this).css({
				'background-color' : '#fff',
				'color' : '#666'
			})
			
			$(".resPriodItem").hide();
			$(".resPriodItem:eq(0)").show();
			
			setAll($(".dateSetAllBtn").get(0));
			
			$(".vacationChecItem").hide();
			$(".vacationCheckBox").each(function() {
				this.checked = false;
			})
		}
		
	})
	
	$(".addNewPeriodBtn").click(function() {
		priodSet(this);		
		
		var boo = $(".allOrMulti").val();
		if(boo == 0)
		{
			setAll($(".dateSetAllBtn").get(0));
		}
	})
	
	$(".proidCheckBox").change(function() {
		priodCheck(this);
		
		var boo = $(".allOrMulti").val();
		if(boo == 0)
		{
			setAll($(".dateSetAllBtn").get(0));
		}
	})
	
	
	//start_select
	$(".start_select").change(function() {
		var boo = $(".allOrMulti").val();
		if(boo == 0)
		{
			setAll($(".dateSetAllBtn").get(0));
		}
	})
	
	//end_select
	$(".end_select").change(function() {
		var boo = $(".allOrMulti").val();
		if(boo == 0)
		{
			setAll($(".dateSetAllBtn").get(0));
		}
	})
	
	//set all option
	$(".dateSetAllBtn").click(function() {
		setAll(this);
	})
	
	
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

function priodCheck(dom) {
	var _o = $(dom).parents(".dateTime").find(".daliyItem").find("input[type=hidden][value=" + $(dom).prevAll("input[type=hidden]").val() + "]");
		
	var _oDaiyItem = $(_o).parent(".daliyItem");
	
	var objBoo = $(dom).parents(".resPriodItem").find(".boo");
	var priodBoo = $(objBoo).val();
	
	if(priodBoo == 0)
	{
		refresh(dom.checked, _oDaiyItem);
	}
}


/**
 * 展開時段
 *  
 * @param {Object} dom
 */
function priodSet(dom) {
	var objBoo = $(dom).parents(".resPriodItem").find(".boo");
	var priodBoo = $(objBoo).val();
	
	if(priodBoo == 1) {
		$(dom).css({
			'background-color' : '#5a9ee9',
			'color' : '#fff'
		})
		
		$(dom).parents(".resPriodItem").find(".proidTagItem").each(function() {
		
			var _cb = $(this).find("input[type=checkbox]");
			
			var _o = $(this).parents(".dateTime").find(".daliyItem").find(".daliyValue[value=" + $(this).find("input[type=hidden]").val() + "]");
			
			var _oDaliyItem = $(_o).parent(".daliyItem");
			
			//alert($(_cb).is(":checked"));
			
			refresh($(_cb).is(":checked"), _oDaliyItem);
		})
		
		$(objBoo).val(0);
	}
	else {
		$(dom).css({
			'background-color' : '#fff',
			'color' : '#666'
		})
		$(dom).parents(".resPriodItem").find(".daliyItem").hide();
		
		$(objBoo).val(1);
	}
}

/**
 * 套用全部設定 
 */
function setAll(dom) {
	var parent = $(dom).parents(".resPriodItem");
	var priodTagParent = $(parent).find(".proidTagItem");
	var dateTimeParent = $(parent).find(".dateTime");
	
	
	//取得TAG的BOOLEAN
	$(priodTagParent).each(function() {
		
		
		//取得目前為哪個checkbox
		var thisVal = $(this).find("input[type=hidden]").val();
		
		//alert(thisVal);
		
		//先取得目前CHECKBOX的狀態
		var thisBoo = $(this).find(".proidCheckBox").is(":checked");
		
		//alert(thisBoo);
		
		//並且跟著設定所有CHECKBOX的狀態
		$(".proidTagItem").find("input[type=hidden][value=" + thisVal + "]").nextAll(".proidCheckBox").each(function() {
			this.checked = thisBoo;
		}) 
		
		
	});
	
	//接著取得是否有套用個別設定
	var expBoo = $(parent).find(".boo").val();
			
	//alert(expBoo);
	
	
	if(expBoo == 1)
	{
		expBoo = 0;
	}
	else
	{
		expBoo = 1
	}
	
	//將所有個別設定套用
	$(".resPriodItem").find(".boo").val(expBoo);
	
	//先遍歷所有的resPriodItem
	$(".resPriodItem").each(function() {
		
		//尋找裡面的 addNewPeriodBtn
		var anpObj = $(this).find(".addNewPeriodBtn");
		
		//設定底下時段的展開與否
		priodSet(anpObj);
		
	})
	
	//再來設定所有的select
	$(dateTimeParent).find(".daliyItem").each(function() {
		//先取得目前的select
		var start_val = $(this).find(".start_select").val();
		var end_val = $(this).find(".end_select").val();
		
		//取得目前索引
		var index = $(this).find(".daliyValue").val();
					
		//設定select
		var target = $(".daliyItem").find(".daliyValue[value=" + index + "]");			
		$(target).parents(".daliyItem").find(".start_select").val(start_val);
		$(target).parents(".daliyItem").find(".end_select").val(end_val);
		
		//先取得禮拜幾			
		//設定hidden name
		/*
		$(".resPriodItem").each(function() {
			var week = $(this).find(".daliyItem").find(".week").val();
			
			$(this).find(".daliyItem").find(".priodStartTime").attr("name", "hours[" + week + "][" + start_val + "][0]");
			$(this).find(".daliyItem").find(".priodEndtTime").attr("name", "hours[" + week + "][" + end_val + "][1]");
		})
		*/
	})
	
	setPriodTime(dateTimeParent);
}


/**
 * 針對營業時間做變更 
 * 
 * @param {object} => dateTimeParent => $(".dateTime")
 */
function setPriodTime(dom) {
	var startTime = $(dom).find(".priodTimeItem").find(".start_select").val();
	var endTime = $(dom).find(".priodTimeItem").find(".end_select").val();
	
	$(".priodTimeItem").find(".start_select").val(startTime);
	$(".priodTimeItem").find(".end_select").val(endTime);
}

