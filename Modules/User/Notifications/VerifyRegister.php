<?php

namespace Modules\User\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Modules\User\Models\User;

class VerifyRegister extends Notification
{
    public $user = null;

    /**
     * Create a new notification instance.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Verify Your Email Address')
            ->greeting('Hello ' . $this->user->name . '!')
            ->line('You account has been created at ' . appName() . '!')
            ->line('Please click below button to activate your account.')
            ->action('Verify Account', url('user/register/verify/' . $this->user->confirmation_code))
            ->line('Thank you for registering!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
