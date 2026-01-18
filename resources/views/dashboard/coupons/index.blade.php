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
        <li class="breadcrumb-item"><a href="#">القسيمات الشرائية </a>
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
                            <th>كود القسيمة</th>
                            <th>نوع الخصم</th>
                            <th>كمية الخصم</th>
                            <th> عدد الاستخدامات</th>
                            <th> المرات المستخدمة</th>
                            <th> تاريخ الانتهاء</th>
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
                    <h4 class="modal-title" id="myModalLabel33">اضافة قسيمة شرائية</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="add_coupon_form">
                    @csrf
                    <div class="modal-body">
                        <div class="row">


                            <div class="col-md-12">
                                <label> عدد الاستخدامات </label>
                                <div class="form-group">
                                    <input type="number" placeholder="عدد الاستخدامات" name="usage_limit" id="usage_limit"  class="form-control" />
                                    <span id="usage_limit_error" class="text-danger"></span>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <label> نوع الخصم </label>
                                <div class="form-group">
                                    <select class="form-select form-select-lg mb-3 form-control" name="type"  id="type" aria-label=".form-select-lg example">

                                        <option selected>-------</option>
                                        <option value="percentage">نسبة مئوية</option>
                                        <option value="fixed">مبلغ ثابت</option>

                                    </select>
                                    <span id="type_error" class="text-danger"></span>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <label> كمية الخصم </label>
                                <div class="form-group">
                                    <input type="number" placeholder="كمية الخصم" name="discount_amount" id="discount_amount"  class="form-control" />
                                    <span id="discount_amount_error" class="text-danger"></span>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <label> تاريخ الانتهاء </label>
                                <div class="form-group">
                                    <input type="date" placeholder="تاريخ الانتهاء" name="expiry_date" id="expiry_date"  class="form-control" />
                                    <span id="expiry_date_error" class="text-danger"></span>
                                </div>
                            </div>

                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" style="display: none" id="add_coupon2" class="btn btn-primary btn-block">تتم الاضافة ...</button>
                        <button type="button" id="add_coupon" class="btn btn-primary btn-block">اضافة</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


{{-- modal edit --}}
<div class="form-modal-ex">
    <div class="modal fade text-left" id="edit_coupon" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">تعديل </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="edit_coupon_form">
                    @csrf
                    <div class="modal-body">
                        <div class="row">

                            <input type="hidden" name="id" id="id2">

                            <div class="col-md-12">
                                <label> عدد الاستخدامات </label>
                                <div class="form-group">
                                    <input type="number" placeholder="عدد الاستخدامات" name="usage_limit" id="usage_limit2"  class="form-control" />
                                    <span id="usage_limit2_error" class="text-danger"></span>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <label> نوع الخصم </label>
                                <div class="form-group">
                                    <select class="form-select form-select-lg mb-3 form-control" name="type"  id="type2" aria-label=".form-select-lg example">

                                        <option selected>-------</option>
                                        <option value="percentage">نسبة مئوية</option>
                                        <option value="fixed">مبلغ ثابت</option>

                                    </select>
                                    <span id="type2_error" class="text-danger"></span>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label> كمية الخصم </label>
                                <div class="form-group">
                                    <input type="number" placeholder="كمية الخصم" name="discount_amount" id="discount_amount2"  class="form-control" />
                                    <span id="discount_amount2_error" class="text-danger"></span>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <label> تاريخ الانتهاء </label>
                                <div class="form-group">
                                    <input type="date" placeholder="تاريخ الانتهاء" name="expiry_date" id="expiry_date2"  class="form-control" />
                                    <span id="expiry_date2_error" class="text-danger"></span>
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

