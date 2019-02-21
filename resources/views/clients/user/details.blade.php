<div class="modal fade" id="modal-user-detail{{$user->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content form-elegant">
            <div class="modal-header text-center">
                <h3 class="modal-title w-100 dark-grey-text font-weight-bold my-3" id="myModalLabel">
                    <strong>@lang('lang.user_detail')</strong>
                </h3>
                <button type="button" class="close btn-close-form" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body mx-4">
                <div class="md-form mb-5">
                    <div class="row">
                        <div class="col-md-4"></div>
                        <div class="col-md-4">
                            {{ Html::image(asset($user->image_path), '', ['class' => 'img-user']) }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-body mx-4">
                <div class="md-form mb-5">
                    {{ Form::text('name', $user->name, [
                        'class' => 'form-control validate user-detail-name',
                        'disable',
                        'readonly',
                    ]) }}
                    {{ Form::label('name', trans('lang.name'), ['data-error' => ' ', 'data-success' => ' ']) }}
                </div>
            </div>
            <div class="modal-body mx-4">
                <div class="md-form mb-5">
                    {{ Form::text('email', $user->email, [
                        'class' => 'form-control validate user-detail-email',
                        'disable',
                        'readonly',
                    ]) }}
                    {{ Form::label('email', trans('lang.email'), ['data-error' => ' ', 'data-success' => ' ']) }}
                </div>
            </div>
            <div class="modal-body mx-4">
                <div class="md-form mb-5">
                    {{ Form::text('birthday', $user->birthday, [
                        'class' => 'form-control validate user-detail-email',
                        'disable',
                        'readonly',
                    ]) }}
                    {{ Form::label('birthday', trans('lang.birthday'), ['data-error' => ' ', 'data-success' => ' ']) }}
                </div>
            </div>
            <div class="modal-body mx-4">
                <div class="md-form mb-5">
                    {{ Form::text('address', $user->address, [
                        'class' => 'form-control validate user-detail-email',
                        'disable',
                        'readonly',
                    ]) }}
                    {{ Form::label('address', trans('lang.address'), ['data-error' => ' ', 'data-success' => ' ']) }}
                </div>
            </div>
            <div class="modal-body mx-4">
                <div class="md-form mb-5">
                    {{ Form::text('gender', $user->gender_custom, [
                        'class' => 'form-control validate user-detail-email',
                        'disable',
                        'readonly',
                    ]) }}
                    {{ Form::label('gender', trans('lang.gender'), ['data-error' => ' ', 'data-success' => ' ']) }}
                </div>
            </div>
            <div class="modal-body mx-4">
                <div class="md-form mb-5">
                    {{ Form::text('phone', $user->phone, [
                        'class' => 'form-control validate user-detail-email',
                        'disable',
                        'readonly',
                    ]) }}
                    {{ Form::label('phone', trans('lang.phone'), ['data-error' => ' ', 'data-success' => ' ']) }}
                </div>
            </div>
        </div>
    </div>
</div>

