<?php

use Intervention\Image\ImageManager as Image;

/**
 *
 * @author Jaikora <kora.jayaram@gmail.com>
 *  this is an wrapper for intervention package moulded for Codeigniter usage
 */
class Imageinter_Exception extends Exception
{
}

class Imageinter
{
	var $intervention;
	var $url;
	var $final_image;
	var $cache;

	public $maxWidth  = 60;
	public $maxHeight = 60;

	public function __construct()
	{
		if (!phpversion() > 5.4) {
			throw new Imageinter_Exception('PHP version should be grater than 5.4');
		}
		$this->ci           =& get_instance();
		$this->intervention = new Image();
	}

	/**
	 * Resize image within a frame without loosing ratio
	 *
	 * @param string $image_path: Path of the image
	 * @param string $size_name: Size name (eg.: mini, small, medium)
	 * @param int $maxWidth: Frame max width
	 * @param ing $maxHeight: Frame max height
	 * @return string: Path of the new image
	 */
	public function contain($image_path, $size_name, $maxWidth = 138, $maxHeight = 138){
		$this->maxWidth  = $maxWidth;
		$this->maxHeight = $maxHeight;
		list($width, $height, $type, $attr) = getimagesize($image_path);
		
		$ratio     = min($this->maxHeight / $height, $this->maxWidth / $width); 
		$newHeight = ceil($height * $ratio); 
		$newWidth  = ceil($width * $ratio); 

		$image = $this->intervention->make($image_path) ;
		$image->interlace();
		$image->resize($newWidth, $newHeight);

		$new_image_path = str_replace("-source", "-".$size_name, $image_path);
		$image->save($new_image_path, 80);

		return $new_image_path;
	}

	public function thumbnail($image_path, $size_name, $maxWidth = 370, $maxHeight = 370)
	{
		// open file a image resource
		$img = $this->intervention->make($image_path);
		$img->interlace();
		
		if($img->height()>$maxHeight){

			// method 1
			// add callback functionality to retain maximal original image size
			$img->fit($maxWidth, $maxHeight, function ($constraint) {
			    $constraint->upsize();
			});
		
		}else{
			// method 2
		    // resize image to 370x370 and keep the aspect ratio
			$img->resize($maxWidth, $maxHeight, function ($constraint) {
				$constraint->aspectRatio();
			});
			
			// Fill up the blank spaces with transparent color
			$img->resizeCanvas($maxWidth, $maxHeight, 'center', false, array(255, 255, 255, 0));
		}
		
		$new_image_path = str_replace("-source", "-$size_name", $image_path);
		$img->save($new_image_path, 80);
		
		return $new_image_path;
	}
	
	/**
	 * Resize image within a frame without loosing ratio: max is taken
	 *
	 * @param string $image_path: Path of the image
	 * @param string $size_name: Size name (eg.: mini, small, medium)
	 * @param int $maxWidth: Frame max width
	 * @param ing $maxHeight: Frame max height
	 * @return string: Path of the new image
	 */
	public function containMax($image_path, $size_name, $maxWidth = 360, $maxHeight = 240){
		$this->maxWidth  = $maxWidth;
		$this->maxHeight = $maxHeight;
		list($width, $height, $type, $attr) = getimagesize($image_path);
		
		$ratio     = max($this->maxHeight / $height, $this->maxWidth / $width); 
		$newHeight = ceil($height * $ratio); 
		$newWidth  = ceil($width * $ratio); 

		$image = $this->intervention->make($image_path);
		$image->interlace();
		$image->resize($newWidth, $newHeight);

		$new_image_path = str_replace("-source", "-".$size_name, $image_path);
		$image->save($new_image_path, 80);

		return $new_image_path;
	}

	public function getResizeWidthHeight($image_path, $maxWidth, $maxHeight){
		list($width, $height, $type, $attr) = getimagesize($image_path);
		
		$ratio     = max($maxHeight / $height, $maxWidth / $width); 
		$newHeight = ceil($height * $ratio); 
		$newWidth  = ceil($width * $ratio);

		return array("width"=>$newWidth, "height"=>$newHeight);
	}

	public function resizeByHeight($image_path, $size_name, $maxwidth = 'auto', $maxheight){
		list($width, $height, $type, $attr) = getimagesize($image_path);
		
		$ratio     = $width / $height; 
		$newWidth  = ceil($maxheight * $ratio);

		$image = $this->intervention->make($image_path);
		$image->interlace();
		$image->resize($newWidth, $maxheight);

		$new_image_path = str_replace("-source", "-".$size_name, $image_path);
		$image->save($new_image_path, 80);

		return $new_image_path;
	}
	
	public function resizeByWidth($image_path, $size_name, $maxwidth, $maxHeight = 'auto'){
		list($width, $height, $type, $attr) = getimagesize($image_path);
		
		$ratio     = $width / $height; 
		$newHeight  = ceil($maxwidth / $ratio);

		$image = $this->intervention->make($image_path);
		$image->interlace();
		$image->resize($maxwidth, $newHeight);

		$new_image_path = str_replace("-source", "-".$size_name, $image_path);
		$image->save($new_image_path, 80);

		return $new_image_path;
	}

	/**
	 * Get image scr 
	 *
	 * @param string $filename: Filename
	 * @param string $size_name: Size name (eg.: mini, small, medium)
	 * @param string $module: Module name (ex: slides, nearby, ...)
	 * @return string: Image scr
	 */
	public function getImageUrl($filename, $size_name, $module){
		
		$image_path = UPLOAD_PATH . 'images/'.$module.'/'.$filename;
		if(file_exists($image_path) && is_file($image_path)){
			$filename = str_replace("-source", "-".$size_name, $filename);
			$new_image_url = UPLOAD_URL . 'images/'.$module.'/'.$filename;
			return $new_image_url;
		}else{
			return false;
		}
	}
	
	public function getUrlandPathImage($path, $filename, $size_name = "source") {

        $url  = UPLOAD_URL . 'images/' . $path . '/' . $filename;
        $path = UPLOAD_PATH . 'images/' . $path . '/' . $filename;

        if($size_name!="source"){
        	$url  = str_replace("-source", "-$size_name", $url);
        	$path = str_replace("-source", "-$size_name", $path);
        }

        if(file_exists($path) && is_file($path)){
        	return array('url' => $url, 'path' => $path);
        }else{
        	return false;
        }
    }
}