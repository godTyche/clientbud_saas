@push('styles')

    <style>
        .table-stats span {
            border-bottom: 1px dotted #000;
            text-decoration: none;
        }
    </style>
@endpush
<div class="row">
    <div class="col-md-12">
        <x-cards.data :title="__('app.statistics')">

            <label>
                {{__('superadmin.browserDetectDescription')}}
            </label>

            <x-table class="table-striped table-stats">
                <x-slot name="thead">
                    <th>Type</th>
                    <th></th>
                </x-slot>
                @if($company->headers)
                    @foreach(json_decode($company->headers,true) as $index=>$head)
                        <tr>
                            <td>
                                <span data-toggle="tooltip"
                                      data-original-title="{{__('superadmin.browserDetectTooltip.'.$index)}}">
                                    @if(is_bool($head))
                                        {{$index}}
                                    @else
                                        {{ ucwords(preg_replace('/(?<!\ )[A-Z]/', ' $0', $index))}}
                                    @endif
                                </span>
                            </td>
                            <td class="text-left pl-20">
                                @if(is_bool($head))
                                    @if($head)
                                        <i class="fa fa-check-circle text-success" data-toggle="tooltip" title="{{__('app.yes')}}"></i>
                                    @else
                                        <i class="fa fa-times text-danger" data-toggle="tooltip" title="{{__('app.no')}}"></i>
                                    @endif
                                @else
                                    <strong>{{ $head }}</strong>
                                @endif
                            </td>

                        </tr>
                    @endforeach
                    <tr>
                        <td class="">{{__('superadmin.registeredIp')}}</td>
                        <td class="text-left pl-20"><strong>{{$company->register_ip??'-'}}</strong></td>
                    </tr>
                @else
                    <tr>
                        <td colspan="2">
                            <x-cards.no-record icon="list" :message="__('messages.noRecordFound')"/>
                        </td>
                    </tr>
                @endif
            </x-table>
        </x-cards.data>
    </div>
</div>

<!-- ROW END -->

