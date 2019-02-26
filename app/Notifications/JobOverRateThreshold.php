<?php

namespace App\Notifications;

use App\Job;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class JobOverRateThreshold extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * @var Job
     */
    protected $job;

    /**
     * Create a new notification instance.
     *
     * @param Job $job
     */
    public function __construct(Job $job)
    {
        $this->job = $job;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed $notifiable
     *
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed $notifiable
     *
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('New interesting job on Upwork')
            ->line('A new job with the title "' . $this->job->title . '"')
            ->action('Go to Upwork', $this->job->url)
            ->cc(config('notifications.cc'));
    }
}
