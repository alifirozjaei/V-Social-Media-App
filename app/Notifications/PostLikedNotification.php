<?php

namespace App\Notifications;

use App\Post;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PostLikedNotification extends Notification implements ShouldQueue
{
    use Queueable;
    public $post;
    public $user;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Post $post, User $user)
    {
        $this->post = $post;
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return !!$notifiable->email_on_like ? ['mail', 'database'] : ['database'];
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
            ->subject('پست شما لایک شد!')
            ->line(
                ' کاربر '
                    . $this->user->name
                    . "(نام کاربری: {$this->user->username})"
                    . "پست {$this->post->title} را لایک کرد."
            )
            ->action('مشاهده پست ', url("post/" . $this->post->slug))
            ->line('ممنون از اینکه از اپلیکیشن ما استفاده میکنید');
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
            'text' =>
            //  $this->user->name
            // . " ({$this->user->username}) "
            "{$this->user->username} "
                . "پست {$this->post->title} را لایک کرد.",

            'link' => "post/" . $this->post->slug
        ];
    }
}
