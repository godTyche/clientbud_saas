<?php

use App\Models\User;
use App\Helper\Files;
use App\Models\Company;
use App\Models\Contract;
use App\Models\Passport;
use App\Models\VisaDetail;
use App\Models\Appreciation;
use App\Models\ContractSign;
use App\Models\ProposalSign;
use App\Models\SlackSetting;
use App\Models\ClientDetails;
use App\Models\AcceptEstimate;
use App\Models\InvoiceSetting;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // WithoutGlobalScopes
        $files = [];

        foreach ($files as $file) {
            $model = $file['model'];
            $columns = $file['columns'];

            Files::fixLocalUploadFiles($model, $columns);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }

};
