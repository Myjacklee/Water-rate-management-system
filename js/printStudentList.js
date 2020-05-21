$(document).ready(function(){
    $("#printStudentList").click(function(){
        className=$("#class_name").text().replace(/\n/g,"").replace(/\s/g,"");
        grade=$("#grade").text().replace(/\n/g,"").replace(/\s/g,"");
        studentNum=parseInt($("#student_num").text().replace(/\n/g,"").replace(/\s/g,""));
        var date=new Date();
        var year=date.getFullYear();
        var month=date.getMonth()+1;
        var day=date.getDate();
        var weekday=new Array(7);
        weekday[0]="星期日";
        weekday[1]="星期一";
        weekday[2]="星期二";
        weekday[3]="星期三";
        weekday[4]="星期四";
        weekday[5]="星期五";
        weekday[6]="星期六";
        var week=weekday[date.getDay()];
        var fullDay=year+"年"+month+"月"+day+"日 "+week;
        var doc=new jsPDF()
        var pageWidth=doc.internal.pageSize.getWidth();
        var pageHeigh=doc.internal.pageSize.getHeight();
        var marginLeft=10;
        var marginTop=21;
        var marginBottom=pageHeigh-10;
        var column2=pageWidth/2;
        var student_col_width=column2-marginLeft-1;
        var rowheight=Math.floor((marginBottom-marginTop)*2/studentNum);
        var colFontSize=14;
        doc.addFont("font-normal.ttf","font","normal");
        doc.setFont("font");
        doc.setFontSize(20);
        doc.setLineWidth(0.5);
        doc.text(100,10,grade+className+"饮水收费张贴表","center");
        doc.setFontSize(14);
        doc.text(marginLeft,17,"名单打印时间："+fullDay);
        doc.text(column2,17,"桶数：");
        doc.line(column2,17+0.5,column2+student_col_width,17+0.5);
        doc.setFontSize(colFontSize);

        var printX=marginLeft;
        var printY=marginTop;
        doc.text(printX,printY+4,"编号"+" "+"姓名");
        for (var i=1;i<=parseInt(studentNum);i++){
            printY=printY+rowheight;
            if(printY>marginBottom){
                printX=column2;
                doc.text(printX,marginTop+4,"编号"+" "+"姓名");
                printY=marginTop+rowheight;
            }
            doc.text(printX,printY,String(i)+" "+$("#student_name_"+String(i)).text());
            doc.line(printX,printY+0.5,printX+student_col_width,printY+0.5);
        }
        doc.save(fullDay+" "+grade+className+"水费记次张贴名单"+".pdf");
    });
});