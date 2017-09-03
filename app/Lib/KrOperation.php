<?php
namespace App\Lib;
use App\Lib\Common;
use App\Lib\Qiniu;
abstract class KrOperation{

	abstract protected function downloadFile($origin_url , $dest_file);
	abstract protected function uploadFile($local_file , $origin_file);
	abstract protected function video_thumb($location,$time);
	/*
	 * $imgs 图片在存储服务器的路径
	 * $temp_dir 图片下载到本地的临时路径
	 * $kr_path  KRPANO 的路径
	 * $origin_dir 	切图完成后，存储图片的目录
	 * $cdn_host 云存储服务器域名
		notice : 目录必须带最后一个 /

	 * return $imgsmain  包含场景数组
	*/
	public static function slice($imgs,$origin_dir){
		//创建临时目录 
		$temp_dir = storage_path()."/pics/".date('Ymd',Common::gmtime()).Common::get_rand_number()."/";
		Common::make_dir($temp_dir);
		$kr=null;						
		$kr = new qiniu();
		$cdn_host = env('APP_CDN');				
		return $kr==null?null:$kr->slicing($imgs,$temp_dir,$cdn_host,$origin_dir);
	}
	


	private function slicing($imgs,$temp_dir,$cdn_host,$origin_dir){
		// $mime_type = finfo_open(FILEINFO_MIME_TYPE);
		$path="";
		$scenes = array();
		$imgsmain = array();
		foreach ($imgs as $img) {
			$obj = $img['imgsrc'];
			$view_uuid=Common::guid(16);
			$rpos = strrpos($obj,"/");
			//计算云存储上的原始文件名，为下次升级素材管理时，针对单张全景图生成预览
			$temp_name = substr($obj, $rpos==0?$rpos:$rpos+1);
			$file = $this->downloadFile($obj,$temp_dir.$temp_name);
			if($file!=null){
				$info = getimagesize($file);
				if(($info['0']/$info['1']==2)&&( (strpos("image/jpeg",$info['mime'])===0)||(strpos("image/tif", $info['mime'])===0))){					
					$filename = $img['imgname'];
					if (strpos($filename, ".jpg")) {
						$filename = substr($filename , 0 , strrpos($filename , "."));
					}
					if (mb_strlen($filename)) {
						$filename = substr($filename, 0,100);
					}
					//生成最终文件，合并生成整个项目全景图
					$final_name = $temp_dir.$view_uuid.substr($obj,strrpos($obj,"."));
					rename($temp_dir.$temp_name, $final_name );
					$path=$path.$final_name." ";
					$source = array(
						'filename' =>$filename, 
						'location'  =>$obj,
						'thumb_path'=>$origin_dir.$view_uuid."/thumb.jpg",
					    'img_dir' => $origin_dir.$view_uuid."/mobile/",
						'view_uuid' =>$view_uuid
						);
					$imgsmain[] = $source;
				}
			}
		}
		if ($path!="") {
		    if(function_exists('exec')){
		        if(strtoupper(substr(PHP_OS,0,3))=='WIN')
		        {
		            exec(storage_path()."/krpano/make.bat"." ".$path."");
		        }
		        else
		        {
		            exec(storage_path()."/krpano_linux/krpanotools register ruza4tk2X4MdHuE7djJQGr9QTftMFHiSH2ac5jkIlFgGqG0K0IVQnh5vF/cicLpwedsURI0QTg+UluEgysRLUytpeVFyBTxdwREEIGquRh1Hp2BY2EtZ8kdO2r6CHLJAFlzY5w6au1rnHwRhJXgaK8J75RwK1DYb/OEZ4tD2pniUrnMrpFwGWwcKnxGyNSmMktsU6qadFjKbMH3HUKNXa7Y59lEzbDZJbsTuP+UynwwBhogv8K+byjs2LDvU48sx4/CNHWi26g==");
		            exec(storage_path()."/krpano_linux/make.sh"." ".$path."");
		        }
		         
		        	
		        //上传切好图的整个目录到服务器
		        $dir = $temp_dir."vtour/panos/";
		        $this ->upload($dir,$origin_dir);
		    }
		}
		return  $imgsmain;
	
	}
	
	private function upload($dir,$origin_file){
		if(is_dir($dir))
		{
			if ($dh = opendir($dir)) 
			{
				while (($file = readdir($dh)) !== false)
				{
					if((is_dir($dir.$file)) && $file!="." && $file!="..")
					{	
	
						//目录
						$this->upload($dir.$file."/",$origin_file.$file."/");
					}
					else
					{
						if($file!="." && $file!="..")
						{	
							//上传文件
							$this->uploadFile($dir.$file ,$origin_file.$file);
						}
					}
				}
				closedir($dh);
			}
		}
	}

}

?>