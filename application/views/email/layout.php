<head></head>
<body style="background-color: #E4E4E4;padding: 20px; margin: 0; min-width: 640px;">
<table border="0" cellspacing="0" width="530" style="color:#262626;background-color:#fff;
		padding:27px 30px 20px 30px;margin:auto; border:1px solid #e1e1e1;">
    <tbody>
    <!-- header -->
    <tr style="background-color:#333333;">
        <td style="padding-left:20px;padding-top:5px;padding-bottom:5px">
            <a target="_blank" style="text-decoration:none;color:inherit;font-family:'HelveticaNeue','Helvetica Neue',Helvetica,Arial,sans-serif;font-weight:normal;">
                <img src="<?php echo image_url('logo.png');?>">
            </a>
        </td>
    </tr>
    </tbody>

    <tbody>
    <tr>
        <td style="padding:40px 0  0 0;">
            <p style="color:#000;line-height:24px;font-family:'HelveticaNeue','Helvetica Neue',Helvetica,Arial,sans-serif;font-weight:normal;">
                <h2 style="font-size: 16px;font-family:'HelveticaNeue','Helvetica Neue',Helvetica,Arial,sans-serif;">
                    <?php echo $email_subject ?>
                </h2>
                <p style="font-size: 13px;line-height:24px;font-family:'HelveticaNeue','Helvetica Neue',Helvetica,Arial,sans-serif;">
                    <?php echo $email_body ?>
                </p>
                <p style="font-size: 14px; font-family:'HelveticaNeue','Helvetica Neue',Helvetica,Arial,sans-serif;">Thanks, have a lovely day.</p>
            </p>

        </td>
    </tr>
    </tbody>


    <tbody>
    <tr>
        <td align="right" style="padding:25px 0  0 0;">
            <table border="0" cellspacing="0" cellpadding="0" style="padding-bottom:9px;" align="right">
                <tbody>
                <tr style="border-bottom:1px solid #999999;">
                    <td width="24" style="padding:0 7px 0 0;">
                        <a href="<?php base_url() ?>" style="border-width:0;">
                            <img src="<?php echo image_url('f_fb.jpg');?>" width="24" height="24" alt="Facebook Image">
                        </a>
                    </td>
                    <td width="24">
                        <a href="<?php base_url() ?>" style="border-width:0;">
                            <img src="<?php echo image_url('f_twt.jpg');?>" width="24" height="24" alt="Twitter Image">
                        </a>
                    </td>
                </tr>
                <tr style="padding-top:15px">
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    </tbody>

</table>

</body>
