<?php

namespace App\Notifications;

use App\Mail\LoyaltyPointsReceivedMailable;
use App\Models\LoyaltyPointsTransaction;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class LoyaltyPointsReceived extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(private LoyaltyPointsTransaction $transaction) {}

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
        return (new LoyaltyPointsReceivedMailable($this->transaction->points_amount, $notifiable->getBalance()))
            ->to($notifiable->email);
    }

    public function toSms($notifiable)
    {
        // instead SMS component
        Log::info(("\n\tYou received: " . $this->transaction->points_amount . "\n\tYour balance: " . $notifiable->getBalance()));
    }
}
