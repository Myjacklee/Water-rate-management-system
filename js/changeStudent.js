$(document).ready(function(){
    $("#addStudentButton").click(function () {
        var studentID=$("#addStudentID").val();
        var studentName=$("#addStudentName").val();
        $.post("addStudent.php", {
                ID : studentID,
                name:studentName
            },
            function(data,status){
                if(data=="success"){
                    alert("成功添加学生！");
                    window.location.reload();
                }else{
                    alert("添加学生失败请重新添加！")
                }
            }
        );
    });
    $("#deleteStudentButton").click(function(){
        var studentID=$("#deleteStudentID").val();
        // var studentName=$("#deleteStudentName").val();
        $.post("deleteStudent.php",{
            ID:studentID
        },
        function(data,status){
            if(data=="success"){
                alert("成功删除学号为 "+studentID+" 的学生！");
                window.location.reload();
            }else if(data=="do not exist"){
                alert("不存在学号为 "+studentID+" 的学生，请重新输入学号！");
                $("#deleteStudentID").val("");
            }else{
                alert("出现未知错误，请重试！");
            }
        });
    });
});