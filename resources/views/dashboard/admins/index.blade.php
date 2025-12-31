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
 <button class="btn btn-outline-primary" style="display: none" onclick="msg_send()" id="position-top-start2"></button>
 <button class="btn btn-outline-primary" style="display: none" onclick="msg_edit()" id="position-top-start_edit"></button>
 <button class="btn btn-outline-primary" style="display: none" onclick="msg_delete()" id="position-top-start_delete"></button>




<div class="breadcrumb-wrapper">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">  لوحة التحكم</a>
        </li>
        <li class="breadcrumb-item"><a href="#">فريق النظام</a>
        </li>
    </ol>
</div>



<a class="btn btn-primary" data-toggle="modal" href="#inlineForm" style="margin-bottom:1%">اضافة</a>

<section id="basic-datatable">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <table class="datatables-basic table table-responsive-md yajra-datatable">
                    <thead>
                        <tr>

                                <th>#</th>
                                <th>اسم المستخدم</th>
                                <th>البريد الالكتروني</th>
                                <th>نوع المستخدم</th>
                                {{-- <th>حالة المستخدم</th> --}}
                                <th>العمليات</th>


                        </tr>
                    </thead>

                    <tbody>

                    </tbody>

                </table>

            </div>
        </div>
    </div>
    <!-- Modal to add new record -->

</section>


{{-- modal add --}}
<div class="form-modal-ex" id="modal_add">
    <div class="modal fade text-left" id="inlineForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">اضافة ادمن</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="add_user_form">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="hidden" name="id" id="id">
                                <label>الاسم </label>
                                <div class="form-group">
                                    <input type="text" placeholder="name" name="name" id="name" class="form-control" />
                                    <span id="name_error" class="text-danger"></span>
                                </div></div>
                            <div class="col-md-6">
                                <label>الايميل </label>
                                <div class="form-group">
                                    <input type="email" placeholder="email" name="email" id="email"  class="form-control" />
                                    <span id="email_error" class="text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label>اسم الدور </label>
                                <div class="form-group">

                                    {{-- <select class="form-select form-control" size="3" name="roles_name" id="roles_name" aria-label=".form-select-lg example"> --}}
                                        <select class="form-select form-select-lg mb-3 form-control" name="roles_name" id="roles_name" aria-label=".form-select-lg example">

                                            <option selected>-------</option>
                                            <?php  $m = App\Models\Dashboard\Role::where('id','!=',8)->get();?>

                                            @foreach ($m as $n)

                                            <option value="{{ $n->name }}">{{ $n->name }}</option>

                                            @endforeach

                                     </select>
                                    <span id="roles_name_error" class="text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label>الحالة </label>
                                <div class="form-group">


                                        <select class="form-select form-select-lg mb-3 form-control" name="status" id="status" aria-label=".form-select-lg example">

                                            <option selected>-------</option>
                                            <option value="1">مفعل</option>
                                            <option value="0">غير مفعل</option>

                                        </select>
                                    <span id="status_error" class="text-danger"></span>
                                </div>
                            </div>





                            <div class="col-md-6">
                                <label>كلمة السر </label>
                                <div class="form-group">
                                    <input type="password" name="password" id="password" class="form-control" />
                                    <span id="password_error" class="text-danger"></span>
                                </div>
                            </div>

                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" style="display: none" id="add_user2" class="btn btn-primary btn-block">تتم الاضافة ...</button>
                        <button type="button" id="add_user" class="btn btn-primary btn-block">اضافة</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


{{-- modal edit --}}
<div class="form-modal-ex">
    <div class="modal fade text-left" id="edit_user" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">تعديل ادمن  </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="edit_user_form">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <input type="hidden" name="id" id="id2">
                                <label>الاسم </label>
                                <div class="form-group">
                                    <input type="text" placeholder="name" name="name" id="name2" class="form-control" />
                                    <span id="name2_error" class="text-danger"></span>
                                </div></div>
                            <div class="col-md-6">
                                <label>الايميل </label>
                                <div class="form-group">
                                    <input type="email" placeholder="email" name="email" id="email2"  class="form-control" />
                                    <span id="email2_error" class="text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label>اسم الدور </label>
                                <div class="form-group">

                                    {{-- <select class="form-select form-control" size="3" name="roles_name" id="roles_name" aria-label=".form-select-lg example"> --}}
                                        <select class="form-select form-select-lg mb-3 form-control" name="roles_name" id="roles_name2" aria-label=".form-select-lg example">

                                            <option selected>-------</option>
                                            <?php  $m = App\Models\Dashboard\Role::where('id','!=',8)->get();?>

                                            @foreach ($m as $n)

                                            <option value="{{ $n->name }}">{{ $n->name }}</option>

                                            @endforeach

                                     </select>
                                    <span id="roles_name2_error" class="text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label>الحالة </label>
                                <div class="form-group">


                                        <select class="form-select form-select-lg mb-3 form-control" name="status" id="status2" aria-label=".form-select-lg example">

                                            <option selected>-------</option>
                                            <option value="1">مفعل</option>
                                            <option value="0">غير مفعل</option>

                                        </select>
                                    <span id="status2_error" class="text-danger"></span>
                                </div>
                            </div>




                            @if(Auth::user()->email != "developers@mirmaz.com" )
                            <div class="col-md-6">
                                <label>كلمة السر </label>
                                <div class="form-group">
                                    <input type="password" name="password" id="password2" class="form-control" />
                                    <span id="password2_error" class="text-danger"></span>
                                </div>
                            </div>
                            @endif


                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" style="display: none" id="editing2" class="btn btn-primary btn-block"> يتم التعديل ...</button>
                        <button type="button" id="editing" onclick="do_update()" class="btn btn-primary btn-block">حفظ التعديلات</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- delete user --}}
