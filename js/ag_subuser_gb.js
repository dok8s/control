function show_win() {
	acc_window.style.top=document.body.scrollTop+event.clientY+15;
	acc_window.style.left=document.body.scrollLeft+event.clientX-20; 
	document.all["acc_window"].style.display = "block";
}

function close_win() {
	document.all["acc_window"].style.display = "none";
}

function Chk_acc(){
	if(document.all.new_user.value==''){
		document.all.new_user.focus();
		alert("请输入帐号!!");
		return false;
	}
	if(document.all.new_pass.value==''){
		document.all.new_pass.focus();
		alert("请输入密码!!");
		return false;
	}
	if(document.all.new_alias.value==''){
		document.new_alias.focus();
		alert("叫块!!");
		return false;
	}
	close_win();
	return true;
}

function ChkData(i){
	e_user=eval("document.AG_"+i+".e_user.value");
	e_pass=eval("document.AG_"+i+".e_pass.value");
	if(e_user.length==0 && e_user=="")
	{
		alert('请输入帐号');
		eval("document.AG_"+i+".e_user.focus()");
		return false;
	}
	if(e_pass.length==0 && e_pass=="")
	{
		alert('请输入密码');
		eval("document.AG_"+i+".e_pass.focus()");
		return false;
	}	
	eval("document.AG_"+i+".submit()");
	return true;
}

function CheckDEL(str)
{
 var page = document.all.page.value;
 if(confirm("是否确定删除该子帐号?"))
  document.location=str+"&page="+page;
}