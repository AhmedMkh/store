{{-- @can('تعديل طالب')
<a class="btn btn-sm btn-primary" data-toggle="modal" href="#edit_user"

data-id=            "{{ $data->id }}"
data-name=          "{{ $data->name }}"
data-category_id=   "{{ $data->category_id }}"
data-status=        "{{ $data->status }}"
data-image=         "{{ $data->image }}"



> <i class="fa fa-edit"></i> </a>

@endcan --}}
@can('حذف طالب')
<a class="btn btn-sm btn-danger" data-toggle="modal" href="#delete_user"
data-id=             "{{ $data->id }}"
><i class="fa fa-trash"></i></a>
@endcan
