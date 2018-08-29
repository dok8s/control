//判斷目前應顯示頁面並顯示 
 function ShowGameList()
 {
  if(loading == 'Y') return;
  ltype_obj = body_browse.document.getElementById('ltype');
  ltype_obj.value  = ltype;
  dt_obj = body_browse.document.getElementById("dt_now");
  dt_obj.innerText = '--'+gmt_str+':'+dt_now;
  show_table = body_browse.document.getElementById("glist_table");
  switch(ShowType)
  {
   case 'OU':	//單式
    ShowData_OU(show_table,GameFT,gamount);
    break;

   case 'V':	//上半場
    ShowData_V(show_table,GameFT,gamount);
    break;

   case 'RE':	//走地
    ShowData_RE(show_table,GameFT,gamount);
    break;
   case 'PD':	//波膽
    ShowData_PD(show_table,GameFT,gamount);
    break;

   case 'F':	//半全場
    ShowData_F(show_table,GameFT,gamount);
    break;

   case 'EO':	//總入球
    ShowData_EO(show_table,GameFT,gamount);
    break;
   case 'P':	//過關
    ShowData_P(show_table,GameFT,gamount);
    break;
   case 'PL':	//已開賽
    ShowData_PL(show_table,GameFT,gamount);
    break;
  }
 }
 
//顯示單式畫面資料 
 function ShowData_OU(obj_table,GameData,data_amount)
 {
  with(obj_table)
  {
   //清除table資料
   while(rows.length > 1)
    deleteRow(rows.length-1);
   //開始顯示開放中賽程資料
   for(i=0; i<data_amount; i++)
   {
    nowTR = insertRow();
    if(GameData[i][8] == 'Y')
     nowTR.className = 'm_cen_top';
    else
     nowTR.className = 'm_cen_top_close';
    with(nowTR)
    {
     //日期時間
     nowTD = insertCell();
     nowTD.innerHTML = GameData[i][1];
     //聯盟
     nowTD = insertCell();
     nowTD.innerHTML = '<BR>'+GameData[i][2];
     //場次
     nowTD = insertCell();
     nowTD.innerHTML = GameData[i][3]+'<BR>'+GameData[i][4];
     //隊伍
     nowTD = nowTR.insertCell();
     nowTD.align = 'left';
     nowTD.innerHTML = GameData[i][5]+'<BR>'+GameData[i][6]+'<div align=right><font color=\"#009900\">'+draw+'</font></div>';
     //讓球/注單
     nowTD = insertCell();
     tmpStr = '<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">'+
	      '<tr align=\"right\">';
     //開始寫入賠率
     if(GameData[i][7] == 'H') //強隊是主隊
     {
//      $ratio_h = '<A href=\"#\" onClick=\"window.open(\'FT_chg_ratio.php?call=ou&rtype=R&ltype=1&game_id='+GameData[i][0]+'\');\">'+GameData[i][9]+'</A>';
      $ratio_h = GameData[i][9];
      $ratio_c = '&nbsp';
      $ioratio_h = GameData[i][11];
      $ioratio_c = GameData[i][12];
     }
     else  //強隊是客隊
     {
      $ratio_h = '&nbsp';
//      $ratio_c = '<A  href=\"#\" onClick=\"window.open(\'FT_chg_ratio.php?call=ou&rtype=R&ltype=1&game_id='+GameData[i][0]+'\');\">'+GameData[i][10]+'</A>';
      $ratio_c = GameData[i][10];
      $ioratio_h = GameData[i][11];
      $ioratio_c = GameData[i][12];
     }
     tmpStr += '<td width=\"48%\">'+$ratio_h+'&nbsp'+$ioratio_h+'</td>'+
               '<td><a href=\"FT_list_bet.php?uid='+uid+'&cid='+sid+'&gid='+GameData[i][0]+'&type=H&wtype=R&rtype=R\" target=\"_parent\"><font color=\"#0000FF\">'+GameData[i][13]+'/'+'</font>'+'<font color=\"#CC0000\">'+GameData[i][15]+'</font></a></td></tr>'+
	       '<tr align=\"right\">'+
	       '<td>'+$ratio_c+'&nbsp'+$ioratio_c+'</td>'+
	       '<td><a href=\"FT_list_bet.php?uid='+uid+'&cid='+sid+'&gid='+GameData[i][0]+'&type=C&wtype=R&rtype=R\" target=\"_parent\"><font color=\"#0000FF\">'+GameData[i][14]+'/'+'</font>'+'<font color=\"#CC0000\">'+GameData[i][16]+'</font></a></td></tr>';
     tmpStr += '<tr><td colspan="2">&nbsp;</td></tr></table>';
     nowTD.innerHTML = tmpStr;
     //上下盤/注單
     nowTD = insertCell();
     nowTD.innerHTML = '<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">'+
                       '<tr align=\"right\">'+
		       '<td width=\"52%\">'+GameData[i][17]+'&nbsp'+GameData[i][19]+'<br>'+
		       '<td><A HREF=\"FT_list_bet.php?uid='+uid+'&cid='+sid+'&gid='+GameData[i][0]+'&type=C&wtype=R&rtype=OU\" target=\"_parent\"><font color=\"#0000FF\">'+GameData[i][21]+'/'+'</font>'+'<font color=\"#CC0000\">'+GameData[i][23]+'</font></A></td></tr>'+
		       '<tr align=\"right\"><td>'+GameData[i][18]+'<br>'+
		       '<td><a href=\"FT_list_bet.php?uid='+uid+'&cid='+sid+'&gid='+GameData[i][0]+'&type=H&wtype=R&rtype=OU\" target=\"_parent\"><font color=\"#0000FF\">'+GameData[i][20]+'/'+'</font>'+'<font color=\"#CC0000\">'+GameData[i][22]+'</font></A></td></tr>'+
	 	       '<tr><td colspan=\"3\">&nbsp;</td></tr></table>';
     //獨贏/注單
     nowTD = insertCell();
     nowTD.innerHTML = '<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">'+
                       '<tr align=\"right\">'+
		       '<td width=\"30%\" align=\"left\">'+GameData[i][24]+'<BR></td>'+
		       '<td><A HREF=\"FT_list_bet.php?uid='+uid+'&cid='+sid+'&gid='+GameData[i][0]+'&type=H&wtype=R&rtype=M\" target=\"_parent\"><font color=\"#0000FF\">'+GameData[i][27]+'/'+'</font>'+'<font color=\"#CC0000\">'+GameData[i][30]+'</font></A></td></tr>'+
                       '<tr align=\"right\">'+
		       '<td align=\"left\">'+GameData[i][25]+'<BR></td>'+
		       '<td><A HREF=\"FT_list_bet.php?uid='+uid+'&cid='+sid+'&gid='+GameData[i][0]+'&type=C&wtype=R&rtype=M\" target=\"_parent\"><font color=\"#0000FF\">'+GameData[i][28]+'/'+'</font>'+'<font color=\"#CC0000\">'+GameData[i][31]+'</font></A></td></tr>'+
                       '<tr align=\"right\">'+
		       '<td align=\"left\">'+GameData[i][26]+'<br></td>'+
		       '<td><A HREF=\"FT_list_bet.php?uid='+uid+'&cid='+sid+'&gid='+GameData[i][0]+'&type=N&wtype=R&rtype=M\" target=\"_parent\"><font color=\"#0000FF\">'+GameData[i][29]+'/'+'</font>'+'<font color=\"#CC0000\">'+GameData[i][32]+'</font></A></td></tr></table>';
    }//with(TR)
   }
  }//with(obj_table);
 }



