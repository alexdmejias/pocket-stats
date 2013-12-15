<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pocket extends CI_Controller {

	// load and setup an array with all the necessary/global
	// parameters
	public function _config() {
		// load special config file
		$this->load->helper('url');
		$this->config->load('pocket.php');

		$config = array(
			'request_url' => 'https://getpocket.com/v3/oauth/request',
			'authorize_url' => 'https://getpocket.com/v3/oauth/authorize',
			'consumer_key' => $this->config->item('consumer_key'),
			'access_token' => $this->config->item('access_token'),
			'redirect_uri' => $this->config->item('redirect_uri')
		);

		return $config;
	}

	public function connect() {

		$config = $this->_config();

		// $config['request_url'] = 'https://getpocket.com/v3/oauth/request';

		$data = array(
			'consumer_key' => $config['consumer_key'],
			'redirect_uri' => $config['redirect_uri']
		);
		$post_data = http_build_query($data);

		$opts = array(
		    'http' => array(
		        'method' => "POST",
		        'header' => "Connection: close\r\n".
		                    "Content-type: application/x-www-form-urlencoded\r\n".
		                    "Content-Length: ".strlen($post_data)."\r\n",
		        'content' => $post_data
		  )
		);

		$context  = stream_context_create($opts);
		$result = file_get_contents($config['request_url'], false, $context);

		$code = explode('=', $result);
		$request_token = $code[1];

		header("Location: https://getpocket.com/auth/authorize?request_token=$request_token&redirect_uri=".$data['redirect_uri']."?request_token=$request_token");

	}

	public function callback() {
		$config = $this->_config();

		$consumer_key = $config['consumer_key'];
		$request_token = $_GET['request_token'];

		$data_config = array(
			'consumer_key' => $config['consumer_key'],
			'code' => $request_token
		);

		$post_data = http_build_query($data_config);

		$opts = array(
			'http' => array(
				'method' => 'POST',
				'header' => "Connection: close\r\n".
							"Content-type: application/x-www-form-urlencoded\r\n".
							"Content-Length: ".strlen($post_data)."\r\n",
				'content' => $post_data
			)
		);
		var_dump($config);
		$context = stream_context_create($opts);
		$result = file_get_contents($config['authorize_url'], false, $context);

        $access_token = explode('&',$result);
        if($access_token[0]!=''){
                echo "<h1>You've been authenticated succesfully!</h1>";
                echo "You should write down the access_token and then add it to config.php<br>";
                echo "Your access token: ". $access_token[0];
                echo "<br>";
                echo "add this to config.php";
        } else{
                echo "Something went wrong. :( ";
        }
	}

	public function _get_articles($article_count = 10) {
		$config = $this->_config();

		$retrive_url = 'https://getpocket.com/v3/get?count='. $article_count;

        $data = array(
            'consumer_key' => $config['consumer_key'],
            'access_token' => $config['access_token']
        );
        $creds_data = http_build_query($data);

        $options = array(
	        'http' => array(
                'method'  => 'POST',
                'content' => http_build_query($data)
	        )
        );

		$request = array(
			'http' => array(
				'method' => 'POST',
				'header' => "Connection: close\r\n".
							"Content-type: application/x-www-form-urlencoded\r\n".
							"Content-Length: ".strlen($creds_data)."\r\n",
				'content' => $creds_data
			)
		);

		$context = stream_context_create($request);
		$result = file_get_contents($retrive_url, false, $context);

		$list = json_decode($result);

		return $list->list;

	}

	public function _get_total_count() {
		$list = $this->_get_articles(10000);

		return count((array)$list);
	}

	public function articles($article_count = 10) {
		$list = $this->_get_articles($article_count);
		$list_count = count((array)$list);
		$data['list'] = $list;
		$data['count'] = $list_count;

		$this->load->view('_header');
		$this->load->view('list', $data);
		$this->load->view('_footer');
	}

	public function full() {
		$list = $this->_get_articles(10000);

		$data['list'] = $list;
		$data['count'] = count((array)$list);

		$this->load->view('_header');
		$this->load->view('list', $data);
		$this->load->view('_footer');
	}

	public function insert() {
		$count = $this->_get_total_count();
		$this->load->model('Count');
		$this->Count->insert_entry($count);

		$data['msg'] = "inserted $count";

		$this->load->view('_header');
		$this->load->view('basic', $data);
		$this->load->view('_footer');
	}

	public function index() {
		$config = $this->_config();
		$data['list'] = $this->_get_articles(10);
		$data['msg'] = "this will be the index page";
		$data['wasd'] = $config;
		$this->load->view('_header');
		$this->load->view('basic', $data);
		$this->load->view('_footer');
	}

}