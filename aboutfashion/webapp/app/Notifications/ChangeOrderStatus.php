<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ChangeOrderStatus extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */

     private $order;
    public function __construct($order)
    {
        $this->order = $order;
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
                    ->subject('Order nº'. $this->order->id . ' - ' . $this->order->status)
                    ->line('Hello ' . $notifiable->first_name . '! Your Order nº'. $this->order->id . ' has changed its status to ' . $this->order->status.'.')
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
            'title' => 'Change Order Status',
            'text' => 'Your Order '. $this->order->id . ' has changed its status to ' . $this->order->status.'.',
        ];
    }
}