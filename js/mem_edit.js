function SubChk()
{
 if(document.all.agents_id.value=='')
 { document.all.agents_id.focus(); alert("�аȥ���ܥN�z��!!"); return false; }
 if(document.all.username.value=='')
 { document.all.username.focus(); alert("�b���аȥ���J!!"); return false; }
 if(document.all.password.value=='')
 { document.all.password.focus(); alert("�K�X�аȥ���J!!"); return false; }
  if(document.all.repassword.value=='')
 { document.all.repassword.focus(); alert("�T�{�K�X�аȥ���J!!"); return false; }
 if(document.all.password.value != document.all.repassword.value)
 { document.all.password.focus(); alert("�K�X�T�{���~,�Э��s��J!!"); return false; }
 if(document.all.alias.value=='')
 { document.all.alias.focus(); alert("�|���W�ٽаȥ���J!!"); return false; }
 if(document.all.pay.value =='3'){
  if(document.all.pay_type[0].checked && (document.all.maxcredit.value=='0' || document.all.maxcredit.value==''))
  {
 	 document.all.maxcredit.focus(); alert("�`�H���B�׽аȥ���J!!"); return false; 
  }
 }
 if(document.all.pay.value =='0'){
  if(document.all.maxcredit.value=='0' || document.all.maxcredit.value=='')
  {
 	 document.all.maxcredit.focus(); alert("�`�H���B�׽аȥ���J!!"); return false; 
  } 	
 }
 if ((document.all.old_aid.value!=document.all.agents_id.value) && document.all.keys.value=='update')
 {alert("�A�w�ܧ󦹤��|���N�z��~~�Э��s�]�w�ӷ|�����Բӳ]�w!!")}
 if(!confirm("�O�_�T�w�g�J�|�����?"))
 {
  return false;
 }
 	if (document.all.type.value != document.all.mem_line.value){
		alert('�z�w�g���ܤF�|�����L�f�ݩʡA\n\n�Ҧ����h���ȱN�Q�k�s�A\n\n�Э��s�i�J��s�h���]�w�C');
		document.all.mem_line.value='Y';
		}
}