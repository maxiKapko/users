<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_user()
    {
        // Arrange
        $userData = [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => bcrypt('password123'),
        ];

        // Act
        $user = User::create($userData);

        // Assert
        $this->assertDatabaseHas('users', ['email' => 'john@example.com']);
        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals('John Doe', $user->name);
        $this->assertEquals('john@example.com', $user->email);
    }

    /** @test */
    public function it_can_edit_a_user()
    {
        // Arrange
        $user = User::factory()->create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => bcrypt('password123'),
        ]);

        // Act
        $newName = 'Updated Name';
        $user->update(['name' => $newName]);

        // Assert
        $this->assertDatabaseHas('users', ['id' => $user->id, 'name' => $newName]);
        $this->assertEquals($newName, $user->fresh()->name);
    }
}
