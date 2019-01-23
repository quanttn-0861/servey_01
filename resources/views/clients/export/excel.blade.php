<!DOCTYPE html>
<html>
<head>
    <title>{{ $data['title'] }}</title>
    <style type="text/css">
        thead tr, thead td {
            border: 1px solid;
        }
    </style>
</head>
<body>
    <table>
        <tbody>
            <tr>
                <td height="20" colspan="4">
                    <h3>@lang('lang.framgia_vn')</h3>
                </td>
            </tr>
            <tr>
                <td height="20" colspan="4">
                    @lang('profile.name_survey'): {{ $survey->title }}
                </td>
            </tr>
            <tr>
                <td height="20" colspan="4">
                    @lang('lang.date_create') {{ $survey->created_at }}
                </td>
            </tr>
        </tbody>
    </table>
    <table class="table-result table" border="1">
        <thead class="thead-default" height="20">
            <tr>
                <th>
                    {{ trans('lang.timestamps') }}
                </th>
                @if ($data['requiredSurvey'] != config('settings.survey_setting.answer_required.none'))
                    <th width="30">{{ trans('lang.email') }}</th>
                @endif
                @foreach ($data['questions'] as $question)
                    @if (!in_array($question->type, [
                        config('settings.question_type.title'),
                        config('settings.question_type.image'),
                        config('settings.question_type.video'),
                    ]))
                        <th width="30">{!! $question['title'] !!}</th>
                    @endif
                @endforeach
            </tr>
        </thead>
        <tbody>
            @if (count($data['results']))
                @foreach ($data['results'] as $result)
                    @php
                        $result = $result->sortBy('order')->sortBy('section_order');
                    @endphp
                    <tr height="20">
                        <td>{{ $result->first()->created_at }}</td>
                        @if ($data['requiredSurvey'] != config('settings.survey_setting.answer_required.none'))
                            <td>{{ $result->first()->user ? $result->first()->user->email : trans('lang.incognito') }}</td>
                        @endif
                        @foreach ($result->groupBy('question_id') as $answers)
                            @if ($answers->count() == 1)
                                <td>{!! $answers->first()->content_answer !!}</td>
                            @else
                                <td>
                                    {{ $answers->implode('content_answer', ', ') }}
                                </td>
                            @endif
                        @endforeach
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</body>
</html>
