<table>
    <tr>
        <th>Organisation Name</th>
        <td>{{$organize->name}}</td>
    </tr>
    <tr>
        <th>Activity Name</th>
        <td>{{$activity->name}}</td>
    </tr>
    <tr>
        <th>Activity Date</th>
        <td>{{App\Http\Controllers\Helpers\Helpers::toFormatDateString($activity->start_date, 'D, d M Y') }}
            to {{App\Http\Controllers\Helpers\Helpers::toFormatDateString($activity->end_date, 'D, d M Y')}}</td>
    </tr>
    <tr>
        <th>Activity Time</th>
        @php
            $days_of_week = [];
            if ($activity->weekday === 'yes') {
                $days_of_week[] = 'WEEKDAY';
            }
            if ($activity->weekend === 'yes') {
                $days_of_week[] = 'WEEKEND';
            }
            $days_of_week_str = implode(' or ' ,array_map('strtolower', $days_of_week));
            $frequencies = [
                '1_DAY_PER_WEEK' => 'One day per week',
                '2_3_DAYS_PER_WEEK'=> '2-3 days per week',
                'FORTNIGHTLY'=> 'Fortnightly',
                'MONTHLY'=> 'Monthly',
                'QUARTERLY'=> 'Quarterly',
                'FLEXIBLE'=> 'Flexible',
                'FULL_TIME'=> 'Full Time'
            ];
        @endphp
        <td>{{$frequencies[$activity->frequency] }} on {{  $days_of_week_str  }}</td>
    </tr>
    <tr>
        <th>Activity Location</th>
        <td>{{$activity->town}}, {{$activity->block_street}}</td>
    </tr>
</table>
<table>
    <thead>
    <tr>
        <th>No.</th>
        <th>Position</th>
        <th>User Name</th>
        <th>Status</th>
        <th>Last Updated</th>
        <th>Activity Leader</th>
        <th>SignUp Date</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Salutation</th>
        <th>Gender</th>
        <th>Age</th>
        <th>Question Response</th>
        <th>Signup Slots</th>
        <th>Attendance Hours</th>
    </tr>
    </thead>
    <tbody>
    @foreach($sign_up_activities as $key => $sign_up_activity)
        @php
            $mapData = \App\Models\VolunteerSignUpActivity::mapData($sign_up_activity, $activity->volunteer_gender === 'yes');
            $user =  \App\User::find($sign_up_activity->user_id);
            $user_profile = $user->userProfile('volunteer');
        @endphp
        <tr style="{{ $key%2===0 ? 'background-color: #f9f9f9;' : 'background-color:#ffffff;' }}">
            <td>{{ $key+1 }}</td>
            <td>{{$mapData->position->title}}</td>
            <td>{{ $user->name }}</td>
            <td>{{ strtoupper($sign_up_activity->status) }}</td>
            <td>{{ App\Http\Controllers\Helpers\Helpers::toFormatDateString($sign_up_activity->updated_at, 'd/m/Y') }}</td>
            <td>{{ \Illuminate\Support\Str::ucfirst($sign_up_activity->leader) }}</td>
            <td>{{ App\Http\Controllers\Helpers\Helpers::toFormatDateString($sign_up_activity->sign_up_date, 'd/m/Y') }}</td>
            <td>{{$user_profile->public_email??$user->email}}</td>
            <td>{{$user_profile->phone_number??''}}</td>
            <td>{{\Illuminate\Support\Str::ucfirst($user_profile->salutation??'')}}</td>
            <td>{{ \Illuminate\Support\Str::ucfirst($mapData->gender)  }}</td>
            <td>{{isset($sign_up_activity->date_of_birth) ? \App\Http\Controllers\Helpers\Helpers::getAge($sign_up_activity->date_of_birth) : ''}}</td>
            <td>{{$sign_up_activity->other_response_required}}</td>
            <td>{{$sign_up_activity->slot}}</td>
            <td>{{($sign_up_activity->checkin_date !== null && $sign_up_activity->status==='checkin') ? $sign_up_activity->hour_per_volunteer : 0 }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
