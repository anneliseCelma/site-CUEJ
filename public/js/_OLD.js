

/*
    Deroulement de la side et effet induit
*/

let sidebar = document.querySelector(".sidebar");
let sidebarButton = document.querySelector("#sidebarButton");
let navMenu = document.querySelector(".header__nav");

// console.log(sidebarButton.alt)

function sidebarButtonChange() {
    if (sidebarButton.alt === "Menu") {
        sidebarButton.src = "./public/svg/close.svg";
        sidebarButton.style.marginRight = "330px";
        sidebarButton.alt ="Close";
        navMenu.style.display = "none";
       }
    else {
        sidebarButton.src = "./public/svg/menu.svg";
        sidebarButton.style.marginRight = "0";
        sidebarButton.alt = "Menu";
        navMenu.style.display = "flex";
    }
}

sidebarButton.addEventListener("click", ()=>{
    sidebar.classList.toggle("sidebar--show")
    sidebarButtonChange();
});

/*
    Deroulement des sub liste de la sidebar
*/
let sidebarSubList = document.querySelectorAll('.sidebar__nav__item');


sidebarSubList.forEach(function(elem) {
    elem.addEventListener("click", ()=>{
        elem.classList.toggle("sidebar__nav__item--show")
        elem.classList.toggle("sidebar__nav__item__title--active")
    });
});

/*
    Section sojourner : effet sur les card
*/

const sojournerCard = document.querySelectorAll('#cardSojourner');

sojournerCard.forEach(function(elem) {
    elem.addEventListener("click", ()=>{
        elem.classList.toggle("sojourner__card-container__item--active")
    });
});

const subString = document.querySelectorAll("#subString");
subString.forEach(function(elem) {
    if (elem.textContent.replace(/[\n\r]+|[\s]{2,}/g, ' ').length > 21) {
        elem.textContent = elem.textContent.replace(/[\n\r]+|[\s]{2,}/g, ' ').slice(0,20) + "...";
    }
});

const cutText = document.querySelectorAll("#cutText");
cutText.forEach(function(elem) {
    if ((elem.textContent.replace(/[\n\r]+|[\s]{2,}/g, ' ').length > 51) && (elem.classList.contains("container-elements__item__represent--h1"))) {
    elem.textContent = elem.textContent.replace(/[\n\r]+|[\s]{2,}/g, ' ').slice(0,40) + "...";
    }
    else if ((elem.textContent.replace(/[\n\r]+|[\s]{2,}/g, ' ').length > 81)) {
        elem.textContent = elem.textContent.replace(/[\n\r]+|[\s]{2,}/g, ' ').slice(0,80) + "...";
    }
});

/*
    Formulaire dynamique
*/
const dynamicElement = document.querySelector("#dynamicElement");
const selectBalise = document.querySelector("#balise-select");
const selectArticle = document.querySelector("#article-select");
const textInput = document.querySelector('input[name=text]');
const toAnalyseInputs = document.querySelectorAll("#toAnalyseInput");

//On ajoute la classe de l'option par défaut
dynamicElement.classList.add('container-dynamic-element__item--' + selectBalise.value);


//On fait comme dans la boucle mais pour mettre les valeurs par défaut
for (let i = 0; i < toAnalyseInputs.length; i++) {
    let inputElem = document.querySelector('input[name=' + toAnalyseInputs[i].name + ']');
    if (dynamicForm[selectBalise.value][toAnalyseInputs[i].name] === true) {
        inputElem.style.cssText = 'display : block;';
    }
    else {
        inputElem.style.cssText = 'display : none;';
    }
}
selectBalise.addEventListener("change", ()=>{
    dynamicElement.classList.remove(...dynamicElement.classList);
    dynamicElement.classList.add('container-dynamic-element__item');
    dynamicElement.classList.add('container-dynamic-element__item--' + selectBalise.value);

    // On affiche que les input souhaité
    for (let i = 0; i < toAnalyseInputs.length; i++) {
        let inputElem = document.querySelector('input[name=' + toAnalyseInputs[i].name + ']');
        // console.log(dynamicForm[selectBalise.value][toAnalyseInputs[i].name]);

        if (dynamicForm[selectBalise.value][toAnalyseInputs[i].name] === true) {
            inputElem.style.cssText = 'display : block;';
        }
        else {
            inputElem.value = "";
            inputElem.style.cssText = 'display : none;';
        }
    }

    // dynamicElement[selectBalise.value].forEach(function(elem) {
    //     console.log(elem);
    // });
});

dynamicElement.textContent = textInput.value;

    // On cache le contenu si l utilisateur n'a pas rentré de texte
    if (textInput.value.length === 0) {
        dynamicElement.style.cssText = "visibility: hidden";
    }
    else {
        dynamicElement.style.cssText = "visibility: visible";
    }
textInput.addEventListener("input", ()=>{
    dynamicElement.textContent = textInput.value;

    // On cache le contenu si l utilisateur n'a pas rentré de texte
    if (textInput.value.length === 0) {
        dynamicElement.style.cssText = "visibility: hidden";
    }
    else {
        dynamicElement.style.cssText = "visibility: visible";
    }
    // console.log(textInput.value.length);
});
    