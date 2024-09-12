<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Books extends MY_Controller 
{

	/**
	 * Constructor to initialize book model
	 */
	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model('Book_model');
	}

	/**
	 * List all books
	 */
	public function get_books()
	{
		$this->setupWithLayout('books/index', ['data' => $this->Book_model->get_books()]);		
	}

	/**
	 * Get specific book
	 */
	public function get_book($id)
	{
		$this->setupWithLayout('books/show', ['data' => $this->Book_model->get_book($id)]);
	}

	/**
	 * Store book
	 */
	public function create_book()
	{
		$output = $this->validation();

		if ($output != TRUE) {
			return $output;
		}

		$this->Book_model->create_book($output);
		$this->success('Successfully created');
	}

	/**
	 * Update book
	 */
	public function update_book($id)
	{
		$output = $this->validation();

		if (!is_array($output)) {
			return $output;
		}
		
		$book = $this->Book_model->update_book($output, $id);

		if (! $book > 0) {
			return $this->error("Cannot update book, please try again");
		}

		return $this->success('Successfully updated book.');
	}

	/**
	 * Delete book
	 */
	public function delete_book($id)
	{
		$book = $this->Book_model->delete_book($id);
		if (! $book > 0) {
			return $this->error("Cannot delete book", 404);
		}

		return $this->success("Successfully deleted book");

	}

	/**
	 * Validation function
	 */
	private function validation()
	{
		$this->form_validation->set_error_delimiters('', '');
		$this->form_validation->set_rules('title', 'Title', 'required');
		$this->form_validation->set_rules('firstname', 'Author First Name', 'required');
		$this->form_validation->set_rules('lastname', 'Author Last Name', 'required');
		$this->form_validation->set_rules('published_year', 'Published Year', 
			'required|integer|less_than['.(date('Y') + 1).']|greater_than[1901]', 
			array('min_length' => 'The Published Year field must be year.', 'max_length' => 'The Published Year field must be year.'));
		$this->form_validation->set_rules('description', 'Description', 'required|min_length[100]');

		if ($this->form_validation->run() == FALSE)
        {            
            $errors = validation_errors();
			$e = explode("\n", $errors);
			if ($e[count($e)-1] == "") {
				array_pop($e);
			}
            $response = array(
                'status' => 'error',
                'errors' => $e
            );
			return $this->error($response, 422);
        }
		return [
			'title' => $this->input->post('title'),
			'author' => $this->input->post('firstname') . ' '.$this->input->post('lastname'),
			'published_year' => $this->input->post('published_year'),
			'genre' => $this->input->post('genre'),
			'description' => $this->input->post('description')
		];
	}
}
