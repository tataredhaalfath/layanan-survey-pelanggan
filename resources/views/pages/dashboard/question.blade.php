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
                        <h5 class="text-uppercase title">Manajemen Pertanyaan</h5><span>Masukkan data pertanyaan untuk
                            survey pelanggan</span>
                    </div>
                    <div class="card-header-right"><button class="btn btn-mini btn-info mr-1"
                            onclick="return refreshData();">Refresh</button><button class="btn btn-mini btn-primary"
                            onclick="return addData();">Tambah Pertanyaan</button></div>
                </div>
                <div class="card-block">
                    <div class="table-responsive mt-3">
                        <table class="table table-striped table-bordered nowrap dataTable" id="questionTable">
                            <thead>
                                <tr>
                                    <th class="all">#</th>
                                    <th class="all">Pertanyaan</th>
                                    <th class="all">Placeholder</th>
                                    <th class="all">Tipe</th>
                                    <th class="all">Prompt Data</th>
                                    <th class="all">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="6" class="text-center"><small>Tidak Ada Data</small></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-12" style="display: none" data-action="edit" id="formEditable">
            <div class="card">
                <div class="card-header">
                    <div class="card-header-left">
                        <h5>Tambah / Edit Petanyaan</h5>
                    </div>
                    <div class="card-header-right"><button class="btn btn-sm btn-warning" onclick="return closeForm(this)"
                            id="btnCloseForm"><i class="ion-android-close"></i></button></div>
                </div>
                <div class="card-block">
                    <form>
                        <input class="form-control" id="id" type="hidden" name="id" required />
                        <div class="form-group">
                            <label for="question">Pertanyaan</label>
                            <input class="form-control" id="question" type="text" name="question" required />
                        </div>
                        <div class="form-group">
                            <label for="placeholder">Placeholder</label>
                            <input class="form-control" id="placeholder" type="text" required name="placeholder" />
                        </div>
                        <div class="form-group">
                            <label for="type">Tipe Inputan</label><select class="form-control" id="type"
                                name="type" required>
                                <option value="text">Text</option>
                                <option value="number">Angka</option>
                                <option value="select">Select</option>
                                <option value="textarea">Text Area</option>
                            </select>
                        </div>
                        <div class="form-group" id="input_prompt" style="display: none">
                            <label for="prompt_data">Prompt Data</label>
                            <input class="form-control" id="prompt_data" type="text" name="prompt_data"
                                placeholder="pilihan1 | pilihan2 | pilihan3" />
                            <small>List opsi dari tipe "Select"
                                <br />
                            </small><small>contoh = pilihan1 | pilihan2 | pilihan3</small>
                            <br />
                            <small>Gunakan tanda ( | ) untuk memasukan lebih dari satu opsi </small>
                        </div>
                        <div class="form-group">
                            <label for="is_required">Status Pertanyaan</label><select class="form-control" id="is_required"
                                name="is_required" required>
                                <option value="1">Wajib Dijawab</option>
                                <option value="0">Opsional</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <button class="btn btn-sm btn-primary" type="submit">
                                <i class="ti-save"></i><span>Simpan</span>
                            </button>
                            <button class="btn btn-sm btn-default" id="reset" type="reset"
                                style="margin-left : 10px;"><span>Reset</span>
                            </button>
                        </div>
                    </form>
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
            const url = "/api/question/dataTable"
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
                    "data": "action"
                }, {
                    "data": "question"
                }, {
                    "data": "placeholder"
                }, {
                    "data": "type"
                }, {
                    "data": "prompt_data"
                }, {
                    "data": "isRequired",
                }],
                "pageLength": 10
            })
        }

        function refreshData() {
            dTable.ajax.reload(null, false)
        }

        function addData() {
            $("#formEditable").attr('data-action', 'add').fadeIn(200);
            $("#boxTable").removeClass("col-md-12").addClass("col-md-8");
            $("#question").focus();
        }

        function getData(id) {
            $.ajax({
                url: `/api/question/${id}/detail`,
                method: "GET",
                dataType: "json",
                success: function(response) {
                    if (response.status == 200) {
                        $("#formEditable").fadeIn(200, function() {
                            let d = response.data;
                            $(this).attr('data-action', 'update')
                            $("#boxTable").removeClass("col-md-12").addClass("col-md-8");
                            $("#id").val(d.id);
                            $("#question").focus().val(d.question);
                            $("#placeholder").val(d.placeholder);
                            $("#type").val(d.type);
                            if (d.type == "select") {
                                let prompt = JSON.parse(d.prompt_data);
                                $('#input_prompt').show()
                                $("#prompt_data").val(prompt.join(" | "))
                            } else {
                                $('#input_prompt').hide()
                                $("#prompt_data").val(d.prompt_data)
                            }
                            $("#is_required").val(d.isRequired);
                        })
                    } else {
                        showMessage('warning', 'flaticon-error', 'Peringatan', response.message)
                    }
                },
                error: function(error) {
                    showMessage('warning', 'flaticon-error', 'Peringatan', error);
                    console.log("error :", error)
                }
            })
        }

        function closeForm(element) {
            $("#formEditable").slideUp(200, function() {
                $("#boxTable").removeClass("col-md-8").addClass("col-md-12")
                $('#reset').click()
            })
        }

        $('#type').change(function() {
            if ($(this).val() == "select") {
                $('#input_prompt').show()
                $('#prompt_data').prop('required', true);
            } else {
                $('#input_prompt').hide()
                $('#prompt_data').prop('required', false);
            }
        })

        $("#formEditable form").submit(function(e) {
            e.preventDefault()
            let convertPrompt = $("#type").val() == "select" && $("#prompt_data").val() !== "" ? ($("#prompt_data")
                .val()) : null
            convertPrompt && (convertPrompt = convertPrompt.split("|").map(promp => promp.trim())
                .filter((prompt) =>
                    prompt !== ""))
            convertPrompt && convertPrompt.length && (convertPrompt = JSON.stringify(convertPrompt))

            let prompt_data = $("#type").val() == "select" ? convertPrompt : null;
            const dataToSend = {
                id: $("#id").val(),
                question: $("#question").val(),
                placeholder: $("#placeholder").val(),
                type: $("#type").val(),
                prompt_data,
                isRequired: $("#is_required").val(),
            }
            saveData(dataToSend, $('#formEditable').attr('data-action'))
            return false
        })

        function saveData(data, action) {
            $.ajax({
                url: action == "update" ? "/api/question/update" : "/api/question/create",
                method: 'POST',
                header: {
                    'Content-Type': 'application/json',
                },
                data: data,
                beforeSend: function() {
                    console.log("Loading...")
                },
                success: function(msg) {
                    if (msg.status == 200) {
                        closeForm();
                        dTable.ajax.reload(null, false);
                        showMessage('success', 'flaticon-alarm-1', 'Sukses', msg.message)
                    } else {
                        showMessage('warning', 'flaticon-error', 'Peringatan', msg.message)

                    }
                },
                error: function(error){
                    console.log("error :", error),
                    showMessage('danger', 'flaticon-error', 'Error !', error.message)
                }
            })
        }

        function removeData(id) {
            $.ajax({
                url: `/api/question/delete`,
                method: "DELETE",
                data: {
                    id: id,
                },
                beforeSend: function() {
                    return confirm("Yakin untuk menghapus data ?");
                    console.log("Sending Data")
                },
                success: function(msg) {
                    if (msg.status == 200) {
                        dTable.ajax.reload(null, false)
                        showMessage("success", 'flaticon-alarm-1', 'Success !', msg.message)
                    } else {
                        showMessage('danger', 'flaticon-error', 'Error !', msg.message)
                    }
                },
                error: function(error) {
                    console.log("error : ", error)
                    showMessage('danger', 'flaticon-error', 'Error !', error.message)
                }
            })
        }
    </script>
@endpush
