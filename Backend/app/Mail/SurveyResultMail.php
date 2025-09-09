<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Survey;

class SurveyResultMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data; // Survey model

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->data->subject ?? 'Survey Result',
        );
    }

    public function content(): Content
    {
        $url = url("http://localhost:5173/formanswer/main/{$this->data->id}");
        return new Content(
            view: 'emails.survey_result',
            with: [
                'survey' => $this->data,
                'url' => $url,
            ]
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
