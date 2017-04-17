<ul class="nav navbar-nav">
    @if (isset($admin_menu))
        @foreach($admin_menu as $menu_item)
          <li><a href="{{ route('admin:getModelAction', strtolower($menu_item)) }}">{{ trans('model.'.$menu_item) }}</a></li>
        @endforeach
    @endif
</ul>