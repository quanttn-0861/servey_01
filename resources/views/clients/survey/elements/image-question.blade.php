<div class="form-row image-question">
    <div class="col-xl-7 col-lg-7 col-md-7 col-sm-11 col-10">
        <div class="show-image-question">
            <img class="img-fluid image-question-url" src="{{ $imageURL ? $imageURL : $backgroudUrl }}" alt="">
            <span class="option-image-question" >
                <i class="fa fa-ellipsis-v"></i>
                <ul class="option-menu-dropdown option-menu-image">
                <li class="change-image">
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
