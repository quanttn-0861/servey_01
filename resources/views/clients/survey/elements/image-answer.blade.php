<div class="form-row image-answer">
    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-6">
        <div class="show-image-answer">
            <img class="img-fluid answer-image-url" src="{{ $imageURL ? $imageURL : $backgroudUrl }}" alt="">
            <span class="remove-image-answer" data-url="{{ route('ajax-remove-image') }}">
                <i class="fa fa-times"></i>
            </span>
        </div>
    </div>
</div>
