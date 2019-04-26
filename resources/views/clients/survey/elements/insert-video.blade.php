<div class="modal" id="modal-insert-video" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">@lang('lang.insert_video')</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <nav>
                        <div class="nav nav-tabs nav-tab-insert-image" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-insert-url-video" role="tab" aria-controls="nav-home" aria-selected="true">
                                @lang('lang.by_url')
                            </a>
                            <!-- <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-search-video" role="tab" aria-controls="nav-contact" aria-selected="false">
                                @lang('lang.search_in_youtube')
                            </a> -->
                        </div>
                    </nav>
                    <div class="tab-content" id="nav-tabContent">
                        <div class="tab-pane fade show active" id="nav-insert-url-video" role="tabpanel" aria-labelledby="nav-home-tab">
                            <div class="tabpanel-form">
                                <div class="form-upload-image">
                                    <div class="row col-md-10 offset-md-1 row-btn-upload">
                                        <div class="col-md-12">
                                            <div class="input-group">
                                                <input type="text" class="form-control input-no-radius input-url-video" id="input-url-video" name="url-video" placeholder="@lang('lang.paste_a_video_url')">
                                                <div class="input-group-append">
                                                    <button class="btn btn-default btn-insert-url-video"><i class="fa fa-link"></i></button>
                                                </div>
                                            </div>
                                            <div class="messages-validate-video hidden">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row col-md-10 offset-md-1">
                                        <div class="col-md-12 show-video">
                                            <iframe data-thumbnail="" class="video-preview" width="100%" height="300px"
                                                src="" allowfullscreen frameborder="0">
                                            </iframe>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="nav-search-video" role="tabpanel" aria-labelledby="nav-contact-tab">
                            <div class="tabpanel-form">
                                <div class="input-group col-md-10 offset-md-1">
                                    <input type="text" class="form-control input-no-radius" placeholder="@lang('lang.search_in_youtube')">
                                    <div class="input-group-append">
                                        <button class="btn btn-default btn-search-video"><i class="fa fa-youtube"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer btn-group-video-modal">
                <button class="btn btn-default btn-cancel-insert-video" data-dismiss="modal">@lang('lang.cancel')</button>
                <button class="btn btn-default btn-insert-video" data-dismiss="modal">@lang('lang.insert_video')</button>
            </div>
        </div>
    </div>
</div>
