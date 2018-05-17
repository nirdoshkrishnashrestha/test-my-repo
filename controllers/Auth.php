<?php // test
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	public function index()
	{
		$this->load->view('login');
	}
	
	public function validate()
	{
		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('password', 'Password', 'trim|required');
		$username = $this->input->post("username");
		$password = $this->input->post("password");
		 if ($this->form_validation->run() == FALSE)
                {
                        $this->load->view('login');
                }
                else
                {	
					$count = $this->main_model->login_check($username,$password);	 /// this will check if user and pass matches or not			
					if($count == 1){
					$this->session->set_userdata('username', $username);
					$this->load->view('success',$username);}						
						else{
						$this->session->set_flashdata('fail', 'Username or Password Incorrect');	
						$this->load->view('login');}	
						
						
                }
		
	}
	
		public function register()
	{
		$this->load->view('register');
	}
	
		public function check_session()
	{
		if($this->session->userdata('username') != NULL)
		$this->load->view('success');
		else
		$this->load->view('login');
	}
	
	public function register_data()
	{
		$this->form_validation->set_message('is_unique', 'The %s is already taken');  // Set errors for all is_unique condition
		$this->form_validation->set_rules('username', 'Username', 'required|min_length[5]|max_length[12]|is_unique[tbl_users.username]');
		$this->form_validation->set_rules('password', 'Password', 'required|min_length[5]|matches[c_password]');
		$this->form_validation->set_rules('c_password', 'Password Confirmation', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[tbl_users.email]');
		$this->form_validation->set_rules('mobile', 'Mobile', 'required|numeric|exact_length[10]|is_unique[tbl_users.mobile]');
		//// is_unique[tbl_users.mobile] checks if there is any value exist in mobile field of table tbl_user 	
		//// is_unique[tbl_users.username] checks if there is any username exits in username field of table tbl_users	
		
		 if ($this->form_validation->run() == FALSE)
                {
                        $this->load->view('register');
                }
                else
                {
						
						$username = $this->input->post("username");
						$password = $this->input->post("password");
						$email = $this->input->post("email");
						$mobile = $this->input->post("mobile");
						
						$data = array(
						"username" => $username,
						"password" => $password,
						"email" => $email,
						"mobile" => $mobile,
						);
						$this->main_model->insert_user($data);
						$this->session->set_flashdata('success', 'User added');
                        $this->load->view('login');
                }
		
	}
	
	
}
