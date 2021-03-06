@extends('layouts.dashboard')

@section('content')

{{-- <div class="col-12 text-right">
    <a href="{{ url('admin/agreement/type') }}" class="btn btn-primary">Add New Type</a>
</div> --}}

<div class="col-12">
    <div class="section-block">
        <h3 class="section-title">Agreements</h3>
    </div>
    <div class="simple-card">
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link border-left-0 active show" id="" data-toggle="tab" href="#list" role="tab"
                    aria-controls="list" aria-selected="true">List</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="profile-tab-simple" data-toggle="tab" href="#add" role="tab"
                    aria-controls="profile" aria-selected="false">Add</a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane fade active show" id="list" role="tabpanel" aria-labelledby="list">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive ">
                            <table id="example" class="table table-striped table-bordered second" style="width:100%">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Aagreement</th>
                                        <th scope="col">Type</th>
                                        <th scope="col">Property</th>
                                        <th scope="col">Rent(M)</th>
                                        <th scope="col">Tent</th>
                                        <th scope="col">Status</th>
                                        {{-- <th scope="col">Sec. Money</th>
                                        <th scope="col">Paid</th> --}}
                                        {{-- <th scope="col">Yr Incr. %</th> --}}
                                        {{-- <th scope="col">Start Date</th> --}}
                                        {{-- <th scope="col">Month Paid</th> --}}
                                        {{-- <th scope="col">Attachment</th> --}}
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($agreements as $agreement)
                                    <tr>
                                        <td>{{ $agreement->id }}</td>
                                        <td>{{ $agreement->name }}</td>
                                        <td>{{ $agreement->property->type->name ?? 'Deleted' }}</td>
                                        <td>{{ $agreement->property->name ?? 'Deleted'}}</td>
                                        <td>{{ $agreement->property->rate ?? 'Deleted' }}</td>
                                        <td>{{ $agreement->tent ? $agreement->tent->fname.' '.$agreement->tent->lname:'Deleted' }}
                                        </td>
                                        <td>
                                            <form class="d-inline"
                                                action="{{route('agreement.update', $agreement->id)}}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                @if ($agreement->status)
                                                <input type="hidden" name="status" value="0">
                                                <button type="submit" class="btn btn-sm btn-success">Actived</button>
                                                @else
                                                <input type="hidden" name="status" value="1">
                                                <button type="submit" class="btn btn-sm btn-danger">Inactived</button>
                                                @endif
                                            </form>
                                        </td>
                                        {{-- <td>{{ $agreement->advance }}</td> --}}
                                        {{-- <td>{{ $agreement->payments->where('type','security')->sum('amount')}}</td>
                                        --}}
                                        {{-- <td>{{ $agreement->yearly_percent }}%</td> --}}
                                        {{-- <td>{{ $agreement->created_at->format('d/m/Y') }}</td> --}}
                                        {{-- <td>
                                            @foreach ($agreement->payments as $payment)
                                            {{ $payment->month }},
                                        @endforeach
                                        </td> --}}
                                        {{-- <td>
                                            <a href="{{ url('public/storage/'.$agreement->attachment) }}"
                                        class="badge badge-secondary p-1">Download</a><br>
                                        </td> --}}
                                        <td class="text-right">
                                            <a href="#" data-toggle="modal" data-target="#details"
                                                class="btn btn-sm btn-success"><i class="fas fa-eye"></i></a>
                                            {{-- <a href="{{ route('agreement.edit', $agreement->id)}}"
                                            class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                                            --}}

                                            <form class="d-inline"
                                                action="{{route('agreement.destroy', $agreement->id)}}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger"><i
                                                        class="fas fa-trash-alt"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>




            <div class="tab-pane fade" id="add" role="tabpanel" aria-labelledby="add">
                <div class="card-body">
                    <form action="{{ route('agreement.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">

                            {{-- <div class="form-group col-md">
                                <label class="col-form-label">Serial No. </label>
                                <input type="hidden" name="serial" value="{{ $id = App\Agreement::nextId() }}">
                            <input value="{{ $id }}" class="form-control" disabled>
                        </div> --}}

                        <div class="form-group col-md">
                            <label class="col-form-label">Agreement Name</label>
                            <input name="name" type="text" class="form-control" required>
                        </div>

                </div>

                <div class="row">
                    <div class="col-md form-group">
                        <label class="col-form-label">Property Type</label>
                        <select id="types" class="form-control">
                            <option>Select type</option>
                            @foreach ($types as $type)
                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md form-group">
                        <label class="col-form-label">Property</label>
                        <select id="properties" class="form-control" name="property_id" required>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md form-group">
                        <label class="col-form-label">Tent</label>
                        <select class="form-control" name="tent_id" required>
                            <option value="">Select Tent</option>
                            @foreach ($tents as $tent)
                            <option value="{{ $tent->id }}">{{ $tent->fname.' '.$tent->lname }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md form-group">
                        <label class="col-form-label">Attachment</label>
                        <input name="attachment" type="file" class="form-control" required>
                    </div>
                    <div class="col-md form-group">
                        <label class="col-form-label">Yearly Increment (%)</label>
                        <input name="yearly_percent" type="number" class="form-control" max="99" required>
                    </div>


                </div>

                <div class="row">
                    <div class="form-group col">
                        <label class="col-form-label">Security Money</label>
                        <input name="advance" type="number" class="form-control"
                            onkeyup="word.innerHTML=toWord(this.value)" autocomplete required>
                        <div class="border-bottom bg-light p-2">In Word: <span class="text-secondary" id="word"></span>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md form-group">
                        <label class="col-form-label">Start Date</label>
                        <input id="created_at" name="created_at" type="date" value="{{ date('Y-m-d') }}"
                            class="form-control">
                    </div>

                    <div class="col-md form-group">
                        <label class="col-form-label">Entry by</label>
                        <input value="{{ Auth::user()->name }}" class="form-control" disabled>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <h4>Conditions:</h4>
                    </div>
                    <div class="col-md">
                        <div class="custom-control custom-checkbox was-validated"
                            style="padding-left: 20px; margin-left: 20px;">
                            <input type="checkbox" class="custom-control-input is-invalid" id="customControlValidation2"
                                required>
                            <label class="custom-control-label" for="customControlValidation2">Any Modification
                                or damage (without notification) or paint Tent has to repair o fix to its revise
                                status it before leave the Property or deduced from him.</label>
                        </div>
                        <div class="custom-control custom-checkbox was-validated"
                            style="padding-left: 20px; margin-left: 20px;">
                            <input type="checkbox" class="custom-control-input is-invalid" id="customControlValidation3"
                                required>
                            <label class="custom-control-label" for="customControlValidation3">Tent has to pay
                                any utility bills against his period before leave the Property or deduced from
                                him.</label>
                        </div>
                        <div class="custom-control custom-checkbox was-validated"
                            style="padding-left: 20px; margin-left: 20px;">
                            <input type="checkbox" class="custom-control-input is-invalid" id="customControlValidation4"
                                required>
                            <label class="custom-control-label" for="customControlValidation4">Tent has to pay
                                any rent dues against his period before leave the Property or deduced from
                                him.</label>
                        </div>
                        <div class="custom-control custom-checkbox was-validated"
                            style="padding-left: 20px; margin-left: 20px;">
                            <input type="checkbox" class="custom-control-input is-invalid" id="customControlValidation5"
                                required>
                            <label class="custom-control-label" for="customControlValidation5">Tent agreed that
                                if any clause upper mentioned I allow the owner to redeem from Security
                                Deposit</label>
                        </div>
                    </div>
                </div>

                <div class="form-group text-right mt-4">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>

                </form>
            </div>
        </div>
    </div>
</div>
</div>



<div class="modal fade" id="details" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailsLabel">Detailed Information</h5>
                <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </a>
            </div>
            <div class="modal-body">
                Another information will show here
            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-secondary" data-dismiss="modal">Close</a>
                {{-- <a href="#" class="btn btn-primary">Save changes</a> --}}
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Get properties by type
    $('#types').on('change', function() {
        var type = $('#types').val();
        var url = '{{ url('api/properties') }}?type=' + type;
        $.ajax({
            type: "GET",
            url: url,
            dataType: 'json',
            success: function (data,status) {
                if (!data.length) {
                    toastr.info('No property found');
                }

                $('#properties').html('');

                data.forEach(element => {
                        $('#properties').append('<option value="'+element.id+'">'+element.name+'</option>')
                });
            }
        });
    });

</script>
@endsection
