<x-cards.data :title="__('superadmin.dashboard.registrationsChart')">
    <x-slot name="action">
        <x-forms.select fieldName="registration_year" fieldId="registration_year">
            <option
                {{ (request()->year ==  now(global_setting()->timezone)->year) ? 'selected' : '' }} value="{{ now(global_setting()->timezone)->year }}">{{ now(global_setting()->timezone)->year }}</option>
            <option
                {{ (request()->year ==  now(global_setting()->timezone)->subYear()->year) ? 'selected' : '' }} value="{{ now(global_setting()->timezone)->subYear()->year }}">{{ now(global_setting()->timezone)->subYear()->year }}</option>
            <option
                {{ (request()->year ==  now(global_setting()->timezone)->subYears(2)->year) ? 'selected' : '' }} value="{{ now(global_setting()->timezone)->subYears(2)->year }}">{{ now(global_setting()->timezone)->subYears(2)->year }}</option>
        </x-forms.select>
    </x-slot>
    <x-bar-chart id="task-chart2" :chartData="$registrationsChart" height="300"  :spaceRatio="0.5"></x-bar-chart>
</x-cards.data>
