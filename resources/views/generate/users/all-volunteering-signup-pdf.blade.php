<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Volunteering Sign Up PDF</title>
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

        .spacing {
            margin-bottom: 4rem;
        }

        table thead th {
            font-weight: bold;
            font-size: .875rem;
            letter-spacing: .0625rem;
            border-left-width: 0;
            color: #000;
            line-height: 20px;
            vertical-align: middle;
        }

        table tbody {
            position: relative;
            overflow: auto;
            width: 100%;
            box-sizing: border-box;
        }

        table td {
            font-family: 'phetsarath ot';
            vertical-align: middle;
            line-height: 20px;
        }

        table thead tr {
            vertical-align: middle;
            line-height: 20px;
        }

        table td.bold {
            font-weight: bold;
        }

        table tbody td {
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

        .text-left {
            text-align: left !important;
        }

        .text-right {
            text-align: right !important;
        }

        .en-only {
            font-family: 'latoregular';
        }

        .p0 {
            padding: 0 !important;
        }

        .pl-10 {
            padding-left: 10px !important;
        }

        .h4 {
            font-size: 18px;
            line-height: 28px;
            color: #333333;
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
        <table style="" cellspacing="0">
            <thead>
            <tr>
                <th class="text-left p0">Name:</th>
                <td class="text-left p0 pl-10">{{$user->name}}</td>
            </tr>
            </thead>
        </table>
        <br>
        <table style="" cellspacing="0">
            <thead>
            <tr>
                <th class="text-left p0">Hours Clocked:</th>
                <td class="text-right p0 pl-10">{{$volunteering_statuses->HOURS_COUNT??0}}</td>
            </tr>
            <tr>
                <th class="text-left p0">Volunteer Leader:</th>
                <td class="text-right p0 pl-10">{{$volunteering_statuses->LEADER_COUNT??0}}</td>
            </tr>
            <tr>
                <th class="text-left p0">Total Activities:</th>
                <td class="text-right p0 pl-10">{{count($all_sign_up_volunteering)}}</td>
            </tr>
            </thead>
        </table>
        <h4 class="h4" style="padding-left: 0.84px">ROLE: VOLUNTEER</h4>
        <div class="table-wrapper">
            <table style="width:100%" cellspacing="0">
                <thead>
                <tr>
                    <th class="text-left p0" style="font-size: 16px;">Name</th>
                    <th class="text-left p0" style="font-size: 16px;">Date</th>
                    <th class="text-left p0" style="font-size: 16px;">Organisation or Group</th>
                    <th class="text-left p0" style="font-size: 16px;">Hours Clocked</th>
                </tr>
                </thead>
                <tbody>
                @foreach($all_sign_up_volunteering as $key => $volunteering)
                    <tr style="{{ $key%2===0 ? 'background-color: #f9f9f9;' : 'background-color:#ffffff;' }};">
                        <td class="text-left"
                            style="padding-top: .75rem; padding-bottom: .75rem;"> {{$volunteering->name}} </td>
                        <td class="text-left"
                            style="padding-top: .75rem; padding-bottom: .75rem;"> {{date('d/m/Y', strtotime($volunteering->sign_up_date))}} </td>
                        <td class="text-left"
                            style="padding-top: .75rem; padding-bottom: .75rem;"> {{$volunteering->organize_name}} </td>
                        <td class="text-left"
                            style="padding-top: .75rem; padding-bottom: .75rem;"> {{$volunteering->sign_up_hour_per_volunteer}} </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <br>
        <div style="margin-top: 20px;">
            <p>This is a computer generated statement. No signature is required.</p>
        </div>
        <div>
            <p>Report generated: {{date('d/m/Y h:i:s', now()->getTimestamp())}}</p>
        </div>
    </div>
</div>
</body>
</html>
