<?php
/*
**数据库操作类
*/
class Sql
{
	protected $_dbHandle;
    protected $_result;
	protected $filter;
	public $table;
	public function connect($host,$user,$pwd,$db)
	{
		$this->_dbHandle=mysqli_connect($host,$user,$pwd,$db);
		if(!$this->_dbHandle)die('connect mysql faild!');
		mysqli_query($this->_dbHandle,"set character set 'UTF-8'");
		mysqli_query($this->_dbHandle,"set names 'UTF8'");
	}
	public function close()
	{
		mysqli_close($this->_dbHandle);
	}
	 public function select($select = array())
    {
        if($select) {
            $this->filter='SELECT ';
            $this->filter.= implode(',', $select);
			 $this->filter.=' FROM '.$this->table;
        }

        return $this;
    }
	public function delete()
    {
        $this->filter='DELETE ';
	    $this->filter.=' FROM '.$this->table;
        return $this;
    }
    public function where($where = array(), $param = array())
    {
        if ($where) {
            $this->filter.=' WHERE ';
            $this->filter.= implode(' ', $where);

            $this->param=$param;
        }

        return $this;
    }
	 public function order($order = array())
    {
        if($order) {
            $this->filter.= ' ORDER BY ';
            $this->filter.= implode(',', $order);
        }

        return $this;
    }
	public function fetch_all()
	{
		$result_array=array();
		$result=mysqli_query($this->_dbHandle,$this->filter);
	    $this->filter;
		if(!$result)
		{
			$this->filter=0;
			return 0;
		}
		while($row=mysqli_fetch_array($result))
		{
			array_push($result_array,$row);
		}
		mysqli_free_result($result);
	    $this->filter=0;
		return isset($result_array[0])?$result_array:0;
	}
	public function fetch_row()
	{
		$result_array=array();
		//echo $this->filter;
		$result=mysqli_query($this->_dbHandle,$this->filter);
		if(!$result)
		{
			$this->filter=0;
			return 0;
		}
		while($row=mysqli_fetch_array($result))
		{
			array_push($result_array,$row);
		}
		mysqli_free_result($result);
	    $this->filter=0;
		return isset($result_array[0])?$result_array[0]:0;
	}
	public function performance()
	{
		$result=mysqli_query($this->_dbHandle,$this->filter);
		if($result)
		{
			return 1;
		}else{
			return 0;
		}
	}
	
	 public function add($data)
    {
        $sql = sprintf("insert into `%s` %s", $this->table, $this->formatInsert($data));
		//echo $sql;
		$result=mysqli_query($this->_dbHandle,$sql);
        if($result){
			return 1;
		}else
		{
			return 0;
		}
    }
    
	 public function updata($data,$id)
    {
        $sql = $this->formaUpdate($data).sprintf(" where ".$id);
		$result=mysqli_query($this->_dbHandle,$sql);
        if($result){
			return 1;
		}else
		{
			return 0;
		}
    }
   
	private function formatInsert($data)
    {
        $fields = array();
        $names = array();
        foreach ($data as $key => $value) {
            $fields[] = sprintf("`%s`", $key);
            $names[] = sprintf("'%s'", $value);
        }

        $field = implode(',', $fields);
        $name = implode(',', $names);

        return sprintf("(%s) values (%s)", $field, $name);
    }
    
	private function formaUpdate($data)
	{
        $fields = "UPDATE ".$this->table." SET";
		if(is_array($data)){
        foreach ($data as $key => $value) {
            $fields.= sprintf(" %s='%s',", $key,$value);
            
        }}
		else{
			$fields.=' '.$data.' ';
		}

        return substr($fields,0,-1);		
	}
	
}
