@can('تعديل طالب')
<a class="btn btn-sm btn-primary" data-toggle="modal" href="#edit_inventory"

data-id=            "{{ $data->id }}"
data-product_id=    "{{ $data->product_id }}"
data-quantity=      "{{ $data->quantity }}"
data-expiration_date="{{ $data->expiration_date }}"


> <i class="fa fa-edit"></i> </a>

@endcan
@can('حذف طالب')
<a class="btn btn-sm btn-danger" data-toggle="modal" href="#delete_inventory"
data-id=             "{{ $data->id }}"
><i class="fa fa-trash"></i></a>
@endcan
