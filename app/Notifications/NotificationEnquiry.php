<?php

namespace App\Notifications;

use App\Models\User;
use App\Notifications\admin\NotifyAdmin;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Notification as FacadesNotification;

class NotificationEnquiry extends Notification
{
    use Queueable;
    protected ?User $user;
    protected ?string $message;
    protected ?int $product_id;

    public function __construct(User $user, string $message, int $product_id)
    {
        $this->user = $user;
        $this->message = $message;
        $this->product_id = $product_id;
    }

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }


    public function toMail(object $notifiable): MailMessage
    {
        $this->notify_admin();
        return (new MailMessage)
            ->line("You have made enquiry about the property, id: {$this->product_id}")
            ->action(
                'Click to see the property you made enquiry of',
                url("/prod_view/{$this->product_id}")
            )
            ->line("We will come back to you in 3 working days.")
            ->line('Thank you for using our application!');
    }

    private function notify_admin(): void
    {
        $users = User::where('role', 'admin')->get();
        if (!empty($users)) {
            FacadesNotification::send($users, new NotifyAdmin($this->user, $this->product_id));
        }
    }

    public function toArray(object $notifiable): array
    {
        return [
            'to' => $notifiable->email,
            'user_id' => $this->user->id,
            'product_id' => $this->product_id,
            'message' => $this->message,
        ];
    }
}
