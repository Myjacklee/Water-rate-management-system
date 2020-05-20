$(document).ready(function(){
    function update(){
        var drinkingCount=0;
        var studentNum=parseInt($("#student_num").text());
        for(var i=1;i<=studentNum;i++){
            drinkingCount+=parseInt($("#student_"+String(i)+"_count").val());
        }
        $("#allCount").text(drinkingCount);
        var allPrice=$("#allPrice").val();
        if(drinkingCount==0){
            $("#drinkingUnitPrice").val(0);
        }else{
            $("#drinkingUnitPrice").text((allPrice/drinkingCount).toFixed(2));
            for(var i=1;i<=studentNum;i++){
                var thisStudentDrinkNum=parseInt($("#student_"+String(i)+"_count").val());
                $("#student_"+String(i)+"_price").text((thisStudentDrinkNum*(allPrice/drinkingCount)).toFixed(2));
            }
        }

    }
    $(".drinkingNum").change(function(){
        update();
    });
    $("#allPrice").change(function(){
        update();
    });
});