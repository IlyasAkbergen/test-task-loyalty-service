<?php

namespace App\Notifications;

use App\Mail\AccountDeactivatedMailable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class AccountDeactivated extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        $channels = [];
        if ($notifiable?->email && $notifiable?->email_notification) {
            array_push($channels, 'mail');
        }

        if ($notifiable?->phone && $notifiable?->phone_notification) {
            array_push($channels, CustomSmsChannel::class);
        }

        return $channels;
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     */
    public function toMail($notifiable)
    {
        return (new AccountDeactivatedMailable())
            ->to($notifiable->email);
    }

    public function toSms($notifiable)
    {
        // instead SMS component
        Log::info('Account: phone: ' . $notifiable->phone . ' ' . ($notifiable->active ? 'Activated' : 'Deactivated'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
