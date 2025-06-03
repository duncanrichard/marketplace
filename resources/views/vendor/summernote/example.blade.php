@extends('layouts.app')

@section('styles')
    @include('vendor.summernote._init_links')
@endsection

@section('content')

    <!-- ========== title-wrapper start ========== -->
    <div class="title-wrapper pt-30">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="title mb-30">
                    <h2>Summernote Example Page</h2>
                </div>
            </div>
            <!-- end col -->
        </div>
        <!-- end row -->
    </div>
    <!-- ========== title-wrapper end ========== -->

    <form class="row" action="#" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="col-lg-12">
            <div class="card-style settings-card-2 mb-30">
                <div class="col-12">
                    <div class="input-style-1">
                        <label>Add <code>.summernote</code> class to your element</label>
                        <textarea class="summernote" required rows="10"></textarea>
                    </div>
                    <div class="col-12">
                        <div class="input-style-1">
                            <label>Another rich editor</label>
                            <textarea class="summernote" required rows="10"></textarea>
                        </div>
                    </div>
                </div>
            <!-- end card -->
        </div>
        <!-- end card -->
        <div class="col-12 my-3 d-flex justify-content-end">
            <button type="submit" class="main-btn primary-btn btn-hover">
                Submit
            </button>
        </div>
    </form>

@endsection

@section('scripts')
    @include('vendor.summernote._init_script')
@endsection
