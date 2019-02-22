<!-- The Modal -->
<div class="modal fade setting-survey" id="pupup-invite-survey">
    <div class="modal-dialog">
        <div class="modal-content modal-content-setting-create-survey">
            <div class="modal-header modal-header-setting-survey">
                <h4 class="modal-title title-setting-survey">@lang('profile.status')</h4>
                <a href="javascript:void(0)" class="close icon-close" data-dismiss="modal">
                    <span class="color-icons-close"><i class="fa fa-times"></i></span>
                </a>
            </div>
            <!-- start tab settings -->
            <div class="tab-content tab-content-setting">
                <div class="container">
                    <div class="row">
                        <div class="col-md-7">
                            <label for="" class="label-email">
                                <span class="all-email" title="all" data-toggle="tooltip" title="all">@lang('lang.email')</span>
                                <span class="inviter-description">
                                    (<span class="emails-not-answer"><i class="fa fa-circle blue"></i> @lang('lang.not_yet_answered')</span>
                                    / <span class="emails-answered"><i class="fa fa-circle green"></i> @lang('lang.answered'))</span>
                                </span>
                            </label>
                        </div>
                        <div class="col-md-5">
                            <div class="input-group">
                                <input type="text" class="form-control search-mail-invite" placeholder="@lang('profile.search')">
                                <span class="input-group-btn">
                                    <button class="btn btn-secondary btn-search-invite" type="button">
                                        <i class="fa fa-search" aria-hidden="true"></i>
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div>
                        <span class="number-incognito-answer"></span>
                    </div>
                    <div class="content-table-invite">
                        <table class="table-body-scroll table-invite table-show-email-manager" cellspacing="0">
                            <thead>
                                <tr>
                                    <th width="15%">@lang('profile.index')</th>
                                    <th>@lang('lang.email')</th>
                                    <th width="20%">@lang('profile.status')</th>
                                    <th width="15%">@lang('profile.count')</th>
                                </tr>
                            </thead>
                            <tbody class="body-table-invite-status" id="style-scroll-custom">
                            </tbody>
                        </table>
                        <div class="notice-data-empty">@include ('clients.layout.empty_data')</div>
                    </div>
                </div>
            </div>
            <!-- end tab settings -->
        </div>
    </div>
</div>
