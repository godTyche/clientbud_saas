@push('styles')
    <style>
        pre {
            background: rgba(0, 0, 0, .05);
            padding: 10px;
            border-radius: 5px;
        }
    </style>
@endpush
<!-- ROW START -->
<div class="row">
    @php
        $updateCompanyPackagePermission = user()->permission('update_company_package');
        $manageCompanyImpersonatePermission = user()->permission('manage_company_impersonate');
    @endphp
    @if (!$company->approved && global_setting()->company_need_approval)
        <div class="col-md-12">
            <x-alert type="danger">
                <div class="d-flex justify-content-between align-items-center f-15">
                    @lang('superadmin.companies.companyNeedApproval')

                    <x-forms.button-primary class="approve-company" data-company-id="{{ $company->id }}"
                                            icon="check-circle">
                        @lang('app.approve')
                    </x-forms.button-primary>

                </div>
            </x-alert>
        </div>
    @endif

    <!--  USER CARDS START -->
    <div class="col-md-6 col-xl-4 mb-4 mb-xl-0 mb-lg-4 mb-md-0">
        <div class="row">

            <div class="col-md-12">
                <div class="card border-0 b-shadow-4">
                    <div class="card-horizontal align-items-center">
                        <div class="card-img">
                            <img class="" src="{{ $company->logo_url }}" alt="">
                        </div>
                        <div class="card-body border-0 pl-0">

                            <div class="row">
                                <div class="col-10">
                                    <h4 class="card-title f-15 f-w-500 text-darkest-grey mb-0">
                                        {{ $company->company_name }}
                                    </h4>
                                </div>
                                <div class="col-2 text-right">
                                    <div class="dropdown">
                                        <button class="btn f-14 px-0 py-0 text-dark-grey dropdown-toggle"
                                                type="button" data-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">
                                            <i class="fa fa-ellipsis-h"></i>
                                        </button>

                                        <div
                                            class="dropdown-menu dropdown-menu-right border-grey rounded b-shadow-4 p-0"
                                            aria-labelledby="dropdownMenuLink" tabindex="0">
                                            <a class="dropdown-item openRightModal"
                                               href="{{ route('superadmin.companies.edit', $company->id) }}">@lang('app.edit')</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <p class="card-text f-11 text-lightest mb-0">@lang('app.createdOn') :
                                {{ $company->created_at->timezone(global_setting()->timezone)->translatedFormat(global_setting()->date_format . ' ' . global_setting()->time_format) }}
                            </p>
                            <p class="card-text f-11 text-lightest">@lang('app.lastLogin')

                                @if (!is_null($company->last_login))
                                    {{ $company->last_login->timezone(global_setting()->timezone)->translatedFormat(global_setting()->date_format . ' ' . global_setting()->time_format) }}
                                @else
                                    --
                                @endif
                            </p>
                        </div>
                    </div>

                </div>

            </div>

        </div>
    </div>
    <!--  USER CARDS END -->

    <!--  USER CARDS START -->
    <div class="col-md-6 col-xl-4 mb-4 mb-xl-0 mb-lg-4 mb-md-0">
        @if($company->user)
            <x-cards.user :image="$company->user->image_url">
                <div class="row mb-1">
                    <div class="col-12">
                        <h4 class="card-title f-15 f-w-500 text-darkest-grey mb-0">
                            {{ ($company->user->salutation ? $company->user->salutation->label() . ' ' : '') . $company->user->name }}
                            @if(global_setting()->email_verification)
                                @if(is_null($company->user->userAuth->email_verified_at))
                                    <i class="fa fa-times-circle text-red" data-toggle="tooltip"
                                       data-original-title="@lang('superadmin.notVerifiedEmail')"></i>
                                @else
                                    <i class="fa fa-check-circle text-success" data-toggle="tooltip"
                                       data-original-title="@lang('superadmin.verifiedEmail')"></i>
                                @endif
                            @endif
                        </h4>
                    </div>
                </div>
                @if ($company->user->country)
                    <p class="f-12 font-weight-normal text-dark-grey mb-1">
                        <span
                            class='flag-icon flag-icon-{{ $company->user->country->iso }} flag-icon-squared'></span> {{ $company->user->country->nicename }}
                    </p>
                @endif

                <p class="card-text f-12 text-lightest">@lang('app.lastLogin')

                    @if (!is_null($company->user->last_login))
                        {{ $company->user->last_login->timezone(global_setting()->timezone)->translatedFormat(global_setting()->date_format . ' ' . global_setting()->time_format) }}
                    @else
                        --
                    @endif
                </p>
            </x-cards.user>
        @else
            <x-cards.user :image="'https://www.gravatar.com/avatar/noimage.png?s=200&d=mp'">
                <div class="card-text f-12 text-lightest m-t-5">There is no active company admin for this company</div>
            </x-cards.user>
        @endif
    </div>
    <!--  USER CARDS END -->

    <!--  WIDGETS START -->
    <div class="col-xl-4 col-md-12">
        <x-cards.data>
            <div class="row">
                <div class="col-12">
                    <h4 class="card-title f-15 f-w-500 text-darkest-grey mb-1">
                        @lang('superadmin.package'): {{ $company->package->name }}
                    </h4>
                </div>
            </div>
            <p class="card-text f-12 text-lightest mb-2">
                @lang('superadmin.licenceExpiresOn')
                @if (!is_null($company->licence_expire_on))
                    <span class="font-weight-bold">
                        {{ \Carbon\Carbon::parse($company->licence_expire_on)->timezone(global_setting()->timezone)->translatedFormat(global_setting()->date_format) }}
                    </span>
                    <em>({{ \Carbon\Carbon::parse($company->licence_expire_on)->diffForHumans() }})</em>
                @else
                    --
                @endif
            </p>
            <p class="card-text d-flex justify-content-between f-12 text-lightest">
                @if($updateCompanyPackagePermission == 'all')
                    <a href="{{ route('superadmin.companies.edit_package', [$company->id]) }}?requestFrom=show"
                       class="btn btn-primary rounded f-12 px-2 py-1 openRightModal">
                        <i class="fa fa-edit mr-1"></i> @lang('app.update') @lang('superadmin.package')
                    </a>
                @endif
                @if($manageCompanyImpersonatePermission == 'all')
                    <button type="button" id="login-as-company"
                            class="btn btn-outline-secondary rounded f-12 ml-2 py-1">
                        <i class="fa fa-sign-in-alt mr-1"></i> @lang('superadmin.superadmin.loginAsCompany')
                    </button>
                @endif
            </p>
        </x-cards.data>
    </div>
    <!--  WIDGETS END -->