{{-- delete coupon --}}
<div class="modal fade modal-danger text-left" id="delete_coupon" tabindex="-1" role="dialog" aria-labelledby="myModalLabel120" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel120">حذف </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="delete_coupon_form">
                    @csrf
                    <input type="hidden" name="id" id="id3">
                     هل انت متأكد من عملية الحذف ؟
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" id="delete_coupon2" style="display: none" data-dismiss="modal">...يتم الحذف</button>
                        <button type="button" class="btn btn-danger" onclick="do_delete()" id="delete_coupon_button" data-dismiss="modal">تأكيد</button>
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
            ajax: "{{ route('dashboard.get_all_coupons') }}",
            columns: [
                {data: 'DT_RowIndex'   ,name: 'DT_RowIndex', orderable: false, searchable: false},
                {data: 'code'          ,name: 'code'},
                {data: 'type',name: 'type'},
                {data: 'discount_amount' ,name: 'discount_amount'},
                {data: 'usage_limit'       ,name: 'usage_limit'},
                {data: 'used_count'       ,name: 'used_count'},
                {data: 'expiry_date'       ,name: 'expiry_date'},
                {data: 'status'       ,name: 'status'},
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
            // $('#city').text('');
            // $("#image").attr('src', "{{  env('APP_URL') }}/attachments/downloads/download.png");


        })
    </script>

    {{-- add user --}}
    <script>
        $(document).on('click', '#add_coupon', function (e) {
            $('#name_error').text('');
            $('#image_error').text('');
            $('#usage_limit_error').text('');
            $('#type_error').text('');
            $('#discount_amount_error').text('');
            $('#expiry_date_error').text('');

            $("#add_coupon2").css("display", "block");
            $("#add_coupon").css("display", "none");
            var formData = new FormData($('#add_coupon_form')[0]);
                $.ajax({
                    type: 'post',
                    enctype: 'multipart/form-data',
                    url: "{{route('dashboard.store_coupons')}}",
                    data: formData,
                    processData: false,
                    contentType: false,
                    cache: false,
                    success: function (data) {

                            $('.yajra-datatable').DataTable().ajax.reload(null, false);
                            $("#add_coupon2").css("display", "none");
                            $("#add_coupon").css("display", "block");
                            $('.close').click();
                            $('#name').val('');
                            $("#image").attr('src', "{{  env('APP_URL') }}/attachments/downloads/download.png");
                            $('#change-picture').val('');
                            $('#position-top-start').click();

                    },
                    error: function (reject) {
                        $("#add_coupon2").css("display", "none");
                        $("#add_coupon").css("display", "block");
                        var response = $.parseJSON(reject.responseText);
                        $.each(response.errors, function (key, val) {
                            $("#" + key + "_error").text(val[0]);
                        });
                    }
                });
            });
    </script>


    {{-- edit coupon --}}
    <script>
        $('#edit_coupon').on('show.bs.modal', function(event) {

            var button = $(event.relatedTarget)
            var id =                  button.data('id')
            var type =                button.data('type')
            var discount_amount =             button.data('discount_amount')
            var usage_limit =             button.data('usage_limit')
            var expiry_date =             button.data('expiry_date')




            var modal = $(this)
            modal.find('.modal-body #id2').val(id);
            modal.find('.modal-body #type2').val(type);
            modal.find('.modal-body #discount_amount2').val(discount_amount);
            modal.find('.modal-body #usage_limit2').val(usage_limit);
            modal.find('.modal-body #expiry_date2').val(expiry_date);



        })
    </script>


   {{-- update coupon --}}
   <script>
        function do_update(){

            $('#name2_error').text('');
            $('#usage_limit2_error').text('');
            $('#type2_error').text('');
            $('#discount_amount2_error').text('');
            $('#expiry_date2_error').text('');

            $("#editing").css("display", "none");
            $("#editing2").css("display", "block");

            var formData = new FormData($('#edit_coupon_form')[0]);
                $.ajax({
                    type: 'post',
                    enctype: 'multipart/form-data',
                    url: "{{route('dashboard.update_coupons')}}",
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

    {{-- fill delete modal coupon --}}
    <script>
        $('#delete_coupon').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id     =  button.data('id')
            var modal = $(this)
            modal.find('.modal-body #id3').val(id);
        })
    </script>


   {{-- delete coupon--}}
   <script>
        function do_delete(){

            $("#delete_coupon_button").css("display", "none");
            $("#delete_coupon2").css("display", "block");
            var formData = new FormData($('#delete_coupon_form')[0]);
            $.ajax({
                type: 'post',
                url: "{{route('dashboard.destroy_coupons')}}",
                data: formData,
                processData: false,
                contentType: false,
                success: function (data) {
                    $("#delete_coupon2").css("display", "none");
                    $("#delete_coupon_button").css("display", "block");
                    $('.close').click();
                    $('#position-top-start_delete').click();
                    $('.yajra-datatable').DataTable().ajax.reload(null, false);

                }, error: function (reject) {
                }
            });
     }
   </script>



@endsection
