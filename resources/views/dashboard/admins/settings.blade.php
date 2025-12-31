@extends('layouts.main_page')

@section('css')

    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/tables/datatable/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/tables/datatable/responsive.bootstrap4.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/tables/datatable/buttons.bootstrap4.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/tables/datatable/rowGroup.bootstrap4.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/pickers/flatpickr/flatpickr.min.css')}}">

    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css-rtl/plugins/extensions/ext-component-sweet-alerts.css')}}">

@endsection


@section('content')


 <button class="btn btn-outline-primary" style="display: none" onclick="msg_add()" id="position-top-start"></button>
 <button class="btn btn-outline-primary" style="display: none" onclick="msg_edit()" id="position-top-start_edit"></button>
 <button class="btn btn-outline-primary" style="display: none" onclick="msg_delete()" id="position-top-start_delete"></button>




<div class="breadcrumb-wrapper">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.html">  لوحة التحكم </a>
        </li>
        <li class="breadcrumb-item"><a href="#">الصفحة الشخصية</a>
        </li>
    </ol>
</div>


<form id="usersFormUpdate">
    @csrf

        <div class="row">

            <input type="hidden" name="id" value="{{ Auth::user()->id }}" id="">
            <div class="form-group col-md-6">
                    <label for="inputAddress">الاسم</label>
                    <input type="text" name="nameauth" value="{{ Auth::user()->name }}" class="form-control" id="inputAddress" placeholder="1234 Main St">
            </div><br>
            <div class="form-group col-md-6">
                    <label for="inputEmail4">البريد الالكتروني</label>
                    <input type="email" class="form-control" value="{{ Auth::user()->email }}" name="email" id="email" placeholder="Email" autocomplete="off">
                    <span id="email_error" class="text-danger"></span>
            </div>
            <div class="form-group col-md-6">
                    <label for="inputPassword4">كلمة المرور</label>
                    <input type="password" name="password" value="{{ Auth::user()->password }}" class="form-control" id="password" placeholder="Password">
                    <span id="password_error" class="text-danger"></span>
            </div>
            <div class="form-group col-md-6">
                    <label for="inputPassword4">تأكيد كلمة المرور</label>
                    <input type="password" name="password_confirmation" value="{{ Auth::user()->password }}" class="form-control" id="inputPassword4" placeholder="Password">
                    <span id="password_confirmation_error" class="text-danger"></span>
            </div>



        </div>

        <button class="btn btn-primary" type="button" id="reload66"  style="display:none" disabled>
            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
        جاري التعديل ...
        </button>

        <button type="button" style="margin-right: 2%"  id="update_users" onclick="do_update()" class="btn btn-primary">تعديل</button>

</form>






 @endsection


@section('js')
    <script src="{{asset('app-assets/vendors/js/tables/datatable/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('app-assets/vendors/js/tables/datatable/datatables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('app-assets/vendors/js/tables/datatable/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('app-assets/vendors/js/tables/datatable/responsive.bootstrap4.js')}}"></script>
    <script src="{{asset('app-assets/vendors/js/tables/datatable/datatables.checkboxes.min.js')}}"></script>
    <script src="{{asset('app-assets/vendors/js/tables/datatable/datatables.buttons.min.js')}}"></script>
    <script src="{{asset('app-assets/vendors/js/tables/datatable/dataTables.rowGroup.min.js')}}"></script>
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
    $(function () {
        'use strict';

        var changePicture = $('#change-picture'),
            userAvatar = $('.user-avatar');


        // Change user profile picture
        if (changePicture.length) {
            $(changePicture).on('change', function (e) {
                var reader = new FileReader(),
                    files = e.target.files;
                reader.onload = function () {
                    if (userAvatar.length) {
                        userAvatar.attr('src', reader.result);
                    }
                };
                reader.readAsDataURL(files[0]);
            });
        }
    });
</script>


 {{-- update setting admin --}}
 <script>
    function do_update(){
        //  $('#email_error').text('');
        //  $('#password_error').text('');
         $("#update_users").css("display", "none");
         $("#reload66").css("display", "block");
         var formData = new FormData($('#usersFormUpdate')[0]);
             $.ajax({
                 type: 'post',
                 enctype: 'multipart/form-data',
                 url: "{{route('dashboard.myprofile_update')}}",
                 data: formData,
                 processData: false,
                 contentType: false,
                 cache: false,
                 success: function (data) {
                     $("#reload66").css("display", "none");
                     $("#update_users").css("display", "block");
                     if(data.status == true){
                        $('#position-top-start_edit').click();

                     }
                 }, error: function (reject) {
                    $("#reload66").css("display", "none");
                     $("#update_users").css("display", "block");
                        var response = $.parseJSON(reject.responseText);
                        $.each(response.errors, function (key, val) {
                            $("#" + key + "_error").text(val[0]);
                        });
                 }
             });
     }
