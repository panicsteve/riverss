<?php
	
defined('BASEPATH') OR exit('No direct script access allowed');

class Tag_model extends CI_Model 
{
	public $id;
	public $title;
	
	public function __construct()
	{
		parent::__construct();
	}

    public function get_all()
    {
		$this->db->order_by('title');
        $query = $this->db->get('tags');
        return $query->result();
    }
    
	public function get_tags_for_feed_item($feed_item_id)
	{    			
		$this->db->join('tags', 'feed_item_tags.tag_id = tags.id');
		$this->db->order_by('title');
		
		$query = $this->db->get_where('feed_item_tags', array('feed_item_id' => $feed_item_id));
		
		return $query->result();
	}
	
	public function get_feed_items_for_tag($tag_id, $limit = 20, $offset = 0)
	{
		$sql = "SELECT 
				tags.id AS tag_id, 
				tags.title AS tag_title, 
				feed_item_tags.feed_item_id AS id,
				feed_items.title AS title,
				feed_items.date AS date,
				feed_items.permalink AS permalink,
				feeds.title AS feed_title,
				feeds.id AS feed_id
				FROM tags 
					JOIN feed_item_tags 
					JOIN feeds
					JOIN feed_items
				WHERE tags.id = ?
					AND feed_item_tags.tag_id = tags.id 
					AND feed_items.id = feed_item_tags.feed_item_id
					AND feeds.id = feed_items.feed_id
				ORDER BY 
					feed_items.date DESC
				LIMIT ?
				OFFSET ?";

		$query = $this->db->query($sql, array($tag_id, $limit, $offset));

		$feed_items = $query->result();
				
		foreach ( $feed_items as $feed_item )
		{	
			$feed_item->tags = $this->tag_model->get_tags_for_feed_item($feed_item->id);
		}
		
		return $feed_items;

	}
	
    public function insert($title)
    {
	    $sql = "INSERT INTO tags (title) VALUES (?) ON DUPLICATE KEY UPDATE id = LAST_INSERT_ID(id), title = VALUES(title)";

		$statement = $this->db->query($sql, array($title));
		
	    $id = $this->db->insert_id();
	    
	    return $id;
    }
    
   	public function search_tags_for_keyword($keyword, $limit = 20, $offset = 0)
   	{
	   	$keyword = "%$keyword%";
	   	
		$sql = "SELECT id, title FROM tags WHERE title LIKE ? ORDER BY title LIMIT ? OFFSET ?";

		$query = $this->db->query($sql, array($keyword, $limit, $offset));

		$feed_items = $query->result();
		
		foreach ( $feed_items as $feed_item )
		{				
			$feed_item->tags = $this->tag_model->get_tags_for_feed_item($feed_item->id);
		}
		
		return $feed_items;
   	}
}
