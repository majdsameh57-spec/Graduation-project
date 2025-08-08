<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;

class ProductNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $product;

    public function __construct($product)
    {
        $this->product = $product;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        $shopUrl = route('shops.show', $this->product->shop_id);
        $productAnchor = '#product-' . $this->product->id;
        $url = $shopUrl . $productAnchor;
        return [
            'product_id' => $this->product->id,
            'product_name' => $this->product->name,
            'shop_id' => $this->product->shop_id,
            'url' => $url,
            'message' => 'تم إضافة منتج جديد: ' . $this->product->name,
        ];
    }
}
