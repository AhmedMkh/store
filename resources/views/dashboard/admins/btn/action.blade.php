
{{-- <?php $role = App\Models\Dashboard\Admin::where('id',Auth::user()->id)->first(); ?> --}}


{{-- @if(Auth::user()->hasRole('سوبر ادمن')  || Auth::user()->hasRole('استاذ')) --}}

<div class="row">
    <div class="col-md-4">
        <a class="btn btn-sm btn-primary" data-toggle="modal" href="#edit_user"

        data-id=             "{{ $data->id }}"
        data-name=           "{{ $data->name }}"
        data-email=          "{{ $data->email }}"
        data-password=       "{{ $data->password }}"
        data-status=         "{{ $data->status }}"
        data-roles_name=     "{{ $data->roles_name }}"

        > <i class="fa fa-edit"></i> </a>
    </div>


            @if(Auth::guard('web')->user()->hasRole('admin'))
                <div class="col-md-4">

                    <a class="btn btn-sm btn-danger" data-toggle="modal" href="#delete_user"
                    data-id=             "{{ $data->id }}"
                    ><i class="fa fa-trash"></i>
                </a>
                </div>

            @endif
</div>
{{-- @endif --}}
