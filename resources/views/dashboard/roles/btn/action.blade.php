

<a class="btn btn-sm btn-primary"
href="{{ route('dashboard.roles.show', $data->id) }}" >

<i class="fa fa-show"></i>عرض الصلاحيات </a>


@if ($data->name !== 'admin')


    <a class="btn btn-sm btn-primary"
    href="{{ route('dashboard.roles.edit', $data->id) }}" >
    <i class="fa fa-edit"></i></a>




    <form method="POST" action="{{ route('dashboard.roles.destroy', $data->id) }}" style="display:inline">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-sm btn-danger">حذف</button>
    </form>

@endif