//顯示上半場畫面資料 
 function ShowData_V(obj_table,GameData,data_amount)
 {
  with(obj_table)
  {
   //清除table資料
   while(rows.length > 1)
    deleteRow(rows.length-1);
   //開始顯示開放中賽程資料
   for(i=0; i<data_amount; i++)
   {
    nowTR = insertRow();
    if(GameData[i][8] == 'Y')
     nowTR.className = 'm_cen_top';
    else
     nowTR.className = 'm_cen_top_close';
    with(nowTR)
    {
     //日期時間
     nowTD = insertCell();
     nowTD.innerHTML = GameData[i][1];
     //聯盟
     nowTD = insertCell();
     nowTD.innerHTML = '<BR>'+GameData[i][2];
     //場次
     nowTD = insertCell();
     nowTD.innerHTML = GameData[i][3]+'<BR>'+GameData[i][4];
     //隊伍
     nowTD = nowTR.insertCell();
     nowTD.align = 'left';
     nowTD.innerHTML = GameData[i][5]+'<BR>'+GameData[i][6]+'<div align=right><font color=\"#009900\">'+draw+'</font></div>';
     //讓球/注單
     nowTD = insertCell();
     tmpStr = '<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">'+
	      '<tr align=\"right\">';
     //開始寫入賠率
     if(GameData[i][7] == 'H') //強隊是主隊
     {
      $ratio_h = GameData[i][9];
      $ratio_c = '&nbsp';
      $ioratio_h = GameData[i][11];
      $ioratio_c = GameData[i][12];
     }
     else  //強隊是客隊
     {
      $ratio_h = '&nbsp';
      $ratio_c = GameData[i][10];
      $ioratio_h = GameData[i][11];
      $ioratio_c = GameData[i][12];
     }
     tmpStr += '<td width=\"48%\">'+$ratio_h+'&nbsp'+$ioratio_h+'</td>'+
               '<td><a href=\"FT_list_bet.php?uid='+uid+'&cid='+sid+'&gid='+GameData[i][0]+'&type=H&wtype=V&rtype=V\" target=\"_parent\"><font color=\"#0000FF\">'+GameData[i][13]+'/'+'</font>'+'<font color=\"#CC0000\">'+GameData[i][15]+'</font></a></td></tr>'+
	       '<tr align=\"right\">'+
	       '<td>'+$ratio_c+'&nbsp'+$ioratio_c+'</td>'+
	       '<td><a href=\"FT_list_bet.php?uid='+uid+'&cid='+sid+'&gid='+GameData[i][0]+'&type=C&wtype=V&rtype=V\" target=\"_parent\"><font color=\"#0000FF\">'+GameData[i][14]+'/'+'</font>'+'<font color=\"#CC0000\">'+GameData[i][16]+'</font></a></td></tr>';
     tmpStr += '<tr><td colspan="2">&nbsp;</td></tr></table>';
     nowTD.innerHTML = tmpStr;
     //上下盤/注單
     nowTD = insertCell();
     nowTD.innerHTML = '<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">'+
                       '<tr align=\"right\">'+
		       '<td width=\"52%\">'+GameData[i][17]+'&nbsp'+GameData[i][18]+'<br>'+
		       '<td><A HREF=\"FT_list_bet.php?uid='+uid+'&cid='+sid+'&gid='+GameData[i][0]+'&type=H&wtype=V&rtype=VOU\" target=\"_parent\"><font color=\"#0000FF\">'+GameData[i][20]+'/'+'</font>'+'<font color=\"#CC0000\">'+GameData[i][22]+'</font></A></td></tr>'+
		       '<tr align=\"right\"><td>'+GameData[i][19]+'<br>'+
		       '<td><a href=\"FT_list_bet.php?uid='+uid+'&cid='+sid+'&gid='+GameData[i][0]+'&type=C&wtype=V&rtype=VOU\" target=\"_parent\"><font color=\"#0000FF\">'+GameData[i][21]+'/'+'</font>'+'<font color=\"#CC0000\">'+GameData[i][23]+'</font></A></td></tr>'+
	 	       '<tr><td colspan=\"3\">&nbsp;</td></tr></table>';
     //獨贏/注單
     nowTD = insertCell();
     nowTD.innerHTML = '<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">'+
                       '<tr align=\"right\">'+
		       '<td width=\"30%\" align=\"left\">'+GameData[i][24]+'<BR></td>'+
		       '<td><A HREF=\"FT_list_bet.php?uid='+uid+'&cid='+sid+'&gid='+GameData[i][0]+'&type=H&wtype=V&rtype=VM\" target=\"_parent\"><font color=\"#0000FF\">'+GameData[i][27]+'/'+'</font>'+'<font color=\"#CC0000\">'+GameData[i][30]+'</font></A></td></tr>'+
                       '<tr align=\"right\">'+
		       '<td align=\"left\">'+GameData[i][25]+'<BR></td>'+
		       '<td><A HREF=\"FT_list_bet.php?uid='+uid+'&cid='+sid+'&gid='+GameData[i][0]+'&type=C&wtype=V&rtype=VM\" target=\"_parent\"><font color=\"#0000FF\">'+GameData[i][28]+'/'+'</font>'+'<font color=\"#CC0000\">'+GameData[i][31]+'</font></A></td></tr>'+
                       '<tr align=\"right\">'+
		       '<td align=\"left\">'+GameData[i][26]+'<br></td>'+
		       '<td><A HREF=\"FT_list_bet.php?uid='+uid+'&cid='+sid+'&gid='+GameData[i][0]+'&type=N&wtype=V&rtype=VM\" target=\"_parent\"><font color=\"#0000FF\">'+GameData[i][29]+'/'+'</font>'+'<font color=\"#CC0000\">'+GameData[i][32]+'</font></A></td></tr></table>';
	 //單數賠率
     //nowTD = insertCell();
     //nowTD.innerHTML = GameData[i][26]+'<BR>'+
     //                  '<A HREF=\"FT_list_bet.php?uid='+uid+'&cid='+sid+'&gid='+GameData[i][0]+'&wtype=REO&rtype=ROD&type=ROD\">'+GameData[i][27]+'/'+'<font color=\"#CC0000\">'+GameData[i][28]+'</font></A></td>';
     //雙數賠率
     //nowTD = insertCell();
     //nowTD.innerHTML = GameData[i][29]+'<BR>'+
     //                  '<A HREF=\"FT_list_bet.php?uid='+uid+'&cid='+sid+'&gid='+GameData[i][0]+'&wtype=REO&rtype=REV&type=REV\">'+GameData[i][30]+'/'+'<font color=\"#CC0000\">'+GameData[i][31]+'</font></A></td>';
    }//with(TR)
   }
  }//with(obj_table);
 }


