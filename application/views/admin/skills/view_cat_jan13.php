<?php $this->load->view('admin/header'); ?>
<?php $this->load->view('admin/sidebar'); ?>
<link rel="stylesheet" href="<?php echo base_url() ?>application/css/css/tab.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  <script src="https://code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script>
  var jqq=$.noConflict();
jqq(document).ready(function() {
    jqq( "#tabs" ).tabs();
  });
  </script>


   
	<div id="tabs">
  <ul>
    <li><a href="#tabs-1">File Upload</a></li>
    <li><a href="#tabs-2">Reuse file upload</a></li>
    
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
                     <p id="f1_upload_form" align="center"><br/>
                         <label>File:  
                              <input name="myfile" type="file" id="myfile" size="30" />
                         </label>
                         <label>
                             <input type="submit" name="submitBtn" class="sbtn" value="Upload" />
                         </label>
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
  </script>
    <?php
$dir = "files/category_logo/";

// Open a directory, and read its contents
if (is_dir($dir)){
  if ($dh = opendir($dir)){
    while (($file = readdir($dh)) !== false){ ?>
     
	<a href="#" onclick="myfunction()">
	<input type="hidden" name="re_im" id="re_im" value="<?php echo $file  ?>" />
	<img src="<?php echo base_url(); ?>files/category_logo/<?php echo $file;  ?>" height="80" width="70"/>
	</a>
    <?php
	}
    closedir($dh);
  }
}
?>
  </div>
  
</div>
 
	
	<?php $this->load->view('admin/footer'); ?>
			

	
 
 
