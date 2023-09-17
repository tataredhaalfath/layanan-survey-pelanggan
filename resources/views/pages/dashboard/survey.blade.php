@extends('layouts.dashboard')
@section('title', $title)
@push('style')
@endpush
@section('content')

    <div class="row mb-5">
        <div class="col-md-12" id="boxTable">
            <div class="card">
                <div class="card-header">
                    <div class="card-header-left">
                        <h5 class="text-uppercase title">Data Survey Pelanggan</h5>
                    </div>
                    <div class="card-header-right">
                        <button class="btn btn-mini btn-info mr-1" onclick="return refreshData();">Refresh</button>
                    </div>
                </div>
                <div class="card-block">
                    <div class="table-responsive mt-3">
                        <table class="table table-striped table-bordered nowrap dataTable" id="questionTable">
                            <thead>
                                <tr>
                                    <th class="all">#</th>
                                    <th class="all">Nama</th>
                                    <th class="all">Email</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="3" class="text-center"><small>Tidak Ada Data</small></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('script')
    <script src="{{ asset('js/plugin/datatables/datatables.min.js') }}"></script>
    <script>
        let dTable = null;

        $(function() {
            dataTable()
        })

        function dataTable() {
            const url = "/api/survey/dataTable"
            dTable = $('#questionTable').DataTable({
                searching: true,
                ordering: true,
                lengthChange: true,
                responsive: true,
                processing: true,
                serverSide: true,
                searchDelay: 1000,
                paging: true,
                lengthMenu: [5, 10, 25, 50],
                ajax: url,
                columns: [{
                    "width": "50px",
                    "data": "action"
                }, {
                    "width": "150px",
                    "data": "name"
                }, {
                    "width": "150px",
                    "data": "email"
                }],
                "pageLength": 10
            })
        }

        function refreshData() {
            dTable.ajax.reload(null, false)
        }

        function removeData(id) {
            $.ajax({
                url: `/api/survey/delete`,
                method: "DELETE",
                data: {
                    id: id,
                },
                beforeSend: function() {
                    return confirm("Yakin untuk menghapus data ?");
                    console.log("Sending Data")
                },
                success: function(msg) {
                  if(msg.status == 200){
                    dTable.ajax.reload(null, false)
                    showMessage("success", 'flaticon-alarm-1', 'Success !', msg.message)
                  } else {
                    showMessage('danger', 'flaticon-error', 'Error !', msg.message)
                  }
                },
                error: function(error) {
                    console.log("error : ", error )
                    showMessage('danger', 'flaticon-error', 'Error !', error)
                }
            })
        }
    </script>
@endpush
