<?php

namespace App\Lib;
/*
 * Krpano100 插件主入口程序
 * ============================================================================
 * 技术支持：2015-2099 成都世纪川翔科技有限公司
 * 官网地址: http://www.krpano100.com
 * ----------------------------------------------------------------------------
 * $Author: wanghao 932625974#qq.com $
 * $Id: bind.php 28028 2016-06-19Z wanghao $
*/
class Plugin{

//获取插件目录下的所有配置  
//@param $type: 编辑页 edit, 显示页 view
//@param $refresh: 强制刷新session，重新读取数据
//@param $return: 是否返回，为ture则返回而不输出
public static function plugin_get_plugins($type)
{
    	$plugins = array();
    	//遍历plugin目录
    	$dir = public_path(). "\plugin\\" ;

    	if ($dh = opendir($dir))
    	{
    			while(($file = readdir($dh)) !== false)
    			{
    				if((is_dir($dir.$file)) && $file!="." && $file!="..")
    				{	
    					//存在功能模块，则加载该模块的配置文件
    					if (file_exists($dir.$file.'/config.php')) {
    						require_once($dir.$file.'/config.php');
    					}
    				}
    			}
    			closedir($dh);
    	}
	

    
    	foreach ($plugins as $k => $v) {			
    			$plugins[$k]['level_enable'] = 1;	//该用户组可用			
    			$key1[] = $plugins[$k]['level_enable'];
    			$key2[] = $v[$type.'_sort'];
    	}
    		//对模块进行前台排序
    		array_multisort($key1,SORT_NUMERIC,SORT_DESC,$key2,SORT_NUMERIC,SORT_ASC,$plugins);
    	
    	return $plugins;
 }
}
?>