//顯示走地畫面資料 
 function ShowData_RE(obj_table,GameData,data_amount)
 {
  winset = '';
  with(obj_table)
  {
   //清除table資料
   while(rows.length > 1)
    deleteRow(rows.length-1);
   //開始顯示開放中賽程資料
   for(i=0; i<data_amount; i++)
   {
    nowTR = insertRow();
    if(GameData[i][8] == 'Y')
     nowTR.className = 'm_cen_top';
    else
     nowTR.className = 'm_cen_top_close';
    with(nowTR)
    {
     //日期時間
     nowTD = insertCell();
     nowTD.innerHTML = GameData[i][1];
     //聯盟
     nowTD = insertCell();
     nowTD.innerHTML = GameData[i][2];
     //場次
     nowTD = insertCell();
     nowTD.innerHTML = GameData[i][3]+'<BR>'+GameData[i][4];
     //隊伍
     nowTD = nowTR.insertCell();
     nowTD.align = 'left';
     nowTD.innerHTML = '<font style=\"background-color:#FFFF00\">'+GameData[i][5]+'&nbsp;&nbsp;'+GameData[i][24]+'<BR>'+GameData[i][6]+'&nbsp;&nbsp;'+GameData[i][25]+'</font><div align=right><font color=\"#009900\">'+draw+'</font></div>';
     //讓球/注單
     nowTD = insertCell();
     tmpStr = '<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">'+
	      '<tr align=\"right\">';
     //開始寫入賠率
     if(GameData[i][7] == 'H') //強隊是主隊
     {
      $ratio_h = GameData[i][9];
      $ratio_c = '&nbsp';
      $ioratio_h = GameData[i][11];
//      $ioratio_h = '<A href=\"#\" onClick=\"window.open(\'FT_chg_ioratio.php?call=ou&type=H&rtype=RE&ltype=1&game_id='+GameData[i][0]+'\');\">'+GameData[i][11]+'</A>';
      $ioratio_c = GameData[i][12];
     }
     else  //強隊是客隊
     {
      $ratio_h = '&nbsp';
      $ratio_c = GameData[i][10];
      $ioratio_h = GameData[i][11];
      $ioratio_c = GameData[i][12];
//      $ioratio_c = '<A href=\"#\" onClick=\"window.open(\'FT_chg_ioratio.php?call=ou&type=C&rtype=RE&ltype=1&game_id='+GameData[i][0]+'\');\">'+GameData[i][12]+'</A>';
     }
     tmpStr += '<td width=\"48%\">'+$ratio_h+'&nbsp'+$ioratio_h+'</td>'+
               '<td><a href=\"FT_list_bet.php?uid='+uid+'&cid='+sid+'&gid='+GameData[i][0]+'&type=H&wtype=R&rtype=RE\" target=\"_parent\"><font color=\"#0000FF\">'+GameData[i][13]+'/'+'</font>'+'<font color=\"#CC0000\">'+GameData[i][15]+'</font></a></td></tr>'+
	       '<tr align=\"right\">'+
	       '<td>'+$ratio_c+'&nbsp'+$ioratio_c+'</td>'+
	       '<td><a href=\"FT_list_bet.php?uid='+uid+'&cid='+sid+'&gid='+GameData[i][0]+'&type=C&wtype=R&rtype=RE\" target=\"_parent\"><font color=\"#0000FF\">'+GameData[i][14]+'/'+'</font>'+'<font color=\"#CC0000\">'+GameData[i][16]+'</font></a></td></tr>';
     tmpStr += '<tr><td colspan="2">&nbsp;</td></tr></table>';
     nowTD.innerHTML = tmpStr;
     //上下盤/注單
     nowTD = insertCell();
     nowTD.innerHTML = '<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">'+
                       '<tr align=\"right\">'+
		       '<td width=\"52%\">'+GameData[i][17]+'&nbsp'+GameData[i][19]+'<br></td>'+
		       '<td><A HREF=\"FT_list_bet.php?uid='+uid+'&cid='+sid+'&gid='+GameData[i][0]+'&type=C&wtype=R&rtype=ROU\" target=\"_parent\"><font color=\"#0000FF\">'+GameData[i][21]+'/'+'</font>'+'<font color=\"#CC0000\">'+GameData[i][23]+'</font></A></td></tr>'+
		       '<tr align=\"right\"><td>&nbsp'+GameData[i][18]+'<br></td>'+
		       '<td><A HREF=\"FT_list_bet.php?uid='+uid+'&cid='+sid+'&gid='+GameData[i][0]+'&type=H&wtype=R&rtype=ROU\" target=\"_parent\"><font color=\"#0000FF\">'+GameData[i][20]+'/'+'</font>'+'<font color=\"#CC0000\">'+GameData[i][22]+'</font></A></td></tr>'+
	 	       '<tr><td colspan=\"2\">&nbsp;</td></tr></table>';


	 //單數賠率
     nowTD = insertCell();
     nowTD.innerHTML = GameData[i][26]+'<BR>'+
                       '<A HREF=\"FT_list_bet.php?uid='+uid+'&cid='+sid+'&gid='+GameData[i][0]+'&wtype=REO&rtype=ROD&type=ROD\">'+GameData[i][27]+'/'+'<font color=\"#CC0000\">'+GameData[i][28]+'</font></A></td>';
     //雙數賠率
     nowTD = insertCell();
     nowTD.innerHTML = GameData[i][29]+'<BR>'+
                       '<A HREF=\"FT_list_bet.php?uid='+uid+'&cid='+sid+'&gid='+GameData[i][0]+'&wtype=REO&rtype=REV&type=REV\">'+GameData[i][30]+'/'+'<font color=\"#CC0000\">'+GameData[i][31]+'</font></A></td>';

    }//with(TR)
   }
  }//with(obj_table);
 }
 

