<?php

namespace Tests\Feature;

use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_get_all_books(): void
    {
        Book::factory()->count(3)->create();

        $response = $this->getJson('/api/books');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    '*' => ['id', 'title', 'author', 'publisher', 'year'],
                ],
            ])
            ->assertJson(['success' => true]);
    }

    public function test_can_create_a_book(): void
    {
        $payload = [
            'title' => 'Laravel Up & Running',
            'author' => 'Matt Stauffer',
            'publisher' => "O'Reilly Media",
            'year' => 2023,
        ];

        $response = $this->postJson('/api/books', $payload);

        $response->assertStatus(201)
            ->assertJson([
                'success' => true,
                'message' => 'Buku berhasil ditambahkan',
                'data' => $payload,
            ]);

        $this->assertDatabaseHas('books', $payload);
    }

    public function test_create_book_validates_required_fields(): void
    {
        $response = $this->postJson('/api/books', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['title', 'author', 'publisher', 'year']);
    }

    public function test_create_book_validates_year_range(): void
    {
        $payload = [
            'title' => 'Test Book',
            'author' => 'Test Author',
            'publisher' => 'Test Publisher',
            'year' => 999,
        ];

        $response = $this->postJson('/api/books', $payload);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['year']);
    }

    public function test_can_show_a_book(): void
    {
        $book = Book::factory()->create();

        $response = $this->getJson("/api/books/{$book->id}");

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Detail buku',
                'data' => ['id' => $book->id],
            ]);
    }

    public function test_show_returns_404_for_missing_book(): void
    {
        $response = $this->getJson('/api/books/9999');

        $response->assertStatus(404);
    }

    public function test_can_update_a_book(): void
    {
        $book = Book::factory()->create();

        $response = $this->putJson("/api/books/{$book->id}", [
            'title' => 'Updated Title',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Buku berhasil diupdate',
                'data' => ['title' => 'Updated Title'],
            ]);

        $this->assertDatabaseHas('books', ['id' => $book->id, 'title' => 'Updated Title']);
    }

    public function test_can_delete_a_book(): void
    {
        $book = Book::factory()->create();

        $response = $this->deleteJson("/api/books/{$book->id}");

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Buku berhasil dihapus',
            ]);

        $this->assertDatabaseMissing('books', ['id' => $book->id]);
    }
}
