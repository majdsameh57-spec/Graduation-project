<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;

class ShopNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $shop;

    public function __construct($shop)
    {
        $this->shop = $shop;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'shop_id' => $this->shop->id,
            'shop_name' => $this->shop->name,
            'url' => route('shops.show', $this->shop->id),
            'message' => 'تم إضافة محل جديد: ' . $this->shop->name,
        ];
    }
}
