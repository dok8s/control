function SubChk()
{
 if(document.all.super_agents_id.value=='')
 { document.all.super_agents_id.focus(); alert("�ܴ������������!!"); return false; }
 if(document.all.username.value=='')
 { document.all.username.focus(); alert("�ʺ����������!!"); return false; }
 if(document.all.password.value=='')
 { document.all.password.focus(); alert("�������������!!"); return false; }
  if(document.all.repassword.value=='')
 { document.all.repassword.focus(); alert("ȷ���������������!!"); return false; }
 if(document.all.password.value != document.all.repassword.value)
 { document.all.password.focus(); alert("����ȷ�ϴ���,����������!!"); return false; }
 if(document.all.alias.value=='')
 { document.all.alias.focus(); alert("�������������������!!"); return false; }
  if(document.all.maxcredit.value=='' || document.all.maxcredit.value=='0')
 { document.all.maxcredit.focus(); alert("�����ö�����������!!"); return false; }

  if(document.all.winloss_s.value=='' )
 { document.all.winloss_s.focus(); alert("��ѡ���ܴ���ռ����!!"); return false; }
  if(document.all.winloss_a.value=='' )
 { document.all.winloss_a.focus(); alert("��ѡ�������ռ����!!"); return false; } 
 var winloss_a,winloss_s;
 winloss_s=eval(document.all.winloss_s.value);
 winloss_a=eval(document.all.winloss_a.value); 
 if ((winloss_s+winloss_a) < 120 || (winloss_s+winloss_a) > 150) //����`�N�z�ΥN�z�Ӭۥ[���o�j��K��,�p�󤭦� .
 {

 alert(" �ܴ��������̵ĳ����ܺ����� 5 - 8 ���� , �������趨 !! ");
 document.all.winloss_s.focus();
 return false;
 }

 
 if ((document.all.old_sid.value!=document.all.super_agents_id.value) && document.all.keys.value=='upd')
 {alert("���ѱ���˴�����֮�ܴ���~~�������趨��������Ա֮��ϸ�趨!!")}
 if(!confirm("�Ƿ�ȷ��д�������?"))
 {
  return false;
 }
}
function SubChk2(){
 var dfwinloss_s,dfwinloss_a;
 dfwinloss_s=(document.all.dfwinloss_s.value);
 dfwinloss_a=(document.all.dfwinloss_a.value); 
 if(dfwinloss_s!="-" && dfwinloss_a!="-"){
	 if ((dfwinloss_s*1+dfwinloss_a*1) < 120 || (dfwinloss_s*1+dfwinloss_a*1) > 150) //��ʾ�ܴ�����������Ӳ��ô��ڰ˳�,С����� .
	 {
	 alert("Ԥ�� �ܴ��������̵ĳ����ܺ����� 5 - 8 ���� , �������趨 !! ");
	 document.all.dfwinloss_s.focus();
	 return false;
	 }
	 if(!confirm("Ԥ��ĳ������� "+dfday+" ����Ч!!ȷ��Ԥ����?")) {
	  return false;
	 }
 }
 if((dfwinloss_s=="-" && dfwinloss_a!="-")||(dfwinloss_s!="-" && dfwinloss_a=="-") ){
		alert("Ԥ����������� [ - ] ��");
	document.all.dfwinloss_s.focus();
	 return false;
 }

}
function roundBy(num,num2) {
	return(Math.floor((num)*num2)/num2);
}
