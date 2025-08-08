<?php

namespace App\Notifications;

use App\Models\article;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ArticlePendingNotification extends Notification
{
    use Queueable;

    public $article;



    /**
     * Create a new notification instance.
     */
    public function __construct(article $article)
    {
        $this->article = $article;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toDatabase($notifiable)
    {
        return [
            'title' => 'مقال جديد بانتظار المراجعة',
            'body' => auth()->user()->name  . ' بواسطة ' .  $this->article->title . 'تم إرسال مقال بعنوان ',
            'article_id' => $this->article->id,
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
