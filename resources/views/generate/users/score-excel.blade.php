<table>
    @if($request->get('term') === 'all')
        <thead>
        <tr>
            <th style="color: #000000" colspan="8">{{ $title }}</th>
        </tr>
        <tr>
            @foreach($scores['terms'] as $key => $term)
                <th style="background-color: #23386D;" colspan="4">Term {{$key+1}}</th>
            @endforeach
        </tr>
        <tr>
            @foreach($scores['terms'] as $key => $term)
                <th style="width: 14%;">Subject ID</th>
                <th style="width: 240px;">Subject Name</th>
                <th style="width: 16%;">Grade</th>
                <th style="width: 16%;">Subject Credit</th>
            @endforeach
        </tr>
        </thead>
        <tbody>
        @foreach($scores['data'] as $keySubject=> $subject)
            <tr
                style="{{ $keySubject%2===0 ? 'background-color: #f9f9f9;' : 'background-color:#ffffff;' }}">
                @foreach($subject as $keyScore => $score)
                    <td>{{ isset($score) ? $score->Sub_ID : '' }}</td>
                    <td>{{ isset($score) ? $score->Sub_Name_L : '' }}</td>
                    <td>
                        @if(isset($score))
                            @php
                                $gradeColor = null;
                                $grade = $score->Grade;
                                $gradeColor = $gradesColors->first(function($item) use ($grade) {
                                    return $item->Grade === $grade;});
                                $gradeColor = !isset($gradeColor) ? 'default' : $gradeColor->color;
                            @endphp
                            {{ $grade }}
                        @else
                        @endif
                    </td>
                    <td>{{ isset($score) ? $score->Sub_Credit : '' }}</td>
                @endforeach
            </tr>
        @endforeach
        </tbody>
    @else
        <thead>
        <tr>
            <th style="color: #000000" colspan="5">{{ $title }}</th>
        </tr>
        <tr>
            <th style="background-color: #23386D;">Order</th>
            <th style="background-color: #23386D;">Subject ID</th>
            <th style="background-color: #23386D;">Subject Name</th>
            <th style="background-color: #23386D;">Grade</th>
            <th style="background-color: #23386D;">Subject Credit</th>
        </tr>
        </thead>
        <tbody>
        @foreach($scores as $key => $score)
            <tr style="{{ $key%2===0 ? 'background-color: #f9f9f9;' : 'background-color:#ffffff;' }}">
                <td>{{ $key+1 }}</td>
                <td>{{ $score->Sub_ID }}</td>
                <td>{{ $score->Sub_Name_L }}</td>
                @php
                    $gradeColor = null;
                    $grade = $score->Grade;
                    $gradeColor = $gradesColors->first(function($item) use ($grade) {
                        return $item->Grade === $grade;});
                    $gradeColor = !isset($gradeColor) ? 'default' : $gradeColor->color;
                @endphp
                <td>{{ $grade }}</td>
                <td>{{ $score->Sub_Credit }}</td>
            </tr>
        @endforeach
        </tbody>
    @endif
</table>
