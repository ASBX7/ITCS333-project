let fnameIcon = document.querySelector("#edit-fname");
let emailIcon = document.querySelector("#edit-email");
let numIcon = document.querySelector("#edit-num");
let lnameIcon = document.querySelector("#edit-lname");
let addressIcon = document.querySelector("#edit-address");

let fname = document.querySelector("#First_Name");
let email = document.querySelector("#Email");
let num = document.querySelector("#phone_number");
let lname = document.querySelector("#Last_Name");
let address = document.querySelector("#Address");

fnameIcon.addEventListener("click", edit1);
emailIcon.addEventListener("click", edit2);
numIcon.addEventListener("click", edit3);
lnameIcon.addEventListener("click", edit4);
addressIcon.addEventListener("click", edit5);


function edit1() {
  if (fname.classList.contains("disabled")) {
    console.log(fname);
    fname.classList.remove("disabled");
    fname.classList.add("enable");
    fnameIcon.classList.remove("fa-pen-to-square");
    fnameIcon.classList.add("fa-square-check");
  } else {
    fname.classList.add("disabled");
    fname.classList.remove("enable");
    fnameIcon.classList.add("fa-pen-to-square");
    fnameIcon.classList.remove("fa-square-check");
  }
}
function edit2() {
  if (email.classList.contains("disabled")) {
    console.log(email);
    email.classList.remove("disabled");
    email.classList.add("enable");
    emailIcon.classList.remove("fa-pen-to-square");
    emailIcon.classList.add("fa-square-check");
  } else {
    email.classList.add("disabled");
    email.classList.remove("enable");
    emailIcon.classList.add("fa-pen-to-square");
    emailIcon.classList.remove("fa-square-check");
  }
}
function edit3() {
  if (num.classList.contains("disabled")) {
    num.classList.remove("disabled");
    num.classList.add("enable");
    numIcon.classList.remove("fa-pen-to-square");
    numIcon.classList.add("fa-square-check");
  } else {
    num.classList.add("disabled");
    num.classList.remove("enable");
    numIcon.classList.add("fa-pen-to-square");
    numIcon.classList.remove("fa-square-check");
  }
}
function edit4() {
  if (lname.classList.contains("disabled")) {
    lname.classList.remove("disabled");
    lname.classList.add("enable");
    lnameIcon.classList.remove("fa-pen-to-square");
    lnameIcon.classList.add("fa-square-check");
  } else {
    lname.classList.add("disabled");
    lname.classList.remove("enable");
    lnameIcon.classList.add("fa-pen-to-square");
    lnameIcon.classList.remove("fa-square-check");
  }
}
function edit5() {
  if (address.classList.contains("disabled")) {
    address.classList.remove("disabled");
    address.classList.add("enable");
    addressIcon.classList.remove("fa-pen-to-square");
    addressIcon.classList.add("fa-square-check");
  } else {
    address.classList.add("disabled");
    address.classList.remove("enable");
    addressIcon.classList.add("fa-pen-to-square");
    addressIcon.classList.remove("fa-square-check");
  }
}

