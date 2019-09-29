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
        //$this->withoutExceptionHandling();

        $response = $this->post('/authors', $this->data());

        $author = Author::first();

        $authors = Author::all();
        $this->assertCount(1, $authors);
        $this->assertInstanceOf(Carbon::class, $authors->first()->dob);
        $this->assertEquals('1988/14/05', $author->first()->dob->format('Y/d/m'));
        //$response->assertRedirect($author->path());
    }

    /** @test */
    public function a_name_is_required()
    {
        //$this->withoutExceptionHandling();

        $response = $this->post('/authors', array_merge($this->data(), ['name' => '']));

        $response->assertSessionHasErrors('name');
    }

    /** @test */
    public function a_dob_is_required()
    {
        //$this->withoutExceptionHandling();

        $response = $this->post('/authors', array_merge($this->data(), ['dob' => '']));

        $response->assertSessionHasErrors('dob');
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
        //$this->withoutExceptionHandling();

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

    private function data()
    {
        return [
            'name' => 'An Author Name',
            'dob' => '1988-05-14'
        ];
    }
}