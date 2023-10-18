$(function () {
    // renderInputList(dataQuestions)
    getQuestions();
});

function getQuestions() {
    const url = "/api/question/list";
    $.ajax({
        url: url,
        method: "GET",
        dataType: "json",
        success: function (response) {
            if (response.status == 200) {
                renderInputList(response.data);
            }
        },
        error: function (error) {
            console.log("error : ", error);
        },
    });
}

// const dataQuestions = [{
//         type: "text",
//         question: "Siapa Namu ?",
//         placeholder: "nama",
//         isRequired: true,
//         id: "251231231"
//     },
//     {
//         type: "number",
//         question: "Berapa Usiamu ?",
//         placeholder: "usia",
//         isRequired: true,
//         id: "251231512"
//     },
//     {
//         type: "select",
//         question: "Hobi",
//         prompt_data: "['main bola', 'basket', 'berenang']",
//         placeholder: "hobi",
//         isRequired: true,
//         id: "276122331"
//     },
//     {
//         type: "textarea",
//         question: "Biodata",
//         placeholder: "biodata",
//         isRequired: false,
//         id: "151129231"
//     }
// ]

function renderInputList(questions) {
    const formBody = $(".survey-form-body");
    questions.map((data) => {
        let elementInput;
        switch (data.type) {
            case "text":
                elementInput = generateInputText(data);
                break;
            case "number":
                elementInput = genetareInputNumber(data);
                break;
            case "select":
                elementInput = generateInputSelect(data);
                break;
            case "textarea":
                elementInput = generateInputTextArea(data);
                break;
            default:
                elementInput = generateInputText(data);
                break;
        }

        formBody.append(elementInput);
    });
}

function generateInputText(data) {
    const surveyFormCategory = $("<div>", {
        class: "survey-form-category",
    });

    const label = $("<label></label>").attr("for", data.id).text(data.question);

    const inputElement = $("<input>", {
        type: "text",
        id: data.id,
        name: data.id,
        class: "form-control mt-2",
        placeholder: data.placeholder,
        required: data.isRequired == 1,
    });

    surveyFormCategory.append(label, inputElement);

    return surveyFormCategory;
}

function genetareInputNumber(data) {
    const surveyFormCategory = $("<div>", {
        class: "survey-form-category",
    });

    const label = $("<label></label>").attr("for", data.id).text(data.question);

    const inputElement = $("<input>", {
        type: "number",
        id: data.id,
        name: data.id,
        class: "form-control mt-2",
        placeholder: data.placeholder,
        required: data.isRequired == 1,
    });

    surveyFormCategory.append(label, inputElement);

    return surveyFormCategory;
}

function generateInputSelect(data) {
    const surveyFormCategory = $("<div>", {
        class: "survey-form-category",
    });
    const label = $("<label></label>").attr("for", data.id).text(data.question);

    const dataOptions = data.prompt_data ? eval(data.prompt_data) : [];
    dataOptions.unshift(data.placeholder);

    const selectElement = $("<select>", {
        id: data.id,
        name: data.id,
        class: "form-control mt-2",
        placeholder: data.placeholder,
        required: data.isRequired == 1,
    });

    $.each(dataOptions, function (index, value) {
        const optionElement = $("<option>", {
            value: index == 0 ? "" : value,
            text: value,
        });

        selectElement.append(optionElement);
    });

    return surveyFormCategory.append(label, selectElement);
}

function generateInputTextArea(data) {
    const surveyFormCategory = $("<div>", {
        class: "survey-form-category",
    });

    const label = $("<label></label>").attr("for", data.id).text(data.question);

    const inputElement = $("<textarea>", {
        id: data.id,
        name: data.id,
        class: "form-control mt-2",
        placeholder: data.placeholder,
        required: data.isRequired == 1,
        rows: 6,
        style: "overflow: hidden; overflow-wrap: break-word; height: 158px;",
    });

    surveyFormCategory.append(label, inputElement);

    return surveyFormCategory;
}

$(document).ready(function () {
    $("#formSurvey").submit(function (e) {
        e.preventDefault();
        let data = new FormData($("#formSurvey")[0]);
        // data.forEach(function (value, key) {
        //     console.log(key + ": " + value);
        // });

        $.ajax({
            url: "/api/survey/create",
            type: "POST",
            contentType: false,
            processData: false,
            cache: false,
            data: data,
            beforeSend: function () {
                console.log("Sending data... !");
            },
            success: function (msg) {
                if (msg.status == 200) {
                    showMessage(
                        "success",
                        "flaticon-alarm-1",
                        "Sukses",
                        msg.message
                    );
                    $("#reset-survey").click();
                } else {
                    showMessage(
                        "warning",
                        "flaticon-error",
                        "Peringatan",
                        msg.message
                    );
                }
            },
            error: function (error) {
                showMessage("warning", "flaticon-error", "Peringatan", error.message);
                console.log("error : ", error);
            },
        });
    });
});
