let navbarItem = document.querySelectorAll("ul li a");
let href = location.href;
navbarItem.forEach((e) => {
    if(href.includes(e.getAttribute("href"))) {
        e.classList.add("active");
    } else {
    }
})


let controlBtns = document.querySelectorAll(".control-section a");
controlBtns.forEach((e) => {
    if(href.includes(e.getAttribute("href"))) {
        e.classList.add("controlBtnActive");
    } else {
    }
})
