<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\SlackMessage; // 追記

class SlackNotification extends Notification
{
    use Queueable;

    protected $channel;  //追記
    protected $name; //追記
    protected $message; //追記

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($message = null) //追記
    {
        $this->channel = env('SLACK_CHANNEL'); //追記
        $this->name = env('SLACK_NAME'); //追記
        $this->message = $message; //追記
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['slack']; //slackに設定
    }

    /**
     * Slack通知表現を返します
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\SlackMessage
     */
    public function toSlack($notifiable) //追記
    {
        $message = (new SlackMessage)
            ->from($this->name)
            ->to($this->channel)
            ->content($this->message);

        return $message;
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
}
