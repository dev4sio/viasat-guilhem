<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Welcome extends CI_Controller
{

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

	public function __construct()
	{
		parent::__construct();
		$this->load->model('user_model');
		$this->load->helper('url_helper');
		$this->load->library('form_validation');
		$this->load->library('session');
	}

	public function index()
	{
		//renvoie l'utilisateur sur la map si il ne s'est pas déconnecté manuellement
		if (!empty($this->session->userdata('user'))) {
			redirect('map/index');
		}

		$this->load->view('templates/header');
		$this->load->view('user/login_form');

		$this->load->view('templates/footer');
	}

	public function login()
	{
		$this->load->helper('form');

		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');

		//On vérifie que la de l'utilisateur est conforme au régles définies
		if ($this->form_validation->run() === FALSE) {
			$this->load->view('templates/header');
			$this->load->view('user/login_form');

			$this->load->view('templates/footer');
		} else {
			$result = $this->user_model->get_user();
			//On vérifie si l'utilisateur existe dans la base
			if (empty($result)) {
				$data['error_msg'] = 'Veuilez vérifier votre nom d\'utilisateur et votre mot de passse.';
				$this->load->view('templates/header');
				$this->load->view('user/login_form', $data);

				$this->load->view('templates/footer');

				//On vérifie que le mot de passe en POST coressepont à celui de la de l'utilisateur dans la base
				//!!!Utiliser password_verify() quand tu auras hashé les mot de passe dans la bdd
			} else if (password_verify($this->input->post('password'), $result['password'])) {
				$data['error_msg'] = 'Veuilez vérifier votre nom d\'utilisateur et votre mot de passse.';
				$this->load->view('templates/header');
				$this->load->view('user/login_form', $data);

				$this->load->view('templates/footer');
				//Connexion réussie
			} else {
				$data['user'] = array(
					'id' => $result['id'],
					'username' => $result['username'],
					'first_name' => $result['first_name'],
					'last_name' => $result['last_name'],
					'email' => $result['email']
				);
				$this->session->set_userdata($data);
				redirect('/map/index/');
			}
		}
	}
	public function logout()
	{
		$this->session->sess_destroy();
		redirect('welcome/index');
	}

	public function signin_page()
	{
		$this->load->view('templates/header');
		$this->load->view('user/signin_form');
		$this->load->view('templates/footer');
	}


	public function signin()
	{
		$this->load->helper('form');

		$this->form_validation->set_rules('username', 'Username', 'required|min_length[5]|max_length[12]|is_unique[user.username]|alpha_numeric');
		$this->form_validation->set_rules('password', 'Password', 'required|min_length[5]');
		$this->form_validation->set_rules('passconf', 'Password Confirmation', 'required|min_length[5]|matches[password]');
		$this->form_validation->set_rules('last_name', 'Last Name', 'required');
		$this->form_validation->set_rules('first_name', 'First Name', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[user.email]');

		if ($this->form_validation->run() === FALSE) {
			$this->load->view('templates/header');
			$this->load->view('user/signin_form');
			$this->load->view('templates/footer');
		} else {
			$this->user_model->set_user();
			redirect('/map/index/');
		}
	}

	public function profile_page()
	{
		$data['user'] = $this->user_model->get_user($_SESSION['user']['id']);
		$this->load->view('templates/header');
		$this->load->view('user/edit_profile_form', $data);
		$this->load->view('templates/footer');
	}

	public function edit_profile()
	{
		$this->load->helper('form');
		//regles de validation
		$this->form_validation->set_rules('last_name', 'Last Name', 'required');
		$this->form_validation->set_rules('first_name', 'First Name', 'required');
		//sinon les régles ne sont pas respectées, on renvoit le formulaire
		if ($this->form_validation->run() === FALSE) {
			$data['msg'] = 'Erreur lors de la modifications de vos informations';
			$this->load->view('templates/header');
			$this->load->view('user/edit_profile_form', $data['msg']);
			$this->load->view('templates/footer');
		} else {
			$this->user_model->edit_user();
			$data['user'] = $this->user_model->get_user($_SESSION['user']['id']);
			$data['msg'] = 'Changements effectués !';
			$this->load->view('templates/header');
			$this->load->view('user/edit_profile_form', $data);
			$this->load->view('templates/footer');
		}
	}
}
