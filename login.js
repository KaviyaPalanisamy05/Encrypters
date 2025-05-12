document.getElementById("loginForm").addEventListener("submit", async (e) => {
    e.preventDefault();

    const identifier = document.getElementById("identifier").value.trim();

    // Step 1: Send identifier to backend to get user data
    const res = await fetch('login.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ identifier })
    });

    const userData = await res.json();

    if (!userData || !userData.public_key || !userData.credential_id) {
        Swal.fire("Error", "User not found or no registered credentials.", "error");
        return;
    }

    // Step 2: Create challenge and prepare WebAuthn options
    const challenge = new Uint8Array(32);
    window.crypto.getRandomValues(challenge);

    const publicKeyCredentialRequestOptions = {
        challenge: challenge.buffer,
        allowCredentials: [{
            type: "public-key",
            id: base64ToArrayBuffer(userData.credential_id)
        }],
        timeout: 60000,
        userVerification: "required"
    };

    try {
        // Step 3: Request authenticator
        const credential = await navigator.credentials.get({
            publicKey: publicKeyCredentialRequestOptions
        });

        const clientDataJSON = credential.response.clientDataJSON;
        const authenticatorData = credential.response.authenticatorData;
        const signature = credential.response.signature;

        // Step 4: Send verification to backend
        const verificationData = {
            id: credential.id,
            identifier, // could be username or email
            response: {
                clientDataJSON: arrayBufferToBase64(clientDataJSON),
                authenticatorData: arrayBufferToBase64(authenticatorData),
                signature: arrayBufferToBase64(signature)
            }
        };

        const verificationRes = await fetch('verify-login.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(verificationData)
        });

        const result = await verificationRes.json();

        if (result.success) {
            Swal.fire("Success", "Login successful!", "success").then(() => {
                window.location.href = "index.php"; // or any page you want
            });
        } else {
            Swal.fire("Error", "Login failed. Invalid signature.", "error");
        }

    } catch (err) {
        console.error("Login error:", err);
        Swal.fire("Error", "Login process was cancelled or failed.", "error");
    }
});

// Converts base64url to ArrayBuffer
function base64ToArrayBuffer(base64) {
    base64 = base64.replace(/-/g, '+').replace(/_/g, '/');
    const pad = base64.length % 4;
    if (pad) base64 += '='.repeat(4 - pad);
    const binary = atob(base64);
    const len = binary.length;
    const bytes = new Uint8Array(len);
    for (let i = 0; i < len; i++) {
        bytes[i] = binary.charCodeAt(i);
    }
    return bytes.buffer;
}

// Converts ArrayBuffer to base64
function arrayBufferToBase64(buffer) {
    return btoa(String.fromCharCode(...new Uint8Array(buffer)));
}
