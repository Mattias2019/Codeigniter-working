<div class="colored" >
 <div class="col-md-12"></div>
    <div class="col-md-12">
            <div class="col-md-12  contcustom" id="contentdiv" >
                <form method="POST" id="profile-frm" enctype="multipart/form-data">
                    <h4>Edit Profile</h4>
                    <div class="message"></div>

                    <?php if($this->session->flashdata('success')){?>
                        <div style="font-size:12px; margin-top:10px;" class="alert alert-success alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                         <?php echo $this->session->flashdata('success'); ?> </div>
                    <?php } ?>
                    <div class="form-group">
                        <input type="text" name="username" readonly class="form-control" value="<?php echo $user->username; ?>" required="required"/>
                    </div>
                    <div class="form-group">
                        <input type="text" name="firstname" class="form-control" value="<?php echo $user->firstname; ?>" required="required"/>
                    </div>
                    <div class="form-group">
                        <input type="text" name="lastname" class="form-control" value="<?php echo $user->lastname; ?>" required="required"/>
                    </div>
                    <div class="form-group">
                        <input type="text" name="email" id="email" class="form-control" value="<?php echo $user->email; ?>" required="required"/>
                    </div>
                    <div class="form-group">
                        <label>Avatar</label><br>
                        <?php $avatar = $user->avatar != '' ? $user->avatar : 'no-image.jpg' ; ?>
                        <img src="assets/images/thumbs/<?php echo $avatar; ?>" class="thumbnail" alt="Thumbnail Image">
                        (max width & height 500)
                        <input id="uploadFile" style="width:110px" placeholder="Choose File" disabled="disabled" />
                        <div class="fileUpload btn btn-sm btn-primary">
                            <span>Upload</span>
                            <input id="uploadBtn" name="avatar" type="file" class="upload" />
                        </div>
                    </div>
                    
                    <button class="btn btn-block btn-default btn-success" id="update-profile" type="submit"><i class="fa fa-save"></i> Update Profile</button>
                    <br>
                </form>
                <button class="btn btn-block btn-default btn-primary goback"> <i class="fa fa-arrow-circle-left"></i> Back to Chat</button>
            </div>
    </div>
</div>

<style type="text/css">
.fileUpload {
    position: relative;
    overflow: hidden;
    margin: 10px;
}
.fileUpload input.upload {
    position: absolute;
    top: 0;
    right: 0;
    margin: 0;
    padding: 0;
    font-size: 20px;
    cursor: pointer;
    opacity: 0;
    filter: alpha(opacity=0);
}
</style>
<script type="text/javascript">
document.getElementById("uploadBtn").onchange = function () {
    document.getElementById("uploadFile").value = this.value;
};
</script>