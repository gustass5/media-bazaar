"use strict";
function enableFieldEdit(id) {
    var fieldWrapperElement = document.getElementById(id);
    if (fieldWrapperElement === null) {
        return;
    }
    fieldWrapperElement.querySelector("div").classList.add("hidden");
    fieldWrapperElement.querySelector("input").classList.remove("hidden");
}