<div class="modal fade modal-danger text-left" id="delete_user" tabindex="-1" role="dialog" aria-labelledby="myModalLabel120" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel120">حذف ادمن </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="delete_user_form">
                    @csrf
                    <input type="hidden" name="id" id="id3">
                     هل انت متأكد من عملية الحذف ؟
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" id="delete_user2" style="display: none" data-dismiss="modal">...يتم الحذف</button>
                        <button type="button" class="btn btn-danger" onclick="do_delete()" id="delete_user_button" data-dismiss="modal">تأكيد</button>
                    </div>
                </form>
        </div>
    </div>
</div>



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
        function msg_send(){

            Swal.fire({
                position: 'top-start',
                icon: 'success',
                title: 'تم الارسال بنجاح ',
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
            ajax: "{{ route('dashboard.get_all_admins') }}",
            columns: [
                {data: 'DT_RowIndex',  name: 'DT_RowIndex', orderable: false, searchable: false},
                {data: 'name'         ,name: 'name'},
                {data: 'email'        ,name: 'email'},
                {data: 'roles_name'   ,name: 'roles_name'},
                // {data: 'status'       ,name: 'status'},
                {data: 'action'     ,  name: 'action'},
            ],
            "lengthMenu": [[5,25,50,-1],[5,25,50,'All']],     // page length options
        });
        });
    </script>
    {{-- defaultContent عشان اذا في بعض الحقول فاضية..ما يرجعلي ايرور من الياجرا داتاتبل وبحطلي بدالها "-" --}}



    {{-- open modal add user --}}
    <script>
        $('#modal_add').on('show.bs.modal', function(event) {
            $('#name').text('');
            $('#email').text('');
            $('#mobile').text('');
            $('#password').text('');
            $('#phone').text('');
            $('#address').text('');




        })
</script>


    {{-- add user --}}
    <script>
        $(document).on('click', '#add_user', function (e) {
            // $('#name_error').text('');


            $("#add_user2").css("display", "block");
            $("#add_user").css("display", "none");
            var formData = new FormData($('#add_user_form')[0]);
                $.ajax({
                    type: 'post',
                    enctype: 'multipart/form-data',
                    url: "{{route('dashboard.store_admins')}}",
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
    </script>


    {{-- edit user --}}
    <script>
        $('#edit_user').on('show.bs.modal', function(event) {



            var button = $(event.relatedTarget)
            var id =             button.data('id')
            var name =           button.data('name')
            var email =          button.data('email')
            var password =       button.data('password')
            var status =         button.data('status')
            var roles_name =     button.data('roles_name')

            var modal = $(this)
            modal.find('.modal-body #id2').val(id);
            modal.find('.modal-body #name2').val(name);
            modal.find('.modal-body #email2').val(email);
            modal.find('.modal-body #password2').val(password);
            modal.find('.modal-body #status2').val(status);
            modal.find('.modal-body #roles_name2').val(roles_name);
        })
    </script>


   {{-- update user --}}
   <script>
        function do_update(){

            $('#name2_error').text('')
            $('#email2_error').text('')
            $('#password2_error').text('')

            $("#editing").css("display", "none");
            $("#editing2").css("display", "block");

            var formData = new FormData($('#edit_user_form')[0]);
                $.ajax({
                    type: 'post',
                    enctype: 'multipart/form-data',
                    url: "{{route('dashboard.update_admins')}}",
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
   </script>

    {{-- fill delete modal user --}}
    <script>
        $('#delete_user').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id     =  button.data('id')
            var modal = $(this)
            modal.find('.modal-body #id3').val(id);
        })
    </script>


   {{-- delete user--}}
   <script>
        function do_delete(){

            $("#delete_user_button").css("display", "none");
            $("#delete_user2").css("display", "block");
            var formData = new FormData($('#delete_user_form')[0]);
            $.ajax({
                type: 'post',
                url: "{{route('dashboard.destroy_admins')}}",
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
   </script>


@endsection
