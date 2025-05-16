/**
 * Signature Pad for Contracts
 */
document.addEventListener("DOMContentLoaded", function () {
    const signatureCanvas = document.getElementById("signature-pad");

    if (!signatureCanvas) return;

    const signaturePad = new SignaturePad(signatureCanvas, {
        backgroundColor: "rgba(255, 255, 255, 0)",
        penColor: "black",
        minWidth: 1,
        maxWidth: 2.5,
    });

    // Clear button
    document
        .getElementById("clear-signature")
        .addEventListener("click", function () {
            signaturePad.clear();
        });

    // Save signature when form is submitted
    document
        .getElementById("contract-sign-form")
        .addEventListener("submit", function (event) {
            if (signaturePad.isEmpty()) {
                event.preventDefault();
                alert("Vui lòng ký tên để xác nhận hợp đồng.");
                return;
            }

            const signatureData = signaturePad.toDataURL();
            document.getElementById("signature_data").value = signatureData;
        });

    // Resize canvas
    window.addEventListener("resize", resizeCanvas);

    function resizeCanvas() {
        const canvas = signaturePad.canvas;
        const ratio = Math.max(window.devicePixelRatio || 1, 1);
        canvas.width = canvas.offsetWidth * ratio;
        canvas.height = canvas.offsetHeight * ratio;
        canvas.getContext("2d").scale(ratio, ratio);
        signaturePad.clear();
    }

    resizeCanvas();
});
