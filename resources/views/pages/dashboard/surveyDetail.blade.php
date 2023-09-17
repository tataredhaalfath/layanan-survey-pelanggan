@extends('layouts.dashboard')
@section('title', $title)
@push('style')
    <style>
        .survey-form-category {
            position: relative;
            /* border-bottom: 1px solid #ddd; */
            padding-bottom: 15px;
        }
    </style>
@endpush
@section('content')

    <div class="row mb-5">
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header text-center">
                    <h5 class="text-uppercase title">Detail Survey Pelanggan</h5>
                </div>
                <div class="card-block">
                    <div class="row">
                        <div class="col-md-8 mx-auto">
                            <div class="survey-form-body mt-3 ">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('script')
    <script src="{{ asset('js/plugin/datatables/datatables.min.js') }}"></script>
    <script>
        let getId = window.location.href;
        getId = getId.split('/')
        getId = getId.pop();
        $(function() {
            $.ajax({
                url: `/api/survey/detail/${getId}`,
                method: "GET",
                dataType: 'json',
                success: function(response) {
                    console.log("response :", response);
                    if (response.status == 200) {
                        renderSurveyList(response.data);
                    } else {
                        showMessage('warning', 'flaticon-error', 'Peringatan', error)
                    }
                },
                error: function(error) {
                    showMessage('warning', 'flaticon-error', 'Peringatan', error)
                    console.log("error :", error)
                }
            })
        })

        function renderSurveyList(questions) {
            const formBody = $(".survey-form-body");
            const payloadName = {
                id: questions.id,
                question: "Nama",
                placeholder: 'nama',
                answer: questions.name,
            }
            const payloadEmail = {
                id: questions.id,
                question: "Nama",
                placeholder: 'nama',
                answer: questions.email,
            }
            const name = generateInputText(payloadName);
            const email = generateInputText(payloadEmail);

            formBody.append(name, email);
            const surveyData = questions.survey_detail;

            surveyData.map((data) => {
                let elementInput;
                switch (data.type) {
                    case "text":
                        elementInput = generateInputText(data)
                        break;
                    case "number":
                        elementInput = genetareInputNumber(data)
                        break;
                    case "select":
                        elementInput = generateInputSelect(data)
                        break;
                    case "textarea":
                        elementInput = generateInputTextArea(data)
                        break
                    default:
                        elementInput = generateInputText(data)
                        break
                }

                formBody.append(elementInput);
            })
        }

        function generateInputText(data) {
            const surveyFormCategory = $('<div>', {
                class: 'survey-form-category'
            });

            const label = $("<label></label>").attr("for", data.id).text(data.question);

            const inputElement = $('<input>', {
                type: 'text',
                id: data.id,
                name: data.id,
                class: 'form-control mt-2',
                value: data.answer,
                disabled: true,
            });

            surveyFormCategory.append(label, inputElement);

            return surveyFormCategory;
        }

        function genetareInputNumber(data) {
            const surveyFormCategory = $('<div>', {
                class: 'survey-form-category'
            });

            const label = $("<label></label>").attr("for", data.id).text(data.question);

            const inputElement = $('<input>', {
                type: 'number',
                id: data.id,
                name: data.id,
                class: 'form-control mt-2',
                value: data.answer,
                disabled: true,
            });

            surveyFormCategory.append(label, inputElement);

            return surveyFormCategory;
        }

        function generateInputSelect(data) {
            const surveyFormCategory = $('<div>', {
                class: 'survey-form-category'
            });
            const label = $("<label></label>").attr("for", data.id).text(data.question);

            const selectElement = $('<select>', {
                id: data.id,
                name: data.id,
                class: 'form-control mt-2',
                disabled: true,
            });
            const optionElement = $('<option>', {
                value: data.answer,
                text: data.answer
            });
            selectElement.append(optionElement);

            return surveyFormCategory.append(label, selectElement);
        }

        function generateInputTextArea(data) {
            const surveyFormCategory = $('<div>', {
                class: 'survey-form-category'
            });

            const label = $("<label></label>").attr("for", data.id).text(data.question);

            const inputElement = $('<textarea>', {
                id: data.id,
                name: data.id,
                class: 'form-control mt-2',
                disabled: true,
                rows: 6,
                style: 'overflow: hidden; overflow-wrap: break-word; height: 158px;'
            });

            inputElement.val(data.answer);

            surveyFormCategory.append(label, inputElement);

            return surveyFormCategory;
        }
    </script>
@endpush
