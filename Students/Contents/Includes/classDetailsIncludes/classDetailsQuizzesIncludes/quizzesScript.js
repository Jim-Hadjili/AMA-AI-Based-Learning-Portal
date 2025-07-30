// Simple search filter
document.getElementById("quizSearch").addEventListener("input", function () {
  var filter = this.value.toLowerCase();
  document.querySelectorAll("#quizList li").forEach(function (li) {
    var text = li.textContent.toLowerCase();
    li.style.display = text.includes(filter) ? "" : "none";
  });
});
