<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/*
 * Name   : Collection
 * Date	  : 20120107 
 * Author : Qesy 
 * QQ	  : 762264
 * Mail   : 762264@qq.com
 *
 *(̅_̅_̅(̲̅(̅_̅_̅_̅_̅_̅_̅_̅()ڪے 
 *
*/ 
class Db_pdo extends Db
{
	protected $p_table_name;
	private static $_instance = array();
	
	public function exec_select($cond_arr=array(), $field='*', $tb_name = 0,  $index = 0, $limit = '', $sort='', $fetch = 0){
		$tb_name = empty($tb_name) ? 0 : $tb_name;
		$limit_str = !is_array($limit) ? $limit : ' limit '.$limit[0].','.$limit[1].'';
		$sort_str = $this->sort($sort);
		$sql = "SELECT ".$field." FROM ".parent::$s_dbprefix[$this->p_dbname].$this->p_table_name[$tb_name].$this->get_sql_cond($cond_arr).$sort_str.$limit_str."";
		if($fetch == 1){
			return $this->q_select($sql, 1);
		}
		if(empty($index)){
			return $this->q_select($sql);
		}else{
			return $this->set_index($this->q_select($sql), $index);
		}
	}
	
	public function exec_insert($insert_arr = array(), $tb_name = 0){
		$tb_name = empty($tb_name) ? 0 : $tb_name;
		$value_str = parent::get_sql_insert($insert_arr);
		$sql = "INSERT INTO ".parent::$s_dbprefix[$this->p_dbname].$this->p_table_name[$tb_name].$value_str."";
		return $this->q_exec($sql);
	}
	
	public function exec_update($update_arr = array(), $cond_arr = array(), $tb_name = 0){
		$tb_name = empty($tb_name) ? 0 : $tb_name;
		$update_str = parent::get_sql_update($update_arr);
		$cond_str = parent::get_sql_cond($cond_arr);
		$sql = "UPDATE ".parent::$s_dbprefix[$this->p_dbname].$this->p_table_name[$tb_name]." SET ".$update_str.$cond_str."";
		return $this->q_exec($sql);
	}
	
	public function exec_del($cond_arr = array(), $tb_name = 0){
		$sql = "DELETE FROM ".parent::$s_dbprefix[$this->p_dbname].$this->p_table_name[$tb_name].parent::get_sql_cond($cond_arr)."";
		return $this->q_exec($sql);
	}
	
	/*public function __destruct(){
		parent::__destruct();
	}*/
}
?>