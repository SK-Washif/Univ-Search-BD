@extends('layouts.adminpanel.master')


@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        @if (\Session::has('success'))
            <div class="row">
                <div class="col-md-12">
                    <div id="notificationAlert" style="display: block;">

                        <div class="alert alert-warning">
                            <span style="color:black;">
                                {!! \Session::get('success') !!}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <div class="d-flex justify-content-between">
            <div>
                <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Testimonial /</span> list</h4>
            </div>
            <div class="my-auto">
                <a href="{{ route('testimonial.create') }}">
                    <button class="btn btn-info rounded-pill">Add Testimonial</button>
                </a>
            </div>
        </div>
        <!-- Basic Bootstrap Table -->
        <div class="card">

            <div class="table-responsive text-nowrap p-4">
                <table class="table" id="DataTable">
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>Faculty Image</th>
                            <th>Faculty Name</th>
                            {{--  <th>Faculty Designation</th>  --}}
                            {{--  <th>University Name</th>  --}}
                            <th>Posted By</th>
                            <th>Time</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @if ($testimonials->isNotEmpty())
                            @foreach ($testimonials as $key => $data)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>
                                        <img src="{{ asset($data->faculty_image) }}" alt="Faculty Image"
                                            style="max-width: 100px;max-height:80px;">
                                    </td>
                                    <td>{{ $data->faculty_name }}</td>
                                    {{--  <td>{{ $data->faculty_designation }}</td>  --}}
                                    {{--  <td>{{ $data->University->name }}</td>  --}}
                                    <td>{{ $data->user->name }}</td>
                                    <td>{{ date('h:ia', strtotime($data->created_at)) }} <br>
                                        {{ date('d M, Y', strtotime($data->created_at)) }}
                                    </td>

                                    <td>
                                        <form method="POST"
                                            action="{{ route('update-testimonial-status', ['id' => $data->id]) }}">
                                            @csrf
                                            <button type="submit"
                                                class="btn btn-{{ $data->status == 1 ? 'success' : 'warning' }} btn-sm">
                                                {{ $data->status == 1 ? 'Active' : 'Inactive' }}
                                            </button>
                                        </form>
                                    </td>

                                    <td>
                                        <a href="{{ route('testimonial.edit', $data->id) }}"
                                            class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i></a>
                                        <a href="#"
                                            onclick="if(!confirm('Are you sure you want to delete this testimonial?')){event.preventDefault();}else{document.getElementById('delete-form-{{ $key }}').submit();}"
                                            class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></a>
                                        <a href="" class="btn btn-info btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#modalScrollable{{ $data->id }}">
                                            <i class="fa fa-eye" aria-hidden="true"></i>
                                        </a>

                                        <form id="delete-form-{{ $key }}"
                                            action="{{ route('testimonial.destroy', $data->id) }}" method="POST"
                                            style="display: none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>

                                        <div class="modal fade" id="modalScrollable{{ $data->id }}" tabindex="-1"
                                            aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg"
                                                role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="modalScrollableTitle">Testimonial Full
                                                            Information</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form>
                                                            <div class="row mb-3">
                                                                <label class="col-sm-2 col-form-label"
                                                                    for="basic-default-faculty_name">Faculty Name</label>
                                                                <div class="col-sm-10">
                                                                    <input type="text" class="form-control"
                                                                        id="basic-default-faculty_name"
                                                                        value="{{ $data->faculty_name ?? '' }}" readonly />
                                                                </div>
                                                            </div>
                                                            <div class="row mb-3">
                                                                <label class="col-sm-2 col-form-label"
                                                                    for="basic-default-faculty_designation">
                                                                    Designation</label>
                                                                <div class="col-sm-10">
                                                                    <input type="text" class="form-control"
                                                                        id="basic-default-faculty_designation"
                                                                        value="{{ $data->faculty_designation ?? '' }}"
                                                                        readonly />
                                                                </div>
                                                            </div>
                                                            <div class="row mb-3">
                                                                <label class="col-sm-2 col-form-label"
                                                                    for="basic-default-content">Content</label>
                                                                <div class="col-sm-10">
                                                                    {{--  <p class="form-control">{!! $data->content !!}</p>  --}}
                                                                    <textarea class="form-control" name="content" id="basic-default-content" cols="30" rows="10" readonly>{!! $data->content ?? '' !!}</textarea>
                                                                </div>
                                                            </div>
                                                            <div class="row mb-3">
                                                                <label class="col-sm-2 col-form-label"
                                                                    for="basic-default-image2">
                                                                    Image</label>
                                                                <div class="col-sm-10">

                                                                    <img src="{{ asset($data->faculty_image) }}"
                                                                        alt="Blog Image"
                                                                        style="max-width: 100px;max-height:80px;">

                                                                </div>
                                                            </div>

                                                            <div class="row mb-3">
                                                                <label class="col-sm-2 col-form-label"
                                                                    for="basic-default-university">University</label>
                                                                <div class="col-sm-10">
                                                                    <input type="text" class="form-control"
                                                                        id="basic-default-university"
                                                                        value="{{ $data->university->name ?? '' }}"
                                                                        readonly />
                                                                </div>
                                                            </div>

                                                            <div class="row mb-3">
                                                                <label class="col-sm-2 col-form-label"
                                                                    for="basic-default-post">Posted by</label>
                                                                <div class="col-sm-10">
                                                                    <input type="text" class="form-control"
                                                                        id="basic-default-post"
                                                                        value="{{ $data->user->name ?? '' }}" readonly />
                                                                </div>
                                                            </div>
                                                            <div class="row mb-3">
                                                                <label class="col-sm-2 col-form-label"
                                                                    for="basic-default-post">Status</label>
                                                                <div class="col-sm-10">
                                                                    <input type="text" class="form-control"
                                                                        id="basic-default-post"
                                                                        value="{{ $data->status == 1 ? 'Active' : 'Inactive' }}"
                                                                        readonly />
                                                                </div>
                                                            </div>
                                                        </form>

                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-outline-secondary"
                                                            data-bs-dismiss="modal">
                                                            Close
                                                        </button>
                                                        <a class="btn btn-primary"
                                                            href="{{ route('testimonial.edit', $data->id) }}">Edit</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>



                                    </td>
                                </tr>
                            @endforeach
                        @endif

                    </tbody>
                </table>
            </div>
        </div>
        <!--/ Basic Bootstrap Table -->



    </div>
@endsection

@section('header_css')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap4.min.css">
@endsection

@section('footer_js')
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/35.2.1/classic/ckeditor.js"></script>
    {{--  <script>
        ClassicEditor
            .create(document.querySelector('#basic-default-content'))
            .catch(error => {
                console.error(error);
            });
    </script>  --}}
    <script>
        $('#notificationAlert').delay(3000).fadeOut('slow');
        $(document).ready(function() {
            $('#DataTable').DataTable();
        });
    </script>
@endsection
