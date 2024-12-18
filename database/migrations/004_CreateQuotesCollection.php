<?php
require_once __DIR__ . '/Migration.php';

class CreateQuotesCollection extends Migration {
    public function up() {
        // Buat collection quotes
        $this->createCollection('quotes');
        
        // Data awal quotes
        $quotes = [
            [
                'quote' => 'When you want something, all the universe conspires in helping you to achieve it.',
                'context' => 'Santiago belajar bahwa impian dan keinginan kita memiliki kekuatan untuk menggerakkan alam semesta.',
                'source' => 'The Alchemist',
                'author' => 'Paulo Coelho'
            ],
            [
                'quote' => 'It\'s the possibility of having a dream come true that makes life interesting.',
                'context' => 'Tentang bagaimana harapan dan mimpi memberi makna pada kehidupan kita.',
                'source' => 'The Alchemist',
                'author' => 'Paulo Coelho'
            ],
            [
                'quote' => 'The secret of life, though, is to fall seven times and to get up eight times.',
                'context' => 'Pentingnya ketahanan dan resiliensi dalam menghadapi tantangan hidup.',
                'source' => 'The Alchemist',
                'author' => 'Paulo Coelho'
            ]
        ];
        
        $this->db->quotes->insertMany($quotes);
        
        // Buat indexes
        $this->createIndex('quotes', 
            ['author' => 1]
        );
        
        $this->createIndex('quotes',
            ['source' => 1]
        );
    }
    
    public function down() {
        $this->dropCollection('quotes');
    }
} 