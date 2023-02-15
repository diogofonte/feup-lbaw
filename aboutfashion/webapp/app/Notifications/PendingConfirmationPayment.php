<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class PendingConfirmationPayment extends Notification
{
    use Queueable;

    private $order;
    public function __construct($order)
    {
        $this->order = Order::find($order);
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail','database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $address = (is_null($this->order->address)) ? 'Not Defined' : ($this->order->address->street . ', nº' . $this->order->address->number);
        $card = (is_null($this->order->card)) ? 'Not Defined' : ($this->order->card->number);

        return (new MailMessage)
                    ->subject('Order nº'. $this->order->id)
                    ->line('Hello ' . $this->order->user->first_name . '! Your Order nº'. $this->order->id . ' is waiting for payment approval!')
                    ->action('View your order', url('/order/'.$this->order->id))
                    ->line('Address: ' . $address)
                    ->line('Card: '.  $card)
                    ->line('Thank you for shopping on our website!');
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
            'title' => 'Pending payment approval!',
            'text' => 'Your Order '. $this->order->id . ' is waiting for payment approval!',
        ];
    }
}