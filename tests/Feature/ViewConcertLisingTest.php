<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ViewConcertLisingTest extends TestCase
{
    /**
     * @test
     * @testdox  description
     */
    public function user_can_view_a_concert_listing()
    {
        // Arrange
        // Create a concert
        $concert = Concert::create([
            'title' => 'The Red Cord',
            'subtitle' => 'with Animosity and Lethargy',
            'date' => Carbon::parse('December 13, 2019'),
            ''
        ]);

        // Act
        // View the concert listing

        // Assert
        // See the concert details
    }
}