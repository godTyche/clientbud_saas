<div class="tab-pane fade show active" role="tabpanel" aria-labelledby="nav-email-tab">

    <div class="d-flex flex-wrap">
        @forelse ($histories as $history)
            <div class="card file-card w-100 rounded-0 border-0 comment p-2">
                <div class="card-horizontal">
                    <div class="card-img my-1 ml-0">
                        <img src="{{ $history->user->image_url }}" alt="{{ $history->user->name }}">
                    </div>
                    <div class="card-body border-0 pl-0 py-1 mb-2">
                        <div class="d-flex flex-grow-1">
                            <h4 class="card-title f-12 font-weight-normal text-dark mr-3 mb-1">
                                @if($history->event_type == "file-added" )
                                    {{ __(ucfirst($history->event_type)) }} by  <span
                                        class="text-darkest-grey">{{ $history->user->name }}</span><a
                                        href="{{route('deals.show', $deal->id).'?tab=files'}}"> {{__('modules.client.viewDetails')}}</a>
                                @endif
                                @if($history->event_type == "proposal-created" )
                                    {{ __(ucfirst($history->event_type)) }} by <span
                                        class="text-darkest-grey">{{ $history->user->name }}</span><a
                                        href="{{route('deals.show', $deal->id).'?tab=proposals'}}"> {{__('modules.client.viewDetails')}}</a>
                                @endif
                                @if($history->event_type == "note-added" )
                                    {{ __(ucfirst($history->event_type)) }} by <span
                                        class="text-darkest-grey">{{ $history->user->name }}</span><a
                                        href="{{route('deals.show', $deal->id).'?tab=notes'}}"> {{__('modules.client.viewDetails')}}</a>
                                @endif

                                @if($history->event_type == "followup-created" )
                                    {{ __(ucfirst($history->event_type)) }} by <span
                                        class="text-darkest-grey">{{ $history->user->name }}</span><a
                                        href={{route('deals.show', $deal->id).'?tab=follow-up'}}> {{__('modules.client.viewDetails')}}</a>
                                @endif
                                @if($history->event_type == "agent-assigned" || $history->event_type == "stage-updated" )
                                    {{ __(ucfirst($history->event_type)) }} by <span
                                        class="text-darkest-grey">{{ $history->user->name }}</span><a
                                        href="{{route('deals.show', $history->deal_id)}}"> {{__('modules.client.viewDetails')}}</a>
                                @endif
                                @if($history->event_type == "followup-deleted" )
                                    {{ __(ucfirst($history->event_type)) }} by <span
                                        class="text-darkest-grey">{{ $history->user->name }}</span>
                                @endif
                                @if($history->event_type == "proposal-deleted" )
                                    {{ __(ucfirst($history->event_type)) }} by <span
                                        class="text-darkest-grey">{{ $history->user->name }}</span>
                                @endif
                                @if($history->event_type == "note-deleted" )
                                    {{ __(ucfirst($history->event_type)) }} by <span
                                        class="text-darkest-grey">{{ $history->user->name }}</span>
                                @endif
                                @if($history->event_type == "file-deleted" )
                                    {{ __(ucfirst($history->event_type)) }} by <span
                                        class="text-darkest-grey">{{ $history->user->name }}</span>
                                @endif
                            </h4>

                        </div>
                        <div class="card-text f-11 text-lightest text-justify">

                            <span class="f-11 text-lightest">
                                {{ $history->created_at->timezone(company()->timezone)->translatedFormat(company()->date_format .' '. company()->time_format)  }}</span>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <x-cards.no-record icon="history" :message="__('messages.noRecordFound')"/>
        @endforelse

    </div>

</div>
