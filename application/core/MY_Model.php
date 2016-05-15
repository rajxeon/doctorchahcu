<?php 
class MY_Model extends CI_Model{
	
	
	protected $_table_name		='';
	protected $_primary_key		='id';
	protected $_primary_filter	='intval';
	protected $_order_by		='';
	public    $_rules			=array();
	protected $_timestamps		=FALSE;
	
	
	
	
	
	public function __construct(){
	 	parent::__construct();		
		}
	
	
	
      public function array_from_data($fields){
		$data=array();
		foreach($fields as $fields){
			$data[$fields]=$this->input->post($fields);
			}
		return $data;
		}
	
	public function get($id=NULL,$single=FALSE){
		
		if($id!=NULL){
			//Return a single row
			$filter=$this->_primary_filter;
			$id=$filter($id);
			$this->db->where($this->_primary_key,$id);
			$method='row';
			}
		elseif($single==TRUE){
			$method='row';
			}
		
		else{
			//Return all the rows
			$method='result';
			}
		
		
		return $this->db->get($this->_table_name)->$method();
		
		}
	public function get_by($where,$single=FALSE){
		$this->db->where($where);
		return $this->get(NULL,$single);
		}
	public function query($query,$single=FALSE){
		return $this->db->query($query)->result();
		}
		
		
	public function save($data,$id=NULL){
		//If id is not null then there will be an insert otherwise there will be a update
		if($this->_timestamps==TRUE){
			$now=date('Y-m-d H:i:s');
			$id || $data['created']	=$now;
			$data['modified']		=$now;
			}
		
		//Insert
		if($id===NULL){	
			!isset($data[$this->_primary_key]) || $data[$this->_primary_key]=NULL;
			
			$this->db->set($data);
			$this->db->insert($this->_table_name);
			$id= $this->db->insert_id();
			}
		//Update
		else {
			$filter	=$this->_primary_filter;
			$id		=$filter($id);
			$this->db->set($data);
			$this->db->where($this->_primary_key,$id);
			$this->db->update($this->_table_name);
			
			}
		return $id;
		
		
		}
	public function delete($id){
		$filter=$this->_primary_filter;
		$id=$filter($id);
		if(!$id){return;}
		
		else{
			$this->db->where($this->_primary_key,$id);
			$this->db->limit(1);
			echo $this->db->delete($this->_table_name);
			}
		}
	
	
	}
?>