//顯示波膽畫面資料 
 function ShowData_PD(obj_table,GameData,data_amount,show_type)
 {
  with(obj_table)
  {
   //清除table資料
   while(rows.length > 1)
    deleteRow(rows.length-1);
   //開始顯示開放中賽程資料
   flag = 0;
   for(i=0; i<data_amount; i++)
   {    
    if(GameData[i][8] == 'Y')
    {
     tr_class = 'm_cen';
     input_class = 'za_text_pd';
    }
    else
    {
     tr_class = 'm_cen_close';
     input_class = 'za_text_pd_close';
    }
    nowTR = insertRow();
    nowTR.className = tr_class;
    //主隊波膽資料顯示
    with(nowTR)
    {
     //日期時間
     nowTD = insertCell();
//     nowTD.rowSpan = 2;
     nowTD.innerHTML = GameData[i][1];
     //聯盟
     nowTD = insertCell();
//     nowTD.rowSpan = 2;
     nowTD.innerHTML = '<br>'+GameData[i][2];
     //隊伍
     nowTD = insertCell();
     nowTD.align = 'left';
     //nowTD.innerHTML = '<a href=\"FT_list_bet.php?uid='+uid+'&cid='+sid+'&gid='+GameData[i][0]+'&wtype=PD\" onmouseover=\"javascript:show_bet(\''+GameData[i][6]+' vs '+GameData[i][5]+': '+GameData[i][36]+' / '+GameData[i][37]+'\');\";>'+GameData[i][5]+'</a>';
     nowTD.innerHTML = GameData[i][5]+'<br>'+GameData[i][6];
     
     //-----------------------------
     nowTD = insertCell();
     nowTD.align = 'right';
     nowTD.innerHTML = '<a href=\"FT_list_bet.php?uid='+uid+'&cid='+sid+'&gid='+GameData[i][0]+'&wtype=PD\"><font color=\"#0000FF\">'+GameData[i][9]+'/'+'</font>'+'<font color=\"#CC0000\">'+GameData[i][10]+'</font></a>';    
     //-----------------------------
     /*     
     //寫入波膽賠率
     nowTD = insertCell();
     nowTD.innerHTML = GameData[i][9];
     nowTD = insertCell();
     nowTD.innerHTML = GameData[i][10];
     nowTD = insertCell();
     nowTD.innerHTML = GameData[i][11];
     nowTD = insertCell();
     nowTD.innerHTML = GameData[i][12];
     nowTD = insertCell();
     nowTD.innerHTML = GameData[i][13];
     nowTD = insertCell();
     nowTD.innerHTML = GameData[i][14];
     nowTD = insertCell();
     nowTD.innerHTML = GameData[i][15];
     nowTD = insertCell();
     nowTD.innerHTML = GameData[i][16];
     nowTD = insertCell();
     nowTD.innerHTML = GameData[i][17];
     nowTD = insertCell();
     nowTD.innerHTML = GameData[i][18];
     nowTD = insertCell();
     nowTD.rowSpan = 2;
     nowTD.innerHTML = GameData[i][19];
     nowTD = insertCell();
     nowTD.rowSpan = 2;
     nowTD.innerHTML = GameData[i][20];
     nowTD = insertCell();
     nowTD.rowSpan = 2;
     nowTD.innerHTML =  GameData[i][21];
     nowTD = insertCell();
     nowTD.rowSpan = 2;
     nowTD.innerHTML =  GameData[i][22];
     nowTD = insertCell();
     nowTD.rowSpan = 2;
     nowTD.innerHTML = GameData[i][23];
     nowTD = insertCell();
     nowTD.innerHTML = GameData[i][24];
     */
    }//with(TR)主隊
    
/*     
    nowTR = insertRow();
    nowTR.className = tr_class;

    //客隊波膽資料顯示
    with(nowTR)
    {
     //寫入波膽賠率
     //nowTD = insertCell();
     //nowTD.align = 'left';
     //nowTD.innerHTML = GameData[i][6]+'<br>';

      
     nowTD = insertCell();
     nowTD.innerHTML = GameData[i][25];
     nowTD = insertCell();
     nowTD.innerHTML = GameData[i][26];
     nowTD = insertCell();
     nowTD.innerHTML = GameData[i][27];
     nowTD = insertCell();
     nowTD.innerHTML = GameData[i][28];
     nowTD = insertCell();
     nowTD.innerHTML = GameData[i][29];
     nowTD = insertCell();
     nowTD.innerHTML = GameData[i][30];
     nowTD = insertCell();
     nowTD.innerHTML = GameData[i][31];
     nowTD = insertCell();
     nowTD.innerHTML = GameData[i][32];
     nowTD = insertCell();
     nowTD.innerHTML = GameData[i][33];
     nowTD = insertCell();
     nowTD.innerHTML = GameData[i][34];
     nowTD = insertCell();
     nowTD.innerHTML = GameData[i][35];
    
    }//with(TR)客隊
 */    
   }
  }//with(obj_table);
 }



