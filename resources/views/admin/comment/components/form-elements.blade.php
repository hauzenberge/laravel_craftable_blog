<div class="form-group row align-items-center" :class="{'has-danger': errors.has('post_id'), 'has-success': fields.post_id && fields.post_id.valid }">
    <label for="post_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.comment.columns.post_id') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.post_id" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('post_id'), 'form-control-success': fields.post_id && fields.post_id.valid}" id="post_id" name="post_id" placeholder="{{ trans('admin.comment.columns.post_id') }}">
        <div v-if="errors.has('post_id')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('post_id') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('comment'), 'has-success': fields.comment && fields.comment.valid }">
    <label for="comment" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.comment.columns.comment') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <div>
            <textarea class="form-control" v-model="form.comment" v-validate="'required'" id="comment" name="comment"></textarea>
        </div>
        <div v-if="errors.has('comment')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('comment') }}</div>
    </div>
</div>


