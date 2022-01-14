<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Api extends CI_Controller {
    public function __construct() {
        parent::__construct();
		header('Access-Control-Allow-Origin: *');
		header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
		header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
    }

    public function login(){
        $password = $this->security->xss_clean(htmlspecialchars($this->input->post('password')));
		$username = $this->security->xss_clean(htmlspecialchars($this->input->post('username')));

		if(empty($username)){
			$json = file_get_contents('php://input');
			$data = json_decode($json);
			$username = $this->security->xss_clean(htmlspecialchars($data->username, ENT_QUOTES));
			$password = $this->security->xss_clean(htmlspecialchars($data->password, ENT_QUOTES));
		}

        $this->db->where('username',$username);
        $this->db->or_where('email',$username);
        $this->db->where('status',1);
        $this->db->limit(1);
        $check = $this->db->get('user');

        if($check->num_rows() > 0){
            $user_data = $check->row_array();
            $this->session->set_userdata($user_data);
            if($user_data['password'] == md5($password)){
                $response = array(
                    'msg'=> 'Welcome to Dashboard '. $user_data['username'],
                    'url' => base_url('welcome/dashboard'),
                    'status' => 1,
                );
            }else{
                $response = array(
                    'msg'=> 'Your password doesnot mach',
                    'status' => 0,
                );
            }
        }else{
            $response = array(
                'msg'=> 'Email Id Doesnot Exists',
                'status' => 0,
            );
        }

        echo json_encode($response);   exit();
    }

    public function register(){
        $password = $this->security->xss_clean(htmlspecialchars($this->input->post('password')));
		$username = $this->security->xss_clean(htmlspecialchars($this->input->post('username')));
		$email = $this->security->xss_clean(htmlspecialchars($this->input->post('email')));
		$country = $this->security->xss_clean(htmlspecialchars($this->input->post('country')));

		if(empty($username)){
			$json = file_get_contents('php://input');
			$data = json_decode($json);
			$username = $this->security->xss_clean(htmlspecialchars($data->username, ENT_QUOTES));
			$password = $this->security->xss_clean(htmlspecialchars($data->password, ENT_QUOTES));
			$country = $this->security->xss_clean(htmlspecialchars($data->country, ENT_QUOTES));
			$email = $this->security->xss_clean(htmlspecialchars($data->email, ENT_QUOTES));
		}

        $this->form_validation->set_rules('username', 'Username','required|min_length[8]|max_length[12]|is_unique[user.username]',
            array(
                    'required'      => 'You have not provided %s.',
                    'is_unique'     => 'This %s already exists.',
                    'min_length' => '%s must be at least 8 characters long',
                    'max_length' => 'Maximum 12 characters accepted',
            )
        );
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_rules('country', 'Country', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[user.email]',
            array(
                'required'      => 'You have not provided %s.',
                'is_unique'     => 'This %s already exists.',
                'valid_email' => 'This %s is not valid',
            )
        );

        if(!$this->form_validation->run()){
            $response = array(
                'msg'=> 'Error!! In your Registration Form',
                'errors' => validation_errors(),
                'status' => 0,
            );
        }else{
            $data = array(
                'username'=> $username,
                'email' => $email,
                'country' => $country,
                'password' => md5($password),
                'status' => 1,
                'activate' => 0,
            );
    
            $signup_check = $this->db->insert('user', $data);

            if($signup_check){
                $response = array(
                    'msg'=> 'Thank you for regestering with us!!',
                    'url' => base_url(),
                    'status' => 1,
                );
            }else{
                $response = array(
                    'msg'=> 'Network Error!! Please try after some time',
                    'status' => 0,
                );
            }
        }

        echo json_encode($response);   exit();
    }

    public function forgot(){
		$username = $this->security->xss_clean(htmlspecialchars($this->input->post('email')));

		if(empty($username)){
			$json = file_get_contents('php://input');
			$data = json_decode($json);
			$username = $this->security->xss_clean(htmlspecialchars($data->username, ENT_QUOTES));
		}

        $this->db->or_where('email',$username);
        $this->db->where('status',1);
        $this->db->limit(1);
        $check = $this->db->get('user');

        if($check->num_rows() > 0){
            $user_data = $check->row_array();
            $url = base_url('welcome/recovery/').$this->my_simple_crypt($user_val['user_id'], 'e');

            if($user_data['password'] == md5($password)){
                $response = array(
                    'msg'=> 'Welcome to Dashboard '. $user_data['username'],
                    'url' => base_url('welcome/dashboard'),
                    'status' => 1,
                );
            }else{
                $response = array(
                    'msg'=> 'Your password doesnot mach',
                    'status' => 0,
                );
            }
        }else{
            $response = array(
                'msg'=> 'Email Id Doesnot Exists',
                'status' => 0,
            );
        }

        echo json_encode($response);   exit();
    }

    public function logout(){
        $this->session->sess_destroy();
        redirect(base_url());
	}

    function my_simple_crypt( $string, $action = 'e' ) {
		// you may change these values to your own
		$secret_key = 'my_simple_secret_key';
		$secret_iv = 'my_simple_secret_iv';
	 
		$output = false;
		$encrypt_method = "AES-256-CBC";
		$key = hash( 'sha256', $secret_key );
		$iv = substr( hash( 'sha256', $secret_iv ), 0, 16 );
	 
		if( $action == 'e' ) {
			$output = base64_encode( openssl_encrypt( $string, $encrypt_method, $key, 0, $iv ) );
		}
		else if( $action == 'd' ){
			$output = openssl_decrypt( base64_decode( $string ), $encrypt_method, $key, 0, $iv );
		}
	 
		return $output;
	}
}