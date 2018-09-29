<style type="text/css">

/*Credits: Dynamic Drive CSS Library */
/*URL: http://www.dynamicdrive.com/style/ */

.suckerdiv li span{
	padding-right:10px;
}

.suckerdiv{
/*padding:3.8em 1.5em 0 0;*/
width:185px;
}
.suckerdiv ul{
margin: 0;
padding: 0;
list-style-type: none;
width: 185px; /* Width of Menu Items */
/*border-bottom: 1px solid #ccc;*/
text-align:left;
}
.suckerdiv ul li{
position: relative;
margin-bottom:3px;
}
/*Sub level menu items */
.suckerdiv ul li ul{
position: absolute;
width: 185px; /*sub menu width*/
top: 0;
visibility: hidden;
left:-185px !important;
}

/* Sub level menu links style */
.suckerdiv ul li a{
	background:url(<?php echo image_url('adminli_bg1.png');?>) no-repeat;
	width:180px;
	height:31px;
	line-height:31px;
	display: block;
	overflow: auto; /*force hasLayout in IE7 */
	color: black;
	text-decoration: none;
/*	padding: 0px 0 0 10px;*/
	/*background:#ccc;border: 1px solid #999;*/
	border-bottom: 0;
	/*text-transform:uppercase;*/
	color:#fff;
	text-align:right;
}

.suckerdiv ul li a:visited{
color: #fff;
}

.suckerdiv ul li a:hover{
/*	background:url(http://localhost/mavenbids/application/css/images/adminli_hoverbg.png) no-repeat;
	width:165px;
	height:31px;
	line-height:31px;
	display: block;*/
/*background-color: #000;*/
color:#1499E4;
}

.suckerdiv .subfolderstyle{
/*background: url(<?php echo image_url('arrow-list.gif');?>) no-repeat center right;
background-color:#ccc;*/
background:url(<?php echo image_url('adminli_bg1.png');?>) no-repeat;
width:180px;
height:31px;
line-height:31px;
display: block;
}

	
/* Holly Hack for IE \*/
* html .suckerdiv ul li { float: left; height: 1%; }
* html .suckerdiv ul li a { height: 1%; }
/* End */

</style>
<script type="text/javascript">

//SuckerTree Vertical Menu 1.1 (Nov 8th, 06)
//By Dynamic Drive: http://www.dynamicdrive.com/style/

var menuids=["suckertree1"] //Enter id(s) of SuckerTree UL menus, separated by commas

function buildsubmenus(){
for (var i=0; i<menuids.length; i++){
  var ultags=document.getElementById(menuids[i]).getElementsByTagName("ul")
    for (var t=0; t<ultags.length; t++){
    ultags[t].parentNode.getElementsByTagName("a")[0].className="subfolderstyle"
		if (ultags[t].parentNode.parentNode.id==menuids[i]) //if this is a first level submenu
			ultags[t].style.left=ultags[t].parentNode.offsetWidth+"px" //dynamically position first level submenus to be width of main menu item
		else //else if this is a sub level submenu (ul)
		  ultags[t].style.left=ultags[t-1].getElementsByTagName("a")[0].offsetWidth+"px" //position menu to the right of menu item that activated it
    ultags[t].parentNode.onmouseover=function(){
    this.getElementsByTagName("ul")[0].style.display="block"
    }
    ultags[t].parentNode.onmouseout=function(){
    this.getElementsByTagName("ul")[0].style.display="none"
    }
    }
		for (var t=ultags.length-1; t>-1; t--){ //loop through all sub menus again, and use "display:none" to hide menus (to prevent possible page scrollbars
		ultags[t].style.visibility="visible"
		ultags[t].style.display="none"
		}
  }
}

if (window.addEventListener)
window.addEventListener("load", buildsubmenus, false)
else if (window.attachEvent)
window.attachEvent("onload", buildsubmenus)

