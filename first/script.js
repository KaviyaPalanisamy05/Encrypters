document.getElementById('signup-form').addEventListener('submit', async function (event) {
    event.preventDefault();
    const email = document.getElementById('email').value;
    const username = document.getElementById('username').value;
  
    const challenge = "ABCDEFG12345678"; // Optional: replace with real challenge from backend
  
    const publicKey = {
      challenge: new Uint8Array(challenge.length).map((_, i) => challenge.charCodeAt(i)),
      rp: { name: "My App" },
      user: {
        id: new TextEncoder().encode(username),
        name: username,
        displayName: username
      },
      pubKeyCredParams: [{ type: "public-key", alg: -7 }],
      authenticatorSelection: {
        authenticatorAttachment: "platform",
        userVerification: "required"
      },
      timeout: 60000,
      attestation: "direct"
    };
  
    try {
      const credential = await navigator.credentials.create({ publicKey });
  
      const response = await fetch('register.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
          email,
          username,
          id: credential.id,
          rawId: btoa(String.fromCharCode(...new Uint8Array(credential.rawId))),
          attestationObject: btoa(String.fromCharCode(...new Uint8Array(credential.response.attestationObject))),
          clientDataJSON: btoa(String.fromCharCode(...new Uint8Array(credential.response.clientDataJSON)))
        })
      });
  
      const result = await response.json();
      if (result.success) {
        alert("Registered! JWT: " + result.jwt);
        localStorage.setItem('jwt', result.jwt);
      } else {
        alert("Registration failed.");
      }
    } catch (err) {
      console.error("WebAuthn error:", err);
      alert("WebAuthn error: " + err.message);
    }
  });
  