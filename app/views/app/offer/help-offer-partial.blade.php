                <table class="table">
                    <tr>
                        <td width="200"><strong>{{ trans('user.first_name') }}</strong></td>
                        <td>
                            @if(!empty($user->first_name))
                                {{ $user->first_name }} {{ $user->last_name }}
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td><strong>{{ trans('user.email') }}</strong></td>
                        <td>{{ $user->email }}</td>
                    </tr>
                    @if($showContactInfo)
                        @if(!empty($user->vk_id))
                            <tr>
                                <td><strong>{{ trans('user.vk_id') }}</strong></td>
                                <td><a href="http://vk.com/{{ $user->vk_id }}">{{ $user->vk_id }}</a></td>
                            </tr>
                        @endif
                        @if(!empty($user->phone))
                            <tr>
                                <td><strong>{{ trans('user.phone') }}</strong></td>
                                <td>+{{ $user->phone }}</td>
                            </tr>
                        @endif
                    @endif
                    @if(in_array($user->gender,array('male','female')))
                        <tr>
                            <td><strong>{{ trans('user.gender') }}</strong></td>
                            <td>{{ trans('global.genders.'.$user->gender) }}</td>
                        </tr>
                    @endif
                    @if($user->birthdate !== '0000-00-00')
                        <tr>
                            <td><strong>{{ trans('user.birthdate') }}</strong></td>
                            <td>{{ $user->birthdate }}</td>
                        </tr>
                    @endif
                    @if(!empty($user->address))
                        <tr>
                            <td><strong>{{ trans('user.address') }}</strong></td>
                            <td>{{ $user->address }}</td>
                        </tr>
                    @endif
                    @if(!empty($days))
                        <tr>
                            <td><strong>{{ trans('offer.help-offer-view.days') }}</strong></td>
                            <td>
                                @foreach($days as $day)
                                    {{ trans('global.days.'.$day['day']) }}: {{ Date::parse($day['time_start'])->format('H:i') }} - {{ Date::parse($day['time_end'])->format('H:i') }} <br />
                                @endforeach
                            </td>
                        </tr>
                    @endif
                    @if(!empty($offer->description))
                        <tr>
                            <td><strong>{{ trans('offer.help-request.description') }}</strong></td>
                            <td>{{ $offer->description }}</td>
                        </tr>
                    @endif
                    @if(!Sentry::check())
                        <tr>
                            <td colspan="2" class="text-center">
                                <a href="{{ URL::route('loginGet') }}" class="btn btn-success btn-lg">{{ trans('offer.help-offer.response-button-login') }}</a>
                            </td>
                        </tr>
                    @elseif(!$hasHelpRequest)
                        <tr>
                            <td colspan="2" class="text-center">
                                <a href="{{ URL::route('helpRequestNewGet') }}" class="btn btn-success btn-lg">{{ trans('offer.help-offer.response-button-application') }}</a>
                            </td>
                        </tr>
                    @elseif($hasOfferResponse)
                        <tr>
                            <td colspan="2" class="text-center">
                                <h3><span class="label label-info">{{ trans('offer.help-offer.already-has-response') }}</span></h3>
                            </td>
                        </tr>
                    @elseif($showButton)
                        <tr>
                            <td colspan="2" class="text-center">
                                <a href="#" class="btn btn-success btn-lg show-requests-select">{{ trans('offer.help-offer.response-button') }}</a>
                                <div class="requests-list hidden form-inline">
                                    @if(count($helpRequests) > 0)
                                        <select name="request" class="form-control">
                                            @foreach($helpRequests as $request)
                                                <option value="{{ $request->id }}">{{ Date::parse($request->date.' '.$request->time)->format('H:i d-m-Y') }} {{ Str::limit($request->description, 25) }}</option>
                                            @endforeach
                                        </select>
                                        <a href="#" data-submit-link="{{ URL::route('helpOfferResponseGet', ['offerId' => $offer->id, 'requestId' => 'XXX']) }}" class="submit-link btn btn-success">{{ trans('global.submit') }}</a>
                                    @else
                                        Uhmm... No help requests.
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endif
                </table>