<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Uddoktapay extends CI_Controller
{
	private $apiKey = '982d381360a69d419689740d9f2e26ce36fb7a50';
	private $apiURL = 'https://sandbox.uddoktapay.com/api/checkout-v2'; // Use API v2

	public function __construct()
	{
		parent::__construct();

		// Load Library
		$this->load->library('Uddoktapaylib');

		// Init Library
		Uddoktapaylib::init($this->apiKey, $this->apiURL);
	}

	public function index()
	{
		$data = [
			'page_title' => 'uddoktapay'
		];
		$this->load->view('uddoktapay/index', $data);
	}

	public function pay()
	{
		if ($this->input->post('amount') !== '') {
			// Uddoktapay Required Data
			$amount = $this->input->post('amount');
			$full_name = $this->input->post('full_name');
			$email = $this->input->post('email');
			$user_id = $this->input->post('user_id');

			$data = [
				'amount' => $amount,
				'full_name' => $full_name,
				'email' => $email,
				'metadata' => [
					'user_id' => $user_id // you can add more data in this section
				],
				'redirect_url' => site_url('uddoktapay/success'),
				'cancel_url' => site_url('uddoktapay/cancel'),
				'webhook_url' => site_url('uddoktapay/webhook'),
			];

			// Create Charge
			$response = Uddoktapaylib::create_payment($data);
			if ($response['status'] === true) {
				redirect($response['payment_url']);
			}
			die($response['message']);
		}
		die('Request is not allowed.');
	}

	public function success()
	{
		// Check API V2 Response Exist
		if ($this->input->post('invoice_id') !== '') {
			$data = Uddoktapaylib::execute_payment_v2();
			if ($data['status'] !== 'error' && $data['status'] === 'COMPLETED') {
				// Payment Success
				var_dump($data);
			} else {
				echo "Payment Pending";
			}
		} else {
			echo "Payment Pending";
		}
	}

	public function cancel()
	{
		echo "Payment Cancel";
	}

	public function webhook()
	{
		try {
			$data = Uddoktapaylib::execute_payment();
			if (!$data['status'] && $data['status'] === 'COMPLETED') {
				// Payment Success
				file_put_contents(FCPATH . 'data.txt', $data); // we just dump data into data.txt file for testing
			} else {
				echo "Payment Pending";
			}
		} catch (Exception $e) {
			die('Request is not allowed.');
		}
	}
}
