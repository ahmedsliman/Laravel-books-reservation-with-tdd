<?php

namespace Tests\Feature;

use App\Author;
use App\Book;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookManagementTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_book_can_be_added_to_the_library()
    {
        $this->withoutExceptionHandling();

        $response = $this->post('/books', $this->data());

        $book = Book::first();

        //$response->assertOk();
        $this->assertCount(1, Book::all());
        $response->assertRedirect($book->path());
    }

    /** @test */
    public function a_book_title_is_required()
    {
        //$this->withoutExceptionHandling();

        $response = $this->post('/books', $this->data());

        $response->assertSessionHasErrors('title');
    }

    /** @test */
    public function a_book_author_is_required()
    {
        //$this->withoutExceptionHandling();

        $response = $this->post('/books', array_merge($this->data(), ['author_id' => '']));

        $response->assertSessionHasErrors('author_id');
    }

    /** @test */
    public function a_book_can_be_updated()
    {
        //$this->withoutExceptionHandling();

        $this->post('/books', $this->data());

        $book = Book::first();

        $response = $this->patch($book->path(), $this->data());

        $this->assertEquals('Cool Title', Book::first()->title);
        $this->assertEquals(1, Book::first()->author_id);
        $response->assertRedirect($book->fresh()->path());
    }

    /**
     * @test
     * @testdox  description
     */
    public function a_book_can_be_deleted()
    {
        $this->withoutExceptionHandling();

        $this->post('/books', $this->data());
        $this->assertCount(1, Book::all());

        $book = Book::first();

        $response = $this->delete($book->path());

        $this->assertCount(0, Book::all());
        $response->assertRedirect('/books');
    }

    public function a_new_author_is_automatically_added()
    {
        $this->withoutExceptionHandling();

        $this->post('/books', $this->data());

        $book = Book::first();
        $author = Author::first();

        $this->assertCount(1, Author::all());
        $this->assertEquals($author->id, $book->author_id);
    }

    private function data()
    {
        return [
            'title' => 'Cool Title',
            'author_id' => 'Victor'
        ];
    }
}
