function invertColors(clicked = false) {
  let isReversed = localStorage.getItem("invertColors");

  if (isReversed === "true" || clicked) {
    var body = document.body;

    if (!window.counter) {
      window.counter = 1;
    }
    else {
      window.counter++;
    }

    if (window.counter % 2 === 0) {
      body.classList.remove("dark-mode");
    }
    else {
      body.classList.add("dark-mode");
    }
  }
}

$("#invert-colors").click(function () {
  localStorage.setItem("invertColors", localStorage.getItem("invertColors") === "false");
  invertColors(true);
});

invertColors();