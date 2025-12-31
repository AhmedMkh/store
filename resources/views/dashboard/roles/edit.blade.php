@extends('layouts.main_page')

@section('css')


    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/pickers/flatpickr/flatpickr.min.css')}}">

    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css-rtl/plugins/extensions/ext-component-sweet-alerts.css')}}">

@endsection


@section('content')

<button class="btn btn-outline-primary" style="display: none" onclick="msg_add()" id="position-top-start"></button>
<button class="btn btn-outline-primary" style="display: none" onclick="msg_send()" id="position-top-start2"></button>
<button class="btn btn-outline-primary" style="display: none" onclick="msg_edit()" id="position-top-start_edit"></button>
<button class="btn btn-outline-primary" style="display: none" onclick="msg_delete()" id="position-top-start_delete"></button>



<div class="breadcrumb-wrapper">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#"> لوحة التحكم </a>
        </li>
        <li class="breadcrumb-item"><a href="#">تعديل صلاحية</a>
        </li>
    </ol>

</div> <br>



<form id="form_edit">
    @csrf
<!-- row -->
<input type="hidden" name="id_passing" value="{{ $id33 }}">
<div class="row">
    <div class="col-md-12">
        <div class="card mg-b-20">
            <div class="card-body">
                <div class="main-content-label mg-b-5">
                    <div class="form-group">
                        <p>اسم الصلاحية :</p>
                        {{-- {!! Form::text('name', null, array('placeholder' => 'Name','class' => 'form-control')) !!} --}}
                        <input type="text" name="name" value="{{ $role->name }}" class="form-control" placeholder="اسم الصلاحية">
                    </div>
                </div>

                    <!-- col -->

                        <ul id="treeview1">
                            <li><a href="#">الصلاحيات</a>
                                <ul>
                                    {{-- <li>
                                        @foreach($permission as $value)
                                        <label>{{ Form::checkbox('permission[]', $value->id, in_array($value->id, $rolePermissions) ? true : false, array('class' => 'name')) }}
                                            {{ $value->name }}</label>
                                        <br />
                                        @endforeach
                                    </li> --}}
                                    <div class="row">
                                        @foreach($permissions as $value)
                                            <div class="col-md-4">
                                                    <div>
                                                        <div class="card border border-primary">
                                                            <div class="card-body">

                                                                <div class="feature2" style="margin-bottom: 5%">
                                                                    <label style="font-size: 26px;"><label>
                                                                        <input
                                                                            type="checkbox"
                                                                            name="permission[]"
                                                                            value="{{ $value->id }}"
                                                                            class="name"
                                                                            {{ in_array($value->id, $rolePermissions) ? 'checked' : '' }}>
                                                                        {{ $value->name }}
                                                                    </label></label>
                                                                </div>

                                                                @foreach ($value->childrens as $item)

                                                                    <h5 class="ml-2 tx-16"><label style="font-size: 16px;">
                                                                        <input type="checkbox" name="permission[]"
                                                                        value="{{ $item->id }}"
                                                                        class="name"
                                                                        {{ in_array($item->id, $rolePermissions) ? 'checked' : '' }}>
                                                                        {{ $item->name }}</label></h5>

                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                            </div>
                                        @endforeach
                                    </div>

                                </ul>
                            </li>
                        </ul>
                    </div>
                    <div class="modal-footer d-grid gap-2 col-6 mx-auto">
                        <button type="button" style="display: none" id="editing2" class="btn btn-primary btn-block"> يتم التعديل ...</button>
                        <button type="button" id="editing" onclick="do_update()" class="btn btn-primary btn-block">حفظ التعديلات</button>
                    </div>
                    <!-- /col -->


        </div>
    </div>
</div>
<!-- row closed -->
</div>
<!-- Container closed -->
</div>
<!-- main-content closed -->
</form>



@endsection



@section('js')

    <script src="{{asset('app-assets/vendors/js/pickers/flatpickr/flatpickr.min.js')}}"></script>

    <script src="{{asset('app-assets/vendors/js/extensions/sweetalert2.all.min.js')}}"></script>
    <script src="{{asset('app-assets/js/scripts/extensions/ext-component-sweet-alerts.js')}}"></script>




    <script>

        function msg_add(){

            Swal.fire({
                position: 'top-start',
                icon: 'success',
                title: 'تمت الاضافة بنجاح ',
                showConfirmButton: false,
                timer: 1500,
                customClass: {
                confirmButton: 'btn btn-primary'
                },
                buttonsStyling: false

            });

        }

        function msg_edit(){

            Swal.fire({
                position: 'top-start',
                icon: 'success',
                title: 'تم التعديل بنجاح',
                showConfirmButton: false,
                timer: 1500,
                customClass: {
                confirmButton: 'btn btn-primary'
                },
                buttonsStyling: false

            });

        }

        function msg_delete(){

            Swal.fire({
                position: 'top-start',
                icon: 'success',
                title: 'تم الحذف بنجاح',
                showConfirmButton: false,
                timer: 1500,
                customClass: {
                confirmButton: 'btn btn-primary'
                },
                buttonsStyling: false

            });

          }

    </script>


     {{-- show information in yajradatatable --}}
     <script type="text/javascript">

        $(function () {
        var table = $('.yajra-datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('dashboard.get_all_role') }}",
            columns: [
                {data: 'DT_RowIndex',  name: 'DT_RowIndex', orderable: false, searchable: false},
                {data: 'name'         ,name: 'name'},

                {data: 'action'     ,  name: 'action'},
            ],
            "lengthMenu": [[5,25,50,-1],[5,25,50,'All']],     // page length options
        });
        });
    </script>
    {{-- defaultContent عشان اذا في بعض الحقول فاضية..ما يرجعلي ايرور من الياجرا داتاتبل وبحطلي بدالها "-" --}}



      {{-- update user --}}
      <script>
        function do_update(){


            $("#editing").css("display", "none");
            $("#editing2").css("display", "block");

            var formData = new FormData($('#form_edit')[0]);
                $.ajax({
                    type: 'post',
                    enctype: 'multipart/form-data',
                    url: "{{route('dashboard.update_rolee')}}",
                    data: formData,
                    processData: false,
                    contentType: false,
                    cache: false,
                    success: function (data) {
                        $("#editing").css("display", "block");
                        $("#editing2").css("display", "none");

                        $('.close').click();

                        $('#position-top-start_edit').click();

                    }, error: function (reject) {
                            $("#editing").css("display", "block");
                            $("#editing2").css("display", "none");
                            var response = $.parseJSON(reject.responseText);
                            $.each(response.errors, function (key, val) {
                                $("#" + key + "_error").text(val[0]);
                            });
                    }
                });
        }
   </script>


@endsection
