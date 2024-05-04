<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\SlackMessage;
use NotificationChannels\OneSignal\OneSignalChannel;
use NotificationChannels\OneSignal\OneSignalMessage;

class TimeTrackerReminder extends BaseNotification
{

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    private $event;

    public function __construct($event)
    {
        $this->company = $event->company;
        $this->event = $event;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array
     */
    public function via($notifiable)
    {
        $via = ['mail', 'database', OneSignalChannel::class];

        if ($this->company->slackSetting->status == 'active') {
            $this->slackUserNameCheck($notifiable) ? array_push($via, 'slack') : null;
        }

        return $via;
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return MailMessage
     */
    // phpcs:ignore
    public function toMail($notifiable): MailMessage
    {
        $build = parent::build();
        $url = route('tasks.index') . '?assignedTo=' . $notifiable->id;
        $url = getDomainSpecificUrl($url, $this->company);
        $greeting = __('email.trackerReminder.dear') . ' <strong>' . $notifiable->name . '</strong>,' . '<br>';
        $content = $greeting . __('email.trackerReminder.text');

        return $build
            ->subject(__('email.trackerReminder.subject'))
            ->markdown('mail.email', [
                'url' => $url,
                'content' => $content,
                'themeColor' => $this->company->header_color,
                'actionText' => __('email.trackerReminder.action')
            ]);
    }

    public function toArray()
    {
        return [
            'id' => $this->event->id,
        ];
    }

    public function toSlack($notifiable) // phpcs:ignore
    {

        return $this->slackBuild($notifiable)
            ->content('>*' . __('email.trackerReminder.subject') . '*' . "\n" . __('email.trackerReminder.text') . ' ');
    }

    // phpcs:ignore
    public function toOneSignal($notifiable)
    {
        return OneSignalMessage::create()
            ->setSubject(__('email.trackerReminder.subject'))
            ->setBody(__('email.trackerReminder.text'));
    }

}
