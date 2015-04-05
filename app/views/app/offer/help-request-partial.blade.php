<table class="table">
    <tr>
        <td width="200"><strong>{{ trans('user.first_name') }}</strong></td>
        <td>
            @if(!empty($user->first_name))
                {{ $user->first_name }} {{ $user->last_name }}
            @endif
        </td>
    </tr>
    @if($showContactInfo)
        <tr>
            <td><strong>{{ trans('user.email') }}</strong></td>
            <td>{{ $user->email }}</td>
        </tr>
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
    @else
        <tr>
            <td><strong>{{ trans('user.email') }}</strong></td>
            <td><i>{{ trans('user.available-after-contact') }}</i></td>
        </tr>
        @if(!empty($user->vk_id))
            <tr>
                <td><strong>{{ trans('user.vk_id') }}</strong></td>
                <td><i>{{ trans('user.available-after-contact') }}</i></td>
            </tr>
        @endif
        @if(!empty($user->phone))
            <tr>
                <td><strong>{{ trans('user.phone') }}</strong></td>
                <td><i>{{ trans('user.available-after-contact') }}</i></td>
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
    <tr>
        <td><strong>{{ trans('user.address') }}</strong></td>
        <td>
            @if(!empty($user->address))
                {{ $user->address }}
            @else
                {{trans('offer.no-address')}}
            @endif
        </td>
    </tr>
    @if(!empty($offer->time) && !empty($offer->date))
        <tr>
            <td><strong>{{ trans('offer.help-request.date') }}</strong></td>
            <td>{{ Date::parse($offer->date.' '.$offer->time)->format('H:i d-m-Y') }}</td>
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
                <a href="{{ URL::route('loginGet') }}" class="btn btn-success btn-lg">{{ trans('offer.help-request.response-button-login') }}</a>
            </td>
        </tr>
    @elseif(empty($helpOffer))
        <tr>
            <td colspan="2" class="text-center">
                <a href="{{ URL::route('helpOfferNewGet') }}" class="btn btn-success btn-lg">{{ trans('offer.help-request.response-button-application') }}</a>
            </td>
        </tr>
    @elseif($hasOfferResponse)
        <tr>
            <td colspan="2" class="text-center">
                <h3><span class="label label-info">{{ trans('offer.help-request.already-has-response') }}</span></h3>
            </td>
        </tr>
    @elseif($showButton)
        <tr>
            <td colspan="2" class="text-center">
                <a href="{{ URL::route('helpRequestResponseGet', ['offerId' => $helpOffer->id, 'requestId' => $offer->id]) }}" class="btn btn-success btn-lg">{{ trans('offer.help-request.response-button') }}</a>
            </td>
        </tr>
    @endif
</table>
