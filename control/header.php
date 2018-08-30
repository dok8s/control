<?php
Session_start();
if (!$_SESSION["ckck"])
{
echo "<script>window.open('".$site."/index.php','_top')</script>";
exit;
}
require( "../member/include/config.inc.php" );
$uid = $_REQUEST['uid'];
$langx = "zh-cn";
$sql = "select id,level,agname from web_sytnet where uid='".$uid."' and status=1";
$result = mysql_query( $sql );
$row = mysql_fetch_array( $result );
$admin_name = $row['agname'];
$cou = mysql_num_rows( $result );
if ( $cou == 0 )
{
	echo "<script>window.open('".$site."/index.php','_top')</script>";
	exit;
}
?>
<html>
<head>
<title>皇冠线上管理系统</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" href="/style/control/control_header.css" type="text/css">
<script src="/js/wmenu.js" type="text/javascript"></script>
    <link rel="stylesheet" href="/style/home.css" type="text/css">
    <script src="/js/jquery-1.10.2.js" type="text/javascript"></script>
    <style>
        *{
            padding: 0px;
            margin: 0px;
        }
        body{
            position: relative;
            font-size: 14px;
            background: #ccc;
            font-family: "微软雅黑";
        }
        ul{
            list-style: none;
        }
        a{
            text-decoration: none;
            color: #333;
        }
        .header-nav{
            background: #dd3377;
        }
        .contain{
            position: relative;
            width: 1010px;
            margin: 0 auto;
        }
        .trig{
            display: none;
            position: absolute;
            bottom: 0px;
            left: 45px;
            border-bottom: 6px solid lightsalmon;
            border-left: 8px solid transparent;
            border-right: 8px solid transparent;
        }
        .second-bg{
            display: none;
            position: relative;
            width: 100%;
            height: 40px;
            background:#fff;
            z-index: 1;
        }
        .nav-list{
            position: relative;
            width: 100%;
            height: 40px;
            z-index: 2;
        }
        .nav-list>li{
            position: relative;
            float: left;
            width: 100px;
            height: 40px;
            line-height: 40px;
            text-align: center;
            border-right: 1px solid #e4e4e4;
        }
        .nav-list>li>a{
            color: #fff;
            display: block;
            position: relative;
        }
        .nav-list>li ul{
            position: absolute;
            width: 100px;
            display: none;
            z-index: 666;
        }
        .nav-list>li ul li{
            float: left;
            height: 40px;
            font-size: 13px;
            line-height: 40px;
            margin: 0 2px;
        }
        .nav-list>li ul li a:hover{
            color: #dd3377;
        }
    </style>
</head>
<script type="text/javascript">

document.onmousedown = initDown;
document.onmouseup   = initUp;
document.onmousemove = initMove;
function initDown() {
	doDown();
	moveme_onmousedown();
}
function initUp() {
	doUp();
	moveme_onmouseup();
}
function initMove() {
	moveme_onmousemove();
}

