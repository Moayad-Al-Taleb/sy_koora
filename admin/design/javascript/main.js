// navbar items change background 
let navbarItem = document.querySelectorAll(".list ul li a");
let href = location.href;

navbarItem.forEach((e) => {
  let attribute = e.getAttribute("href");
  if (href.includes(attribute)) {
    e.classList.add("active");
  }
});

// navbar items change background 

let sideIcon = document.querySelector(".list-icon");
let closeIcon = document.querySelector(".close-icon");
let navbar = document.querySelector(".sidebar");

closeIcon.onclick = () => {
  if (navbar.classList.contains("active")) {
    navbar.classList.remove("active");
  } else {
    navbar.classList.add("active");
  }
};
sideIcon.onclick = () => {
  if (navbar.classList.contains("active")) {
    navbar.classList.remove("active");
  } else {
    navbar.classList.add("active");
  }
};


let panelTitle = document.querySelectorAll(".panel-title");
let panelContent = document.querySelectorAll(".panel-content");

panelTitle.forEach((pan, index) => {
  pan.onclick = () => {
    panelContent.forEach((panel, index2) => {
      if (index == index2) {
        if (panel.classList.contains("active")) {
          panel.classList.remove("active");
        } else {
          panel.classList.add("active");
        }
      }
    });
  };
});
