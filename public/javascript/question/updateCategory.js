let categoryElement = document.getElementById("answer_type");

let textElement0 = document.getElementById("answer_text");
textElement0.setAttribute("name", "answer[text][0]");

let languageDiv = document.getElementById("answer_language").parentElement;
let textDiv = document.getElementById("answer_text").parentElement;
let scaleDiv = document.getElementById("answer_scale").parentElement;
let minDiv = document.getElementById("answer_minimum").parentElement;
let maxDiv = document.getElementById("answer_maximum").parentElement;

let addIncrementor = 0;

let addButton = document.getElementById("add-nominals");
addButton.addEventListener('click', addAnswer);

let removeButton = document.getElementById("remove-nominals");
removeButton.addEventListener('click', removeField);

let category = categoryElement.options[categoryElement.value].text;
categoryElement.addEventListener('change', updatedCategory)

updateElementsShowing(category);

function updatedCategory() {
    category = categoryElement.options[categoryElement.value].text;

    updateElementsShowing(category);

}

function updateElementsShowing(category) {
    switch (category) {
        case 'Nominal':
            languageDiv.setAttribute('class', 'show');
            textDiv.setAttribute('class', 'show');
            scaleDiv.setAttribute('class', 'hide');
            minDiv.setAttribute('class', 'hide');
            maxDiv.setAttribute('class', 'hide');

            break;
        case 'Ordinal':
            languageDiv.setAttribute('class', 'hide');
            textDiv.setAttribute('class', 'hide');
            scaleDiv.setAttribute('class', 'show');
            minDiv.setAttribute('class', 'hide');
            maxDiv.setAttribute('class', 'hide');

            break;
        case 'Continuous':
            languageDiv.setAttribute('class', 'hide');
            textDiv.setAttribute('class', 'hide');
            scaleDiv.setAttribute('class', 'hide');
            minDiv.setAttribute('class', 'show');
            maxDiv.setAttribute('class', 'show');

            break;
        default:
            console.log("Unrecognised input.");
    }
}

function addAnswer(event) {
    addIncrementor++;
    event.preventDefault();
    let textElement = document.createElement('input');
    textElement.setAttribute('type', 'text');
    textElement.setAttribute('name', 'answer[text][' + addIncrementor + ']');
    textElement.setAttribute('id', 'answer_text_' + addIncrementor);
    textDiv.appendChild(textElement);
    removeButton.setAttribute('class', 'show');
}

function removeField(event) {
    event.preventDefault();
    let textElement = document.getElementById('answer_text_' + addIncrementor);
    textElement.parentNode.removeChild(textElement);


    addIncrementor--;
    if (addIncrementor === 0) {
        removeButton.setAttribute("class", "hide");
    }
}