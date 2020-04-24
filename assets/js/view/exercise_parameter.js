export  function exerciseParameterElementCreate(parameterId, parameterValue, parameterTypeName, parameterTypeId) {

    parameterId = parameterId || "";
    parameterValue = parameterValue || "";
    parameterTypeName = parameterTypeName || "";
    parameterTypeId = parameterTypeId || null;

    let inputExerciseParameterValue = document.createElement("input");
    inputExerciseParameterValue.classList.add("exercise-parameter-value");
    inputExerciseParameterValue.setAttribute("value", parameterValue);

    let inputExerciseParameterType = document.createElement("input");
    inputExerciseParameterType.classList.add("exercise-parameter-type");
    inputExerciseParameterType.setAttribute("data-exercise-parameter-type-id", parameterTypeId);
    inputExerciseParameterType.setAttribute("value", parameterTypeName);

    let buttonExerciseParameterDelete = document.createElement("button");
    buttonExerciseParameterDelete.classList.add("exercise-parameter-delete-button");

    let iconDeleteButton = document.createElement("i");
    iconDeleteButton.classList.add("fa-trash-alt");
    iconDeleteButton.classList.add("far");

    let divExerciseParameterItem = document.createElement("div");
    divExerciseParameterItem.classList.add("exercise-parameter-item");
    divExerciseParameterItem.setAttribute("data-exercise-parameter-id", parameterId);

    buttonExerciseParameterDelete.appendChild(iconDeleteButton);
    divExerciseParameterItem.appendChild(inputExerciseParameterValue);
    divExerciseParameterItem.appendChild(inputExerciseParameterType);
    divExerciseParameterItem.appendChild(buttonExerciseParameterDelete);
    return divExerciseParameterItem;
}