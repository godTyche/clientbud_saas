<script src="{{ asset('vendor/jquery/Chart.min.js') }}"></script>
<style>
    .card-img {
        width: 120px;
        height: 120px;
    }

    .card-img img {
        width: 120px;
        height: 120px;
        object-fit: cover;
    }
    .appreciation-count {
        top: -6px;
        right: 10px;
    }

</style>
@php

$showFullProfile = false;

if ($viewPermission == 'all'
    || ($viewPermission == 'added' && $employee->employeeDetail->added_by == user()->id)
    || ($viewPermission == 'owned' && $employee->employeeDetail->user_id == user()->id)
    || ($viewPermission == 'both' && ($employee->employeeDetail->user_id == user()->id || $employee->employeeDetail->added_by == user()->id))
) {
    $showFullProfile = true;
}

@endphp

@php
$editEmployeePermission = user()->permission('edit_employees');
$viewAppreciationPermission = user()->permission('view_appreciation');
@endphp

<div class="d-lg-flex">

    <div class="project-left w-100 py-0 py-lg-5 py-md-0">
        <!-- ROW START -->
        <div class="row">
            <!--  USER CARDS START -->
            <div class="col-lg-12 col-md-12 mb-4 mb-xl-0 mb-lg-4 mb-md-0">
                <div class="row">
                    <div class="col-xl-6 col-md-6 mb-4 mb-lg-0">

                        <x-cards.user :image="$employee->image_url">
                            <div class="row">
                                <div class="col-10">
                                    <h4 class="card-title f-15 f-w-500 text-darkest-grey mb-0">
                                        {{ ($employee->salutation ? $employee->salutation->label() . ' ' : '') . $employee->name }}
                                        @isset($employee->country)
                                            <x-flag :country="$employee->country" />
                                        @endisset
                                    </h4>
                                </div>
                                @if ($editEmployeePermission == 'all' || ($editEmployeePermission == 'added' && $employee->employeeDetail->added_by == user()->id))
                                    <div class="col-2 text-right">
                                        <div class="dropdown">
                                            <button class="btn f-14 px-0 py-0 text-dark-grey dropdown-toggle"
                                                type="button" data-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">
                                                <i class="fa fa-ellipsis-h"></i>
                                            </button>

                                            <div class="dropdown-menu dropdown-menu-right border-grey rounded b-shadow-4 p-0"
                                                aria-labelledby="dropdownMenuLink" tabindex="0">
                                                <a class="dropdown-item openRightModal"
                                                    href="{{ route('employees.edit', $employee->id) }}">@lang('app.edit')</a>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                            </div>

                            <p class="f-13 font-weight-normal text-dark-grey mb-0">
                                {{ !is_null($employee->employeeDetail) && !is_null($employee->employeeDetail->designation) ? $employee->employeeDetail->designation->name : '' }}
                                &bull;
                                {{ isset($employee->employeeDetail) && !is_null($employee->employeeDetail->department) && !is_null($employee->employeeDetail->department) ? $employee->employeeDetail->department->team_name : '' }}
                            </p>

                            @if ($employee->status == 'active')
                                <p class="card-text f-12 text-lightest">@lang('app.lastLogin')

                                    @if (!is_null($employee->last_login))
                                        {{ $employee->last_login->timezone(company()->timezone)->format(company()->date_format . ' ' . company()->time_format) }}
                                    @else
                                        --
                                    @endif
                                </p>

                            @else
                                <p class="card-text f-12 text-lightest">
                                    <x-status :value="__('app.inactive')" color="red" />
                                </p>
                            @endif

                            @if ($showFullProfile)
                                <div class="card-footer bg-white border-top-grey pl-0">
                                    <div class="d-flex flex-wrap justify-content-between">
                                        <span>
                                            <label class="f-11 text-dark-grey mb-12 text-capitalize"
                                                for="usr">@lang('app.open') @lang('app.menu.tasks')</label>
                                            <p class="mb-0 f-18 f-w-500">{{ $employee->open_tasks_count }}</p>
                                        </span>
                                        <span>
                                            <label class="f-11 text-dark-grey mb-12 text-capitalize"
                                                for="usr">@lang('app.menu.projects')</label>
                                            <p class="mb-0 f-18 f-w-500">{{ $employee->member_count }}</p>
                                        </span>
                                        <span>
                                            <label class="f-11 text-dark-grey mb-12 text-capitalize"
                                                for="usr">@lang('modules.employees.hoursLogged')</label>
                                            <p class="mb-0 f-18 f-w-500">{{ $hoursLogged }}</p>
                                        </span>
                                        <span>
                                            <label class="f-11 text-dark-grey mb-12 text-capitalize"
                                                for="usr">@lang('app.menu.tickets')</label>
                                            <p class="mb-0 f-18 f-w-500">{{ $employee->agents_count }}</p>
                                        </span>
                                    </div>
                                </div>
                            @endif
                        </x-cards.user>

                        @if ($employee->employeeDetail->about_me != '')
                            <x-cards.data :title="__('app.about')" class="mt-4">
                                <div>{{ $employee->employeeDetail->about_me }}</div>
                            </x-cards.data>
                        @endif


                        <x-cards.data :title="__('modules.client.profileInfo')" class=" mt-4">
                            <x-cards.data-row :label="__('modules.employees.employeeId')"
                                :value="(!is_null($employee->employeeDetail) && !is_null($employee->employeeDetail->employee_id)) ? $employee->employeeDetail->employee_id : '--'" />

                            <x-cards.data-row :label="__('modules.employees.fullName')"
                                :value="$employee->name" />

                            <x-cards.data-row :label="__('app.email')" :value="$employee->email" />

                            <x-cards.data-row :label="__('app.designation')"
                                :value="(!is_null($employee->employeeDetail) && !is_null($employee->employeeDetail->designation)) ? $employee->employeeDetail->designation->name : '--'" />

                            <x-cards.data-row :label="__('app.department')"
                                :value="(isset($employee->employeeDetail) && !is_null($employee->employeeDetail->department) && !is_null($employee->employeeDetail->department)) ? $employee->employeeDetail->department->team_name : '--'" />


                            <div class="col-12 px-0 pb-3 d-block d-lg-flex d-md-flex">
                                <p class="mb-0 text-lightest f-14 w-30 d-inline-block text-capitalize">
                                    @lang('modules.employees.gender')</p>
                                <p class="mb-0 text-dark-grey f-14 w-70">
                                    <x-gender :gender='$employee->gender' />
                                </p>
                            </div>

                            <x-cards.data-row :label="__('modules.employees.joiningDate')"
                            :value="(!is_null($employee->employeeDetail) && !is_null($employee->employeeDetail->joining_date)) ? $employee->employeeDetail->joining_date->format(company()->date_format) : '--'" />

                            @php
                                $currentyearJoiningDate = \Carbon\Carbon::parse(now(company()->timezone)->year.'-'.$employee->employeeDetail->joining_date->translatedFormat('m-d'));
                                if ($currentyearJoiningDate->copy()->endOfDay()->isPast()) {
                                    $currentyearJoiningDate = $currentyearJoiningDate->addYear();
                                }
                                $diffInHoursJoiningDate = now(company()->timezone)->floatDiffInHours($currentyearJoiningDate, false);
                            @endphp

                            <x-cards.data-row :label="__('modules.employees.workAnniversary')" :value="(!is_null($employee->employeeDetail) && !is_null($employee->employeeDetail->joining_date)) ? (($diffInHoursJoiningDate > -23 && $diffInHoursJoiningDate <= 0) ? __('app.today') : $currentyearJoiningDate->longRelativeToNowDiffForHumans()) : '--'" />

                            <x-cards.data-row :label="__('modules.employees.dateOfBirth')"
                                              :value="(!is_null($employee->employeeDetail) && !is_null($employee->employeeDetail->date_of_birth)) ? $employee->employeeDetail->date_of_birth->translatedFormat('d F') : '--'" />

                            @if ($showFullProfile)
                                <x-cards.data-row :label="__('app.mobile')"
                                :value="(!is_null($employee->country_id) ? '+'.$employee->country->phonecode.'-' : '--'). $employee->mobile ?? '--'" />

                                <x-cards.data-row :label="__('modules.employees.slackUsername')"
                                    :value="(isset($employee->employeeDetail) && !is_null($employee->employeeDetail->slack_username)) ? '@'.$employee->employeeDetail->slack_username : '--'" />

                                <x-cards.data-row :label="__('modules.employees.hourlyRate')"
                                    :value="(!is_null($employee->employeeDetail)) ? company()->currency->currency_symbol.$employee->employeeDetail->hourly_rate : '--'" />

                                <x-cards.data-row :label="__('app.address')"
                                    :value="$employee->employeeDetail->address ?? '--'" />

                                <x-cards.data-row :label="__('app.skills')"
                                    :value="$employee->skills() ? implode(', ', $employee->skills()) : '--'" />

                                <x-cards.data-row :label="__('app.language')"
                                    :value="$employeeLanguage->language_name ?? '--'" />

                                {{-- Custom fields data --}}
                                <x-forms.custom-field-show :fields="$fields" :model="$employee->employeeDetail"></x-forms.custom-field-show>

                            @endif

                        </x-cards.data>


                    </div>


                        <div class="col-xl-6 col-lg-6 col-md-6">

                            <x-cards.data class="mb-4" :title="__('modules.appreciations.appreciation')">
                                @forelse ($employee->appreciationsGrouped as $item)
                                <div class="float-left position-relative mb-2" style="width: 50px" data-toggle="tooltip" data-original-title="@if(isset($item->award->title)){{  $item->award->title }} @endif">
                                    @if(isset($item->award->awardIcon->icon))
                                    <i class="bi bi-hexagon-fill fs-40" style="color: {{ $item->award->color_code }}"></i>
                                    <i class="bi bi-{{ $item->award->awardIcon->icon }} f-15 text-white position-absolute appreciation-icon"></i>
                                    @endif
                                    <span class="position-absolute badge badge-secondary rounded-circle border-additional-grey appreciation-count">{{ $item->no_of_awards }}</span>
                                </div>
                                @empty
                                    <p class="f-14 text-dark-grey">@lang('messages.noRecordFound')</p>
                                @endforelse
                            </x-cards.data>

                            <x-cards.data class="mb-4">
                                <div class="d-flex justify-content-between">
                                        <div class="col-6">
                                            <p class="f-14 text-dark-grey">@lang('modules.employees.reportingTo')</p>
                                            @if ($employee->employeeDetail->reportingTo)
                                                <x-employee :user="$employee->employeeDetail->reportingTo" />
                                            @else
                                            --
                                            @endif
                                        </div>

                                    @if ($employee->reportingTeam)
                                        <div class="col-6">
                                            <p class="f-14 text-dark-grey">@lang('modules.employees.reportingTeam')</p>
                                            @if (count($employee->reportingTeam) > 0)
                                                @if (count($employee->reportingTeam) > 1)
                                                    @foreach ($employee->reportingTeam as $item)
                                                        <div class="taskEmployeeImg rounded-circle mr-1">
                                                            <a href="{{ route('employees.show', $item->user->id) }}">
                                                                <img data-toggle="tooltip" data-original-title="{{ $item->user->name }}"
                                                                    src="{{ $item->user->image_url }}">
                                                            </a>
                                                        </div>
                                                    @endforeach
                                                @else
                                                    @foreach ($employee->reportingTeam as $item)
                                                        <x-employee :user="$item->user" />
                                                    @endforeach
                                                @endif

                                            @else
                                                --
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            </x-cards.data>

                            @if ($showFullProfile)
                                <div class="row">
                                    @if (in_array('attendance', user_modules()))
                                        <div class="col-xl-6 col-sm-12 mb-4">
                                            <x-cards.widget :title="__('modules.dashboard.lateAttendanceMark')"
                                                :value="$lateAttendance" :info="__('modules.dashboard.thisMonth')"
                                                icon="map-marker-alt" />
                                        </div>
                                    @endif
                                    @if (in_array('leaves', user_modules()))
                                        <div class="col-xl-6 col-sm-12 mb-4">
                                            <x-cards.widget :title="__('modules.dashboard.leavesTaken')" :value="$leavesTaken"
                                                :info="__('modules.dashboard.thisMonth')" icon="sign-out-alt" />
                                        </div>
                                    @endif
                                </div>
                                <div class="row">
                                    @if (in_array('tasks', user_modules()))
                                        <div class="col-md-12 mb-4">
                                            <x-cards.data :title="__('app.menu.tasks')" padding="false">
                                                <x-pie-chart id="task-chart" :labels="$taskChart['labels']"
                                                    :values="$taskChart['values']" :colors="$taskChart['colors']" height="250"
                                                    width="300" />
                                            </x-cards.data>
                                        </div>
                                    @endif
                                    @if (in_array('tickets', user_modules()))
                                        <div class="col-md-12 mb-4">
                                            <x-cards.data :title="__('app.menu.tickets')" padding="false">
                                                <x-pie-chart id="ticket-chart" :labels="$ticketChart['labels']"
                                                    :values="$ticketChart['values']" :colors="$ticketChart['colors']"
                                                    height="250" width="300" />
                                            </x-cards.data>
                                        </div>
                                    @endif
                                </div>
                            @endif

                        </div>
                </div>
            </div>
            <!--  USER CARDS END -->

            <!--  WIDGETS START -->

            <!--  WIDGETS END -->

        </div>
        <!-- ROW END -->
    </div>

    @if ($showFullProfile)

        <!-- PROJECT RIGHT START -->
        <div class="project-right my-4 my-lg-0">
            <div class="bg-white">
                <!-- ACTIVITY HEADING START -->
                <div class="p-activity-heading d-flex align-items-center justify-content-between b-shadow-4 p-20">
                    <p class="mb-0 f-18 f-w-500">@lang('modules.employees.activity')</p>
                </div>
                <!-- ACTIVITY HEADING END -->
                <!-- ACTIVITY DETAIL START -->
                <div class="p-activity-detail cal-info b-shadow-4" data-menu-vertical="1" data-menu-scroll="1"
                    data-menu-dropdown-timeout="500" id="projectActivityDetail">

                    @forelse($activities as $key=>$activity)
                        <div class="card border-0 b-shadow-4 p-20 rounded-0">
                            <div class="card-horizontal">
                                <div class="card-header m-0 p-0 bg-white rounded">
                                    <x-date-badge :month="$activity->created_at->timezone(company()->timezone)->translatedFormat('M')"
                                        :date="$activity->created_at->timezone(company()->timezone)->translatedFormat('d')" />
                                </div>
                                <div class="card-body border-0 p-0 ml-3">
                                    <h4 class="card-title f-14 font-weight-normal text-capitalize">{!! __($activity->activity) !!}
                                    </h4>
                                    <p class="card-text f-12 text-dark-grey">
                                        {{ $activity->created_at->timezone(company()->timezone)->format(company()->time_format) }}
                                    </p>
                                </div>
                            </div>
                        </div><!-- card end -->
                    @empty
                        <div class="card border-0 p-20 rounded-0">
                            <div class="card-horizontal">

                                <div class="card-body border-0 p-0 ml-3">
                                    <h4 class="card-title f-14 font-weight-normal">
                                        @lang('messages.noActivityByThisUser')</h4>
                                    <p class="card-text f-12 text-dark-grey"></p>
                                </div>
                            </div>
                        </div><!-- card end -->
                    @endforelse


                </div>
                <!-- ACTIVITY DETAIL END -->
            </div>
        </div>
        <!-- PROJECT RIGHT END -->

    @endif
</div>
