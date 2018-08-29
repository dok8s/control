function show_win(Ag_id,Ag_name) {
	document.all["re_window"].style.display="none";
	agAcc.aid.value=Ag_id;
	document.all["acc_title"].innerHTML="<font color=#FFFFFF>&nbsp;請輸入結帳日期{"+Ag_id+"."+Ag_name+"}</font>";
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
	document.all["re_title"].innerHTML="<font color=#FFFFFF>&nbsp;請輸入回復日期{"+Ag_id+"."+Ag_name+"}</font>";
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
		alert("請輸入結帳日期(YYYYMMDD)!!");
		return false;
	}
	if(document.agre.acc_date.value=='' || document.agre.acc_date.value.length != 10){
		document.agre.acc_date.focus();
		alert("請輸入回復日期(YYYYMMDD)!!");
		return false;
	}
	close_win();
	return true;
}

function CheckDEL(str)
{
 var enable_s = document.all.enable.value;
 var page = document.all.page.value;
 if(confirm("是否確定刪除總代理?"))
  document.location=str+"&enable_s="+enable_s+"&page="+page;
}
function CheckSTOP(str,chk){
	var enable_s = document.all.enable.value;
	var page = document.all.page.value;
	if(chk=='Y'){ 
		if(confirm("是否確定啟用總代理?")) document.location=str+"&enable_s="+enable_s+"&page="+page;
	}
	if(chk=='S'){
		if(confirm("是否確定暫停總代理?")) document.location=str+"&enable_s="+enable_s+"&page="+page;
	}
	if(chk=='N'){
		if(confirm("是否確定停用總代理?")) document.location=str+"&enable_s="+enable_s+"&page="+page;
	}
}