</script>


     {{-- show information in yajradatatable --}}
     {{-- <script type="text/javascript">

        $(function () {
        var table = $('.yajra-datatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('get_all_users') }}",
            columns: [
                {data: 'DT_RowIndex',  name: 'DT_RowIndex', orderable: false, searchable: false},
                {data: 'name'         ,name: 'name'},
                {data: 'email'        ,name: 'email'},
                {data: 'mobile'       ,name: 'mobile'},
                {data: 'category_id'  ,name: 'category_id'},
                {data: 'action'     ,  name: 'action'},
            ],
            "lengthMenu": [[5,25,50,-1],[5,25,50,'All']],     // page length options
        });
        });
    </script> --}}
    {{-- defaultContent عشان اذا في بعض الحقول فاضية..ما يرجعلي ايرور من الياجرا داتاتبل وبحطلي بدالها "-" --}}


    {{-- add user --}}
    {{-- <script>
        $(document).on('click', '#add_user', function (e) {
            $('#name_error').text('');
            $('#email_error').text('');
            $('#mobile_error').text('');
            $('#password_error').text('');

            $("#add_user2").css("display", "block");
            $("#add_user").css("display", "none");
            var formData = new FormData($('#add_user_form')[0]);
                $.ajax({
                    type: 'post',
                    enctype: 'multipart/form-data',
                    url: "{{route('store_users')}}",
                    data: formData,
                    processData: false,
                    contentType: false,
                    cache: false,
                    success: function (data) {

                            $('.yajra-datatable').DataTable().ajax.reload(null, false);
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
    </script> --}}


    {{-- edit user --}}
    {{-- <script>
        $('#edit_user').on('show.bs.modal', function(event) {
        //    to hide error validation after open model edit
            $('#name2_error').text('')
            $('#email2_error').text('')
            $('#mobile2_error').text('')
            $('#password2_error').text('')


            var button = $(event.relatedTarget)
            var id =             button.data('id')
            var name =           button.data('name')
            var email =          button.data('email')
            var mobile =         button.data('mobile')
            var password =       button.data('password')

            var modal = $(this)
            modal.find('.modal-body #id2').val(id);
            modal.find('.modal-body #name2').val(name);
            modal.find('.modal-body #email2').val(email);
            modal.find('.modal-body #mobile2').val(mobile);
            modal.find('.modal-body #password2').val(password);
        })
    </script> --}}


   {{-- update user --}}
   {{-- <script>
        function do_update(){

            $('#name2_error').text('')
            $('#email2_error').text('')
            $('#mobile2_error').text('')
            $('#password2_error').text('')

            $("#editing").css("display", "none");
            $("#editing2").css("display", "block");

            var formData = new FormData($('#edit_user_form')[0]);
                $.ajax({
                    type: 'post',
                    enctype: 'multipart/form-data',
                    url: "{{route('update_user')}}",
                    data: formData,
                    processData: false,
                    contentType: false,
                    cache: false,
                    success: function (data) {
                        $("#editing").css("display", "block");
                        $("#editing2").css("display", "none");

                        $('.close').click();

                        $('#position-top-start_edit').click();
                        $('.yajra-datatable').DataTable().ajax.reload(null, false);

                    }, error: function (reject) {
                            $("#editing").css("display", "block");
                            $("#editing2").css("display", "none");
                            var response = $.parseJSON(reject.responseText);
                            $.each(response.errors, function (key, val) {
                                $("#" + key + "2_error").text(val[0]);
                            });
                    }
                });
        }
   </script> --}}

    {{-- fill delete modal user --}}
    {{-- <script>
        $('#delete_user').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id     =  button.data('id')
            var modal = $(this)
            modal.find('.modal-body #id3').val(id);
        })
    </script> --}}


   {{-- delete user--}}
   {{-- <script>
        function do_delete(){

            $("#delete_user_button").css("display", "none");
            $("#delete_user2").css("display", "block");
            var formData = new FormData($('#delete_user_form')[0]);
            $.ajax({
                type: 'post',
                url: "{{route('dashboard.destroy_user')}}",
                data: formData,
                processData: false,
                contentType: false,
                success: function (data) {
                    $("#delete_user2").css("display", "none");
                    $("#delete_user_button").css("display", "block");
                    $('.close').click();
                    $('#position-top-start_delete').click();
                    $('.yajra-datatable').DataTable().ajax.reload(null, false);

                }, error: function (reject) {
                }
            });
     }
    </script> --}}






@endsection
