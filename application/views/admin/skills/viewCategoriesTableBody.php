<?php
if(isset($categories) and $categories->num_rows()>0)
{
    foreach($categories->result() as $category)
    {
        $attachment_url = $this->file_model->get_category_logo_file_path($category->id, $category->attachment_name);
        ?>
        <tr role="row">
            <td>
                <label class="mt-checkbox mt-checkbox-single mt-checkbox-outline">
                    <input type="checkbox" class="checkboxes" name="categoryList[]" id="categoryList[] value="<?php echo $category->id; ?>">
                    <span></span>
                </label>
            </td>
            <td>
                <?php echo $category->id; ?>
            </td>
            <td>
                <?php echo $category->category_name; ?>
            </td>
            <td>
                <?php echo $category->group_name; ?>
            </td>
            <td width="6%">
                <span class="label label-sm label-<?php if ($category->is_active==0){ ?>danger" > <?php } else { ?>success" ><?php } ?>
                    <?php if ($category->is_active==0){ echo "Disabled"; } else { echo "Active"; }?>
                </span>
            </td>
            <td>
                <img class="logo-image" src="<?php echo $attachment_url; ?>" <?php if ($category->attachment_name == '') echo 'hidden="hidden"'; ?>/>
            </td>
            <td>
                <?php echo date('Y-m-d',$category->created); ?>
            </td>

            <td>
                <div class="btn-group btn-group">
                    <a class="btn btn-sm green" title="Edit" href="<?php echo admin_url('skills/editCategory/'.$category->id)?>">
                        <i class="fa fa-edit"></i>
                    </a>
                    <a class="btn btn-sm red" title="Delete" href="<?php echo admin_url('skills/deleteCategory/'.$category->id)?>" onclick="return confirm('Are you sure want to delete??');">
                        <i class="fa fa-trash"></i>
                    </a>
                </div>
            </td>

        </tr>
        <?php
    }//Foreach End
}//If End
else
{
    echo '<tr><td colspan="5">'.t('No Category Found').'</td></tr>';
}
?>