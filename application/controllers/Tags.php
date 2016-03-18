<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tags extends CI_Controller 
{
	public function index()
	{
		$this->load->model('tag_model');

		$tags = $this->tag_model->get_all();
		
		$data = array();
		$data['title'] = 'Riverss';
		$data['tags'] = $tags;

		$this->load->view('layout_head', $data);
		$this->load->view('tags', $data);
		$this->load->view('layout_foot', $data);
	}
		
	public function view($tag_id, $page = 0)
	{
		$per_page = 10;

		$this->load->model('feed_model');
		$this->load->model('feeditem_model');
		$this->load->model('tag_model');

		$feed_items = $this->tag_model->get_feed_items_for_tag($tag_id, $per_page, $page * $per_page);

		$data = array();
		$data['title'] = 'Riverss';
		
		if ( count($feed_items) > 0 )
		{
			$data['table_title'] = $feed_items[0]->tag_title;
		}
		else
		{
			$data['table_title'] = 'No more items.';
		}
			
		$data['feed_items'] = $feed_items;
		$data['page'] = $page;
		$data['pagination_route'] = "/tags/view/$tag_id/";

		$this->load->view('layout_head', $data);
		$this->load->view('feed_items', $data);
		$this->load->view('pagination', $data);		
		$this->load->view('layout_foot', $data);
	}
}
