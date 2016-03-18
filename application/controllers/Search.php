<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Search extends CI_Controller 
{
	public function index()
	{
		$this->load->model('feed_model');
		$this->load->model('feeditem_model');
		$this->load->model('tag_model');

		$keyword = $this->input->post('keyword');
		
		if ( $keyword != '' )
		{
			$feed_items = $this->feeditem_model->search_feed_items_for_keyword($keyword);
			$tags = $this->tag_model->search_tags_for_keyword($keyword);
		}
		else
		{
			$feed_items = array();
			$tags = array();
		}
		
		$data = array();
		$data['title'] = 'Riverss';
		$data['table_title'] = htmlentities($keyword);
		$data['feed_items'] = $feed_items;
		$data['tags'] = $tags;

		$this->load->view('layout_head', $data);
		$this->load->view('tags', $data);
		$this->load->view('feed_items', $data);
		$this->load->view('layout_foot', $data);
	}
}
