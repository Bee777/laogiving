<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>User Student Score PDF</title>
    <style type="text/css">
        body {
            font-family: 'phetsarath ot';
        }

        table {
            clear: both;
            margin-top: 6px !important;
            margin-bottom: 6px !important;
            max-width: none !important;
            border-collapse: separate !important;
            border-spacing: 0;
            border-bottom-width: 0;
        }

        table thead th {
            font-weight: bold;
            font-size: .875rem;
            letter-spacing: .0625rem;
            border-left-width: 0;
            vertical-align: bottom;
            border-bottom: 1px solid #ebebeb;
            padding: .75rem;
            color: #000;
        }

        table tbody {
            position: relative;
            overflow: auto;
            width: 100%;
            box-sizing: border-box;
        }

        table td.both-lang {
            font-family: 'phetsarath ot';
        }

        table td.bold {
            font-weight: bold;
        }

        table tbody td {
            padding: .75rem;
            vertical-align: middle;
            border: 0;
            color: #000;
        }

        .font-size-sm {
            font-size: .875rem !important;
        }

        .text-center {
            text-align: center !important;
        }

        .table-bordered {
            border: 1px solid #ebebeb;
        }

        .en-only {
            font-family: 'latoregular';
        }

        .header-title {
            color: #000;
            font-size: 14px;
            padding: 1rem;
            text-align: center;
            text-transform: uppercase;
            position: relative;
        }

        .th-color {
            border: none;
            background-color: #23386D;
            color: #fff;
        }

        @page {
            header: page-header;
            footer: page-footer;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="boxed">
        <h4 class="text-center header-title" style="margin-bottom: -2px;">{{ $title }}</h4>
        <div class="table-wrapper">
            <table style="width:100%" cellspacing="0">
                @if($request->get('term') === 'all')
                    <thead>
                    <tr>
                        @foreach($scores['terms'] as $key => $term)
                            <th class="text-center en-only"
                                style="font-size: 18px;border: none; background-color: #23386D;color: #fff;"
                                colspan="4">
                                Term {{$key+1}}</th>
                        @endforeach
                    </tr>
                    <tr>
                        @foreach($scores['terms'] as $key => $term)
                            <th class="text-center en-only" style="width: 14%; font-size: 14px;">Subject ID</th>
                            <th class="en-only" style="width: 240px; font-size: 14px;">Subject Name</th>
                            <th class="d-sm-table-cell en-only" style="width: 16%; font-size: 14px;">Grade</th>
                            <th class="d-sm-table-cell en-only" style="width: 16%; font-size: 14px;">Subject Credit</th>
                        @endforeach
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($scores['data'] as $keySubject=> $subject)
                        <tr
                            style="{{ $keySubject%2===0 ? 'background-color: #f9f9f9;' : 'background-color:#ffffff;' }}">
                            @foreach($subject as $keyScore => $score)
                                <td style="border-top: none;"
                                    class="text-center font-size-sm en-only ">{{ isset($score) ? $score->Sub_ID : '' }}</td>
                                <td class="font-w600 font-size-sm both-lang">{{ isset($score) ? $score->Sub_Name_L : '' }}</td>
                                <td class="d-sm-table-cell text-center en-only bold">
                                    @if(isset($score))
                                        <span
                                            @php
                                                $gradeColor = null;
                                                $grade = $score->Grade;
                                                $gradeColor = $gradesColors->first(function($item) use ($grade) {
                                                    return $item->Grade === $grade;
                                                });
                                                $gradeColor = !isset($gradeColor) ? 'default' : $gradeColor->color;
                                            @endphp
                                            class="badge badge-{{ $gradeColor }}">  {{ $grade }}</span>
                                    @else

                                    @endif
                                </td>
                                <td class="d-sm-table-cell text-center en-only">
                                    <em class="text-muted font-size-sm both-lang "><b>{{ isset($score) ? $score->Sub_Credit : '' }}</b></em>
                                </td>
                            @endforeach
                        </tr>
                    @endforeach
                    </tbody>
                @else
                    <thead>
                    <tr role="row">
                        <th class="text-center th-color en-only" style="width: 28px; color: #ffffff;">Order</th>
                        <th class="text-center th-color en-only" style="width: 110px; color: #ffffff;">Subject ID</th>
                        <th class="th-color  en-only" style="width: 240px; color: #ffffff;">Subject Name</th>
                        <th class="d-sm-table-cell th-color en-only" style="width: 20%; color: #ffffff;">Grade</th>
                        <th class="d-sm-table-cell th-color en-only" style="width: 25%; color: #ffffff;">Subject Credit</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($scores as $key => $score)
                        <tr style="{{ $key%2===0 ? 'background-color: #f9f9f9;' : 'background-color:#ffffff;' }}">
                            <td class="text-center font-size-sm en-only">{{ $key+1 }}</td>
                            <td class="text-center font-size-sm en-only">{{ $score->Sub_ID }}</td>
                            <td class="font-w600 font-size-sm both-lang">{{ $score->Sub_Name_L }}</td>
                            <td class="d-sm-table-cell text-center en-only bold">
                                <span
                                    @php
                                        $gradeColor = null;
                                        $grade = $score->Grade;
                                        $gradeColor = $gradesColors->first(function($item) use ($grade) {
                                            return $item->Grade === $grade;});
                                        $gradeColor = !isset($gradeColor) ? 'default' : $gradeColor->color;
                                    @endphp
                                    class="badge badge-{{ $gradeColor }}">  {{ $grade }}</span></td>
                            <td class="d-sm-table-cell text-center en-only">
                                <em class="text-muted font-size-sm en-only"><b>{{ $score->Sub_Credit }}</b></em></td>
                        </tr>
                    @endforeach
                    </tbody>
                @endif
            </table>
        </div>
    </div>
</div>
</body>
</html>
