@can('تعديل طالب')
<a class="btn btn-sm btn-primary" data-toggle="modal" href="#edit_category"

data-id=            "{{ $data->id }}"
data-name=          "{{ $data->name }}"
data-status=         "{{ $data->status }}"



> <i class="fa fa-edit"></i> </a>

@endcan
@can('حذف طالب')
<a class="btn btn-sm btn-danger" data-toggle="modal" href="#delete_category"
data-id=             "{{ $data->id }}"
><i class="fa fa-trash"></i></a>
@endcan