//顯示半全場畫面資料 
 function ShowData_F(obj_table,GameData,data_amount,show_type)
 {
  with(obj_table)
  {
   //清除table資料
   while(rows.length > 1)
    deleteRow(rows.length-1);
   //開始顯示開放中賽程資料
   flag = 0;
   for(i=0; i<data_amount; i++)
   {    
    if(GameData[i][8] == 'Y')
    {
     tr_class = 'm_cen';
     input_class = 'za_text_f';
    }
    else
    {
     tr_class = 'm_cen_close';
     input_class = 'za_text_f_close';
    }
    nowTR = insertRow();
    nowTR.className = tr_class;
    //主隊波膽資料顯示
    with(nowTR)
    {
     //日期時間
     nowTD = insertCell();
//     nowTD.rowSpan = 2;
     nowTD.innerHTML = GameData[i][1];
     //聯盟
     nowTD = insertCell();
//     nowTD.rowSpan = 2;
     nowTD.innerHTML = '<br>'+GameData[i][2];
     //隊伍
     nowTD = insertCell();
     nowTD.align = 'left';
     //nowTD.innerHTML = '<a href=\"FT_list_bet.php?uid='+uid+'&cid='+sid+'&gid='+GameData[i][0]+'&wtype=PD\" onmouseover=\"javascript:show_bet(\''+GameData[i][6]+' vs '+GameData[i][5]+': '+GameData[i][36]+' / '+GameData[i][37]+'\');\";>'+GameData[i][5]+'</a>';
     nowTD.innerHTML = GameData[i][5]+'<br>'+GameData[i][6];
     
     //-----------------------------
     nowTD = insertCell();
     nowTD.align = 'right';
     nowTD.innerHTML = '<a href=\"FT_list_bet.php?uid='+uid+'&cid='+sid+'&gid='+GameData[i][0]+'&wtype=F\"><font color=\"#0000FF\">'+GameData[i][9]+'/'+'</font>'+'<font color=\"#CC0000\">'+GameData[i][10]+'</font></a>';    
     //-----------------------------
    }//with(TR)主隊
    

   }
  }//with(obj_table);
 }




