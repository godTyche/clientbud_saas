<?php

namespace App\Notifications\SuperAdmin;

use App\Models\Company;
use App\Notifications\BaseNotification;

class NewCompanyRegister extends BaseNotification
{


    private $forCompany;

    public $ipAddress;
    public $userAgent;

    /**
     * Create a new notification instance.
     *
     * @return void
     */

    public function __construct(Company $company, $ipAddress, $userAgent)
    {
        $this->forCompany = $company;
        $this->ipAddress = $ipAddress;
        $this->userAgent = $userAgent;
    }

    /**
     * Get the notification's delivery channels.
     *t('mail::layout')
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        $via = ['database'];

        if ($notifiable->email_notifications && $notifiable->email != '') {
            array_push($via, 'mail');
        }

        return $via;
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {

        return parent::build()
            ->subject(__('superadmin.newCompany.subject') . ' ' . config('app.name') . '!')
            ->greeting(__('email.hello') . ' ' . $notifiable->name . '!')
            ->line(__('superadmin.newCompany.text'))
            ->line(__('modules.client.companyName') . ': **' . $this->forCompany->company_name . '**')
            ->line(__('modules.attendance.ipAddress') . ': ' . $this->ipAddress)
            ->line(__('superadmin.userAgent') . ': ' . $this->userAgent)
            ->action(__('email.loginDashboard'), getDomainSpecificUrl(route('superadmin.companies.show', [$this->forCompany->id])))
            ->line(__('email.thankyouNote'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return $this->forCompany->toArray();
    }

}
