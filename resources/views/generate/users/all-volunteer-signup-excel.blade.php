<table>
    <tr>
        <th>Org Name</th>
        <td>{{$organize->name}}</td>
    </tr>
    <tr>
        <th>Date</th>
        <td>{{now()->toDateString()}}</td>
    </tr>
    <tr>
        <th>Time</th>
        <td>{{now()->toTimeString()}}</td>
    </tr>
</table>
<table>
    <thead>
    <tr>
        <th>No.</th>
        <th>User Name</th>
        <th>Salutation</th>
        <th>Phone No.</th>
        <th>Email Address</th>
        <th>Number of Activities</th>
        <th>Number of Hours</th>
    </tr>
    </thead>
    <tbody>
    @foreach($volunteers as $key => $volunteer)
        <tr style="{{ $key%2===0 ? 'background-color: #f9f9f9;' : 'background-color:#ffffff;' }}">
            <td>{{ $key+1 }}</td>
            <td>{{ $volunteer->user_name }}</td>
            <td>{{ $volunteer->salutation }}</td>
            <td>{{ $volunteer->phone_number }}</td>
            <td>{{ $volunteer->public_email }}</td>
            <td>{{ $volunteer->activities_count }}</td>
            <td>{{ $volunteer->hours_number }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
