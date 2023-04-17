let username = "";
let isLoggedIn = false;

const send_message = (conv, message) => {
  if (conv.length > 4) {
    conv = conv + "<br>";
  }
  if (!message) {
    message = "Hello, How can I help You";
  }
  $("#converse").html(
    conv +
      "<span class='current-msg'><span id='chat-bot'>Bot: </span>" +
      message +
      "</span><br>"
  );
  $("#converse").scrollTop($("#converse").prop("scrollHeight"));

  $(".current-msg").hide().delay(500).fadeIn().removeClass("current-msg");
};

const show_login_form = (conv) => {
  const initialLoginForm =
    "<div class='current-msg alert alert-info'>" +
    "<span id='chat-bot'>Bot: </span>" +
    "Please login to continue" +
    "</div>" +
    "<div class='text-center'>" +
    "<button id='login-btn' class='btn btn-primary mr-3'>Login</button>" +
    "<button id='continue-btn' class='btn btn-secondary'>Continue as Guest</button>" +
    "</div>";

  $("#converse").html(initialLoginForm);
  $("#converse").scrollTop($("#converse").prop("scrollHeight"));

  $("#login-btn").click(() => {
    const loginForm =
      "<form id='login-form'>" +
      "<div class='form-group'>" +
      "<label for='c_username'>Username:</label>" +
      "<input type='text' class='form-control' id='c_username' name='c_username'>" +
      "</div>" +
      "<div class='form-group'>" +
      "<label for='c_password'>Password:</label>" +
      "<input type='password' class='form-control' id='c_password' name='c_password'>" +
      "</div>" +
      "<button type='submit' class='btn btn-primary'>Login</button>" +
      "<button type='button' id='cancel-btn' class='btn btn-danger ml-3'>Cancel</button>" +
      "</form>";

    $("#converse").html(loginForm);
    $("#converse").scrollTop($("#converse").prop("scrollHeight"));

    $("#cancel-btn").click(() => {
      show_login_form(conv);
    });

    $("#login-form").submit((event) => {
      event.preventDefault();

      const username = $("#c_username").val();
      const password = $("#c_password").val();

      if (username.trim() === "" || password.trim() === "") {
        send_message(
          conv,
          "<div class='alert alert-danger'>" +
            "<span id='chat-bot'>Bot: </span>" +
            "Please enter both username and password." +
            "</div>"
        );
        return;
      }

      $.post(
        "getresponse.php",
        { username: username, password: password },
        (data) => {
          if (data === "success") {
            // Successfully logged in
            send_message(
              "<div class='alert alert-success'>" +
                "<span id='chat-bot'>Bot: </span>" +
                "Welcome, " +
                username +
                "! What can I do for you?" +
                "</div>"
            );
            
            const LogoutButton =
              "<button id='logout-btn' class='btn btn-danger' style='position: absolute; top: 15px; right: 60px;'>LogOut</button>";
            $("#converse").append(LogoutButton);
            $("#logout-btn").click(() => {
              show_login_form(conv);
              isLoggedIn=0;
            });
            isLoggedIn=1;
          } else {
            // Login failed
            send_message(
              "<div class='alert alert-danger'>" +
                "<span id='chat-bot'>Bot: </span>" +
                "Login failed. Please try again." +
                "</div>"
            );
          }
        }
      );
    });
  });

  $("#continue-btn").click(() => {
    // Guest mode
    send_message(
      "<div class='alert alert-warning'>" +
        "<span id='chat-bot'>Bot: </span>" +
        "Welcome, Guest! Some features are restricted for registered users." +
        "</div>"
    );
    const backButton =
      "<button id='back-btn' class='btn btn-danger' style='position: absolute; top: 15px; right: 60px;'>Back</button>";
    $("#converse").append(backButton);
    $("#back-btn").click(() => {
      show_login_form(conv);
    });
  });
};

const get_username = (conv) => {
  if (isLoggedIn) {
    send_message(conv, "Hi, " + username + ". What can I do for you?");
  } else {
    show_login_form(conv);
  }
};

const ai = (conv, message) => {
  message = message.toLowerCase();
  message = message.trim();

  // Handle user input
  
  if (isLoggedIn) {
    if (message.includes("hello") || message.includes("hi")) {
      send_message(conv, "Hello! How can I help you today?");
    } else if (message.includes("help")) {
      send_message(conv, "Sure, what do you need help with?");
    } else{
      $.get("getresponse.php", { q: message }, (data, status) => {
        setTimeout(() => {
          send_message(conv, data);
        }, 3000);
      });
      send_message(
        conv,
        "typing..."
      );
    } 
    }
    else {
      send_message(
        conv,
        "You are not allowed to do that because you are in guest mode! Please log in."
      );
    } 
    
};

$(function () {
  let open = false;
  let conv = $("#converse").html();
  get_username(conv);

  $("#send").click(function () {
    const usermsg = $("#textbox").val();
    conv = $("#converse").html();
    console.log(conv.length);
    if (usermsg !== "") {
      $("#textbox").val("");
      if (conv.length > 4) {
        conv = conv + "<br>";
      }
      $("#converse").html(
        conv + "<span id='chat-user'>You: </span>" + usermsg + "<br>"
      );
      $("#converse").scrollTop($("#converse").prop("scrollHeight"));
      conv = $("#converse").html();
      ai(conv, usermsg);
    }
  });

  $("#chat-button").click(function () {
    $("#chat-box").animate({
      right: "30px",
    });
  });

  $("#cancel").click(function () {
    $("#chat-box").animate({ right: "-300px" });
  });
});

$(document).ready(function () {
  $("#chat-button").click(function () {
    $("#chat-box").toggleClass("show");
  });

  $("#cancel").click(function () {
    $("#chat-box").removeClass("show");
  });
});

const controlsElements = document.querySelector(".controls-elements");
const sendButton = document.querySelector("#send");

controlsElements.addEventListener("keydown", (event) => {
  if (event.keyCode === 13 && event.ctrlKey) {
    event.preventDefault();
    sendButton.click();
  }
});
