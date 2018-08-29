<!--
function Chk_acc(){
	if(document.agAcc.acc_date.value=='' || document.agAcc.acc_date.value.length != 10){
		document.agAcc.acc_date.focus();
		alert("请输入结帐日期(YYYYMMDD)!!");
		return false;
	}
	close_win();
}

function Chk_acc1(){
	if(document.agre.acc_date.value=='' || document.agre.acc_date.value.length != 10){
		document.agre.acc_date.focus();
		alert("请输入回复日期(YYYYMMDD)!!");
		return false;
	}
	close_win();
}

function show_win(mem_id,mem_name,cdate) {
	agAcc.mid.value=mem_id;
	document.all["acc_title"].innerHTML="<font color=#FFFFFF>&nbsp;请输入结帐日期{"+mem_id+"."+mem_name+"}</font>";
	acc_window.style.top=document.body.scrollTop+event.clientY+15;
	acc_window.style.left=document.body.scrollLeft+event.clientX-20; 
	nowDate = new Date();
	document.all["acc_date"].value =cdate ;
	document.all["cdate"].value =cdate ;
	document.all["acc_window"].style.display = "block";
	document.agAcc.acc_date.focus();
}

function show_win1(mem_id,mem_name,cdate) {
	document.all["acc_window"].style.display = "none";
	agre.mid.value=mem_id;
	document.all["re_title"].innerHTML="<font color=#FFFFFF>&nbsp;请输入回复日期{"+mem_id+"."+mem_name+"}</font>";
	re_window.style.top=document.body.scrollTop+event.clientY+15;
	re_window.style.left=document.body.scrollLeft+event.clientX-20; 
	document.all["cdate"].value =cdate ;
	document.all["re_window"].style.display = "block";
	document.agre.acc_date.focus();
}

function close_win() {
	document.all["acc_window"].style.display = "none";
	document.all["re_window"].style.display="none";
}
function ChangePage()
{
 document.location="./team_wagers_reports.php?page="+document.all.page.value;
}
function CheckDEL(str)
{
 var agent_id = document.all.agent_id.value;
 var enable_s = document.all.enable.value;
 var page = document.all.page.value;
 if(confirm("是否确定要删除该会员?"))

  document.location=str+"&agent_id="+agent_id+"&enable_s="+enable_s+"&page="+page;
}
function CheckSTOP(str)
{
 var agent_id = document.all.agent_id.value;
 var enable_s = document.all.enable.value;
 var page = document.all.page.value;
 if(confirm("是否确定要(停用/启用)该会员?"))
  document.location=str+"&agent_id="+agent_id+"&enable_s="+enable_s+"&page="+page;
}

// -->