function generateClassCode() {
  // Generate a random 6-character alphanumeric code
  const characters = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
  let code = "";

  // First character should be a letter
  code += characters.substring(0, 26).charAt(Math.floor(Math.random() * 26));

  // Add 5 more random alphanumeric characters
  for (let i = 0; i < 5; i++) {
    code += characters.charAt(Math.floor(Math.random() * characters.length));
  }

  document.getElementById("class_code").value = code;
}