</div>
<!-- ROW END -->

<!-- ROW START -->
<div class="row mt-4">
    <div class="col-xl-8 col-lg-7 col-md-6 mb-4 mb-xl-0 mb-lg-4">
        <x-cards.data :title="__('modules.client.companyDetails')">
            <x-cards.data-row :label="__('modules.accountSettings.companyEmail')" :value="$company->company_email"/>
            <x-cards.data-row :label="__('modules.accountSettings.companyPhone')"
                              :value="$company->company_phone ?? '--'"/>

            <div class="col-12 px-0 pb-3 d-lg-flex d-md-flex d-block">
                <p class="mb-0 text-lightest f-14 w-30 text-capitalize">{{ __('modules.accountSettings.companyWebsite') }}</p>
                <p class="mb-0 text-dark-grey f-14 w-70 text-wrap">
                    <a href="{{ $company->website }}" target="_blank">{{ $company->website }}</a>
                </p>
            </div>

            <x-cards.data-row :label="__('modules.accountSettings.companyAddress')"
                              :value="isset($company->defaultAddress) ? $company->defaultAddress->address : '--'"
                              html="true"/>
            <x-cards.data-row :label="__('modules.accountSettings.defaultCurrency')"
                              :value="$company->currency->currency_code . ' (' . $company->currency->currency_symbol . ')'"/>
            <x-cards.data-row :label="__('modules.accountSettings.defaultTimezone')" :value="$company->timezone"/>
            @if (module_enabled('Subdomain'))

                <div class="col-12 px-0 pb-3 d-lg-flex d-md-flex d-block">
                    <p class="mb-0 text-lightest f-14 w-30 text-capitalize">Subdomain</p>
                    @if($company->sub_domain)
                        <div class="mb-0 text-dark-grey f-14 w-70 text-wrap  p-0"><a
                                href="http://{{ $company->sub_domain }}" class="text-dark-grey"
                                target="_blank">{{ $company->sub_domain }}</a></div>
                    @else
                        <p class="mb-0 f-14 text-red">
                            {{__('superadmin.subdomainNotAdded')}}
                        </p>
                    @endif

                </div>

            @endif

            <div class="col-12 px-0 pb-3 d-block d-lg-flex d-md-flex">
                <p class="mb-0 text-lightest f-14 w-30 d-inline-block text-capitalize">
                    @lang('app.status')</p>
                <p class="mb-0 text-dark-grey f-14 w-70">
                    @if ($company->status == 'active')
                        <i class="fa fa-circle mr-1 text-dark-green f-10"></i>
                    @else
                        <i class="fa fa-circle mr-1 text-red f-10"></i>
                    @endif
                    {{ __('app.'.$company->status) }}
                </p>
            </div>

            @if (global_setting()->company_need_approval)
                <div class="col-12 px-0 pb-3 d-block d-lg-flex d-md-flex">
                    <p class="mb-0 text-lightest f-14 w-30 d-inline-block text-capitalize">
                        @lang('app.approved')</p>
                    <p class="mb-0 text-dark-grey f-14 w-70">
                        @if ($company->approved == 1)
                            <i class="fa fa-circle mr-1 text-dark-green f-10"></i> @lang('app.yes')
                        @else
                            <i class="fa fa-circle mr-1 text-red f-10"></i> @lang('app.no')
                        @endif
                    </p>
                </div>
            @endif

            @if (!is_null($company->approved_by))
                <div class="col-12 px-0 pb-3 d-block d-lg-flex d-md-flex">
                    <p class="mb-0 text-lightest f-14 w-30 d-inline-block text-capitalize">
                        @lang('superadmin.companies.approvedChangedBy')</p>

                    <div class="media align-items-center mw-250">
                        <img src="{{ $company->approvalBy->image_url }}" class="mr-2 taskEmployeeImg rounded-circle"
                             alt="{{ $company->approvalBy->name }}"
                             title="{{ $company->approvalBy->userBadge() }}">

                        <div class="media-body {{$company->approvalBy->status}}">

                            <h5 class="mb-0 f-12">
                                {!! $company->approvalBy->userBadge() !!}
                            </h5>
                        </div>
                    </div>

                </div>
            @endif

        </x-cards.data>
    </div>

    <div class="col-xl-4 col-lg-7 col-md-6 mb-4 mb-xl-0 mb-lg-4">
        @php
            $storage = __('superadmin.notUsed');
            if ($company->file_storage_count && $company->file_storage_sum_size) {
                if ($company->package->storage_unit == 'mb') {
                    $storage = \App\Models\SuperAdmin\Package::bytesToMB($company->file_storage_sum_size) . ' ' . __('superadmin.mb');
                } else {
                    $storage = \App\Models\SuperAdmin\Package::bytesToGB($company->file_storage_sum_size)  . ' ' . __('superadmin.gb');
                }
            }

            $maxStorage = __('superadmin.unlimited');
            if ($company->package->max_storage_size != -1) {
                $maxStorage = $company->package->max_storage_size . ' ' . strtoupper($company->package->storage_unit);
            }
        @endphp
        <x-cards.data :title="__('app.statistics')" padding="false">
            <x-table class="table-hover">
                <tr>
                    <td class="pl-20">@lang('app.menu.employees')</td>
                    <td
                        class="text-right pr-20 {{ $company->employees_count >= $company->package->max_employees ? 'text-danger' : '' }}">
                        {{ $company->employees_count . ' / ' . $company->package->max_employees }}</td>
                </tr>
                <tr>
                    <td class="pl-20">@lang('superadmin.storage')</td>
                    <td class="text-right pr-20">{{ $storage . ' / ' . $maxStorage }}</td>
                </tr>
                <tr>
                    <td class="pl-20">@lang('app.menu.clients')</td>
                    <td class="text-right pr-20">{{ $company->clients_count }}</td>
                </tr>
                <tr>
                    <td class="pl-20">@lang('app.menu.invoices')</td>
                    <td class="text-right pr-20">{{ $company->invoices_count }}</td>
                </tr>
                <tr>
                    <td class="pl-20">@lang('app.menu.estimates')</td>
                    <td class="text-right pr-20">{{ $company->estimates_count }}</td>
                </tr>
                <tr>
                    <td class="pl-20">@lang('app.menu.projects')</td>
                    <td class="text-right pr-20">{{ $company->projects_count }}</td>
                </tr>
                <tr>
                    <td class="pl-20">@lang('app.menu.tasks')</td>
                    <td class="text-right pr-20">{{ $company->tasks_count }}</td>
                </tr>
                <tr>
                    <td class="pl-20">@lang('app.menu.leads')</td>
                    <td class="text-right pr-20">{{ $company->leads_count }}</td>
                </tr>
                <tr>
                    <td class="pl-20">@lang('app.menu.orders')</td>
                    <td class="text-right pr-20">{{ $company->orders_count }}</td>
                </tr>
                <tr>
                    <td class="pl-20">@lang('app.menu.tickets')</td>
                    <td class="text-right pr-20">{{ $company->tickets_count }}</td>
                </tr>
                <tr>
                    <td class="pl-20">@lang('app.menu.contracts')</td>
                    <td class="text-right pr-20">{{ $company->contracts_count }}</td>
                </tr>
            </x-table>
        </x-cards.data>
    </div>
