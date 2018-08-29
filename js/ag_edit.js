function SubChk()
{	
 if(document.all.super_agents_id.value=='')
 { document.all.super_agents_id.focus(); alert("總代理請務必輸入!!"); return false; }
 if(document.all.username.value=='')
 { document.all.username.focus(); alert("帳號請務必輸入!!"); return false; }
 if(document.all.password.value=='')
 { document.all.password.focus(); alert("密碼請務必輸入!!"); return false; }
  if(document.all.repassword.value=='')
 { document.all.repassword.focus(); alert("確認密碼請務必輸入!!"); return false; }
 if(document.all.password.value != document.all.repassword.value)
 { document.all.password.focus(); alert("密碼確認錯誤,請重新輸入!!"); return false; }
 if(document.all.alias.value=='')
 { document.all.alias.focus(); alert("代理商名稱請務必輸入!!"); return false; }
  if(document.all.maxcredit.value=='' || document.all.maxcredit.value=='0')
 { document.all.maxcredit.focus(); alert("總信用額度請務必輸入!!"); return false; }
 
  if(document.all.winloss_s.value=='')
 { document.all.winloss_s.focus(); alert("請選擇總代理佔成數!!"); return false; }
  if(document.all.winloss_a.value=='')
 { document.all.winloss_a.focus(); alert("請選擇代理商佔成數!!"); return false; } 
 var winloss_a,winloss_s;
 winloss_s=eval(document.all.winloss_s.value);
 winloss_a=eval(document.all.winloss_a.value); 
 //if ((winloss_s+winloss_a-100) < 20 )
 //{
 //  if (winloss_s==0 && winloss_a==100)
 //  {
//
 //  }else{
 //    alert("超過成數~~請重新選擇");
 //    document.all.winloss_s.focus();
 //    return false;
 //  }
 //}
 //if ((winloss_s+winloss_a-100) > 50 )
 //{
 //  if (winloss_s==0 && winloss_a==100)
 //  {
//
 //  }else{
 //    alert("低於成數~~請重新選擇");
 //    document.all.winloss_s.focus();
 //    return false;
 //  }
 //} 
 if ((document.all.old_sid.value!=document.all.super_agents_id.value) && document.all.keys.value=='upd')
 {alert("你已變更此代理商之總代理~~請重新設定其所屬會員之詳細設定!!")}
 if(!confirm("是否確定寫入代理商?"))
 {
  return false;
 }
}

function roundBy(num,num2) {
	return(Math.floor((num)*num2)/num2);
}