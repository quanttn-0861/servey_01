<div class="row show-image-background-survey">
    <div class="col-xl-10 col-lg-10 col-md-10 col-sm-8 col-8 choice-image-background">
        <label>@lang('survey.background')</label>
    </div>
    {{-- <div class="col-xl-2 col-lg-2 col-md-2 col-sm-3 col-3 ">
        <a href="javascript:void(0)" class="background-image-survey-btn fa fa-image" data-url="{{ route('ajax-fetch-background-survey') }}"></a>
    </div> --}}
</div>
@include('clients.survey.elements.background-survey', ['imageURL' => route('home').'/'.config('settings.choose-background-image.default')])
<input type="hidden" class="background-survey-hidden" value="{{ route('home') }}/{{ config('settings.choose-background-image.default') }}" name="background-survey-hidden">
