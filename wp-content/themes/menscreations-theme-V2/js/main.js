/**
 * MensCreations WordPress Theme JavaScript
 * @copyright menscreations 2026
 * @author Eran Nadeera <menswebdesign@gmail.com>
 */

"use strict";

// =============================================
// LIGHT & DARK MODE
// =============================================
const $themeBtn = document.querySelector("[data-theme-btn]");
const $HTML = document.documentElement;

const isDark = window.matchMedia("(prefers-color-scheme: dark)").matches;

// Always initialize sessionStorage on first load
if (sessionStorage.getItem("theme")) {
  $HTML.dataset.theme = sessionStorage.getItem("theme");
} else {
  const defaultTheme = isDark ? "dark" : "light";
  $HTML.dataset.theme = defaultTheme;
  sessionStorage.setItem("theme", defaultTheme); // ← Fix: save on first load
}

const changeTheme = () => {
  const current  = sessionStorage.getItem("theme");
  const newTheme = current === "light" ? "dark" : "light";
  $HTML.dataset.theme = newTheme;
  sessionStorage.setItem("theme", newTheme);
};

if ($themeBtn) {
  $themeBtn.addEventListener("click", changeTheme);
}

// =============================================
// TAB SWITCHING
// =============================================
const $tabBtns = document.querySelectorAll("[data-tab-btn]");

if ($tabBtns.length > 0) {
  let [lastActiveTab] = document.querySelectorAll("[data-tab-content]");
  let [lastActiveTabBtn] = $tabBtns;

  $tabBtns.forEach((btn) => {
    btn.addEventListener("click", function () {
      if (lastActiveTab) lastActiveTab.classList.remove("active");
      if (lastActiveTabBtn) {
        lastActiveTabBtn.classList.remove("active");
        lastActiveTabBtn.setAttribute("aria-selected", "false");
      }

      const $tabContent = document.querySelector(
        `[data-tab-content="${this.dataset.tabBtn}"]`
      );
      if ($tabContent) {
        $tabContent.classList.add("active");
        lastActiveTab = $tabContent;
      }

      this.classList.add("active");
      this.setAttribute("aria-selected", "true");
      lastActiveTabBtn = this;
    });
  });
}

// =============================================
// MOBILE MENU TOGGLE
// =============================================
const $mobileMenuBtn = document.getElementById("mobile-menu-btn");
const $navMenu = document.getElementById("nav-menu");

if ($mobileMenuBtn && $navMenu) {
  $mobileMenuBtn.addEventListener("click", function () {
    const isOpen = $navMenu.classList.toggle("open");
    this.setAttribute("aria-expanded", isOpen);
    const openIcon  = this.querySelector(".menu-open");
    const closeIcon = this.querySelector(".menu-close");
    if (openIcon)  openIcon.style.display  = isOpen ? "none"  : "block";
    if (closeIcon) closeIcon.style.display = isOpen ? "block" : "none";
  });

  // Close menu when a nav link is clicked
  $navMenu.querySelectorAll("a").forEach((link) => {
    link.addEventListener("click", () => {
      $navMenu.classList.remove("open");
      $mobileMenuBtn.setAttribute("aria-expanded", "false");
      const openIcon  = $mobileMenuBtn.querySelector(".menu-open");
      const closeIcon = $mobileMenuBtn.querySelector(".menu-close");
      if (openIcon)  openIcon.style.display  = "block";
      if (closeIcon) closeIcon.style.display = "none";
    });
  });
}

// =============================================
// PORTFOLIO CATEGORY FILTER
// =============================================
const $filterBtns    = document.querySelectorAll(".filter-btn");
const $portfolioCards = document.querySelectorAll(".portfolio-card");

if ($filterBtns.length > 0) {
  $filterBtns.forEach((btn) => {
    btn.addEventListener("click", function () {
      $filterBtns.forEach(b => b.classList.remove("active"));
      this.classList.add("active");

      const filter = this.dataset.filter;

      $portfolioCards.forEach((card) => {
        if (filter === "all") {
          card.classList.remove("hidden");
        } else {
          const cats = card.dataset.category || "";
          cats.includes(filter)
            ? card.classList.remove("hidden")
            : card.classList.add("hidden");
        }
      });
    });
  });
}

// =============================================
// AJAX CONTACT FORM
// =============================================
const $submitBtn = document.getElementById("contact-submit");
const $formMsg   = document.getElementById("form-message");

if ($submitBtn) {
  $submitBtn.addEventListener("click", async function () {
    const name    = document.getElementById("contact-name")?.value.trim();
    const email   = document.getElementById("contact-email")?.value.trim();
    const subject = document.getElementById("contact-subject")?.value.trim();
    const message = document.getElementById("contact-message")?.value.trim();

    if (!name || !email || !message) {
      showFormMessage("Please fill in all required fields.", "error");
      return;
    }
    if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
      showFormMessage("Please enter a valid email address.", "error");
      return;
    }

    $submitBtn.disabled = true;
    $submitBtn.querySelector(".label-large").textContent = "Sending...";

    if (typeof menscreations_ajax !== "undefined") {
      try {
        const formData = new FormData();
        formData.append("action",  "menscreations_contact");
        formData.append("nonce",   menscreations_ajax.nonce);
        formData.append("name",    name);
        formData.append("email",   email);
        formData.append("subject", subject);
        formData.append("message", message);

        const response = await fetch(menscreations_ajax.ajax_url, {
          method: "POST",
          body: formData,
        });

        const data = await response.json();

        if (data.success) {
          showFormMessage(data.data.message || "Message sent successfully!", "success");
          clearForm();
        } else {
          showFormMessage(data.data.message || "Failed to send. Please try again.", "error");
        }
      } catch (err) {
        showFormMessage("Network error. Please try again later.", "error");
        console.error("Contact form error:", err);
      }
    } else {
      // Fallback: mailto
      window.location.href = `mailto:?subject=${encodeURIComponent(subject)}&body=${encodeURIComponent(`Name: ${name}\nEmail: ${email}\n\n${message}`)}`;
    }

    $submitBtn.disabled = false;
    $submitBtn.querySelector(".label-large").textContent = "Send Message";
  });
}

function showFormMessage(msg, type) {
  if (!$formMsg) return;
  $formMsg.textContent = msg;
  $formMsg.style.display = "block";
  $formMsg.style.backgroundColor = type === "success"
    ? "hsl(142, 70%, 35%)"
    : "hsl(0, 70%, 40%)";
  $formMsg.style.color = "#fff";
  $formMsg.style.padding = "12px 16px";
  $formMsg.style.borderRadius = "8px";

  if (type === "success") {
    setTimeout(() => { $formMsg.style.display = "none"; }, 5000);
  }
}

function clearForm() {
  ["contact-name", "contact-email", "contact-subject", "contact-message"].forEach((id) => {
    const el = document.getElementById(id);
    if (el) el.value = "";
  });
}