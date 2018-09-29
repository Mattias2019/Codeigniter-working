<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*

 *This MY_file_helper is used for File handling references.

 *

 * @access	public

 * @param	string

 * @return	string


 */

if (!defined('KB'))
{
	define('KB', 1024);
}
if (!defined('MB'))
{
	define('MB', 1024*1024);
}
if (!defined('GB'))
{
	define('GB', 1024*1024*1024);
}

if ( ! function_exists('delete_file'))

{

	function delete_file($path='',$files = array())

	{

		

		foreach($files as $file){

			

			if(file_exists($path.$file)){

				$thumb = get_thumb($file);

				if($thumb != ''){

					if(file_exists($path.$thumb))

						unlink($path.$thumb);

					unlink($path.$file);

				}

			}

		}

		

	}

}





if ( ! function_exists('get_thumb'))

{

	function get_thumb($filename = '')

	{

		$thumb = '';

		$img = explode(".",$filename);

		if(count($img) == 2)

		$thumb = $img[0]."_thumb.".$img[1];

		

		return $thumb;

	}

}



/*

	Function createthumb($name,$filename,$new_w,$new_h)

	creates a resized image

	variables:

	$name		Original filename

	$filename	Filename of the resized image

	$new_w		width of resized image

	$new_h		height of resized image

*/

function createthumb($name,$filename,$new_w,$new_h)

{

	$system=explode(".",$name);

	if (preg_match("/jpg|jpeg/",$system[1])){$src_img=imagecreatefromjpeg($name);}

	if (preg_match("/png/",$system[1])){$src_img=imagecreatefrompng($name);}
echo $src_img;
	$old_x=imageSX($src_img);

	$old_y=imageSY($src_img);

	if ($old_x > $old_y) 

	{

		$thumb_w=$new_w;

		$thumb_h=$old_y*($new_h/$old_x);

	}

	if ($old_x < $old_y) 

	{

		$thumb_w=$old_x*($new_w/$old_y);

		$thumb_h=$new_h;

	}

	if ($old_x == $old_y) 

	{

		$thumb_w=$new_w;

		$thumb_h=$new_h;

	}
   $thumb_w = round($thumb_w);
   $thumb_h = round($thumb_h);
	$dst_img=ImageCreateTrueColor($thumb_w,$thumb_h);
	
	//bool imagecopyresampled  ( resource $dst_image  , resource $src_image  , int $dst_x  , int $dst_y  , int $src_x  , int $src_y  , int $dst_w  , int $dst_h  , int $src_w  , int $src_h  )
	imagecopyresized($dst_img,$src_img,0,0,0,0,$thumb_w,$thumb_h,$new_w,$new_h); 

	if (preg_match("/png/",$system[1]))
	{

		imagepng($dst_img,$filename); 

	} else {

		imagejpeg($dst_img,$filename,"50"); 

	}

	imagedestroy($dst_img); 

	imagedestroy($src_img); 
	
		
	
}//End of createthumb function

/*

	Function createLogo($name,$filename,$new_w,$new_h)

	creates a resized image

	variables:

	$name		Original filename

	$filename	Filename of the resized image

	$new_w		width of resized image

	$new_h		height of resized image

*/

function createLogo($name,$filename,$new_w,$new_h)

