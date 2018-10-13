<?
Session_start();
if (!$_SESSION["ckck"])
{
echo "<script>window.open('".$site."/index.php','_top')</script>";
exit;
}
require ("../member/include/config.inc.php");

$uid			=$_REQUEST['uid'];
$active		=$_REQUEST['active'];
$filename	=$_REQUEST['filename'];
$langx		='zh-cn';



$sql = "select id,level from web_sytnet where uid='$uid' and status=1";
$result = mysql_db_query($dbname,$sql);
$row = mysql_fetch_array($result);
$cou=mysql_num_rows($result);
if($cou==0){
	echo "<script>window.open('$site/index.php','_top')</script>";
	exit;
}
$agname=$row['agname'];
require ("../member/include/traditional.$langx.inc.php");

//$sql = "select agname from web_sytnet where Oid='$uid'";
//$result = mysql_query($sql);
//$row = mysql_fetch_array($result);
//
//$sql = "select agname from web_sytnet where subuser=1 and subname='$agname'";
//$result = mysql_query($sql);


//$sql = "select * from web_system";
//$result = mysql_db_query($dbname,$sql);
//$row = mysql_fetch_array($result);
//$messages=$row['msg_member'];
?>
<html style="width: 98%;margin: 0 auto;">
<head>
<title></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<link rel="stylesheet" href="/style/control/control_main.css" type="text/css">
<link rel="stylesheet" href="/style/control/calendar.css" type="text/css">
<link rel="stylesheet" href="/style/control/control_main1.css" type="text/css">
<style type="text/css">
<!--
.m_title_re {  background-color: #577176; text-align: right; color: #FFFFFF}
.m_bc { background-color: #C9DBDF; padding-left: 7px }

.m_title_ce {background-color: #669999; text-align: center; color: #FFFFFF}

div.bac {
	margin:10px;
	width:740px;
	color: #000;
	padding:5px;
	border:1px solid #C00;
	line-height:1.3em;
	font-size:1em;
}
p.title { margin:0; padding:2px; background-color:#900; color:#FFF; text-align:center;}
b { color:#C30;}
-->
</style>
<script>
var current = null
function colorTRx(flag){
	if(flag==1 && current!=null){
		current.style.backgroundColor = current._background;
		current.style.color = current._font;
		current = null
		return;
	}
	if ((self.event.srcElement.parentElement.rowIndex!=0) && (self.event.srcElement.parentElement.tagName=="TR") && (current!=self.event.srcElement.parentElement)) {
		if (current!=null){
			current.style.backgroundColor = current._background
			current.style.color = current._font
		}
		self.event.srcElement.parentElement._background = self.event.srcElement.parentElement.style.backgroundColor
		self.event.srcElement.parentElement._font = self.event.srcElement.parentElement.style.color
		self.event.srcElement.parentElement.style.backgroundColor = "#FFCC66"
		self.event.srcElement.parentElement.style.color = "red"
		current = self.event.srcElement.parentElement
	}
}

function scroll_chk(){
	SCROLL_FROM.form_action.value='Y';
	if(SCROLL_FROM.scoll_text.value=='') return false;
}
function news_chk(){
	SCROLL_FROM.form_action.value='1';
	if(SCROLL_FROM.scoll_news.value=='') return false;
}
function Delete_sure(filename1)
{
 a=confirm("确定删除此笔资料");
 if (a==true)
 {
 	self.location='body_home.php?uid=<?=$uid?>&active=2&filename='+filename1;
   return true;
 }else{
   return false;
 }
}function go_web(sw1,sw2,sw3) {
    //alert(sw3);
    if(sw1==2){
        Go_Chg_pass(1);
    }else if(sw1==5){
        Go_real(1);
    }	else{
        //window.open(sw3,'main');
        parent.main.location.href=sw3;
    }
}
function Go_real(a){
    var uid="<?=$uid?>";
    Real_Win=window.open("/control/real_lock/index.php"+"?uid=<?=$uid?>","_blank");
}
function Go_Chg_pass(a){
    var uid="<?=$uid?>";
    Real_Win=window.open("chg_passwd.php"+"?uid=<?=$uid?>&flag="+a,"main","width=255,height=135,status=no");
}
</script>
</head>
<link rel="stylesheet" href="/style/control/announcement/a1.css" type="text/css">
<link rel="stylesheet" href="/style/control/announcement/a2.css" type="text/css">
<link rel="stylesheet" href="./css/loader.css" type="text/css">
<script src="/js/jquery-1.10.2.js" type="text/javascript"></script>
<script src="/js/ClassSelect_ag.js" type="text/javascript"></script>
<link rel="stylesheet" href="/style/control/control_main.css" type="text/css">
<link rel="stylesheet" href="/style/control/calendar.css">
<link rel="stylesheet" href="/style/control/control_main1.css" type="text/css">
<link rel="stylesheet" href="/style/home.css" type="text/css">
<link rel=stylesheet type=text/css href="/style/nav/css/zzsc.css">
<script type="text/javascript">
    // 等待所有加载
    $(window).load(function(){
        $('body').addClass('loaded');
        $('#loader-wrapper .load_title').remove();
    });
</script>
<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" vlink="#0000FF" alink="#0000FF" >
<div id="loader-wrapper">
    <div id="loader"></div>
    <div class="loader-section section-left"></div>
    <div class="loader-section section-right"></div>
    <div class="load_title">正在加载...</div>
</div>
<div id="firstpane" class="menu_list" style="float:left;padding-right: 10px;width: 230px;">
    <p class="menu_head current" style="width: 223px;">线上操盘</p>
    <div style="display:block" class=menu_body >
        <a onClick="go_web(1,0,'/control/ctl/ctl.php?uid=<?=$uid?>')" style="cursor:hand"><img src="/images/control/tri.gif">赛程</a>
        <a onClick="go_web(1,0,'/control/ctl/ctl_result.php?uid=<?=$uid?>')" style="cursor:hand"><img src="/images/control/tri.gif">比分</a>
    </div>
    <p class="menu_head current" style="width: 223px;">即时注单</p>
    <div style="display:block" class=menu_body >
        <a onClick="go_web(1,0,'/control/real_wager/index.php?uid=<?=$uid?>');" style='cursor:hand'><img src='/images/control/tri.gif'>足球</a>
        <a onClick="go_web(1,1,'/control/real_wager_BK/index.php?uid=<?=$uid?>');" style='cursor:hand'><img src='/images/control/tri.gif'>篮球</a>
        <a onClick="go_web(1,1,'/control/real_wager_TN/index.php?uid=<?=$uid?>');" style='cursor:hand'><img src='/images/control/tri.gif'>网球</a>
        <a onClick="go_web(1,1,'/control/real_wager_VB/index.php?uid=<?=$uid?>');" style='cursor:hand'><img src='/images/control/tri.gif'>排球</a>
        <a onClick="go_web(1,1,'/control/real_wager_BS/index.php?uid=<?=$uid?>');" style='cursor:hand'><img src='/images/control/tri.gif'>棒球</a>
        <a onClick="go_web(1,1,'/control/real_wager_NFS/loadgame_R.php?uid=<?=$uid?>');" style='cursor:hand'><img src='/images/control/tri.gif'>冠军</a>
    </div>
    <p class="menu_head" style="width: 223px;">系统管理</p>
    <div style="display:none" class=menu_body >
        <?
        if ( $row['level'] == 1 )
        {
            echo "<a onclick=\"go_web(1,0,'/control/system/system.php?uid=";
            echo $uid;
            echo "');\" style=\"cursor:hand\"><img src=\"/images/control/tri.gif\">参数</a>
				                <a onclick=\"go_web(1,0,'/control/data/deldata.php?uid=";
            echo $uid;
            echo "');\" style=\"cursor:hand\"><img src=\"/images/control/tri.gif\">清理数据</a>\t\t\t\t\t\t";
        }
        ?>
        <a onClick="go_web(1,1,'/control/system/notice.php?uid=<?=$uid?>');" style="cursor:hand"><img src="/images/control/tri.gif">即时公告</a>
        <a onClick="go_web(1,0,'/control/system/notice.php?uid=<?=$uid?>&scroll_set=set');" style="cursor:hand"><img src="/images/control/tri.gif">股东历史讯息</a>
        <a onClick="go_web(1,0,'/control/system/showlog.php?level=-2&uid=<?=$uid?>');" style="cursor:hand"><img src="/images/control/tri.gif">超管日志</a>
        <a onClick="go_web(1,0,'/control/system/syslog.php?uid=<?=$uid?>');" style="cursor:hand"><img src="/images/control/tri.gif">代理在线</a>
        <a onClick="go_web(1,0,'/control/system/memlog.php?uid=<?=$uid?>');" style="cursor:hand"><img src="/images/control/tri.gif">会员在线</a>
    </div>
    <p class="menu_head" style="width: 223px;">注单管理</p>
    <div style="display:none" class=menu_body >
        <a onClick="go_web(1,0,'/control/reallist/voucher.php?uid=<?=$uid?>');" style="cursor:hand"><img src="/images/control/tri.gif">流水注单</a>
        <a onClick="go_web(1,0,'/control/reallist/gaidan.php?uid=<?=$uid?>');" style="cursor:hand"><img src="/images/control/tri.gif">改单注单</a>
        <a onClick="go_web(1,0,'/control/reallist/aceept.php?uid=<?=$uid?>');" style="cursor:hand"><img src="/images/control/tri.gif">异常注单</a>
        <a onClick="go_web(1,0,'/control/reallist/danger_list.php?uid=<?=$uid?>');" style="cursor:hand"><img src="/images/control/tri.gif">走地危险球</a>
        <a onClick="go_web(1,0,'/control/reallist/real_list.php?uid=<?=$uid?>');" style="cursor:hand"><img src="/images/control/tri.gif">注单查询</a>
        <?
        if ( $row['level'] == 1 )
        {
            echo "<a onclick=\"go_web(1,0,'/control/wager_add/main.php?uid=$uid');\" style=\"cursor:hand\"><img src=\"/images/control/tri.gif\">手工添单</a>
				\t\t\t\t\t\t";
            echo "<a onclick=\"go_web(1,0,'/control/wager_add1/main.php?uid=$uid');\" style=\"cursor:hand\"><img src=\"/images/control/tri.gif\">过关添单</a>
				\t\t\t\t\t\t";
        }
        ?>
    </div>
    <p class="menu_head" style="width: 223px;">帐号管理</p>
    <div style="display:none" class=menu_body >
        <a onClick="go_web(1,3,'/control/super/super.php?uid=<?=$uid?>');" style='cursor:hand;'> <img src='/images/control/tri.gif'>大股东</a>
        <a onClick="go_web(1,4,'/control/corprator/super_corprator.php?uid=<?=$uid?>');" style='cursor:hand;'> <img src='/images/control/tri.gif'>股东</a>
        <a onClick="go_web(1,5,'/control/super_agent/body_super_agents.php?uid=<?=$uid?>');" style='cursor:hand;'> <img src='/images/control/tri.gif'>总代理</a>
        <a onClick="go_web(1,6,'/control/agents/su_agents.php?uid=<?=$uid?>');" style='cursor:hand;'> <img src='/images/control/tri.gif'>代理</a>
        <a onClick="go_web(1,7,'/control/members/ag_members.php?uid=<?=$uid?>');" style='cursor:hand;'> <img src='/images/control/tri.gif'>会员</a>
        <a onClick="go_web(1,8,'/control/members/ag_members1.php?uid=<?=$uid?>');" style='cursor:hand;'> <img src='/images/control/tri.gif'>异常会员</a>
        <?
        if ( $row['level'] == 1 )
        {

            echo "<a onclick=\"go_web(1,8,'/control/system/set_user_ip.php?uid=$uid');\" style='cursor:hand'><img src='/images/control/tri.gif'>会员绑IP</a>";
        }
        if ( $row['level'] == 1 )
        {
            echo "\t\t\t\t\t\t<a onclick=\"go_web(1,3,'/control/super/subuser.php?uid=";
            echo $uid;
            echo "');\" style=\"cursor:hand\"><img src=\"/images/control/tri.gif\">管理帐号</a>\r\n\t\t\t\t\t\t<a onclick=\"go_web(1,3,'/control/wager/wager_add.php?uid=";
            echo $uid;
            echo "');\" style=\"cursor:hand\"><img src=\"/images/control/tri.gif\">添单账号</a>\r\n\t\t\t\t\t\t<a onclick=\"go_web(1,3,'/control/wager/wager_hide.php?uid=";
            echo $uid;
            echo "');\" style=\"cursor:hand\"><img src=\"/images/control/tri.gif\">隐单账号</a>\r\n\t\t\t\t\t\t";
        }

        ?>
        <a onClick="go_web(2,5,'');" style="cursor:hand"><img src="/images/control/tri.gif">变更密码</a>
    </div>
</div>
<script type=text/javascript>
    $(document).ready(function(){
        $("#firstpane .menu_body:eq(0)").show();
        $("#firstpane p.menu_head").click(function(){
            $(this).addClass("current").next("div.menu_body").slideToggle(300).siblings("div.menu_body").slideUp("slow");
            $(this).siblings().removeClass("current");
        });
        $("#secondpane .menu_body:eq(0)").show();
        $("#secondpane p.menu_head").mouseover(function(){
            $(this).addClass("current").next("div.menu_body").slideDown(500).siblings("div.menu_body").slideUp("slow");
            $(this).siblings().removeClass("current");
        });

    });
</script>
<div id="body_show" style="float:left;width: 800px;"><div>
        <div name="MaxTag" id="home" src="/js/home.js" linkage="home">

            <div id="home_contain" class="home_contain" onresize="setDivSize(this)" style="width: 67%;min-width: 1200px;">
                <div id="home_box" class="home_box">
                    <div id="top_title" class="top_title"><span>帐号新增及密码更改提示</span></div>
                    <div id="status_contain" class="status_contain" style="width: 67%;float:left;">
                        <div id="status_title" class="status_title">
                            <span class="title_box" style="min-width: 150px;">时间</span>
                            <span class="title_box2 margin_right" style="min-width: 60px;">操作者</span>
                            <span class="title_box2" style="min-width: 60px;">项目</span>
                            <span class="title_box2" style="min-width: 60px;">帐号</span>
                            <span class="title_box3" style="min-width: 60px;">阶层</span>
                        </div>
                        <div id="member" class="acc_box">
                            <div style="height:205px;overflow-y:auto">
                                <?
                                if($ag==""){
                                    $sql="select  * from agents_log  where Status=2 and M_czz='$agname' order by M_DateTime desc";
                                }else{
                                    $sql="select  * from agents_log  where Status=2 and (".$ag." M_czz='$agname') order by M_DateTime desc";
                                }
                                $result = mysql_query($sql);
                                while ($row = mysql_fetch_array($result)){
                                    ?>
                                    <div id="last_login" class="acc_box">
                                        <span class="info_box" style="min-width: 150px;"><?=$row["M_DateTime"]?></span>
                                        <span class="info_box2 margin_right red" style="min-width: 60px;"><font id="member_suspended"><?=$row["M_czz"]?></font></span>
                                        <span class="info_box2 black" style="min-width: 60px;"><font id="member_view"><?=$row["M_xm"]?></font></span>
                                        <span class="info_box2 gray" style="min-width: 60px;"><font id="member_inactive"><?=$row["M_user"]?></font></span>
                                        <span class="info_box3 green" style="min-width: 60px;"><font id="member_active"><?=$row["M_jc"]?></font></span>
                                    </div>
                                    <?
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>