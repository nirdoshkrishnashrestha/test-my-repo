<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Share extends CI_Controller {

	public function add_share()
	{
		$this->load->view('add_share');
	}
	
		public function insert_share1()
	{
		$this->load->view('add_share');
	}
	
	public function success()
	{
		$data["share_info"] = $this->main_model->get_share();
	}
	
	public function signout()
	{
		$this->session->unset_userdata('username');
		$this->session->sess_destroy();
		$this->load->view('login');
	}

	public function show_portfolio()
	{
		$data_s["share_info"] = $this->main_model->get_share_info();
		$this->load->view('profit',$data_s);
	}
	
	public function insert_share()
	{
		$data = array(
		"share_name" => $this->input->post("stock_symbol"),
		"date" => $this->input->post("date"),
		"buy_rate" => $this->input->post("buy_rate"),
		"num" => $this->input->post("num"),
		"username" => $this->session->userdata('username')
		);
		$this->main_model->insert_share($data);
		//$this->session->set_flashdata('under', 'Individual share section is Under Construction');
		redirect(base_url()."index.php/share/show_portfolio");		
	}
	
	public function delete($share_id)
	{
		$sql = "DELETE FROM `share_info` WHERE `share_info`.`share_id` = ".$share_id;
		$this->db->query($sql);	
		redirect(base_url()."index.php/share/show_portfolio");
	}
}
