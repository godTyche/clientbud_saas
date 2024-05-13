@include('import.process-form', [
    'headingTitle' => __('app.importExcel') . ' ' . __('app.menu.lead'),
    'processRoute' => route('lead-contact.import.process'),
    'backRoute' => auth()->user()->user->is_superadmin ? route('superadmin.companies.index') : route('lead-contact.index'),
    'backButtonText' => auth()->user()->user->is_superadmin ? __('superadmin.backToCompanies') : __('app.backToLead'),
    'clients' => $clients,
    'companies' => $companies
])
