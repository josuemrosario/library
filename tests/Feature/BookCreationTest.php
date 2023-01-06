<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Book;

class BookCreationTest extends TestCase
{
    
    use RefreshDatabase;
    
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_a_book_can_be_added_to_the_library()
    {
        
        
        
        //Laravel will not show exceptions
        $this->withoutExceptionHandling();
        
        $response = $this->post('/books',[
            'title' => 'Cool Book Title',
            'author' => 'Victor',

        ]);

        $response->assertOK();
        $this->assertCount(1,Book::all());
    }

    public function test_a_title_is_required(){
        
       
        $response = $this->post('/books',[
            'title' => '',
            'author' => 'Victor',

        ]);

        $response->assertSessionHasErrors('title');

    }


    public function test_an_author_is_required(){
        
       
        $response = $this->post('/books',[
            'title' => 'Cool title',
            'author' => '',

        ]);

        $response->assertSessionHasErrors('author');

    }


    public function test_a_book_can_be_updated(){
        
       $this->withoutExceptionHandling();

        $this->post('/books',[
            'title' => 'Cool title',
            'author' => 'Victor',

        ]);

        $book = Book::first();

        $response = $this->patch('/books/'.$book->id,[
            'title' => 'New Title',
            'author' => 'New Author',

        ]);

        $this->assertEquals('New Title', Book::first()->title);
        $this->assertEquals('New Author', Book::first()->author);

    }

}
