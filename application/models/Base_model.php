<?php

/**
 * Class base_model
 */
abstract class Base_model extends CI_Model
{
    /**
     * @var bool
     */
    public $is_new_record;

    /**
     * Return table name
     * @return string
     */
    abstract protected function table_name();

    /**
     * Return primary key(s)
     * @return array
     */
    abstract protected function primary_key();

    /**
     * Insert new record into database
     * @param $data
     * @return mixed
     */
    public function insert($data)
    {
        return $this->db->insert($this->table_name(), $data);
    }

    /**
     * Update record by primary key
     * @param $data
     * @param mixed $pk
     * @return bool
     */
    public function update($data, $pk)
    {
        if($pk){
            $this->db->where($this->pk_to_array($pk));
            return $this->db->update($this->table_name(), $data);
        }
        return false;
    }

    /**
     * Update all records
     * @param $data
     * @return mixed
     */
    public function update_all($data)
    {
        return $this->db->update($this->table_name(), $data);
    }

    /**
     * Delete record by primary key
     * @param mixed $pk
     * @return bool
     */
    public function delete_by_pk($pk)
    {
        if($pk){
            $this->db->where($this->pk_to_array($pk));
            return $this->db->delete($this->table_name());
        }
        return false;
    }
    /**
     * Deletes all data from table
     * @return mixed
     */
    public function delete_all()
    {
        return $this->db->empty_table($this->table_name());
    }

    /**
     * Find all records
     * @return mixed
     */
    public function find_all()
    {
        $query = $this->db->get($this->table_name());
        return $query->result_array();
    }

    /**
     * Find records by attributes
     * @param $attributes
     * @return array
     */
    public function find_all_by_attributes($attributes)
    {
        $query = $this->db->get_where($this->table_name(), $attributes);
        $data = $query->result_array();
        if (count($data)>0){
            return $data;
        }else {
            return array();
        }
    }

    /**
     * Find one record by primary key
     * @param mixed $pk string|array
     * @return null
     */
    public function find_by_pk($pk)
    {
        $query = $this->db->get_where($this->table_name(),$this->pk_to_array($pk),1);
        if(count($query->result_array()) >0){
            $this->is_new_record = FALSE;
            return $query->result_array()[0];
        }else {
            $this->is_new_record = TRUE;
            return null;
        }
    }

    /**
     * Find all records by passed ids
     * @param array $ids
     * @return null
     */
    public function find_by_ids(array $ids)
    {
        $this->db->where_in('id',$ids);
        $query = $this->db->get($this->table_name());
        if(count($query->result_array()) >0){
            return $query->result_array();
        }
        return null;
    }

    /**
     * Find one record by attributes
     * @param $attributes
     * @return null
     */
    public function find_one_by_attributes(array $attributes)
    {
        $query = $this->db->get_where($this->table_name(), $attributes);
        $data = $query->result_array();
        if (count($data)>0){
            $this->is_new_record = FALSE;
            return $data[0];
        }else {
            $this->is_new_record = TRUE;
            return null;
        }
    }

    /**
     * Return amount of all rows in the table
     * @return mixed
     */
    public function count_all()
    {
        return $this->db->count_all($this->table_name());
    }

    /**
     * @param $attributes
     * @return mixed
     */
    public function count_by_attributes($attributes)
    {
        $this->db->select('count(*) as count');
        $query = $this->db->get_where($this->get_table_name(),$attributes);
        $data = $query->result_array();
        return $data[0]['count'];
    }

    /**
     * @param $pk
     * @return array
     */
    public function pk_to_array($pk)
    {
        if(!is_array($pk)){
            $pk_tmp = array();
            foreach ($this->primary_key() as $name){
                $pk_tmp[$name] = $pk;
            }
            $pk = $pk_tmp;
        }
        return $pk;
    }
}