//顯示總入球畫面資料 
 function ShowData_EO(obj_table,GameData,data_amount,show_type)
 {
  with(obj_table)
  {
   //清除table資料
   while(rows.length > 1)
    deleteRow(rows.length-1);
   //開始顯示開放中賽程資料
   for(i=0; i<data_amount; i++)
   {
    nowTR = insertRow();
    if(GameData[i][8] == 'Y')
     nowTR.className = 'm_cen_top';
    else
     nowTR.className = 'm_cen_top_close';
    with(nowTR)
    {
     //日期時間
     nowTD = insertCell();
     nowTD.align = "center";
     nowTD.innerHTML = GameData[i][1];
     //隊伍
     nowTD = nowTR.insertCell();
     nowTD.align = 'left';
     nowTD.innerHTML = GameData[i][5]+'<BR>'+GameData[i][6];
     //單數賠率
     nowTD = insertCell();
     nowTD.innerHTML = GameData[i][9]+'<BR>'+
                       '<A HREF=\"FT_list_bet.php?uid='+uid+'&cid='+sid+'&gid='+GameData[i][0]+'&wtype=T&rtype=ODD\"><font color=\"#0000FF\">'+GameData[i][10]+'/'+'</font>'+'<font color=\"#CC0000\">'+GameData[i][11]+'</font></A></td>';
     //雙數賠率
     nowTD = insertCell();
     nowTD.innerHTML = GameData[i][12]+'<BR>'+
                       '<A HREF=\"FT_list_bet.php?uid='+uid+'&cid='+sid+'&gid='+GameData[i][0]+'&wtype=T&rtype=EVEN\"><font color=\"#0000FF\">'+GameData[i][13]+'/'+'</font>'+'<font color=\"#CC0000\">'+GameData[i][14]+'</font></A></td>';
     //0~1賠率
     nowTD = insertCell();
     nowTD.innerHTML = GameData[i][15]+'<BR>'+
                       '<A HREF=\"FT_list_bet.php?uid='+uid+'&cid='+sid+'&gid='+GameData[i][0]+'&wtype=T&rtype=0~1\"><font color=\"#0000FF\">'+GameData[i][16]+'/'+'</font>'+'<font color=\"#CC0000\">'+GameData[i][17]+'</font></A></td>';
     //2~3賠率
     nowTD = insertCell();
     nowTD.innerHTML = GameData[i][18]+'<BR>'+
                       '<A HREF=\"FT_list_bet.php?uid='+uid+'&cid='+sid+'&gid='+GameData[i][0]+'&wtype=T&rtype=2~3\"><font color=\"#0000FF\">'+GameData[i][19]+'/'+'</font>'+'<font color=\"#CC0000\">'+GameData[i][20]+'</font></A></td>';
     //4~6賠率
     nowTD = insertCell();
     nowTD.innerHTML = GameData[i][21]+'<BR>'+
                       '<A HREF=\"FT_list_bet.php?uid='+uid+'&cid='+sid+'&gid='+GameData[i][0]+'&wtype=T&rtype=4~6\"><font color=\"#0000FF\">'+GameData[i][22]+'/'+'</font>'+'<font color=\"#CC0000\">'+GameData[i][23]+'</font></A></td>';
     //7up賠率
     nowTD = insertCell();
     nowTD.innerHTML = GameData[i][24]+'<BR>'+
                       '<A HREF=\"FT_list_bet.php?uid='+uid+'&cid='+sid+'&gid='+GameData[i][0]+'&wtype=T&rtype=OVER\"><font color=\"#0000FF\">'+GameData[i][25]+'/'+'</font>'+'<font color=\"#CC0000\">'+GameData[i][26]+'</font></A></td>';
    }//with(TR)
   }
  }//with(obj_table);
 }

//顯示過關畫面資料 
 function ShowData_P(obj_table,GameData,data_amount,show_type)
 {
  with(obj_table)
  {
   //清除table資料
   while(rows.length > 1)
    deleteRow(rows.length-1);
   //開始顯示開放中賽程資料
   for(i=0; i<data_amount; i++)
   {
    nowTR = insertRow();
    if(GameData[i][8] == 'Y')
     nowTR.className = 'm_cen';
    else
     nowTR.className = 'm_cen_close';
    with(nowTR)
    {
     //日期時間
     nowTD = insertCell();
     nowTD.innerHTML = GameData[i][1];
     //聯盟
     nowTD = insertCell();
     nowTD.innerHTML = '<BR>'+GameData[i][2];
     //場次
     nowTD = insertCell();
     nowTD.innerHTML = GameData[i][3]+'<BR>'+GameData[i][4];
     //隊伍
     nowTD = nowTR.insertCell();
     nowTD.align = 'left';
     nowTD.innerHTML = GameData[i][5]+'<BR>'+GameData[i][6];
     //過關注單數量/金額
     nowTD = insertCell();
     nowTD.align = 'right';
     nowTD.innerHTML = '<a href=\"FT_list_bet.php?uid='+uid+'&cid='+sid+'&gid='+GameData[i][0]+'&type=H&wtype=P\"><font color=\"#0000FF\">'+GameData[i][9]+'/'+'</font>'+'<font color=\"#CC0000\">'+GameData[i][12]+'</font></a><br>'+
                       '<a href=\"FT_list_bet.php?uid='+uid+'&cid='+sid+'&gid='+GameData[i][0]+'&type=C&wtype=P\"><font color=\"#0000FF\">'+GameData[i][10]+'/'+'</font>'+'<font color=\"#CC0000\">'+GameData[i][13]+'</font></a><br>'+
                       '<a href=\"FT_list_bet.php?uid='+uid+'&cid='+sid+'&gid='+GameData[i][0]+'&type=N&wtype=P\"><font color=\"#0000FF\">'+GameData[i][11]+'/'+'</font>'+'<font color=\"#CC0000\">'+GameData[i][14]+'</font></a>';
    }//with(TR)
   }
  }//with(obj_table);
 }

