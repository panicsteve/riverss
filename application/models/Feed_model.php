<?php
	
defined('BASEPATH') OR exit('No direct script access allowed');

class Feed_model extends CI_Model 
{
	public $id;
	public $title;
	public $url;
	
	public function __construct()
	{
		parent::__construct();
	}

    public function get($feed_id)
    {
        $query = $this->db->get_where('feeds', array('id' => $feed_id));
        return $query->result();
    }

    public function get_all()
    {
	    $this->db->order_by('title');
        $query = $this->db->get('feeds');
        return $query->result();
    }
}
