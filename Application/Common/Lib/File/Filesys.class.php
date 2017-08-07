<?php
/**
 * 文件夹及文件管理
 */
namespace Common\Lib\File;
class Filesys {

	/**
	 * 循环创建相对于根目录的文件夹
	 * @param $dir_name
	 * @param int $mode
	 * @return bool
	 */
	public function mkDir($dir_name, $mode = 0755) {
		if (is_dir ( $dir_name ) || @mkdir ( $dir_name, $mode ))
			return true;
		if (! $this->mkDir ( dirname ( $dir_name ), $mode ))
			return false;
		return @mkdir ( $dir_name, $mode );
	}
	
	/**
	 * 上传预览图
	 */
	public function uploadThumb($path, $input_name = 'Filedata') {
		$return = null;
		$file = $_FILES[$input_name];
		$name = $file["name"];
		$ext = $this->getExt ( $name );
		$newname = $this->getNewFilename ( $this->getExt ( $name ) );
		move_uploaded_file ($file['tmp_name'], $path.'/'.$newname  );
		return str_replace ( './', '/', $path . '/' . $newname );
	}
	
	/**
	 * 获取文件夹名称
	 */
	public function getDirName($file_path){
		if(!$file_path){
			return null;
		}
		$path_info=pathinfo($file_path);
		return $path_info['dirname'];
	}
	
	/**
	 * 获取域名
	 */
	public function getDomain($file_path,$return_path=false){
		$file_path = str_replace('http://','',$file_path);
		if(!$file_path){
			return false;
		}
		$file_path = str_replace('\\','/',$file_path);
		$file_path = explode('/',$file_path);
		if(strpos($file_path[0],'.')>0){
			$domain=$file_path[0];
			unset($file_path[0]);
		}else{
			$domain=null;
		}
		if($return_path){
			$path=implode('/',$file_path);
			return array('domain'=>$domain,'path'=>$path);
		}
		return $domain;
	}
	

	/**
	 * 获取文件名称
	 * @param $file_path
	 * @return null
	 */
	public function getFileName($file_path) {
		if(!$file_path){
			return null;
		}
		$path_info=pathinfo($file_path);
		return $path_info['filename'];
	}

	/**
	 * 获取扩展名
	 * @param $file_name
	 * @return string
	 */
	public function getExt($file_name) {
		$ary = explode ( '.', $file_name );
		return strtolower ( end ( $ary ) );
	}
	

	/**
	 * 生成不 重复的文件名
	 * @param $ext
	 * @return string
	 */
	public function getNewFilename($ext) {
		$rand = Str::random ( 8 );
		return md5 ( microtime ( true ) . $rand ) . '.' . $ext;
	}
	
	/**
	 * 生成预览图
	 */
	public function makeThumb($file_path) {
		$ext = strtolower ( $this->getExt ( $file_path ) );
		if ($ext == 'ppt' || $ext == 'pptx') {
			$exe = realpath ( Config::get ( 'app.convert_ppt' ) );
			$ext = 'png';
		} elseif ($ext == 'dwg') {
			$exe = realpath ( Config::get ( 'app.convert_cad' ) );
			$ext = 'png';
		} elseif ($ext == 'pdf') {
			$exe = realpath ( Config::get ( 'app.convert_path' ) );
			$ext = 'jpg';
		} else {
			return false;
		}
		$thumb_name = $this->getThumbName ( $file_path, $ext );
		
		$file_path = realpath ( $file_path );
		$cmd = "$exe $file_path";
		if (exec ( $cmd ) != 1) {
			return false;
		}
		
		// 生成展示用缩略图
		$this->img2thumb ( $thumb_name ['big'], $thumb_name ['mid'], 0, 600 );
		$this->img2thumb ( $thumb_name ['mid'], $thumb_name ['midx'], 0, 300 );
		$this->img2thumb ( $thumb_name ['midx'], $thumb_name ['small'], 0, 150 );
		sleep ( 1 );
		$thumb_name ['big'] = str_replace ( './', '/', $thumb_name ['big'] );
		$thumb_name ['mid'] = str_replace ( './', '/', $thumb_name ['mid'] );
		$thumb_name ['midx'] = str_replace ( './', '/', $thumb_name ['midx'] );
		$thumb_name ['small'] = str_replace ( './', '/', $thumb_name ['small'] );
		return $thumb_name;
	}
	
	/**
	 * 生成图片的缩略图
	 */
	public function makePicThumb($file_path) {
		$ext = $this->getExt ( $file_path );
		$thumb_name = $this->getThumbName ( $file_path, $ext );
		// 生成展示用缩略图
		$this->img2thumb ( $thumb_name ['big'], $thumb_name ['mid'], 0, 600 );
		$this->img2thumb ( $thumb_name ['mid'], $thumb_name ['midx'], 0, 300 );
		$this->img2thumb ( $thumb_name ['midx'], $thumb_name ['small'], 0, 150 );
		return true;
	}
	
