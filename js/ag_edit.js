function SubChk()
{	
 if(document.all.super_agents_id.value=='')
 { document.all.super_agents_id.focus(); alert("�`�N�z�аȥ���J!!"); return false; }
 if(document.all.username.value=='')
 { document.all.username.focus(); alert("�b���аȥ���J!!"); return false; }
 if(document.all.password.value=='')
 { document.all.password.focus(); alert("�K�X�аȥ���J!!"); return false; }
  if(document.all.repassword.value=='')
 { document.all.repassword.focus(); alert("�T�{�K�X�аȥ���J!!"); return false; }
 if(document.all.password.value != document.all.repassword.value)
 { document.all.password.focus(); alert("�K�X�T�{���~,�Э��s��J!!"); return false; }
 if(document.all.alias.value=='')
 { document.all.alias.focus(); alert("�N�z�ӦW�ٽаȥ���J!!"); return false; }
  if(document.all.maxcredit.value=='' || document.all.maxcredit.value=='0')
 { document.all.maxcredit.focus(); alert("�`�H���B�׽аȥ���J!!"); return false; }
 
  if(document.all.winloss_s.value=='')
 { document.all.winloss_s.focus(); alert("�п���`�N�z������!!"); return false; }
  if(document.all.winloss_a.value=='')
 { document.all.winloss_a.focus(); alert("�п�ܥN�z�Ӧ�����!!"); return false; } 
 var winloss_a,winloss_s;
 winloss_s=eval(document.all.winloss_s.value);
 winloss_a=eval(document.all.winloss_a.value); 
 //if ((winloss_s+winloss_a-100) < 20 )
 //{
 //  if (winloss_s==0 && winloss_a==100)
 //  {
//
 //  }else{
 //    alert("�W�L����~~�Э��s���");
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
 //    alert("�C�󦨼�~~�Э��s���");
 //    document.all.winloss_s.focus();
 //    return false;
 //  }
 //} 
 if ((document.all.old_sid.value!=document.all.super_agents_id.value) && document.all.keys.value=='upd')
 {alert("�A�w�ܧ󦹥N�z�Ӥ��`�N�z~~�Э��s�]�w����ݷ|�����Բӳ]�w!!")}
 if(!confirm("�O�_�T�w�g�J�N�z��?"))
 {
  return false;
 }
}

function roundBy(num,num2) {
	return(Math.floor((num)*num2)/num2);
}