function show_webs(sw) {
	ad_list.style.display='none';
	mo_list.style.display='none';
	op_list.style.display='none';
	ot_list.style.display='none';
	bk_list.style.display='none';
	rl_list.style.display='none';

	switch(sw){
		case'ad':ad_list.style.display='block';break;
		case'mo':mo_list.style.display='block';break;
		case'op':op_list.style.display='block';break;
		case'ot':ot_list.style.display='block';break;
		case'bk':bk_list.style.display='block';break;
		case'rl':rl_list.style.display='block';break;

	}
}
function go_web(sw1,sw2,sw3) {
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
<base target="net_ctl_main"><!-- oncontextmenu="window.event.returnValue=false"-->
<body onLoad="show_webs();"  bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" vlink="D8B20C" alink="D8B20C">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
    <div id="header_show" style="position: fixed;width:100%;z-index:99; top:0px;"><div>
            <div name="MaxTag" id="header" src="/js/header.js" linkage="header">
                <div id="header_div">
                    <div id="header_tr" name="fixHead" class="top_option_contain">
                        <div id="header_td" class="lang_contain" style="width:166px;">
                            <div id="lang_btn" class="lang_btn">
                                <span id="sel_langx" name="sel_langx" class="lang_txt">欢迎-<?=$admin_name?></span>
                            </div>
                        </div>
                        <? if($setdata['d0_ag_online_show']==1){ ?>
                            <div id="online_mem" class="online_btn" title=""><a href='system/syslog.php?uid=<?=$uid?>' target="main"><span style='color:#1e1e1e'>代理在线</span></a></div>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <? } ?>
                        <? if($setdata['d0_mem_online_show']==1){ ?>
                            <div id="online_mem" class="online_btn" title=""><a href="system/memlog.php?uid=<?=$uid?>" target="main"><span style='color:#1e1e1e'>会员在线</span></a></div>
                        <? } ?>

                        <div id="new_url" class="contact_us">[
                            <a style="color:#b8a6a6;" href="/index.php" target="_top" onMouseOver="window.status='登出'; return true;" onMouseOut="window.status='';return true;">登出</a>
                            ]
                        </div>
                        <div id="contactus" class="contact_us" onclick="notice();">联系我们</div>
                        <div id="live_chat" class="live_chat" style="width: 52px;" onclick="notice();">在线客服</div>
                        <div id="live_chat" class="live_chat" style="width: 52px;" onclick="Go_Chg_pass(2);">变更密码</div>
                        <div id="new_url" class="new_url"><a href="/url.html" style="color:#5b534f" target="main" onMouseOver="window.status='最新网址'; return true;" onMouseOut="window.status='';return true;">最新网址</a></div>
                    </div>
                </div>
                <div class="navbox">
                    <div class="nav">

                        <li class="drop-menu-effect"><a href="/control/body_home.php?uid=<?=$uid?>"
                                                        target="main" onMouseOver="window.status='首页'; return true;" onMouseOut="window.status='';return true;">
                                <span>首页</span></a>
                        </li>
                        <li class="drop-menu-effect"> <a href="/control/admin/payment.php?uid=<?=$uid?>"
                                                         target="main" onMouseOver="window.status='支付方式'; return true;" onMouseOut="window.status='';return true;"><span>支付方式</span></a>
                        </li>
                        <li class="drop-menu-effect"> <a href="/control/report/report.php?uid=<?=$uid?>"
                                                         target="main" onMouseOver="window.status='报表'; return true;" onMouseOut="window.status='';return true;"><span>报表</span></a>
                        </li>
                        <li class="drop-menu-effect"> <a href="800/index.php?uid=<?=$uid?>"
                                                         target="main" onMouseOver="window.status='现金系统'; return true;" onMouseOut="window.status='';return true;"><span>现金系统</span></a>
                        </li>
                        <li class="drop-menu-effect"><a href="/control/announcement/get_an.php?uid=<?=$uid?>&langx=<?=$langx?>" target="main" onMouseOver="window.status='公告内容'; return true;" onMouseOut="window.status='';return true;"><span>公告内容</span></a>
                        </li>
                        <?
                        if ( $row['level'] == 1 )
                        {?>
                          <li class="drop-menu-effect"><a href="/control/chat/chat.php?uid=<?=$uid?>&langx=<?=$langx?>" target="main" onMouseOver="window.status='会话'; return true;" onMouseOut="window.status='';return true;"><span>会话</span></a>
                          </li>
                        <?
                        }
                        ?>
                    </div>
                </div>
            </div>

            <div id="lang_select" class="lang_select" style="display:none;" tabindex="9527">
                <span id="lang_en-us">ENG</span>
                <span id="lang_zh-cn">简体</span>
                <span id="lang_zh-tw">繁體</span>
            </div>
            <div id="user_select" class="user_select" style="display:none;" tabindex="9527">
                <span id="logout"><a href="/index.php" target="_top" onMouseOver="window.status='登出'; return true;" onMouseOut="window.status='';return true;" style="color: #000000;">登出</a></span>
            </div>
            <div name="MaxTag" id="langxMC" src="/js/conf/zh_cn.js" linkage="zh_cn" style="display:none;"></div>
            <div name="MaxTag" id="zh-cn" src="/js/zh-cn.js?7742" style="display:none;"></div>
        </div>
    </div>
    </div>
</tr>
</table>
</body>
</html>
<style>
    .highlight{
        background-color: #bb1720;
    }
</style>
<script>
    $(function(){
        $('.nav>li').hover(function(){
            var $ul=$(this).find('ul');
            var oW=$(this).width();//li
            var otrigW=$(this).find('.trig').width();
            var oNavListL=$('.nav-list').offset().left;
            var oTL=$(this).offset().left-oNavListL;//距离最左边的距离
            var oTR=$('.nav-list').width()-oTL-oW;//距离最右边的距离
            console.log(oNavListL+":"+oTL);

            if($ul.find('li').length>0){
                $('.second-bg').show();
                $(this).find('.trig').show();
                $ul.show();
                var sum=0;
                var oLeft=0;
                for(var i=0;i<$ul.find('li').length;i++){
                    sum+=$ul.find('li').eq(i).width()+4;
                }
                $ul.width(sum);
                oLeft=(sum-oW)/2;
                if(oLeft>oTL){//到达左侧边界
                    oLeft=oTL;
                    $ul.css('left',-oLeft+'px');
                    return ;
                }
                if(oLeft>oTR){
                    $ul.css('right',-oTR+'px');
                    return ;
                }
                $ul.css('left',-oLeft+'px');

            }
        },function(){
            $('.second-bg').hide();
            $(this).find('ul').hide();
            $(this).find('.trig').hide();
        });
        lanrenzhijia(".drop-menu-effect");
        $('.nav li').click(function(){
            $(this).addClass('highlight').siblings().removeClass('highlight');
        });
    });
    function lanrenzhijia(_this){
        $(_this).each(function(){
            var $this = $(this);
            var theMenu = $this.find(".submenu");
            var tarHeight = theMenu.height();
            theMenu.css({height:0});
            $this.hover(
                function(){
                    $(this).addClass("mj_hover_menu");
                    theMenu.stop().show().animate({height:tarHeight},400);
                },
                function(){
                    $(this).removeClass("mj_hover_menu");
                    theMenu.stop().animate({height:0},400,function(){
                        $(this).css({display:"none"});
                    });
                }
            );
        });
    }
</script>
<style>
    .top_option_contain {
        position: relative;
        width: 100%;
        height: 35px;
        background-color: #FFFFFF;
        color: #5b534f;
        font-size: 13px;
    }
    .lang_contain {
        margin-left: 20px;
        width: 66px;
        float: left;
        -display: inline;
    }
    .lang_btn {
        background: url(../../images/control/icon_lang.jpg) left no-repeat;
        height: 35px;
        line-height: 35px;
    }
    .lang_txt {
        display: block;
        padding: 0px 0px 0px 19px;
        background: url(../../images/control/icon_arrow.jpg) right no-repeat;
        width: auto;
        cursor: pointer;
    }
    .online_btn {
        margin-left: 27px;
        width: auto;
        height: 35px;
        white-space: nowrap;
        line-height: 35px;
        float: left;
        cursor: pointer;
    }
    .online_btn span {
        color: #7e1414;
    }
    .uesr_code {
        float: right;
        margin-right: 20px;
        -display: inline;
        height: 35px;
        line-height: 35px;
        background: url(../../images/control/icon_arrow.jpg) right no-repeat;
        cursor: pointer;
        padding-right: 22px;
    }
    .note {
        position: relative;
        float: right;
        width: 16px;
        height: 17px;
        background: url(../../images/control/icon_note.png) no-repeat;
        margin-right: 23px;
        margin-top: 12px;
        cursor: pointer;
        z-index: 100;
    }
    .contact_us {
        width: 52px;
        height: 35px;
        float: right;
        line-height: 35px;
        margin-right: 25px;
        cursor: pointer;
    }
    .live_chat {
        width: 70px;
        height: 35px;
        float: right;
        line-height: 35px;
        margin-right: 18px;
        text-align: right;
        cursor: pointer;
        background: url(../../images/control/icon_chat.jpg) no-repeat left center;
    }
    .new_url {
        height: 35px;
        line-height: 35px;
        float: right;
        margin-right: 25px;
        cursor: pointer;
    }
    .nav_container {
        position: relative;
        clear: both;
        width: 100%;
        height: 40px;
        background-color: #7E1414;
        color: #FFFFFF;
        font-size: 15px;
    }
    .nav_back {
        margin: 0;
        width: 40px;
        background: url(../../images/control/nav_back.gif) no-repeat 0 0;
    }
    .nav_box, .nav_box_on, .nav_back {
        float: left;
        height: 40px;
        text-align: center;
        line-height: 40px;
        display: inline;
        cursor: pointer;
        margin: 0 25px;
        text-transform: uppercase;
    }
    .nav_box_on, .nav_box, .top_a:hover {
        color: #FF9999;
        background: url(../../images/control/nav_btn_on.jpg) center bottom no-repeat;
    }
    #home_btn {
        margin: 0 25px 0 20px;
        background-position: center bottom;
    }
    .top_a {
        float: left;
        height: 40px;
        text-align: center;
        line-height: 40px;
        display: inline;
        cursor: pointer;
        margin: 0 25px;
        text-transform: uppercase;
        color: #ffffff;
    }
    a:visited {
        text-decoration: none;
        color: #ffffff;
    }
    a:link {
        text-decoration: none;
        color: #ffffff;
    }
    .navbox{height:40px;position:relative;z-index:9; margin:auto;background:#7E1414;filter:alpha(opacity=90);-moz-opacity:0.90;opacity:0.90;font-family:'微软雅黑';}
    .nav{width:1002px;height:40px; list-style:none;}
    .nav li{float:left;height:40px;position:relative; list-style:none;}
    .nav li.last{background:none;}
    .nav li a{text-decoration:none;}
    .nav li a span{float:left;display:block;line-height:40px;font-size:14px;color:#ffffff;cursor:pointer;width:143px;text-align:center; }
    .mj_hover_menu{text-decoration:none; width:143px; background:url(images/menu_hover.jpg); height:40px;}
    .nav li.selected .submenu{display:block;z-index: 1000;}
    .nav li .submenu{display:none;position:absolute;top:40px;left:-9px;}
    .nav li .submenu li{float:none;padding:0;background:none;height:auto;border-bottom:dotted 0px #BEBEBE;}
    .mj_menu_pro_bg{width:825px; height:235px; background:url(images/menu_pro_bg.png) no-repeat;}
    .mj_menu_pro_main{width:765px; margin:auto; padding-top:12px;}
    .mj_menu_pro_li{ float:left;}
    .mj_menu_li_txt{line-height:22px; font-size:12px; color:#7E1414;}
    .mj_menu_li_txt font{font-size:14px; color:#bb1721;}
    .mj_menu_li_txt a{color:#7E1414; text-decoration:none;}
    .mj_menu_li_txt a:hover{color:#7E1414; text-decoration:underline;}

    .mj_menu_news_bg{width:480px; height:185px; background:url(images/menu_news_bg.png) no-repeat;}
    .mj_menu_news_main{width:440px; margin:auto; padding-top:12px;}
    .mj_menu_news_li{padding:0px 30px; margin-right:30px; height:150px; float:left; border-right:solid 1px #cccccc; }
    .mj_menu_news_img{float:left; text-align:left; color:#bb1721; line-height:30px; font-size:14px;}
    .mj_menu_news_li2{padding:0px 30px; height:150px; float:right; border-left:solid 1px #cccccc; }
    .mj_menu_news_img2{float:left; margin-left:30px; text-align:left; color:#bb1721; line-height:30px; font-size:14px;}
    .mj_menu_news_li3{padding:0px 25px; height:150px; float:right; border-left:solid 1px #cccccc; }
    .mj_menu_news_img3{float:left; margin-left:10px; text-align:left; color:#bb1721; line-height:30px; font-size:14px;}
</style>