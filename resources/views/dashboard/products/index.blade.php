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
        <li class="breadcrumb-item"><a href="#"> المنتجات </a>
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
                            <th>اسم المنتج</th>
                            <th>slug</th>
                            <th>القسم الفرعي</th>
                            <th>الوصف</th>
                            <th>السعر</th>
                            <th>سعر الخصم</th>
                            <th>الصورة</th>
                            <th>الحالة</th>
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
                    <h4 class="modal-title" id="myModalLabel33">اضافة منتج</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="add_user_form">
                    @csrf
                    <div class="modal-body">
                        <div class="row">


                            <div class="col-md-12">
                                <label> الاسم </label>
                                <div class="form-group">
                                    <input type="name" placeholder="الاسم" name="name" id="name"  class="form-control" />
                                    <span id="name_error" class="text-danger"></span>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <label>الوصف</label>
                                <div class="form-group">
                                    <textarea class="form-control" name="description" id="description" placeholder="الوصف" row="4"></textarea>
                                    <span id="description_error" class="text-danger"></span>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <label>القسم الفرعي</label>
                                <div class="form-group">
                                    <select class="form-select form-select-lg mb-3 form-control" name="subcategory_id" id="subcategory_id" aria-label=".form-select-lg example">
                                        <option selected>اختر القسم الفرعي</option>
                                        @forelse($subcategories as $subcategory)
                                            <option value="{{ $subcategory->id }}">{{ $subcategory->name }}</option>
                                        @empty
                                            <option disabled>لا توجد أقسام فرعية</option>
                                        @endforelse
                                    </select>
                                    <span id="subcategory_id_error" class="text-danger"></span>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <label>السعر</label>
                                <div class="form-group">
                                    <input type="number" placeholder="السعر" name="price" id="price"  class="form-control" />
                                    <span id="price_error" class="text-danger"></span>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <label>سعر الخصم</label>
                                <div class="form-group">
                                    <input type="number" placeholder="سعر الخصم" name="discount_price" id="discount_price"  class="form-control" />
                                    <span id="discount_price_error" class="text-danger"></span>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label>الحالة </label>
                                <div class="form-group">


                                        <select class="form-select form-select-lg mb-3 form-control" name="status" id="status" aria-label=".form-select-lg example">

                                            <option selected>-------</option>
                                            <option value="active">مفعل</option>
                                            <option value="inactive">غير مفعل</option>

                                        </select>
                                    <span id="status_error" class="text-danger"></span>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="media mb-2">
                                    <img src="" alt="users avatar" id="image" class="user-avatar users-avatar-shadow rounded mr-2 my-25 cursor-pointer" height="90" width="90" />
                                    <div class="media-body mt-50">
                                        <div class="col-12 d-flex mt-1 px-0">
                                            <label class="btn btn-primary mr-75 mb-0" for="change-picture">
                                                <span class="d-none d-sm-block">تغيير الصورة</span>
                                                    <input class="form-control" type="file" multiple id="change-picture" name="image" hidden required accept="image/png, image/jpeg, image/jpg" />
                                                    <span class="d-block d-sm-none">
                                                    <i class="mr-0" data-feather="edit"></i>
                                                </span>
                                            </label>
                                            <button class="btn btn-outline-secondary d-block d-sm-none">
                                                <i class="mr-0" data-feather="trash-2"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <span id="image_error" class="text-danger"></span>
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
                    <h4 class="modal-title" id="myModalLabel33">تعديل </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="edit_user_form">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <input type="hidden" name="id" id="id2">
                                <label> الاسم </label>
                                <div class="form-group">
                                    <input type="text" placeholder="الاسم" name="name" id="name2" class="form-control" />
                                    <span id="name2_error" class="text-danger"></span>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <label>الوصف</label>
                                <div class="form-group">
                                    <textarea class="form-control" name="description" id="description2" placeholder="الوصف" row="4"></textarea>
                                    <span id="description2_error" class="text-danger"></span>
                                </div>
                            </div>

                            

                            <div class="col-md-12">
                                <label>القسم الفرعي</label>
                                <div class="form-group">
                                    <select class="form-select form-select-lg mb-3 form-control" name="subcategory_id" id="subcategory_id2" aria-label=".form-select-lg example">
                                        <option selected>اختر القسم الفرعي</option>
                                        @forelse($subcategories as $subcategory)
                                            <option value="{{ $subcategory->id }}">{{ $subcategory->name }}</option>
                                        @empty
                                            <option disabled>لا توجد أقسام فرعية</option>
                                        @endforelse
                                    </select>
                                    <span id="subcategory_id2_error" class="text-danger"></span>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <label>السعر</label>
                                <div class="form-group">
                                    <input type="number" placeholder="السعر" name="price" id="price2"  class="form-control" />
                                    <span id="price2_error" class="text-danger"></span>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <label>سعر الخصم</label>
                                <div class="form-group">
                                    <input type="number" placeholder="سعر الخصم" name="discount_price" id="discount_price2"  class="form-control" />
                                    <span id="discount_price2_error" class="text-danger"></span>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label>الحالة </label>
                                <div class="form-group">


                                        <select class="form-select form-select-lg mb-3 form-control" name="status" id="status2" aria-label=".form-select-lg example">

                                            <option selected>-------</option>
                                            <option value="active">مفعل</option>
                                            <option value="inactive">غير مفعل</option>

                                        </select>
                                    <span id="status_error" class="text-danger"></span>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="media mb-2">
                                    <img src="" alt="users avatar" id="image2" class="user-avatar users-avatar-shadow rounded mr-2 my-25 cursor-pointer" height="90" width="90" />
                                    <div class="media-body mt-50">
                                        <div class="col-12 d-flex mt-1 px-0">
                                            <label class="btn btn-primary mr-75 mb-0" for="change-picture2">
                                                <span class="d-none d-sm-block">تغيير الصورة</span>
                                                    <input class="form-control" type="file" multiple id="change-picture2" name="image" hidden required accept="image/png, image/jpeg, image/jpg" />
                                                    <span class="d-block d-sm-none">
                                                    <i class="mr-0" data-feather="edit"></i>
                                                </span>
                                            </label>
                                            <button class="btn btn-outline-secondary d-block d-sm-none">
                                                <i class="mr-0" data-feather="trash-2"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <span id="image_error" class="text-danger"></span>
                                </div>
                            </div>



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
            ajax: "{{ route('dashboard.get_all_products') }}",
            columns: [
                {data: 'DT_RowIndex'   ,name: 'DT_RowIndex', orderable: false, searchable: false},
                {data: 'name'          ,name: 'name'},
                {data: 'slug'       ,name: 'slug'},
                {data: 'subcategory', name: 'subcategory.name'}, 
                {data: 'description'   ,name: 'description'},
                {data: 'price'         ,name: 'price'},
                {data: 'discount_price',name: 'discount_price'},
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


        })
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


  {{-- change status --}}
    <script>

        $(document).on('change','#cousome_switch', function (e) {


                let id = $(this).data('id');


                $.ajax({
                    type: "post",
                    dataType: "json",
                    url: '{{ route('dashboard.is_view_products') }}',

                    data: {
                            '_token':'{{ csrf_token() }}',
                            'id':id,

                        },
                    success: function (data) {

                        $('#position-top-status').click();
                    }
                });
        });

    </script>




    {{-- add user --}}
    <script>
        $(document).on('click', '#add_user', function (e) {
            $('#name_error').text('');
            $('#image_error').text('');


            $("#add_user2").css("display", "block");
            $("#add_user").css("display", "none");
            var formData = new FormData($('#add_user_form')[0]);
                $.ajax({
                    type: 'post',
                    enctype: 'multipart/form-data',
                    url: "{{route('dashboard.store_products')}}",
                    data: formData,
                    processData: false,
                    contentType: false,
                    cache: false,
                    success: function (data) {

                            $('.yajra-datatable').DataTable().ajax.reload(null, false);
                            $("#add_user2").css("display", "none");
                            $("#add_user").css("display", "block");
                            $('.close').click();
                            $('#name').val('');
                            $("#image").attr('src', "{{  env('APP_URL') }}/attachments/downloads/download.png");
                            $('#change-picture').val('');
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
            var id =                  button.data('id')
            var name =                button.data('name')
            var subcategory_id =         button.data('subcategory_id')
            var description =         button.data('description')
            var price =               button.data('price')
            var discount_price =      button.data('discount_price')
            var status =              button.data('status')
            var image =               button.data('image')



            var modal = $(this)
            modal.find('.modal-body #id2').val(id);
            modal.find('.modal-body #name2').val(name);
            modal.find('.modal-body #subcategory_id2').val(subcategory_id);
            modal.find('.modal-body #status2').val(status);
            modal.find('.modal-body #price2').val(price);
            modal.find('.modal-body #discount_price2').val(discount_price);
            modal.find('.modal-body #description2').val(description);
            $(".modal-body #image2").attr('src', "{{  env('APP_URL') }}/attachments/products/"+image);

        })
    </script>


   {{-- update user --}}
   <script>
        function do_update(){

            $('#name2_error').text('')



            $("#editing").css("display", "none");
            $("#editing2").css("display", "block");

            var formData = new FormData($('#edit_user_form')[0]);
                $.ajax({
                    type: 'post',
                    enctype: 'multipart/form-data',
                    url: "{{route('dashboard.update_products')}}",
                    data: formData,
                    processData: false,
                    contentType: false,
                    cache: false,
                    success: function (data) {
                        $("#editing").css("display", "block");
                        $("#editing2").css("display", "none");

                        $('.close').click();
                        $('#change-picture2').val('');
                        $('#position-top-start_edit').click();
                        $("#image").attr('src', "{{  env('APP_URL') }}/attachments/downloads/download.png");
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
                url: "{{route('dashboard.destroy_products')}}",
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
