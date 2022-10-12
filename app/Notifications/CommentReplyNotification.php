<?php

namespace App\Notifications;

use App\Comment;
use App\Post;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CommentReplyNotification extends Notification implements ShouldQueue
{
    use Queueable;
    public $user;
    public $replyUser;
    public $post;
    public $replyComment;
    public $comment;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(User $user, User $replyUser, Post $post, Comment $comment, Comment $replyComment)
    {
        $this->user = $user;
        $this->replyUser = $replyUser;
        $this->post = $post;
        $this->comment = $comment;
        $this->replyComment = $replyComment;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return (!!$notifiable->email_on_reply) && $this->replyUser->id != $notifiable->id  ? ['mail', 'database'] : ['database'];
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
            ->subject('یه نظر شما پاسخی داده شده است!')
            ->line(
                ' کاربر '
                    . $this->replyUser->name
                    . "(نام کاربری: {$this->replyUser->username})"
                    . ' به نظر شما در پست '
                    . $this->post->title
                    . " پاسخ داد. "
            )
            ->action('مشاهده پست ', url("post/" . $this->post->slug))
            ->line("نظر شما :")
            ->line($this->comment->content)
            ->line('پاسخ داده شده :')
            ->line($this->replyComment->content)
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
            // $this->replyUser->name
            // . "({$this->replyUser->username})"
            " {$this->replyUser->username} "
                . ' به نظر شما در پست '
                . $this->post->title
                . " پاسخ داد. ",
            "link" => "post/" . $this->post->slug
        ];
    }
}
