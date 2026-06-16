"use strict";

// ============================================
// GLOBAL TOAST NOTIFICATION HELPERS
// ============================================
const showGlobalToast = (message, type = "success") => {
  const container = document.getElementById("toast-container");
  if (!container) return;

  const icons = { success: "✅", error: "❌", info: "ℹ️" };
  const toast = document.createElement("div");
  toast.className = `toast toast-${type}`;
  toast.innerHTML = `<span class="toast-icon">${icons[type]}</span><span>${message}</span>`;
  
  container.appendChild(toast);
  
  // Slide out and remove toast after 3 seconds
  setTimeout(() => {
    toast.style.animation = "toastOut 0.4s ease forwards";
    setTimeout(() => toast.remove(), 400);
  }, 3000);
};

window.showGlobalToast = showGlobalToast;

// ============================================
// AJAX LIVE SEARCH auto-suggestions
// ============================================
const initLiveSearch = () => {
  const searchInput = document.getElementById("nav-search-input");
  const suggestionsBox = document.getElementById("nav-search-suggestions");
  const clearBtn = document.getElementById("nav-clear-search");

  if (!searchInput || !suggestionsBox) return;

  let debounceTimer;

  const formatRupiah = (angka) => {
    return new Intl.NumberFormat("id-ID", {
      style: "currency",
      currency: "IDR",
      minimumFractionDigits: 0,
      maximumFractionDigits: 0,
    }).format(angka).replace(',00', '');
  };

  const performSearch = (query) => {
    if (query.length < 2) {
      suggestionsBox.innerHTML = "";
      suggestionsBox.style.display = "none";
      if (clearBtn) clearBtn.style.display = "none";
      return;
    }

    if (clearBtn) clearBtn.style.display = "block";

    fetch(`/api/search-products?q=${encodeURIComponent(query)}`, {
      headers: {
        "X-Requested-With": "XMLHttpRequest",
      },
    })
      .then((res) => res.json())
      .then((data) => {
        if (data.length === 0) {
          suggestionsBox.innerHTML = `<div class="suggestion-item text-center text-muted" style="padding: 12px; font-size: 0.8rem;">
            Tidak ada kecocokan hardware
          </div>`;
        } else {
          suggestionsBox.innerHTML = data
            .map((item) => {
              return `
              <a href="/products/${item.id}" class="suggestion-item">
                <div class="item-info">
                  <span class="item-name">${item.name}</span>
                  <span class="item-meta">${item.sku} &bull; ${item.category}</span>
                </div>
                <span class="item-price">${formatRupiah(item.price)}</span>
              </a>
            `;
            })
            .join("");
        }
        suggestionsBox.style.display = "flex";
      })
      .catch((err) => console.error("Search error:", err));
  };

  searchInput.addEventListener("input", function () {
    clearTimeout(debounceTimer);
    const query = this.value.trim();
    debounceTimer = setTimeout(() => performSearch(query), 300);
  });

  if (clearBtn) {
    clearBtn.addEventListener("click", () => {
      searchInput.value = "";
      suggestionsBox.innerHTML = "";
      suggestionsBox.style.display = "none";
      clearBtn.style.display = "none";
      searchInput.focus();
    });
  }

  // Close suggestions if clicking outside
  document.addEventListener("click", (e) => {
    if (e.target !== searchInput && e.target !== suggestionsBox && !suggestionsBox.contains(e.target)) {
      suggestionsBox.style.display = "none";
    }
  });

  searchInput.addEventListener("focus", function () {
    if (this.value.trim().length >= 2) {
      suggestionsBox.style.display = "flex";
    }
  });
};

// ============================================
// AJAX ADD TO CART (Catalog card interactions)
// ============================================
const initAddToCartAjax = () => {
  document.addEventListener("click", (e) => {
    const btn = e.target.closest(".btn-add-to-cart-ajax");
    if (!btn) return;

    e.preventDefault();

    const productId = btn.dataset.productId;
    const originalContent = btn.innerHTML;

    btn.innerHTML = "⏳";
    btn.disabled = true;

    // Retrieve CSRF token from metadata
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute("content");

    fetch("/cart", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        "Accept": "application/json",
        "X-CSRF-TOKEN": csrfToken,
        "X-Requested-With": "XMLHttpRequest",
      },
      body: JSON.stringify({
        product_id: productId,
        quantity: 1,
      }),
    })
      .then((res) => {
        if (!res.ok) {
          if (res.status === 401) {
            // Redirect to login page if unauthorized
            window.location.href = "/login";
            throw new Error("Unauthorized");
          }
          return res.json().then((data) => {
            throw new Error(data.message || "Gagal menambahkan produk.");
          });
        }
        return res.json();
      })
      .then((data) => {
        if (data.success) {
          // Update cart count badge in header
          const badge = document.getElementById("nav-cart-count");
          if (badge) {
            badge.textContent = data.cart_count;
            badge.style.display = "inline-flex";
          }
          showGlobalToast(data.message, "success");
        }
      })
      .catch((err) => {
        if (err.message !== "Unauthorized") {
          showGlobalToast(err.message, "error");
        }
      })
      .finally(() => {
        btn.innerHTML = originalContent;
        btn.disabled = false;
      });
  });
};

// ============================================
// INITIATE LIBRARIES ON DOM LOAD
// ============================================
document.addEventListener("DOMContentLoaded", () => {
  initLiveSearch();
  initAddToCartAjax();
});