</script>
<div id="sideBar">
  <div class="sideBar1 clsFloatRight">
      <div class="suckerdiv">
        <ul id="suckertree1">
          <li><a href="<?php echo admin_url('home');?>"><span><?= t('Dash Board'); ?></span></a></li>
          <li><a href="<?php echo admin_url('siteSettings');?>"><span><?= t('website_settings'); ?></span></a></li>
          <li><a href="<?php echo admin_url('paymentSettings');?>"><span><?= t('payment_settings'); ?></span></a></li>
          <li><a href="<?php echo admin_url('emailSettings');?>"><span><?= t('Email Settings'); ?></span></a></li>
		  <li><a href="#"><span class="clsblue_arrow1"><?= t('Payments'); ?></span></a>
            <ul>
              <li><a href="#"><span><?= t('Transaction'); ?></span></a>
                <ul>
                  <li><a href="<?php echo admin_url('payments/transaction');?>"><span><?= t('View All'); ?></span></a></li>
                </ul>
              </li>
			<li><a href="#"><span><?= t('Withdrawal Queue'); ?></span></a>
			    <ul>
                  <li><a href="<?php echo admin_url('payments/releaseWithdraw');?>"><span><?= t('Release Withdraw'); ?></span></a></li>
                  <li><a href="<?php echo admin_url('payments/viewWithdraw');?>"><span><?= t('View All'); ?></span></a></li>
                 </ul>
			  </li>
			  
              <li><a href="#"><span><?= t('Escrow Transaction'); ?></span></a>
                <ul>
                  <li><a href="<?php echo admin_url('payments/releaseEscrow');?>"><span><?= t('Escrow Release'); ?></span></a></li>
                  <li><a href="<?php echo admin_url('payments/viewEscrow');?>"><span><?= t('View All'); ?></span></a></li>
                </ul>
				</li>
			</ul>	
          </li>
           <li><a href="#"><span class="clsblue_arrow2"><?= t('Manage Users'); ?></span></span></a>
            <ul>
				<li><a href="#"><span><?= t('Users'); ?></span></a>
                <ul>
				<li><a href="<?php echo admin_url('users/searchUsers');?>"><span><?= t('search_user'); ?></span></a></li>
                  <li><a href="<?php echo admin_url('users/addUsers');?>"><span><?= t('Add users'); ?></span></a></li>
                  <li><a href="<?php echo admin_url('users/viewUsers');?>"><span><?= t('View users'); ?></span></a></li>
                  
                </ul>
				</li>
              <li><a href="#"><span><?= t('Bans'); ?></span></a>
                <ul>
                  <li><a href="<?php echo admin_url('users/addBans');?>"><span><?= t('Add bans'); ?></span></a></li>
                  <li><a href="<?php echo admin_url('users/editBans');?>"><span><?= t('Edit bans'); ?></span></a></li>
                </ul>
              </li>
              
			    <li><a href="#"><span><?= t('Suspend'); ?></span></a>
			  	<ul>
					<li><a href="<?php echo admin_url('users/addSuspend'); ?>"><span><?= t('Add Suspend'); ?></span></a></li>
					<li><a href="<?php echo admin_url('users/editSuspend'); ?>"><span><?= t('Edit Suspend'); ?></span></a></li>
		 		</ul>
			  </li>
            </ul>
          </li>
		  <li><a href="#"><span class="clsblue_arrow3"><?= t('Manage Packages'); ?></span></a>
            <ul>
              <li><a href="#"><span><?= t('Packages'); ?></span></a>
                <ul>
                  <li><a href="<?php echo admin_url('packages/addPackages');?>" ><span><?= t('Add Package'); ?></span></a></li>
                  <!--<li><a href="<?php echo admin_url('packages/searchPackage');?>"><?= t('Search'); ?></a></li>-->
                  <li><a href="<?php echo admin_url('packages/viewpackage');?>"><span><?= t('View All'); ?></span></a></li>
                </ul>
              </li>
              <li><a href="<?php echo admin_url('packages/viewsubscriptionuser');?>"><span><?= t('Subscription Users'); ?></span></a>
			  <ul>
                  <li><a href="<?php echo admin_url('packages/viewsubscriptionuser');?>" ><span><?= t('View subscribed users'); ?></span></a></li>
                  <li><a href="<?php echo admin_url('packages/searchsubscriptionuser');?>"><span><?= t('Search Subscription user'); ?></span></a></li>
                </ul>
				</li>
              <li><a href="<?php echo admin_url('packages/viewsubscriptionpayment');?>"><span><?= t('Subscription payment'); ?></span></a>
			  <ul>
			   <li><a href="<?php echo admin_url('packages/viewsubscriptionpayment');?>"><span><?= t('View subscription Payment'); ?></span></a></li>
                  <li><a href="<?php echo admin_url('packages/searchsubscriptionpayment');?>"><span><?= t('Search Subscription Payment'); ?></span></a></li>
				  </ul>
			  </li> 
			</ul>	
          </li>
		  <li><a href="<?php echo admin_url('users/viewAdmin');?>"><span><?= t('View Admin'); ?></span></a></li>
          <li><a href="<?php echo admin_url('skills/viewGroups');?>"><span><?= t('groups'); ?></span></a></li>
          <li><a href="<?php echo admin_url('skills/view_cate');?>"><span><?= t('categories'); ?></span></a></li>
		  <li><a href="<?php echo admin_url('skills/view_slide');?>"><span><?php echo "Slider"; ?></span></a></li>
		  
          <li><a href="<?php echo admin_url('skills/viewQuotes');?>"><span><?= t('Quotes'); ?></span></a></li>
          <li><a href="<?php echo admin_url('skills/viewJobs');?>"><span><?= t('Jobs'); ?></span></a></li>
		  <li><a href="<?php echo admin_url('support/viewSupport');?>"><span><?= t('support'); ?></span></a></li>
		  <li><a href="<?php echo admin_url('jobCases/viewCases');?>"><span><?= t('dispute'); ?></span></a></li>
          <li><a href="<?php echo admin_url('faq/viewFaqs');?>"><span><?= t('faqs'); ?></span></a></li>
          <li><a href="<?php echo admin_url('page/viewPages');?>"><span><?= t('Manage Static pages'); ?></span></a></li>
         </ul>
      </div> 
  </div>
</div>