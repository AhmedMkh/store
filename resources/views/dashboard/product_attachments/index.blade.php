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
 <button class="btn btn-outline-primary" style="display: none" onclick="msg_status()" id="position-top-status"></button>




<div class="breadcrumb-wrapper">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">   لوحة التحكم </a>
        </li>
        <li class="breadcrumb-item"><a href="#"> مرفقات المنتجات </a>
        </li>
    </ol>
</div>


@can('اضافة طالب')
<a class="btn btn-primary" data-toggle="modal" href="#inlineForm" style="margin-bottom:1%">اضافة</a>
@endcan

<section id="basic-datatable">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <table class="datatables-basic table table-responsive-md yajra-datatable">
                    <thead>
                        <tr>

                            <th>#</th>
                            <th>النوع</th>
                            <th>المرفق</th>
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
                    <h4 class="modal-title" id="myModalLabel33">اضافة مرفق</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="add_user_form">
                    @csrf
                    <div class="modal-body">
                        <div class="row">

                            <input type="hidden" name="product_id" value="{{ $product_id }}">

                            <div class="col-md-6">
                                <label>النوع </label>
                                <div class="form-group">


                                        <select class="form-select form-select-lg mb-3 form-control" name="type" id="type" aria-label=".form-select-lg example">

                                            <option selected>-------</option>
                                            <option value="image">صورة</option>
                                            <option value="video">فيديو</option>

                                        </select>
                                    <span id="type_error" class="text-danger"></span>
                                </div>
                            </div>

                            <!-- قسم الصورة -->
                            <div class="col-md-12" id="image_section" style="display: none;">
                                <div class="media mb-2">
                                    <img src="" alt="users avatar" id="image" class="user-avatar users-avatar-shadow rounded mr-2 my-25 cursor-pointer" height="90" width="90" />
                                    <div class="media-body mt-50">
                                        <div class="col-12 d-flex mt-1 px-0">
                                            <label class="btn btn-primary mr-75 mb-0" for="change-picture">
                                                <span class="d-none d-sm-block">اضافة صورة</span>
                                                    <input class="form-control" type="file" multiple id="change-picture" name="image" hidden accept="image/png, image/jpeg, image/jpg" />
                                                    <span class="d-block d-sm-none">
                                                    <i class="mr-0" data-feather="edit"></i>
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                    <span id="image_error" class="text-danger"></span>
                                </div>
                            </div>

                            <!-- قسم الفيديو -->
                            <div class="col-md-12" id="video_section" style="display: none;">
                                <label>رابط الفيديو</label>
                                <div class="form-group">
                                    <input type="url" placeholder="ضع رابط الفيديو هنا" name="video_url" id="video_url" class="form-control" />
                                    <span id="video_url_error" class="text-danger"></span>
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


{{-- delete user --}}
<div class="modal fade modal-danger text-left" id="delete_user" tabindex="-1" role="dialog" aria-labelledby="myModalLabel120" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel120">حذف </h5>
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
        function msg_status(){

            Swal.fire({
                position: 'top-start',
                icon: 'success',
                title: 'تم تعديل الحالة بنجاح',
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
            ajax: "{{ route('dashboard.get_all_subcategories') }}",
            columns: [
                {data: 'DT_RowIndex'   ,name: 'DT_RowIndex', orderable: false, searchable: false},
                {data: 'name'          ,name: 'name'},
                {data: 'slug'       ,name: 'slug'},
                {data: 'category', name: 'category.name'},
                {data: 'image'         ,name: 'image'},
                {data: 'status'        ,name: 'status'},
                {data: 'action'        ,name: 'action'},
            ],
            "lengthMenu": [[5,25,50,-1],[5,25,50,'All']],     // page length options
        });
        });
    </script>
    {{-- defaultContent عشان اذا في بعض الحقول فاضية..ما يرجعلي ايرور من الياجرا داتاتبل وبحطلي بدالها "-" --}}



    {{-- open modal add user --}}
    <script>
        $('#modal_add').on('show.bs.modal', function(event) {
            $('#city').text('');
            $("#image").attr('src', "{{  env('APP_URL') }}/attachments/downloads/download.png");
            $('#type').val('');
            $('#video_url').val('');
            $('#change-picture').val('');
            $('#image_section').hide();
            $('#video_section').hide();
        })
    </script>

    {{-- show/hide image or video fields based on type selection --}}
    <script>
        $(document).on('change', '#type', function() {
            let selectedType = $(this).val();

            if (selectedType === 'image') {
                $('#image_section').show();
                $('#video_section').hide();
            } else if (selectedType === 'video') {
                $('#video_section').show();
                $('#image_section').hide();
            } else {
                $('#image_section').hide();
                $('#video_section').hide();
            }
        });
    </script>

    <script>
        $(function () {
            'use strict';
            var changePicture = $('#change-picture'),
                userAvatar = $('#image');
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

    <script>
        $(function () {
            'use strict';
            var changePicture = $('#change-picture2'),
                userAvatar = $('#image2');
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




    {{-- add user --}}
    <script>
        $(document).on('click', '#add_user', function (e) {
            $('#type_error').text('');
            $('#image_error').text('');
            $('#video_url_error').text('');

            $("#add_user2").css("display", "block");
            $("#add_user").css("display", "none");
            var formData = new FormData($('#add_user_form')[0]);
                $.ajax({
                    type: 'post',
                    enctype: 'multipart/form-data',
                    url: "{{route('dashboard.store_subcategories')}}",
                    data: formData,
                    processData: false,
                    contentType: false,
                    cache: false,
                    success: function (data) {

                            $('.yajra-datatable').DataTable().ajax.reload(null, false);
                            $("#add_user2").css("display", "none");
                            $("#add_user").css("display", "block");
                            $('.close').click();
                            $('#type').val('');
                            $('#video_url').val('');
                            $("#image").attr('src', "{{  env('APP_URL') }}/attachments/downloads/download.png");
                            $('#change-picture').val('');
                            $('#image_section').hide();
                            $('#video_section').hide();
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
                url: "{{route('dashboard.destroy_subcategories')}}",
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
