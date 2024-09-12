<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_books_table extends CI_Migration {

    public function up()
    {
        // Create table
        $this->dbforge->add_field(array(
            'id' => array(
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => TRUE,
                'auto_increment' => TRUE,
            ),
            'title' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'author' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'genre' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
            ),
            'published_year' => array(
                'type' => 'YEAR'                
            ),
            'description' => array(
                'type' => 'TEXT',
                'null' => TRUE,
            ),
        ));
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('books');
    }

    public function down()
    {
        // Drop table
        $this->dbforge->drop_table('books');
    }
}
