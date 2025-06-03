<div class="pcoded-inner-content">
    <div class="main-body">
        <div class="row justify-content-center">
            <div class="col-12 center">
            @if($errors -> any())
                @foreach($errors->all() as $message)
                    <div class="d-flex justify-content-between my-3 alert alert-danger background-danger text-center p-4">
                        <p class="fw-bold me-3">{{ $message }}</p>
                        <button type="button" style="width: 5%" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endforeach
            @endif
            @if(session('msg'))
                <div class="d-flex justify-content-between my-3 alert alert-danger background-danger text-center p-4">
                    <p class="fw-bold me-3">{{ session()->get('msg') }}</p>
                    <button type="button" style="width: 5%" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if(session('success'))
                <div class="d-flex justify-content-between my-3 alert alert-success background-success text-center">
                    <p class="fw-bold me-3">{{ session()->get('success') }}</p>
                    <button type="button" style="width: 5%" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            </div>
        </div>
    </div>
</div>
