<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class EmailSendingTest extends TestCase
{
    public function testEmailIsSent()
    {
        Mail::fake();
        // Your code that triggers the email sending
        // For example, using the route we defined earlier:
        $recipientEmail = 'admin@yoursoccergames.com';
        $response = $this->get('/test-email');

        // Assert the response is successful
        $response->assertStatus(200);

        // Assert the email was sent to the correct recipient
        Mail::assertSent(TestEmail::class, function ($mail) use ($recipientEmail) {
            return $mail->hasTo($recipientEmail);
        });
    }
}
