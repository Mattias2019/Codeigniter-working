<?php $this->load->view('admin/header'); ?>
<?php $this->load->view('admin/sidebar'); ?>
<div id="main">
  <div class="clsSettings">
    <div class="clsMainSettings">
	
	 <div class="inner_t">
      <div class="inner_r">
        <div class="inner_b">
          <div class="inner_l">
            <div class="inner_tl">
              <div class="inner_tr">
                <div class="inner_bl">
                  <div class="inner_br"> 


<link rel="stylesheet" href="<?php echo base_url() ?>application/css/css/tab.css">
  <script src="<?php echo base_url();?>application/js/jquery.min.js"></script>
  <script src="<?php echo base_url();?>application/js/jquery-ui.js"></script>
 <!-- <link rel="stylesheet" href="/resources/demos/style.css"> -->
  <script>
  var jqq=$.noConflict();
jqq(document).ready(function() {
    jqq( "#tabs" ).tabs();
	
	
	    //handle the click for each of 'li'
  jqq('ul#services li').click(function()
    {
        
        //var newimg = $('img',this).attr('src') == 'birthday12-hp.jpg'?'Bird-blue-icon.png':'birthday12-hp.jpg';
       
	   
	   var newimg = jqq('img',this).attr('src');
        var a=jqq('img',this).attr('src',newimg);
		
		var tarr = newimg.split('/');      // ["static","images","banner","blue.jpg"]
var file = tarr[tarr.length-1];

var user=<?php echo $this->uri->segment(4); ?>; 
  
 window.location="<?php echo admin_url('skills/re_im/'); ?>"+file+"/"+user;

		//alert(file);
    });
	
	
	
  });
  </script>

<style>
ul#services
{
clear:both;
overflow: hidden;
}
ul#services li
{
float:left;
width:15%;

}

input#myfile{
	border:none;
	float:left;
	height:30px;
}
#f1_upload_form label{
	float:left;
	width:100px;
	text-align:left;
	display:block;
}
p#f1_upload_form {
	clear:both;
	overflow:hidden;
}
.clsSubmitBt1{
	float:left!important;
	margin:1em 0 0 100px !important;
}
.catdet {
	margin:20px 0;
}
.catdet p{
	clear:both;
	overflow:hidden;
	text-align:left;
	margin:5px 0;
}
.catdet p span{
	margin:0 0 0 10px;
	font-weight:bold !important;
}
.catdet p label{
	float:left;
	width:150px;
	text-align:left;
	display:block;
	margin:0;
}
</style>
<div class="clsTop clsClearFixSub">
            <div class="clsNav">
          <input type="submit" name="submitBtn" class="clsSubmitBt1 sbtn" value="Back" onclick="goBack()" style="float:right!important;margin:-5px 0 0 !important;"/>
        </div>
		   <div class="clsTitle">
          <h3><?php //echo t('view_group'); ?>Categories image upload</h3>
		  <!--<p style="clear:both;overflow:hidden;"> 
                             
                        
                     </p> -->
        </div>
		
      </div>
	  <?php
	  foreach($categories->result() as $category)
	{			

if($category->id == $this->uri->segment(4))
{

?>
<div class="catdet">
<p><label>category id</label>:<span><?php echo $this->uri->segment(4); ?></span></p>
 <p><label>category name</label>:<span><?php echo $category->category_name; ?></span></p>
 <p><label>Group id</label>:<span><?php echo $category->group_id; ?></span></p>
 </div>
 
<?php
}
}
?>
   
	<div id="tabs">
  <ul>
    <li><a href="#tabs-1">Image Upload</a></li>
    <li><a href="#tabs-2">Reuse image upload</a></li>
    
  </ul>
  <div id="tabs-1">
    <script language="javascript" type="text/javascript">

function startUpload(){
      document.getElementById('f1_upload_process').style.visibility = 'visible';
      document.getElementById('f1_upload_form').style.visibility = 'hidden';
      return true;
}

function stopUpload(success){
      var result = '';
      if (success == 1){
         result = '<span class="msg">The file was uploaded successfully!<\/span><br/><br/>';
		 var x = document.getElementById("myfile").value;
		 var y="<?php echo $this->uri->segment(4); ?>";
   
		window.location="<?php echo admin_url('skills/update_img/'); ?>"+x+"/"+y;
      }
      else {
         result = '<span class="emsg">There was an error during file upload!<\/span><br/><br/>';
      }
      document.getElementById('f1_upload_process').style.visibility = 'hidden';
      document.getElementById('f1_upload_form').innerHTML = result + '<label>File: <input name="myfile" type="file" size="30" /><\/label><label><input type="submit" name="submitBtn" class="sbtn" value="Upload" /><\/label>';
      document.getElementById('f1_upload_form').style.visibility = 'visible';      
      return true;   
}

</script>
<form action="<?php echo admin_url('skills/upload'); ?>" method="post" enctype="multipart/form-data" target="upload_target" onsubmit="startUpload();" >
                     <p id="f1_upload_process" ></p>
                     <p id="f1_upload_form" align="center">
                         <label>File: </label>
                              <input name="myfile" type="file" id="myfile" size="30" />
                         </p>
                       <p style="clear:both;overflow:hidden;"> 
                             <input type="submit" name="submitBtn" class="clsSubmitBt1 sbtn" value="Upload" />
                        
                     </p>
                     
                     <iframe id="upload_target" name="upload_target" src="#" style="width:0;height:0;border:0px solid #fff;"></iframe>
                 </form>
  </div>
  <div id="tabs-2">
  <script>
  function myfunction()
 { 
 var lang = document.getElementById("re_im").value;
  var user=<?php echo $this->uri->segment(4); ?>; 
  
 window.location.href="<?php echo admin_url('skills/re_im/'); ?>"+lang+"/"+user;
 }
 function goBack() {
    window.history.back()
}

  </script>
  
  
  <ul id='services'>
    <?php
$dir = "files/category_logo/";

// Open a directory, and read its contents
if (is_dir($dir)){
  if ($dh = opendir($dir)){
    while (($file = readdir($dh)) !== false){ 
	
	
	?>
	
	
	
	<?php
	if($file == '..' || $file == '.' ) { echo ""; }
	else{
	?>
	<li><img src="<?php echo base_url(); ?>files/category_logo/<?php echo $file;  ?>" height="80" width="70"/></li>
	
	
    <?php
	}
	}
    closedir($dh);
  }
}
?>
</ul>
  </div>
  
</div>
 
		</div></div></div></div></div></div></div></div></div></div> 
		</div>
		
	<?php $this->load->view('admin/footer'); ?>
			

	
 
 