	/**
	 * 删除文件夹以及文件夹下所有文件
	 */
	public function delDir($dir) {
		// 先删除目录下的文件：
		if (! is_dir ( $dir )) {
			return false;
		}
		$dh = opendir ( $dir );
		while ( $file = readdir ( $dh ) ) {
			if ($file != "." && $file != "..") {
				$fullpath = $dir . "/" . $file;
				if (! is_dir ( $fullpath )) {
					unlink ( $fullpath );
				} else {
					$this->deldir ( $fullpath );
				}
			}
		}
		closedir ( $dh );
		// 删除当前文件夹：
		if (@rmdir ( $dir )) {
			return true;
		} else {
			return false;
		}
	}
	/**
	 * @Title: PictureResize 
	 * @Description: todo(等比缩放:图片尺寸过将进行等比缩放) 
	 * @param string $srcImage
	 * @param string $toFile
	 * @param string|int $maxWidth   允许范围内最大宽度
	 * @param string|int $maxHeight  允许范围内最大高度
	 * @param string|int $imgQuality 图片采样蜂窝颗粒度
	 * @return void|string|boolean  
	 * @
	 * @date 2015-11-6 下午5:03:11 
	 * @throws
	 */
	function pictureResize($srcImage,$toFile,$maxWidth = 400,$maxHeight = 400,$imgQuality=100 ){
		list($width, $height, $type, $attr) = getimagesize($srcImage);
		//如果不够放缩 那么直接返回原文件,仅仅进行重命名
		if($width <= $maxWidth || $height <= $maxHeight){
			return copy($srcImage, $toFile );
			//return rename($srcImage, $toFile);
		}
		$prefix = strtolower( pathinfo($srcImage, PATHINFO_EXTENSION) );
		//图形修正  这里图形处理有蹊跷  不规范图形命名直接返回
		if( $prefix === 'gif' && $type !==1 ){ return copy( $srcImage, $toFile );  }
		if( $prefix === 'jpg' && $type !==2 ){ return copy( $srcImage, $toFile );  }
		if( $prefix === 'png' && $type !==3 ){ return copy( $srcImage, $toFile );  }
		switch ($type) {
			case 1: $img = imagecreatefromgif($srcImage); break;
			case 2: $img = imagecreatefromjpeg($srcImage); break;
			case 3: $img = imagecreatefrompng($srcImage); break;
			default:
				return false;
		}
		$scale = min($maxWidth/$width, $maxHeight/$height); //求出绽放比例
		if($scale < 1) {
			$newWidth = floor($scale*$width);
			$newHeight = floor($scale*$height);
			$newImg = imagecreatetruecolor($newWidth, $newHeight);
			imagecopyresampled($newImg, $img, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
			//$newName = $maxWidth.'x'.$maxHeight;
			$newName = "";
			$toFile = preg_replace("/(.gif|.jpg|.jpeg|.png)/i","",$toFile);
			switch($type) {
				case 1: if(imagegif($newImg, "$toFile$newName.gif", $imgQuality))
					return "$newName.gif"; break;
					case 2: if(imagejpeg($newImg, "$toFile$newName.jpg", $imgQuality))
						return "$newName.jpg"; break;
						case 3: if(imagepng($newImg, "$toFile$newName.png", $imgQuality))
							return "$newName.png"; break;
						default: if(imagejpeg($newImg, "$toFile$newName.jpg", $imgQuality))
							return "$newName.jpg"; break;
			}
			imagedestroy($newImg);
		}
		imagedestroy($img);
		return true;
	}

	/**
	 * 生成缩略图
	 * @param string     $src_img    源图绝对完整地址{带文件名及后缀名}
	 * @param string     $dst_img    目标图绝对完整地址{带文件名及后缀名}
	 * @param int        $width      缩略图宽{0:此时目标高度不能为0，目标宽度为源图宽*(目标高度/源图高)}
	 * @param int        $height     缩略图高{0:此时目标宽度不能为0，目标高度为源图高*(目标宽度/源图宽)}
	 * @param int        $cut        是否裁切{宽,高必须非0}
	 * @param int/float  $proportion 缩放{0:不缩放, 0<this<1:缩放到相应比例(此时宽高限制和裁切均失效)}
	 * @return bool
	 */
	function img2thumb($src_img, $dst_img, $width = 75, $height = 75, $cut = 0, $proportion = 0) {
		if (! is_file ( $src_img )) {
			return false;
		}
		$ot = $this->getExt ( $dst_img );
		$otfunc = 'image' . ($ot == 'jpg' ? 'jpeg' : $ot);
		$srcinfo = getimagesize ( $src_img );
		$src_w = $srcinfo [0];
		$src_h = $srcinfo [1];
		$type = strtolower ( substr ( image_type_to_extension ( $srcinfo [2] ), 1 ) );
		//下面两行修复报错直接导致无法的问题 yuansl 2015 11 03 17:48
		$type = str_replace(' ', '', $type);
		if( !$type ){ return false;}
		$createfun = 'imagecreatefrom' . ($type == 'jpg' ? 'jpeg' : $type);
		$dst_h = $height;
		$dst_w = $width;
		$x = $y = 0;
		
		/**
		 * 缩略图不超过源图尺寸（前提是宽或高只有一个）
		 */
		if (($width > $src_w && $height > $src_h) || ($height > $src_h && $width == 0) || ($width > $src_w && $height == 0)) {
			$proportion = 1;
		}
		if ($width > $src_w) {
			$dst_w = $width = $src_w;
		}
		if ($height > $src_h) {
			$dst_h = $height = $src_h;
		}
		
		if (! $width && ! $height && ! $proportion) {
			return false;
		}
		if (! $proportion) {
			if ($cut == 0) {
				if ($dst_w && $dst_h) {
					if ($dst_w / $src_w > $dst_h / $src_h) {
						$dst_w = $src_w * ($dst_h / $src_h);
						$x = 0 - ($dst_w - $width) / 2;
					} else {
						$dst_h = $src_h * ($dst_w / $src_w);
						$y = 0 - ($dst_h - $height) / 2;
					}
				} else if ($dst_w xor $dst_h) {
					if ($dst_w && ! $dst_h) 					// 有宽无高
					{
						$propor = $dst_w / $src_w;
						$height = $dst_h = $src_h * $propor;
					} else if (! $dst_w && $dst_h) 					// 有高无宽
					{
						$propor = $dst_h / $src_h;
						$width = $dst_w = $src_w * $propor;
					}
				}
			} else {
				if (! $dst_h) 				// 裁剪时无高
				{
					$height = $dst_h = $dst_w;
				}
				if (! $dst_w) 				// 裁剪时无宽
				{
					$width = $dst_w = $dst_h;
				}
				$propor = min ( max ( $dst_w / $src_w, $dst_h / $src_h ), 1 );
				$dst_w = ( int ) round ( $src_w * $propor );
				$dst_h = ( int ) round ( $src_h * $propor );
				$x = ($width - $dst_w) / 2;
				$y = ($height - $dst_h) / 2;
			}
		} else {
			$proportion = min ( $proportion, 1 );
			$height = $dst_h = $src_h * $proportion;
			$width = $dst_w = $src_w * $proportion;
		}
		$src = $createfun ( $src_img );
		$dst = imagecreatetruecolor ( $width ? $width : $dst_w, $height ? $height : $dst_h );
		$white = imagecolorallocate ( $dst, 255, 255, 255 );
		imagefill ( $dst, 0, 0, $white );
		
		if (function_exists ( 'imagecopyresampled' )) {
			imagecopyresampled ( $dst, $src, $x, $y, 0, 0, $dst_w, $dst_h, $src_w, $src_h );
		} else {
			imagecopyresized ( $dst, $src, $x, $y, 0, 0, $dst_w, $dst_h, $src_w, $src_h );
		}
		$otfunc ( $dst, $dst_img );
		imagedestroy ( $dst );
		imagedestroy ( $src );
		return true;
	}

	/**
	 * 扫描文件夹
	 */
	public function scanning($dir, $exists = null)
	{
		$files = glob ( $dir . '/*.*' );
		if ($exists) {
			$files = array_diff ( $files, $exists );
		}
		
		return $files;
	}
	
	/**
	 * 移动文件夹
	 */
	public function moveDir($source, $target)
	{
		return is_file ( $source ) || is_dir ( $source ) ? @rename ( $source, $target ) : false;
	}
	
	public function copyFile($source, $target)
	{
		return is_file ( $source ) || is_dir ( $source ) ? @copy ( $source, $target ) : false;
	}
	
	/**
	 * 修改一个图片 让其翻转指定度数
	 * @param string $filename
	 *        	文件名（包括文件路径）
	 * @param float $degrees
	 *        	旋转度数
	 * @return boolean
	 */
	public function flip($filename, $degrees = 90) {
		// 读取图片
		$data = @getimagesize ( $filename );
		if ($data == false)
			return false;
			// 读取旧图片
		switch ($data [2]) {
			case 1 :
				$src_f = imagecreatefromgif ( $filename );
				break;
			case 2 :
				$src_f = imagecreatefromjpeg ( $filename );
				break;
			case 3 :
				$src_f = imagecreatefrompng ( $filename );
				break;
			default:
				$src_f = '';break;
		}
		if ($src_f == "")
			return false;
		$rotate = @imagerotate ( $src_f, $degrees, 0 );
		if (! imagejpeg ( $rotate, $filename, 100 ))
			return false;
		@imagedestroy ( $rotate );
		return true;
	}

}