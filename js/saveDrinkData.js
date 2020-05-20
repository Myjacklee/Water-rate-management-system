$(document).ready(function(){
    $("#saveButton").click(function () {
        var studentNum=parseInt($("#student_num").text());
        var totalCost=$("#allPrice").val();
        var totalDrinkNum=$("#allCount").text();
        var price=$("#drinkingUnitPrice").text();
        var url="saveDrinkData.php?";
        for(var i=1;i<=studentNum;i++ ){

            url=url+"student_ID_"+String(i)+"="+$("#student_ID_"+String(i)).text()+"&student_"+String(i)+"_count="+$("#student_"+String(i)+"_count").val()+
                "&student_"+String(i)+"_price="+$("#student_"+String(i)+"_price").text()+"&";
        }
        url+="totalCost="+totalCost+"&";
        url+="totalDrinkNum="+totalDrinkNum+"&";
        url+="price="+price;
   //     url=url.substr(0,url.length-1);
        $.get(url,function(response,status){
            if(response=="success"){
                alert("数据保存成功！");
            }else if(response=="please login"){
                alert("请登录！");
                window.location.load("login.php")
            }else{
                alert("出现未知错误，请稍后重试！");
            }
        })
        }
    );
});