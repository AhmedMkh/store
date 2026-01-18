@can('تعديل طالب')
<a class="btn btn-sm btn-primary" data-toggle="modal" href="#edit_coupon"

data-id=            "{{ $data->id }}"
data-usage_limit=          "{{ $data->usage_limit }}"
data-type=          "{{ $data->type }}"
data-discount_amount=          "{{ $data->discount_amount }}"
data-expiry_date=          "{{ $data->expiry_date }}"



> <i class="fa fa-edit"></i> </a>

@endcan
@can('حذف طالب')
<a class="btn btn-sm btn-danger" data-toggle="modal" href="#delete_coupon"
data-id=             "{{ $data->id }}"
><i class="fa fa-trash"></i></a>
@endcan
