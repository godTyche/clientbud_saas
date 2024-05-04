<?php

namespace App\Listeners\SuperAdmin;

use App\Events\NewCompanyCreatedEvent;
use App\Models\User;
use App\Notifications\SuperAdmin\NewCompanyRegister;
use App\Scopes\CompanyScope;
use Illuminate\Support\Facades\Notification;
use GuzzleHttp\Client;

class CompanyRegisteredListener
{

    /**
     * Handle the event.
     *
     * @param NewCompanyCreatedEvent $event
     * @return true
     */
    public function handle(NewCompanyCreatedEvent $event)
    {
        if (isRunningInConsoleOrSeeding()) {
            return true;
        }

        $company = $event->company;

        $ipAddress = request()->getClientIp();
        $userAgent = request()->userAgent();

        $generatedBy = User::withoutGlobalScopes([CompanyScope::class])
            ->whereNull('company_id')
            ->where('is_superadmin', 1)
            ->where('status', 'active')
            ->get();

        Notification::send($generatedBy, new NewCompanyRegister($company, $ipAddress, $userAgent));
    }


}
