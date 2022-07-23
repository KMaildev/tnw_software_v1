<!-- Button trigger modal -->
{{-- <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#phoneCall_{{ $id }}">
    <i class="fa fa-phone"></i>
    Call
</button> --}}

<a href="#" data-bs-toggle="modal" data-bs-target="#phoneCall_{{ $id }}">
    <i class="fa fa-phone"></i>
    Call
</a>

<a href="" class="btn btn-primary btn-xs">
    Call History
</a>

<form class="accept_reject_save" action="#" method="POST" id="create-form">
    @csrf
    <div>
        <div class="modal fade" id="phoneCall_{{ $id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalCenterTitle">
                            Accept / Reject
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="mb-3">
                                <input type="text" placeholder="Remark" name="remark" class="form-control"
                                    id="remark">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

@section('script')
    {!! JsValidator::formRequest('App\Http\Requests\StoreFollowUp', '#create-form') !!}
    <script>
        $('.accept_reject_save').submit(function(e) {
            e.preventDefault();
            let form = $(this);
            let data = form.serializeArray();

            var _token = data[0].value;
            var request_info_id = data[1].value;
            var accept_reject_status = data[2].value;
            var remark = data[3].value;

            console.log(data);


        });
    </script>
@endsection
