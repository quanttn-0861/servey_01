<div class="form-row background-survey">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-11 col-12">
        <div class="show-background-survey">
            <img class="img-background image-background-url" src="{{ $imageURL }}" alt="">
            <span class="option-background-survey" >
                <i class="fa fa-ellipsis-v"></i>
                <ul class="option-menu-dropdown option-menu-image">
                    <li class="change-background-survey">
                        <i class="fa fa-picture-o text-dark"></i>
                        <span class="option-menu-content">@lang('lang.change_image')</span>
                    </li>
                    <li class="remove-image" data-url="{{ route('ajax-remove-image') }}">
                        <i class="fa fa-trash"></i>
                        <span class="option-menu-content">@lang('lang.delete_image')</span>
                    </li>
                </ul>
            </span>
        </div>
    </div>
</div>
