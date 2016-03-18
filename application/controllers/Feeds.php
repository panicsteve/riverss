<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Feeds extends CI_Controller 
{
	public function index($page = 0)
	{
		$per_page = 10;
		
		$this->load->model('feed_model');
		$this->load->model('feeditem_model');
		
		$data = array();
		$data['title'] = 'Riverss';
		$data['table_title'] = "Recent";
		$data['feed_items'] = $this->feeditem_model->get_recent_items_from_all_feeds($per_page, $page * $per_page);
		$data['page'] = $page;
		$data['pagination_route'] = '/feeds/index/';
		
		$this->load->view('layout_head', $data);
		$this->load->view('feed_items', $data);
		$this->load->view('pagination', $data);
		$this->load->view('layout_foot', $data);
	}
	
	public function view($feed_id, $page = 0)
	{
		$per_page = 10;

		$this->load->model('feed_model');
		$this->load->model('feeditem_model');
		$this->load->model('tag_model');

		$feed = $this->feed_model->get($feed_id);

		$data = array();
		$data['title'] = 'Riverss';
		$data['table_title'] = $feed[0]->title;	
		$data['feed_id'] = $feed_id;
		$data['page'] = $page;
		$data['pagination_route'] = "/feeds/view/$feed_id/";
		$data['feed_items'] = $this->feeditem_model->get_recent_items($feed_id, $per_page, $page * $per_page);
		
		if ( count($data['feed_items']) == 0 )
		{
			$data['table_title'] = 'No more items.';
		}

		$this->load->view('layout_head', $data);
		$this->load->view('feed_items', $data);
		$this->load->view('pagination', $data);
		$this->load->view('layout_foot', $data);
	}
	
	public function update()
	{
		$this->load->model('feed_model');
		$this->load->model('feeditem_model');
		$this->load->model('tag_model');

		$feeds = $this->feed_model->get_all();
		
		foreach ( $feeds as $feed )
		{
			//echo "<b>Updating {$feed->title}... </b><br>";
			
			$parser = new SimplePie();
			$parser->set_feed_url($feed->url);
			$parser->enable_cache(true);
			$parser->force_fsockopen(true);
			$parser->init();
			$parser->handle_content_type();
	
			$feed_items = $parser->get_items();
	
			$new_count = 0;
			
			foreach ( $feed_items as $feed_item )
			{
				$new_feed_item_id = $this->feeditem_model->insert(
						$feed->id, $feed_item->get_title(), 
						$feed_item->get_date('Y-m-d H:i:s'), 
						$feed_item->get_permalink(), 
						$feed_item->get_id(true));

				if ( $new_feed_item_id != 0 )
				{
					if ( $feed_item->get_categories() )
					{
						foreach ( $feed_item->get_categories() as $cat )
						{
							$new_tag_id = $this->tag_model->insert($cat->get_label());
							
							$this->feeditem_model->attach_tag_to_feed_item($new_tag_id, $new_feed_item_id);
						}
					}				
				}
			}
		}
	}
}
