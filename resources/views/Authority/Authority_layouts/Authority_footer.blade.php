<nav class="nav_list">
    <p class="nav_item ms-0"><a href="{{ route('department.list') }}">部門マスタ</a></p>
    <p class="nav_item"><a href="{{ route('search.show') }}">部門集計</a></p>
    <p class="nav_item {{ (url()->current() == route('department.list'))?'is_active' : 'in_active' }}"><a href="{{ route('department.list') }}">一覧表示</a></p>
    <p class="nav_item {{ (url()->current() == route('department.create'))?'is_active' : 'in_active' }}"><a href="{{ route('department.create') }}">新規登録</a></p>
</nav>