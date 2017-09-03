<?php	
	namespace App\Lib;
	use App\Lib\Qiniu\Auth;
	use App\Lib\Qiniu\Storage\UploadManager;
	use App\Lib\Qiniu\Processing\Operation;
	use App\Lib\Qiniu\config;
	/* lost functions  */
	
	class Qiniu_Factory 
	{
		private static $auth;
		private static $Operation;
		public static function getAuth()
		{
			if(empty($auth)){
				$auth = new Auth(env('QINIU_KEY'), env('QINIU_SECRET'));
			}
			return $auth;
		}

		public static function getUploaManager(){
			return new UploadManager();
		}

		public static function getOperation(){
			if (empty($Operation)) {
				$Operation = new Operation(env('APP_CDN') ,Qiniu_Factory::getAuth());
			}
			return $Operation;
		}

		public static function getZoneUrl(){
			return env('QINIU_UP');
		}

	}
?>


