<?php

namespace Satis2020\ServicePackage\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Satis2020\ServicePackage\Channels\MessageChannel;

/**
 * Class RegisterAClaim
 * @package Satis2020\ServicePackage\Notifications
 */
class RegisterAClaim extends Notification implements ShouldQueue
{
    use Queueable, \Satis2020\ServicePackage\Traits\Notification;

    public $claim;
    public $event;

    /**
     * Create a new notification instance.
     *
     * @param $claim
     */
    public function __construct($claim)
    {
        $this->claim = $claim;

        $this->event = $this->getNotification('register-a-claim');

        $this->event->text = str_replace('{claim_reference}', $this->claim->reference, $this->event->text);

        if ($claim->claimObject && $claim->claimObject!=null){
            $this->event->text = str_replace('{claim_object}', $this->claim->claimObject->name, $this->event->text);
        }else{
            $this->event->text = str_replace('{claim_object}', '--', $this->event->text);
        }

        $this->event->text = str_replace('{claim_status}', $this->claim->status, $this->event->text);
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        $preferredChannels = $this->getFeedBackChannels($notifiable->staff);
        return collect([$preferredChannels, ['database', 'broadcast']])->collapse()->all();
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
            ->subject('Réclamation enregistrée')
            ->markdown('ServicePackage::mail.claim.feedback', [
                'text' => $this->event->text,
                'name' => "{$notifiable->firstname} {$notifiable->lastname}"
            ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        return [
            'text' => $this->event->text,
            'claim' => $this->claim
        ];
    }

    /**
     * Get the broadcastable representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return BroadcastMessage
     */
    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'text' => $this->event->text,
            'claim' => $this->claim
        ]);
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

    /**
     * Get the message representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toMessage($notifiable)
    {
        return [
            'to' => $notifiable->staff->institution->iso_code.$notifiable->telephone[0],
            'text' => $this->event->text,
            'institutionMessageApi' => $notifiable->staff->institution->institutionMessageApi
        ];
    }
}
