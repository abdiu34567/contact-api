<?php

namespace Tests\Feature;

use App\Models\Contact;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test that a contact can be created successfully.
     */
    public function test_can_create_a_contact(): void
    {
        $contactData = [
            'first_name' => 'Test',
            'last_name' => 'User',
            'email' => 'test@example.com',
            'phone' => '+1234567890',
        ];

        $response = $this->postJson('/api/contacts', $contactData);

        $response->assertStatus(201);

        $response->assertJsonFragment([
            'first_name' => 'Test',
            'email' => 'test@example.com',
        ]);

        $this->assertDatabaseHas('contacts', [
            'email' => 'test@example.com',
        ]);
    }

    /**
     * Test validation fails when required fields are missing.
     */
    public function test_validation_fails_for_create_contact(): void
    {
        $response = $this->postJson('/api/contacts', []);

        $response->assertStatus(422);

        $response->assertJsonValidationErrors(['first_name', 'last_name', 'email', 'phone']);
    }

    public function test_can_list_all_contacts(): void
    {
        Contact::factory()->count(3)->create();

        $response = $this->getJson('/api/contacts');

        $response->assertStatus(200);

        $response->assertJsonCount(3, 'data');
    }

    public function test_can_show_a_single_contact(): void
    {
        $contact = Contact::factory()->create();

        $response = $this->getJson('/api/contacts/'.$contact->id);

        $response->assertStatus(200);

        $response->assertJsonPath('data.id', $contact->id);
    }

    public function test_can_update_a_contact(): void
    {
        $contact = Contact::factory()->create();

        $updateData = [
            'first_name' => 'Updated Name',
            'last_name' => $contact->last_name,
            'email' => $contact->email,
            'phone' => $contact->phone,
        ];

        $response = $this->putJson('/api/contacts/'.$contact->id, $updateData);

        $response->assertStatus(200);
        $response->assertJsonPath('data.first_name', 'Updated Name');

        $this->assertDatabaseHas('contacts', [
            'id' => $contact->id,
            'first_name' => 'Updated Name',
        ]);
    }

    public function test_can_delete_a_contact(): void
    {
        $contact = Contact::factory()->create();

        $response = $this->deleteJson('/api/contacts/'.$contact->id);

        $response->assertStatus(204);

        $this->assertDatabaseMissing('contacts', ['id' => $contact->id]);
    }

    public function test_can_search_for_a_contact(): void
    {
        $matchingContact = Contact::factory()->create([
            'first_name' => 'John',
            'company' => 'Global Tech',
        ]);

        $nonMatchingContact = Contact::factory()->create([
            'first_name' => 'Jane',
            'company' => 'Web Solutions',
        ]);

        $response = $this->getJson('/api/contacts/search?query=John');

        $response->assertStatus(200);

        $response->assertJsonCount(1, 'data');

        $response->assertJsonPath('data.0.id', $matchingContact->id);

        $response->assertJsonMissing(['id' => $nonMatchingContact->id]);
    }
}
