$(document).ready(function(){
    $("#generateCode").click(function(){
        $.post("genInventionCode.php",{

            },
            function(data,status){
                if(data=="success"){
                    alert("生成注册码成功！");
                    window.location.reload();
                }else{
                    alert("出现未知错误，请重试或联系管理员！");
                }
            }
        )
    });
});