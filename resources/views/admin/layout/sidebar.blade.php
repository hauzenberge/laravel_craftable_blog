<div class="sidebar">
    <nav class="sidebar-nav">
        <ul class="nav">
            <li class="nav-title">{{ trans('brackets/admin-ui::admin.sidebar.content') }}</li>
            @can('admin.category.index')<li class="nav-item"><a class="nav-link" href="{{ url('admin/categories') }}"><i class="nav-icon icon-map"></i> {{ trans('admin.category.title') }}</a></li>@endcan
            @can('admin.post.index')<li class="nav-item"><a class="nav-link" href="{{ url('admin/posts') }}"><i class="nav-icon icon-power"></i> {{ trans('admin.post.title') }}</a></li>@endcan
            @can('admin.comment.index')<li class="nav-item"><a class="nav-link" href="{{ url('admin/comments') }}"><i class="nav-icon icon-globe"></i> {{ trans('admin.comment.title') }}</a></li>@endcan
            {{-- Do not delete me :) I'm used for auto-generation menu items --}}

            <li class="nav-title">{{ trans('brackets/admin-ui::admin.sidebar.settings') }}</li>
            @can('admin.admin-user.index')<li class="nav-item"><a class="nav-link" href="{{ url('admin/admin-users') }}"><i class="nav-icon icon-user"></i> {{ __('Manage access') }}</a></li>@endcan
            @can('admin.role')<li class="nav-item"><a class="nav-link" href="{{ url('admin/roles') }}"><i class="nav-icon icon-ghost"></i> {{ trans('admin.role.title') }}</a></li>@endcan
            @can('admin.translation.index')<li class="nav-item"><a class="nav-link" href="{{ url('admin/translations') }}"><i class="nav-icon icon-location-pin"></i> {{ __('Translations') }}</a></li>@endcan
            {{-- Do not delete me :) I'm also used for auto-generation menu items --}}
            {{--<li class="nav-item"><a class="nav-link" href="{{ url('admin/configuration') }}"><i class="nav-icon icon-settings"></i> {{ __('Configuration') }}</a></li>--}}
        </ul>
    </nav>
    <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div>

