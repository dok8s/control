function show_win(Ag_id,Ag_name) {
	document.all["re_window"].style.display="none";
	agAcc.aid.value=Ag_id;
	document.all["acc_title"].innerHTML="<font color=#FFFFFF>&nbsp;请输入结帐日期{"+Ag_id+"."+Ag_name+"}</font>";
	acc_window.style.top=document.body.scrollTop+event.clientY+15;
	acc_window.style.left=document.body.scrollLeft+event.clientX-20; 
	//nowDate = new Date();
	//document.all["acc_date"].value = nowDate.getYear()+'-'+nowDate.getMonth()+'-'+nowDate.getDate();
	document.all["acc_window"].style.display = "block";
	document.agAcc.acc_date.focus();
}
function show_win1(Ag_id,Ag_name) {
	document.all["acc_window"].style.display = "none";
	agre.aid.value=Ag_id;
	document.all["re_title"].innerHTML="<font color=#FFFFFF>&nbsp;请输入回复日期{"+Ag_id+"."+Ag_name+"}</font>";
	re_window.style.top=document.body.scrollTop+event.clientY+15;
	re_window.style.left=document.body.scrollLeft+event.clientX-20; 
	//nowDate = new Date();
	//document.all["acc_date"].value = nowDate.getYear()+'-'+nowDate.getMonth()+'-'+nowDate.getDate();
	document.all["re_window"].style.display = "block";
	document.agre.acc_date.focus();
}
function close_win() {
	document.all["acc_window"].style.display = "none";
	document.all["re_window"].style.display="none";
}

function Chk_acc(){
	if(document.agAcc.acc_date.value=='' || document.agAcc.acc_date.value.length != 10){
		document.agAcc.acc_date.focus();
		alert("请输入结帐日期(YYYYMMDD)!!");
		return false;
	}
	if(document.agre.acc_date.value=='' || document.agre.acc_date.value.length != 10){
		document.agre.acc_date.focus();
		alert("请输入回复日期(YYYYMMDD)!!");
		return false;
	}
	close_win();
	return true;
}

function CheckDEL(str)
{
 var enable_s = document.all.enable.value;
 var page = document.all.page.value;
 //if(confirm("是否确定删除该代理商?"))
  //document.location=str+"&enable_s="+enable_s+"&page="+page;
   czm='';
 execScript('czm=InputBox(Chr(13)&Chr(10)&Chr(13)&Chr(10)&Chr(13)&Chr(10)&"请输入操作码，并确定删除！","")','vbscript');
 if(czm!='' && czm!=undefined){
  document.location=str+"&enable_s="+enable_s+"&page="+page+"&czm="+escape(czm);
 }
}
function CheckSTOP(str)
{
 var enable_s = document.all.enable.value;
 var page = document.all.page.value;
 if(confirm("是否确定(停用/启用) 该代理商?"))
  document.location=str+"&enable_s="+enable_s+"&page="+page;
}