<?php

namespace Tests\Feature;

use App\Author;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthorManagementTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function an_author_can_be_created()
    {
        $this->withoutExceptionHandling();

        $response = $this->post('/authors', [
            'name' => 'An Author Name',
            'dob' => '1988-05-14'
        ]);

        $author = Author::first();

        $authors = Author::all();
        $this->assertCount(1, $authors);
        $this->assertInstanceOf(Carbon::class, $authors->first()->dob);
        $this->assertEquals('1988/14/05', $author->first()->dob->format('Y/d/m'));
        $response->assertRedirect($author->path());
    }

    /** @test */
    public function an_author_title_is_required()
    {
        //$this->withoutExceptionHandling();

        $response = $this->post('/authors', [
            'title' => '',
            'author' => 'Victor'
        ]);

        $response->assertSessionHasErrors('title');
    }

    /** @test */
    public function an_author_author_is_required()
    {
        //$this->withoutExceptionHandling();

        $response = $this->post('/authors', [
            'title' => 'Some author',
            'author' => ''
        ]);

        $response->assertSessionHasErrors('author');
    }

    /** @test */
    public function an_author_can_be_updated()
    {
        //$this->withoutExceptionHandling();

        $this->post('/authors', [
            'title' => 'Cool Title',
            'author' => 'Victor'
        ]);

        $author = Author::first();

        $response = $this->patch($author->path(), [
            'title' => 'New title',
            'author' => 'New author'
        ]);

        $this->assertEquals('New title', Author::first()->title);
        $this->assertEquals('New author', Author::first()->author);
        $response->assertRedirect($author->fresh()->path());
    }

    /**
     * @test
     * @testdox  description
     */
    public function an_author_can_be_deleted()
    {
        $this->withoutExceptionHandling();

        $this->post('/authors', [
            'title' => 'Cool Title',
            'author' => 'Victor'
        ]);
        $this->assertCount(1, Author::all());

        $author = Author::first();

        $response = $this->delete($author->path());

        $this->assertCount(0, Author::all());
        $response->assertRedirect('/authors');
    }
}