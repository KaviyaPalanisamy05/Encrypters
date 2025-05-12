document.getElementById("sendOtpBtn").addEventListener("click", async () => {
    const email = document.getElementById("email").value.trim();
    //get the email from the signup
    // const username = document.getElementById("username").value.trim();

    if (!email) {
      alertify.error("Error", "Please enter your email.", "error");
      return;
    }
    //if the email feild is not entered
    const formData = new FormData();
    formData.append("full_name", "user"); // this name will appear in the body of the mail
    formData.append("email", email);
    formData.append("send_otp", "1");
    
    //the formdata will send as POST method to otp.php
    const res = await fetch("otp.php", {
      method: "POST",
      body: formData
    });
  
    const text = await res.text();
    if (text.includes("OTP sent")) {
  alertify.success("OTP sent to your email.");
  document.getElementById("emailSection").style.display = "none";
  document.getElementById("otpSection").style.display = "block";
} else {
  alertify.error(text);
}

  });
  
  document.getElementById("verifyOtpBtn").addEventListener("click", async () => {
    const otp = document.getElementById("otp").value.trim();
  
    const formData = new FormData();
    formData.append("otp", otp);
    formData.append("verify_otp", "1");
  
    const res = await fetch("otp.php", {
      method: "POST",
      body: formData
    });
  
    const text = await res.text();
    if (text.includes("✅")) {
      alertify.success("OTP Verified Successfully!");
      document.getElementById("otpSection").style.display = "none";
      document.getElementById("registerSection").style.display = "block";
  
      // Show verified email in disabled field
      const email = document.getElementById("email").value.trim();
      document.getElementById("verifiedEmail").value = email;
    } else {
      alertify.error("Invalid OTP");
    }
  });
  
  document.getElementById("signupForm").addEventListener("submit", async (e) => {
    e.preventDefault();
    //get the email username and number from the sign-up form
    const email = document.getElementById("verifiedEmail").value;
    const username = document.getElementById("username").value;
    const number = document.getElementById("number").value;
  
    //once the register button click - create public key (webAuthn)
    const publicKeyOptions = {
      //create a challenge - create a random 32 bit challenge
      challenge: Uint8Array.from(window.crypto.getRandomValues(new Uint8Array(32)), c => c).buffer,
      //relying party - name for your app
      rp: { name: "My Auth App" },
      //details stored in google password manager
      user: {
        id: Uint8Array.from(username, c => c.charCodeAt(0)), //private key
        name: email, //email
        displayName: username //username
      },
      pubKeyCredParams: [{ type: "public-key", alg: -7 }, { type: "public-key", alg: -257 }],
      //-7 = ES256 (ECDSA w/ SHA-256), -257 = RS256 (RSA w/ SHA-256)
      authenticatorSelection: { userVerification: "required" },
      //these ask for userverification [required, preferred, discouraged] like fingerprint, passkey
      timeout: 60000,
      //the form will close in 60s i.e, 1min
      attestation: "direct"
      //directly provide the user verification
    };
  
    try {
      //the user to register a credential (e.g., via fingerprint, PIN).
      const credential = await navigator.credentials.create({ publicKey: publicKeyOptions });
      const attestationObject = credential.response.attestationObject; //details about the key and user
      const clientDataJSON = credential.response.clientDataJSON; //details about the challenge and origin
      const rawId = credential.rawId; //convert the userID into binary
  
      //Packaging Data to Send to Server
      const data = {
        id: credential.id,
        rawId: arrayBufferToBase64(rawId),
        type: credential.type,
        response: {
          attestationObject: arrayBufferToBase64(attestationObject),
          clientDataJSON: arrayBufferToBase64(clientDataJSON)
        },
        email,
        username,
        number
      };
      //Prepares a JSON object to send to your backend
  
      //send this data to register.php in POST()
      const res = await fetch("register.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(data)
      });

      //get the response from register.php
      const result = await res.json();
      if (result.message === "User registered successfully") {
        Swal.fire("Success", result.message, "success").then(() => {
          window.location.href = "dashboard.php";
        });
      } else {
        Swal.fire("Error", result.message || "Unknown error", "error");
      }
  
    } catch (err) {
      console.error(err);
      Swal.fire("Error", "Registration Failed. Try again.", "error");
    }
  });
  
  function arrayBufferToBase64(buffer) {
    return btoa(String.fromCharCode(...new Uint8Array(buffer)));
  }
  //convert arraybuffer into base64
  