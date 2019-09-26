<?php

namespace Tests\Feature;

use App\Book;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookReservationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_book_can_be_added_to_the_library()
    {
        $this->withoutExceptionHandling();

        $response = $this->post('/books', [
            'title' => 'Cool Book Title',
            'author' => 'Victor'
        ]);

        $book = Book::first();

        //$response->assertOk();
        $this->assertCount(1, Book::all());
        $response->assertRedirect('/books/' . $book->id);
    }

    /** @test */
    public function a_book_title_is_required()
    {
        //$this->withoutExceptionHandling();

        $response = $this->post('/books', [
            'title' => '',
            'author' => 'Victor'
        ]);

        $response->assertSessionHasErrors('title');
    }

    /** @test */
    public function a_book_author_is_required()
    {
        //$this->withoutExceptionHandling();

        $response = $this->post('/books', [
            'title' => 'Some book',
            'author' => ''
        ]);

        $response->assertSessionHasErrors('author');
    }

    /** @test */
    public function a_book_can_be_updated()
    {
        //$this->withoutExceptionHandling();

        $this->post('/books', [
            'title' => 'Cool Title',
            'author' => 'Victor'
        ]);

        $book = Book::first();

        $response = $this->patch('/books/' . $book->id, [
            'title' => 'New title',
            'author' => 'New author'
        ]);

        $this->assertEquals('New title', Book::first()->title);
        $this->assertEquals('New author', Book::first()->author);
        $response->assertRedirect('/books/' . $book->id);
    }

    /**
     * @test
     * @testdox  description
     */
    public function a_book_can_be_deleted()
    {
        $this->withoutExceptionHandling();

        $this->post('/books', [
            'title' => 'Cool Title',
            'author' => 'Victor'
        ]);
        $this->assertCount(1, Book::all());

        $book = Book::first();

        $response = $this->delete('/books/' . $book->id);

        $this->assertCount(0, Book::all());
        $response->assertRedirect('/books');
    }
}