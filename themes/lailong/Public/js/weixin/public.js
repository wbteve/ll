//��������
$("#flip").click(function(){	
    /*    $("#panel").slideToggle("slow");
     $(this).toggleClass("icon_nav_close");*/
	var moban=$("#moban").val();
    var divName=$(this).attr("name");
    if(divName==0){
        $(this).find("img").attr("src",moban+"/Public/images/demo/shou.png");
        $("#panel").slideDown("slow");
        $(this).attr("name",1);
    }else{
        $(this).find("img").attr("src",moban+"/Public/images/demo/open.png");
        $("#panel").slideUp("slow");
        $(this).attr("name",0);
    }
});