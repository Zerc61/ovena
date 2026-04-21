// === CURSOR GLOW ===
const glow = document.getElementById("cursorGlow");
document.addEventListener("mousemove", (e) => {
    glow.style.left = e.clientX + "px";
    glow.style.top = e.clientY + "px";
});

// === TABS ===
const tabs = document.querySelectorAll(".auth-tab");
const panels = document.querySelectorAll(".auth-panel");
const indicator = document.getElementById("tabIndicator");

tabs.forEach((tab) => {
    tab.addEventListener("click", () => {
        const target = tab.dataset.tab;

        tabs.forEach((t) => t.classList.remove("active"));
        tab.classList.add("active");

        if (target === "daftar") {
            indicator.classList.add("right");
        } else {
            indicator.classList.remove("right");
        }

        panels.forEach((p) => p.classList.remove("active"));
        document.getElementById("panel-" + target).classList.add("active");
    });
});

// === TOGGLE PASSWORD ===
function togglePw(inputId, btn) {
    const input = document.getElementById(inputId);
    const isPassword = input.type === "password";
    input.type = isPassword ? "text" : "password";

    if (isPassword) {
        btn.innerHTML = `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/>
            <line x1="1" y1="1" x2="23" y2="23"/>
        </svg>`;
    } else {
        btn.innerHTML = `<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
            <circle cx="12" cy="12" r="3"/>
        </svg>`;
    }
}

// === AUTO-SWITCH TAB SETELAH REGISTER GAGAL ===
// Kalau user submit daftar tapi gagal, otomatis buka tab daftar
document.addEventListener("DOMContentLoaded", () => {
    const params = new URLSearchParams(window.location.search);
    if (
        params.get("tab") === "daftar" ||
        document.querySelector("#panel-daftar .error-msg.show")
    ) {
        tabs[1].click();
    }
});

// === TOAST (hanya untuk flash message) ===
document.querySelectorAll(".toast-container .toast").forEach((el) => {
    setTimeout(() => {
        el.classList.add("out");
        setTimeout(() => el.remove(), 300);
    }, 3000);
});
