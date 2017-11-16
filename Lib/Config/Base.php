<?php
defined ( 'SYS_PATH' ) || exit ( 'No direct script access allowed' );
/*
 * Name : Collection
 * Date : 20120107
 * Author : Qesy
 * QQ : 762264
 * Mail : 762264@qq.com
 *
 * (̅_̅_̅(̲̅(̅_̅_̅_̅_̅_̅_̅_̅()ڪے
 *
 */
abstract class Base {
	public $pageNum = 20;
	public $temp_arr = array ();
	public $cookieObj;
	function __construct() {
		$this->cookieObj = Helper\Cookie::get_instance();
	}
	public function createSn() { // -- Name : 生成编号 --
		return WEB_PREFIX . '-' . uniqid ( rand ( 100, 999 ), false );
	}
	public function loadView($temp, $data = array()) { // -- Name : 加载模版 --
		if (! is_file ( SYS_PATH . 'view/' . $temp . EXTEND ))
			die ( SYS_PATH . 'view/' . $temp . EXTEND . ' not found !' );
		$this->temp_arr = empty ( $data ) ? $this->temp_arr : $data;
		foreach ( $this->temp_arr as $key => $val ) {
			$$key = $val;
		}
		require SYS_PATH . 'view/' . $temp . EXTEND;
	}
	public function loadCss(array $cssArr) { // -- Name : 加载CSS --
		foreach ( $cssArr as $key => $val ) {
			echo '<link href="' . CSS_PATH . $val . '.css?v=' . VERSION . '" rel="stylesheet" type="text/css" />';
		}
	}
	public function loadScripts(array $jsArr) { // -- Name : 加载JS --
		foreach ( $jsArr as $key => $val ) {
			echo '<script type="text/javascript" src="' . JS_PATH . $val . '.js?v=' . VERSION . '" charset="utf-8"></script>';
		}
	}
	public function page_bar($count, $size, $url = '', $num = 9, $pageNum = 1) { // -- 分页 --
		if ($count <= 0) {
			return;
		}
		$toall = ceil ( $count / $size );
		($pageNum <= $toall) || $pageNum = $toall;
		$pre = ($pageNum <= 1) ? '<li><a href="' . str_replace ( '{page}', 1, $url ) . '">上一页</a></li>' : '<li><a href="' . str_replace ( '{page}', $pageNum - 1, $url ) . '">上一页</a></li>';
		$next = ($pageNum >= $toall) ? '<li><a href="' . str_replace ( '{page}', $toall, $url ) . '">下一页</a></li>' : '<li><a href="' . str_replace ( '{page}', $pageNum + 1, $url ) . '">下一页</a></li>';
		$start = $end = 1;
		$toallStr = $str = '';
		if ($toall <= $num) {
			$start = 1;
			$end = $toall;
		} elseif (($toall - $pageNum) > ceil ( $num / 2 ) && $pageNum < ceil ( $num / 2 )) {
			$start = 1;
			$end = $num;
		} elseif (($toall - $pageNum) < ceil ( $num / 2 )) {
			$start = ($toall - $num + 1);
			$end = $toall;
		} else {
			$start = ($pageNum - floor ( $num / 2 ));
			$end = ($pageNum + floor ( $num / 2 ));
		}
		for($i = $start; $i <= $end; $i ++) {
			$str = ($pageNum == $i) ? '<li class="active"><a>' . $i . '</a></li>' : '<li><a href="' . str_replace ( '{page}', $i, $url ) . '">' . $i . '</a></li>';
		}
		return '<ul class="pagination">' . $pre . $str . $next . $toallStr . '</ul>';
	}
	public static function insert_func_array(array $controllerArr) { // -- Name : 回调函数 --
		$fun_arr = isset ( $controllerArr ['funArr'] ) ? $controllerArr ['funArr'] : array ();
		$clss = new $controllerArr ['name'] ();
		call_user_func_array ( array (
				& $clss,
				$controllerArr ['method'] . '_Action' 
		), $fun_arr );
	}
}
?>