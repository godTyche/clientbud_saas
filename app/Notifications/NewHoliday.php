<?php

namespace App\Notifications;

use App\Models\Holiday;
use App\Models\EmailNotificationSetting;

class NewHoliday extends BaseNotification
{

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    private $holiday;
    private $emailSetting;

    public function __construct(Holiday $holiday)
    {
        $this->holiday = $holiday;
        $this->company = $this->holiday->company;
        $this->emailSetting = EmailNotificationSetting::where('company_id', $this->company->id)->where('slug', 'holiday-notification')->first();
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array
     */
    public function via($notifiable)
    {
        $via = [];

        if ($this->emailSetting->send_slack == 'yes' && $this->company->slackSetting->status == 'active') {
            $this->slackUserNameCheck($notifiable) ? array_push($via, 'slack') : null;
        }

        return $via;
    }

    public function toSlack($notifiable)
    {
        return $this->slackBuild($notifiable)
            ->content(__('email.holidays.subject') . "\n" . $notifiable->name . "\n" . '*' . __('app.date') . '*: ' . $this->holiday->date->format($this->company->date_format) . "\n" . __('modules.holiday.occasion') . ': ' . $this->holiday->occassion);

    }

}
