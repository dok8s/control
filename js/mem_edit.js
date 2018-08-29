function SubChk()
{
 if(document.all.agents_id.value=='')
 { document.all.agents_id.focus(); alert("請務必選擇代理商!!"); return false; }
 if(document.all.username.value=='')
 { document.all.username.focus(); alert("帳號請務必輸入!!"); return false; }
 if(document.all.password.value=='')
 { document.all.password.focus(); alert("密碼請務必輸入!!"); return false; }
  if(document.all.repassword.value=='')
 { document.all.repassword.focus(); alert("確認密碼請務必輸入!!"); return false; }
 if(document.all.password.value != document.all.repassword.value)
 { document.all.password.focus(); alert("密碼確認錯誤,請重新輸入!!"); return false; }
 if(document.all.alias.value=='')
 { document.all.alias.focus(); alert("會員名稱請務必輸入!!"); return false; }
 if(document.all.pay.value =='3'){
  if(document.all.pay_type[0].checked && (document.all.maxcredit.value=='0' || document.all.maxcredit.value==''))
  {
 	 document.all.maxcredit.focus(); alert("總信用額度請務必輸入!!"); return false; 
  }
 }
 if(document.all.pay.value =='0'){
  if(document.all.maxcredit.value=='0' || document.all.maxcredit.value=='')
  {
 	 document.all.maxcredit.focus(); alert("總信用額度請務必輸入!!"); return false; 
  } 	
 }
 if ((document.all.old_aid.value!=document.all.agents_id.value) && document.all.keys.value=='update')
 {alert("你已變更此之會員代理商~~請重新設定該會員之詳細設定!!")}
 if(!confirm("是否確定寫入會員資料?"))
 {
  return false;
 }
 	if (document.all.type.value != document.all.mem_line.value){
		alert('您已經改變了會員的盤口屬性，\n\n所有的退水值將被歸零，\n\n請重新進入更新退水設定。');
		document.all.mem_line.value='Y';
		}
}