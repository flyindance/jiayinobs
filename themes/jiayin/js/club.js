$(document).ready(function(){
		
			$(".add").click(function(){
			var n=$(this).prev().val();
			var num=parseInt(n)+1;
			if(num==0){ return;}
			$(this).prev().val(num);
			});
			
			$(".jian").click(function(){
			var n=$(this).next().val();
			var num=parseInt(n)-1;
			if(num==0){ return}
			$(this).next().val(num);
			});
			  
		$(".tnt ul li").click(function(){
			$(this).addClass("aabg").siblings().removeClass("aabg")
		   var _idne=$(this).index();
			$(".te .tttochan")   	
					.eq(_idne).show()   
					.siblings().hide();
		});
		
		 $(".tengul ul li").click(function(){
		    var tengd=$(this).index();
			var sem=$(this).find("img").attr("src");
			 $(".toppro").find("img").attr("src",sem)
		  });
		  
		$(".entdint").hover(function(){
			  $(".botne").show()
		},function(){
			 $(".botne").hide()
			});
			 
			 
})


 $(function(){
	 var _index=0;
	 var timers=null;
	 var _lents=$(".baenr-dingw a").length-1;
	 $(".baner-nav ul li").click(function(){
	    $(this).addClass("acitives").siblings().removeClass("acitives")	
		_index=$(this).index();
		 $(".baenr-dingw a").eq(_index).fadeIn().siblings().fadeOut()
	 }); 
	 function autos(){
		 timers=setInterval(function(){
			 _index++;
			 if(_index>_lents){_index=0}
			 $(".baner-nav ul li").eq(_index).addClass("acitives").siblings().removeClass("acitives")
			 $(".baenr-dingw a").eq(_index).fadeIn().siblings().fadeOut()
			 },3000);
		 }
		 autos()
		 $(".baner-nav ul li").mouseover(function(){
			 clearInterval(timers)
		 });
		  $(".baner-nav ul li").mouseout(function(){
			  autos()
		 });
		 
 $(".vbo-yuandian ul li").click(function(){
	$(this).addClass("act").siblings().removeClass("act")
	var _indext=$(this).index();
	$(".video-img ul li").eq(_indext).show().siblings().hide();
});


  })
  
  
  
  function auto(id){
    var lent=$(""+id+' '+'.engdr'+' '+'img'+"").length-1;
    var jia=0;
    $(""+id+' '+'.next'+"").click(function(){
        jia++;
        if(jia>lent){jia=0};
        $(""+id+' '+'.engdr'+"").stop().animate({left:-jia*615+"px"},300);
    });
    $(""+id+' '+'.pre'+"").click(function(){
      jia--;
      if(jia<0){jia=lent};
      $(""+id+' '+'.engdr'+"").stop().animate({left:-jia*615+"px"},300);
    });   
}
$(function(){
  auto('.box1');//调用函数;
  auto('.box2');
})



