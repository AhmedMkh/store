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
        <li class="breadcrumb-item"><a href="#"> لوحة التحكم</a>
        </li>
        <li class="breadcrumb-item"><a href="#">اضافة صلاحية</a>
        </li>
    </ol>

</div> <br>



<form id="form_store">
    @csrf
<!-- row -->
<div class="row">
    <div class="col-md-12">
        <div class="card mg-b-20">
            <div class="card-body">




                <div class="main-content-label mg-b-5">
                    <div class="col-xs-7 col-sm-7 col-md-7">
                        <div class="form-group">
                            <p>اسم الصلاحية :</p>
                            {{-- {!! Form::text('name', null, array('class' => 'form-control'),'id'=>'name_rolee') !!} --}}
                            <input type="text" name="name" class="form-control" id='name_rolee'>
                            <span id="name_rolee_error" class="text-danger"></span>
                        </div>
                    </div>
                </div>



                        <ul id="treeview1">
                            <li style="font-size: 19px"><a href="#">الصلاحيات</a>
                                <ul>
                            </li>

                            <div class="custom-control custom-checkbox ">
                                <input type="checkbox" class="custom-control-input "  id="checkAll"  />
                                <label class="custom-control-label" for="checkAll">تحديد الكل </label>
                            </div>


                            <div class="row">
                                @foreach($permissions as $value)
                                    <div class="col-md-4">
                                            <div>
                                                <div class="card border border-primary">
                                                    <div class="card-body">
                                                        <div class="feature2" style="margin-bottom: 5%">

                                                            <label style="font-size: 26px;" onclick="checked({{ $value->id }})">
                                                                <input type="checkbox" name="permission[]" value="{{ $value->id }}" class="name"> {{ $value->name }}
                                                            </label>

                                                        </div>

                                                        @foreach ($value->childrens as $item)

                                                            <h6 class="ml-2 tx-16"><label style="font-size: 16px;"> <input type="checkbox" name="permission[]" class="checked{{$value->id}}" value={{$item->id}}>
                                                                {{ $item->name }}</label>
                                                            </h6>

                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                    </div>
                                @endforeach
                            </div>
                            </li>

                        </ul>
                        </li>
                        </ul>
                    </div>

                    <div class="modal-footer d-grid gap-2 col-6 mx-auto">
                        <button type="button" style="display: none" id="add_user2" class="btn btn-primary btn-block">تتم الاضافة ...</button>
                        <button type="button" id="add_user" class="btn btn-primary btn-block">اضافة</button>
                    </div>



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

    <script>
        $("#checkAll").click(function () {
            $('input:checkbox').not(this).prop('checked', this.checked);
        });
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



    {{-- add role --}}
    <script>
        $(document).on('click', '#add_user', function (e) {

            $("#add_user2").css("display", "block");
            $("#add_user").css("display", "none");
            var formData = new FormData($('#form_store')[0]);
                $.ajax({
                    type: 'post',
                    enctype: 'multipart/form-data',
                    url: "{{route('dashboard.roles.store')}}",
                    data: formData,
                    processData: false,
                    contentType: false,
                    cache: false,
                    success: function (data) {


                            $("#add_user2").css("display", "none");
                            $("#add_user").css("display", "block");
                            $('.close').click();
                            $('#position-top-start').click();

                    },
                    error: function (reject) {
                        $("#add_user2").css("display", "none");
                        $("#add_user").css("display", "block");
                        var response = $.parseJSON(reject.responseText);
                        $.each(response.errors, function (key, val) {
                            $("#" + key + "_error").text(val[0]);
                        });
                    }
                });
            });
    </script>
 @endsection
