<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

use App\Models\Reply;

class TopicReplied extends Notification implements ShouldQueue
{
    use Queueable;

    public $reply;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Reply $reply)
    {
        //注入回复实体,方便头Database方法中的使用
        $this->reply = $reply;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        // return ['mail'];
        return ['database','mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        // return (new MailMessage)
        //             ->line('The introduction to the notification.')
        //             ->action('Notification Action', url('/'))
        //             ->line('Thank you for using our application!');

        // $url = $this->reply->topic->link(['#reply'.$this->reply->id]);


        $url = "https://www.baidu.com";


        return (new MailMessage)
        ->line('你的话题有新的回复')
        ->action('查看回复',$url);
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
            //
        ];
    }


    public function toDatabase($notifiable)
    {
        $topic = $this->reply->topic;

        $link = $topic->link(['#reply'.$this->reply->id]);

        // 存入在数据库的数据
        return [
            
            'reply_id'=>$this->reply->id,
            'reply_content'=>$this->reply->content,
            'user_id'=>$this->reply->user->id,
            'user_name'=>$this->reply->user->name,
            'user_avatar'=>$this->reply->user->avatar,
            'topic_id'=>$topic->id,
            'topic_title'=>$topic->title,
            'topic_link'=>$link,
        ];
    }
}