//顯示已開賽畫面資料 
 function ShowData_PL(obj_table,GameData,data_amount)
 {
  with(obj_table)
  {
   //清除table資料
   while(rows.length > 1)
    deleteRow(rows.length-1);
   //開始顯示開放中賽程資料
   for(i=0; i<data_amount; i++)
   {
    nowTR = insertRow();
    nowTR.align = 'right';
    if(GameData[i][55]=='Y'){
    nowTR.bgColor = '#CCCCCC';
   }else{
    nowTR.bgColor = '#FFFFFF';
   }
    with(nowTR)
    {
     //日期時間
     nowTD = insertCell();
     nowTD.align = 'center';
     nowTD.innerHTML = GameData[i][1];
     //聯盟
     nowTD = insertCell();
     nowTD.align = 'center';
     nowTD.innerHTML = '<BR>'+GameData[i][2];
     //場次
     nowTD = insertCell();
     nowTD.align = 'center';
     nowTD.innerHTML = GameData[i][3]+'<BR>'+GameData[i][4];
     //隊伍
     nowTD = nowTR.insertCell();
     nowTD.align = 'left';
     nowTD.innerHTML = GameData[i][5]+'<BR>'+GameData[i][6]+'<div align=right><font color=\"#006600\">'+draw+'</font></div>';

     //讓球/注單
     nowTD = insertCell();
     nowTD.vAlign = 'top';
     tmpStr = '<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\"><tr align=right>';
     //開始寫入賠率
     if(GameData[i][7] == 'H') //強隊是主隊
     {
      ratio_RH = GameData[i][9];
      ratio_RC = '&nbsp';
     }
     else  //強隊是客隊
     {
      ratio_RH = '&nbsp';
      ratio_RC = GameData[i][10];
     }
     nowTD.innerHTML = '<table width=100% border=\"0\" cellspacing=\"0\" cellpadding=\"0\"><tr align=right><td width=\"50\"><font color=#0000bb>'+ratio_RH+'</font>&nbsp;</td>'+
		'<td width=\"30\">'+GameData[i][11]+'&nbsp;</td>'+
		'<td ><a href=\"FT_list_bet.php?uid='+uid+'&gid='+GameData[i][0]+'&type=H&wtype=R&rtype=R\" target=\"_parent\"><font color=\"#0000FF\">'+GameData[i][13]+'/'+'</font>'+'<font color=\"#CC0000\">'+GameData[i][15]+'</font></a></td></tr>'+
                '<tr align=right><td width=\"50\"><font color=#0000bb>'+ratio_RC+'</font>&nbsp;</td>'+
                '<td width=\"30\">'+GameData[i][12]+'&nbsp;</td>'+
                '<td ><a href=\"FT_list_bet.php?uid='+uid+'&gid='+GameData[i][0]+'&type=C&wtype=R&rtype=R\" target=\"_parent\"><font color=\"#0000FF\">'+GameData[i][14]+'/'+'</font>'+'<font color=\"#CC0000\">'+GameData[i][16]+'</font></a></td>'+
                '</tr></table></td>';

     //上半場
     nowTD = insertCell();
     nowTD.vAlign = 'top';
     nowTD.innerHTML = '<a href=\"FT_list_bet.php?uid='+uid+'&gid='+GameData[i][0]+'&type=H&wtype=V&rtype=V\" target=\"_parent\"><font color=\"#0000FF\">'+GameData[i][58]+'/'+'</font>'+'<font color=\"#CC0000\">'+GameData[i][60]+'</font></a><br>'+
                       '<a href=\"FT_list_bet.php?uid='+uid+'&gid='+GameData[i][0]+'&type=C&wtype=V&rtype=V\" target=\"_parent\"><font color=\"#0000FF\">'+GameData[i][59]+'/'+'</font>'+'<font color=\"#CC0000\">'+GameData[i][61]+'</font></a>';


     //走地
     nowTD = insertCell();
     nowTD.vAlign = 'top';
     nowTD.innerHTML = '<a href=\"FT_list_bet.php?uid='+uid+'&gid='+GameData[i][0]+'&type=H&wtype=R&rtype=RE\" target=\"_parent\"><font color=\"#0000FF\">'+GameData[i][17]+'/'+'</font>'+'<font color=\"#CC0000\">'+GameData[i][19]+'</font></a><br>'+
                       '<a href=\"FT_list_bet.php?uid='+uid+'&gid='+GameData[i][0]+'&type=C&wtype=R&rtype=RE\" target=\"_parent\"><font color=\"#0000FF\">'+GameData[i][18]+'/'+'</font>'+'<font color=\"#CC0000\">'+GameData[i][20]+'</font></a>';
     //上下盤/注單
     nowTD = insertCell();
     nowTD.vAlign = 'top';
     nowTD.innerHTML = '<A HREF=\"FT_list_bet.php?uid='+uid+'&gid='+GameData[i][0]+'&type=C&wtype=R&rtype=OU\" target=\"_parent\"><font color=\"#0000FF\">'+GameData[i][21]+'/'+'</font>'+'<font color=\"#CC0000\">'+GameData[i][23]+'</font></A><BR>'+
                       '<A HREF=\"FT_list_bet.php?uid='+uid+'&gid='+GameData[i][0]+'&type=H&wtype=R&rtype=OU\" target=\"_parent\"><font color=\"#0000FF\">'+GameData[i][22]+'/'+'</font>'+'<font color=\"#CC0000\">'+GameData[i][24]+'</font></A>';

     //上半大小盤/注單
     nowTD = insertCell();
     nowTD.vAlign = 'top';
     nowTD.innerHTML = '<A HREF=\"FT_list_bet.php?uid='+uid+'&gid='+GameData[i][0]+'&type=H&wtype=V&rtype=VOU\" target=\"_parent\"><font color=\"#0000FF\">'+GameData[i][62]+'/'+'</font>'+'<font color=\"#CC0000\">'+GameData[i][64]+'</font></A><BR>'+
                       '<A HREF=\"FT_list_bet.php?uid='+uid+'&gid='+GameData[i][0]+'&type=C&wtype=V&rtype=VOU\" target=\"_parent\"><font color=\"#0000FF\">'+GameData[i][63]+'/'+'</font>'+'<font color=\"#CC0000\">'+GameData[i][65]+'</font></A>';


     //走地大小/注單
     nowTD = insertCell();
     nowTD.vAlign = 'top';
     nowTD.innerHTML = '<A HREF=\"FT_list_bet.php?uid='+uid+'&gid='+GameData[i][0]+'&type=C&wtype=R&rtype=ROU\" target=\"_parent\"><font color=\"#0000FF\">'+GameData[i][51]+'/'+'</font>'+'<font color=\"#CC0000\">'+GameData[i][53]+'</font></A><BR>'+
                       '<A HREF=\"FT_list_bet.php?uid='+uid+'&gid='+GameData[i][0]+'&type=H&wtype=R&rtype=ROU\" target=\"_parent\"><font color=\"#0000FF\">'+GameData[i][52]+'/'+'</font>'+'<font color=\"#CC0000\">'+GameData[i][54]+'</font></A>';
     
	 //單雙/注單
     wargeEO = eval(GameData[i][72] + '+' + GameData[i][74]); //單雙注單加總
     goldEO = eval(GameData[i][73] + '+' + GameData[i][75]);
     nowTD = insertCell();
     nowTD.vAlign = 'top';
     nowTD.innerHTML = '<A HREF=\"FT_list_bet.php?uid='+uid+'&gid='+GameData[i][0]+'&wtype=REO&rtype=REO&st=1\" target=\"_parent\">'+wargeEO+'/'+'<font color=\"#CC0000\">'+goldEO+'</font></A>';

	 //獨贏/注單
     nowTD = insertCell();
     nowTD.vAlign = 'top';
     nowTD.innerHTML = '<A HREF=\"FT_list_bet.php?uid='+uid+'&gid='+GameData[i][0]+'&type=H&wtype=R&rtype=M\" target=\"_parent\"><font color=\"#0000FF\">'+GameData[i][25]+'/'+'</font>'+'<font color=\"#CC0000\">'+GameData[i][28]+'</font></A><BR>'+
                       '<A HREF=\"FT_list_bet.php?uid='+uid+'&gid='+GameData[i][0]+'&type=C&wtype=R&rtype=M\" target=\"_parent\"><font color=\"#0000FF\">'+GameData[i][26]+'/'+'</font>'+'<font color=\"#CC0000\">'+GameData[i][29]+'</font></A><BR>'+
                       '<A HREF=\"FT_list_bet.php?uid='+uid+'&gid='+GameData[i][0]+'&type=N&wtype=R&rtype=M\" target=\"_parent\"><font color=\"#0000FF\">'+GameData[i][27]+'/'+'</font>'+'<font color=\"#CC0000\">'+GameData[i][30]+'</font></A>';

     //上半獨贏/注單
     nowTD = insertCell();
     nowTD.vAlign = 'top';
     nowTD.innerHTML = '<A HREF=\"FT_list_bet.php?uid='+uid+'&gid='+GameData[i][0]+'&type=H&wtype=V&rtype=VM\" target=\"_parent\"><font color=\"#0000FF\">'+GameData[i][66]+'/'+'</font>'+'<font color=\"#CC0000\">'+GameData[i][69]+'</font></A><BR>'+
                       '<A HREF=\"FT_list_bet.php?uid='+uid+'&gid='+GameData[i][0]+'&type=C&wtype=V&rtype=VM\" target=\"_parent\"><font color=\"#0000FF\">'+GameData[i][67]+'/'+'</font>'+'<font color=\"#CC0000\">'+GameData[i][70]+'</font></A><BR>'+
                       '<A HREF=\"FT_list_bet.php?uid='+uid+'&gid='+GameData[i][0]+'&type=N&wtype=V&rtype=VM\" target=\"_parent\"><font color=\"#0000FF\">'+GameData[i][68]+'/'+'</font>'+'<font color=\"#CC0000\">'+GameData[i][71]+'</font></A>';



     //半全場/注單
     nowTD = insertCell();
     nowTD.vAlign = 'top';
     nowTD.innerHTML = '<A HREF=\"FT_list_bet.php?uid='+uid+'&gid='+GameData[i][0]+'&wtype=F&st=1\" target=\"_parent\"><font color=\"#0000FF\">'+GameData[i][56]+'/'+'</font>'+'<font color=\"#CC0000\">'+GameData[i][57]+'</font></A>';



     //波膽/注單
     nowTD = insertCell();
     nowTD.vAlign = 'top';
     nowTD.innerHTML = '<A HREF=\"FT_list_bet.php?uid='+uid+'&gid='+GameData[i][0]+'&wtype=PD&st=1\" target=\"_parent\"><font color=\"#0000FF\">'+GameData[i][31]+'/'+'</font>'+'<font color=\"#CC0000\">'+GameData[i][32]+'</font></A>';
     //單雙/注單
     wargeEO = eval(GameData[i][33] + '+' + GameData[i][35]); //單雙注單加總
     goldEO = eval(GameData[i][34] + '+' + GameData[i][36]);
     nowTD = insertCell();
     nowTD.vAlign = 'top';
     nowTD.innerHTML = '<A HREF=\"FT_list_bet.php?uid='+uid+'&gid='+GameData[i][0]+'&wtype=T&rtype=EO&st=1\" target=\"_parent\"><font color=\"#0000FF\">'+wargeEO+'/'+'</font>'+'<font color=\"#CC0000\">'+goldEO+'</font></A>';
     //總入球/注單
     warge_A = eval(GameData[i][37] + '+' + GameData[i][39] + '+' + GameData[i][41] + '+' + GameData[i][43]);
     gold_A= eval(GameData[i][38] + '+' + GameData[i][40] + '+' + GameData[i][42] + '+' + GameData[i][44]);
     nowTD = insertCell();
     nowTD.vAlign = 'top';
     nowTD.innerHTML = '<A HREF=\"FT_list_bet.php?uid='+uid+'&gid='+GameData[i][0]+'&wtype=T&rtype=T&st=1\" target=\"_parent\"><font color=\"#0000FF\">'+warge_A+'/'+'</font>'+'<font color=\"#CC0000\">'+gold_A+'</font></A>';
     //過關/注單
     warge_RP = eval(GameData[i][45] + '+' + GameData[i][46] + '+' + GameData[i][47]); //主客隊注單加總
     gold_RP = eval(GameData[i][48] + '+' + GameData[i][49] + '+' + GameData[i][50]);
     nowTD = insertCell();
     nowTD.vAlign = 'top';
     nowTD.innerHTML = '<A HREF=\"FT_list_bet.php?uid='+uid+'&gid='+GameData[i][0]+'&wtype=P&st=1\" target=\"_parent\"><font color=\"#0000FF\">'+warge_RP+'/'+'</font>'+'<font color=\"#CC0000\">'+gold_RP+'</font></A>';
    }//with(TR)
   }
  }//with(obj_table);
 }

