<?php

namespace App\Notifications;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserFollowNotification extends Notification implements ShouldQueue
{
    use Queueable;
    public $user;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
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
        return !!$notifiable->email_on_follow ?  ['mail', 'database'] : ['database'];
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
            ->subject('شما دنبال کننده جدید دارید!')
            ->line(
                ' کاربر '
                    . $this->user->name
                    . "(نام کاربری: {$this->user->username})"
                    . ' شما را دنبال می کند. '
            )
            ->action('مشاهده پروفایل کاربر ', url("@" . $this->user->username))
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
            // $this->user->name
            "{$this->user->username}"
                . ' شما را دنبال می کند. ',
            'link' => "@" . $this->user->username
        ];
    }
}