{

	$system=explode(".",$name);

	if (preg_match("/jpg|jpeg/",$system[1])){$src_img=imagecreatefromjpeg($name);}

	if (preg_match("/png/",$system[1])){$src_img=imagecreatefrompng($name);}

	$old_x=imageSX($src_img);

	$old_y=imageSY($src_img);
	
	if ($old_x == $new_w) 

	{

		$thumb_w=$new_w;

		$thumb_h=$new_h;

	}

	if ($old_x > $new_w) 

	{

		$thumb_w=$new_w;

		$thumb_h=$new_h;

	}
	if ($old_x < $new_w) 

	{

		$thumb_w=$new_w;

		$thumb_h=$new_h;

	}
	
	$dst_img=ImageCreateTrueColor($thumb_w,$thumb_h);
	//echo $dst_img;exit;
	
	//bool imagecopyresampled  ( resource $dst_image  , resource $src_image  , int $dst_x  , int $dst_y  , int $src_x  , int $src_y  , int $dst_w  , int $dst_h  , int $src_w  , int $src_h  )
	imagecopyresampled($dst_img,$src_img,0,0,10,0,$thumb_w,$thumb_h,$new_w,$new_h); 

	if (preg_match("/png/",$system[1]))

	{

		imagepng($dst_img,$filename); 

	} else {

		imagejpeg($dst_img,$filename); 

	}

	imagedestroy($dst_img); 

	imagedestroy($src_img); 

}//End of createLogo function

 function SaveImage($im, $filename,$image_type,$save_to_file,$quality) {
 
    $res = null;
 
    // ImageGIF is not included into some GD2 releases, so it might not work
    // output png if gifs are not supported
    if(($image_type == 1)  && !function_exists('imagegif')) $image_type = 3;

    switch ($image_type) {
      case 1:
        if ($save_to_file) {
          $res = ImageGIF($im,$filename);
        }
        else {
          header("Content-type: image/gif");
          $res = ImageGIF($im);
        }
        break;
      case 2:
        if ($save_to_file) {
          $res = ImageJPEG($im,$filename,$quality);
        }
        else {
          header("Content-type: image/jpeg");
          $res = ImageJPEG($im, NULL, $quality);
        }
        break;
      case 3:
        if (PHP_VERSION >= '5.1.2') {
          // Convert to PNG quality.
          // PNG quality: 0 (best quality, bigger file) to 9 (worst quality, smaller file)
          $quality = 9 - min( round($quality / 10), 9 );
          if ($save_to_file) {
            $res = ImagePNG($im, $filename, $quality);
          }
          else {
            header("Content-type: image/png");
            $res = ImagePNG($im, NULL, $quality);
          }
        }
        else {
          if ($save_to_file) {
            $res = ImagePNG($im, $filename);
          }
          else {
            header("Content-type: image/png");
            $res = ImagePNG($im);
          }
        }
        break;
    }
 
    return $res;
 
  }
 
  function ImageCreateFromType($type,$filename) {
   $im = null;
   switch ($type) {
     case 1:
       $im = ImageCreateFromGif($filename);
       break;
     case 2:
       $im = ImageCreateFromJpeg($filename);
       break;
     case 3:
       $im = ImageCreateFromPNG($filename);
       break;
    }
    return $im;
  }
 
  // generate thumb from image and save it
  function GenerateThumbFile($from_name, $to_name,$n_wid,$n_hgt) {
  
	$max_x = $n_wid;
	$max_y = $n_hgt;
	$cut_x = 0;
	$cut_y = 0;
	$save_to_file = true;
    $image_type = -1;
    $quality = 100;
 
    // if src is URL then download file first
    $temp = false;
    if (substr($from_name,0,7) == 'http://') {
      $tmpfname = tempnam("tmp/", "TmP-");
      $temp = @fopen($tmpfname, "w");
      if ($temp) {
        @fwrite($temp, @file_get_contents($from_name)) or die("Cannot download image");
        @fclose($temp);
        $from_name = $tmpfname;
      }
      else {
        die("Cannot create temp file");
      }
    }

    // check if file exists
    if (!file_exists($from_name)) die("Source image does not exist!");
    
    // get source image size (width/height/type)
    // orig_img_type 1 = GIF, 2 = JPG, 3 = PNG
    list($orig_x, $orig_y, $orig_img_type, $img_sizes) = @GetImageSize($from_name);

    // cut image if specified by user
    if ($cut_x > 0) $orig_x = min($cut_x, $orig_x);
    if ($cut_y > 0) $orig_y = min($cut_y, $orig_y);
 
    // should we override thumb image type?
    $image_type = ($image_type != -1 ? $image_type : $orig_img_type);
 
    // check for allowed image types
    if ($orig_img_type < 1 or $orig_img_type > 3) die("Image type not supported");
 
    if ($orig_x > $max_x or $orig_y > $max_y) {
 
      // resize
      $per_x = $orig_x / $max_x;
      $per_y = $orig_y / $max_y;
      if ($per_y > $per_x) {
        $max_x = $orig_x / $per_y;
      }
      else {
        $max_y = $orig_y / $per_x;
      }
 
    }
    else {
      // keep original sizes, i.e. just copy
      if ($save_to_file) {
        @copy($from_name, $to_name);
      }
      else {
        switch ($image_type) {
          case 1:
              header("Content-type: image/gif");
              readfile($from_name);
            break;
          case 2:
              header("Content-type: image/jpeg");
              readfile($from_name);
            break;
          case 3:
              header("Content-type: image/png");
              readfile($from_name);
            break;
        }
      }
      return;
    }
 
    if ($image_type == 1) {
      // should use this function for gifs (gifs are palette images)
      $ni = imagecreate($max_x, $max_y);
    }
    else {
      // Create a new true color image
      $ni = ImageCreateTrueColor($max_x,$max_y);
    }
 
    // Fill image with white background (255,255,255)
    $white = imagecolorallocate($ni, 255, 255, 255);
    imagefilledrectangle( $ni, 0, 0, $max_x, $max_y, $white);
    // Create a new image from source file
    $im = ImageCreateFromType($orig_img_type,$from_name);
    // Copy the palette from one image to another
    imagepalettecopy($ni,$im);
    // Copy and resize part of an image with resampling
    imagecopyresampled(
      $ni, $im,             // destination, source
      0, 0, 0, 0,           // dstX, dstY, srcX, srcY
      $max_x, $max_y,       // dstW, dstH
      $orig_x, $orig_y);    // srcW, srcH
 
    // save thumb file
   SaveImage($ni, $to_name,$image_type,$save_to_file,$quality);

    if($temp) {
      unlink($tmpfname); // this removes the file
    }

  }

    function get_default_portfolio_thumbnail() {
        return '/application/css/images/noImageblue.png';
    }

/* End of file MY_file_helper.php */

/* Location: ./application/helpers/MY_file_helper.php */

?>