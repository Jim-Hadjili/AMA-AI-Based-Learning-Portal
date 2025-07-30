// Simple search filter
document
  .getElementById("materialSearch")
  .addEventListener("input", function () {
    var filter = this.value.toLowerCase();
    document.querySelectorAll("#materialList li").forEach(function (li) {
      var text = li.textContent.toLowerCase();
      li.style.display = text.includes(filter) ? "" : "none";
    });
  });
