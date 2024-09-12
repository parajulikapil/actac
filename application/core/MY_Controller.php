<?php

abstract class MY_Controller extends CI_Controller 
{
	/**
	 * Setup view layout and content
	 */
	public function setupWithLayout(string $viewPath, array|string|null $data)
	{
		$this->load->view('layouts/header');
		$this->load->view($viewPath, $data);
		$this->load->view('layouts/footer');
	}

	/**
	 * Success response for json response
	 */
	public function success(array|string $data, int $statusCode = 200)
	{
		$res = [];
		if (is_string($data)) {
			$res['message'] = $data;
		} else {
			$res = $data;
		}
		$this->output
		->set_status_header($statusCode)
		->set_content_type('application/json')
		->set_output(json_encode($res));
	}

	/**
	 * Error response for json response
	 */
	public function error(array|string $data, int $statusCode = 400)
	{
		$res = [];
		if (is_string($data)) {
			$res = array(
                'status' => 'error',
                'errors' => [$data]
            );
		} else {
			$res = $data;
		}
		$this->output
		->set_status_header($statusCode)
		->set_content_type('application/json')
		->set_output(json_encode($res));
	}
}