</div>

<!-- ROW END -->


<script>
    $('body').on('click', '#login-as-company', function () {
        Swal.fire({
            title: `@lang('messages.sweetAlertTitle')`,
            text: `@lang('superadmin.loginInfo')`,
            icon: 'warning',
            showCancelButton: true,
            focusConfirm: false,
            confirmButtonText: `@lang('app.login')`,
            cancelButtonText: `@lang('app.cancel')`,
            customClass: {
                confirmButton: 'btn btn-primary mr-3',
                cancelButton: 'btn btn-secondary'
            },
            showClass: {
                popup: 'swal2-noanimation',
                backdrop: 'swal2-noanimation'
            },
            buttonsStyling: false
        }).then((result) => {
            if (result.isConfirmed) {
                const url = "{{ route('superadmin.companies.login_as_company', $company->id) }}";

                const token = "{{ csrf_token() }}";

                $.easyAjax({
                    type: 'POST',
                    url: url,
                    blockUI: true,
                    data: {
                        '_token': token
                    },
                    success: function (response) {
                        if (response.status == "success") {
                            location.href = "{{ route('dashboard') }}"
                        }
                    }
                });
            }
        });
    });

    $('body').on('click', '.approve-company', function () {
        var companyId = $(this).data('company-id');

        Swal.fire({
            title: `@lang('messages.sweetAlertTitle')`,
            icon: 'warning',
            showCancelButton: true,
            focusConfirm: false,
            confirmButtonText: `@lang('app.approve')`,
            cancelButtonText: `@lang('app.cancel')`,
            customClass: {
                confirmButton: 'btn btn-primary mr-3',
                cancelButton: 'btn btn-secondary'
            },
            showClass: {
                popup: 'swal2-noanimation',
                backdrop: 'swal2-noanimation'
            },
            buttonsStyling: false
        }).then((result) => {
            if (result.isConfirmed) {
                var url = "{{ route('superadmin.companies.approve_company') }}";

                var token = "{{ csrf_token() }}";

                $.easyAjax({
                    type: 'POST',
                    url: url,
                    blockUI: true,
                    data: {
                        '_token': token,
                        'companyId': companyId
                    },
                    success: function (response) {
                        if (response.status == "success") {
                            window.location.reload();
                        }
                    }
                });
            }
        });
    });
</script>
