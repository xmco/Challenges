document.getElementById("login-form").onsubmit = function(e) {
  e.preventDefault();
  e.stopImmediatePropagation();

  alert("This form is totally fake, the vulnerability is somewhere else :)");
};
