<?php
	
defined('BASEPATH') OR exit('No direct script access allowed');

class FeedItem_model extends CI_Model 
{
	public $id;
	public $feed_id;
	public $title;
	public $date;
	public $permalink;
	public $hash;
	
	public function __construct()
	{
		parent::__construct();
	}

	public function attach_tag_to_feed_item($tag_id, $feed_item_id)
	{
		$sql = "INSERT INTO feed_item_tags (feed_item_id, tag_id) VALUES (?, ?) ON DUPLICATE KEY UPDATE tag_id = tag_id";
			
		$this->db->query($sql, array($feed_item_id, $tag_id));
	}
	
	public function search_feed_items_for_keyword($keyword, $limit = 20, $offset = 0)
	{
		$this->load->model('tag_model');

		$keyword = "%$keyword%";

		$sql = "SELECT feeds.id AS feed_id, feeds.title AS feed_title, feed_items.date AS date, feed_items.permalink AS permalink, feed_items.title AS title, feed_items.id AS id FROM feed_items JOIN feeds WHERE feed_items.title LIKE ? AND feeds.id = feed_items.feed_id ORDER BY feed_items.date DESC LIMIT ? OFFSET ?";

		$query = $this->db->query($sql, array($keyword, $limit, $offset));

		$feed_items = $query->result();
		
		foreach ( $feed_items as $feed_item )
		{				
			$feed_item->tags = $this->tag_model->get_tags_for_feed_item($feed_item->id);
		}
		
		return $feed_items;
	}

    public function get_recent_items_from_all_feeds($limit = 20, $offset = 0)
    {
		$this->load->model('tag_model');

		$sql = "SELECT feeds.id AS feed_id, feed_items.date AS date, feed_items.permalink AS permalink, feeds.title AS feed_title, feed_items.title AS title, feed_items.id AS id FROM feed_items JOIN feeds WHERE feeds.id = feed_items.feed_id ORDER BY feed_items.date DESC LIMIT ? OFFSET ?";

		$query = $this->db->query($sql, array($limit, $offset));

		$feed_items = $query->result();
				
		foreach ( $feed_items as $feed_item )
		{	
			$feed_item->tags = $this->tag_model->get_tags_for_feed_item($feed_item->id);
		}
		
		return $feed_items;
    }

    public function get_recent_items($feed_id, $limit = 20, $offset = 0)
    {
		$this->load->model('tag_model');

		$sql = "SELECT feeds.id AS feed_id, feeds.title AS feed_title, feed_items.date AS date, feed_items.permalink AS permalink, feed_items.title AS title, feed_items.id AS id FROM feed_items JOIN feeds WHERE feed_items.feed_id = ? AND feeds.id = feed_items.feed_id ORDER BY feed_items.date DESC LIMIT ? OFFSET ?";

		$query = $this->db->query($sql, array($feed_id, $limit, $offset));

		$feed_items = $query->result();
		
		foreach ( $feed_items as $feed_item )
		{				
			$feed_item->tags = $this->tag_model->get_tags_for_feed_item($feed_item->id);
		}
		
		return $feed_items;
    }
    
    public function insert($feed_id, $title, $date, $permalink, $hash)
    {
	    $sql = "INSERT INTO feed_items (feed_id, title, date, permalink, hash) VALUES (?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE id = LAST_INSERT_ID(id), title = VALUES(title)";

		$statement = $this->db->query($sql, array($feed_id, $title, $date, $permalink, $hash));

	    return $this->db->insert_id();
	}
}
