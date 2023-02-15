<?php

namespace App\Notifications;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ChangePriceWishlist extends Notification
{
    use Queueable;

    private $product;

    public function __construct($product)
    {
        $this->product = $product;
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
        return (new MailMessage)
                    ->subject('Product '. $this->product->name .' has changed price')
                    ->line('The product '.$this->product->name.' in your wishlist has changed its price to '.$this->product->price)
                    ->action('View Product', url('/products/'.$this->product->id))
                    ->line('Thank you for using our application!');
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
            'title' => 'Changed Product Price',
            'text' => 'The product '.$this->product->name.' in your wishlist has changed its price to '.$this->product->price,
        ];
    }
}