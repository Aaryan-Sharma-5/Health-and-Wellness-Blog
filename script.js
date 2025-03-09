document.addEventListener("DOMContentLoaded", function () {
  document.querySelectorAll('nav a[href^="#"]').forEach(anchor => {
      anchor.addEventListener("click", function (e) {
          e.preventDefault();
          document.querySelector(this.getAttribute("href")).scrollIntoView({
              behavior: "smooth"
          });
      });
  });

  // Discussion Forum - Posting Comments
  const postBtn = document.getElementById("postBtn");
  const discussionText = document.getElementById("discussionText");
  const discussionPosts = document.getElementById("discussionPosts");

  postBtn.addEventListener("click", function () {
      let text = discussionText.value.trim();
      if (text === "") {
          alert("Please enter a message before posting.");
          return;
      }

      let postDiv = document.createElement("div");
      postDiv.classList.add("card", "mt-3", "p-3");
      postDiv.innerHTML = `<p>${text}</p>`;
      discussionPosts.prepend(postDiv);

      discussionText.value = "";
  });
});
