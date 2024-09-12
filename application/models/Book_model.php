<?php

class Book_model extends CI_Model
{
	protected $table = 'books';

	/**
	 * Returns all the list of books
	 */
	public function get_books()
	{
		return $this->db->get($this->table)->result();
	}

	/**
	 * Get book by id
	 */
	public function get_book($id)
	{	
		$result = $this->db->get_where($this->table, array('id' => $id), 1)->result();
		if (count($result) > 0) {
			return $result[0];
		}
		return null;
	}

	/**
	 * Update book
	 */
	public function update_book($data, $id)
	{
		$this->db->trans_start();
		$this->db->update($this->table, $data, array('id' => $id));
		$this->db->trans_complete();
		if ($this->db->affected_rows() > 0) {
			return 1;
		} else {
			if ($this->db->trans_status() === FALSE) {
				return 0;
			}
			return 1;
		}
	}

	/**
	 * Insert book
	 */
	public function create_book($data)
	{
		$this->db->insert($this->table, $data);
		return $this->db->affected_rows();
	}

	/**
	 * Delete book
	 */
	public function delete_book($id)
	{
		$this->db->delete($this->table, array('id' => $id));
		return $this->db->affected_rows();
	}
}
