/**
 * @author FunEat
 */

var itemWidth = 850;
var index = 0;
var count = 0;

var preItemWidth = 665;
var preMenuSize = 7;
var preIndex = 0;
var preCount = 0;

$(function() {
	
	init();
	
	$(".galleryLeftBtn").click(function() {
		
		if(index >= count - 1)
		{
			index = 0;
		}
		else
		{
			index++;
		}
		
		galleryAnimate();
		preview();
	});
	
	$(".galleryRightBtn").click(function() {
		
		if(index == 0)
		{
			index = count - 1;
		}
		else
		{
			index--;
		}
		
		
		galleryAnimate();
		preview();
		
	});
	
	/**
	 * preview 
	 */
	
	$(".galleryPreviewLeftBtn").click(function() {
		if(preIndex >= preCount)
		{
			preIndex = 0;
		}
		else
		{
			preIndex++;
		}
		
		previewAnimate();
	});
	
	$(".galleryPreviewRightBtn").click(function() {
		//alert(preIndex + " " + preCount);
		
		if(preIndex == 0)
		{
			preIndex = preCount;
		}
		else
		{
			preIndex--;
		}
		
		previewAnimate();
	})
	
	$(".galleryPreviewItem").click(function() {
		index = $(this).index();
		//preIndex = Math.floor(index / preMenuSize);
		
		galleryAnimate();
		preview();
	})
	
})

function init() {
	//count
	count = $(".galleryItem").size();
	preCount = Math.floor(count / preMenuSize);
	
	//調整寬度
	$(".gallery").width($(".galleryItem").size() * itemWidth);
	$(".galleryPreviewMenu").width($(".galleryPreviewItem").size() * preItemWidth);
	
	$(".galleryPreviewBox").css({
		'left' : (parseInt($(".resGalleryBox").width()) * 0.5) - (parseInt($(".galleryPreviewBox").width()) * 0.5)
	});
}

function galleryAnimate() {
	$(".gallery").animate({
			'left' : -(index * itemWidth)
		});
}

function preview() {
	$(".galleryPreviewItem").removeClass("thisPreview");
	
	var obj = $(".galleryPreviewItem").get(index);
	$(obj).addClass("thisPreview");
	
	previewMove();
}

function previewMove() {
	preIndex = Math.floor(index / preMenuSize);
	
	previewAnimate();
}

function previewAnimate() {
	$(".galleryPreviewMenu").animate({
		'left' : -(preIndex * preItemWidth)
	});
}
