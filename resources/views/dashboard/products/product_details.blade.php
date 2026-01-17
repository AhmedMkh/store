@extends('layouts.main_page')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/tables/datatable/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/tables/datatable/responsive.bootstrap4.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css-rtl/plugins/extensions/ext-component-sweet-alerts.css')}}">
@endsection

@section('content')
    <!-- Toast Notifications -->
    <button class="btn btn-outline-primary" style="display: none" onclick="msg_add()" id="position-top-start"></button>
    <button class="btn btn-outline-primary" style="display: none" onclick="msg_delete()" id="position-top-start_delete"></button>

    <!-- Breadcrumb -->
    <div class="breadcrumb-wrapper mb-3">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('dashboard.products')}}">المنتجات</a></li>
            <li class="breadcrumb-item">تفاصيل المنتج</li>
        </ol>
    </div>

    <!-- Product Details Section -->
    <section class="mb-4">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">تفاصيل المنتج</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- Product Image -->
                            <div class="col-md-3 mb-3">
                                <img src="{{$product->image}}" alt="{{$product->name}}" class="img-fluid rounded" style="max-height: 300px; object-fit: cover;">
                            </div>

                            <!-- Product Info -->
                            <div class="col-md-9">
                                <div class="row mb-2">
                                    <div class="col-md-6">
                                        <h6 class="text-muted mb-1">الاسم</h6>
                                        <p class="fw-bold">{{$product->name}}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <h6 class="text-muted mb-1">Slug</h6>
                                        <p class="fw-bold">{{$product->slug}}</p>
                                    </div>
                                </div>

                                <div class="row mb-2">
                                    <div class="col-md-6">
                                        <h6 class="text-muted mb-1">القسم الفرعي</h6>
                                        <p class="fw-bold">{{$product->subcategory?->name ?? '-'}}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <h6 class="text-muted mb-1">الحالة</h6>
                                        <p class="fw-bold">
                                            <span class="badge {{$product->status === 'active' ? 'bg-success' : 'bg-danger'}}">
                                                {{$product->status === 'active' ? 'مفعل' : 'غير مفعل'}}
                                            </span>
                                        </p>
                                    </div>
                                </div>

                                <div class="row mb-2">
                                    <div class="col-md-6">
                                        <h6 class="text-muted mb-1">السعر</h6>
                                        <p class="fw-bold text-primary">{{$product->price}} ر.س</p>
                                    </div>
                                    <div class="col-md-6">
                                        <h6 class="text-muted mb-1">سعر الخصم</h6>
                                        <p class="fw-bold text-success">{{$product->discount_price ?? '-'}} ر.س</p>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-12">
                                        <h6 class="text-muted mb-1">الوصف</h6>
                                        <p>{{$product->description}}</p>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <a href="{{route('dashboard.products')}}" class="btn btn-secondary">
                                            <i class="fa fa-arrow-left"></i> العودة للمنتجات
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Product Attachments Section -->
    <section class="mb-4">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">المرفقات (صور وفيديوهات)</h5>
                        <button class="btn btn-sm btn-primary" data-toggle="modal" href="#addAttachmentModal">
                            <i class="fa fa-plus"></i> إضافة مرفق
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th style="width: 50px;">#</th>
                                        <th>النوع</th>
                                        <th>المحتوى</th>
                                        <th>تاريخ الإضافة</th>
                                        <th style="width: 100px;">الإجراءات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($product->attachments ?? [] as $attachment)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>
                                                <span class="badge" style="background-color: {{$attachment->type === 'image' ? '#4539ad' : '#ff6b6b'}}; color: white;">                                                    {{$attachment->type === 'image' ? 'صورة' : 'فيديو'}}
                                                </span>
                                            </td>
                                            <td>
                                                @if($attachment->type === 'image')
                                                    <img src="{{$attachment->image}}" alt="" style="max-width: 100px; max-height: 80px;" class="rounded">
                                                @else
                                                    <a href="{{$attachment->video}}" target="_blank" class="btn btn-sm btn-info">
                                                        <i class="fa fa-video"></i> عرض الفيديو
                                                    </a>
                                                @endif
                                            </td>
                                            <td>{{$attachment->created_at?->format('Y-m-d H:i')}}</td>
                                            <td>
                                                <button class="btn btn-sm btn-danger" onclick="deleteAttachment({{$attachment->id}})" title="حذف">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center text-muted py-4">لا توجد مرفقات</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Product Comments Section -->
    <section class="mb-4">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">التعليقات</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th style="width: 50px;">#</th>
                                        <th>المستخدم</th>
                                        <th>المحتوى</th>
                                        <th>تاريخ الإضافة</th>
                                        <th style="width: 100px;">الإجراءات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($product->comments ?? [] as $comment)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td>{{$comment->user?->name ?? '-'}}</td>
                                            <td>
                                                <span title="{{$comment->content}}">{{substr($comment->content, 0, 50)}}{{strlen($comment->content) > 50 ? '...' : ''}}</span>
                                            </td>
                                            <td>{{$comment->created_at?->format('Y-m-d H:i')}}</td>
                                            <td>
                                                <button class="btn btn-sm btn-danger" onclick="deleteComment({{$comment->id}})" title="حذف">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center text-muted py-4">لا توجد تعليقات</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Add Attachment Modal -->
    <div class="modal fade text-left" id="addAttachmentModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">إضافة مرفق</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="addAttachmentForm">
                    @csrf
                    <input type="hidden" name="product_id" value="{{$product->id}}">
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label>نوع المرفق</label>
                            <select class="form-control" name="type" id="attachmentType" required>
                                <option value="">اختر النوع</option>
                                <option value="image">صورة</option>
                                <option value="video">فيديو</option>
                            </select>
                            <span class="text-danger" id="type_error"></span>
                        </div>

                        <div class="form-group mb-3" id="imageInput" style="display: none;">
                            <label>الصورة</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" name="image" id="imageFile" accept="image/*">
                                <label class="custom-file-label" for="imageFile">اختر صورة</label>
                            </div>
                            <span class="text-danger" id="image_error"></span>
                        </div>

                        <div class="form-group mb-3" id="videoInput" style="display: none;">
                            <label>رابط الفيديو</label>
                            <input type="url" class="form-control" name="video" id="videoUrl" placeholder="https://example.com/video">
                            <span class="text-danger" id="video_error"></span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">إلغاء</button>
                        <button type="button" class="btn btn-primary" id="addAttachmentBtn" onclick="addAttachment()">إضافة</button>
                        <button type="button" class="btn btn-primary" id="addAttachmentLoading" style="display: none;" disabled>
                            <span class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true"></span>
                            جاري الإضافة...
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script src="{{asset('app-assets/vendors/js/extensions/sweetalert2.all.min.js')}}"></script>
    <script src="{{asset('app-assets/js/scripts/extensions/ext-component-sweet-alerts.js')}}"></script>

    <script>
        // Toggle between image and video input
        $(document).ready(function () {
            $('#attachmentType').on('change', function () {
                const type = $(this).val();
                $('#imageInput').hide();
                $('#videoInput').hide();
                if (type === 'image') {
                    $('#imageInput').show();
                    $('#imageFile').attr('required', 'required');
                    $('#videoUrl').removeAttr('required');
                } else if (type === 'video') {
                    $('#videoInput').show();
                    $('#videoUrl').attr('required', 'required');
                    $('#imageFile').removeAttr('required');
                }
            });
        });

        // Add Attachment
        function addAttachment() {
            clearAttachmentErrors();
            const type = $('#attachmentType').val();

            if (!type) {
                $('#type_error').text('يجب اختيار نوع المرفق');
                return;
            }

            const formData = new FormData($('#addAttachmentForm')[0]);

            $('#addAttachmentBtn').hide();
            $('#addAttachmentLoading').show();

            $.ajax({
                type: 'POST',
                url: "{{ route('dashboard.store_product_attachments') }}",
                data: formData,
                processData: false,
                contentType: false,
                success: function (data) {
                    msg_add();
                    $('#addAttachmentModal').modal('hide');
                    $('#addAttachmentForm')[0].reset();
                    setTimeout(() => location.reload(), 1000);
                },
                error: function (reject) {
                    const response = $.parseJSON(reject.responseText);
                    $.each(response.errors, function (key, val) {
                        $('#' + key + '_error').text(val[0]);
                    });
                },
                complete: function () {
                    $('#addAttachmentBtn').show();
                    $('#addAttachmentLoading').hide();
                }
            });
        }

        // Delete Attachment
        function deleteAttachment(attachmentId) {
            Swal.fire({
                title: 'هل أنت متأكد؟',
                text: 'هذا الإجراء لا يمكن التراجع عنه',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'نعم، احذفها',
                cancelButtonText: 'إلغاء'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('dashboard.destroy_product_attachments') }}",
                        data: {
                            '_token': '{{ csrf_token() }}',
                            'id': attachmentId
                        },
                        success: function (data) {
                            msg_delete();
                            setTimeout(() => location.reload(), 1000);
                        },
                        error: function () {
                            Swal.fire('خطأ', 'حدث خطأ أثناء حذف المرفق', 'error');
                        }
                    });
                }
            });
        }

        // Add Comment
        function addComment() {
            clearCommentErrors();
            const content = $('#commentContent').val();

            if (!content) {
                $('#content_error').text('يجب إدخال محتوى التعليق');
                return;
            }

            const formData = new FormData($('#addCommentForm')[0]);

            $('#addCommentBtn').hide();
            $('#addCommentLoading').show();

            $.ajax({
                type: 'POST',
                url: "{{ route('dashboard.store_comments') }}",
                data: formData,
                processData: false,
                contentType: false,
                success: function (data) {
                    msg_add();
                    $('#addCommentModal').modal('hide');
                    $('#addCommentForm')[0].reset();
                    setTimeout(() => location.reload(), 1000);
                },
                error: function (reject) {
                    const response = $.parseJSON(reject.responseText);
                    $.each(response.errors, function (key, val) {
                        $('#' + key + '_error').text(val[0]);
                    });
                },
                complete: function () {
                    $('#addCommentBtn').show();
                    $('#addCommentLoading').hide();
                }
            });
        }

        // Delete Comment
        function deleteComment(commentId) {
            Swal.fire({
                title: 'هل أنت متأكد؟',
                text: 'هذا الإجراء لا يمكن التراجع عنه',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'نعم، احذفها',
                cancelButtonText: 'إلغاء'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('dashboard.destroy_comments') }}",
                        data: {
                            '_token': '{{ csrf_token() }}',
                            'id': commentId
                        },
                        success: function (data) {
                            msg_delete();
                            setTimeout(() => location.reload(), 1000);
                        },
                        error: function () {
                            Swal.fire('خطأ', 'حدث خطأ أثناء حذف التعليق', 'error');
                        }
                    });
                }
            });
        }

        // Clear attachment form errors
        function clearAttachmentErrors() {
            $('#type_error').text('');
            $('#image_error').text('');
            $('#video_error').text('');
        }

        // Clear comment form errors
        function clearCommentErrors() {
            $('#content_error').text('');
        }

        // Toast notification functions
        function msg_add() {
            Swal.fire({
                position: 'top-start',
                icon: 'success',
                title: 'تمت الإضافة بنجاح',
                showConfirmButton: false,
                timer: 1500,
                customClass: {
                    confirmButton: 'btn btn-primary'
                },
                buttonsStyling: false
            });
        }

        function msg_delete() {
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
@endsection
