$(document).ready(function(){
    var className;
    var grade;
    var studentNum;
    var allCost;
    var allCount;
    var margin=5;
    var rowLength;
    function setTitle(doc){
        var describeRowLength=40;
        doc.setFontSize(20);
        doc.text(100,10,"饮水收费表","center");
        doc.setFontSize(12);
        doc.text(margin+20,15,"班级："+grade+className);
        doc.text(margin+describeRowLength*2,15,"人数："+studentNum);
        doc.text(margin+describeRowLength*3,15,"总次数："+allCount);
        doc.text(margin+describeRowLength*4,15,"总费用："+allCost);

        doc.text(margin+rowLength*1,20,"编号");
        doc.text(margin+rowLength*2,20,"学号");
        doc.text(margin+rowLength*5,20,"姓名");
        doc.text(margin+rowLength*7,20,"次数");
        doc.text(margin+rowLength*9,20,"费用");
    }
    $("#printChargingList").click(function(){
        className=$("#class_name").text().replace(/\n/g,"").replace(/\s/g,"");
        grade=$("#grade").text().replace(/\n/g,"").replace(/\s/g,"");
        studentNum=$("#student_num").text().replace(/\n/g,"").replace(/\s/g,"");
        allCost=$("#allPrice").val();
        allCount=$("#allCount").text().replace(/\n/g,"").replace(/\s/g,"");

        var a4PageHeight=290;
        var bottomMargin=20;
        var doc=new jsPDF();
        doc.addFont('font-normal.ttf', 'font', 'normal');
        doc.setFont('font');
        doc.setFontSize(20);
        doc.text(100,10,"饮水收费表",'center');
        doc.setFontSize(12);
        doc.setLineWidth(0.5);
        rowLength=20;
        var width=5.5;

        setTitle(doc);
        var indexY=20;
        for(var i=1;i<=studentNum;i++){
            indexY=indexY+width;
            if(indexY>a4PageHeight-bottomMargin){
                doc.addPage();
                setTitle(doc);
                indexY=20+width;
            }
            doc.text(margin+rowLength*1,indexY,String(i));
            doc.text(margin+rowLength*2,indexY,$("#student_ID_"+String(i)).text());
            doc.text(margin+rowLength*5,indexY,$("#student_name_"+String(i)).text());
            doc.text(margin+rowLength*7,indexY,$("#student_"+String(i)+"_count").val());
            doc.text(margin+rowLength*9,indexY,$("#student_"+String(i)+"_price").text()+"元");
            doc.line(margin+rowLength*1,indexY+0.5,margin+rowLength*9+5,indexY+0.5);
        }
        var date=new Date();
        var temp=$("#grade").text();
        var temp2=$("#class_name").text();
        doc.save(String(date.getYear()+1900)+"年"+String(date.getMonth()+1)+"月"+String(date.getDate())+"日 "+grade+className+"水费收取详单"+".pdf");
    }

);
});
