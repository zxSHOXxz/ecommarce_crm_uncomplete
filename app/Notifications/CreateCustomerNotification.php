<?php

namespace App\Notifications;

use App\Notifications\Traits\SetDataForNotifications;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CreateCustomerNotification extends Notification implements ShouldQueue, ShouldBroadcast
{
    use SetDataForNotifications;
    use Queueable;

    public $tries = 2;
    public $timeout = 10;
    protected $customer;
    /**
     * Create a new notification instance.
     *
     * @param string $subject
     * @param string $greeting
     * @param array $methods
     * @param string $content
     * @return void
     */
    public function __construct(string $subject, string $greeting, array $methods, string $content, $customer)
    {
        $this->subject = $subject;
        $this->greeting = $greeting;
        $this->actionUrl = env("APP_URL");
        $this->actionText = env("APP_NAME");
        $this->methods = $methods;
        $this->image = env("DEFAULT_IMAGE_AVATAR");
        $this->content = $content;
        $this->customer = $customer;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return $this->methods;
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject($this->subject)
            ->greeting($this->greeting)
            ->line($this->content)
            ->action($this->actionText, $this->actionUrl);
    }


    public function broadcastOn()
    {
        return ['my-channel'];
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
            'subject' =>  $this->subject,
            'image' => $this->image,
            'content' => $this->content,
            'greeting' => $this->greeting,
        ];
    }
}
