<?php

namespace vultrui\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\SlackMessage;

class BlockStorageDeleted extends Notification
{
    use Queueable;


    protected $blockstorage_id;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    
    public function __construct( $blockstorage_id )
    {
        $this->blockstorage_id = $blockstorage_id;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return $notifiable->prefer_slack() ? ['slack'] : [];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    /*public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }*/

    public function toSlack($notifiable)
    {

        return (new SlackMessage)
                ->warning()
                ->content('Block Storage (ID: '.$this->blockstorage_id.') has been deleted - ('.$notifiable->slug().')' );

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
            'blockstorage_id' => $this->blockstorage_id
        ];
    }
}
