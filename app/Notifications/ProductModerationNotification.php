<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ProductModerationNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $product;
    protected $status;

    public function __construct($product, $status)
    {
        $this->product = $product;
        $this->status = $status;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->greeting('Здравствуйте!')
            ->line("Ваш продукт '{$this->product->name}' был {$this->status}.")
            ->line('Спасибо за использование нашего сервиса!');
    }

    public function toArray($notifiable)
    {
        return [
            'product_id' => $this->product->id,
            'status' => $this->status,
        ];
    }
}
